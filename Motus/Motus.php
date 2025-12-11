<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Motus </title>
        <link rel="stylesheet" href="./style.css"> 

    </head>
    <body>
        <h1>Jeu du Motus </h1>
        <h1>Veuillez saisir un mot :</h1>

        
        <form method="POST" > 
        <select name="langues"  > 
            <?php 
        session_start();
        mb_internal_encoding("UTF-8"); //On indique que toutes les fonctions utilisent UTF-8
        include './../fonctions.php';

        // ----------- Gestion de la langue voulue  ----------------------------------------------------------------------
        if (isset($_POST['langues'])) {
            $_SESSION['langue'] = $_POST['langues'];// Pour que la langue ne change pas a chaque Post (pour la validation d'une ligne par exempleh)
        }
        
        $langueVoulue = $_SESSION['langue'] ?? "fr"; // on enregistre en quel langue est le mot a trouvée par defaut en français

        if ($langueVoulue=="fr"){ // pour que la langue choisie soit selectionner dans l'input 
            echo"<option value='fr' selected>Français</option>";
            echo" <option value='en'>English</option>";
            echo "<option value='es'>Espagnol</option>" ;  // pour l'espagnol dans la BD 

            echo "</select>";
        }
        else if ($langueVoulue=="en"){
            echo"<option value='fr'>Français</option>";
            echo" <option value='en' selected>English</option>";
            echo "<option value='es'>Espagnol</option>" ;  // pour l'espagnol dans la BD 

            echo "</select>";
        }
        else if ($langueVoulue=="es"){
            echo"<option value='fr'>Français</option>";
            echo" <option value='en'>English</option>";
            echo "<option value='es' selected>Espagnol</option>" ;  // pour l'espagnol dans la BD 

            echo "</select>";                    
        }
        
           ?>
        <button type="submit">Valider la langue choisie</button>

        </form>
        
        <?php

        

        // ----------- Gestion du score ----------------------------------------------------------------------
        $_SESSION['score'] = $_SESSION['score'] ?? 0; // Pour creer un score global on le renvoie a chaque Post
        
        ?> <p> <?php
        echo " Score : ".$_SESSION['score'];  // On affiche le score 
        ?> </p> 
        
        <?php
        // ----------- Gestion du mot a trouver  ----------------------------------------------------------------------

         // Pour que le mot a trouvée ne change pas a chaque validation d'une ligne

         // Si le mot secret n'existe pas encore EN SESSION
        // OU si ce n'est PAS un tableau (ex : erreur précédente où on stockait un string)
        // OU si la langue demandée n'existe pas dans le tableau (ex : 'es' mais pas de clé 'es')
        // ALORS on génère un nouveau mot multilingue
        if (!isset($_SESSION['motSecret']) // Aucun mot stocké
            || !is_array($_SESSION['motSecret']) // Mauvais format : ce n'est pas un tableau => impossible d'accéder à ['fr'], ['en'], ['es']
            || !isset($_SESSION['motSecret'][$langueVoulue])){ // La langue demandée n'existe pas dans le tableau
            $_SESSION['motSecret'] = get_random_word(); // on génère un nouveau mot 
        }        

        $motSecret = $_SESSION['motSecret'][$langueVoulue];       // mot à deviner (garde les accents pour l'affichage)
        
        // ----------- Gestion des autres parametres du jeu ----------------------------------------------------------------------

        $tailleMot = mb_strlen($motSecret, "UTF-8");
        if ($tailleMot >=5){// AVEC 5 essai minimum
            $nombreEssais = $tailleMot; // nombre de tentatives max
        }
        else{
            $nombreEssais = 5; // nombre de tentatives max
        }
        //recup data post par le tableau
        $tentatives = $_POST['tentatives'] ?? [];  //$tentatives contient tous les mots déjà saisis par le joueur

        $motActuel = $_POST['motActuel'] ?? []; //$motActuel est le mot en cours de saisie (lettre par lettre)




        // ----------- Vérification de saisie  ----------------------------------------------------------------------
        // Si le joueur a soumis un mot 
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($motActuel)) { //Vérifie si le joueur a soumis quelque chose
            //reconstruire le mot avec les input 1 par 1
            $motReconstruit = implode('', $motActuel); //implode transforme le tableau de lettres [c,l,é] en mot "clé"
            // Vérifie la longueur 
            if (mb_strlen($motReconstruit, "UTF-8") === $tailleMot) {
                $tentatives[] = $motReconstruit; //On ajoute le mot aux tentatives si sa longueur correspond au mot a trouver 
            }
        }

        function mb_str_split_chars($str) {
            //Transforme une chaîne en tableau de lettres, y compris les lettres accentuées (de la meme manière qu'implode au dessus)
            return preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);
        }

        // ----------- Gestion des réponses par lettres ----------------------------------------------------------------------
        function evaluerTentative($motSecret, $motSaisi) {
            /* Compare le mot saisi avec le mot a trouver et 
              Retourne un tableau indiquant pour chaque lettre :
              'bien-place' si lettre correcte et à la bonne position,
              'mal-place' si lettre existe mais mauvaise position,
              'absent' si lettre n’existe pas dans le mot a trouver */

            $secretChars = mb_str_split_chars($motSecret); // mot secret = mot a trouver
            $saisiChars = mb_str_split_chars($motSaisi);

            $len = count($secretChars); 
            $result = array_fill(0, $len, 'absent'); // par défaut tout est en absent 
            
            
            // et ensuite on vérifie si ils sont 'bien-place' ou 'mal-place'

            // Marquer les 'bien-place'
            for ($i = 0; $i < $len; $i++) {
                if (isset($saisiChars[$i]) && $saisiChars[$i] === $secretChars[$i]) { // 1.	la lettre saisie existe à l’index $i   2.la lettre saisie est la même que la lettre du mot secret au même endroit
                    $result[$i] = 'bien-place';
                    $secretChars[$i] = null;
                }
            }

            //Pour les autres positions, chercher si la lettre existe encore dans secretChars
            for ($i = 0; $i < $len; $i++) {
                if ($result[$i] === 'bien-place')
                    continue;
                if (!isset($saisiChars[$i]))
                    continue;

                $lettre = $saisiChars[$i];
                // cherche un index k où secretChars[k] === lettre et non consommée (not null)
                $foundIndex = null;
                for ($k = 0; $k < $len; $k++) {
                    if ($secretChars[$k] !== null && $secretChars[$k] === $lettre) { // La lettre du mot secret à l’index 'k' est égale à la lettre qu’on cherche dans le mot saisi du joueur
                        $foundIndex = $k;
                        break;
                    }
                }
                if ($foundIndex !== null) { // Ce code s’exécute quand la lettre n’est PAS bien placée, mais on vérifie si elle existe ailleurs dans le mot secret.
                    $result[$i] = 'mal-place';
                    $secretChars[$foundIndex] = null;
                } else {
                    $result[$i] = 'absent';
                }
            }

            return $result; // ex: ['bien-place','absent','mal-place']
        }

        ?>

        <form method="POST">
            <table>
        <?php


        // ----------- Gestion de la grille ----------------------------------------------------------------------

        for ($i = 0; $i < $nombreEssais; $i++) {
            echo "<tr>";

            // Si c’est une tentative passée
            if (isset($tentatives[$i])) {
                $motSaisi = $tentatives[$i];
                // évaluer la tentative pour obtenir les classes
                $classes = evaluerTentative($motSecret, $motSaisi);
                // découpe en caractères pour afficher
                $lettres = mb_str_split_chars($motSaisi);
                for ($j = 0; $j < $tailleMot; $j++) {
                    $lettreAffiche = isset($lettres[$j]) ? $lettres[$j] : '';
                    $classe = $classes[$j] ?? 'absent';
                    // Affiche la lettre en majuscule multioctet
                    echo "<td class='$classe'>" . htmlspecialchars(mb_strtoupper($lettreAffiche, "UTF-8")) . "</td>";
                }
            }
            // Sinon, si c'est la ligne active (prochaine saisie)
            else {
                if ($i === count($tentatives)) {
                    for ($j = 0; $j < $tailleMot; $j++) {
                        // champ individuel pour chaque lettre
                        echo '<td><input type="text" name="motActuel[' . $j . ']" maxlength="1" autocomplete="off" onkeydown="if(event.keyCode==32) return false;"></td>';
                    }
                } else {
                    // Lignes restantes vides
                    for ($j = 0; $j < $tailleMot; $j++) {
                        echo "<td></td>";
                    }
                }
            }

            echo "</tr>";
        }
        ?>
            </table>

                <?php
                // Conserver les tentatives pour les POST suivants
                foreach ($tentatives as $tent) {
                    echo '<input type="hidden" name="tentatives[]" value="' . htmlspecialchars($tent, ENT_QUOTES, 'UTF-8') . '">';
                }
                ?>
            <br>
            <button type="submit">Valider</button>
        </form>

            <?php
            // ----------- Gestion de la victoire / défaite  ----------------------------------------------------------------------

            //  Vérif victory
            if (!empty($tentatives)) {
                $derniereTentative = end($tentatives);

                if ($derniereTentative === $motSecret) {
                    $_SESSION['score'] += 1; // Ajouter 1 au score 
                    echo "<h2>Bravo ! Vous avez trouvé le mot <b>" . htmlspecialchars(mb_strtoupper($motSecret, "UTF-8")) . "</b> !</h2>";
                    ?>
                    <form method="POST">
            <button type="submit">Rejouer</button>
                <?php
                $_SESSION['motSecret']=get_random_word();
                ?>
            </form> <?php
            } elseif (count($tentatives) >= $nombreEssais) {
                $_SESSION['score'] = 0; // remettre le score a 0
                echo "<h2>Perdu ! Le mot était <b>" . htmlspecialchars(mb_strtoupper($motSecret, "UTF-8")) . "</b>.</h2>";
                ?>
                <form method="POST">
            <button type="submit">Rejouer</button> 
                <?php
                $_SESSION['motSecret'] = get_random_word();
                ?>
            </form> 
            <?php
            } ?>
            <p></p>

        <?php
        }
        ?>

        <p> Pour les accents copier ici : </p>
        <p> â - é - è - ê - ñ - ó - í - ñ - ô </p>
                
    <script src="Motus.js"></script> 

</body>
</html>