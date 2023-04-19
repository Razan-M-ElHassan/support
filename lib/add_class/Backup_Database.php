<?php
	/**
	* The Backup_Database class
	*/
	class Backup_Database
	{
		/**
		 * Database to backup
		 */
		var $dbName;

		/**
		 * Database charset
		 */
		var $charset;

		/**
		 * Database connection
		 */
		var $conn;

		/**
		 * Backup directory where backup files are stored 
		 */
		var $backupDir;

		/**
		 * Output backup file
		 */
		var $backupFile;

		/**
		 * Use gzip compression on backup file
		 */
		var $gzipBackupFile;

		/**
		 * Content of standard output
		 */
		var $output;

		/**
		 * Disable foreign key checks
		 */
		var $disableForeignKeyChecks;

		/**
		 * Batch size, number of rows to process per iteration
		 */
		var $batchSize;

		/**
		 * Constructor initializes database
		 */
		public function __construct($conn, $charset = 'utf8') {
			$this->dbName                  = DB_NAME;
			$this->charset                 = $charset;
			$this->conn                    = $conn;
			$this->backupDir               = BACKUP_DIR ? BACKUP_DIR : '.';
			$this->backupFile              = 'myphp-backup-'.$this->dbName.'-'.date("Ymd_His", time()).'.sql';
			$this->gzipBackupFile          = defined('GZIP_BACKUP_FILE') ? GZIP_BACKUP_FILE : true;
			$this->disableForeignKeyChecks = defined('DISABLE_FOREIGN_KEY_CHECKS') ? DISABLE_FOREIGN_KEY_CHECKS : true;
			$this->batchSize               = defined('BATCH_SIZE') ? BATCH_SIZE : 1000; // default 1000 rows
			$this->output                  = '';
		}
		
		/**
		* Backup the whole database or just some tables
		* Use '*' for whole database or 'table1 table2 table3...'
		* @param string $tables
		*/
		public function backupTables($tables = '*') 
		{
			try {
				/**
				* Tables to export
				*/
				
				if($tables == '*') 
				{
					$tables = array();
					$result = $this->conn->select('SHOW TABLES',array(),PDO::FETCH_NUM);
					$tables = [];
					
					foreach($result as $val)
					{
						$tables[] = $val[0];
					}
				} else {
					$tables = is_array($tables) ? $tables : explode(',', str_replace(' ', '', $tables));
				}
				
				if (empty($tables)) {
					return false;
				}
				
				$sql = 'CREATE DATABASE IF NOT EXISTS `'.$this->dbName.'`'.";\n\n";
				$sql .= 'USE `'.$this->dbName."`;\n\n";

				/**
				* Disable foreign key checks 
				*/
				if ($this->disableForeignKeyChecks === true) 
				{
					$sql .= "SET foreign_key_checks = 0;\n\n";
				}

				/**
				* Iterate tables
				*/
				foreach($tables as $table) 
				{
					if( in_array($table, IGNORE_TABLES) )
						continue;
					
					$this->obfPrint("Backing up `".$table."` table...".str_repeat('.', 50-strlen($table)), 0, 0);

					/**
					* CREATE TABLE
					*/
					$sql .= 'DROP TABLE IF EXISTS `'.$table.'`;';
					
					$data_create = $this->conn->select('SHOW CREATE TABLE ' . $table,array(),PDO::FETCH_NUM);
					$sql .= "\n\n".$data_create[0][1] . ';' . "\n\n";
				
					/**
					* INSERT INTO
					*/
					
					$row = $this->conn->select('SELECT COUNT(*) FROM `'.$table.'`',array(),PDO::FETCH_NUM);
					$numRows = $row[0][0];

					// Split table in batches in order to not exhaust system memory 
					$numBatches = intval($numRows / $this->batchSize) + 1; // Number of while-loop calls to perform

					for($b = 1; $b <= $numBatches; $b++) 
					{
						$query = 'SELECT * FROM `'.$table .'` LIMIT '.($b * $this->batchSize - $this->batchSize).','. $this->batchSize;
						$result = $this->conn->select($query,array(),PDO::FETCH_NUM);
					
						$realBatchSize = count($result); // Last batch size can be different from $this->batchSize
						$numFields = (!empty($result[0]))? count($result[0]):0;

						if($realBatchSize !== 0)
						{
							$sql .= 'INSERT INTO `'.$table.'` VALUES ';

							$rowCount = 1;
							foreach($result as $row)
							{
								$sql.='(';
								for($j=0; $j<$numFields; $j++) 
								{
									if (isset($row[$j])) 
									{
										$row[$j] = addslashes($row[$j]);
										$row[$j] = str_replace("\n","\\n",$row[$j]);
										$row[$j] = str_replace("\r","\\r",$row[$j]);
										$row[$j] = str_replace("\f","\\f",$row[$j]);
										$row[$j] = str_replace("\t","\\t",$row[$j]);
										$row[$j] = str_replace("\v","\\v",$row[$j]);
										$row[$j] = str_replace("\a","\\a",$row[$j]);
										$row[$j] = str_replace("\b","\\b",$row[$j]);
										if ($row[$j] == 'true' or $row[$j] == 'false' or preg_match('/^-?[0-9]+$/', $row[$j]) or $row[$j] == 'NULL' or $row[$j] == 'null') 
										{
											$sql .= $row[$j];
										} else {
											$sql .= '"'.$row[$j].'"' ;
										}
									} else {
										$sql.= 'NULL';
									}
    
									if ($j < ($numFields-1)) {
										$sql .= ',';
									}
								}
    
								if ($rowCount == $realBatchSize) 
								{
									$rowCount = 0;
									$sql.= ");\n"; //close the insert statement
								} else {
									$sql.= "),\n"; //close the row
								}
								$rowCount++;
							}
							
							$this->saveFile($sql);
							$sql = '';
						}
					}

					/**
					* CREATE TRIGGER
					*/

					// Check if there are some TRIGGERS associated to the table
					$query = "SHOW TRIGGERS LIKE '" . $table . "%'";
					$result = $this->conn->select($query,array(),PDO::FETCH_NUM);
				
					if (!empty($result)) 
					{
						$triggers = array();
						foreach ($result as $trigger) {
							$triggers[] = $trigger[0];
						}
						
						// Iterate through triggers of the table
						foreach ( $triggers as $trigger ) 
						{
							$query= 'SHOW CREATE TRIGGER `' . $trigger . '`';
							$result = $this->conn->select($query,array(),PDO::FETCH_NUM);
							$sql.= "\nDROP TRIGGER IF EXISTS `" . $trigger . "`;\n";
							$sql.= "DELIMITER $$\n" . $result[0][2] . "$$\n\nDELIMITER ;\n";
						}

						$sql.= "\n";

						$this->saveFile($sql);
						$sql = '';
					}
 
					$sql.="\n\n";
					$this->obfPrint('OK');
				}

				/**
				* Re-enable foreign key checks 
				*/
				if ($this->disableForeignKeyChecks === true) {
					$sql .= "SET foreign_key_checks = 1;\n";
				}

				$this->saveFile($sql);

				if ($this->gzipBackupFile) 
				{
					$this->gzipBackupFile();
				} else {
					$this->obfPrint('Backup file succesfully saved to ' . $this->backupDir.'/'.$this->backupFile, 1, 1);
				}
			} catch (Exception $e) {
				print_r($e->getMessage());
				return false;
			}
			return true;
		}

		/**
		* Save SQL to file
		* @param string $sql
		*/
		protected function saveFile(&$sql) 
		{
			if (!$sql) return false;
			
			try 
			{
				if (!file_exists($this->backupDir)) 
				{
					mkdir($this->backupDir, 0777, true);
				}
				file_put_contents($this->backupDir.'/'.$this->backupFile, $sql, FILE_APPEND | LOCK_EX);

			} catch (Exception $e) 
			{
				print_r($e->getMessage());
				return false;
			}
			return true;
		}

		/*
		* Gzip backup file
		*
		* @param integer $level GZIP compression level (default: 9)
		* @return string New filename (with .gz appended) if success, or false if operation fails
		*/
		protected function gzipBackupFile($level = 9) 
		{
			if (!$this->gzipBackupFile) {
				return true;
			}

			$source = $this->backupDir . '/' . $this->backupFile;
			$dest =  $source . '.gz';

			$this->obfPrint('Gzipping backup file to ' . $dest . '... ', 1, 0);

			$mode = 'wb' . $level;
			if ($fpOut = gzopen($dest, $mode)) 
			{
				if ($fpIn = fopen($source,'rb')) {
					while (!feof($fpIn)) {
						gzwrite($fpOut, fread($fpIn, 1024 * 256));
					}
					fclose($fpIn);
				} else {
					return false;
				}
				gzclose($fpOut);
				if(!unlink($source)) {
					return false;
				}
			} else {
				return false;
			}
        
			$this->obfPrint('OK');
			return $dest;
		}

		/**
		* Prints message forcing output buffer flush
		*
		*/
		public function obfPrint ($msg = '', $lineBreaksBefore = 0, $lineBreaksAfter = 1) 
		{
			if (!$msg) {
				return false;
			}

			if ($msg != 'OK' and $msg != 'KO') {
				$msg = date("Y-m-d H:i:s") . ' - ' . $msg;
			}
			$output = '';

			$lineBreak = "\n";
			
			if ($lineBreaksBefore > 0) 
			{
				for ($i = 1; $i <= $lineBreaksBefore; $i++) {
					$output .= $lineBreak;
				}                
			}
			$output .= $msg;

			if ($lineBreaksAfter > 0) {
				for ($i = 1; $i <= $lineBreaksAfter; $i++) {
					$output .= $lineBreak;
				}                
			}

			// Save output for later use
			$this->output .= str_replace('<br />', '\n', $output);

			echo $output;

			$this->output .= " ";
			flush();
		}

		/**
		* Returns full execution output
		*
		*/
		public function getOutput()
		{
			return $this->output;
		}
		
		/**
		* Returns name of backup file
		*
		*/
		public function getBackupFile() 
		{
			if ($this->gzipBackupFile) {
				return $this->backupDir.'/'.$this->backupFile.'.gz';
			} else
				return $this->backupDir.'/'.$this->backupFile;
		}

		/**
		* Returns backup directory path
		*
		*/
		public function getBackupDir() 
		{
			return $this->backupDir;
		}

		/**
		* Returns array of changed tables since duration
		*
		*/
		public function getChangedTables($since = '1 day') 
		{
			$query = "SELECT TABLE_NAME,update_time FROM information_schema.tables WHERE table_schema='" . $this->dbName . "'";
			$result = $this->conn->select($query,array(),PDO::FETCH_ASSOC);
			$resultset = array();
			
			foreach($result as $row)
			{
				$resultset[] = $row;
			}		
			if(empty($resultset))
				return false;
			
			$tables = [];
			for ($i=0; $i < count($resultset); $i++) 
			{
				if( in_array($resultset[$i]['TABLE_NAME'], IGNORE_TABLES) ) // ignore this table
					continue;
				if(strtotime('-' . $since) < strtotime($resultset[$i]['update_time']))
					$tables[] = $resultset[$i]['TABLE_NAME'];
			}
			return ($tables) ? $tables : false;
		}
	
	
	////////////////////////////////////////////////////////////////////////////////////////
		/**
		* Backup the whole database or just some tables
		* Use '*' for whole database or 'table1 table2 table3...'
		* @param string $tables
		*/
		public function restoreDb($file) 
		{
			try{
				$sql = '';
				$multiLineComment = false;

				$backupDir = $this->backupDir;
				$this->backupFile = $file;
				$backupFile = $this->backupFile;

				/**
				* Gunzip file if gzipped
				*/
				$backupFileIsGzipped = substr($backupFile, -3, 3) == '.gz' ? true : false;
				if ($backupFileIsGzipped) 
				{
					if (!$backupFile = $this->gunzipBackupFile()) 
					{
						throw new Exception("ERROR: couldn't gunzip backup file " . $backupDir . '/' . $backupFile);
					}
				}

				/**
				* Read backup file line by line
				*/
				$handle = fopen($backupDir . '/' . $backupFile, "r");
				if ($handle) 
				{
					while (($line = fgets($handle)) !== false) 
					{
						$line = ltrim(rtrim($line));
						if (strlen($line) > 1) 
						{ // avoid blank lines
							$lineIsComment = false;
							if (preg_match('/^\/\*/', $line)) 
							{
								$multiLineComment = true;
								$lineIsComment = true;
							}
							if ($multiLineComment or preg_match('/^\/\//', $line)) 
							{
								$lineIsComment = true;
							}
							if (!$lineIsComment) 
							{
								$sql .= $line;
								if (preg_match('/;$/', $line)) 
								{
									// execute query
									$this->conn->select($sql,array(),PDO::FETCH_ASSOC);
									//if($this->conn->select($sql,array(),PDO::FETCH_ASSOC)) 
									//{
										if (preg_match('/^CREATE TABLE `([^`]+)`/i', $sql, $tableName)) 
										{
											$this->obfPrint("Table succesfully created: `" . $tableName[1] . "`");
										}
										$sql = '';
									/*} else {
										//throw new Exception("ERROR: SQL execution error: " . $sql);
										echo("ERROR: SQL execution error: " . $sql);
									}*/
								}
							} else if (preg_match('/\*\/$/', $line)) {
								$multiLineComment = false;
							}
						}
					}
					fclose($handle);
				} else {
					throw new Exception("ERROR: couldn't open backup file " . $backupDir . '/' . $backupFile);
				} 
			} catch (Exception $e) {
				print_r($e->getMessage());
				return false;
			}

			if ($backupFileIsGzipped) 
			{
				unlink($backupDir . '/' . $backupFile);
			}
			
			if ($this->disableForeignKeyChecks === true) {
				$this->conn->select('SET foreign_key_checks = 1',array(),PDO::FETCH_ASSOC);
			}
			return true;
		}

		/*
		* Gunzip backup file
		*
		* @return string New filename (without .gz appended and without backup directory) if success, or false if operation fails
		*/
		protected function gunzipBackupFile() 
		{
			// Raising this value may increase performance
			$bufferSize = 4096; // read 4kb at a time
			$error = false;

			$source = $this->backupDir . '/' . $this->backupFile;
			$dest = $this->backupDir . '/' . date("Ymd_His", time()) . '_' . substr($this->backupFile, 0, -3);

			$this->obfPrint('Gunzipping backup file ' . $source . '... ', 1, 1);

			// Remove $dest file if exists
			if (file_exists($dest)) 
			{
				if (!unlink($dest)) {
					return false;
				}
			}
			
			// Open gzipped and destination files in binary mode
			if (!$srcFile = gzopen($this->backupDir . '/' . $this->backupFile, 'rb')) {
				return false;
			}
			if (!$dstFile = fopen($dest, 'wb')) {
				return false;
			}

			while (!gzeof($srcFile)) 
			{
				// Read buffer-size bytes
				// Both fwrite and gzread are binary-safe
				if(!fwrite($dstFile, gzread($srcFile, $bufferSize))) {
					return false;
				}
			}

			fclose($dstFile);
			gzclose($srcFile);

			// Return backup filename excluding backup directory
			return str_replace($this->backupDir . '/', '', $dest);
		}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	}

?>