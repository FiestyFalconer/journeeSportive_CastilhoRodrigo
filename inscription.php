<?php
require_once './php/htmlToPhp.inc.php';

$submit = filter_input(INPUT_POST,'submit',FILTER_SANITIZE_STRING);
$message = "";

if($submit == "submit"){
    $nom = filter_input(INPUT_POST,'nomEleve',FILTER_SANITIZE_STRING);
    $prenom = filter_input(INPUT_POST,'prenomEleve',FILTER_SANITIZE_STRING);
    $classe = filter_input(INPUT_POST,'classe',FILTER_SANITIZE_STRING);

    $choix1 = filter_input(INPUT_POST,'choix1',FILTER_SANITIZE_STRING);
    $choix2 = filter_input(INPUT_POST,'choix2',FILTER_SANITIZE_STRING);
    $choix3 = filter_input(INPUT_POST,'choix3',FILTER_SANITIZE_STRING);
    /*******/
    var_dump($nom);
    
    if($nom == "" || $prenom == ""){
        $message = "le nom et le prenom sont obligatoires";
    }
    else{
        if($choix1 == $choix2 || $choix1 == $choix3 || $choix2 == $choix3){
            $message = "erreur";
        }
        else{

        }
    }
    
}
else if($submit == "annuler"){

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
    <h1>Inscription à la journée sportive du CFPT</h1>
    <form action="inscription.php" method="POST">

        <div>
            <label>Nom :</label>
            <input type="text" name="nomEleve">
        </div>

        <div>
            <label>Prenom :</label>
            <input type="text" name="prenomEleve">
        </div>

        <div>
            <label>Classe :</label>
            <select name="classe">
                <option value="ifa-p2a">IFA-P2A</option>
                <option value="ifa-p2b">IFA-P2B</option>
                <option value="ifa-p2c">IFA-P2C</option>
            </select>
        </div>

        <div>
            <p>---------------------------------------------------------</p>
        </div>

        <div>
            <label>Premier choix:</label>
            <?=afficherSelectActivites('choix1')?>
        </div>

        <div>
            <label>Deuxième choix:</label>
            <?=afficherSelectActivites('choix2')?>
        </div>

        <div>
            <label>Troisième choix:</label>
            <?=afficherSelectActivites('choix3')?>
        </div>

        <button type="submit" name="submit" value="submit">Confirmer</button>
        <button type="submit" name="submit" value="annuler">Annuler</button>

    </form>
    <p style="color: red;"><?=$message?></p>
</body>

</html>