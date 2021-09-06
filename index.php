<?php
require_once "./php/htmlToPhp.inc.php";
$connecte = "Le utilisateur n'est pas connecté";

if($_SESSION['Login']){
    $connecte = "Vous êtes connecté en train de Admin";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Journee Sportive CFPT</h1>
    <h2><?=$connecte?></h2>
    <?= showAll(getClasses(),getActivites())?>


    
    <?php if($_SESSION['Login']){?>
    <a href="./inscription.php">Inscription</a>
    <a href="./deconnexion.php">Déconnexion</a>
    <?php }else{?>
    <a href="./login.php">Login</a>
    <?php }?>
</body>
</html>