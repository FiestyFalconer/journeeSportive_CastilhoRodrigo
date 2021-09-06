<?php
require_once "./php/htmlToPhp.inc.php";

$submit = filter_input(INPUT_POST,'envoyer',FILTER_SANITIZE_STRING);

if($submit == "submit"){
    $password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);
    $utilisateur = filter_input(INPUT_POST,'utilisateur',FILTER_SANITIZE_STRING);

    if($password != "" && $utilisateur != ""){

        var_dump($password);
        var_dump($utilisateur);

        var_dump(login($utilisateur,$password));
        
        if(login($utilisateur,$password)){
            echo "HELLO";
            $_SESSION['Login'] = true;
            header('location: index.php');
        }
    }
}
var_dump($_SESSION['Login']);
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
    <h1>Login</h1>
    <form action="./login.php" method="POST">

        <label>Nom utilisateur:</label>
        <input type="text" name="utilisateur">
        <br>
        <label>Mot de passe:</label>
        <input type="password" name="password">
        <br>
        <button type="submit" name="envoyer" value="submit">Envoyer</button>
    </form>
</body>
</html>