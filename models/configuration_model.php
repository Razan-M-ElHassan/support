<?php
	// configuration MODEL, 
	class configuration_model extends model
	{
		/** The Default Method Like Main in java*/
		function __construct()
		{
			parent::__construct();
		}
		
		//config_item get All configuration
		public function config_item()
		{
			$conf = $this->db->select("SELECT conf_name , conf_val, update_at
									FROM ".DB_PREFEX."config 
									WHERE 1=1
									" ,array());
			$ret = array();
			foreach($conf as $val)
			{
				$ret[$val['conf_name']] = array();
				$ret[$val['conf_name']]['NAME'] = $val['conf_val'];
				$ret[$val['conf_name']]['DATE'] = $val['update_at'];
			}
			return $ret;
		}
		
		//update configuration
		public function upd_info()
		{
			$form = new form();
			
			$form	->post('title')
					->valid('Min_Length',2)
					
					->post('desc')
					->valid('Min_Length',10)
					
					->post('about')
					->valid('Min_Length',10)
					
					->post('terms')
					->valid('Min_Length',10)
					
					->post('phone')
					->valid('Phone')
					
					->post('email')
					->valid('Email')
					
					->post('email_host')
					->valid('URL')
					
					->post('paging')
					->valid('Int_min',2)
					->valid('Int_max',50)
					
					->post('email_port')
					->valid('Int_min',1)
					->valid('Int_max',1000)
					
					->post('email_add')
					->valid('Email')
					
					->post('email_pass')
					->valid('Min_Length',3)
					
					->post('face')
					->valid('URL')
					
					->post('twitter')
					->valid('URL')
					
					->post('inst')
					->valid('URL')
					
					->post('login_msg')
					->valid('Min_Length',30)
					
					->submit();
			$fdata = $form->fetch();
			
			if(!empty($fdata['MSG']))
			{
				return array('Error'=>$fdata['MSG']);
			}
			
			$time = dates::convert_to_date('now');
			$time = dates::convert_to_string($time);
			
			$gr_array = array('conf_val'	=>$fdata['title']
							,'update_at'	=>$time
							);
			$this->db->update(DB_PREFEX.'config',$gr_array,"conf_name = 'TITLE'");
			session::set('TITLE',$fdata['title']);
			//cookies::set("TITLE",$fdata['title']);
			
			$gr_array['conf_val'] = $fdata['phone'];
			$this->db->update(DB_PREFEX.'config',$gr_array,"conf_name = 'PHONE'");
			
			$gr_array['conf_val'] = $fdata['desc'];
			$this->db->update(DB_PREFEX.'config',$gr_array,"conf_name = 'DESC_INFO'");
			
			$gr_array['conf_val'] = $fdata['about'];
			$this->db->update(DB_PREFEX.'config',$gr_array,"conf_user = 1 AND conf_name = 'ABOUT'");
			session::set('ABOUT',$fdata['about']);
			
			$gr_array['conf_val'] = $fdata['terms'];
			$this->db->update(DB_PREFEX.'config',$gr_array,"conf_user = 1 AND conf_name = 'TERMS'");
			session::set('TERMS',$fdata['terms']);
			
			$gr_array['conf_val'] = $fdata['email'];
			$this->db->update(DB_PREFEX.'config',$gr_array,"conf_name = 'EMAIL_ADD'");
			//cookies::set("EMAIL_ADD",$fdata['email']);
			
			$gr_array['conf_val'] = $fdata['paging'];
			$this->db->update(DB_PREFEX.'config',$gr_array,"conf_name = 'PAGING'");
			session::set('PAGING',$fdata['paging']);
			//cookies::set("PAGING",$fdata['paging']);
			
			$gr_array['conf_val'] = $fdata['login_msg'];
			$this->db->update(DB_PREFEX.'config',$gr_array,"conf_name = 'LOGIN_FOOTER'");
			session::set('LOGIN_FOOTER',$fdata['login_msg']);
			//cookies::set("LOGIN_FOOTER",$fdata['login_msg']);
			
			$gr_array['conf_val'] = $fdata['email_port'];
			$this->db->update(DB_PREFEX.'config',$gr_array,"conf_name = 'EMAIL_PORT'");
			
			$gr_array['conf_val'] = $fdata['email_host'];
			$this->db->update(DB_PREFEX.'config',$gr_array,"conf_name = 'EMAIL_HOST'");
			
			$gr_array['conf_val'] = $fdata['email_add'];
			$this->db->update(DB_PREFEX.'config',$gr_array,"conf_name = 'EMAIL_SEND_ADD'");
			
			$gr_array['conf_val'] = $fdata['email_pass'];
			$this->db->update(DB_PREFEX.'config',$gr_array,"conf_name = 'EMAIL_SEND_PASS'");
			
			$gr_array['conf_val'] = $fdata['face'];
			$this->db->update(DB_PREFEX.'config',$gr_array,"conf_name = 'FACEBOOK'");
			session::set('FACEBOOK',$fdata['face']);
			//cookies::set("FACEBOOK",$fdata['face']);
			
			$gr_array['conf_val'] = $fdata['twitter'];
			$this->db->update(DB_PREFEX.'config',$gr_array,"conf_name = 'TWITTER'");
			session::set('TWITTER',$fdata['twitter']);
			//cookies::set("TWITTER",$fdata['twitter']);
			
			$gr_array['conf_val'] = $fdata['inst'];
			$this->db->update(DB_PREFEX.'config',$gr_array,"conf_name = 'INSTAGRAM'");
			session::set('INSTAGRAM',$fdata['inst']);
			//cookies::set("INSTAGRAM",$fdata['inst']);
			
			$files	= new files(); 
			
			//Logo
			if(!empty($_FILES['new_pro_image']) )
			{
				if($files->check_file($_FILES['new_pro_image']))
				{
					$gr_array['conf_val'] = $files->up_file($_FILES['new_pro_image'],URL_PATH.'public/IMG/');
					$this->db->update(DB_PREFEX.'config',$gr_array,"conf_name = 'LOGO'");
					session::set("LOGO",$gr_array['conf_val']);
				}
				if(!empty($files->error_message) && $files->error_message != "No file was uploaded")
				{
					return array('Error'=>$files->error_message);
				}
			}
			
			return array("ok"=>1);
			
		}
		
		//update configuration
		public function del()
		{
			$form = new form();
			
			$form	->post('psw')
					->valid('Min_Length',2)
					->valid('Max_Length',90)
					
					->post('captcha')
					->valid('Int_max',9999)
					->valid('Int_min',1000)
					
					->submit();
			$fdata = $form->fetch();
			
			if(!empty($fdata['MSG']))
			{
				return $fdata['MSG'];
			}
			
			if(session::get("captcha") != $fdata['captcha'])
			{
				
				return "captcha is Error ";
			}
			
			$data = $this->db->select("SELECT staff_id, staff_name, staff_permission, staff_img
									,staff_email, staff_pass, staff_active
									FROM ".DB_PREFEX."staff 
									WHERE staff_id = :ID" ,
									array(':ID'=>session::get('user_id'))
								);
			
			if(count($data) != 1 || $data[0]['staff_pass'] != Hash::create(HASH_FUN,$fdata['psw'],HASH_PASSWORD_KEY))
			{
				return " كلمة المرور خطأ";
			}
			
			if($data[0]['staff_permission'] != 1)
			{
				return " ليس لديك صلاحية هذا الاجراء";
			}
			
			//del student item type
			$this->db->delete(DB_PREFEX.'staff_item_type',"1 = 1");
			$this->db->delete(DB_PREFEX.'item_type',"1 = 1");
			$this->db->auto_increment(DB_PREFEX.'item_type');
			
			//del notification
			$this->db->delete(DB_PREFEX.'notification',"1 = 1");
			$this->db->auto_increment(DB_PREFEX.'notification');
			
			//del forget
			$this->db->delete(DB_PREFEX.'forget',"1 = 1");
			$this->db->auto_increment(DB_PREFEX.'forget');
			
			//del staff
			$this->db->delete(DB_PREFEX.'staff',"staff_id != 1");
			$this->db->auto_increment(DB_PREFEX.'staff');
			
			return array('id'=>1);
			
		}
		
		
	}
?>