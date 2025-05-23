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
        <h1 class="titre">
            Camping de l'Extreme <img src="../images/logo.png" class="logo" alt="logo de l'image"/>
            <button class="chg_theme"> 
                <img src="../images/mode_sombre.png" class="mode_sombre" alt="Mode sombre"/>
            </button>
        </h1>

        <a class="accueil" href="accueil.php">Accueil</a><br/>

        <?php bandeau("panier");?>

        <?php
                //Après paiement
                if(isset($_GET["transaction"]) && $_GET["transaction"]=="154632ABCD"){
                        echo '
                        <fieldset class="formulaire voyages">';
                        if (isset($_GET["status"]) && $_GET["status"]=="accepted"){
                                //on rajoute les voyages du panier dans les voyages achetés
                                $users[$_SESSION["user_index"]-1]["voyages_achete"]=array_merge($users[$_SESSION["user_index"]-1]["voyages_achete"],$users[$_SESSION["user_index"]-1]["voyages_panier"]);
                                //on incrémente le nombre de personnes de chaque voyage qui est dans le panier
                                foreach($user["voyages_panier"] as $k=> $panier){
                                        $voyages[$panier["id"]]["nb_personnes"]++;
                                }
                                //on supprime les voyages du panier                            
                                $users[$_SESSION["user_index"]-1]["voyages_panier"] = [];

                                echo '<div class="panier">Votre panier a été acheté</div>';
                        }
                        else{
                                echo '<div class="panier">L\'achat de votre panier a échoué</div>';
                        }
                        echo '</fieldset>';
                }
                else{
                        echo '
                        <fieldset class="formulaire achat">
                        <legend>Panier :</legend>';
                        $sum=0;
                        if(empty($user["voyages_panier"])){
                                echo '<p>Votre panier est vide</p>
                                        <p>Trouvez vos <a href="recherche.php">nouveaux voyages</a></p>';
                        }
                        else{
                                //affichage des informations de chaque voyage du panier
                                foreach($user["voyages_panier"] as $k=> $panier){
                                        $date_start = date("d/m/Y", strtotime($voyages[$panier["id"]]["depart"]));
                                        $date_end = date("d/m/Y", strtotime($voyages[$panier["id"]]["fin"]));
                                        echo '<a href="voyage.php?id='.$panier["id"].'"><img src="'.$voyages[$panier["id"]]["image"].'" class="imgVoyage_achat" alt="photo_voyage""/></a>
                                        <div class="achat"><b>'.$voyages[$panier["id"]]["titre"].'</b>
                                        <br><br><br><b>Description :</b> '.$voyages[$panier["id"]]["description"].'<br><br>

                                        <b>De</b> '.$date_start.' <b>à</b> '.$date_end.
                                        '<br><b>Durée :</b> '.$voyages[$panier["id"]]["duree"].' jours
                                        <br><br><b>Prix de base :</b> '.$voyages[$panier["id"]]["prix"].' €
                                        <br><b>Prix total :</b> '.$panier["total"].' €
                                        </div><br><p></p>';
                                        //ajout du prix du voyage au prix total du panier
                                        $sum+=$panier["total"];
                                }

                                echo '</fieldset>';
                        }
                        //formulaire de paiement
                        echo '<fieldset class="formulaire">
                        <p class="prix_total"><b>Total :</b> '.$sum.'€</p>
                        <form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
                                <input type="hidden" name="transaction" value="154632ABCD">
                                <input type="hidden" name="montant" value="'.$sum.'">
                                <input type="hidden" name="vendeur" value="MI-4_J">
                                <input type="hidden" name="retour" value="http://localhost:8080/php/achat.php?session=s">
                                <input type="hidden" name="control" value="'.md5(getAPIKey("MI-4_J") . "#" . "154632ABCD" . "#" . $sum . "#" . "MI-4_J" . "#" . "http://localhost:8080/php/achat.php?session=s" . "#").'">
                                
                                <input class="payer" type="submit" value="Valider et payer">
                        </form>
                        </fieldset>';
                }
                file_put_contents('../json/utilisateurs.json', json_encode($users, JSON_PRETTY_PRINT));
                file_put_contents('../json/voyages.json', json_encode($voyages, JSON_PRETTY_PRINT));
        ?>


        <br><br>
        <div class="afterimage">
                <span class="first-afterimage">Nous contacter :</span>
                <p>Email : contact@campingextreme.com<br/>Téléphone : 01 23 45 67 89</p>
                <br/>
        </div>
        <script src="../javascript/chg_theme.js"></script>
    </body>
</php>
