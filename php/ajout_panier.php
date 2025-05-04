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
        <title>camping de l'extreme - Recap</title>
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
            $users=get_data("../json/utilisateurs.json");
            $json_voyages=file_get_contents("../json/voyages.json");
            $voyages=json_decode($json_voyages, true);

            $id=$_POST["id"];
            $total=$_POST["total"];

            //pour chaque étape, on ajoute les options sélectionnées dans un tableau
            foreach($voyages[$id]["etapes"] as $k=> $etape){
                foreach($etape["option"] as $i=>$option){
                    //Si l'option est sélectionnée on met le nom de l'option dans le tableau sinon une chaîne vide
                    if(isset($_POST['option'.$k.$i])){
                        $options[$k][$i] = $_POST['option'.$k.$i] ;
                    }
                    else{
                        $options[$k][$i] = "";
                    }
                }
            }
            //ajout des données dans le panier de l'utilisateur
            array_push($users[$_SESSION["user_index"]-1]["voyages_panier"], array(
                "id"=>intval($id),
                "total"=>intval($total),
                "options"=>$options 
            ));

            file_put_contents('../json/utilisateurs.json', json_encode($users, JSON_PRETTY_PRINT));
        ?>
            
        <div class="voyages">
        <h3>Le voyage a bien été ajouté à votre panier</h3>

        <a href = "recherche.php"><button>Chercher un autre voyage</button></a>
        <a href = "profil.php"><button>Aller au panier</button></a>

        </div>

        <br><br>
        <div class="afterimage">
                <span class="first-afterimage">Nous contacter :</span>
                <p>Email : contact@campingextreme.com<br/>Téléphone : 01 23 45 67 89</p>
                <br/>
        </div>
        
        <script src="../javascript/chg_theme.js"></script>
    </body>
</php>
