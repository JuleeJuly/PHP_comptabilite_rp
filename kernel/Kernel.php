<?php
	class Kernel{
		public static function autoload($class){
			//ROOT chemin direct_ defini dans un autre fichier
			//Permet de charger les classes
			if(file_exists(ROOT."lib/class/$class.php")){
					require_once(ROOT."lib/class/$class.php");
				}
			if(file_exists(ROOT."/class/$class.php")){
					require_once(ROOT."/class/$class.php");
				}
			if(file_exists(ROOT."/kernel/$class.php")){
					require_once(ROOT."/kernel/$class.php");
				}

			if(file_exists(ROOT."/controller/$class.php")){
					require_once(ROOT."/controller/$class.php");
				}
			if(file_exists(ROOT."/model/$class.php")){
					require_once(ROOT."/model/$class.php");
				}
			if(file_exists(ROOT."/PHPExcel/Classes/PHPExcel.php")){
					require_once(ROOT."/PHPExcel/Classes/PHPExcel.php");
				}
		}
		public static function run(){
			spl_autoload_register(array("Kernel","autoload"));
			$query = isset($_GET["query"]) ? $_GET["query"] : "";
			$route = Router::analyze($query);
			//var_dump($route);
			$class = $route["controller"]."Controller";
			if(class_exists($class)){
				$controller = new $class($route);
				//var_dump($controller);
					if(isset($route["action"])){
						//var_dump($route);
						$method = array($controller,$route["action"]);
					}else{
						$method = array($controller, "run");
					}
					if( is_callable($method)){
						call_user_func($method);
					}else{
						Tools::redirect(URL);
					}
			}
		}
	}
?>