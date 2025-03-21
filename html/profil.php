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
            <fieldset class="formulaire profil">
                <legend>Profil <img src="../images/profil_picture.webp" class="profil_picture"/></legend>
                    <?php
                        if(empty($_SESSION["user_index"])){
                            session_destroy();
                            header("Location :accueil.php");
                        }
                        else{
                            $json_users=file_get_contents("../json/utilisateurs.json");
                            $users=json_decode($json_users, true);
                            $user=$users[$_SESSION["user_index"]-1];

                            echo '<p>Identifiant :</p>
                            <p>'.$user["login"].'</p>
                            <p><button type="submit" class="edit_icon" name="modif_login"><img class="edit_icon" src="../images/edit_icon.png"/></button></p>

                            <p>Mot de passe :</p>
                            <p>'.$user["mdp"].'</p>
                            <p><button type="submit" class="edit_icon" name="modif_mdp"><img class="edit_icon" src="../images/edit_icon.png"/></button></p>

                            <p>E-mail : </p>
                            <p>'.$user["email"].'</p>
                            <p><button type="submit" class="edit_icon" name="modif_email"><img class="edit_icon" src="../images/edit_icon.png"/></button></p>

                            <p>Prénom :</p>
                            <p>'.$user["profil"]["prenom"].'</p>
                            <p><button type="submit" class="edit_icon" name="modif_prenom"><img class="edit_icon" src="../images/edit_icon.png"/></button></p>

                            <p>Nom : </p>
                            <p>'.$user["profil"]["nom"].'</p>
                            <p><button type="submit" class="edit_icon" name="modif_nom"><img class="edit_icon" src="../images/edit_icon.png"/></button></p>

                            <p>Numéro de téléphone :</p>
                            <p>'.$user["profil"]["telephone"].'</p>
                            <p><button type="submit" class="edit_icon" name="modif_tel"><img class="edit_icon" src="../images/edit_icon.png"/></button></p>

                            <p>Date de naissance :</p>
                            <p>'.$user["profil"]["date de naissance"].'</p>
                            <p><button type="submit" class="edit_icon" name="modif_dob"><img class="edit_icon" src="../images/edit_icon.png"/></button></p>

                            <p>Genre : </p>
                            <p>'.$user["profil"]["genre"].'</p>
                            <p><button type="submit" class="edit_icon" name="modif_genre"><img class="edit_icon" src="../images/edit_icon.png"/></button></p>

                            <p>Adresse :</p>
                            <p>'.$user["profil"]["adresse"].'</p>
                            <p><button type="submit" class="edit_icon" name="modif_adresse"><img class="edit_icon" src="../images/edit_icon.png"/></button></p>
                            
                            <p>Voyages :</p>
                            <p>...</p>
                            <p>...</p>
                            
                            <p>Date d\'inscription :</p>
                            <p>'.$user['date d\'inscription'].'</p>
                            <p></p>';
                        }
                    ?>
                    <p class="empty"> .</p>
                    <p></p>
                    <p></p>
                    <p></p>
                <input type="submit" name="deco" value="Déconnexion">
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