<?php
    include 'fonctions.php';
    session_start();
    if (isset($_POST["login"])){
        $login=$_POST["login"];
    }
    if (isset($_POST["mdp"])){
        $mdp=$_POST["mdp"];
    }


    if(isset($_SESSION["connexion"]) && $_SESSION["connexion"]=="connected"){
        header("Location: accueil.php");
    }
?>

<!DOCTYPE php>
<php>
    <head>
        <meta charset="utf-8"/>
        <title>camping de l'extreme - Connexion</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    </head>
    <body>
        <script src="../javascript/formulaires.js"></script>
        <h1 class="titre">Camping de l'Extreme <img src="../images/logo.png" class="logo" alt="logo de l'image"/></h1>
        <a class="accueil" href="accueil.php">Accueil</a><br/>

        <?php 
            bandeau("connexion");
            
            $users = get_data("../json/utilisateurs.json");
            
            if($users == null){
                echo "<p>Problème de récupération des données côté serveur</p>";
            }
            else{
                $veriflogin=0;
                $verifmdp=0;
                foreach($users as $k=> $user){
                    if(isset($user["login"]) && $user["login"] === $login){
                        if(isset($user["mdp"]) && $user["mdp"] === $mdp){
                            // Dire à la session qu'on est connecté
                            $_SESSION["user_index"] = $k+1;
                            $_SESSION["connexion"] = "connected";
                            $_SESSION["login"] = $login;
                            $_SESSION["role"] = $user["role"];

                            header("Location: accueil.php");
                        }
                        else{
                            $verifmdp=1;
                        }
                        $veriflogin=1;
                        break;
                    }
                }
            }
        ?>

        <form id="connexion" action="connexion.php" method="post">
            <fieldset class="formulaire connexion">
            <legend>Connexion</legend>

            <label for="login" >Identifiant :</label>
            <input type="text" name="login" value="<?php if($veriflogin==1){echo $login;}?>" required>
            <?php
                if($veriflogin!=1 && !empty($login)){
                    echo '<p></p>
                    <span class="etoile">Identifiant incorrect</span>';
                }
            ?>

            <label for="mdp" >Mot de passe :</label>

            <span>
                <input type="password" name="mdp" id="password" required>
                <button type="button" class="edit_icon" onclick="hide_view(0)">
                    <img id="icon" src="../images/view.png"/>
                </button>
            </span>
            <?php
                if($verifmdp==1 && !empty($mdp)){
                    echo '<p></p>
                    <span class="etoile">Mot de passe incorrect</span>';
                }
            ?>


            <label for="submit" ></label>
            <button type="button" class="inscription" name="submit" onclick="verification_connexion()">Se connecter</button>

            <p>Vous n'avez pas encore de compte ? <a href="inscription.php">Inscrivez-vous</a></p>


            </fieldset>
        </form>

        <br><br>
        <div class="afterimage">
            <span class="first-afterimage">Nous contacter :</span>
            <p>Email : contact@campingextreme.com<br/>Téléphone : 01 23 45 67 89</p>
            <br/>
        </div>
    </body>
</php>
