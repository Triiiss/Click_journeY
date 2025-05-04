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
            $json_voyages=file_get_contents("../json/voyages.json");
            $voyages=json_decode($json_voyages, true);

            //On récupère l'id, le prix total et les options choisies du voyage

            //cas où la page est accédée depuis le panier
            if(isset($_POST["idPanier"])){
                $users=get_data("../json/utilisateurs.json");
                if($users===null){
                    echo "<p>Problème de récupération des données côté serveur</p>";
                }
                $user=$users[$_SESSION["user_index"]-1];

                $idPanier=$_POST["idPanier"];
                $id=$user["voyages_panier"][$idPanier]["id"];
                $total=$user["voyages_panier"][$idPanier]["total"];
                $options=$user["voyages_panier"][$idPanier]["options"];
            }
            //cas où la page est accédée depuis la liste des voyages achetés
            else if(isset($_POST["idAchat"])){
                $users=get_data("../json/utilisateurs.json");
                if($users===null){
                    echo "<p>Problème de récupération des données côté serveur</p>";
                }
                $user=$users[$_SESSION["user_index"]-1];

                $idAchat=$_POST["idAchat"];
                $id=$user["voyages_achete"][$idAchat]["id"];
                $total=$user["voyages_achete"][$idAchat]["total"];
                $options=$user["voyages_achete"][$idAchat]["options"];
            }
            //cas où la page est accédée depuis la recherche
            else{
                $id=$_POST["id"];
                $total=$voyages[$id]["prix"];

                foreach($voyages[$id]["etapes"] as $k=> $etape){
                    foreach($etape["option"] as $i=>$option){
                        if(isset($_POST['option'.$k.$i])){
                            $options[$k][$i] = explode(';',$_POST['option'.$k.$i])[0] ;
                            $total+=explode(';',$_POST['option'.$k.$i])[1];
                        }
                        else{
                            $options[$k][$i] = "";
                        }
                    }
                }
            }

            echo '<div class=voyages>';
                echo '<img src="'.$voyages[$id]["image"].'" class="imgDetail" alt="photo_voyage""/>';
                echo '<div class=recap>';
                    echo '<div>'.$voyages[$id]["titre"].'</div>';
                    echo '<div>'.$voyages[$id]["description"].'</div>';
                    echo '<div>Prix de base: '.$voyages[$id]["prix"].'euros'.'</div>';
                    echo '<div>Prix total: '.$total.'euros'.'</div>';
                    echo '<div>Départ le '.$voyages[$id]["depart"].'</div>';
                    echo '<div>Durée : '.$voyages[$id]["duree"].'</div>'; 
                    
                    echo '<div>Options : </div>';

                    foreach($voyages[$id]["etapes"] as $k => $etape){
                        echo '<div>'.$etape["titre"].'</div>';
                        $optExiste=0;
                        foreach($etape["option"] as $i=>$option){
                            if($options[$k][$i]!=""){
                                echo '<div>'.$options[$k][$i].'</div>';
                                $optExiste=1;
                            }
                        }
                        if($optExiste==0){
                            echo '<div>Aucune option<div>';
                        }
                    }

                    if(!isset($_POST["type"]) || $_POST["type"] != achete){
                        echo '<form action="ajout_panier.php" method="post">

                        <input type="hidden" name="id" value="'.$id.'"></input>
                        <input type="hidden" name="total" value="'.$total.'"></input>';

                        foreach($voyages[$id]["etapes"] as $k => $etape){ 
                            foreach($etape["option"] as $i=>$option){
                                echo '<input type="hidden" name="option'.$k.$i.'" value="'.$options[$k][$i].'">';
                            }
                        }

                        if(isset($_POST["idAchat"])==false){
                            echo '<a href = "voyage.php?id='.$id.'"><button type="button">Modifier</button></a>';
                        }

                        if(isset($_POST["id"])){
                            echo' <button type="submit" name="submit">Ajouter au panier</button>';
                        }
                        echo '</form>';
                    }
                    

                echo '</div>';
            echo '</div>';

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
