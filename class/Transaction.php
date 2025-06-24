<?php
    class Transaction{
        protected $id;
        public function __construct($id) {
            $this->id = $id;
        }
        public function recover_details() {
            $request = new Request();
            return $request->recover_transaction_details($this->id);
        }
    }
?>