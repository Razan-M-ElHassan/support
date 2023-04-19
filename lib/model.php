<?php
	class model 
	{
		/**The Default Method Like Main in java*/
		function __construct()
		{
			if(empty($this->db))
			{
				$this->db = new database();
			}
		}
		
	}
?>