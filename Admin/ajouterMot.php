
<?php

$identifiant = $_REQUEST['identifiant'];
$motDePasse = $_REQUEST['mot2passe'];

if($identifiant == "admin"){
    if($motDePasse == "Isanum64!"){

        require_once './../fonctions.php';

        $fr = $_REQUEST['fr'] ?? NULL;
        $en = $_REQUEST['en'] ?? NULL;
        $es = $_REQUEST['es'] ?? NULL;
        $categs = $_REQUEST['categs'] ?? [];

        if($fr != NULL && $en != NULL && $es != NULL){

            if( add_word($fr,$en,$es,$categs) && delete_word($fr,'fr','_ask')){
                $resultat = '?add='.$fr;
            }else{
                $resultat = '?erreur='.$fr;
            }
        }

        echo '<script>window.location.replace("./pageAdmin.php'.$resultat.'&identifiant='.$identifiant.'&mot2passe='.$motDePasse.'");</script>';

    }else{
        echo '<script>window.location.replace("./connectionAdmin.php?erreur=mot2passe");</script>';
    }
}else{
    echo '<script>window.location.replace("./connectionAdmin.php?erreur=id");</script>';
}
?>
