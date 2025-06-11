<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, inital-scale=1.0">
        <!--<meta http-equiv="refresh" content="300">-->
        <link rel="stylesheet" type="text/css" href="src/css/styles.css"/>
        <link rel="stylesheet" type="text/css" href="src/css/styles_mob.css"/>
        <?php 
            if(isset($_SESSION['couleur_comptatest'])){
                switch($_SESSION['couleur_comptatest']){
                    case "bleu":
                        echo '<link rel="stylesheet" type="text/css" href="src/css/bleu.css"/>';
                    break;
                    case "rouge":
                        echo '<link rel="stylesheet" type="text/css" href="src/css/rouge.css"/>';
                    break;
                    case "vert":
                        echo '<link rel="stylesheet" type="text/css" href="src/css/vert.css"/>';
                    break;
                    case "jaune":
                        echo '<link rel="stylesheet" type="text/css" href="src/css/jaune.css"/>';
                    break;
                    case "rose":
                        echo '<link rel="stylesheet" type="text/css" href="src/css/rose.css"/>';
                    break;
                    case "violet":
                        echo '<link rel="stylesheet" type="text/css" href="src/css/violet.css"/>';
                    break;
                    case "orange":
                        echo '<link rel="stylesheet" type="text/css" href="src/css/orange.css"/>';
                    break;
                    default:
                        echo '<link rel="stylesheet" type="text/css" href="src/css/bleu.css"/>';
                    break;
                }
            }
            else{
                echo '<link rel="stylesheet" type="text/css" href="src/css/bleu.css"/>';
            }
        ?>
        <!--<link rel="stylesheet" type="text/css" href="src/css/bleu.css"/>-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <link rel="icon" type="image/x-icon" href="src/other/icones/crane.png">
        <title><?php echo $data['title'];?></title>
    </head>
    <body>
        <input type="hidden" id="couleur" value="<?php echo $_SESSION['couleur_comptatest']?>">
