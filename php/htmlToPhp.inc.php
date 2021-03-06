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
        'Login' => false
    ];
}

//afficher les differents "selects" pour les activites
function afficherSelectActivites($name){
    try{
        $select = "<select name='$name'>";

        $tableau = getActivites();

        foreach ($tableau as $activites){
            $select .= "<option value=$activites[idActivite]>$activites[nomActivite]</option>";
        }

        $select .= "</select>";

        return $select;
    }catch(Exception $e){
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
    }
    
}
//afficher toutes les classes
function afficherSelectClasses(){
    try{
        $select = "<select name='classe'>";

        $tableau = getClasses();

        foreach($tableau as $classes){
            $select .= "<option value=$classes[idClasse]>$classes[nomClasse]</option>";
        }
    
        $select .= "</select>";
    
        return $select;
    }
    catch(Exception $e){
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
    }
}

// avoir les differentes classes
function getActivites(){
    try{
        $query =  getConnexion()->prepare("
            SELECT `activite`.`idActivite`,`activite`.`nomActivite`
            FROM `journeesportive`.`activite`
        ");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e){
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
    }
}
//avoir une seule activite
function getUneActivite($id){
    try{
        $query =  getConnexion()->prepare("
            SELECT `activite`.`idActivite`,`activite`.`nomActivite`
            FROM `journeesportive`.`activite`
            WHERE `activite`.`idActivite` = ?
        ");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e){
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
    }
}
//avoir une classe
function getUneClasse($id){
    try{
        $query =  getConnexion()->prepare("
            SELECT `idClasse`, `nomClasse` 
            FROM `classe` 
            WHERE `idClasse` = ?
        ");
    $query->execute([$id]);
    return $query->fetch(PDO::FETCH_ASSOC);
    }catch(PDOException $e){
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
    }
}
//modifier une classe
function modifierClasse($nomClasse,$id){
    try{
        $query = getConnexion()->prepare("
            UPDATE `journeesportive`.`classe` 
            SET `classe`.`nomClasse`= ?
            WHERE `classe`.`idClasse` = ?
        ");
        $query->execute([$nomClasse,$id]);
    }catch(PDOException $e){
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
    }
    
}
//modifier une activite
function modifierActivite($nomActivite,$id){
    try{
        $query = getConnexion()->prepare("
            UPDATE `journeesportive`.`activite` 
            SET `activite`.`nomActivite`= ?
            WHERE `activite`.`idActivite` = ?
        ");
        $query->execute([$nomActivite,$id]);
    }
    catch(PDOException $e){
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
    }
}
//effacer la classe choisi
function deleteClasse($id){
    try{
        $pdo = getConnexion();
        $query = $pdo->prepare("
            DELETE FROM `incription` 
            WHERE (SELECT `eleve`.`idClasse` FROM `eleve` WHERE `idClasse` = ?);
        ");
        $query->execute([$id]); 
        
        $query = $pdo->prepare("
            DELETE FROM `eleve`
            WHERE `eleve`.`idClasse` = ?
        ");
        $query->execute([$id]); 
        
        $query = $pdo->prepare("
            DELETE FROM `classe`
            WHERE `classe`.`idClasse` = ?
        ");
        $query->execute([$id]);    
    }
    catch(PDOException $e){
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
    } 
}
//effacer la activite choisi
function deleteActivite($id){
    try{
        $pdo = getConnexion();
            
        $query = $pdo->prepare("
            DELETE FROM `incription`
            WHERE `incription`.`idActivite` = ?
        ");
        $query->execute([$id]); 
            
        $query = $pdo->prepare("
            DELETE FROM `activite`
            WHERE `activite`.`idActivite` = ?
        ");
        $query->execute([$id]);    
    }catch(PDOException $e){
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
    }
    
        
}

// avoir les classes
function getClasses(){
    try{
        $query = getConnexion()->prepare("
            SELECT `classe`.`idClasse`,`classe`.`nomClasse`
            FROM `journeesportive`.`classe`
        ");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e){
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
    }
    
}
//montrer les classes et les activites
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
        if($_SESSION['Login']){
            $tableau.="
            <tr>
                <td>$uneClasse[idClasse]</td>
                <td>$uneClasse[nomClasse]</td>
                <td><a href='./editer.php?id=$uneClasse[idClasse]&act=false'>Editer</a></td>
                <td><a href='./effacer.php?id=$uneClasse[idClasse]&act=false'>Effacer</a></td>
            </tr>
            ";
        }
        else{
            $tableau.="
                <tr>
                <td>$uneClasse[idClasse]</td>
                <td>$uneClasse[nomClasse]</td>
                </tr>
             ";
        }
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
        if($_SESSION['Login']){
            $tableau.="
                <tr>
                    <td>$uneActivite[idActivite]</td>
                    <td>$uneActivite[nomActivite]</td>
                    <td><a href='./editer.php?id=$uneActivite[idActivite]&act=true'>Editer</a></td>
                    <td><a href='./effacer.php?id=$uneActivite[idActivite]&act=true'>Effacer</a></td>
                </tr>
            ";
        }else{
            $tableau.="
                <tr>
                    <td>$uneActivite[idActivite]</td>
                    <td>$uneActivite[nomActivite]</td>
                </tr>
            ";
        }
    }
    $tableau.="</tbody></table>";

    return $tableau;

}

//ajouter une classe dans la base de donnees
function insertClasse($nomClasse){
    try{
        $pdo = getConnexion();
        $query = $pdo->prepare("
            INSERT INTO `journeesportive`.`classe`
                       (`nomClasse`)
            Values            (?)
        ");
        $query->execute([$nomClasse]);
    }
    catch(PDOException $e){
       echo 'Exception reçue : ',  $e->getMessage(), "\n";
    }
}

//ajouter une activite a la base de donnees
function insertActivite($nomActivite){
    try{
        $pdo = getConnexion();
        $query = $pdo->prepare("
            INSERT INTO `journeesportive`.`activite`
                    (`nomActivite`)
            Values          (?)
        ");
        $query->execute([$nomActivite]);
    }
    catch(PDOException $e){
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
    }
}
//avoir les eleves de la table
function getEleves_id($pdo, $prenomEleve, $nomEleve){
    $pdo = getConnexion();
    $query = $pdo->prepare("
        SELECT `eleve`.`idEleve` 
        FROM `journeesportive`.`eleve`
        WHERE `eleve`.`nom` = ?
        AND `eleve`.`prenom` = ?
    ");

    if($query->execute([$nomEleve, $prenomEleve])){
        $row = $query->fetch(PDO::FETCH_ASSOC);

        return $row !== false ? $row['idEleve'] : false;
    }

    return false;
}

function getPassword($utilisateur){
    try{
    $pdo = getConnexion();
    $query = $pdo->prepare("
        SELECT  `utilisateurs`.`password`
        FROM `journeesportive`.`utilisateurs`
        WHERE `utilisateurs`.`pseudo` = ?
    ");
    $query->execute([$utilisateur]);
    return $query->fetch(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e){
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
    }
}

function login($utilisateur, $password){
    var_dump(getPassword($utilisateur));
    var_dump($utilisateur);
    if(getPassword($utilisateur)){
        $hashPassword = password_verify($password,getPassword($utilisateur)['password']);

        if($hashPassword){
            return true;
        }
    }
    return false;
}


//ajouter un eleve avec les choix quil a choisi
function insertEleve( $nomEleve, $prenomEleve, $idClasse, $choix1, $choix2, $choix3){

    try{
        $pdo = getConnexion();
        $pdo->beginTransaction();

        $eleve_id = getEleves_id($pdo, $prenomEleve, $nomEleve);

        var_dump($eleve_id);
        //si ele
        if($eleve_id == false){

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

            $pdo->commit();
        }
    }
    catch(PDOException $e){
        $pdo->rollBack();

        echo 'Exception reçue : ',  $e->getMessage(), "\n";
    }
}