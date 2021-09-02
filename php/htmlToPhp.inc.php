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

//avoir les donnees de chatout le tableau
function getEleves(){
    $query = getConnexion()->prepare("
    SELECT `eleve`.`idEleve`, `eleve`.`nom`, `eleve`.`prenom`, `classe`.`nomClasse`, `activite`.`nomActivite`, `incription`.`ordrePref`
    from `journeesportive`.`eleve`, `journeesportive`.`classe`, `journeesportive`.`activite`, `journeesportive`.`incription`
    where  `incription`.`idEleve`= `eleve`.`idEleve`
    and `activite`.`idActivite` = `incription`.`idActivite`
    and `eleve`.`idClasse` = `classe`.`idClasse`
    order by `eleve`.`idEleve`
    ");
    $query->execute();
    return $query->fetchAll();
}

function showEleves($eleves){
    
    $tableau = "<table>
        <thead>
        <tr>
            <th>id</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Classe</th>
            <th>Activite</th>
            <th>Ordre de préférences</th>
        </tr>
        </thead>
        <tbody>
    ";

    foreach($eleves as $unEleve){
        $tableau.="
            <tr>
                <td>$unEleve[idEleve]</td>
                <td>$unEleve[nom]</td>
                <td>$unEleve[prenom]</td>
                <td>$unEleve[nomClasse]</td>
                <td>$unEleve[nomActivite]</td>
                <td>$unEleve[ordrePref]</td>
                <td><a href='./editer.php?id=$unEleve[idEleve]'>Editer</a></td>
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