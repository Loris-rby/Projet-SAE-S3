<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Motus PHP</title>
        <link rel="stylesheet" href="style.css"> 

    </head>
    <body>
        <h1>Jeu du Motus (PHP)</h1>

        <?php
        include './fonctions.php';
        mb_internal_encoding("UTF-8"); //On indique que toutes les fonctions utilisent UTF-8



        $motSecret = "apprendre"; // mot à deviner (garde les accents pour l'affichage)
        $tailleMot = mb_strlen($motSecret, "UTF-8");
        $nombreEssais = 5; // nombre de tentatives max
        //recup data post par le tableau
        $tentatives = $_POST['tentatives'] ?? [];  //$tentatives contient tous les mots déjà saisis par le joueur

        $motActuel = $_POST['motActuel'] ?? []; //$motActuel est le mot en cours de saisie (lettre par lettre)
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
            //Transforme une chaîne en tableau de lettres, y compris les lettres accentuées (de la meme manière qu'implode au dessus
            return preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);
        }

        function evaluerTentative($motSecret, $motSaisi) {
            /* Compare le mot saisi avec le mot a trouver et 
              Retourne un tableau indiquant pour chaque lettre :
              'bien-place' si lettre correcte et à la bonne position,
              'mal-place' si lettre existe mais mauvaise position,
              'absent' si lettre n’existe pas dans le mot a trouver */

            $secretChars = mb_str_split_chars($motSecret); // mot secret = mot a trouver
            $saisiChars = mb_str_split_chars($motSaisi);

            $len = count($secretChars);
            $result = array_fill(0, $len, 'absent');

            // Marquer les bien-place 
            for ($i = 0; $i < $len; $i++) {
                if (isset($saisiChars[$i]) && $saisiChars[$i] === $secretChars[$i]) {
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
                    if ($secretChars[$k] !== null && $secretChars[$k] === $lettre) {
                        $foundIndex = $k;
                        break;
                    }
                }
                if ($foundIndex !== null) {
                    $result[$i] = 'mal-place';
                    // consommer cette occurrence pour éviter double comptage
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
//  Vérif victory
            if (!empty($tentatives)) {
                $derniereTentative = end($tentatives);

                if ($derniereTentative === $motSecret) {
                    echo "<h2>Bravo ! Vous avez trouvé le mot <b>" . htmlspecialchars(mb_strtoupper($motSecret, "UTF-8")) . "</b> !</h2>";
                    ?><form method="POST"><button type="submit">Rejouer</button></form><?php
            } elseif (count($tentatives) >= $nombreEssais) {
                echo "<h2>Perdu ! Le mot était <b>" . htmlspecialchars(mb_strtoupper($motSecret, "UTF-8")) . "</b>.</h2>";
                ?><form method="POST"><button type="submit">Rejouer</button></form><?php
            }
        }
        ?>

                <p> Pour les accents copier-coller ici : </p>
        <p> â - 
         é -
         è -
         ê -
         î -
         ñ -
         ó -
         í -
         ñ -
         ô </p>
        <!-- Pour les accents mettre le code  -->
                
    <script src="Motus.js"></script> 

</body>
</html>