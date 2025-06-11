<?php
    class Car{
        protected $id;
        protected $name;
        protected $plate;
        protected $member;
        protected $garage;

        public function __construct($id) {
            $this->id = $id;
            $request = new Request();
            $car_data = $request->recover_car_by_id($this->id);
            while($data = $car_data->fetch()) {
                $this->name = $data['nom'];
                $this->plate = $data['plaque'];
                $this->member = $data['id_membre'];
                $this->garage = $data['id_garage'];
            }
        }
        public function get_name() {
            return $this->name;
        }
        public function get_plate() {
            return $this->plate;
        }
        public function get_member() {
            return $this->member;
        }
        public function get_garage() {
            return $this->garage;
        }
        public function update_car($id,$name, $plate, $member, $garage) {
            $this->id = $id;
            $this->name = $name;
            $this->plate = $plate;
            $this->member = $member;
            $this->garage = $garage;
            $request = new Request();
            $request->update_car($this->id, $name, $plate, $member, $garage);
        }
        public function delete_car() {
            $request = new Request();
            $request->delete_car($this->id);
        }
    }
?>