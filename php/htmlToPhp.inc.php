<?php
require_once "database.php";

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

    $select = "<select name='$name'>";

    $tableau = getActivites();

    foreach ($tableau as $activites){
        $select .= "<option value=$activites[nomActivite]>$activites[nomActivite]</option>";
    }

    $select .= "</select>";

    return $select;
}

function afficherSelectClasses(){
    $select = "<select name='classe'>";

    $tableau = getClasses();

    foreach($tableau as $classes){
        $select .= "<option value=$classes[nomClasse]>$classes[nomClasse]</option>";
    }
    
    $select .= "</select>";
    
    return $select;
}

// avoir les differentes classes
function getActivites(){
    $query =  getConnexion()->prepare("
        SELECT `activite`.`nomActivite`
        FROM `journeesportive`.`activite`
    ");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// avoir les classes
function getClasses(){
    $query = getConnexion()->prepare("
        SELECT `classe`.`nomClasse`
        FROM `journeesportive`.`classe`
    ");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

//ajouter une classe dans la base de donnees
function insertClasse($nomClasse){
    $pdo = getConnexion();
    $query = $pdo->prepare("
        INSERT INTO `journeesportive`.`classe`
                    (`nomClasse`)
        Values            (?)
    ");
    $query->execute([$nomClasse]);
}