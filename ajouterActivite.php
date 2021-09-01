<?php
require_once './php/htmlToPhp.inc.php';

$submit = filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_STRING);
$message = "";
$boolActivite = true;

if ($submit == "submit") {
    $nomActivite = filter_input(INPUT_POST, 'nouvelleActivite', FILTER_SANITIZE_STRING);
    var_dump($nomActivite);
    if ($nomActivite != "") {
        echo "ddddd";
        $tableau = getActivites();
        //voir si on a deja la meme classe dans la base de donnees
        foreach ($tableau as $activite) {
            if ($activite['nomActivite'] == $nomActivite) {
                $boolClasse = false;
            }
        }
        if ($boolActivite) {
            $message = "IL existe deja cette activite";
        } else {
            $message = "la activite a bien etais ajoutée";
            insertActivite($nomActivite);
        }
    } else {
        $message = "ERREUR";
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
    <h1>Ajouter une nouvelle Activite</h1>
    <form method="POST" action="./ajouterActivite.php">
        <div>
            <label>Nouvelle activite:</label>
            <input type="text" name="nouvelleActivite">
        </div>

        <button type="submit" value="submit" name="submit">Confirmer</button>
    </form>
    <p style="color: red;"><?= $message ?></p>
    <div>
        <a href="./inscription.php">Aller a la page d'accuille</a>
    </div>

</body>

</html>