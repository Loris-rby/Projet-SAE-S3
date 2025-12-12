<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./style.css" />
        <title>Admin : connexion</title>
    </head>
    <body>

        <div id="pageAcceuil">

            <span class="testLogo">Connection admin</span><br>

            <div class="blocInfo">
                <h2>Identification</h2>

                <form action="./controleurAdmin.php" method="POST">

                    <!-- identifiant -->
                    <label for="identifiant">Identifiant</label>
                    <input type="text" id="identifiant" name="identifiant"/><br>
                    
                    <!-- mot de passe -->
                    <label for="mot2passe">Mot de passe</label>
                    <input type="password" id="mot2passe" name="mot2passe"/><br>

                    <!-- Valider -->
                    <input type="submit" value="Entrer"/>
                </form>

                <?php
                    // message de mauvais mot de passe
                    if (isset($_REQUEST['erreur'])){
                        if($_REQUEST['erreur']=="mot2passe"){
                            echo '<p>Erreur de connexion : mauvais mot de passe</p><br>';
                        }else{
                            echo '<p>Erreur de connexion : mauvais identifiant</p><br>';
                        }
                    }
                ?>

            </div>
                
        </div>

    </body>
</html>