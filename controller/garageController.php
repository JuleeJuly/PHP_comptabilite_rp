<?php session_start();
	class garageController extends Controller{
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
            else if(isset($_POST['add'])){
                $this->model->add_car($_POST['name'],$_POST['plate'],$_POST['garage'],$_POST['member']);
                header("Location: garage");
                die();
            }
            else if(isset($_POST['update'])){
				$car = new Car($_POST['car_id']);
                $car->update_car($_POST['car_id'], $_POST['car_name'], $_POST['car_plate'], $_POST['member'], $_POST['garage']);
                header("Location: garage");
 				die();
            }
            else if(isset($_POST['delete'])){
				$car = new Car($_POST['car_id']);
				$car->delete_car();
                header("Location: garage");
 				die();
            }
			else{
                /*__________TITRE__________*/
				$title = $this->model->title();
				$this->view->__set("title",$title);
                /*__________GARAGE, VEHICULE, MEMBER__________*/
                $car_list = $this->model->recover_car_list();
                $this->view->__set("car_list",$car_list);
                $garage_list = $this->model->recover_garage();
                $this->view->__set("garage_list",$garage_list);
                $members = $this->model->recover_members();
                $this->view->__set("members",$members);
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