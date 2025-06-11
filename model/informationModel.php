<?php
	class informationModel extends Model{
		public function title(){
			return "Informations";
		}	
		public function recover_group(){
			$req = new Request();
			return $req->recover_group();
		}
		public function recover_member_id_by_login($login){
			$req = new Request();
			return $req->recover_member_id_by_login($login);
		}
		public function add_information($id_author,$title,$group,$content){
			$req = new Request();
			return $req->add_information($id_author,$title,$group,$content);
		}
        public function update_information($id,$title,$content){
			$req = new Request();
			return $req->update_information($id,$title,$content);
		}
        public function delete_information($id){
			$req = new Request();
			return $req->delete_information($id);
		}
		public function recover_list_information(){
			$req = new Request();
			return $req->recover_list_information();
		}
	}
?>