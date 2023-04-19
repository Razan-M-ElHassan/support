<?php
	/**
	* requests Controller, 
	* This For requests Operations
	*/
	class requests extends controller
	{
		//The Default Method
		function __construct()
		{
			parent::__construct();
			$this->view->CSS = array();
			$this->view->JS = array('views/requests/JS/requests.js');
		}
		
		//index show requests list
		function index($id=0)//Main Page ........
		{
			if(!empty($_POST['csrf']))
			{
				echo json_encode($this->model->user_list());
				return;
			}
			$this->view->specialist = $this->model->specialist();
			$this->view->area = $this->model->area();
			if($id != 0)
			{
				$_POST['csrf'] 	= lib::get_CSRF();
				$_POST['id']	= $id;
				$x = $this->model->user_list();
				if(count($x['data']) == 1)
				{
					$this->view->details = $x['data'][0];
					$this->view->render(array('requests/details'),'public');
					return;
				}
			}
			$this->view->types = $this->model->user_list();
			$this->view->render(array('requests/index'));
		}
		
		//new_co
		function active()
		{
			echo json_encode($this->model->active());
		}
		
		//new_co
		function done()
		{
			echo json_encode($this->model->done());
		}
		
		//upd_type
		function upd_type()
		{
			echo json_encode($this->model->upd_type());
		}
		
		//delete type
		function del_type()
		{
			echo json_encode($this->model->del_type());
		}
		
		
	}
?>