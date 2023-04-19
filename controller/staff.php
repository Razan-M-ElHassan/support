<?php
	/**
	* staff Controller, 
	* This Called after admin
	*/
	class staff extends controller
	{
		/**
		* The Default Method
		* No return (void)
		*/
		function __construct()
		{
			parent::__construct();
			$this->view->CSS = array();
			$this->view->JS = array('views/staff/JS/staff.js','public/JS/img.js');
		}
		
		//Display user window
		function index($id=0)
		{
			if(!empty($_POST['csrf']))
			{
				echo json_encode($this->model->user_list());
				return;
			}
			$this->view->permissions= $this->model->permissions();
			$this->view->specialist = $this->model->specialist();
			$this->view->items 		= $this->model->items();
			
			if($id != 0)
			{
				$_POST['csrf'] 	= lib::get_CSRF();
				$_POST['id']	= $id;
				$x = $this->model->user_list();
				if(count($x['data']) == 1)
				{
					$this->view->details = $x['data'][0];
					$this->view->render(array('staff/details'));
					return;
				}
			}
			
			$this->view->render(array('staff/index'));
		}
		
		//create New Staff
		function new_staff()
		{
			echo json_encode($this->model->new_Staff());
		}
		
		//update Staff
		function upd_staff()
		{
			echo json_encode($this->model->upd_Staff());
		}
		
		//del Staff
		function del_Staff()
		{
			echo json_encode($this->model->del_Staff());
		}
		
		//del Staff file
		function del_file()
		{
			echo json_encode($this->model->del_file());
		}
		
		//active / freez staff
		function active()
		{
			echo json_encode($this->model->active());
		}
		
		//send msg to staff
		function msg_staff()
		{
			echo json_encode($this->model->msg_staff());
		}
		
		//update Iqama
		function upd_iqama()
		{
			echo json_encode($this->model->upd_iqama());
		}
		
		//update driver
		function upd_driver()
		{
			echo json_encode($this->model->upd_driver());
		}
		
		
	}
?>
