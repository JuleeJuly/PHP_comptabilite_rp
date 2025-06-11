<?php
    class Connect {
        public function connect($login, $password) {
            $session_login = "";
			$session_status = "";
			$session_color = "";
			$param = new Parameter();
			$req = $param->select_parameter();
			while($data = $req->fetch()){
				$session_login = $data['session_login'];
				$session_status = $data['session_statut'];
				$session_color = $data['session_couleur'];
			}
            $request = new Request();
            $req = $request->select_identifiers($login);
			$result = $req->fetch();
			$exist = 0;
			if(empty($result['login']) || empty($result['password'])){
				$exist = 0;
			}
			else if(($result['login'] == $login) && password_verify($password,$result['password']) == true){
				$_SESSION[$session_login] = $result['login'];
				$_SESSION[$session_status] = $result['id_statut'];
				$_SESSION[$session_color] = $result['couleur'];
				$exist = 1;
            }
            return $exist;            
        }
        public function disconnect() {
            
        }
    }
?>