<?php
	/**
	* dashboard Controller, 
	* This Called after staff Loggin
	*/
	class dashboard extends controller
	{
		/**
		* The Default Method
		* No return (void)
		*/
		function __construct()
		{
			parent::__construct();
			$this->view->CSS = array();
			$this->view->JS = array('views/dashboard/JS/dash.js');
			
		}
		
		//Display dashboard window
		function index($id=0)
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
					$this->view->render(array('dashboard/details'),'public');
					return;
				}
			}
			$this->view->render(array('dashboard/index'),'public');
			
		}
		
		//new
		function new_req()
		{
			echo json_encode($this->model->new_req());
		}
		
		function about()
		{
			$this->view->about = $this->model->terms('ABOUT'); 
			$this->view->render(array('dashboard/about'),'public');
		}
		
		function terms()
		{
			$this->view->terms = $this->model->terms(); 
			$this->view->render(array('dashboard/terms'),'public');
		}
		
		function contact()
		{
			$this->view->MSG = "";
			if(!empty($_POST['csrf']))
			{
				$this->view->MSG = $this->model->contact();
			}
			$this->view->render(array('dashboard/contact'),'public');
		}
	}
?>