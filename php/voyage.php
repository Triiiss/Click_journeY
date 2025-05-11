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
        <h1 class="titre">
            Camping de l'Extreme <img src="../images/logo.png" class="logo" alt="logo de l'image"/>
            <button class="chg_theme"> 
                <img src="../images/mode_sombre.png" class="mode_sombre" alt="Mode sombre"/>
            </button>
        </h1>
        
        <a class="accueil" href="accueil.php">Accueil</a><br/>

        <?php bandeau("recherche");?>
            
        <?php
            $json_voyages=file_get_contents("../json/voyages.json");
            $voyages=json_decode($json_voyages, true);
            $id=$_GET["id"];
            
            //affichage des infos du voyage
            echo '<div class=voyages>';
                echo '<img src="'.$voyages[$id]["image"].'" class="imgDetail" alt="photo_voyage""/>';
                echo '<div class=recap>';
                    echo '<div>'.$voyages[$id]["titre"].'</div>';
                    echo '<div>Lieu : '.$voyages[$id]["lieu"].'</div>';
                    echo '<div>'.$voyages[$id]["description"].'</div>';
                    echo '<div>'.'Prix : <span id="prix">'.$voyages[$id]["prix"].'</span> euros'.'</div>';
                    echo '<div>'.'Départ le '.$voyages[$id]["depart"].'</div>';
                    echo '<div>'.'Durée : '.$voyages[$id]["duree"].' jours</div>'; 
                echo '</div>';
            echo '</div>';
        ?>

        <form action="recap.php" method="post">
            <?php
            $etapes = $voyages[$id]["etapes"];
            foreach($etapes as $k=> $etape){
                echo '<fieldset class="voyages">';
                    if ($k==0) {
                        echo '<legend>Options</legend>';
                    }
                    echo'<h3>Etape '.($k+1).' : '.$etape["titre"].'</h3>
                    <div>Lieu : '.$etape["lieu"].'</div>
                    <div>Durée : '.$etape["duree"].'</div>

                    <label for="option'.$k.'">Options :</label>
                    <div>';
                        foreach($etape["option"] as $i=>$option){
                            echo $option["titre"].'('.$option["prix"].'€)'.'<input class="options" type="checkbox" name="option'.$k.$i.'" value="'.
                            $option["titre"].';'.$option["prix"].'">';
                        }
                    echo '</div>
                </fieldset>';
            }
            echo '<div>'.'Total : <span id="total">'.$voyages[$id]["prix"].'</span>euros'.'</div>';

            ?>
            <input type="hidden" name="id" value="<?php echo "".$id."" ?>"></input>

            <fieldset class="options">
                <button class="options" type="reset" name="reset">Réinitialiser</button>
                <button class="options" type="submit" name="submit">Récapitulatif</button>
            </fieldset>
        </form>

        <script>
            const prix = parseFloat(document.getElementById('prix').textContent);
            const ptot = document.getElementById('total');
            const options = document.getElementsByClassName('options');

            function updateTotalPrice() {
              let total = prix;
              for (var i in options) {
                  if (options[i].checked) {
                    total += parseFloat(options[i].value.split(';')[1]);
                  }
              }
              ptot.textContent = total;
            }

            for (var i in options) {
                  options[i].addEventListener('change', updateTotalPrice);
            }
      </script>

        <br><br>
        <div class="afterimage">
                <span class="first-afterimage">Nous contacter :</span>
                <p>Email : contact@campingextreme.com<br/>Téléphone : 01 23 45 67 89</p>
                <br/>
        </div>

        <script src="../javascript/chg_theme.js"></script>
    </body>
</php>

