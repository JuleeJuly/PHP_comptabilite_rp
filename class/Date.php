<?php
    class Date{
        public function calculate_date(){
            $date = date('Y-m-d');
			$effective_date = "";
			if(date("H", time()) < 3){
				$effective_date = date('Y-m-d', strtotime("-1 day"));
			}else{
				$effective_date = $date;
			}
            return $effective_date;
        }
    }
?>