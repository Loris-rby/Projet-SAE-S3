<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./../style.css" />
        <title>Admin : connexion</title>
    </head>
    <body>

        <?php
            require_once './../header.php';
        ?>

        <div id="pageAcceuil">

            <h1 class="centre">Connexion admin</h1>

            <div class="blocInfo">
                <h3 class="centre">Identification</h3>

                <form action="./pageAdmin.php" method="POST">

                    <!-- identifiant -->
                    <label for="identifiant">Identifiant</label>
                    <input type="text" id="identifiant" name="identifiant"/><br><br>
                    
                    <!-- mot de passe -->
                    <label for="mot2passe">Mot de passe</label>
                    <input type="password" id="mot2passe" name="mot2passe"/><br><br>

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