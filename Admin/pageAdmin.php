<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./style.css" />
        <title>Admin</title>
    </head>
    <body>

        <div id="pageAcceuil">

            <span class="testLogo">Page admin</span><br>

            <div class="blocInfo">

                <h2>Demandes d'ajouts</h2>


                <ul>
                <?php

                    // recup fichier 
                    require_once './../fonctions.php';

                    // recup demandes
                    $lesDemandes = get_all_ask_words();

                    // afficher demandes
                    foreach ($lesDemandes as $demande){

                        $fr = $demande['fr'] ?? NULL;
                        $en = $demande['en'] ?? NULL;
                        $es = $demande['es'] ?? NULL;
                        $categ = $demande['categories'] ?? NULL;

                        echo "<li>";

                        echo "Français : ".$fr." , ";
                        echo "Anglais : ".$en." , ";
                        echo "Espagnol : ".$es." , ";

                        // refuser requette 
                        echo '<a href="./suprDemande.php?fr='.$fr.'">Refuser</a> ou ';

                        // valider requette 
                        echo '<a href="./ajouterMot.php?fr='.$fr.'&en='.$en.'&es='.$es.'">Valider</a>';

                        echo "</li>";
                    }

                ?>
                </ul>

                <?php
                    if (isset($_REQUEST['supr'])){
                        echo '<p>Demande d\'ajout du mot <b>"'.$_REQUEST['supr'].'"</b> bien suprimée.</p><br>';
                    }
                    if (isset($_REQUEST['valid'])){
                        echo '<p>Mot <b>"'.$_REQUEST['valid'].'"</b> bien ajouté à la base.</p><br>';
                    }
                ?>


            </div>
                
        </div>

    </body>
</html>