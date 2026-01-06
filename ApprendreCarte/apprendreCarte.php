<!DOCTYPE html>

<html>
    <head>
        <title>MD - Apprentissage par carte</title>
        <link rel="stylesheet" href="./../style.css">
    </head>


    <body>

        <!------------------------------------- PARTIE PHP 1 ---------------------------------------
         1. Démarrer une session pour le score
         2. Récupérer le header
         3. Lier le fichier fonctions.php de Loris pour manipuler les fonctions déjà faite sur la base de données
         4. Récupérer le score envoyé à php après le rechargement de la page
         5. Récupérer le score dans une variable pour l'afficher
         6. Valeurs par défaut pour les listes déroulantes
        -->
        <?php
        // Pour démarrer une session & lier fonctions.php
        session_start();
        require_once './../fonctions.php';
        require_once './../header.php';

        // Récupérer le score par PHP
        if(isset($_POST['score'])){
            $_SESSION['score'] = (int)$_POST['score'];
        }
        $currentScore = $_SESSION['score'] ?? 0;


        // Valeurs par défaut
        $langue = $_SESSION['langue'] ?? 1;
        $tag = $_SESSION['tag'] ?? 'rien';

        // Si le formulaire est soumis, on met à jour les valeurs
        if (isset($_GET['langue'])) {
            $langue = (int) $_GET['langue'];
            $_SESSION['langue'] = $langue;
        }

        if (isset($_GET['tag'])) {
            $tag = $_GET['tag'];
            $_SESSION['tag'] = $tag;
        }

        // Récupérer toutes les catégories pour la liste déroulante
        $allCateg = get_all_categories();
        ?>





        <!------------------------------------- PARTIE HTML 1 ---------------------------------------
         Afficher le texte en haut
        -->
        <h1 class="centre">Apprentissage par carte</h1>

        <div class="moyenLarge">
            <h3 class="centre">Concept :</h3>
            <p class="centre">Sur la carte vous allez avoir un mot et il va falloir trouver la traduction. Entrer la traduction dans le champs de texte et valider la réponse.</p>
            <br>
        </div>


    



        <!------------------------------------- PARTIE HTML 2 ---------------------------------------
         Personnalisation des apprentissages
         1. Liste déroulante des langues
         2. Liste déroulante des catégories de mots
         3. Bouton valider 
        -->
        <div class="containerPersonalisation blocInfo">
            <h3>Personnaliser votre apprentissage : </h3>
            <form method="GET">
                <label for="langueChoisie">Choisir une langue : </label>
                <select name="langue" id="langueChoisie">
                    <option value="1" <?= $langue == 1 ? 'selected' : '' ?>>FR-ENG</option>
                    <option value="2" <?= $langue == 2 ? 'selected' : '' ?>>FR-ESP</option>
                    <option value="3" <?= $langue == 3 ? 'selected' : '' ?>>ENG-FR</option>
                    <option value="4" <?= $langue == 4 ? 'selected' : '' ?>>ENG-ESP</option>
                </select>

                <br>
                <label for="langueChoisie">Choisir une catégorie de mots : </label>
                <select name="tag" id="tagChoisi">

                    <?php
                    // Récupérer toutes les categories pour la liste déroulante
                    $nbrCateg = count($allCateg);
                    echo "<option value ='rien'>" ."  ". "</option>";
                    for ($i = 0; $i<$nbrCateg; $i++){
                        $theCateg = $allCateg[$i];
                       $selected = ($theCateg === $tag) ? 'selected' : '';
                        echo "<option value='".$theCateg."' $selected>".$theCateg."</option>";
                    }
                    ?>
                </select>


                <br>
                <!-- Valider les infos des listes déroulantes-->
                <input type="submit" value="Valider"/>

            </form>
        </div>

        <h3 id="score" class="centre">Score : <?php echo $currentScore; ?> </h3>



        <!------------------------------------- PARTIE PHP 2 ---------------------------------------
         Choisir un mot aléatoire
         1. Récupérer les mots
         2. Variables 
        -->
        <?php
        // Variable par défaut pour pouvoir afficher le message de réussite ou d'echec
        $message = ""; 

        // Choisir le mot à afficher en fonction de la langue choisi
        $langue = $_GET['langue'] ?? 1;

        // Catégorie
        $categChoisi = null;
        if (isset($_GET['tag']) && $_GET['tag'] !== 'rien') {
            $categChoisi = strtolower($_GET['tag']);
        }


        // Récupération du mot
        if ($categChoisi !== null) {
            $motRandom = get_random_word_par_categ_et_langues($langue, $categChoisi);
        } else {
            $motRandom = get_random_word();
        }

        
        $motFR = $motRandom['fr'];
        $motENG = $motRandom['en'];
        $motESP = $motRandom['es'];



        switch ($langue) {
            case 1:
                $mot1 = $motFR;
                $mot2 = $motENG;
                break;
            case 2:
                $mot1 = $motFR;
                $mot2 = $motESP;
                break;
            case 3:
                $mot1 = $motENG;
                $mot2 = $motFR;
                break;
            case 4:
                $mot1 = $motENG;
                $mot2 = $motESP;
                break;
        }
        ?>




        <!------------------------------------- PARTIE HTML 3 ---------------------------------------
         Containers
         1. Container de la carte, la carte, sa partie avant et arrière
         2. Container des réponses (zone de texte, boutons valider et suivant, message, score )
         3. Bouton valider 
        -->
        <div class="containerCarte">
            <!-- Pour créer la carte -->
            <div class="carte">
                <!-- Pour créer les cartes avant et arrière. Elles seront affichés / cachés dans le CSS -->
                <div class="carteAvant"><?php echo $mot1; ?></div>
                <div class="carteArriere"><?php echo $mot2; ?></div>
            </div>
        </div>

        
        <!-- Pour créer un container des réponses -->
        <div class="containerReponse">

            <p>Entrer votre réponse : </p> 
            <input class="moyenLarge" type="text" id="reponse" size="50">

            <div class="ligneBoutons">
                <button id="btnValider">Valider</button>
                <form method="POST" style="margin: 0;">
                    <!-- Pour envoyer le score à PHP pour qu'il ne se remette pas a 0 à chaque nouveau mot -->
                    <input type="hidden" name="score" id="scoreCache" value="<?php echo $currentScore; ?>">
                    <button type="submit" id="btnNext">Suivant</button>
                    <!--<button type="submit" id="btnReset">Réinitialiser</button>-->
                </form>
            </div>

            <!-- Pour afficher un message réponse (fait dans le javaScript) -->
            <p id="message"></p>
        </div>

        

        



        <!------------------------------------- PARTIE JavaScript ---------------------------------------
         1. Faire retourner la carte
         2. Variables
         3. Varification de la réponse de l'utilisateur (affichage message et incrémentation score)
         4. Incrémentation variable score pour l'affichage
         (Faite avec l'aide d'IA car on ne connait pas le JS)
        -->
        <script>
            // Pour faire retourner la carte
            const carte = document.querySelector('.carte');     // récupère l'élément HTML <div class="carte">
            carte.addEventListener('click', () => {             // écoute le clic sur la carte
                carte.classList.toggle('is-flipped');           // ajoute la classe si elle n’y est pas, l’enlève si elle y est déjà
            });
            

            // Pour vérifier la réponse de l'utilateur
            let bonneRep = "<?php echo $mot2; ?>";                    // Bonne réponse 
            let score = <?php echo $_SESSION['score'] ?? 0; ?>;         // Pour afficher le score
            const scoreHidden = document.getElementById("scoreCache");


            // Quand le bouton est cliqué
            document.getElementById("btnValider").addEventListener("click", () => {
                const rep = document.getElementById("reponse").value.trim().toLowerCase();  // récupère l'élément HTML réponse de l'utili
                carte.classList.toggle('is-flipped');

                if (rep === bonneRep.toLowerCase()) {
                    // Afficher dans l'element avec l'id "message" le texte ... et mettre la couleur en ...
                    document.getElementById("message").textContent = "Bravo ! Bonne réponse";
                    document.getElementById("message").style.color = "green";
                    score += 1;
                } else {
                    // Afficher dans l'element avec l'id "message" le texte ... et mettre la couleur en ...
                    document.getElementById("message").textContent = "Mauvaise réponse, la bonne réponse était <?php echo $mot2; ?>";
                    document.getElementById("message").style.color = "red";
                    score = 0;
                }


                // Mettre à jour l'affichage du score
                document.getElementById("score").textContent = "Score : " + score;
                // Mettre à jour le hidden pour PHP
                scoreCache.value = score;     
            });

                       
        </script>
        

    </body>
</html>