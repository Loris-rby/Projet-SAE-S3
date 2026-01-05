
<?php

$identifiant = $_REQUEST['identifiant'];
$motDePasse = $_REQUEST['mot2passe'];

if($identifiant == "admin"){
    if($motDePasse == "Isanum64!"){

        require_once './../fonctions.php';

        $fr = $_REQUEST['fr'] ;

        if($fr != NULL){
            if(delete_word($fr,'fr','_ask') ){
                $resultat = '?supr='.$fr;
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
