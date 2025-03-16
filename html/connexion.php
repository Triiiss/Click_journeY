<?php
    session_start();
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


        <ul class="bandeau">
            <nav class="bandeau">
                <li class="bandeau"><a class="bandeau" href="presentation.php">PRESENTATION</a></li>
                <li class="bandeau"><a class="bandeau" href="recherche.php">ITINERAIRES</a></li>
                <li class="bandeau" id="current"><a class="bandeau" id="current" href="connexion.php">CONNEXION</a></li>
                <li class="bandeau"><a class="bandeau" href="inscription.php">INSCRIPTION</a></li>
                <li class="profil"><a class="profil" href="profil.php"> 
                <img src="../images/profil_picture.webp" class="profil_picture" alt="Profil"/></a>
                </li>
            </nav>
        </ul>

        <form action="../php/connexion.php" method="post">
            <fieldset class="formulaire">
            <legend>Connexion</legend>

            <label for="login" >Identifiant :</label>
            <input type="text" name="login" >

            <label for="mdp" >Mot de passe :</label>
            <input type="password" name="mdp" >

            <label for="submit" ></label>
            <button class="inscription" name="submit" type="submit" >Se connecter</button>

            <p>Vous n'avez pas encore de compte ? <a href="inscription.php">Inscrivez-vous</a></p>
            </fieldset>
        </form>

        <p>Accès temporaire au <a href="profil.php">profil</a> et à <a href="admin.php">l'admin</a></p>

        <br><br>
        <div class="afterimage">
            <span class="first-afterimage">Nous contacter :</span>
            <p>Email : contact@campingextreme.com<br/>Téléphone : 01 23 45 67 89</p>
            <br/>
        </div>
    </body>
</php>
