<?php
	class Controller{
		protected $view;
		protected $model;
		protected $route;
		public function __construct($route){
			$this->route = $route;
				$class = $route["controller"]."Model";
				$this->model = new $class($route);
			$this->view = new View($route);
		}
	}
?>