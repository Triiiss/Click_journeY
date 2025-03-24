<?php
    include 'fonctions.php';
    session_start();
    $login=$_POST["login"];
    $mdp=$_POST["mdp"];


    if($_SESSION["connexion"]=="connected"){
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
        <h1 class="titre">Camping de l'Extreme <img src="../images/logo.png" class="logo" alt="logo de l'image"/></h1>
        <a class="accueil" href="accueil.php">Accueil</a><br/>

        <?php bandeau("connexion");?>

        <form action="connexion.php" method="post">
            <fieldset class="formulaire connexion">
            <legend>Connexion</legend>

            <label for="login" >Identifiant :</label>
            <input type="text" name="login" >

            <label for="mdp" >Mot de passe :</label>
            <input type="password" name="mdp" >


            <label for="submit" ></label>
            <button class="inscription" name="submit" type="submit" >Se connecter</button>

            <p>Vous n'avez pas encore de compte ? <a class="orange" href="inscription.php">Inscrivez-vous</a></p>

            <?php
                $users = get_data("../json/utilisateurs.json");
                
                if($users == null){
                    echo "<p>Problème de récupération des données côté serveur</p>";
                }
                else{
                    $veriflogin=0;
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
                                echo '<p></p>
                                <span class="etoile">Mot de passe incorrect</span>';
                            }
                            $veriflogin=1;
                            break;
                        }
                    }
                    if($veriflogin!=1 && !empty($login)){
                        echo '<p></p>
                        <span class="etoile">Identifiant incorrect</span>';
                    }
                }
            ?>

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
