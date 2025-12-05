<!DOCTYPE html>
<html>
    
    <head>
        <link rel="stylesheet" href="./style.css">
        <title>MD - Apprentissage par carte</title>
    </head>
    
    <body>
        <h1 class="centre">Apprentissage par carte</h1>
        <h3 class="centre">Concept :</h3>
        <p class="centre">Sur la carte vous allez avoir un mot et il va falloir trouver la traduction. Entrer la traduction dans le champs de texte et valider la réponse.</p>
        
        <?php
        // Pour inclure le fichier fonction.php et utiliser les fonctions de Loris sur la base
        require_once './../fonctions.php';
        ?>

        <!-- Pour choisir ce qu'on veut apprendre -->
        <div class="containerPersonalisation">
            <form method="GET">
                <label for="langueChoisie">Choisir une langue : </label>
                <select name="langue" id="langueChoisie">
                    <option value="1">FR-ENG</option>
                    <option value="2">FR-ESP</option>
                </select>
                
                <br>
                <label for="langueChoisie">Choisir un tag : </label>
                <select name="tag" id="tagChoisi">
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
                
                <!-- Valider les infos des listes déroulantes-->
                <input type="submit" value="Valider"/>
            </form>
        </div>

        

        <!-- Pour choisir aléatoirement un mot -->
        <?php
        $tableauMots = [["chien","dog","perro","animal"], ["chat","cat","gato","animal"], ["hello","bonjour","hola","salutation"], ["chaise","chair","silla","objet"], ["au revoir", "goodbye","adios","salutation"], ["gateau","cake","pastela","nourriture"]];
        // 1ere etape avec des valeurs déjà entrées
        $indexMot = array_rand($tableauMots);
        $leMot = $tableauMots[$indexMot];
        $motFR = $leMot[0];
        $motENG = $leMot[1];
        $motESP = $leMot[2];
        $motTag = $leMot[3];
        

        // Récupèrer un mot random de la base
        echo get_random_word();

        // Variables par défaut 
        $message = "";
            
        //echo $tag = $_GET['tag'];
    
        ?>



        
        <!-- Pour créer un container de la carte -->
        <div class="containerCarte">
            <!-- Pour créer la carte -->
            <div class="carte">
                <!-- Pour créer les cartes avant et arrière. Elles seront affichés / cachés dans le CSS -->
                <div class="carteAvant"><?php echo $motFR; ?></div>
                <div class="carteArriere"><?php echo $motENG; ?></div>
            </div>
        </div>
        
        
        <div class="containerReponse">
            <p>Entrer votre réponse : </p> 
            <input type="text" id="reponse" size="50">
            <button id="btnValider">Valider</button>      <!-- Un bouton simple plutot que valider car il ne fait pas que la page se recherche (sinon un nouveau mot sera choisit)-->  
            
            <form method="POST">
                <button type="submit" id="btnNext">Suivant</button>
            </form>
            
            <p id="message"></p>        <!-- Pour afficher un message réponse (fait dans le javaScript) -->
        </div>
        
        
        

        <!-- Balise javaScript, faite avec l'aide d'IA car on ne connait pas le JS -->
        <script>
            // Pour faire retourner la carte
            const carte = document.querySelector('.carte');     // récupère l'élément HTML <div class="carte">
            carte.addEventListener('click', () => {             // écoute le clic sur la carte
                carte.classList.toggle('is-flipped');           // ajoute la classe si elle n’y est pas, l’enlève si elle y est déjà
            });
            
            
            // Pour vérifier la réponse de l'utilateur
            let bonneRep = "<?php echo $motENG; ?>";  // Bonne réponse 
            
            // Quand le bouton est cliqué
            document.getElementById("btnValider").addEventListener("click", () => {
                const rep = document.getElementById("reponse").value.trim().toLowerCase();  // récupère l'élément HTML réponse de l'utili
                carte.classList.toggle('is-flipped');

                if (rep === bonneRep.toLowerCase()) {
                    // Afficher dans l'element avec l'id "message" le texte ... et mettre la couleur en ...
                    document.getElementById("message").textContent = "Bravo ! Bonne réponse";
                    document.getElementById("message").style.color = "green";
                } else {
                    // Afficher dans l'element avec l'id "message" le texte ... et mettre la couleur en ...
                    document.getElementById("message").textContent = "Mauvaise réponse, la bonne réponse était <?php echo $motENG; ?>";
                    document.getElementById("message").style.color = "red";
                }
            });
            
            
            /* 
            // Pour prendre un nouveau mot dans la liste
            const mots = ?php echo json_encode($tableauMots); ?>;      // Récupère le tableau de mot en JSON
            
            document.getElementById("btnNext").addEventListener("click", () => {
                // Tirer un mot aléatoire
                const index = Math.floor(Math.random() * mots.length);
                const nouveauMot = mots[index];

                // Mettre à jour la carte
                document.querySelector(".carteAvant").textContent = nouveauMot[0];
                document.querySelector(".carteArriere").textContent = nouveauMot[1];

                // Mettre à jour la bonne réponse
                bonneRep = nouveauMot[1];

                // Réinitialiser l'affichage
                document.getElementById("reponse").value = "";
                document.getElementById("message").textContent = "";
                carte.classList.remove('is-flipped'); // remets la carte à l'endroit
            });
            */
            
        </script>

        
    </body>
</html>