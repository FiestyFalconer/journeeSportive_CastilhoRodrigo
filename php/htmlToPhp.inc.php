<?php
require_once "database.php";

session_start();
//creer la session
if(!isset($_SESSION['Nom'])){
    $_SESSION = [
        'Nom' => '',
        'Prenom' => '',
        'Classe' => '',
        'choix1' => '',
        'choix2' => '',
        'choix3' => ''  
    ];
}

//afficher les differents "selects"
function afficherSelectActivites($name){

    $select = "<select name='$name'>";

    $tableau = getActivites();

    foreach ($tableau as $activites){
        $select .= "<option value=$activites[idActivite]>$activites[nomActivite]</option>";
    }

    $select .= "</select>";

    return $select;
}

function afficherSelectClasses(){
    $select = "<select name='classe'>";

    $tableau = getClasses();

    foreach($tableau as $classes){
        $select .= "<option value=$classes[idClasse]>$classes[nomClasse]</option>";
    }
    
    $select .= "</select>";
    
    return $select;
}

// avoir les differentes classes
function getActivites(){
    $query =  getConnexion()->prepare("
        SELECT `activite`.`idActivite`,`activite`.`nomActivite`
        FROM `journeesportive`.`activite`
    ");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// avoir les classes
function getClasses(){
    $query = getConnexion()->prepare("
        SELECT `classe`.`idClasse`,`classe`.`nomClasse`
        FROM `journeesportive`.`classe`
    ");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function getEleves(){
    $query = getConnexion()->prepare("
    SELECT `eleve`.`idEleve`, `eleve`.`nom`, `eleve`.`prenom`, `classe`.`nomClasse`, `activite`.`nomActivite`, `incription`.`ordrePref`
    from `journeesportive`.`eleve`, `journeesportive`.`classe`, `journeesportive`.`activite`, `journeesportive`.`incription`
    where `eleve`.`idClasse` = `classe`.`idClasse`
    and `eleve`.`idEleve`= `incription`.`idEleve`
    and `activite`.`idActivite` = `incription`.`idActivite`
    ");
    $query->execute();
    return $query->fetchAll();
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

//ajouter une activite a la base de donnees
function insertActivite($nomActivite){
    $pdo = getConnexion();
    $query = $pdo->prepare("
        INSERT INTO `journeesportive`.`activite`
                    (`nomActivite`)
        Values          (?)
    ");
    $query->execute([$nomActivite]);
}

function insertEleve($nomEleve, $prenomEleve, $idClasse, $idActivite, $choix1, $choix2, $choix3){
    $pdo = getConnexion();
    $query = $pdo->prepare("
        INSERT INTO  `journeesportive`.`eleve`
                    (`nom`,`prenom`,`idClasse`)
        Values      (?,?,?)
    ");
    $query->execute([$nomEleve,$prenomEleve,$idClasse]);

    for($i = 0; $i<3; $i++){
        $query = $pdo->prepare("
        INSERT INTO `journeesportive`.`incription`
                    (`idEleve`,`idActivite`,`ordrePref`)
                    (lastInsertId,?,?)
        ");
        if($i == 0){
            $query->execute([$idActivite,$choix1]);
        }
        else if($i == 1){
            $query->execute([$idActivite,$choix2]);
        }
        else{
            $query->execute([$idActivite,$choix3]);
        }

    }
   
}