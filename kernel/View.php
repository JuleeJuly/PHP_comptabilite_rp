<?php
	class View{
		protected $_route;
		protected $data;
		public function __construct($route){
			$this->_route = $route;
		}
		//Affichage de la vue 
		public function display($view){
			$data = $this->data;
			$viewFile = ROOT ."/views/" . $this->_route["controller"]."/".$view.".php";
			include($viewFile);
		}
		public function display_top(){
			$data = $this->data;
			include(ROOT."/src/views/top.php");	
		}
		public function display_header(){
			$data = $this->data;
			include(ROOT."/src/views/header.php");
		}
		public function display_bottom(){
			$data = $this->data;
			include(ROOT."/src/views/bottom.php");
		}
		public function display_footer(){
			$data = $this->data;
			include(ROOT."/src/views/footer.php");
		}
		public function __set($key,$value){
			$this->data[$key] = $value;
		}
		public function __get($key){
			return $this->data($key);
		}
	}
?>