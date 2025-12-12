<?php

if(isset($_REQUEST['identifiant'])){
    $identifiant = $_REQUEST['identifiant'];
}else{
    $identifiant = NULL;
}

if(isset($_REQUEST['mot2passe'])){
    $motDePasse = $_REQUEST['mot2passe'];
}else{
    $motDePasse = NULL;
}


if($identifiant == "Théo"){
    if($motDePasse == "mot2passe"){
        include("./pageAdmin.php");
    }else{
        echo '<script>window.location.replace("./connectionAdmin.php?erreur=mot2passe");</script>';
    }
}else{
    echo '<script>window.location.replace("./connectionAdmin.php?erreur=id");</script>';
}
    
?>