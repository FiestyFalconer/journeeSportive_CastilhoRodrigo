<?php

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