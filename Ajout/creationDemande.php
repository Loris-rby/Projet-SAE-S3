
<?php

require_once './../fonctions.php';

$fr = $_REQUEST['texteFR'] ?? NULL;
$en = $_REQUEST['texteEN'] ?? NULL;
$es = $_REQUEST['texteES'] ?? NULL;
$categ = $_REQUEST['categories'] ?? [];

if($fr != NULL && $en != NULL && $es != NULL){
    ask_add_word($fr,$en,$es,$categ);
    $resultat = "?valid=".$fr;
}else{
    $resultat = "?erreur=".$fr;
}

echo '<script>window.location.replace("./demandeAjout.php'.$resultat.'");</script>';

?>
