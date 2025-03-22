<?php
    include 'fonctions.php';
    session_start();
?>

<!DOCTYPE php>
<php>
    <head>
        <meta charset="utf-8"/>
        <title>camping de l'extreme - Recap</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    </head>
    <body>
        <h1 class="titre">Camping de l'Extreme <img src="../images/logo.png" class="logo" alt="logo de l'image"/></h1>
        <a class="accueil" href="accueil.php">Accueil</a><br/>

        <?php bandeau("recherche");?>
            
        <?php
            $json_voyages=file_get_contents("../json/voyages.json");
            $voyages=json_decode($json_voyages, true);
            $id=$_POST["id"];
            $hebergement=$_POST["hebergement"];
            $restauration=$_POST["restauration"];
            $transport=$_POST["transport"];
            $activites=$_POST["activites"];
            echo '<div class=voyages>';
                echo '<img src="'.$voyages[$id]["image"].'" class="imgDetail" alt="photo_voyage""/>';
                echo '<div class=recap>';
                    echo '<div>'.$voyages[$id]["titre"].'</div>';
                    echo '<div>'.$voyages[$id]["description"].'</div>';
                    echo '<div>'.'Prix : '.$voyages[$id]["prix"].'euros'.'</div>';
                    echo '<div>'.'Départ le '.$voyages[$id]["depart"].'</div>';
                    echo '<div>'.'Durée : '.$voyages[$id]["duree"].'</div>'; 
                    echo '<div>'.'Hebergement : '.$hebergement.'</div>'; 
                    echo '<div>'.'Restauration : '.$restauration.'</div>'; 
                    echo '<div>'.'Transport : '.$transport.'</div>'; 
                    echo '<div>'.'Activites : '.$activites.'</div>'; 
                echo '</div>';
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