<?php
	/**
	* area Controller, 
	* This For area Operations
	*/
	class area extends controller
	{
		//The Default Method
		function __construct()
		{
			parent::__construct();
			$this->view->CSS = array();
			$this->view->JS = array('views/area/JS/area.js');
		}
		
		//index show area list
		function index()//Main Page ........
		{
			$this->view->types = $this->model->type_list();
			$this->view->render(array('area/index'));
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