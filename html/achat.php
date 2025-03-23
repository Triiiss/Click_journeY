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

        <fieldset class="formulaire connexion">
                <legend>Panier :</legend>
                        <?php
                                $sum=0;
                                if(empty($user["voyages_panier"])){
                                        echo '<p>Votre panier est vide</p>
                                                <p>Trouvez vos <a href="rercherche.php">nouveaux voyages</a></p>';
                                }
                                else{
                                        foreach($user["voyages_panier"] as $k=> $panier){
                                                echo '<a href="voyage.php?id='.$panier.'"><img src="'.$voyages[$panier]["image"].'" class="imgVoyage" alt="photo_voyage""/></a>
                                                <p>'.$voyages[$panier]["titre"].'<br><br><br>de '.$voyages[$panier]["depart"].' à '.$voyages[$panier]["fin"].'<br>Durée '.$voyages[$panier]["duree"].'<br><br>Description '.$voyages[$panier]["description"].'<br><br>Prix '.$voyages[$panier]["prix"].'</p>';
                                                $sum+=$voyages[$panier]["prix"];
                                        }

                                        echo '<p class="empty">a</p><p></p>
                                        <p>Total :</p> <p>'.$sum.'€</p>';
                                }
                        ?>
        </fieldset> 

        <form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
                <fieldset class="formulaire">
                        <label for="titulaire">Titulaire :</label>
                        <input type="text" maxlength="8" pattern="[a-zA-Z]*" name="titulaire" placeholder="<?php echo $_SESSION["login"]; ?>" required>

                        <label for="carte_numero">Numéro de carte :</label>
                        <input type="text" name="carte_numero" pattern="[0-9]{16}" placeholder="5555 1234 5678 9000" required>
                        
                        <label for="carte_expiration">Date d'expiration :</label>
                        <input type="text"  name="carte_expiration" required>
                        
                        <label for="carte_cryptogramme">Cryptogramme (CVV) :</label>
                        <input type="text" name="carte_cryptogramme" pattern="[0-9]{3}" placeholder="555" required>

                        <?php if(isset($_POST["carte_numero"]) && isset($_POST["carte_cryptogramme"])){
                                $transaction= $_POST["carte_numero"].$_POST["carte_cryptogramme"];
                        }?>
                        
                        <input type="hidden" name="transaction" value="<?php echo $transaction; ?>">
                        <input type="hidden" name="montant" value="<?php echo $sum; ?>">
                        <input type="hidden" name="vendeur" value="MI-4_J">
                        <input type="hidden" name="retour" value="localhost:8080/html/achat.php">
                        <input type="hidden" name="control" value="<?php echo md5(getAPIKey("MI-4_J") . "#" . $transaction . "#" . $sum . "#" . "MI-4_J" . "#" . "localhost:8080/html/achat.php" . "#"); ?>">
                        
                        <input type="submit" value="Valider et payer">
                </fieldset>
        </form>

    </body>
</php>