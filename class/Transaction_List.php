<?php
    class Transaction_List{
        protected $transaction_list = array();

        public function __construct() {
        }

        public function recover_number_of_transactions() {
            $request = new Request();
            $req = $request->recover_number_of_transactions();
            $data = $req->fetch();
            return $data['total'];
        }

        public function recover_transactions($first, $per_page, $sort){
            $request = new Request();
            switch($sort){
                case "date":
                    $orders = $request->recover_transactions_by_date($first, $per_page);
                    break;
                case "groupe":
                    $orders = $request->recover_transactions_by_group($first, $per_page);
                    break;
            }
            $array = array();
            while($data = $orders->fetch()){
                $id = $data['id'];
                $transaction = new Transaction($id);
                $details = $transaction->recover_details();
                $array[] = array(
                    "id" => $data['id'],
                    "client"  => $data['client'],
                    "debit_propre"  => $data['debit_propre'],
                    "poids_achat"  => $data['poids_achat'],
                    "data"  => $data['data'],
                    "heure"  => $data['heure'],
                    "valide"  => $data['valide'],
                    "commentaire"  => $data['commentaire'],
                    "archive"  => $data['archive'],
                    "credit_propre"  => $data['credit_propre'],
                    "id_client"  => $data['id_client'],
                    "heure_valide"  => $data['heure_valide'],
                    "debit_sale"  => $data['debit_sale'],
                    "credit_sale"  => $data['credit_sale'],
                    "poids_vente"  => $data['poids_vente'],
                    "id_membre_payeur"  => $data['id_membre_payeur'],
                    "prenom"  => $data['prenom'],
                    "couleur"  => $data['couleur'],
                    "details" => $details
                );
            }
            return $array;
        }
    }
?>