<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./../style.css" />
        <title>Admin</title>
    </head>
    <body>

        <?php
            require_once './../header.php';
        ?>

        <div id="pageAcceuil">

            <span class="testLogo">Page admin</span><br>

            <div class="blocInfo">

                <h2>Demandes d'ajouts</h2>
                
                <ul>
                <?php

                    $identifiant = $_REQUEST['identifiant'];
                    $motDePasse = $_REQUEST['mot2passe'];

                    if($identifiant == "admin"){
                        if($motDePasse == "Isanum64!"){
                            
                            // recup fichier 
                            require_once './../fonctions.php';

                            // recup demandes
                            $lesDemandes = get_all_ask_words();

                            // afficher demandes
                            foreach ($lesDemandes as $demande){

                                
                                echo '<div class="boiteMot">';
                                echo "<p><b class='texteMedium'>{$demande['fr']}</b> (fr) <b class='texteMedium'>/ {$demande['en']}</b> (en) <b class='texteMedium'>/ {$demande['es']}</b> (es) </p>";
                                echo "<b class='texteMedium'> Catégories : </b>";
                                
                                foreach ($demande['categories'] as $categ){
                                    echo "<input class='petitInput' type='text' readOnly value='{$categ}' size='".strlen($categ)."'>";
                                }
                                echo '<br>';
                                

                                $fr = $demande['fr'] ;
                                $en = $demande['en'] ;
                                $es = $demande['es'] ;
                                $categs = $demande['categories'] ;

                                // refuser requette 
                                echo '<p><a href="./suprDemande.php?fr='.$fr.'&identifiant='.$identifiant.'&mot2passe='.$motDePasse.'"><b class="texteMedium">Refuser</b></a> ou ';

                                // valider requette 
                                echo '<a href="./ajouterMot.php?fr='.$fr.'&en='.$en.'&es='.$es.'&identifiant='.$identifiant.'&mot2passe='.$motDePasse;
                                foreach ($categs as $categ){
                                    echo '&categs[]='.$categ;
                                }
                                echo '"><b class="texteMedium">Valider</b></a> ?</p>';

                                echo "</div>";
                            }

                            
                
                            if (isset($_REQUEST['supr'])){
                                echo '<p>Demande d\'ajout du mot <b>"'.$_REQUEST['supr'].'"</b> bien suprimée.</p><br>';
                            }
                            if (isset($_REQUEST['valid'])){
                                echo '<p>Mot <b>"'.$_REQUEST['valid'].'"</b> bien ajouté à la base.</p><br>';
                            }


                        }else{
                            echo '<script>window.location.replace("./connectionAdmin.php?erreur=mot2passe");</script>';
                        }
                    }else{
                        echo '<script>window.location.replace("./connectionAdmin.php?erreur=id");</script>';
                    }
                ?>
                </ul>

            </div>
                
        </div>

    </body>
</html>