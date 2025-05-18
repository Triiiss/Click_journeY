<?php
    include 'fonctions.php';
    session_start();

    if(empty($_SESSION["connexion"]) || $_SESSION["connexion"]!="connected"){
        header("Location: accueil.php");
    }
    if(isset($_POST["deco"]) || empty($_SESSION["user_index"])){
        session_destroy();
        header("Location: accueil.php");
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
        <script src="../javascript/informations.js"></script>
        <h1 class="titre">Camping de l'Extreme <img src="../images/logo.png" class="logo" alt="logo de l'image"/>
            <button class="chg_theme"> 
                <img src="../images/mode_sombre.png" class="mode_sombre" alt="Mode sombre"/>
            </button></h1>
        <a class="accueil" href="accueil.php">Accueil</a><br/>

        <?php bandeau("profil");?>


        <fieldset class="formulaire voyages">
                <legend>Voyages</legend>
    
                <?php
                    //suppression voyage
                    for($i=max(count($user["voyages_favoris"]),count($user["voyages_panier"]));$i>=0;$i--){
                        if(isset($_POST['supp_'.$user["login"].'_panier_'.$i])){
                            unset($user["voyages_panier"][$i]);
                            unset($users[$_SESSION["user_index"]-1]["voyages_panier"][$i]);

                            $user["voyages_panier"] = array_values($user["voyages_panier"]);
                            $users[$_SESSION["user_index"]-1]["voyages_panier"] = array_values($users[$_SESSION["user_index"]-1]["voyages_panier"]);
                        }
                        //voyage favoris pas encore implémentée
                        /*
                        if(isset($_POST["supp_".$user['login']."_favoris_".$i])){
                            unset($user["voyages_favoris"][$i]);
                            unset($users[$_SESSION["user_index"]-1]["voyages_favoris"][$i]);

                            $user["voyages_favoris"] = array_values($user["voyages_favoris"]);
                            $users[$_SESSION["user_index"]-1]["voyages_favoris"] = array_values($users[$_SESSION["user_index"]-1]["voyages_favoris"]);
                        }
                        */
                    }
                    file_put_contents('../json/utilisateurs.json', json_encode($users, JSON_PRETTY_PRINT));

                    echo '<div class="all">';

                    //afichage panier
                    echo '<p>----------------------------</p><p>---------Panier : --------</p> <p>-<button class="admin"><a class="acheter" href="achat.php">Payer le panier</a></button>-</p>
                    <p class="empty">d</p><p></p><p></p>';
                    if(empty($user["voyages_panier"])){
                        echo '<p></p><p>Vous n\'avez pas de voyages dans votre panier</p>';
                    }
                    else{
                        if(count($user["voyages_panier"]) <= 3 || isset($_POST["plus_panier"])){
                            foreach ($user["voyages_panier"] as $i=>$panier){
                                echo '<div class="itineraire">
                                    <form action="recap.php" method="post">
                                        <input type="hidden" name="idPanier" value="'.$i.'"></input>
                                        <input type="image" src="'.$voyages[$panier["id"]]["image"].'" class="imgVoyage" alt="photo_voyage"></input>
                                    </form>

                                    <form action="profil.php" method="post" enctype="multipart/form-data">
                                        <div class="titreVoyage">'.$voyages[$panier["id"]]["titre"].
                                        '<button type="submit" class="edit_icon" name="supp_'.$user['login'].'_panier_'.$i.'">X</button>
                                        </div>
                                    </form>
                                    
                                </div>';
                            }
                        }
                        else{
                            for($i=0;$i<3;$i++){
                                echo '<div class="itineraire">
                                    <form action="recap.php" method="post">
                                        <input type="hidden" name="idPanier" value="'.$i.'"></input>
                                        <input type="image" src="'.$voyages[$user["voyages_panier"][$i]["id"]]["image"].'" class="imgVoyage" alt="photo_voyage"></input>
                                    </form>

                                    <form action="profil.php" method="post" enctype="multipart/form-data">
                                        <div class="titreVoyage">'.$voyages[$user["voyages_panier"][$i]["id"]]["titre"].'<button type="submit" class="edit_icon" name="supp_'.$user['login'].'_panier_'.$i.'">X</button></div>
                                    </form>

                                </div>';
                            }
                            echo '<p></p>
                            <form action="profil.php" method="post" enctype="multipart/form-data">
                                <p colspan="5"><input type="submit" class="admin" name="plus_panier" value="Voir plus"></p>
                            </form>';
                        }
                    }
                    echo '</div>';

                    echo '<div>';
                        if(isset($_POST["plus_panier"])){
                            echo '<tr>
                                <form action="profil.php" method="post" enctype="multipart/form-data">
                                    <td colspan="5"><input type="submit" class="admin" value="Voir moins"></td>
                                </form>
                            </tr>';
                            }
                    echo '</div>';

                    /*echo '
                    <p class="empty">d</p><p></p><p></p><p class="empty">.</p><p>----------------------------Favoris :----------------------------</p>
                    <p class="empty">d</p><p></p><p></p>';
                    if(empty($user["voyages_favoris"])){
                        echo '<p></p><p>Vous n\'avez pas de voyages favoris</p>';
                    }
                    else{
                        echo '<div class="all">';
                        if(count($user["voyages_favoris"]) < 3 || isset($_POST["plus_favoris"])){
                            foreach ($user["voyages_favoris"] as $favoris){
                                echo '<div class="itineraire">
                                    <a href="voyage.php?id='.$favoris.'"><img src="'.$voyages[$favoris]["image"].'" class="imgVoyage" alt="photo_voyage""/></a>
                                    <div class="titreVoyage">'.$voyages[$favoris]["titre"].'<button type="submit" class="edit_icon" name="supp_'.$user['login'].'_favoris_'.$i.'">X</button></div>
                                </div>';
                            }
                            if(isset($_POST["plus_favoris"])){
                                echo '<tr>
                                    <td colspan="5"><input type="submit" class="admin" value="Voir moins"></td>
                                </tr>';
                            }
                        }
                        else{
                            for($i=0;$i<3;$i++){
                                echo '<div class="itineraire">
                                    <a href="voyage.php?id='.$user["voyages_favoris"][$i].'"><img src="'.$voyages[$user["voyages_favoris"][$i]]["image"].'" class="imgVoyage" alt="photo_voyage""/></a>
                                    <div class="titreVoyage">'.$voyages[$user["voyages_favoris"][$i]]["titre"].'<button type="submit" class="edit_icon" name="supp_'.$user['login'].'_favoris_'.$i.'">X</button></div>
                                </div>';
                            }
                            echo '<p></p>
                                <p colspan="5"><input type="submit" class="admin" name="plus_favoris" value="Voir plus"></p>';
                        }
                        echo '</div>';
                    }*/

                    //affichage voyages achetés
                    echo '<p class="empty">.</p><p>----------------------------Voyages achetés :----------------------------</p><p class="empty">.</p>
                        <table class="achat">';

                    if(empty($user["voyages_achete"])){
                        echo '<th class="empty"></th><th>Vous n\'avez pas encore achetés de voyages</th>';
                    }
                    else{
                        echo '<tr>
                            <th>Titre</th>
                            <th>Lieu</th>
                            <th>Date de début</th>
                            <th>Durée</th>
                            <th>Prix</th>
                        </tr>';
                        if (count($user["voyages_achete"]) < 5 || isset($_POST["plus_achat"])){
                            foreach ($user["voyages_achete"] as $i =>$achat){
                                echo '<tr class="voyages_achat">
                                    <td>
                                    <form action="recap.php" method="post">
                                        <input type="hidden" name="idAchat" value="'.$i.'"></input>
                                        <button type="submit" name="submit">'.$voyages[$achat["id"]]["titre"].'</button>
                                    </form>
                                    </td>

                                    <td>'.$voyages[$achat["id"]]["lieu"].'</td>
                                    <td>'.$voyages[$achat["id"]]["depart"].'</td>
                                    <td>'.$voyages[$achat["id"]]["duree"].' jours</td>
                                    <td>'.$achat["total"].'€</td>
                                </tr>';
                            }
                            if(isset($_POST["plus_achat"])){
                                echo '<tr>
                                    <form action="profil.php" method="post" enctype="multipart/form-data">
                                        <td colspan="5"><input type="submit" class="admin" value="Voir moins"></td>
                                    </form>
                                </tr>';
                            }
                        }
                        else{
                            for($i=0;$i<5;$i++){
                                echo '<tr class="voyages_achat">
                                    <td>
                                    <form action="recap.php" method="post">
                                        <input type="hidden" name="idAchat" value="'.$i.'"></input>
                                        <button type="submit" name="submit">'.$voyages[$user["voyages_achete"][$i]["id"]]["titre"].'</button>
                                    </form>
                                    </td>

                                    <td>'.$voyages[$user["voyages_achete"][$i]["id"]]["lieu"].'</td>
                                    <td>'.$voyages[$user["voyages_achete"][$i]["id"]]["depart"].'</td>
                                    <td>'.$voyages[$user["voyages_achete"][$i]["id"]]["duree"].' jours</td>
                                    <td>'.$user["voyages_achete"][$i]["total"].'€</td>
                                </tr>';
                            }
                            echo '<tr>  
                                <form action="profil.php" method="post" enctype="multipart/form-data">
                                    <td colspan="5"><input type="submit" class="admin" name="plus_achat" value="Voir plus"></td>
                                </form>
                            </tr>';
                        }
                    }
                    echo '</table>';
                ?>
            </fieldset>

            <br>

            <!--AFFICHAGE INFOS UTILISATEUR-->
            <form id="form_profil" action="profil.php" method="POST" enctype="multipart/form-data">
                <fieldset class="formulaire profil">
                <?php
                    if (file_exists("../images/profil_picture/profil_picture_".$_SESSION['login'])){
                        echo '<legend>Profil <img src="../images/profil_picture/profil_picture_'.$_SESSION['login'].'" class="profil_picture"/></legend>';
                    }
                    else{
                        
                        echo '<legend>Profil <img src="../images/profil_picture/default.webp" class="profil_picture"/></legend>';
                    }
                ?>

                
                <?php

                        /*Changer les informations */
                        if(isset($_POST["supp"])){ //Supression compte
                            unset($users[$_SESSION["user_index"]-1]);
                            $users=array_values($users);
                            session_destroy();
                            file_put_contents('../json/utilisateurs.json', json_encode($users, JSON_PRETTY_PRINT));
                            header("Location: accueil.php");
                        }

                        if(isset($_POST["profil_picture"])){
                            $photo = $_FILES["profil_picture_value"];
                            
                            if($photo["size"] <= 2000000 && $photo["error"] === UPLOAD_ERR_OK){       /*Taille de la photo */
                                move_uploaded_file($photo['tmp_name'], "../images/profil_picture/profil_picture_".$user['login']);
                            }
                        }

                        if(isset($_POST["new_login"])){
                            $newlogin=new_login($_POST["new_login_value"],"../json/utilisateurs.json");

                            if($newlogin == 1){
                                $users[$_SESSION["user_index"]-1]['login'] = $_POST["new_login_value"];
                                $user['login'] = $_POST["new_login_value"];
                            }

                        }
                        if(isset($_POST["new_mdp"]) && !empty($_POST["new_mdp_value"])){
                            $safemdp=password_safe($_POST["new_mdp_value"]);
                            
                            if ($safemdp==1){
                                $users[$_SESSION["user_index"]-1]['mdp'] = $_POST["new_mdp_value"];
                                $user['mdp'] = $_POST["new_mdp_value"];
                            }
                            else{
                                echo '<td>Le mot de passe n\'est pas assez sécurisé</td>';
                            }
                        }
                        if(isset($_POST["new_email"]) && !empty($_POST["new_email_value"])){
                            $users[$_SESSION["user_index"]-1]['email'] = $_POST["new_email_value"];
                            $user['email'] = $_POST["new_email_value"];
                        }
                        if(isset($_POST["new_nom"]) && !empty($_POST["new_nom_value"])){
                            $users[$_SESSION["user_index"]-1]['profil']['nom'] = $_POST["new_nom_value"];
                            $user['profil']['nom'] = $_POST["new_nom_value"];
                        }
                        if(isset($_POST["new_prenom"]) && !empty($_POST["new_prenom_value"])){
                            $users[$_SESSION["user_index"]-1]['profil']['prenom'] = $_POST["new_prenom_value"];
                            $user['profil']['prenom'] = $_POST["new_prenom_value"];
                        }
                        if(isset($_POST["new_adresse"]) && !empty($_POST["new_adresse_value"])){
                            $users[$_SESSION["user_index"]-1]['profil']['adresse'] = $_POST["new_adresse_value"];
                            $user['profil']['adresse'] = $_POST["new_adresse_value"];
                        }
                        if(isset($_POST["new_tel"]) && !empty($_POST["new_tel_value"])){
                            $users[$_SESSION["user_index"]-1]['profil']['tel'] = $_POST["new_tel_value"];
                            $user['profil']['tel'] = $_POST["new_tel_value"];
                        }
                        if(isset($_POST["new_dob"]) && !empty($_POST["new_dob_value"])){
                            $users[$_SESSION["user_index"]-1]['profil']['dob'] = $_POST["new_dob_value"];
                            $user['profil']['dob'] = $_POST["new_dob_value"];
                        }
                        if(isset($_POST["new_genre"]) && !empty($_POST["new_genre_value"])){
                            $users[$_SESSION["user_index"]-1]['profil']['genre'] = $_POST["new_genre_value"];
                            $user['profil']['genre'] = $_POST["new_genre_value"];
                        }


                        /*Afficher les informations */
                        echo '<p>Identifiant :</p>';
                        echo '
                        <p><span class="login_info_">'.$user['login'].' </span>
                        <span class="hidden login_edit_"><input class="modifier" type="text" name="new_login_value" placeholder="'.$user['login'].'"/></span></p>

                        <p><span class="login_info_"><button type="button" class="edit_icon" onclick="edit_infos(\'\',\'login\')"><img class="edit_icon" src="../images/edit_icon.png"/></button></span>
                        <span class="hidden login_edit_"><input class="admin" type="submit" name="new_login" value="Valider" onclick="waiting_time(event,\'form_profil\')"/><input class="edit_icon" type="button" value="X" onclick="cancel_edit(\'\',\'login\')"/></span></p>';


                        echo '<p>Mot de passe :</p>';
                        echo '
                        <p><span class="mdp_info_">'.$user['mdp'].' </span>
                        <span class="hidden mdp_edit_"><input class="modifier" type="text" name="new_mdp_value" placeholder="'.$user['mdp'].'"/></span></p>

                        <p><span class="mdp_info_"><button type="button" class="edit_icon" onclick="edit_infos(\'\',\'mdp\')"><img class="edit_icon" src="../images/edit_icon.png"/></button></span>
                        <span class="hidden mdp_edit_"><input class="admin" type="submit" name="new_mdp" value="Valider" onclick="waiting_time(event,\'form_profil\')"/><input class="edit_icon" type="button" value="X" onclick="cancel_edit(\'\',\'mdp\')"/></span></p>';


                        echo '<p>E-mail : </p>';
                        echo '
                        <p><span class="email_info_">'.$user['email'].' </span>
                        <span class="hidden email_edit_"><input class="modifier" type="text" name="new_email_value" placeholder="'.$user['email'].'"/></span></p>

                        <p><span class="email_info_"><button type="button" class="edit_icon" onclick="edit_infos(\'\',\'email\')"><img class="edit_icon" src="../images/edit_icon.png"/></button></span>
                        <span class="hidden email_edit_"><input class="admin" type="submit" name="new_email" value="Valider" onclick="waiting_time(event,\'form_profil\')"/><input class="edit_icon" type="button" value="X" onclick="cancel_edit(\'\',\'email\')"/></span></p>';
            

                        echo '<p>Prénom :</p>';
                        echo '
                        <p><span class="prenom_info_">'.$user['profil']['prenom'].' </span>
                        <span class="hidden prenom_edit_"><input class="modifier" type="text" name="new_prenom_value" placeholder="'.$user['profil']['prenom'].'"/></span></p>

                        <p><span class="prenom_info_"><button type="button" class="edit_icon" onclick="edit_infos(\'\',\'prenom\')"><img class="edit_icon" src="../images/edit_icon.png"/></button></span>
                        <span class="hidden prenom_edit_"><input class="admin" type="submit" name="new_prenom" value="Valider" onclick="waiting_time(event,\'form_profil\')"/><input class="edit_icon" type="button" value="X" onclick="cancel_edit(\'\',\'prenom\')"/></span></p>';
                        

                        echo '<p>Nom :</p>';
                        echo '
                        <p><span class="nom_info_">'.$user['profil']['nom'].' </span>
                        <span class="hidden nom_edit_"><input class="modifier" type="text" name="new_nom_value" placeholder="'.$user['profil']['nom'].'"/></span></p>

                        <p><span class="nom_info_"><button type="button" class="edit_icon" onclick="edit_infos(\'\',\'nom\')"><img class="edit_icon" src="../images/edit_icon.png"/></button></span>
                        <span class="hidden nom_edit_"><input class="admin" type="submit" name="new_nom" value="Valider" onclick="waiting_time(event,\'form_profil\')"/><input class="edit_icon" type="button" value="X" onclick="cancel_edit(\'\',\'nom\')"/></span></p>';
                        

                        echo '<p>Numéro de téléphone :</p>';
                        echo '
                        <p><span class="tel_info_">'.$user['profil']['tel'].' </span>
                        <span class="hidden tel_edit_"><input class="modifier" type="text" name="new_tel_value" placeholder="'.$user['profil']['tel'].'"/></span></p>

                        <p><span class="tel_info_"><button type="button" class="edit_icon" onclick="edit_infos(\'\',\'tel\')"><img class="edit_icon" src="../images/edit_icon.png"/></button></span>
                        <span class="hidden tel_edit_"><input class="admin" type="submit" name="new_tel" value="Valider" onclick="waiting_time(event,\'form_profil\')"/><input class="edit_icon" type="button" value="X" onclick="cancel_edit(\'\',\'tel\')"/></span></p>';
                        

                        echo '<p>Date de naissance :</p>';
                        echo '<p><span class="dob_info_">'.date("d/m/Y", strtotime($user['profil']['dob'])).' </span>
                        <span class="hidden dob_edit_"><input class="modifier" type="text" name="new_dob_value" placeholder="'.date("d/m/Y", strtotime($user['profil']['dob'])).'"/></span></p>

                        <p><span class="dob_info_"><button type="button" class="edit_icon" onclick="edit_infos(\'\',\'dob\')"><img class="edit_icon" src="../images/edit_icon.png"/></button></span>
                        <span class="hidden dob_edit_"><input class="admin" type="submit" name="new_dob" value="Valider" onclick="waiting_time(event,\'form_profil\')"/><input class="edit_icon" type="button" value="X" onclick="cancel_edit(\'\',\'dob\')"/></span></p>';
                        

                        echo '<p>Genre :</p>';
                        echo '
                        <p><span class="genre_info_">'.$user['profil']['genre'].' </span>
                        <span class="hidden genre_edit_">';
                        if($user['profil']['genre'] == "mme"){
                                echo '<select class="modif_role" name="new_genre_value">
                                    <option value="mme">Mme</option>
                                    <option value="mr">Mr</option>
                                    <option value="x">X</option>
                                </select>';
                            }
                            else if($user['profil']['genre'] == "mr"){
                                echo '<select class="modif_role" name="new_genre_value">
                                    <option value="mr">Mr</option>
                                    <option value="mme">Mme</option>
                                    <option value="x">X</option>
                                </select>';
                            }
                            else{
                                echo '<select class="modif_role" name="new_genre_value">
                                    <option value="x">X</option>
                                    <option value="mme">Mme</option>
                                    <option value="mr">Mr</option>
                                </select>';
                            }
                        
                        echo '</span></p>

                        <p><span class="genre_info_"><button type="button" class="edit_icon" onclick="edit_infos(\'\',\'genre\')"><img class="edit_icon" src="../images/edit_icon.png"/></button></span>
                        <span class="hidden genre_edit_"><input class="admin" type="submit" name="new_genre" value="Valider" onclick="waiting_time(event,\'form_profil\')"/><input class="edit_icon" type="button" value="X" onclick="cancel_edit(\'\',\'genre\')"/></span></p>';
                        

                        echo '<p>Adresse :</p>';
                        echo '
                        <p><span class="adresse_info_">'.$user['profil']['adresse'].' </span>
                        <span class="hidden adresse_edit_"><input class="modifier" type="text" name="new_adresse_value" placeholder="'.$user['profil']['adresse'].'"/></span></p>

                        <p><span class="adresse_info_"><button type="button" class="edit_icon" onclick="edit_infos(\'\',\'adresse\')"><img class="edit_icon" src="../images/edit_icon.png"/></button></span>
                        <span class="hidden adresse_edit_"><input class="admin" type="submit" name="new_adresse" value="Valider" onclick="waiting_time(event,\'form_profil\')"/><input class="edit_icon" type="button" value="X" onclick="cancel_edit(\'\',\'adresse\')"/></span></p>';
                    ?>

                    <p class="empty"> .</p>
                    <p></p>
                    <p></p>

                    <p>Photo de profil</p>
                    <p>
                    <label for="profil_picture_value" id="pp_button">Choisir un fichier</label>
                    <input type="file" class="button_file" accept="image/*" id="profil_picture_value"/><span id="file_name"></span></p>
                    <td><input class="admin" type="submit" name="profil_picture" value="Valider"/></td>

                    <script>
                        const fileInput = document.getElementById("profil_picture_value");
                        const fileNameDisplay = document.getElementById("file_name");

                        fileInput.addEventListener("change", function () {
                            if (this.files.length > 0) {
                                fileNameDisplay.textContent = this.files[0].name;
                                fileNameDisplay.style.display = "block";
                            }
                            else {
                                fileNameDisplay.textContent = "";
                                fileNameDisplay.style.display = "none";
                            }
                        });

                    </script>
                    
                    <p>Date d'inscription :</p>
                    <p><?php echo date("d/m/Y", strtotime($user['date d\'inscription']));?></p>
                    <p></p>
                    
                    <?php file_put_contents('../json/utilisateurs.json', json_encode($users, JSON_PRETTY_PRINT));?>
                        
                    
                    <p class="empty"> .</p>
                    <p></p>
                    <p></p>
                    <p><input type="submit" name="supp" value="Supprimer le compte"></p>
                        
                    <input type="submit" name="deco" value="Déconnexion">
                </fieldset>
            </form>

        <br><br>
        <div class="afterimage">
            <span class="first-afterimage">Nous contacter :</span>
            <p>Email : contact@campingextreme.com<br/>Téléphone : 01 23 45 67 89</p>
            <br/>
        </div>
        <script src="../javascript/chg_theme.js"></script>
    </body>
</php>