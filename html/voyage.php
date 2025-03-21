<?php
    session_start();
?>

<!DOCTYPE php>
<php>
    <head>
        <meta charset="utf-8"/>
        <title>camping de l'extreme - Recherche</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    </head>
    <body>
        <h1 class="titre">Camping de l'Extreme <img src="../images/logo.png" class="logo" alt="logo de l'image"/></h1>
        <a class="accueil" href="accueil.php">Accueil</a><br/>

        <ul class="bandeau">
            <nav class="bandeau">
                <li class="bandeau"><a class="bandeau" href="presentation.php">PRESENTATION</a></li>
                <li class="bandeau" id="current"><a class="bandeau" id="current" href="recherche.php">ITINERAIRES</a></li>
                <?php
                if(isset($_SESSION["connexion"]) && $_SESSION["connexion"] == "connected"){
                        if(isset($_SESSION["role"]) && $_SESSION["role"] == "admin"){
                        echo '<li class="bandeau"><a class="bandeau" href="admin.php">ADMIN</a></li>';
                        }
                        echo '<li class="profil"><a class="profil" href="profil.php"><img src="../images/profil_picture.webp" class="profil_picture" alt="Profil"/></a></li>';

                }
                else{
                        echo '<li class="bandeau"><a class="bandeau" href="connexion.php">CONNEXION</a></li>';
                        echo '<li class="bandeau"><a class="bandeau" href="inscription.php">INSCRIPTION</a></li>';
                }
                ?>
            </nav>
        </ul>
            
        <?php
            $json_voyages=file_get_contents("../json/voyages.json");
            $voyages=json_decode($json_voyages, true);
            $id=$_GET["id"];
            echo '<div class=vueDetail>';
                echo '<img src="'.$voyages[$id]["image"].'" class="imgVoyage" alt="photo_voyage""/>';
                echo $voyages[$id]["titre"];
            echo '</div>';
        ?>

        <br><br>
        <div class="afterimage">
                <span class="first-afterimage">Nous contacter :</span>
                <p>Email : contact@campingextreme.com<br/>Téléphone : 01 23 45 67 89</p>
                <br/>
        </div>
    </body>
</php>

