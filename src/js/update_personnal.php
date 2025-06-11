<?php session_start();
require 'connect.php';
// Récupérer les données envoyées via Ajax
if(isset($_POST['delete_gains'])){
    $req = $bd->prepare('UPDATE new_recel_perso SET archive=1 WHERE id=:id');
    $req->execute(array('id'=>$_POST['delete_gains']));
}
else if(isset($_POST['delete_expense'])){
    $req = $bd->prepare('UPDATE new_depense_perso SET archive=1 WHERE id=:id');
    $req->execute(array('id'=>$_POST['delete_expense']));
}
else{
    $effective_date = "";
    if((date("H", time())) < 3){
        $effective_date = date('Y-m-d', strtotime("-1 day"));
    }
    else{
        $effective_date = date('Y-m-d');
    }
    if($_POST['value'] > 0){
        switch($_POST['id']){
            case "1":
            case "2":
            case "6":
                $req = $bd->prepare('INSERT INTO new_depense_perso(id_membre,montant,data,heure,type,data_effective) VALUES (:id_membre,:montant,:data,:heure,:type,:data_effective)');
                $req->execute(array('id_membre'=>$_POST['member_id'],'montant'=>$_POST['value'],'data'=>date('Y-m-d'),'heure'=>date("H:i:s", time()),'type'=>$_POST['id'],'data_effective'=>$effective_date));
            break;
            default:
                //recup les prix actuel
                $own_money_value = 0;
                $dirty_money_value = 0;
                $bleaching_rate = 0;
                $req = $bd->prepare('SELECT * FROM new_tarif_item_business WHERE id_item=:id');
                $req->execute(array('id'=>$_POST['id'])); 
                while($data = $req->fetch()){
                    $dirty_money_value = $data['prix_sale'];
                }
                $req = $bd->prepare('SELECT taux_blanchi FROM new_tarif_business');
                $req->execute();
                while($data = $req->fetch()){
                    $bleaching_rate = $data['taux_blanchi'];
                }
                $own_money_value = $dirty_money_value*$bleaching_rate;
                $req = $bd->prepare('INSERT INTO new_recel_perso(id_membre,id_item,quantite,data,heure,valeur_propre,valeur_sale,data_effective) VALUES (:id_membre,:id_item,:quantite,:data,:heure,:valeur_propre,:valeur_sale,:data_effective)');
                $req->execute(array('id_membre'=>$_POST['member_id'],'id_item'=>$_POST['id'],'quantite'=>$_POST['value'],'data'=>date('Y-m-d'),'heure'=>date("H:i:s", time()),'valeur_propre'=>$own_money_value,'valeur_sale'=>$dirty_money_value,'data_effective'=>$effective_date)); 
            break;
        }
    }  
}
// Construire la réponse JSON
$response = array();
// Renvoyer la réponse au format JSON
header('Content-Type: application/json');
echo json_encode($response);
?>