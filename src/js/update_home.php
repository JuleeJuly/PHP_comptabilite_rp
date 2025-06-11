<?php session_start();
    require 'connect.php';
    /*****Selon le type d'action à effectuer*****/
    $action = $_POST['action'];
    if($action == "update_present"){
        $req = $bd->prepare('UPDATE new_membre SET present=:present WHERE new_membre.id=:id');
        $req->execute(array('present'=>$_POST['value'], 'id'=>$_POST['id_member'])); 
        /*****Vérification de l'appart: ouvert ou fermé*****/
        $open = 0;
        $id_appart = 0;
        $req = $bd->prepare('SELECT id_appart FROM new_membre WHERE new_membre.id =:id');
        $req->execute(array('id'=>$_POST['id_member']));
        while($donnees = $req->fetch()){
            $id_appart = $donnees['id_appart'];
        }
        /*****Selon value, on ouvre ou ferme l'appart*****/
        switch($value){
            case 0:
                $req = $bd->prepare('SELECT id FROM new_membre WHERE id_appart =:id_appart and present = 1 and new_membre.archive = 0');
                $req->execute(array('id_appart'=>$id_appart));
                while($data = $req->fetch()){
                    $open = 1;
                }
            break;
            case 1:
                $open = 1;
            break;
        }
        /*****Mise a jours de l'appart : ouvert ou fermé*****/
        $req = $bd->prepare('UPDATE new_appart SET ouvert=:open WHERE new_appart.id=:id_appart');
        $req->execute(array('open'=>$open, 'id_appart'=>$id_appart));
        $response = array();
    }
    else if($action == "update_operation"){
        $req = $bd->prepare('UPDATE new_operation SET id_content=:val WHERE new_operation.id=:id');
        $req->execute(array('val'=>$_POST['value'], 'id'=>$_POST['id_operation']));
        $response = array();
    }
    else if($action == "delete_sun"){
        $req = $bd->prepare('DELETE FROM new_soleil WHERE new_soleil.id=:id');
        $req->execute(array('id'=>$_POST['id_sun']));
        $response = array();
    }
    else if($action == "update_present_day_war_text"){
        $req = $bd->prepare('UPDATE new_jour_presence_nom SET nom=:val WHERE new_jour_presence_nom.id_jour=:id');
        $req->execute(array('val'=>$POST['value'], 'id'=>$POST['id_day'])); 
        $response = array();
    }
    else if($action == "update_present_day_war"){
        $id_day_presence = $_POST['id_day_presence'];
        $value = $_POST['value'];
        $moment = $_POST['moment'];
        $id_day = $_POST['id_day'];
        $total = 0;
        switch($moment){
            //apres midi
            case 1 : 
            $req = $bd->prepare('UPDATE new_jour_presence SET apres_midi=:valeur WHERE new_jour_presence.id=:id');
            $req->execute(array('valeur'=>$value, 'id'=>$id_day_presence));
            $req = $bd->prepare('SELECT SUM(apres_midi) as "apres_midi" FROM new_jour_presence WHERE id_jour=:jour ');
            $req->execute(array('jour'=>$id_day));
            while($data = $req->fetch()){
                $total = $data['apres_midi'];
            }
            break;
            //soir
            case 2 :
            $req = $bd->prepare('UPDATE new_jour_presence SET soir=:valeur WHERE new_jour_presence.id=:id');
            $req->execute(array('valeur'=>$value, 'id'=>$id_day_presence)); 
            $req = $bd->prepare('SELECT SUM(soir) as "soir" FROM new_jour_presence WHERE id_jour=:jour ');
            $req->execute(array('jour'=>$id_day));
            while($data = $req->fetch()){
                $total = $data['soir'];
            }
            break;
        }
        $response = array('total'=>$total);
    }
    
    // Renvoyer la réponse au format JSON
    header('Content-Type: application/json');
    echo json_encode($response);
?>