<?php
require_once './php/htmlToPhp.inc.php';

$submit = filter_input(INPUT_POST,'submit',FILTER_SANITIZE_STRING);
$message = "";
$boolClasse = false;

if($submit == "submit"){
    $nomClasse = filter_input(INPUT_POST,'nouvelleClasse',FILTER_SANITIZE_STRING);

    if($nomClasse != ""){
        $tableau = getClasses();
        //voir si on a deja la meme classe dans la base de donnees
        foreach($tableau as $classe){
            if($classe['nomClasse'] == $nomClasse){
                $boolClasse = true;
            }
        }
    }
    else{
        $message = "ERREUR";
    }

    if($boolClasse){
        $message = "IL existe deja cette classe";
    }else{
        $message = "la classe a bien etais ajoutée";
        insertClasse($nomClasse);
    }

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
    <h1>Ajouter une nouvelle Classe</h1>

    <form action="ajouterClasse.php" method="POST">
        <div>
            <label>Nouvelle classe:</label>
            <input type="text" name="nouvelleClasse">
        </div>
        <button type="submit" name="submit" value="submit">Confirmer</button>

    </form>
    <p style="color: red;"><?=$message?></p>
    <div>
        <a href="./inscription.php">Aller a la page d'accuille</a>
    </div>
</body>

</html>