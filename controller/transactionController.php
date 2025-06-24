<?php session_start();
    class transactionController extends Controller{
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
                //ajout d'une commande
                if(isset($_POST['add_transaction'])){
                    
                }
                
                //vider le tableau des poches
                else if(isset($_POST['delete_pocket'])){
					$this->model->delete_pocket();
					header("Location: transaction");
 					die();
                }
                //affichage de la page
                else{
                    //variable de filtres des transactions
                    if(isset($_POST['validate_sort'])){
						$_SESSION['tri'] = $_POST['tri'];
					}
                    //nombre de transactions par page
					if(isset($_POST['validate_transac_number'])){
						$_SESSION['number_transac'] = $_POST['number_transac'];
					}
                    //page actuelle
					$current_page = 1;
                    if(isset($_GET['page']) && !empty($_GET['page'])){
					    $current_page = (int) strip_tags($_GET['page']);
					}
					$list_transactions = new Transaction_List();
					$number_of_transactions = $list_transactions->recover_number_of_transactions();
					$per_page = 10;
					if(isset($_SESSION['nb_transac'])){
						$per_page = $_SESSION['nb_transac'];
					}
					$number_of_page = ceil($number_of_transactions / $per_page);
					$first = ($current_page * $per_page) - $per_page;
					$this->view->__set("current_page",$current_page);
					$this->view->__set("pages",$number_of_page);

					$sort = "date";
					if(isset($_SESSION['tri'])){
						$sort = $_SESSION['tri'];
					}
					$orders = $list_transactions->recover_transactions($first, $per_page, $sort);
					$this->view->__set("orders",$orders);
					$result = $this->model->title();
					$this->view->__set("title",$result);
					$date = date('d/m/Y');
					$this->view->__set("date",$date);
					$all_members = $this->model->recover_members();
					$this->view->__set("members", $all_members);
					$group_list = $this->model->recover_group();
					$this->view->__set("group_list",$group_list);
					$all_items = $this->model->recover_items();
					$this->view->__set("all_items",$all_items);
					$all_pocket_item_name = $this->model->recover_pocket_item_name();
	 				$this->view->__set("all_pocket_item_name",$all_pocket_item_name);
					$all_pocket_item_member = $this->model->recover_pocket_item_member();
					$this->view->__set("all_pocket_item_member",$all_pocket_item_member);
					$all_pocket_item_vehicle = $this->model->recover_pocket_item_vehicle();
					$this->view->__set("all_pocket_item_vehicle",$all_pocket_item_vehicle);
					
					
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
