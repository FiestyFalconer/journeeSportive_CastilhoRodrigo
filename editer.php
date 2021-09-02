<?php
require_once "./php/htmlToPhp.inc.php";

$id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
$act = filter_input(INPUT_GET,'act',FILTER_SANITIZE_STRING);
$submit = filter_input(INPUT_POST,'submit',FILTER_SANITIZE_STRING);

function boolAct($id,$act){
    $resultat = "";
    if($act == "true"){
        $resultat = getUneActivite($id)['nomActivite'];
    }
    else{
        $resultat = getUneClasse($id)['nomClasse'];
    }

    return $resultat;
}

if($submit == "submit"){

    $modif = filter_input(INPUT_POST,'modif',FILTER_SANITIZE_STRING);
    var_dump($modif);
    if($modif != "" || $modif != boolAct($id,$act)){
        if($act == "true"){
            
            modifierActivite($modif,$id);
        }
        else{
            modifierClasse($modif,$id);
        }
        header('Location: index.php');
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
    <h1>Editer</h1>

    <form method="POST" action="editer.php?id=<?=$id?>&act=<?=$act?>">
        
        <input type="text" value="<?=boolAct($id,$act)?>" name="modif">

        <button type="submit" value="submit" name="submit" >Confirmer</button>

    </form>



    <a href="./index.php">Retour</a>
</body>
</html>