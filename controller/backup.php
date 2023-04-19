<?php
	/**
	* backup Controller, 
	* This Called after admin
	*/
	class backup extends controller
	{
		/**
		* The Default Method
		* No return (void)
		*/
		function __construct()
		{
			parent::__construct();
			$this->view->CSS = array();
			$this->view->JS = array('views/backup/JS/backup.js');
		}
		
		//Display backup window
		function index()
		{
			$this->view->backup_list	= $this->model->backup_list();
			$this->view->render(array('backup/index'));
		}
		
		//create new backup
		function new_backup()
		{
			echo $this->model->new_backup();
		}
		
		// get backup file to download
		function get_file($file_name="")
		{
			$dir 	= BACKUP_DIR.$file_name;
			if(!file_exists($dir) || is_dir($dir)) 
			{
				echo "File Not Found ".$file_name;
				return;
			}
			//header('Content-Description: File Transfer');
			header('Content-Type: '.mime_content_type($dir));
			header('Content-Length: ' . filesize($dir));
			//header('Content-Disposition: inline; filename="'.basename($dir).'"');
					
			//header('Content-Transfer-Encoding: binary');
			//header('Accept-Ranges: bytes');
			echo file_get_contents($dir);
				
		}
		
		//get backup
		function get_backup()
		{
			json_encode($this->model->get_backup());
		}
		
		//upload_backup backup
		function upload_backup()
		{
			echo json_encode($this->model->upload_backup());
		}
		
		//del backup
		function del_backup()
		{
			echo json_encode($this->model->del_backup());
		}
		
	}
?>