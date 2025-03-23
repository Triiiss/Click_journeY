<?php
    include 'fonctions.php';
    session_start();

    if($_SESSION["connexion"]!="connected"){
        header("Location: connexion.php");
    }
?>

<!DOCTYPE php>
<php>
    <head>
        <meta charset="utf-8"/>
        <title>camping de l'extreme - Voyage</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    </head>
    <body>
        <h1 class="titre">Camping de l'Extreme <img src="../images/logo.png" class="logo" alt="logo de l'image"/></h1>
        <a class="accueil" href="accueil.php">Accueil</a><br/>

        <?php bandeau("recherche");?>
            
        <?php
            $json_voyages=file_get_contents("../json/voyages.json");
            $voyages=json_decode($json_voyages, true);
            $id=$_GET["id"];
            echo '<div class=voyages>';
                echo '<img src="'.$voyages[$id]["image"].'" class="imgDetail" alt="photo_voyage""/>';
                echo '<div class=recap>';
                    echo '<div>'.$voyages[$id]["titre"].'</div>';
                    echo '<div>'.$voyages[$id]["description"].'</div>';
                    echo '<div>'.'Prix : '.$voyages[$id]["prix"].'euros'.'</div>';
                    echo '<div>'.'Départ le '.$voyages[$id]["depart"].'</div>';
                    echo '<div>'.'Durée : '.$voyages[$id]["duree"].'</div>'; 
                echo '</div>';
            echo '</div>';
        ?>

        <form action="recap.php" method="post">
            <?php
            $etapes = $voyages[$id]["etapes"];
                foreach($etapes as $k=> $etape){
                    echo '
                    <fieldset class="options">
                        <legend>Options</legend>
                        <h3>Etape : '.$etape["titre"].'</h3>
                        <div>Lieu : '.$etape["lieu"].'</div>
                        <div>Durée : '.$etape["duree"].' jours</div>

                        <label for="option'.$k.'">Options :</label>
                        <div>';
                            foreach($etape["option"] as $option){
                                echo $option.'<input class="options" type="checkbox" name="option'.$k.'" value="'.$option.'">';
                            }
                        echo '</div>
                    </fieldset>';
                }
            ?>
            <input type="hidden" name="id" value="<?php echo "".$id."" ?>"></input>

            <fieldset class="options">
                <button class="options" type="reset" name="reset">Réinitialiser</button>
                <button class="options" type="submit" name="submit">Récapitulatif</button>
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

