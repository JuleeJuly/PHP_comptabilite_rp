<?php
    class personalModel extends Model{
        public function title(){
            return "Perso";
        }
        public function recover_member_id_by_login($login){
            $req = new Request();
            $request = $req->recover_member_id_by_login($login);
            foreach($request as $member){
				return $member['id_membre'];
			}
        }		
    }
?>