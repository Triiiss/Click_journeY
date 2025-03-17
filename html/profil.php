<?php
    session_start();
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
                <p>Genre : </p><p>Femme</p>
                <p>Prénom</p><p>Emilie</p>
                <p>Nom : </p><p>Dupont</p>
                <p>E-mail : </p><p>email@gmail.com</p>
                <p>Numéro de téléphone</p><p>01 23 45 67 89</p>
                <p>Date de naissance</p><p>25/08/1991</p>
                <p>Adresse :</p><p>01 rue de la paix Paris</p>
                <p></p><p></p>
                <p>Mode :</p><p>Nuit/jour</p>
                <p>Langue</p><p>Français</p>
                <p>Voyage.s favoris :</p><p>la montagne (jsp laquelle)</p>
                <p></p><p></p>
                <p>Identifiant :</p><p></p>
                <p>Mot de passe :</p><p>modifier le mot de passe?</p>
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