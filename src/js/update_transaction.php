<?php session_start();
require 'connect.php';

/******FUNCTION******/

function recover_unit_dirty_price($bd,$price,$group,$item_id){
    switch($price){
    //tarif groupe sale
    case 0:
        $req = $bd->prepare('SELECT prix_sale FROM new_tarif_groupe_item WHERE id_groupe=:group and id_item=:id');
        $req->execute(array('group'=>$group,'id'=>$item_id));
        while($data = $req->fetch()){
            $unit_price = $data['prix_sale'];
        }
    break;
    //tarif rachat sale
    case 1:
        //recup idtarifrachat
        $id_tarif_rachat = 0;
        $req = $bd->prepare('SELECT id_tarif FROM new_structure WHERE id=:group');
        $req->execute(array('group'=>$group));
        while($data = $req->fetch()){
            $id_tarif_rachat = $data['id_tarif'];
        }
        $req = $bd->prepare('SELECT prix_sale FROM new_tarif_item WHERE id_tarif=:tarif and id_item=:id');
        $req->execute(array('tarif'=>$id_tarif_rachat,'id'=>$item_id));
        while($data = $req->fetch()){
            $unit_price = $data['prix_sale'];
        }
        break;
    }
    return $unit_price;
}

function recover_unit_own_price($bd,$price,$group,$item_id){
    switch($price){
        //tarif groupe propre
        case 0:
            $req = $bd->prepare('SELECT prix_propre FROM new_tarif_groupe_item WHERE id_groupe=:group and id_item=:id');
            $req->execute(array('group'=>$group,'id'=>$item_id));
            while($data = $req->fetch()){
                $unit_price = $data['prix_propre'];
            }
        break;
        //tarif rachat propre
        case 1:
            $id_tarif_rachat = 0;
            $req = $bd->prepare('SELECT id_tarif FROM new_structure WHERE id=:group');
            $req->execute(array('group'=>$group));
            while($data = $req->fetch()){
                $id_tarif_rachat = $data['id_tarif'];
            }
            $req = $bd->prepare('SELECT prix_propre FROM new_tarif_item WHERE id_tarif=:tarif and id_item=:id');
            $req->execute(array('tarif'=>$id_tarif_rachat,'id'=>$item_id));
            while($data = $req->fetch()){
                $unit_price = $data['prix_propre'];
            }
        break;
    }
    return $unit_price;
}

function update_account($bd,$order_id,$order_item_id){
    //On recupere l'id du membre payer et le groupe client
    $req = $bd->prepare('SELECT new_transaction.client,new_transaction.id_membre_payeur FROM new_transaction WHERE new_transaction.id=:id');
    $req->execute(array('id'=>$order_id));
    while($data = $req->fetch()){
        $member = $data['id_membre_payeur'];
        $group = $data['client'];
    }
    //On recupere les infos de la ligne de commande
    $req = $bd->prepare('SELECT * FROM new_transaction_item WHERE new_transaction_item.id=:id');
    $req->execute(array('id'=>$order_item_id));
    while($data = $req->fetch()){
        $dirty_own = $data['sale_propre'];
        $debit = $data['debit'];
        $credit = $data['credit'];
    }
    //Si c'est du propre, on met a jour le compte du membre
    if($dirty_own == "propre"){
        if($debit > 0){
            $type_account_management = 1;
            $amount = $debit;
        }else if($credit > 0){
            $type_account_management = 0;
            $amount = $credit;
        }
        $reason = "Structure_".$group."_".$order_item_id."";
        $req = $bd->prepare('INSERT INTO new_gestion_compte(id_membre,type,montant,data,raison,id_type_transac,type_transac) VALUES (:id_membre,:type,:montant,:data,:raison,:id_type_transac,:type_transac)');
        $req->execute(array('id_membre'=>$member,'type'=>$type_account_management,'montant'=>$amount,'data'=>date('Y-m-d'),'raison'=>$reason,'id_type_transac'=>$order_id,'type_transac'=>1));
        update_member_account($bd,$amount,$member,$type_account_management);
    }
}

