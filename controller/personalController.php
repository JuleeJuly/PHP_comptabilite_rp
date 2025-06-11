<?php session_start();
	class personalController extends Controller{
		public function display(){
			$session_login = "";
			$session_status = "";
			$session_color = "";
			$request = new Request();
			$req = $request->select_settings();
			while($data = $req->fetch()){
				$session_login = $data['session_login'];
				$session_status = $data['session_statut'];
				$session_color = $data['session_couleur'];
			}
			if(!isset($_SESSION[$session_login])){
				header("Location: index");
 				die();
			}
            else if($_SESSION[$session_status] == "" || $_SESSION[$session_login] == ""){
				header("Location: index");
 				die();
			}
            if(isset($_POST['validate'])){
                $_SESSION[$session_color] = $_POST['color'];
                $member = new Member($_POST['member_id']);
                $member->update_color($_POST['color'],$_POST['member_id']);
				header("Location: personnal");
 				die();
			}	
			else{
                /*__________TITRE ET DATE__________*/
                $title = $this->model->title();
				$this->view->__set("title",$title);
                $date = date('d/m/Y');
				$this->view->__set("date",$date);
                /*__________MEMBRE ID__________*/
                $member_id = $this->model->recover_member_id_by_login($_SESSION[$session_login]);
                $this->view->__set("member_id",$member_id);
                $member = new Member($member_id);
                $total_criminal_record = $member->recover_total_criminal_record();
                $this->view->__set("total_criminal_record",$total_criminal_record);
                $criminal_record = $member->recover_criminal_record();
                $this->view->__set("criminal_record",$criminal_record);
                $personal_gains = $member->recover_personal_gains();
                $this->view->__set("personal_gains",$personal_gains);
                $personal_expense = $member->recover_personal_expense();
				$this->view->__set("personal_expense",$personal_expense);
				$all_personal_gains = $member->recover_all_personal_gains();
                $this->view->__set("all_personal_gains",$all_personal_gains);
				$all_personal_expense = $member->recover_all_personal_expense();
				$this->view->__set("all_personal_expense",$all_personal_expense);
				$all_personal_penalty = $member->recover_all_personal_penalty();
				$this->view->__set("personal_penalty",$all_personal_penalty);
				$date = new Date();
				$effective_date = $date->calculate_date();
				$day_gains = $member->recover_day_gains($effective_date);
				$this->view->__set("day_gains",$day_gains);
				$day_expense = $member->recover_day_expense($effective_date);
				$this->view->__set("day_expense",$day_expense);
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