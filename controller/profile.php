<?php
	/**
	* profile Controller, 
	* This Called after staff Loggin
	*/
	class profile extends controller
	{
		/**
		* The Default Method
		* No return (void)
		*/
		function __construct()
		{
			parent::__construct();
			$this->view->CSS = array('views/profile/CSS/profile.css');
			$this->view->JS = array('views/profile/JS/pro.js','public/JS/img.js');
			$this->view->curr_page = "profile";
		}
		
		//Display profile window
		function index()
		{
			$this->view->sys_info 	= json_encode($this->model->sys_info());
			$this->view->specialist = $this->model->specialist();
			$this->view->items 		= $this->model->items();
			
			$this->view->render(array('profile/index'));
			
			
		}
		
		//Update profile data
		function upd_info()
		{
			echo json_encode($this->model->upd_info());
		}
		
		//delete img file
		function del_img()
		{
			echo $this->model->del_img();
		}
		
		//get notifications
		function noti()
		{
			echo json_encode($this->model->noti());
		}
		
		//get notifications
		function noti_read($id)
		{
			echo $this->model->noti_read($id);
		}
		
		//get notifications
		function noti_all_read()
		{
			echo $this->model->noti_all_read();
		}
		
	}