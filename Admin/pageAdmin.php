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

                                $fr = $demande['fr'] ;
                                $en = $demande['en'] ;
                                $es = $demande['es'] ;
                                $categs = $demande['categories'] ;

                                echo "<div class='demandeAjout'>";

                                echo "<b>Français :</b> ".$fr.", ";
                                echo "<b>Anglais :</b> ".$en.", ";
                                echo "<b>Espagnol :</b> ".$es."<br>";

                                echo "<b>Catégories :</b> ";
                                foreach ($categs as $categ){
                                    echo $categ.", ";
                                }
                                echo "<br>";

                                // refuser requette 
                                echo '<a href="./suprDemande.php?fr='.$fr.'&identifiant='.$identifiant.'&mot2passe='.$motDePasse.'"><b>Refuser</b></a> ou ';

                                // valider requette 
                                echo '<a href="./ajouterMot.php?fr='.$fr.'&en='.$en.'&es='.$es.'&identifiant='.$identifiant.'&mot2passe='.$motDePasse;
                                foreach ($categs as $categ){
                                    echo '&categs[]='.$categ;
                                }
                                echo '"><b>Valider</b></a> ?';

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