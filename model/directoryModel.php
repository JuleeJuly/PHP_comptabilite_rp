<?php
	class directoryModel extends Model{
        public function title(){
            return "Annuaire";
        }	
        public function recover_group_contact(){
            $req = new Request();
            return $req->recover_group_contact();
        }
        public function recover_structure_contact(){
            $req = new Request();
            return $req->recover_structure_contact();
        }
        public function recover_other_contact(){
            $req = new Request();
            return $req->recover_other_contact();
        }
    }
?>
