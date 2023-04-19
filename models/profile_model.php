<?php
	/**
	* profile MODEL, 
	*/
	class profile_model extends model
	{
		/** The Default Method Like Main in java*/
		function __construct()
		{
			parent::__construct();
		}
		
		public function specialist()
		{
			$gr = $this->db->select("SELECT spe_id AS ID, spe_name AS NAME
									,COUNT(staff_id) AS STU
									FROM ".DB_PREFEX."specialist
									LEFT JOIN ".DB_PREFEX."staff ON staff_spe = spe_id
									WHERE 1=1
									GROUP BY spe_id" ,array()
								);
			$ret = array();
			foreach($gr as $val)
			{
				$ret[$val['ID']] = $val;
			}
			return $ret;
			
		}
		
		public function items()
		{
			$gr = $this->db->select("SELECT item_id AS ID, item_name AS NAME,item_type AS TY
									FROM ".DB_PREFEX."item_type
									WHERE 1=1" ,array()
								);
			$ret = array();
			foreach($gr as $val)
			{
				$ret[$val['ID']] = $val;
			}
			return $ret;
			
		}
		
		//sys_info get All profile
		public function sys_info()
		{
			//Profile
			$profile = $this->db->select("SELECT staff_id AS ID, staff_name AS NAME
										,staff_phone AS PHONE, staff_email AS EMAIL
										,staff_spe AS SPEC, staff_city AS CITY
										,staff_accept_cons AS ACE, staff_active AS ACTIVE
										,CONCAT('".URL."public/IMG/user/', staff_img) AS IMG
										FROM ".DB_PREFEX."staff
										WHERE staff_id = :ID"
										,array(":ID"=>session::get("user_id")));
			
			
			
			$ret 				= $profile[0];
			$ret['OTH_DATA'] = $this->db->select("SELECT ity_item AS IT, ity_val AS VAL
													FROM ".DB_PREFEX."staff_item_type
													WHERE ity_staff = :STAFF
													" ,array(":STAFF"=>session::get("user_id")));
			$dir 	= URL_PATH."public/USERS/".$ret["ID"]."/";
			$link 	= URL."public/USERS/".$ret["ID"]."/";
			$ret["FILES"] 		= files::get_file_list($dir,$link);
			return $ret;
		}
		
		//update profile
		public function upd_info()
		{
			$time	= dates::convert_to_date('now');
			$time	= dates::convert_to_string($time);
			
			$form	= new form();
			
			$form	->post('new_staff_name') //name
					->valid('Min_Length',3)
			
					->post('new_staff_spec',false,true) 
					->valid('numeric')
					
					->post('new_staff_phone') //Phone
					->valid('Phone')
					
					->post('new_staff_city') //
					->valid('Min_Length',3)
					
					->post('upd_item_id')
					->valid_array('numeric')
					
					->post('upd_item')
					
					->post('curr_staff_pass') //Current Password
					->valid('Min_Length',2)
					
					->post('new_staff_pass',false,true) //New Password
					->valid('Min_Length',2)
					
					->post('new_staff_pass2',false,true) //Confirm New Password
					->valid('Min_Length',2)
					
					->post('accept',false,true)
					->valid('numeric')
					
					->submit();
			$fdata	= $form->fetch();
			
			if(!empty($fdata['MSG']))
			{
				return array('Error'=>$fdata['MSG']);
			}
			
			//check user
			$data = $this->db->select("SELECT staff_id, staff_pass
										FROM ".DB_PREFEX."staff
										WHERE staff_id = :ID" 
										,array(":ID"=>session::get('user_id')));
			
			if(count($data) != 1 || $data[0]['staff_pass'] != Hash::create(HASH_FUN,$fdata['curr_staff_pass'],HASH_PASSWORD_KEY))
			{
				return array('Error'=>"كلمة المرور غير صحيحة");
			}
			
			//check accept
			if($fdata['accept'] !== 1)
			{
				return array('Error'=>"In Field accept : عليك ان توافق على الشروط والاحكام");
			}
			//check phone
			$em = $this->db->select("SELECT staff_id, staff_phone
									FROM ".DB_PREFEX."staff 
									WHERE staff_id != :ID AND staff_phone = :PHO  "
									,array(':PHO'=>$fdata['new_staff_phone']
											,':ID'=>session::get('user_id')
											));
			
			if(count($em) != 0)
			{
				return array('Error'=>"In Field new_staff_phone : Duplicate .. \n");
			}
			
			$user_array = array('staff_name'	=>$fdata['new_staff_name']
								,'staff_phone'	=>$fdata['new_staff_phone']
								,'staff_spe'	=>$fdata['new_staff_spec']
								,'staff_city'	=>$fdata['new_staff_city']
								,'staff_accept_cons'=>1
								,'update_at'	=>$time
								,'update_by'	=>session::get('user_id')
								);
			session::set('user_name'		,$fdata['new_staff_name']);
			
			if(!empty($fdata['new_staff_pass']))
			{
				if($fdata['new_staff_pass'] != $fdata['new_staff_pass2'])
				{
					return array('Error'=>"In Field new_staff_pass : كلمة المرور غير متطابقة .. \n ");
				}
				$user_array['staff_pass'] = Hash::create(HASH_FUN,$fdata['new_staff_pass'],HASH_PASSWORD_KEY);
			}
			
			$it = array('ity_staff'	=> session::get('user_id')
						,'update_at'=> $time
						,'update_by'=> session::get('user_id')
						);
			$this->db->delete(DB_PREFEX.'staff_item_type',
									'ity_staff = '.session::get('user_id'));
			
			foreach($fdata['upd_item_id'] as $key=>$val)
			{
				if(!empty($fdata['upd_item'][$key]))
				{
					$it['ity_item'] = $val;
					$it['ity_val'] 	= $fdata['upd_item'][$key];
					$this->db->insert(DB_PREFEX.'staff_item_type',$it);
				}
			}
			
			$files	= new files(); 
			if(!empty($_FILES['new_pro_image']) )
			{
				if($files->check_file($_FILES['new_pro_image']))
				{
					$user_array['staff_img'] = $files->up_file($_FILES['new_pro_image'],URL_PATH.'public/IMG/user/');
					session::set('user_img'	,$user_array['staff_img']);
				}
				if(!empty($files->error_message))
				{
					return array('Error'=>$files->error_message);
				}
			}
			$this->db->update(DB_PREFEX.'staff',$user_array,"staff_id = ".session::get('user_id'));
			
			if(!empty($_FILES['upd_staff_file_image']) && count($_FILES['upd_staff_file_image'])!= 0)
			{
				$file_array = $files->reArrayFiles($_FILES['upd_staff_file_image']);
				
				foreach($file_array as $val)
				{
					if($files->check_file($val))
					{
						$x = $files->up_file($val,URL_PATH.'public/IMG/user/'.session::get('user_id'));
					}
				}
				
				if(!empty($files->error_message))
				{
					return array('Error'=>"Other File ".$files->error_message);
				}
			}
			return array('id'=>1);
		}
		
		//del_img
		public function del_img()
		{
			$form	= new form();
			
			$form	->post('file') // Name
					->valid('Min_Length',3)
					
					->submit();
			$fdata	= $form->fetch();
			
			$url = URL_PATH."public/USERS/".session::get('user_id')."/".$fdata['file'];
			$x = unlink($url);
			if($x)
			{
				return "The file has been deleted";
			}else{
				return "The file has not been deleted";
			}
		}
	
		//notifications
		public function noti()
		{
			$x = $this->db->select("SELECT noti_id AS ID, noti_title AS TITLE
									,noti_type AS TYPE, noti_link AS URL, noti_status AS STATUS
									FROM ".DB_PREFEX."notification 
									WHERE noti_user = :USR AND noti_status IS NULL
									ORDER BY noti_status ASC, noti_id DESC" 
									,array(":USR"=>session::get("user_id")));
			$ret = array('MSG'=>array(),'NOTI'=>array(),'NEW_MSG'=>0,'NEW_NOTI'=>0);
			foreach($x as $val)
			{
				array_push($ret[$val['TYPE']],$val);
				if($val['STATUS'] === null)
				{
					$ret["NEW_".$val['TYPE']] ++;
				}
			}
			$this->upd_permission();
			
			return $ret;
		}
		
		//notifications read
		public function noti_read($id)
		{
			$form	= new form();
			if($form->single_valid($id,'numeric') !== true)
			{
				return "Error";
			}
			
			$time	= dates::convert_to_date('now');
			$time	= dates::convert_to_string($time);
			
			$this->db->update(DB_PREFEX.'notification',
						array('noti_status'=>1,'update_at'=>$time)
						,"noti_user = ".session::get('user_id')." AND noti_id = ".$id." AND noti_status IS NULL");
			
			return 1;
		}
		
		//notifications read
		public function noti_all_read()
		{
			$time	= dates::convert_to_date('now');
			$time	= dates::convert_to_string($time);
			
			$this->db->update(DB_PREFEX.'notification',
						array('noti_status'=>1,'update_at'=>$time)
						,"noti_user = ".session::get('user_id')." AND noti_status IS NULL");
			return 1;
		}
		
		public function upd_permission()
		{
			$p = $this->db->select("SELECT page_class,page
										FROM ".DB_PREFEX."per_group_pages 
										JOIN ".DB_PREFEX."pages ON per_group_page = page_id
										WHERE 
										per_group_permission = :GROUP" ,
									array(':GROUP'=>session::get('user_per_id'))
								);
			$pages = array();
			foreach($p as $key => $val)
			{
				if(empty($pages[$val['page_class']]))
				{
					$pages[$val['page_class']] = array();
				}
				array_push($pages[$val['page_class']],$val['page']);
			}
			session::set('user_pages',$pages);
				
		}
	}
?>