<?php session_start();
	class informationController extends Controller{
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
				if(isset($_POST['validate'])){
					$author = $_SESSION[$session_login];
					$req_id_author = $this->model->recover_member_id_by_login($author);
					$id_author = 0;
					foreach($req_id_author as $data){
						$id_author = $data['id_membre'];
					}
					$group = 0;
					if(isset($_POST['group'])){
						$group = $_POST['group'];
					}
					$this->model->add_information($id_author,$_POST['title'],$group,$_POST['content']);
					header("Location: information");
 					die();
				}else if(isset($_POST['update'])){
                    $req = $this->model->update_information($_POST['id'],$_POST['title'],$_POST['content']);
                    header("Location: information");
 					die();
                }else if(isset($_POST['delete'])){
                    $req = $this->model->delete_information($_POST['id']);
                    header("Location: information");
                    die();
                }else{		
                    /*__________DATE ET TITRE__________*/
					$title = $this->model->title();
					$this->view->__set("title",$title);
                    $date = date('d/m/Y');	
					$this->view->__set("date",$date);
                    /*__________Récupération des groupes__________*/
					$group_list = $this->model->recover_group();
					$this->view->__set("group_list",$group_list);
                    /*__________Récupération des infos__________*/
					$information_list = $this->model->recover_list_information();
					$this->view->__set('information_list',$information_list);
                    /*__________AFFICHAGE__________*/
					$this->view->display_header();
					$this->view->display_top();
					$this->view->display("index");
					$this->view->display_bottom();
					$this->view->display_footer();
				}	
			}	
		}
	}
?>