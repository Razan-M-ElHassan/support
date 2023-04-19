<?php
	/**
	* backup MODEL, 
	*/
	class backup_model extends model
	{
		/** The Default Method Like Main in java*/
		function __construct()
		{
			parent::__construct();
		}
		
		//get backup files list
		public function backup_list()
		{
			$files = scandir(BACKUP_DIR);
			if(count($files) < 3)
			{
				return array();
			}
			$result = array();
			
			foreach($files as $val)
			{
				if(!is_dir($val) && $val != ".htaccess")
				{
					array_push($result,$val);
				}
			}
			return $result;
		}
		
		//create backup file
		public function new_backup()
		{
			return $this->db->backup();
		}
		
		//upload_backup backup
		public function upload_backup()
		{
			$form	= new form();
			
			$form	->post('psw') // password
					->valid('Min_Length',3)
					
					->post('captcha')
					->valid('Int_max',9999)
					->valid('Int_min',1000)
					
					->submit();
			$fdata	= $form->fetch();
			
			if(!empty($fdata['MSG']))
			{
				return array('Error'=>$fdata['MSG']);
			}
			
			if(session::get("captcha") != $fdata['captcha'])
			{
				return array('Error'=>"captcha is Error ");
			}
			
			///check password
			$data = $this->db->select("SELECT staff_id
									FROM ".DB_PREFEX."staff 
									WHERE 
									staff_id = :ID AND staff_pass = :login" ,
									array(':ID'=> session::get('user_id')
										,':login'=>Hash::create(HASH_FUN,$fdata['psw'],HASH_PASSWORD_KEY))
								);
			
			if(count($data)!= 1)
			{
				return array('Error'=>"Error data .. \n ");
			}
			
			$files	= new files(); 
			if(empty($_FILES['new_backup_file']) )
			{
				return array('Error'=>"Error data .. \n ");
			}
			
			//get name
			$name = $_FILES['new_backup_file']['name'];
			$pos = strpos($name,".sql.gz");
			$len = strlen($name);
			if(!$pos || $len - $pos != 7)
			{
				return array('Error'=>"Error File Name EXT .. $pos - $len \n ");
			}
			if(file_exists(BACKUP_DIR."/".$_FILES['new_backup_file']['name']))
			{
				return array('Error'=>"File Exsist .. \n ");
			}
			move_uploaded_file($_FILES['new_backup_file']["tmp_name"],BACKUP_DIR."/".$name);
			
			
			return array('id'=>1);
		}
		
		//del backup
		public function del_backup()
		{
			$form	= new form();
			
			$form	->post('file_name') //File Name
					->valid('Min_Length',10)
			
					->post('psw') // password
					->valid('Min_Length',3)
					
					->post('captcha')
					->valid('Int_max',9999)
					->valid('Int_min',1000)
					
					->submit();
			$fdata	= $form->fetch();
			
			if(!empty($fdata['MSG']))
			{
				return array('Error'=>$fdata['MSG']);
			}
			
			if(session::get("captcha") != $fdata['captcha'])
			{
				return array('Error'=>"captcha is Error ");
			}
			
			///check password
			$data = $this->db->select("SELECT staff_id
									FROM ".DB_PREFEX."staff 
									WHERE 
									staff_id = :ID AND staff_pass = :login" ,
									array(':ID'=> session::get('user_id')
										,':login'=>Hash::create(HASH_FUN,$fdata['psw'],HASH_PASSWORD_KEY))
								);
			
			if(count($data)!= 1)
			{
				return array('Error'=>"Error data .. \n ");
			}
			
			//check file
			if(empty($fdata['file_name']) || !file_exists(BACKUP_DIR."/".$fdata['file_name']) )
			{
				return array('Error'=>"In Field file_name : Error data .. \n ");
			}
			unlink(BACKUP_DIR."/".$fdata['file_name']);
			return array('id'=>1);
		}
		
		//restore backup
		public function get_backup()
		{
			$form	= new form();
			
			$form	->post('file_name') //File Name
					->valid('Min_Length',10)
			
					->post('psw') // password
					->valid('Min_Length',3)
					
					->submit();
			$fdata	= $form->fetch();
			
			if(!empty($fdata['MSG']))
			{
				return array('Error'=>$fdata['MSG']);
			}
			
			///check password
			$data = $this->db->select("SELECT staff_id
									FROM ".DB_PREFEX."staff 
									WHERE 
									staff_id = :ID AND staff_pass = :login" ,
									array(':ID'=> session::get('user_id')
										,':login'=>Hash::create(HASH_FUN,$fdata['psw'],HASH_PASSWORD_KEY))
								);
			
			if(count($data)!= 1)
			{
				return array('Error'=>"In Field del_pass : Error data .. \n ");
			}
			
			//check file
			if(empty($fdata['file_name']) || !file_exists(BACKUP_DIR."/".$fdata['file_name']) )
			{
				return array('Error'=>"In Field file_name : Error data .. \n ");
			}
			$outpput = $this->db->restore($fdata['file_name']);
			return array('id'=>1);
		}	
	}
?>