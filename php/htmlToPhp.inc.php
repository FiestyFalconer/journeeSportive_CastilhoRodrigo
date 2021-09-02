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
        'Choix3' => '', 
    ];
}

//afficher les differents "selects" pour les activites
function afficherSelectActivites($name){

    $select = "<select name='$name'>";

    $tableau = getActivites();

    foreach ($tableau as $activites){
        $select .= "<option value=$activites[idActivite]>$activites[nomActivite]</option>";
    }

    $select .= "</select>";

    return $select;
}
//afficher toutes les classes
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
//avoir une seule activite
function getUneActivite($id){
    $query =  getConnexion()->prepare("
        SELECT `activite`.`idActivite`,`activite`.`nomActivite`
        FROM `journeesportive`.`activite`
        WHERE `activite`.`idActivite` = ?
    ");
    $query->execute([$id]);
    return $query->fetch(PDO::FETCH_ASSOC);
}
//avoir une classe
function getUneClasse($id){
    $query =  getConnexion()->prepare("
        SELECT `idClasse`, `nomClasse` 
        FROM `classe` 
        WHERE `idClasse` = ?
    ");
    $query->execute([$id]);
    return $query->fetch(PDO::FETCH_ASSOC);
}
//modifier une classe
function modifierClasse($nomClasse,$id){
    $query = getConnexion()->prepare("
        UPDATE `journeesportive`.`classe` 
        SET `classe`.`nomClasse`= ?
        WHERE `classe`.`idClasse` = ?
    ");
    $query->execute([$nomClasse,$id]);
}
//modifier une activite
function modifierActivite($nomActivite,$id){
    $query = getConnexion()->prepare("
        UPDATE `journeesportive`.`activite` 
        SET `activite`.`nomActivite`= ?
        WHERE `activite`.`idActivite` = ?
    ");
    $query->execute([$nomActivite,$id]);
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

function showAll($classes,$activites){
    
    $tableau = "<table>
        <thead>
        <tr>
            <th>id</th>
            <th>Classe</th>
        </tr>
        </thead>
        <tbody>
    ";

    foreach($classes as $uneClasse){
        $tableau.="
            <tr>
                <td>$uneClasse[idClasse]</td>
                <td>$uneClasse[nomClasse]</td>
                <td><a href='./editer.php?id=$uneClasse[idClasse]&act=false'>Editer</a></td>
                <td><a href='./editer.php?id=$uneClasse[idClasse]&act=false'>Effacer</a></td>
            </tr>
        ";
    }
    $tableau .= "<table>
    <thead>
    <tr>
        <th>id</th>
        <th>Activite</th>
    </tr>
    </thead>
    <tbody>
    ";

    foreach($activites as $uneActivite){
    $tableau.="
        <tr>
            <td>$uneActivite[idActivite]</td>
            <td>$uneActivite[nomActivite]</td>
            <td><a href='./editer.php?id=$uneActivite[idActivite]&act=true'>Editer</a></td>
            <td><a href='./editer.php?id=$uneActivite[idActivite]&act=true'>Effacer</a></td>
        </tr>
    ";
}
    $tableau.="</tbody></table>";

    return $tableau;

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

function insertEleve($nomEleve, $prenomEleve, $idClasse, $choix1, $choix2, $choix3){
    $pdo = getConnexion();
    $query = $pdo->prepare("
        INSERT INTO  `journeesportive`.`eleve`
                    (`nom`,`prenom`,`idClasse`)
        Values      (?,?,?)
    ");
    $query->execute([$nomEleve,$prenomEleve,$idClasse]);

    $last_id = $pdo->lastInsertId();
    
    $query = $pdo->prepare("
        INSERT INTO `journeesportive`.`incription`
                    (`idEleve`,`idActivite`,`ordrePref`)
        Values            (?,?,?)
    ");
    for($i = 0; $i<3; $i++){
        
        if($i == 0){
            $query->execute([$last_id, $choix1,1]);
        }
        else if($i == 1){
            $query->execute([$last_id, $choix2,2]);
        }
        else{
            $query->execute([$last_id, $choix3,3]);
        }

    }
   
}