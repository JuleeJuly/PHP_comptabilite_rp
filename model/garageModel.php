<?php
	class garageModel extends Model{
        public function title(){
            return "Garage";
        }	
        public function recover_car_list(){
            $req = new Request();
            return $req->recover_car_list();
        }
        public function recover_garage(){
            $req = new Request();
            return $req->recover_garage();
        }
        public function recover_members(){
            $req = new Request();
            return $req->recover_members();
        }
        public function add_car($nom,$plate,$garage,$member){
            $req = new Request();
            return $req->add_car($nom,$plate,$garage,$member);
        }
    }
?>