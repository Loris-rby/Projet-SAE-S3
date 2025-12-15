
<?php

require_once './../fonctions.php';

$fr = $_REQUEST['fr'] ?? NULL;

if($fr != NULL){
    if(delete_word($fr,'fr','_ask') ){
        $resultat = '?supr='.$fr;
    }else{
        $resultat = '?erreur='.$fr;
    }
}

echo '<script>window.location.replace("./pageAdmin.php'.$resultat.'");</script>';

?>