function update_member_account($bd,$amount,$member,$type_account_management){
    //Mettre a jour le compte
    $req = $bd->prepare('SELECT * FROM new_membre WHERE new_membre.id=:id');
    $req->execute(array('id'=>$member));
    while($data = $req->fetch()){
        $account = $data['compte_total'];
        $black_box = $data['caisse_noir'];
    }
    switch($type_account_management){
        case 0:
            $all_account = $account-$amount;
            $all_black_box = $black_box-$amount;
        break;
        case 1:
            $all_account = $account+$amount;
            $all_black_box = $black_box+$amount;
        break;
    }
    $req = $bd->prepare('UPDATE new_membre SET compte_total=:total,caisse_noir=:caissenoir WHERE new_membre.id=:id');
    $req->execute(array('total'=>$all_account,'caissenoir'=>$all_black_box,'id'=>$member));
}

function update_order($bd,$order_id,$order_item_id){
    //on met a jour la commande
    $req = $bd->prepare('SELECT new_transaction_item.type,new_transaction_item.sale_propre,new_transaction_item.debit,new_transaction_item.credit,new_transaction_item.poids,new_transaction_item.id_transaction FROM new_transaction_item WHERE new_transaction_item.id_transaction=:order_id and new_transaction_item.id != :id and archive = 0');
    $req->execute(array('order_id'=>$order_id,'id'=>$order_item_id));
    $own_credit = 0;
    $own_debit = 0;
    $dirty_credit = 0;
    $dirty_debit = 0;
    $purchase_weight = 0;
    $sale_weight = 0;
    $own_total = 0;
    $dirty_total = 0;
    while($data = $req->fetch()){
        //sale
        if($data['sale_propre'] != "propre"){
            //achat
            if($data['type'] != "vente"){
                $dirty_credit += $data['credit'];
                $purchase_weight += $data['poids'];
            //vente
            }else{
                $dirty_debit += $data['debit'];
                $sale_weight += $data['poids'];
            }
        //propre
        }else{
            //achat
            if($data['type']  != "vente"){
                $own_credit += $data['credit'];
                $purchase_weight += $data['poids'];
            //vente
            }else{
                $own_debit += $data['debit'];
                $sale_weight += $data['poids'];
            }
        }
    }
    $own_total = $own_debit-$own_credit;
    $dirty_total = $dirty_debit-$dirty_credit;
    if($own_total < 0 ){
        $own_debit= 0;
        $own_credit = $own_total;
    }else if($own_total == 0){
        $own_debit = 0;
        $own_credit = 0;
    }else{
        $own_debit = $own_total;
        $own_credit = 0;
    }
    if($dirty_total < 0){
        $dirty_debit = 0;
        $dirty_credit = $dirty_total;
    }else if($dirty_total == 0){
        $dirty_debit = 0;
        $dirty_credit = 0;
    }else{
        $dirty_debit = $dirty_total;
        $dirty_credit = 0;
    }
    $req = $bd->prepare('UPDATE new_transaction SET debit_propre=:debit_propre,credit_propre=:credit_propre, debit_sale=:debit_sale, credit_sale=:credit_sale, poids_achat=:poids_achat,poids_vente=:poids_vente WHERE new_transaction.id=:id');
    $req->execute(array('debit_propre'=>$own_debit,'credit_propre'=>$own_credit,'debit_sale'=>$dirty_debit,'credit_sale'=>$dirty_credit,'poids_achat'=>$purchase_weight,'poids_vente'=>$sale_weight,'id'=>$order_id));
}

function archive_order($bd,$order_id){
    $req = $bd->prepare('UPDATE new_transaction SET archive=1 WHERE new_transaction.id=:id');
    $req->execute(array('id'=>$order_id));
}

function validate_order($bd,$order_id){
    $req = $bd->prepare('UPDATE new_transaction SET valide=1,heure_valide=:heure WHERE new_transaction.id=:id');
    $req->execute(array('heure'=>date( "H:i:s", time()),'id'=>$order_id));
}

function validate_order_item($bd,$order_item_id){
    $req = $bd->prepare('UPDATE new_transaction_item SET valide=1, heure_valide=:heure WHERE new_transaction_item.id=:id');
    $req->execute(array('heure'=>date( "H:i:s", time()),'id'=>$order_item_id));
}

