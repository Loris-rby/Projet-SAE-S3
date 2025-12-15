
<?php

require_once './../fonctions.php';

$fr = $_REQUEST['fr'] ?? NULL;
$en = $_REQUEST['en'] ?? NULL;
$es = $_REQUEST['es'] ?? NULL;
$categ = $_REQUEST['categories'] ?? [];

if($fr != NULL && $en != NULL && $es != NULL){

    if( add_word($fr,$en,$es,$categ) && delete_word($fr,'fr','_ask')){
        $resultat = '?add='.$fr;
    }else{
        $resultat = '?erreur='.$fr;
    }
}

echo '<script>window.location.replace("./pageAdmin.php'.$resultat.'");</script>';

?>
