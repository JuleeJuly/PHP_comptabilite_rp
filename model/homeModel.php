<?php
    class homeModel extends Model{
        public function title(){
            return "Accueil";
        }
        public function recover_payment_cartel(){
            $request = new Request();
			return $request->recover_payment_cartel();
        }
        public function recover_blanchi(){
            $request = new Request();
			return $request->recover_blanchi();
        }
        public function recover_payment_contract($enterprise){
            $request = new Request();
			return $request->recover_payment_contract($enterprise);
        }
        public function recover_all_sun($day_date){
            $request = new Request();
			return $request->recover_all_sun($day_date);
        }
        public function recover_sun($day_date){
            $request = new Request();
			return $request->recover_sun($day_date);
        }
        public function add_sun($sun,$date,$hour,$reason){
            $request = new Request();
			return $request->add_sun($sun,$date,$hour,$reason);
        }
        public function payment_cartel($id_cartel){
            $request = new Request();
			return $request->payment_cartel($id_cartel);
        }
        public function payment_blanchi($id_blanchi){
            $request = new Request();
			return $request->payment_blanchi($id_blanchi);
        }
        public function payment_contract($id_bennys){
            $request = new Request();
			return $request->payment_contract($id_bennys);
        }         
        public function recover_black_box(){
			$request = new Request();
			return $request->recover_black_box();
		}
		public function recover_detail_black_box(){
			$request = new Request();
			return $request->recover_detail_black_box();
		}
        public function recover_members(){
			$request = new Request();
			return $request->recover_members();
		}
        public function recover_nb_members(){
			$request = new Request();
			return $request->recover_nb_members();
		}
         public function recover_operation(){
			$request = new Request();
			return $request->recover_operation();
		}
        public function recover_days_war(){
			$request = new Request();
			return $request->recover_days_war();
		}
        public function recover_days_war_members(){
			$request = new Request();
			return $request->recover_days_war_members();
		}
        public function recover_total_days_war(){
            $request = new Request();
			return $request->recover_total_days_war();
        }
    }
?>