<?php
require_once "./php/htmlToPhp.inc.php";

$id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
$act = filter_input(INPUT_GET,'act',FILTER_SANITIZE_STRING);

if($act == "true"){
    deleteActivite($id);

}else{
    deleteClasse($id);
}

header('Location: index.php');