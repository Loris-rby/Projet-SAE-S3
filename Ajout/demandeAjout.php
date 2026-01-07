<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./../style.css" />
        <title>MemoDeck : ajout</title>
    </head>
    <body>

        <?php
            require_once './../header.php';
        ?>

        <div id="pageAcceuil">

            <h1 class="centre">Ajout de mot</h1>

            <div class="blocInfo">
                <h3 class="centre"> Demande d'ajout</h3>

                <form id="formAjout" action="./creationDemande.php" method="GET">

                    <!-- Texte FR -->
                    <label for="texteFR">Écriture du mot en Français</label>
                    <input type="text" id="texteFR" name="texteFR"/><br><br>
                    
                    <!-- Texte EN -->
                    <label for="texteEN">Écriture du mot en Anglais</label>
                    <input type="text" id="texteEN" name="texteEN"/><br><br>

                    <!-- Texte FR -->
                    <label for="texteES">Écriture du mot en Espagnol</label>
                    <input type="text" id="texteES" name="texteES"/><br><br>

                    <!-- Select catégorie -->
                    <select name="" id="categSelect">
                        <?php
                            require_once './../fonctions.php';

                            // Récupérer toutes les categories pour la liste déroulante
                            $allCateg = get_all_categories();
                            $nbrCateg = count($allCateg);
                            for ($i = 0; $i<$nbrCateg; $i++){
                                $theCateg = $allCateg[$i];
                                echo "<option value='".$theCateg."'>";
                                echo $theCateg."</option>";
                            }
                        ?>
                    </select>

                    <!-- Ajouter catégorie -->
                    <button type="button" onclick="ajouterCategorie();">Ajouter Catégorie</button><br>
                    
                    <div id="categories"></div>
                    <!-- JS gestion catégories -->
                    <script>
                        var categChoisies = [];

                        function ajouterCategorie(){
                            var categSelect = document.getElementById("categSelect");
                            var categ = categSelect.value;

                            if( !categChoisies.includes(categ) ){
                                categChoisies.push(categ);

                                var input = document.createElement("input");
                                input.type = "text";
                                input.name = "categs[]";
                                input.classList.add('inputCateg')
                                input.readOnly = true;
                                //input.className = ""; // set the CSS class

                                input.value = categ;

                                var divCateg = document.getElementById("categories");
                                divCateg.appendChild(input); // put it into the DOM
                                divCateg.appendChild(document.createElement("br"));
                            }
                        }
                    </script>


                    <!-- Valider -->
                    <br><input type="submit" value="Demande l'ajout"/>
                </form>


                <?php
                    // message de validation de l'ajout de la demande
                    if(isset($_REQUEST['erreur'])){
                        echo '<p>Erreur d\'enregistrement de la demande du mot <b>"'.$_REQUEST['erreur'].'"</b></p><br>';
                    }
                    else if (isset($_REQUEST['valid'])){
                        echo '<p>Demande d\'ajout du mot <b>"'.$_REQUEST['valid'].'"</b> bien enregistrée !</p><br>';
                    }
                ?>

            </div>

            <div class="moyenLarge">
                <a class="alignRight" href="./../Admin/connectionAdmin.php">Connexion administrateur</a>
            </div>
                
        </div>

    </body>
</html>