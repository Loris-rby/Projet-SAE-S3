<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./style.css" />
        <title>MemoDeck : ajout</title>
    </head>
    <body>

        <div id="pageAcceuil">

            <span class="testLogo">Page ajout</span><br>

            <div class="blocInfo">
                <h2>Ajout</h2>

                <form action="./creationDemande.php" method="GET">

                    <!-- Texte FR -->
                    <label for="texteFR">Écriture du mot en Français</label>
                    <input type="text" id="texteFR" name="texteFR"/><br>
                    
                    <!-- Texte EN -->
                    <label for="texteEN">Écriture du mot en Anglais</label>
                    <input type="text" id="texteEN" name="texteEN"/><br>

                    <!-- Texte FR -->
                    <label for="texteES">Écriture du mot en Espagnol</label>
                    <input type="text" id="texteES" name="texteES"/><br>


                    <!-- Valider -->
                    <input type="submit" value="Demande l'ajout"/>
                </form>


                <?php
                    // message de validation de l'ajout de la demande
                    if (isset($_REQUEST['valid'])){
                        echo '<p>Demande d\'ajout du mot <b>"'.$_REQUEST['valid'].'"</b> bien enregistrée !</p><br>';
                    }
                ?>

            </div>
                
        </div>

    </body>
</html>