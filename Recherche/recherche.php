<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./../style.css" />
        <title>MemoDeck : recherche</title>
    </head>
    <body>

        <?php
            require_once './../header.php';
        ?>

        <div id="pageAcceuil">

            <span class="testLogo">Recherche</span><br>

            <!-- PHP setup -->
            <?php 
                require_once './../fonctions.php';

                try{
                    $texteRecherche = $_REQUEST['texteRecherche'] ?? null ;
                    $langueRecherche = $_REQUEST['langueRecherche'] ?? "fr" ;
                    $categRecherche = $_REQUEST['categRecherche'] ?? null ;
                    if($categRecherche == "TOUTES"){
                        $categRecherche = null;
                    }
                }catch( Exception $e ){}
            ?>

            <div class="blocInfo">
                <h2>Recherche</h2>

                <form action="./recherche.php" method="GET">

                    <!-- Texte à chercher -->
                    <input class="moyenLarge" type="text" id="texteRecherche" name="texteRecherche"/><br>
                    
                    <!-- Select langue pour recherche -->
                    <select name="langueRecherche" id="langueRecherche">
                        <option value="fr" <?php if($langueRecherche=="fr") echo "selected"?> >Français</option>
                        <option value="en" <?php if($langueRecherche=="en") echo "selected"?> >Anglais</option>
                        <option value="es" <?php if($langueRecherche=="es") echo "selected"?> >Espagnol</option>
                    </select>

                    <!-- Select avec toutes catégories -->
                    <select name="categRecherche" id="categRecherche">
                        <option value="TOUTES" >N'importe quelle catégorie</option>
                        <?php
                            // Récupérer toutes les categories pour la liste déroulante
                            $allCateg = get_all_categories();
                            $nbrCateg = count($allCateg);
                            for ($i = 0; $i<$nbrCateg; $i++){
                                $theCateg = $allCateg[$i];
                                echo "<option value='".$theCateg;
                                echo "'>";
                                echo $theCateg."</option>";
                            }
                        ?>
                    </select>

                    <!-- Valider -->
                    <input type="submit" value="🔍"/>
                </form>

            </div>

            <!-- PHP récup choix utilisateur & mots voulu dans base donnée -->
            <?php
                $mots = get_dictionary_words($texteRecherche, $langueRecherche, $categRecherche); 
            ?>

            <div class="blocInfo">
                <h2>Résultat</h2>
                <ul>
                        <!-- PHP affiche mots trouvés -->
                        <?php 
                            foreach ($mots as $leMot) {
                                echo "-> FR: {$leMot['fr']}, EN: {$leMot['en']}<br>";
                            }
                        ?>
                        
                </ul>
            </div>

            
                
        </div>

    </body>
</html>