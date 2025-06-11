<?php session_start();
    class indexController extends Controller{
        public function display(){
            $title = $this->model->title();
            $this->view->__set("title",$title);
            $this->view->display_header();
            if(isset($_POST['connect'])){
                echo "toto";
                $login = $_POST['login'];
                $password = $_POST['password'];
                $connect = new Connect();
                $exist = $connect->connect($login, $password);
                if($exist == 1){
                    header("Location: home");
 					die();
                }
            }
            $this->view->display("index");
			$this->view->display_bottom();
			$this->view->display_footer();
        }
    }
?>