/******TAITEMENT DES APPELS JS******/

if(isset($_POST['pocket_item'])){
    $id = $_POST['pocket_item'];
    $value = $_POST['value'];
    $req = $bd->prepare('UPDATE new_poche_item SET nom_item=:val WHERE new_poche_item.id=:id');
    $req->execute(array('val'=>$value,'id'=>$id));
}
if(isset($_POST['pocket_member_item'])){
    $id = $_POST['pocket_member_item'];
    $value = $_POST['value'];
    $req = $bd->prepare('UPDATE new_poche_item_membre SET quantite=:val WHERE new_poche_item_membre.id=:id');
    $req->execute(array('val'=>$value,'id'=>$id));
}
if(isset($_POST['pocket_vehicle_item'])){
    $id = $_POST['pocket_vehicle_item'];
    $value = $_POST['value'];
    $req = $bd->prepare('UPDATE new_poche_item_vehicule SET quantite=:val WHERE new_poche_item_vehicule.id=:id');
    $req->execute(array('val'=>$value,'id'=>$id));
}
//Calcul prix
if(isset($_POST['price_calculation'])){
    $amount = 0;
    $unit_price = 0;
    if(!empty($_POST['price_calculation']) && !empty($_POST['quantity'])){
        $price = $_POST['price'];
        $dirty_own = $_POST['dirty_own'];
        $bleaching_rate = $_POST['bleaching_rate'];
        $item_id = $_POST['price_calculation'];
        $quantity = $_POST['quantity'];
        $group = $_POST['group'];
        $purchase_sale = $_POST['purchase_sale'];
        //Si c'est ou blanchi(13) ou pas
        switch($iditem){
            case 13:
                $amount = $quantity*$bleaching_rate;
            break;
            default:
                switch($dirty_own){
                case "dirty":
                    $unit_price = recover_unit_dirty_price($bd,$price,$group,$item_id);
                break;
                case "own":
                    $unit_price = recover_unit_own_price($bd,$price,$group,$item_id);
                break;
            }
            $amount = $quantity*$unit_price;
            break;
        }
        $response = array('amount'=>$amount);
    }else{
        $response = array('amount'=>0);
    } 
}

// Calcul taux blanchi
if(isset($_POST['bleaching_rate'])){
    if(!empty($_POST['bleaching_rate'])){
        $item_id = $_POST['bleaching_rate'];
        $group = $_POST['group'];
        $purchase_sale = $_POST['purchase_sale'];
        $bleaching_rate = 0;
        //on recup item
        //si billet blanchi sinn rien
        if($item_id == 13){
            switch($purchase_sale){
                case "purchase":
                    $req = $bd->prepare('SELECT new_tarif.taux_blanchi as "tarif" FROM new_tarif,new_structure WHERE new_tarif.id = new_structure.id_tarif and new_structure.id=:group');
                    $req->execute(array('group'=>$group));
                    while($data = $req->fetch()){
                        $bleaching_rate = $data['tarif'];
                    }
                break;
                case "sale":
                    $req = $bd->prepare('SELECT new_structure.taux_blanchi as "tarif" FROM new_structure WHERE new_structure.id=:group');
                    $req->execute(array('group'=>$group));
                    while($data = $req->fetch()){
                        $bleaching_rate = $data['tarif'];
                    }
                break;
            }
            $response = array('bleaching_rate'=>$bleaching_rate);
        }else{
            $response = array('bleaching_rate'=>0);
        }
    }else{
        $response = array('bleaching_rate'=>0);
    }
}

//Calcul poids
if(isset($_POST['weight_calculation'])){
    if(!empty($_POST['quantity']) && !empty($_POST['weight_calculation'])){
        $item_id = $_POST['weight_calculation'];
        $quantity = $_POST['quantity'];
        $weight = 0;
        $req = $bd->prepare('SELECT new_item.poids as "poids" FROM new_item WHERE new_item.id=:id');
        $req->execute(array('id'=>$item_id));
        while($data = $req->fetch()){
            $weight = $data['poids'];
        }
        $total_weight = $weight*$quantity;
        $response = array('weight'=>$total_weight);
    }else{
        $response = array('weight'=>0);
    }
}

