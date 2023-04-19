<?php
	/**
	* staff MODEL, 
	*/
	class staff_model extends model
	{
		/** The Default Method Like Main in java*/
		function __construct()
		{
			parent::__construct();
		}
		
		public function permissions()
		{
			$gr = $this->db->select("SELECT per_id AS ID, per_name AS NAME
									,per_desc AS DESCR
									FROM ".DB_PREFEX."permission_groups
									WHERE 1=1" ,array()
								);
			$ret = array();
			foreach($gr as $val)
			{
				$ret[$val['ID']] = $val;
			}
			return $ret;
			
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
					->valid('Min_Length',3)
					
					->post('email',false,true) // email
					->valid('Email')
					
					->post('phone',false,true) // phone
					->valid('Phone')
					
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
				$sea_txt .= 'staff_id = :ID AND ';
			}
			if(!empty($fdata['name']))
			{
				$sea_arr[':NAME'] = "%".$fdata['name']."%";
				$sea_txt .= 'staff_name like :NAME AND ';
			}
			if(!empty($fdata['phone']))
			{
				$sea_arr[':PH'] = "%".$fdata['phone']."%";
				$sea_txt .= 'staff_phone like :PH AND ';
			}
			if(!empty($fdata['email']))
			{
				$sea_arr[':ACA'] = "%".$fdata['email']."%";
				$sea_txt .= 'staff_email like :ACA AND ';
			}
			
			$sea_txt .= " staff_permission = 2 ";
			//get count
			$count_staff = $this->db->select("SELECT count(staff_id) AS NO
										FROM ".DB_PREFEX."staff
										WHERE $sea_txt" ,$sea_arr
								);
			if(count($count_staff) != 1 || $count_staff[0]['NO'] == 0)
			{
				return array('total_no'=>0,'data'=>array());
			}
			$ret = array('total_no'=>$count_staff[0]['NO'],'data'=>array());
			
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
			
			$r = $this->db->select("SELECT staff_id AS ID, staff_name AS NAME
									,staff_phone AS PHONE, staff_email AS EMAIL
									,staff_spe AS SPEC, staff_city AS CITY
									,staff_accept_cons AS ACE, staff_active AS ACTIVE
									,CONCAT('".URL."public/IMG/user/', staff_img) AS IMG
									,staff_permission AS PER
									FROM ".DB_PREFEX."staff
									WHERE $sea_txt
									ORDER BY staff_name ASC $lim_txt
									" ,$sea_arr
								);
			
			foreach($r as $val)
			{
				$dir 	= URL_PATH."public/USERS/".$val["ID"]."/";
				$link 	= URL."public/USERS/".$val["ID"]."/";
				$val["FILES"] 		= files::get_file_list($dir,$link);
				
				$val['OTH_DATA'] = $this->db->select("SELECT ity_item AS IT, ity_val AS VAL
													FROM ".DB_PREFEX."staff_item_type
													WHERE ity_staff = :STAFF
													" ,array(":STAFF"=>$val['ID']));
				array_push($ret['data'],$val);
				
			}
			
			return $ret;
		}
		
		//create new staff
		public function new_Staff()
		{
			$form	= new form();
			$form	->post('new_name') // Name
					->valid('Min_Length',3)
					
					->post('new_phone')
					->valid('Phone')
					
					->post('new_email')
					->valid('Email')
					
					->post('new_spec')
					->valid('numeric')
					
					->submit();
			$fdata	= $form->fetch();
			
			if(!empty($fdata['MSG']))
			{
				return array('Error'=>$fdata['MSG']);
			}
			
			//check Email, Phone:
			$em = $this->db->select("SELECT staff_email, staff_phone 
									FROM ".DB_PREFEX."staff 
									WHERE staff_email = :AD 
										OR staff_phone = :PH"
									,array(":AD"=>$fdata['new_email'],
											":PH"=>$fdata['new_phone']));
			if(count($em) != 0)
			{
				$err = "";
				foreach($em as $val)
				{
					if($val['staff_phone'] == $fdata['new_phone'])
					{
						$err .= "In Field new_phone : رقم الهاتف يخص شخص اخر  .. \n";
					}
					if($val['staff_email'] == $fdata['new_email'])
					{
						$err .= "In Field new_email : البريد الالكنروني يخص شخص اخر .. \n";
					}
				}
				if(!empty($err))
				{
					return array('Error'=>$err);
				}
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
			
			//insert
			$user_array = array('staff_name'		=> $fdata['new_name']
								,'staff_phone'		=> $fdata['new_phone']
								,'staff_email'		=> $fdata['new_email']
								,'staff_spe'		=> $fdata['new_spec']
								,'staff_pass'		=> Hash::create(HASH_FUN,"password",HASH_PASSWORD_KEY)
								,'create_at'		=> dates::convert_to_string(dates::convert_to_date('now'))
								,'create_by'		=> session::get('user_id')
								);
			
			$this->db->insert(DB_PREFEX.'staff',$user_array);
			$id = $this->db->LastInsertedId();
			
			if(empty($id))
			{
				return array('id'=>0);
			}
			$msg = "مرحبا بك ".$fdata['new_name']." <br/>
					لقد تم تسجيلك في موقع ".TITLE." <br/>
					لاكمال تسجيلك قم باكمال بياناتك بعد تسجيل دخولك على الرابط ".URL."login <br/> 
					باستخدام بريدك الالكنروني : ".$fdata['new_email']." <br/> 
					كلمة المرور: 'password' ";
			$email 		= new Email();
			$em = $email->send_SMS($fdata['new_phone'],$msg);
			$em = $email->send_email($fdata['new_email'],"Registration",$msg);
			return array('id'=>$id);
		}
		
		//update staff
		public function upd_Staff()
		{
			$time	= dates::convert_to_date('now');
			$time	= dates::convert_to_string($time);
			
			$form	= new form();
			
			$form	->post('upd_id') // id
					->valid('Integer')
					
					->post('upd_name') // Name
					->valid('Min_Length',3)
					
					->post('upd_phone') // phone
					->valid('Phone')
					
					->post('upd_email') // Email
					->valid('Email')
					
					->post('upd_spec')
					->valid('numeric')
					
					->post('upd_city') // City
					->valid('Min_Length',3)
					
					->post('upd_item_id')
					->valid_array('numeric')
					
					->post('upd_item')
					//->valid('Date')
					
					->submit();
			$fdata	= $form->fetch();
			
			if(!empty($fdata['MSG']))
			{
				return array('Error'=>$fdata['MSG']);
			}
			
			//check NO:
			$em = $this->db->select("SELECT staff_id FROM ".DB_PREFEX."staff 
									WHERE staff_id = :ID"
									,array(":ID"=>$fdata['upd_id']));
			if(count($em) != 1)
			{
				return array('Error'=>"لم يتم العثور على الموظف");
			}
			
			//check Email:
			$em = $this->db->select("SELECT staff_email, staff_phone
									FROM ".DB_PREFEX."staff 
									WHERE (staff_email = :AD 
										OR staff_phone = :PH) AND staff_id != :ID"
									,array(":ID"=>$fdata['upd_id']
											,":AD"=>$fdata['upd_email']
											,":PH"=>$fdata['upd_phone']));
			if(count($em) != 0)
			{
				$err = "";
				foreach($em as $val)
				{
					if($val['staff_phone'] == $fdata['upd_phone'])
					{
						$err .= "In Field upd_phone : رقم الهاتف يخص شخص اخر  .. \n";
					}
					if($val['staff_email'] == $fdata['upd_email'])
					{
						$err .= "In Field upd_email : البريد الالكنروني يخص شخص اخر .. \n";
					}
				}
				if(!empty($err))
				{
					return array('Error'=>$err);
				}
			}
			
			//check specialist
			$gr = $this->db->select("SELECT spe_id AS ID, spe_name AS NAME
									FROM ".DB_PREFEX."specialist
									WHERE spe_id = :ID" ,array(":ID"=>$fdata['upd_spec'])
								);
			if(count($gr) != 1)
			{
				return array('Error'=>"In Field upd_spec : لم يتم العثور على التخصص .. \n");
			}
			
			//Update
			$user_array = array('staff_name'	=> $fdata['upd_name']
								,'staff_spe'	=> $fdata['upd_spec']
								,'staff_phone'	=> $fdata['upd_phone']
								,'staff_email'	=> $fdata['upd_email']
								,'staff_city'	=> $fdata['upd_city']
								,'update_at'	=> $time
								,'update_by'	=> session::get('user_id')
								);
			
			$this->db->update(DB_PREFEX.'staff',$user_array,'staff_id = '.$fdata['upd_id']);
			
			$items = $this->items();
			$it = array('ity_staff'	=> $fdata['upd_id']
						,'update_at'=> $time
						,'update_by'=> session::get('user_id')
						);
			$this->db->delete(DB_PREFEX.'staff_item_type',
									'ity_staff = '.$fdata['upd_id']);
			
			foreach($fdata['upd_item_id'] as $key=>$val)
			{
				if(!empty($fdata['upd_item'][$key]))
				{
					$it['ity_item'] = $val;
					$it['ity_val'] 	= $fdata['upd_item'][$key];
					$this->db->insert(DB_PREFEX.'staff_item_type',$it);
				}
			}
			
			return array('id'=>$fdata['upd_id']);
		}
		
		//delete staff
		public function del_Staff()
		{
			$time	= dates::convert_to_date('now');
			$time	= dates::convert_to_string($time);
			
			$form	= new form();
			
			$form	->post('upd_id') // Admission
					->valid('Integer')
					
					->submit();
			$fdata	= $form->fetch();
			
			if(!empty($fdata['MSG']))
			{
				return array('Error'=>$fdata['MSG']);
			}
			
			//check NO:
			$em = $this->db->select("SELECT staff_id, count(vis_id) AS VISITS 
									FROM ".DB_PREFEX."staff 
									WHERE staff_id = :ID
									",array(":ID"=>$fdata['upd_id']));
			if(count($em) != 1)
			{
				return array('Error'=>"لم يتم العثور على الموظف");
			}
			
			$this->db->delete(DB_PREFEX.'staff','staff_id = '.$fdata['upd_id']);
			
			return array('id'=>$fdata['upd_id']);
		}
		
		//delete staff file
		public function del_file()
		{
			$time	= dates::convert_to_date('now');
			$time	= dates::convert_to_string($time);
			
			$form	= new form();
			
			$form	->post('id') // Admission
					->valid('Integer')
					
					->post('file') // Admission
					->valid('Min_Length',5)
					
					->submit();
			$fdata	= $form->fetch();
			
			if(!empty($fdata['MSG']))
			{
				return array('Error'=>$fdata['MSG']);
			}
			
			$files	= new files(); 
			$file_path = URL_PATH."public/USERS/".$fdata['id']."/".$fdata['file'];
			$files->del_file($file_path);
			
			return array('id'=>$fdata['id']);
		}
		
		//active / freez agent
		public function active()
		{
			$form	= new form();
			
			$form	->post('id') // ID
					->valid('Integer')
					
					->post('current',false,true) // Name
					->valid('In_Array',array('true','false'))
					
					->submit();
			$fdata	= $form->fetch();
			
			if(!empty($fdata['MSG']))
			{
				return array('Error'=>$fdata['MSG']);
			}
			
			//check NO:
			$data = $this->db->select("SELECT staff_active 
									FROM ".DB_PREFEX."staff 
									WHERE staff_id = :ID"
									,array(":ID"=>$fdata['id']));
			if(count($data) != 1)
			{
				return array('Error'=>"لم يتم العثور على الموظف");
			}
			
			$curr = ($data[0]['staff_active']==1)?true:false;
			
			if(($fdata['current'] == "true" && !$curr)||($fdata['current']== "false" && $curr))
			{
				return array('Error'=>'حالة الموظف الحالية هي  '.$curr.' - '.$fdata['current']);
			}
			
			
			$time	= dates::convert_to_date('now');
			$time	= dates::convert_to_string($time);
			
			$upd_array = array();
			$upd_array['staff_active'] 	= ($curr)?0:1;
			$upd_array['update_at'] 	= $time;
			$upd_array['update_by'] 	= session::get('user_id');
			
			$this->db->update(DB_PREFEX.'staff',$upd_array,'staff_id = '.$fdata['id']);
			
			return array('id'=>$fdata['id']);
		}
			
		//msg_staff
		public function msg_staff()
		{
			$form	= new form();
			
			$form	->post('msg_user') // users
					->valid_array('Integer')
					
					->post('msg_comm') // MSG
					->valid('Min_Length',5)
					
					->post('sms_msg',false,true) // SMS
					->valid('Integer')
					
					->post('email_msg',false,true) // Email
					->valid('Integer')
					
					->submit();
			$fdata	= $form->fetch();
			
			if(!empty($fdata['MSG']))
			{
				return array('Error'=>$fdata['MSG']);
			}
			
			$time	= dates::convert_to_date('now');
			$time	= dates::convert_to_string($time);
			
			$email 		= new Email();
			
			$sent_email = 0;
			$sent_sms 	= 0;
			$error 		= "";
			
			foreach($fdata['msg_user'] as $val)
			{
				
				//check NO:
				$data = $this->db->select("SELECT staff_id, staff_phone, staff_email FROM ".DB_PREFEX."staff 
										WHERE staff_id = :ID"
										,array(":ID"=>$val));
				if(count($data) != 1)
				{
					$error .= "لم يتم العثور على الموظف ".$val." \n ";
					continue;
				}
				$data = $data[0];
				if(!empty($fdata['email_msg']))
				{
					$em = $email->send_email($data['staff_email'],"MSG",$fdata['msg_comm']);
					if($em === true)
					{
						$sent_email ++;
					}else
					{
						$error .= $em." d";
					}
				}
				if(!empty($fdata['sms_msg']))
				{
					$em = $email->send_SMS($data['staff_phone'],$fdata['msg_comm']);
					if($em === true)
					{
						$sent_sms ++;
					}else
					{
						$error .= $em." d";
					}
				}
				$notification = array("noti_user"	=> $data['staff_id']
									,"noti_title"	=> $fdata['msg_comm']
									,"noti_type"	=> "MSG"
									,"noti_link"	=> ""
									,"create_at"	=> $time
									);
			
				$this->db->insert(DB_PREFEX.'notification',$notification);
			
			}
			
			$ret = array();
			if(!empty($error))
			{
				$ret['Error'] = $error;
			}
			$ret['total'] 	= count($fdata['msg_user']);
			$ret['email'] 	= $sent_email;
			$ret['sms'] 	= $sent_sms;
			
			return $ret;
		}
			
		//update Nat
		public function upd_iqama()
		{
			$form	= new form();
			
			$form	->post('upd_id') // id
					->valid('Integer')
					
					->post('nat_no') // IQ
					->valid('Min_Length',3)
					
					->post('nat_type') // 
					->valid('In_Array',array_keys(lib::$id_type))
					
					->post('nat_place') // IQ Place
					->valid('Min_Length',3)
					
					->post('nat_create') // IQ Create
					->valid('Date')
					
					->post('nat_end') // IQ End
					->valid('Date')
					
					->submit();
			$fdata	= $form->fetch();
			
			if(!empty($fdata['MSG']))
			{
				return array('Error'=>$fdata['MSG']);
			}
			
			//check NO:
			$em = $this->db->select("SELECT staff_id, staff_nat AS NAT
									FROM ".DB_PREFEX."staff 
									WHERE staff_id = :ID"
									,array(":ID"=>$fdata['upd_id']));
			if(count($em) != 1)
			{
				return array('Error'=>"لم يتم العثور على الموظف");
			}
			$st = $em[0];
			
			
			//check Nat no:
			$em = $this->db->select("SELECT staff_nat_no 
									FROM ".DB_PREFEX."staff 
									WHERE staff_nat_no = :NAT AND staff_id != :ID"
									,array(":ID"=>$fdata['upd_id']
											,":NAT"=>$fdata['nat_no']));
			if(count($em) != 0)
			{
				return array('Error'=>"In Field nat_no : رقم الهوية يخص شخص اخر .. \n");
			}
			
			//check NAT
			if($st['NAT'] != 'SA' && !in_array($fdata['nat_type'], array("PASSPORT","IQAMA")))
			{
				return array('Error'=>"In Field nat_type : هوية الشخص الاجنبي يفترض ان تكون اقامة او جواز سفر .. \n");
			}
			if($st['NAT'] == 'SA' && $fdata['nat_type'] == "IQAMA")
			{
				return array('Error'=>"In Field new_nat_type : هوية الشخص السعودي يفترض ان لا تكون اقامة .. \n");
			}
			//check date
			$en=date_create($fdata['nat_end']);
			$st=date_create($fdata['nat_create']);
			if($en < $st )
			{
				return array('Error'=>"In Field nat_end : تاريخ النهاية يفترض ان يكون اكبر من البداية .. \n");
			}
			
			$iq_array = array('staff_nat_no'	=> $fdata['nat_no']
							,'staff_nat_type'	=> $fdata['nat_type']
							,'staff_nat_place'	=> $fdata['nat_place']
							,'staff_nat_create'	=> $fdata['nat_create']
							,'staff_nat_end'	=> $fdata['nat_end']
							,'update_at'		=> dates::convert_to_string(dates::convert_to_date('now'))
							,'update_by'		=> session::get('user_id')
							);
			
			$this->db->update(DB_PREFEX.'staff',$iq_array,'staff_id = '.$fdata['upd_id']);
			
			return array('id'=>$fdata['upd_id']);
		}
		
		//update Driver
		public function upd_driver()
		{
			$form	= new form();
			
			$form	->post('upd_id') // id
					->valid('Integer')
					
					->post('dr_no') // IQ
					->valid('Min_Length',3)
					
					->post('dr_type') // Nationality
					->valid('In_Array',array_keys(lib::$driver_type))
					
					->post('dr_place') // Place
					->valid('Min_Length',3)
					
					->post('dr_create') // Create
					->valid('Date')
					
					->post('dr_end') // End
					->valid('Date')
					
					->submit();
			$fdata	= $form->fetch();
			
			if(!empty($fdata['MSG']))
			{
				return array('Error'=>$fdata['MSG']);
			}
			
			//check NO:
			$em = $this->db->select("SELECT staff_id, staff_nat AS NAT
									,dr_no AS DR
									FROM ".DB_PREFEX."staff 
									LEFT JOIN ".DB_PREFEX."staff_driver ON staff_id = dr_staff
									WHERE staff_id = :ID"
									,array(":ID"=>$fdata['upd_id']));
			if(count($em) != 1)
			{
				return array('Error'=>"لم يتم العثور على الموظف");
			}
			$em = $em[0];
			
			$start 	= dates::convert_to_date($fdata['dr_create']);
			$end 	= dates::convert_to_date($fdata['dr_end']);
			if($start >= $end)
			{
				return array('Error'=>"تاريخ نهاية الاقامة اكبر من تاريخ بدايتها");
			}
			
			
			$e = $this->db->select("SELECT dr_no FROM ".DB_PREFEX."staff_driver 
									WHERE dr_no = :NO AND dr_staff != :ID",
									array(":NO"=>$fdata['dr_no'],":ID"=>$fdata['upd_id']));
			if(count($e)!=0)
			{
				return array('Error'=>"رقم الرخصة مكرر");
			}
			
			$iq_array = array('dr_no'		=> $fdata['dr_no']
							,'dr_type'		=> $fdata['dr_type']
							,'dr_place'		=> $fdata['dr_place']
							,'dr_create'	=> $fdata['dr_create']
							,'dr_end'		=> $fdata['dr_end']
							);
			
			if(!empty($em['DR']))
			{
				//Update
				$iq_array['update_at'] = dates::convert_to_string(dates::convert_to_date('now'));
				$iq_array['update_by'] = session::get('user_id');
				$this->db->update(DB_PREFEX.'staff_driver',$iq_array,'dr_staff = '.$fdata['upd_id']);
			}else
			{
				//new iqama
				$iq_array['dr_staff']	= $fdata['upd_id'];
				$iq_array['create_at'] 	= dates::convert_to_string(dates::convert_to_date('now'));
				$iq_array['create_by'] 	= session::get('user_id');
				$this->db->insert(DB_PREFEX.'staff_driver',$iq_array);
			}
			
			return array('id'=>$fdata['upd_id']);
		}
		
	}
?>