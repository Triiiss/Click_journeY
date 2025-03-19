<?php
    session_start();

    if(empty($_SESSION["connexion"]) || $_SESSION["connexion"]!="connected"){
        header("Location :accueil.php");
    }
?>

<!DOCTYPE php>
<php>
    <head>
        <meta charset="utf-8"/>
        <title>camping de l'extreme - Profil</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    </head>
    <body>
        <h1 class="titre">Camping de l'Extreme <img src="../images/logo.png" class="logo" alt="logo de l'image"/></h1>
        <a class="accueil" href="accueil.php">Accueil</a><br/>

        <ul class="bandeau">
            <nav class="bandeau">
                <li class="bandeau"><a class="bandeau" href="presentation.php">PRESENTATION</a></li>
                <li class="bandeau"><a class="bandeau" href="recherche.php">ITINERAIRES</a></li>
                <?php
                if(isset($_SESSION["role"]) && $_SESSION["role"] == "admin"){
                    echo '<li class="bandeau"><a class="bandeau" href="admin.php">ADMIN</a></li>';
                }
                ?>
                <li class="profil" id="current"><a class="profil" id="current" href="profil.php"> 
                <img src="../images/profil_picture.webp" class="profil_picture" alt="Profil"/></a>
                </li>
            </nav>
        </ul>

        <form action="profil.php" method="POST">
        <fieldset class="formulaire">
            <legend>Profil <img src="../images/profil_picture.webp" class="profil_picture"/></legend>
                <?php
                    if(empty($_SESSION["login"])){
                        session_destroy();
                        header("Location :accueil.php");
                    }
                    else{
                        $json_users=file_get_contents("../json/utilisateurs.json");
                        $users=json_decode($json_users, true);
                        
                        foreach($users as $k=> $user){
                            if ($user["login"] == $_SESSION["login"]){echo '
                                <p>Identifiant</p><p>'.$user["login"].'</p>
                                <p>Mot de passe</p><p>'.$user["mdp"].'</p>
                                <p>E-mail : </p><p>'.$user["email"].'</p>

                                <p>Prénom</p><p>'.$user["profil"]["prenom"].'</p>
                                <p>Nom : </p><p>'.$user["profil"]["nom"].'</p>
                                <p>Numéro de téléphone</p><p>'.$user["profil"]["telephone"].'</p>
                                <p>Date de naissance</p><p>'.$user["profil"]["date de naissance"].'</p>
                                <p>Genre : </p><p>'.$user["profil"]["genre"].'</p>
                                <p>Adresse :</p><p>'.$user["profil"]["adresse"].'</p>';
                                break;
                            }
                        }                                
                    }
                ?>
                <p></p>
                <button name="modif" type="button" >Modifier le profil</button>
                <input type="submit" name="deco" value="déconnexion">
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
<?php
    if(isset($_POST["deco"])){
        session_destroy();
        header("Location: accueil.php");
    }
?>