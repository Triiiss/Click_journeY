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
        
        <form action="recherche.php">
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

            <fieldset class="recherche">
                <button class="recherche" type="reset" name="reset">Supprimer les filtres</button>
                <button class="recherche" type="submit" name="submit">Rechercher</button>
            </fieldset>
        </form>
   
        <h3 class="reco">Recommendations</h3>

        <div class="reco">
        <?php 
            session_start();
            $json_voyages=file_get_contents("../json/voyages.json");
            $voyages=json_decode($json_voyages, true);

            for($i=0;$i<10;$i++){
                if(isset($voyages[$i])){
                    echo '<div class="titreVoyage">'.$voyages[$i]["titre"].'</div>';
                    echo '<img src="'.$voyages[$i]["image"].'" class="imgVoyage" alt="photo_voyage"/>';
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

