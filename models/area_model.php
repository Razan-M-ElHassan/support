<?php
	/**
	* area MODEL, 
	*/
	class area_model extends model
	{
		/** The Default Method Like Main in java*/
		function __construct()
		{
			parent::__construct();
		}
		//SELECT ``, ``, ``, `create_at`, `create_by`, `update_at`, `update_by` FROM `supp_area` WHERE 1
		//type_list get All types
		public function type_list()
		{
			return $this->db->select("SELECT area_id AS ID, area_name AS NAME, area_city AS CITY
									,COUNT(supp_id) AS STU
									FROM ".DB_PREFEX."area
									LEFT JOIN ".DB_PREFEX."support ON supp_area = area_id
									WHERE 1=1
									GROUP BY area_id" ,array());
											
		}
		
		//new_co
		public function new_type()
		{
			$form = new form();
			$form	->post('new_name')
					->valid('Min_Length',2)
					
					->post('new_city')
					->valid('Min_Length',2)
					
					->submit();
			$fdata = $form->fetch();
			
			if(!empty($fdata['MSG']))
			{
				return array('Error'=>$fdata['MSG']);
			}
			
			//insert
			$gr_array = array('area_name'	=>$fdata['new_name']
							,'area_city'	=>$fdata['new_city']
							,'create_by'	=>session::get('user_id')
							,'create_at'	=>dates::convert_to_string(dates::convert_to_date('now'))
							);
			$this->db->insert(DB_PREFEX.'area',$gr_array);
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
					
					->post('upd_city')
					->valid('Min_Length',2)
					
					->submit();
			$fdata = $form->fetch();
			
			if(!empty($fdata['MSG']))
			{
				return array('Error'=>$fdata['MSG']);
			}
			
			$gr_array = array('area_name'	=>$fdata['upd_name']
							,'area_city'	=>$fdata['upd_city']
							,'update_by'	=>session::get('user_id')
							,'update_at'	=>dates::convert_to_string(dates::convert_to_date('now'))
							);
				
			$this->db->update(DB_PREFEX.'area',$gr_array,"area_id = ".$fdata['id']);
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
			
			$spe = $this->db->select("SELECT area_id AS ID, COUNT(supp_id) AS STU
									FROM ".DB_PREFEX."area
									LEFT JOIN ".DB_PREFEX."support ON supp_area = area_id
									WHERE area_id = :ID
									GROUP BY area_id" ,array(":ID"=>$fdata['upd_id']));
			if(count($spe) != 1)
			{
				return array('Error'=>"لم يتم العثور على التخصص");
			}
			if($spe[0]['STU'] != 0)
			{
				return array('Error'=>"هنالك طلبات من هذا التخصص");
			}
			
			$this->db->delete(DB_PREFEX.'area',"area_id = ".$fdata['upd_id']);
			return array('id'=>$fdata['upd_id']);
			
		}
		
	}
?>