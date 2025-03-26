<?php
        include 'fonctions.php';
        session_start();
        if(empty($_SESSION["connexion"]) || $_SESSION["connexion"]!="connected"){
            header("Location :accueil.php");
        }

        $users=get_data("../json/utilisateurs.json");
        if($users===null){
            echo "<p>Problème de récupération des données côté serveur</p>";
        }
        $voyages=get_data("../json/voyages.json");
        if($voyages===null){
            echo "<p>Problème de récupération des données côté serveur</p>";
        }
        $user=$users[$_SESSION["user_index"]-1];
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

        <?php bandeau("panier");?>

        <?php
                if(isset($_GET["transaction"]) && $_GET["transaction"]=="154632ABCD"){
                        echo '
                        <fieldset class="formulaire connexion">';
                        if (isset($_GET["status"]) && $_GET["status"]=="accepted"){

                                $users[$_SESSION["user_index"]-1]["voyages_achete"]=array_merge($users[$_SESSION["user_index"]-1]["voyages_achete"],$users[$_SESSION["user_index"]-1]["voyages_panier"]);                            
                                $users[$_SESSION["user_index"]-1]["voyages_panier"] = [];

                                echo 'Votre panier a été acheté';
                        }
                        else{
                                echo 'L\'achat de votre panier a échoué';
                        }
                        echo '</fieldset>';
                }
                else{
                        echo '
                        <fieldset class="formulaire">
                        <legend>Panier :</legend>';
                        $sum=0;
                        if(empty($user["voyages_panier"])){
                                echo '<p>Votre panier est vide</p>
                                        <p>Trouvez vos <a href="rercherche.php">nouveaux voyages</a></p>';
                        }
                        else{
                                foreach($user["voyages_panier"] as $k=> $panier){
                                        echo '<a href="voyage.php?id='.$panier["id"].'"><img src="'.$voyages[$panier["id"]]["image"].'" class="imgVoyage" alt="photo_voyage""/></a>
                                        <p><b>'.$voyages[$panier["id"]]["titre"].'</b>
                                        <br><br><br>de '.$voyages[$panier["id"]]["depart"].' à '.$voyages[$panier["id"]]["fin"].
                                        '<br>Durée : '.$voyages[$panier["id"]]["duree"].
                                        '<br><br>Description : '.$voyages[$panier["id"]]["description"].
                                        '<br><br>Prix de base : '.$voyages[$panier["id"]]["prix"].' €
                                        <br><br>Prix total : '.$panier["total"].' €
                                        </p>';
                                        $sum+=$panier["total"];
                                }

                                echo '<p class="empty">a</p><p></p>
                                <p></p> <p><b>Total :</b> '.$sum.'€</p>';
                        }
                        echo '<p></p>
                        <form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
                                <input type="hidden" name="transaction" value="154632ABCD">
                                <input type="hidden" name="montant" value="'.$sum.'">
                                <input type="hidden" name="vendeur" value="MI-4_J">
                                <input type="hidden" name="retour" value="http://localhost:8080/html/achat.php?session=s">
                                <input type="hidden" name="control" value="'.md5(getAPIKey("MI-4_J") . "#" . "154632ABCD" . "#" . $sum . "#" . "MI-4_J" . "#" . "http://localhost:8080/html/achat.php?session=s" . "#").'">
                                
                                <input type="submit" value="Valider et payer">
                        </form>
                        </fieldset> ';
                }
                file_put_contents('../json/utilisateurs.json', json_encode($users, JSON_PRETTY_PRINT));
        ?>



    </body>
</php>