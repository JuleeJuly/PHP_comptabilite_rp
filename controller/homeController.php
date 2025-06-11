<?php session_start();
    class homeController extends Controller{
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
            else if(isset($_POST['button_sun'])){
                $date = date('Y-m-d');
				$hour = date( "H:i:s", time());
				$reason = $_POST['reason'];
				$this->model->add_sun(1,$date,$hour,$reason);
				header("Location: home");
 				die();
            }
            else if(isset($_POST['button_cartel'])){
                $id_cartel = $_POST['cartel_id'];
				$this->model->payment_cartel($id_cartel);
				header("Location: home");
 				die();
            }
            else if(isset($_POST['button_blanchi'])){
                $id_blanchi = $_POST['blanchi_id'];
				$this->model->payment_blanchi($id_blanchi);
				header("Location: home");
 				die();
            }
            else if(isset($_POST['button_bennys'])){
                $id_bennys = $_POST['bennys_id'];
				$this->model->payment_contract($id_bennys);
				header("Location: home");
 				die();
            }
            else{
                $day_date = date('Y-m-d');
                /*__________Paiement CARTEL________*/
				$payment_cartel = $this->model->recover_payment_cartel();
				$this->view->__set("payment_cartel", $payment_cartel);
				/*__________BLANCHI________*/
				$blanchi = $this->model->recover_blanchi();
				$this->view->__set("blanchi", $blanchi);
				/*__________BENNYS________*/
				$bennys = $this->model->recover_payment_contract("bennys");
				$this->view->__set("bennys", $bennys);
				/*__________SOLEIL__________*/
				$all_sun = $this->model->recover_all_sun($day_date);
				$this->view->__set("all_sun", $all_sun);
				$sun = $this->model->recover_sun($day_date);
				$this->view->__set("sun", $sun);
				/*__________DATE ET TITRE__________*/
				$date = date('d/m/Y');
				$this->view->__set("date",$date);
				$title = $this->model->title();
				$this->view->__set("title",$title);
				/*__________CAISSE NOIR__________*/
				$black_box = $this->model->recover_black_box();
				$this->view->__set('black_box',$black_box);
				$detail_black_box = $this->model->recover_detail_black_box();
				$this->view->__set('detail_black_box',$detail_black_box);
				/*__________PRESENCE__________*/
				$all_members = $this->model->recover_members();
				$this->view->__set("members", $all_members);
				$nb_members = $this->model->recover_nb_members();
				$this->view->__set("nb_members", (int)$nb_members[0]);
				/*__________OPERATION__________*/
				$operation = $this->model->recover_operation();
				$this->view->__set("operation", $operation);
				/*__________PRESENCE GUERRE__________*/
				$days_war = $this->model->recover_days_war();
				$this->view->__set("days_war", $days_war);
				$days_war_members = $this->model->recover_days_war_members();
				$this->view->__set("days_war_members", $days_war_members);
				$total_days_war = $this->model->recover_total_days_war();
				$this->view->__set("total_days_war", $total_days_war);
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