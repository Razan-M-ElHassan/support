<?php
	/**
	* specialist Controller, 
	* This For specialist Operations
	*/
	class specialist extends controller
	{
		//The Default Method
		function __construct()
		{
			parent::__construct();
			$this->view->CSS = array();
			$this->view->JS = array('views/specialist/JS/specialist.js');
		}
		
		//index show specialist list
		function index()//Main Page ........
		{
			$this->view->types = $this->model->type_list();
			$this->view->render(array('specialist/index'));
		}
		
		//new
		function new_spec()
		{
			echo json_encode($this->model->new_type());
		}
		
		//upd
		function upd_spec()
		{
			echo json_encode($this->model->upd_type());
		}
		
		//delete type
		function del_spec()
		{
			echo json_encode($this->model->del_type());
		}
		
		
	}
?>