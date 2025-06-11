<?php
    class Parameter {
        public function select_parameter() {
			$request = new Request();
			$req = $request->select_settings();
            return $req;          
        }
    }
?>