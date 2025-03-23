<?php
    include 'fonctions.php';
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

        <?php bandeau("recherche");?>
        
        <form action="recherche.php" method="post">
            <fieldset class="recherche">
                <legend>Filtres</legend>
                <div class="filtre">
                    <label for="lieu">Lieu</label>
                    <input class="recherche" type="text" name="lieu"> 
                </div>
                <div class="filtre">
                    <label for="depart">Date de départ</label>
                    <input class="recherche" type="Date" name="depart"> 
                </div>
                <div class="filtre">
                    <label for="duree">Durée (jours)</label>
                    <input class="recherche" type="number" name="duree" maxlength="3" min="1">  
                </div>                
            </fieldset>

            <fieldset class="recherche">
                <div class="filtre">
                    <label for="budget">Budget</label>
                    <input class="recherche" type="range" name="budget" min="10" max="10000" value="1000">
                </div>   
                <div class="filtre">
                    <label for="nbpersonnes">Nombre de personnes</label>
                    <input class="recherche" type="number" name="nbpersonnes" min="1" max="10" value="1">
                </div>   
                <!--Sélectionnez votre destination
                <map name="map">
                </map>-->                 
            </fieldset>

            <fieldset class="recherche">
                <div class="filtre">
                    <label for="vacances">Type de vacances</label>
                    <div>
                        Plage<input class="recherche" type="checkbox" name="vacances" value="plage">
                        Montagne<input class="recherche" type="checkbox" name="vacances" value="montagne">
                        Ville <input class="recherche" type="checkbox" name="vacances" value="ville">
                        Forêt<input class="recherche" type="checkbox" name="vacances" value="forêt">
                    </div>
                </div>   
                <div class="filtre">
                    <label for="randonnée">Randonnée</label>
                    <div>
                        Oui<input class="recherche" type="radio" name="randonnée" value="oui">
                        Non<input class="recherche" type="radio" name="randonnée" value="non">
                    </div>
                </div>   
                <div class="filtre">
                    <label for="douches">Douches</label>
                    <div>
                        Oui<input class="recherche" type="radio" name="douches" value="oui">
                        Non<input class="recherche" type="radio" name="douches" value="non">
                    </div>
                </div>              
            </fieldset>

            <fieldset class="recherche">
                <label for="search">Recherche :</label>
                <input class="recherche" type="text" name="search">
            </fieldset>

            <div class="voyages">
            <?php 
                $json_voyages=file_get_contents("../json/voyages.json");
                $voyages=json_decode($json_voyages, true);
                $count=0;

                $recherche=$_POST["search"];
                foreach($voyages as $k=> $voyage){
                    if(strpos($voyage["mots_cles"], $recherche)!==false && $recherche!=""){
                        if(($count)%3==0){
                            echo '<div class="grpV">';
                        }
                        echo '<div class="itineraire">';
                        echo '<a href="voyage.php?id='.$k.'"><img src="'.$voyage["image"].'" class="imgVoyage" alt="photo_voyage"/></a>';
                        echo '<div class="titreVoyage">'.$voyage["titre"].'</div>';          
                        echo '</div>'; 
                        if(($count+1)%3 == 0){
                            echo '</div>';
                        }     
                        $count++;  
                    }
                }
                if($count%3 != 0){
                        echo '</div>';
                }
            ?>
            </div>

            <fieldset class="recherche">
                <button class="recherche" type="reset" name="reset">Supprimer les filtres</button>
                <button class="recherche" type="submit" name="submit">Rechercher</button>
            </fieldset>
        </form>
   
        <h3 class="voyages">Recommendations</h3>

        <div class="voyages all">
        <?php 
            foreach($voyages as $k=> $voyage){
                if(isset($voyage)){
                    echo '<div class="itineraire">';
                    echo '<a href="voyage.php?id='.$k.'"><img src="'.$voyage["image"].'" class="imgVoyage" alt="photo_voyage""/></a>';
                    echo '<div class="titreVoyage">'.$voyage["titre"].'</div>';   
                    echo '</div>';                
                }
            }
        ?>
        </div>

        <br><br>
        <div class="afterimage">
                <span class="first-afterimage">Nous contacter :</span>
                <p>Email : contact@campingextreme.com<br/>Téléphone : 01 23 45 67 89</p>
                <br/>
        </div>
    </body>
</php>

