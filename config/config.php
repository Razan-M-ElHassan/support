<?php
	//General Vars:
	define('PAGING',5);
	define('TITLE','support');
	define('IMG','icon.png');
	define('DESCRIPTION','');
	define('KEYWORDS','');
	define('EMAIL_ADD','');
	define('PHONE_NUM','0123456789');
	
	define('AVAILABLIE_WAR',50);
	
	//Paths
	define("URL","//".$_SERVER['HTTP_HOST']."/support/");
	define("URL_PATH",$_SERVER['DOCUMENT_ROOT']."support/");
	define('LIB','lib/');
	
	//Constants Dont Change This Hash !
	define('HASH_FUN','sha256');
	define('HASH_KEY','haftar');
	define('HASH_PASSWORD_KEY','haftar@JAK');
	define('TOKEN','MY_TOKEN_#12360_MAK');
	define('MAC_ADDRESS','');
	
	//Database
	define('DB_TYPE','mysql');
	define('DB_HOST','localhost');
	define('DB_USER','root');
	define('DB_PASS','root');
	define('DB_NAME','support');
	define('DB_charset','utf8');
	define('DB_PREFEX','supp_');
	
	//Backup config:
	define("BACKUP_DIR", URL_PATH.'backup-files/');
	define("TABLES", '*'); // Full backup
	define('IGNORE_TABLES',array('tbl_token_auth', 'token_auth')); // Tables to ignore
	define("CHARSET", 'utf8');
	define("GZIP_BACKUP_FILE", true); // Set to false if you want plain SQL backup files (not gzipped)
	define("DISABLE_FOREIGN_KEY_CHECKS", true); // Set to true if you are having foreign key constraint fails
	define("BATCH_SIZE", 1000); // Batch size when selecting rows from database in order to not exhaust system memory
								// Also number of rows per INSERT statement in backup file

	
	//OTHER
	define('MAX_FILE_SIZE',2097152);
	
	
?>
