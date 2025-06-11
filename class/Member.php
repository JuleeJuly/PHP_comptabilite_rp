<?php
    class Member{
        protected $id;
        protected $last_name;
        protected $first_name;
        protected $number;
        protected $present;
        protected $archive;
        protected $personnal_count;
        protected $group_account;
        protected $total_account;
        protected $appart;
        protected $owner;
        protected $grade;
        protected $cid;
        protected $date_of_birth;
        protected $photo;
        protected $color;
        protected $threshold_account;
        protected $display_home_account;

        public function __construct($id) {
            $this->id = $id;
            $request = new Request();
            $member_data = $request->recover_member_by_id($this->id);
            while($data = $member_data->fetch()) {
                $this->last_name = $data['nom'];
                $this->first_name = $data['prenom'];
                $this->number = $data['num'];
                $this->present = $data['present'];
                $this->archive = $data['archive'];
                $this->personnal_count = $data['compte_perso'];
                $this->group_account = $data['caisse_noir'];
                $this->total_account = $data['compte_total'];
                $this->appart = $data['id_appart'];
                $this->owner = $data['proprio'];
                $this->grade = $data['id_grade'];
                $this->cid = $data['cid'];
                $this->date_of_birth = $data['date_naissance'];
                $this->photo = $data['photo'];
                $this->color = $data['couleur'];
                $this->threshold_account = (int)$data['seuil_caisse_noir'];
                $this->display_home_account = $data['affiche_caisse_noir'];
            }
        }
        public function recover_total_criminal_record(){
            $day_date = date('Y-m-d');
            $request = new Request();
            $criminal_records = $request->recover_total_criminal_record($this->id, $day_date);
            while($data = $criminal_records->fetch()) {
                return $data['total'];
            }
        }
        public function recover_criminal_record(){
            $day_date = date('Y-m-d');
            $request = new Request();
            return $request->recover_criminal_record($this->id, $day_date);
        }
        public function update_color($color,$member_id){
            $this->color = $color;
            $request = new Request();
            $request->update_color($color,$member_id);
        }
        public function recover_personal_gains(){
            $request = new Request();
            return $request->recover_personal_gains($this->id);
        }
        public function recover_personal_expense(){
            $request = new Request();
            return $request->recover_personal_expense($this->id);
        }
        public function recover_all_personal_gains(){
            $request = new Request();
            return $request->recover_all_personal_gains($this->id);
        }
        public function recover_all_personal_expense(){
            $request = new Request();
            return $request->recover_all_personal_expense($this->id);
        }
        public function recover_all_personal_penalty(){
            $request = new Request();
            return $request->recover_all_personal_penalty($this->id);
        }
        public function recover_day_gains($date){
            $request = new Request();
            return $request->recover_day_gains($date,$this->id);
        }
        public function recover_day_expense($date){
            $request = new Request();
            return $request->recover_day_expense($date,$this->id);
        }

        public function get_last_name() {
            return $this->last_name;
        }
        public function get_first_name() {
            return $this->first_name;
        }
        public function get_number() {
            return $this->number;
        }
        public function get_present() {
            return $this->present;
        }
        public function get_archive() {
            return $this->archive;
        }
        public function get_personnal_count() {
            return $this->personnal_count;
        }
        public function get_group_account() {
            return $this->group_account;
        }
        public function get_total_account() {
            return $this->total_account;
        }
        public function get_appart() {
            return $this->appart;
        }
        public function get_owner() {
            return $this->owner;
        }
        public function get_grade() {
            return $this->grade;
        }
        public function get_cid() {
            return $this->cid;
        }
        public function get_date_of_birth() {
            return $this->date_of_birth;
        }
        public function get_photo() {
            return $this->photo;
        }
        public function get_color() {
            return $this->color;
        }
        public function get_threshold_account() {
            return $this->threshold_account;
        }
        public function get_display_home_account() {
            return $this->display_home_account;
        }
    }
?>