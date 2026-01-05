<!DOCTYPE html>

<html>
    <head>
        <title>MD - Memory</title>
        <link rel="stylesheet" href="./style.css">
        <link rel="stylesheet" href="./../Header/styleHeader.css">
    </head>



    <body>
        <!------------------------------------- PARTIE PHP 1 ---------------------------------------
         1. Récupérer le header
        -->
        <?php
        require_once './../fonctions.php';
        require_once './../Header/header.php';
        ?>





        <!------------------------------------- PARTIE HTML 1 ---------------------------------------
        1. Afficher le texte en haut
        -->
        <h1 class="centre">Jeu du mémory</h1>
        <h3 class="centre">Concept :</h3>
        <p class="centre">Le jeu se compose d'une grille de 16 cartes. À chaque tour, vous pouvez retourner deux cartes.</p>
        <p class="centre">Votre objectif est de trouver la paire correspondante : une carte avec un mot en français et sa traduction en anglais. Si vous trouvez une paire correcte, les deux cartes restent retournées.</p>
        <p class="centre">Ce jeu vous permet de stimuler votre mémoire tout en renforçant votre vocabulaire en français et en anglais.</p>
        





        <!------------------------------------- PARTIE HTML 2 ---------------------------------------
         Personnalisation des apprentissages
         1. Liste déroulante des langues
         2. Liste déroulante des catégories de mots
         3. Bouton valider 
        -->
        <div class="containerPersonalisation">
            <h3>Personnaliser votre apprentissage : </h3>
            <form method="GET">
                <label for="langueChoisie">Choisir une langue : </label>
                <select name="langue" id="langueChoisie">
                    <option value="1">FR-ENG</option>
                    <option value="2">FR-ESP</option>
                    <option value="3">ENG-FR</option>
                    <option value="4">ENG-ESP</option>
                </select>




                <br>
                <label for="langueChoisie">Choisir une catégorie de mots : </label>
                <select name="tag" id="tagChoisi">

                    <?php
                    // Récupérer toutes les categories pour la liste déroulante
                    $allCateg = get_all_categories();
                    $nbrCateg = count($allCateg);
                    echo "<option value ='rien'>" ."  ". "</option>";
                    for ($i = 0; $i<$nbrCateg; $i++){
                        $theCateg = $allCateg[$i];
                        echo "<option value='".$theCateg;
                        echo "'>";
                        echo $theCateg."</option>";
                    }
                    ?>
                </select>



                <br>
                <!-- Valider les infos des listes déroulantes-->
                <input type="submit" value="Valider"/>


            </form>
        </div>






        <!------------------------------------- PARTIE PHP 2 / HTML 3 ---------------------------------------
        Création du jeu
         1. Récupération de mot randoms 
             - créations de listes de mots et de cartes
             - Récuparation de 8 mots randoms
             - Création d'un id pour chaque pair de mot et ajout de chaque partie de mot (fr-eng) en 2 cartes dans la liste de carte
             - Mélanger les cartes
         2. Création des div 
             - Grille de jeu + des 4 lignes 
             - Des 4 cartes par lignes
         3. Bouton valider pour faire la vérification des cartes
        -->


        <?php
        // Listes
        $lesMots = [];
        $cartes = [];


        // On récupère 8 mots randoms et on les ajoute a la liste de mot
        while (count($lesMots) < 8) {
            $unMot = get_random_word();
            array_push($lesMots, $unMot);

            /*
            // Eviter les doublons (si le mot francais n'existe pas dans la liste des mots alors on l'ajoute)
            if (!isset($lesMots[$unMot['fr']])) {
                $lesMots[$unMot['fr']] = $unMot;
            }
            */
        }


        // Faire en fonction des langues
        if(isset($_GET['langue'])){
            $langue = $_GET["langue"];
        }else {
             $langue = 1;
        }



        switch ($langue) {
            case 1:
                // Création des cartes
                foreach ($lesMots as $unMot) {
                    // Création d'un id pour la vérification des cartes retournées
                    $pairId = $unMot['fr'] ."-". $unMot['en'];

                    // Ajout des cartes fr et eng au tableau de cartes
                    $cartes[] = [
                        'texte' => $unMot['fr'],
                        'pair' => $pairId
                    ];
                    $cartes[] = [
                        'texte' => $unMot['en'],
                        'pair' => $pairId
                    ];
                }
                break;
                
            case 2:
                // Création des cartes
                foreach ($lesMots as $unMot) {
                    // Création d'un id pour la vérification des cartes retournées
                    $pairId = $unMot['fr'] ."-". $unMot['es'];

                    // Ajout des cartes fr et eng au tableau de cartes
                    $cartes[] = [
                        'texte' => $unMot['fr'],
                        'pair' => $pairId
                    ];
                    $cartes[] = [
                        'texte' => $unMot['es'],
                        'pair' => $pairId
                    ];
                }
                break;

            case 3:
                // Création des cartes
                foreach ($lesMots as $unMot) {
                    // Création d'un id pour la vérification des cartes retournées
                    $pairId = $unMot['en'] ."-". $unMot['fr'];

                    // Ajout des cartes fr et eng au tableau de cartes
                    $cartes[] = [
                        'texte' => $unMot['en'],
                        'pair' => $pairId
                    ];
                    $cartes[] = [
                        'texte' => $unMot['fr'],
                        'pair' => $pairId
                    ];
                }
                break;
        }


        // Mélange des cartes
        shuffle($cartes);


        // Variable par défaut pour pouvoir afficher le message de réussite ou d'echec
        $message = ""; 
        $indexCarte = 0;
        ?>





        <!-- Container pour toute la grille de jeu (délimite cette espace) -->
        <div class="containerGrilleJeu">

            <?php
            // Pour afficher 4 lignes
            for ($j=0; $j<4; $j++) {
            ?>
            <!-- Container pour 1 ligne de carte -->
            <div class="containerLigne1">
                

                <?php
                // Pour afficher 4 cartes par lignes
                for ($i=0; $i<4; $i++) {
                ?>

                    <!-- Pour créer la carte avec un id pour la vérifiaction -->
                    <div class="carte" data-pair=" <?php echo $cartes[$indexCarte]['pair'];?> ">
                    <!-- Pour créer les cartes avant et arrière. La carte avant n'affiche rien et la carte arrière à le mot fr ou anglais-->
                        <div class="carteAvant"></div>
                        <div class="carteArriere"><?php echo $cartes[$indexCarte]['texte']; ?></div>
                    </div>
                

                <?php 
                // On passe à la carte suivante
                $indexCarte++;
                // Fin nbr carte (for $i)
                }
                ?>
               

            </div>  <!-- Fin containerLigne1 -->
            <?php
            // Fin nbr lignes (for $j)
            }
            ?>


        </div>  <!-- Fin containerGrilleJeu -->


        <form method="POST" style="margin: 0;">
            <button type="submit" id="btnNext">Rejouer</button>
        </form>





        <!------------------------------------- PARTIE JavaScript ---------------------------------------
         1. Variables
         2. Retourner ou pas la carte 
             - Conditions pour ne pas la retourner
             - La retourné
         3. Vérification de la bonne réponse (quand 2 cartes sont retournées)
         4. Fonction de vérification
             - Récupérer les cartes
             - Vérification des paires : si c'est les mêmes alors on garde les acrtes retournées, sinon on laisse un peu 
             de temps avant de les retourner à nouveau
             - Autorise à nouveau le clic de 2 cartes
         
         (Faite avec l'aide d'IA car on ne connait pas le JS)
        -->

        <script>
        // Récupérer tt les balises HTML avec classe carte
        const cartes = document.querySelectorAll('.carte');


        // Variables globales
        let cartesRetournees = [];          // Cartes actuellement retournées
        let blocage = false;                // Permet de bloquer les clics (false = peut tourner carte, true = peut pas)


        // Action retourner (ou pas) la carte
        cartes.forEach(carte => {                               
            carte.addEventListener('click', () => {             // Quand la carte est cliquée on fait : ...
                if (blocage) return;                            // Si blocage = activé : arrete fonction (clic = ignoré)
                if (carte.classList.contains("fixe")) return;   // Si carte = "fixe" (= deja cliquée) : on fait rien
                if (cartesRetournees.includes(carte)) return;   // Si carte cliquée = dans  liste des cartes retournées, on fait rien (empeche de la retourner)
                if (cartesRetournees.length === 2) return;      // Si 2 cartes sont déjà retournées, on fait rien (empeche de retourner la carte cliquée)
                
                // Si aucun des caas précédens est arrivé alors on peut retourner la carte
                carte.classList.add('is-flipped');      // On ajoute le CSS à la carte (le CSS fait l'animation)
                cartesRetournees.push(carte);           // Ajoute la carte dans la liste des cartes retournées



                // Vérification automatique (quand 2 cartes sont retournées)
                if (cartesRetournees.length === 2) {
                    verifierPaire();
                }
            });
        });



        // Fonction de vérification
        function verifierPaire() {
            // Bloque le retournage de carte
            blocage = true;


            // Récupération des cartes retournées + leur identifiant (pair)
            const carte1 = cartesRetournees[0];
            const carte2 = cartesRetournees[1];
            const pair1 = carte1.dataset.pair;
            const pair2 = carte2.dataset.pair;

            
            if (pair1 === pair2) {
                // Bloque définitivement les cartes en mode retournées
                carte1.classList.add("fixe");
                carte2.classList.add("fixe");

                //Vide la liste des cartes retournées et autorise le clic
                cartesRetournees = [];
                blocage = false;
            } 
            

            else {
                // On attend un certain délai (0.7s)
                setTimeout(() => {
                    // On retourne les cartes, on vide la liste des cartes retournées et on autorise le clic
                    carte1.classList.remove('is-flipped');
                    carte2.classList.remove('is-flipped');

                    cartesRetournees = [];
                    blocage = false;
                }, 700); 
            }

        }

        </script>



    </body>
</html>



