<?php
	//dashboard MODEL, 
	class dashboard_model extends model
	{
		function __construct()
		{
			parent::__construct();
		}
		
		public function specialist()
		{
			$gr = $this->db->select("SELECT spe_id AS ID, spe_name AS NAME
									FROM ".DB_PREFEX."specialist
									WHERE 1=1" ,array()
								);
			$ret = array();
			foreach($gr as $val)
			{
				$ret[$val['ID']] = $val;
			}
			return $ret;
			
		}
		
		public function area()
		{
			$gr = $this->db->select("SELECT area_id AS ID, area_name AS NAME, area_city AS CITY
									FROM ".DB_PREFEX."area
									WHERE 1=1
									ORDER BY area_city, area_name " ,array()
								);
			$ret = array();
			foreach($gr as $val)
			{
				$ret[$val['ID']] = $val;
			}
			return $ret;
			
		}
		
		//get users list
		public function user_list()
		{
			$form	= new form();
			$form	->post('current_page',false,true) // current page
					->valid('numeric')
					
					->post('all_data',false,true) // all data
					->valid('numeric')
					
					->post('id',false,true) // id
					->valid('numeric')
					
					->post('name',false,true) // Name
					->valid('Min_Length',1)
					
					->post('email',false,true) // email
					->valid('Min_Length',1)
					
					->post('phone',false,true) // phone
					->valid('Min_Length',1)
					
					->post('city',false,true) // city
					->valid('Min_Length',1)
					
					->post('new_spec',false,true) // id
					->valid('numeric')
					
					->submit();
			$fdata	= $form->fetch();
			
			if(!empty($fdata['MSG']))
			{
				return 'Error: '.$fdata['MSG'];
			}
			$sea_arr = array();
			$sea_txt = "";
			
			if(!empty($fdata['id']))
			{
				$sea_arr[':ID'] = $fdata['id'];
				$sea_txt .= 'supp_id = :ID AND ';
			}
			if(!empty($fdata['name']))
			{
				$sea_arr[':NAME'] = "%".$fdata['name']."%";
				$sea_txt .= 'supp_name like :NAME AND ';
			}
			if(!empty($fdata['city']))
			{
				$sea_arr[':CI'] = $fdata['city'];
				$sea_txt .= 'supp_area = :CI AND ';
			}
			if(!empty($fdata['phone']))
			{
				$sea_arr[':PH'] = "%".$fdata['phone']."%";
				$sea_txt .= 'supp_phone like :PH AND ';
			}
			if(!empty($fdata['email']))
			{
				$sea_arr[':ACA'] = "%".$fdata['email']."%";
				$sea_txt .= 'supp_email like :ACA AND ';
			}
			if(!empty($fdata['new_spec']))
			{
				$sea_arr[':NAT'] = $fdata['new_spec'];
				$sea_txt .= 'supp_type = :NAT AND ';
			}
			
			
			$sea_txt .= " supp_accept = 1 AND supp_don = 0";
			//get count
			$count_support = $this->db->select("SELECT count(supp_id) AS NO
										FROM ".DB_PREFEX."support
										WHERE $sea_txt" ,$sea_arr
								);
			if(count($count_support) != 1 || $count_support[0]['NO'] == 0)
			{
				return array('total_no'=>0,'data'=>array());
			}
			$ret = array('total_no'=>$count_support[0]['NO'],'data'=>array());
			
			//get data:
			if(empty($fdata['current_page']))
			{
				$fdata['current_page'] = 1;
			}
			$lim_txt = "";
			if(empty($fdata['all_data']))
			{
				$LIM = session::get('PAGING');
				$FR = ($fdata['current_page'] * $LIM) - $LIM;
				$lim_txt = "LIMIT ".$FR." , ".$LIM;
			}
			
			$r = $this->db->select("SELECT supp_id AS ID, supp_name AS NAME
									,supp_type AS SPEC, supp_area AS CITY
									,supp_phone AS PHONE, supp_email AS EMAIL
									,supp_desc AS DESCR, supp_accept_time AS AC_TIME
									,create_at as REQ_TIME
									FROM ".DB_PREFEX."support
									WHERE $sea_txt
									ORDER BY create_at ASC $lim_txt
									" ,$sea_arr
								);
			
			foreach($r as $val)
			{
				$dir 	= URL_PATH."public/SUPP/".$val["ID"]."/";
				$link 	= URL."public/SUPP/".$val["ID"]."/";
				$val["FILES"] 		= files::get_file_list($dir,$link);
				
				$val['OTH_DATA'] = $this->db->select("SELECT ity_item AS IT, ity_val AS VAL
													FROM ".DB_PREFEX."support_item_type
													WHERE ity_support = :support
													" ,array(":support"=>$val['ID']));
				array_push($ret['data'],$val);
				
			}
			
			return $ret;
		}
		
		//new_req
		public function new_req()
		{
			$form = new form();
			$form	->post('new_name',false,true)
					->valid('Min_Length',2)
					
					->post('new_phone')
					->valid('Phone')
					
					->post('new_email',false,true)
					->valid('EMAIL')
					
					->post('new_city')
					->valid('numeric')
					
					->post('new_desc')
					->valid('Min_Length',2)
					
					->post('new_spec')
					->valid('numeric')
					
					->post('captcha')
					->valid('Int_max',9999)
					->valid('Int_min',1000)
					
					->submit();
			$fdata = $form->fetch();
			
			if(!empty($fdata['MSG']))
			{
				return array('Error'=>$fdata['MSG']);
			}
			if(session::get("captcha") != $fdata['captcha'])
			{
				$err_log_time = (session::get("error_log_time")== false)?0:session::get("error_log_time");
				session::set("error_log_time",$err_log_time + 1);
				return  array('Error'=>"In Field captcha : رمز التحقق خاطئ  .. \n");
			}
			
			//check specialist
			$gr = $this->db->select("SELECT spe_id AS ID, spe_name AS NAME
									FROM ".DB_PREFEX."specialist
									WHERE spe_id = :ID" ,array(":ID"=>$fdata['new_spec'])
								);
			if(count($gr) != 1)
			{
				return array('Error'=>"In Field new_spec : لم يتم العثور على التخصص .. \n");
			}
			
			//check area
			$gr = $this->db->select("SELECT area_id AS ID, area_name AS NAME
									FROM ".DB_PREFEX."area
									WHERE area_id = :ID" ,array(":ID"=>$fdata['new_city'])
								);
			if(count($gr) != 1)
			{
				return array('Error'=>"In Field new_city : لم يتم العثور على المنطقة .. \n");
			}
			
			//insert
			$gr_array = array('supp_name'	=>(!empty($fdata['new_name']))?$fdata['new_name']:null
							,'supp_phone'	=>$fdata['new_phone']
							,'supp_email'	=>(!empty($fdata['new_email']))?$fdata['new_email']:null
							,'supp_type'	=>$fdata['new_spec']
							,'supp_area'	=>$fdata['new_city']
							,'supp_desc'	=>$fdata['new_desc']
							,'create_at'	=>dates::convert_to_string(dates::convert_to_date('now'))
							);
			$this->db->insert(DB_PREFEX.'support',$gr_array);
			return array('id'=>$this->db->LastInsertedId());
		}
		
		
		//Get terms:
		public function terms($type="TERMS")
		{
			$x = $this->db->select("SELECT conf_val AS TER FROM ".DB_PREFEX."config WHERE conf_name = :TY",array(':TY'=>$type));
			return $x[0]['TER'];
		}
		
		//save contact msg
		public function contact()
		{
			$time	= dates::convert_to_date('now');
			$time	= dates::convert_to_string($time);
			$form	= new form();
			
			$form	->post('name')
					->valid('Min_Length',1)
					
					->post('email')
					->valid('Email')
					
					->post('subject')
					->valid('Min_Length',1)
					
					->post('message')
					->valid('Min_Length',10)
					
					->post('captcha')
					->valid('Int_max',9999)
					->valid('Int_min',1000)
					
					->submit();
			$fdata	= $form->fetch();
			
			if(!empty($fdata['MSG']))
			{
				return $fdata['MSG'];
			}
			
			if(session::get("captcha") != $fdata['captcha'])
			{
				return "رمز التحقق خاطئ ";
			}
			
			$notification = array("noti_user"	=> 1
								,"noti_title"	=> "Contact MSG IN Email"
								,"noti_type"	=> "MSG"
								,"noti_link"	=> ""
								,"create_at"	=> $time
								);
			
			$this->db->insert(DB_PREFEX.'notification',$notification);
				
			$MSG = "Subject: ".$fdata['subject']." <br/>";
			$MSG .= "Time: ".$time." <br/>";
			$MSG .= "Name: ".$fdata['name']." <br/>";
			$MSG .= "Email: ".$fdata['email']." <br/>";
			if(session::get('user_id'))
			{
				$MSG .= "User ID: ".session::get('user_id')." <br/>";
			}
			$MSG .= "MSG: <br/> ".$fdata['message'];
			
			$email = new Email();
			
			$x = $email->send_email(session::get('EMAIL_ADD'),$fdata['subject'],$MSG);
			
			$MSG = "لقد تم ارسال رسالتك/ استفسارك \n سيتم الرد عليك قريبا \n الرسالة:\n".$MSG;
			$x = $email->send_email($fdata['email'],'رسالة/ استفسار',$MSG);
				
			return "تم ارسال إستفسارك, سيتم الرد عليك قريبا";
			
		}
		
	}
?>