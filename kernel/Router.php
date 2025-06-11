<?php
//Classe permettant d'analyser la route , elle renvoie un tableau sous forme d'un controller , action, parametre
	class Router{
	public static function analyze($query){
		$result = array(
			"controller" => "Error",
			"action" => "error404",
			"params" => array()
			);
		if($query === "" || $query === "/"){
			$result["controller"] = "index";
			$result["action"] = "display";
		} else{
				$parts = explode("/", $query);
					$result["controller"] = $parts[0];
					if(isset($parts[1])){
					$result["action"] = $parts[1];}
					else{
						$result['action'] = 'display';
					}
					if(isset($parts[2])){
					$result["params"]["id"] = $parts[2];}
		}
		return $result;
	}
}
?>