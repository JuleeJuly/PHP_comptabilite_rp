<?php session_start();
	class directoryController extends Controller{
		public function display(){
			$session_login = "";
			$session_status = "";
			$request = new Request();
			$req = $request->select_settings();
			while($data = $req->fetch()){
				$session_login = $data['session_login'];
				$session_status = $data['session_statut'];
			}
			if(!isset($_SESSION[$session_login])){
				header("Location: index");
 				die();
			}
			else if($_SESSION[$session_status] == "" || $_SESSION[$session_login] == ""){
				header("Location: index");
 				die();
			}
			else{
				/*__________TITRE__________*/
				$title = $this->model->title();
				$this->view->__set("title",$title);
				/*__________Récupération des contacts__________*/
				$group_contact = $this->model->recover_group_contact();
				$this->view->__set("group_contact",$group_contact);
				$structure_contact = $this->model->recover_structure_contact();
				$this->view->__set("structure_contact",$structure_contact);
				$other_contact = $this->model->recover_other_contact();
				$this->view->__set("other_contact",$other_contact);
				/*__________AFFICHAGE__________*/
				$this->view->display_header();
				$this->view->display_top();
				$this->view->display("index");
				$this->view->display_bottom();
				$this->view->display_footer();
			}
		}
	}
?>