//valide la transaction
if(isset($_POST['order_validate'])){
    $order_item_id = $_POST['order_validate'];
    //On recupere l'ID de la commande
    $req = $bd->prepare('SELECT new_transaction_item.id_transaction,new_transaction_item.valide,new_transaction_item.archive FROM new_transaction_item WHERE new_transaction_item.id=:id');
    $req->execute(array('id'=>$order_item_id));
    while($data = $req->fetch()){
        $order_id = $data['id_transaction'];
        $valide_double = $data['valide'];
        $archive_double = $data['archive'];
    }
    $order_OK = 1;
    //On recupere les autres lignes de la commande
    $req = $bd->prepare('SELECT new_transaction_item.id,new_transaction_item.valide,new_transaction_item.archive FROM new_transaction_item WHERE new_transaction_item.id_transaction=:order_id and new_transaction_item.id != :id');
    $req->execute(array('order_id'=>$order_id,'id'=>$order_item_id));
    while($data = $req->fetch()){
        $id = $data['id'];
        //si une ligne n'est pas valide, on ne valide pas la commande
        if($data['valide'] == 0 && $data['archive'] == 0){
            $order_OK = 0;
        }
    }
    //on valide la ligne et la commande
    //On met a jour les comptes
    if($order_OK == 1 && $valide_double == 0 && $archive_double == 0){
        validate_order_item($bd,$order_item_id);
        validate_order($bd,$order_id);
        update_account($bd,$order_id,$order_item_id);
    }
    //on valide uniquement la ligne
    else if($valide_double == 0 && $archive_double == 0){
        validate_order_item($bd,$order_item_id);
    }
}

// SUPPRIME LA TRANSACTION
if(isset($_POST['order_delete'])){
    $order_item_id = $_POST['order_delete'];
    $req = $bd->prepare('SELECT new_transaction_item.valide,new_transaction_item.archive FROM new_transaction_item WHERE new_transaction_item.id=:id');
    $req->execute(array('id'=>$order_item_id));
    while($data = $req->fetch()){
        $valide_double = $data['valide'];
        $archive_double = $data['archive'];
    }
    if($valide_double == 0 && $archive_double == 0){
        //On archive la ligne
        $req = $bd->prepare('UPDATE new_transaction_item SET archive=1 WHERE new_transaction_item.id=:id');
        $req->execute(array('id'=>$order_item_id));
        //on recupere toutes les donnees de la ligne commande
        $req = $bd->prepare('SELECT new_transaction_item.type,new_transaction_item.sale_propre,new_transaction_item.debit,new_transaction_item.credit,new_transaction_item.poids,new_transaction_item.id_transaction FROM new_transaction_item WHERE new_transaction_item.id=:id');
        $req->execute(array('id'=>$order_item_id));
        while($data = $req->fetch()){
            $order_id = $data['id_transaction'];
        }
        //On verifie les autres lignes avec l'id transaction
        $valide = 0;
        $archive = 0;
        $encours = 0;
        $req = $bd->prepare('SELECT new_transaction_item.id,new_transaction_item.valide,new_transaction_item.archive FROM new_transaction_item WHERE new_transaction_item.id_transaction=:order_id and new_transaction_item.id != :id');
        $req->execute(array('order_id'=>$order_id,'id'=>$order_item_id));
        while($data = $req->fetch()){
            if($data['valide'] == 1){
                $valide = 1;
            }
            if($data['archive'] == 1){
                $archive = 1;
            }
            if($data['archive'] == 0 && $data['valide'] == 0){
                $encours = 1;
            } 
        }
        if($encours == 1){
            update_order($bd,$order_id,$order_item_id);
        }else if($valide == 1){
            update_order($bd,$order_id,$order_item_id);
            validate_order($bd,$order_id);
        }else if($archive == 1){
            archive_order($bd,$order_id);
        }else if($archive == 0 && $valide == 0 && $encours == 0){
            archive_order($bd,$order_id);
        }
    }
}

// Renvoyer la réponse au format JSON
header('Content-Type: application/json');
echo json_encode($response);
?>