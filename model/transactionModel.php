<?php
    class transactionModel extends Model {
        public function title() {
            return "Transactions";
        }
        public function recover_members(){
            $request = new Request();
            return $request->recover_members();
        }
        public function recover_group(){
            $request = new Request();
            return $request->recover_group();
        }
        public function recover_items(){
            $request = new Request();
            return $request->recover_items();
        }
        public function delete_pocket(){
            $request = new Request();
            $request->delete_pocket();
        }
        public function recover_pocket_item_name(){
            $request = new Request();
            return $request->recover_pocket_item_name();
        }
        public function recover_pocket_item_member(){
            $request = new Request();
            return $request->recover_pocket_item_member();
        }
        public function recover_pocket_item_vehicle(){
            $request = new Request();
            return $request->recover_pocket_item_vehicle();
        }
    }
?>