<?php session_start();
    require 'connect.php';
    $req = $bd->prepare('UPDATE new_contact SET archive=1 WHERE new_contact.id=:id');
    $req->execute(array('id'=>$_POST['id']));
    $response = array();
    header('Content-Type: application/json');
    echo json_encode($response);
?>