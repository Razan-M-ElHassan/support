<?php
	/**
	* requests MODEL, 
	*/
	class requests_model extends model
	{
		/** The Default Method Like Main in java*/
		function __construct()
		{
			parent::__construct();
		}
		
		public function specialist()
		{
			$gr = $this->db->select("SELECT spe_id AS ID, spe_name AS NAME
									,COUNT(supp_id) AS STU
									FROM ".DB_PREFEX."specialist
									LEFT JOIN ".DB_PREFEX."support ON supp_type = spe_id
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
		
		public function area()
		{
			$gr = $this->db->select("SELECT area_id AS ID, area_name AS NAME, area_city AS CITY
									FROM ".DB_PREFEX."area
									WHERE 1=1
									ORDER BY area_city, area_name " ,array());
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
				$sea_arr[':CI'] = "%".$fdata['city']."%";
				$sea_txt .= 'supp_area like :CI AND ';
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
			
			
			$sea_txt .= " 1 = 1";
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
									,create_at as REQ_TIME, supp_accept AS ACA
									,supp_don AS DON, supp_done_time AS DON_TIME
									FROM ".DB_PREFEX."support
									WHERE $sea_txt
									ORDER BY create_at ASC $lim_txt
									" ,$sea_arr
								);
			
			foreach($r as $val)
			{
				$dir 	= URL_PATH."public/USERS/".$val["ID"]."/";
				$link 	= URL."public/USERS/".$val["ID"]."/";
				$val["FILES"] 		= files::get_file_list($dir,$link);
				
				$val['OTH_DATA'] = $this->db->select("SELECT ity_item AS IT, ity_val AS VAL
													FROM ".DB_PREFEX."support_item_type
													WHERE ity_support = :support
													" ,array(":support"=>$val['ID']));
				array_push($ret['data'],$val);
				
			}
			
			return $ret;
		}
		
		//active / freez agent
		public function active()
		{
			$form	= new form();
			
			$form	->post('id') // ID
					->valid('Integer')
					
					->submit();
			$fdata	= $form->fetch();
			
			if(!empty($fdata['MSG']))
			{
				return array('Error'=>$fdata['MSG']);
			}
			
			//check NO:
			$data = $this->db->select("SELECT supp_accept 
									FROM ".DB_PREFEX."support 
									WHERE supp_id = :ID"
									,array(":ID"=>$fdata['id']));
			if(count($data) != 1)
			{
				return array('Error'=>"لم يتم العثور على الطلب");
			}
			
			$time	= dates::convert_to_date('now');
			$time	= dates::convert_to_string($time);
			
			$upd_array = array();
			$upd_array['supp_accept'] 	= 1;
			$upd_array['supp_accept_time'] 	= $time;
			$upd_array['supp_accept_by'] 	= session::get('user_id');
			
			$this->db->update(DB_PREFEX.'support',$upd_array,'supp_id = '.$fdata['id']);
			
			return array('id'=>$fdata['id']);
		}
		
		//done
		public function done()
		{
			$form	= new form();
			
			$form	->post('id') // ID
					->valid('Integer')
					
					->submit();
			$fdata	= $form->fetch();
			
			if(!empty($fdata['MSG']))
			{
				return array('Error'=>$fdata['MSG']);
			}
			
			//check NO:
			$data = $this->db->select("SELECT supp_accept 
									FROM ".DB_PREFEX."support 
									WHERE supp_id = :ID"
									,array(":ID"=>$fdata['id']));
			if(count($data) != 1)
			{
				return array('Error'=>"لم يتم العثور على الطلب");
			}
			
			$time	= dates::convert_to_date('now');
			$time	= dates::convert_to_string($time);
			
			$upd_array = array();
			$upd_array['supp_don'] 	= 1;
			$upd_array['supp_done_time'] 	= $time;
			$upd_array['supp_done_by'] 	= session::get('user_id');
			
			$this->db->update(DB_PREFEX.'support',$upd_array,'supp_id = '.$fdata['id']);
			
			return array('id'=>$fdata['id']);
		}
		
		
		//new_co
		public function new_type()
		{
			$form = new form();
			$form	->post('new_name')
					->valid('Min_Length',2)
					
					->post('new_data')
					->valid('In_Array',array_keys(lib::$data_type))
					
					->submit();
			$fdata = $form->fetch();
			
			if(!empty($fdata['MSG']))
			{
				return array('Error'=>$fdata['MSG']);
			}
			
			//insert
			$gr_array = array('item_name'	=>$fdata['new_name']
							,'requests'	=>$fdata['new_data']
							,'create_by'	=>session::get('user_id')
							,'create_at'	=>dates::convert_to_string(dates::convert_to_date('now'))
							);
			$this->db->insert(DB_PREFEX.'requests',$gr_array);
			return array('id'=>$this->db->LastInsertedId());
		}
		
		//update Type
		public function upd_type()
		{
			$form = new form();
			
			$form	->post('id')
					->valid('Integer')
					
					->post('upd_name')
					->valid('Min_Length',2)
					
					->post('upd_data')
					->valid('In_Array',array_keys(lib::$data_type))
					
					->submit();
			$fdata = $form->fetch();
			
			if(!empty($fdata['MSG']))
			{
				return array('Error'=>$fdata['MSG']);
			}
			
			$gr_array = array('item_name'	=>$fdata['upd_name']
							,'requests'	=>$fdata['upd_data']
							,'update_by'	=>session::get('user_id')
							,'update_at'	=>dates::convert_to_string(dates::convert_to_date('now'))
							);
				
			$this->db->update(DB_PREFEX.'requests',$gr_array,"item_id = ".$fdata['id']);
			return array('id'=>$fdata['id']);
			
		}
		
		//delete Type
		public function del_type()
		{
			$form = new form();
			$form	->post('upd_id')
					->valid('numeric')
					
					->submit();
						
			$fdata = $form->fetch();
			
			if(!empty($fdata['MSG']))
			{
				return array('Error'=>$fdata['MSG']);
			}
			
			$this->db->delete(DB_PREFEX.'staff_requests',"ity_item = ".$fdata['upd_id']);
			$this->db->delete(DB_PREFEX.'requests',"item_id = ".$fdata['upd_id']);
			return array('id'=>$fdata['upd_id']);
			
		}
		
	}
?>