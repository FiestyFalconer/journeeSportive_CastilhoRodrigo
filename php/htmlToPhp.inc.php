<?php

session_start();
//creer la session
if(!isset($_SESSION['Nom'])){
    $_SESSION = [
        'Nom' => '',
        'Prenom' => '',
        'Classe' => '',
        'Choix1' => '',
        'Choix2' => '',
        'Choix3' => ''  
    ];
  }


//afficher les differents "selects"
function afficherSelectActivites($name){

    $select = "
            <select name='$name'>
                <option value='accrobranche'>Accrobranche</option>
                <option value='velo'>Vélo</option>
                <option value='football'>Football</option>
            </select>
    ";

    return $select;
}