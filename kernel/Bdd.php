<?php
	class Bdd{
		public static function Cbdd(){
			try{
				$bd=new PDO('mysql:host=;port=; dbname=; charset=utf8', '','');
				}catch(Exception $e){
					die('Erreur : '.$e->getMessage());
				}
				return $bd;
		}
	}
?>