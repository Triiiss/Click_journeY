<?php
    session_start();

    if(empty($_SESSION["connexion"]) || $_SESSION["connexion"]!="connected"){
        header("Location :accueil.php");
    }
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

        <ul class="bandeau">
            <nav class="bandeau">
                <li class="bandeau"><a class="bandeau" href="presentation.php">PRESENTATION</a></li>
                <li class="bandeau"><a class="bandeau" href="recherche.php">ITINERAIRES</a></li>
                <?php
                if(isset($_SESSION["role"]) && $_SESSION["role"] == "admin"){
                    echo '<li class="bandeau"><a class="bandeau" href="admin.php">ADMIN</a></li>';
                }
                ?>
                <li class="profil" id="current"><a class="profil" id="current" href="profil.php"> 
                <img src="../images/profil_picture.webp" class="profil_picture" alt="Profil"/></a>
                </li>
            </nav>
        </ul>

        <form action="profil.php" method="POST">
            <fieldset class="formulaire profil">
                <legend>Profil <img src="../images/profil_picture.webp" class="profil_picture"/></legend>
                    <?php
                        if(empty($_SESSION["user_index"])){
                            session_destroy();
                            header("Location :accueil.php");
                        }
                        else{
                            $json_users=file_get_contents("../json/utilisateurs.json");
                            $users=json_decode($json_users, true);
                            $user=$users[$_SESSION["user_index"]-1];

                            /*Changer les informations */
                            if(isset($_POST["new_login"])){
                                $newlogin=1;
                                foreach($users as $login){
                                    if(isset($login["login"]) && $login["login"] === $_POST["new_login_value"]){
                                        $newlogin=0;
                                        break;
                                    }
                                }
                                if(strlen($_POST["new_login_value"]) < 2){
                                    $newlogin=0;
                                }

                                if(isset($newlogin) && $newlogin == 1){
                                    $users[$_SESSION["user_index"]-1]['login'] = $_POST["new_login_value"];
                                    $user['login'] = $_POST["new_login_value"];
                                }

                            }
                            if(isset($_POST["new_mdp"]) && !empty($_POST["new_mdp_value"])){
                                $maj=0;
                                $min=0;
                                $num=0;
                                $spe=0;
                                $safemdp=0;
                                foreach(str_split($_POST["new_mdp_value"]) as $letter){
                                    if($maj==0 && ctype_upper($letter)){
                                        $maj=1;
                                    }
                                    if($min==0 && ctype_lower($letter)){
                                        $min=1;
                                    }
                                    if($num==0 && is_numeric($letter)){
                                        $num=1;
                                    }
                                    if($spe==0 && ($letter == '!' || $letter == '*' || $letter == '#' || $letter == '%' || $letter == '_')){
                                        $spe=1;
                                    }
                                }
                                if (strlen($mdp)>=8 && $maj == 1 && $min == 1 && $num == 1 && $spe == 1){
                                    $safemdp = 1;
                                }
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
                                $users[$_SESSION["user_index"]-1]['profil']['date de naissance'] = $_POST["new_dob_value"];
                                $user['profil']['date de naissance'] = $_POST["new_dob_value"];
                            }
                            if(isset($_POST["new_genre"]) && !empty($_POST["new_genre_value"])){
                                $users[$_SESSION["user_index"]-1]['profil']['genre'] = $_POST["new_genre_value"];
                                $user['profil']['genre'] = $_POST["new_genre_value"];
                            }


                            /*Afficher les informations */
                            echo '<p>Identifiant :</p>';
                            if(isset($_POST["modif_login"])){
                                echo '<td><input type="text" name="new_login_value" placeholder="'.$user["login"].'"/></td>';
                                echo '<td><input class="admin" type="submit" name="new_login" value="Valider"/></td>';
                            }
                            else{
                                echo '<p>'.$user["login"].'</p>
                                <p><button type="submit" class="edit_icon" name="modif_login"><img class="edit_icon" src="../images/edit_icon.png"/></button></p>';
                            }


                            echo '<p>Mot de passe :</p>';
                            if(isset($_POST["modif_mdp"])){
                                echo '<td><input type="text" name="new_mdp_value" placeholder="'.$user["mdp"].'"/></td>';
                                echo '<td><input class="admin" type="submit" name="new_mdp" value="Valider"/></td>';
                            }
                            else{
                                echo '<p>'.$user["mdp"].'</p>
                                <p><button type="submit" class="edit_icon" name="modif_mdp"><img class="edit_icon" src="../images/edit_icon.png"/></button></p>';
                            }


                            echo '<p>E-mail : </p>';
                            if(isset($_POST["modif_email"])){
                                echo '<td><input type="text" name="new_email_value" placeholder="'.$user["email"].'"/></td>';
                                echo '<td><input class="admin" type="submit" name="new_email" value="Valider"/></td>';
                            }
                            else{
                                echo '<p>'.$user["email"].'</p>
                                <p><button type="submit" class="edit_icon" name="modif_email"><img class="edit_icon" src="../images/edit_icon.png"/></button></p>';
                            }

                            echo '<p>Prénom :</p>';
                            if(isset($_POST["modif_prenom"])){
                                echo '<td><input type="text" name="new_prenom_value" placeholder="'.$user["profil"]["prenom"].'"/></td>';
                                echo '<td><input class="admin" type="submit" name="new_prenom" value="Valider"/></td>';
                            }
                            else{
                                echo '<p>'.$user["profil"]["prenom"].'</p>
                                <p><button type="submit" class="edit_icon" name="modif_prenom"><img class="edit_icon" src="../images/edit_icon.png"/></button></p>';
                            }

                            echo '<p>Nom :</p>';
                            if(isset($_POST["modif_nom"])){
                                echo '<td><input type="text" name="new_nom_value" placeholder="'.$user["profil"]["nom"].'"/></td>';
                                echo '<td><input class="admin" type="submit" name="new_nom" value="Valider"/></td>';
                            }
                            else{
                                echo '<p>'.$user["profil"]["nom"].'</p>
                                <p><button type="submit" class="edit_icon" name="modif_nom"><img class="edit_icon" src="../images/edit_icon.png"/></button></p>';
                            }

                            echo '<p>Numéro de téléphone :</p>';
                            if(isset($_POST["modif_tel"])){
                                echo '<td><input type="tel" pattern="[0-9]*" name="new_tel_value" placeholder="'.$user["profil"]["tel"].'"/></td>';
                                echo '<td><input class="admin" type="submit" name="new_tel" value="Valider"/></td>';
                            }
                            else{
                                echo '<p>'.$user["profil"]["tel"].'</p>
                                <p><button type="submit" class="edit_icon" name="modif_tel"><img class="edit_icon" src="../images/edit_icon.png"/></button></p>';
                            }

                            echo '<p>Date de naissance :</p>';
                            if(isset($_POST["modif_dob"])){
                                echo '<td><input type="text" name="new_dob_value" placeholder="'.$user["profil"]["date de naissance"].'"/></td>';
                                echo '<td><input class="admin" type="submit" name="new_dob" value="Valider"/></td>';
                            }
                            else{
                                echo '<p>'.$user["profil"]["date de naissance"].'</p>
                                <p><button type="submit" class="edit_icon" name="modif_dob"><img class="edit_icon" src="../images/edit_icon.png"/></button></p>';
                            }

                            echo '<p>Genre :</p>';
                            if(isset($_POST["modif_genre"])){
                                if($user['profil']['genre'] == "mme"){
                                    echo '<td><select class="modif_role" name="new_genre_value">
                                        <option value="mme">Mme</option>
                                        <option value="mr">Mr</option>
                                        <option value="x">X</option>
                                    </select></td>';
                                }
                                else if($user['profil']['genre'] == "mr"){
                                    echo '<td><select class="modif_role" name="new_genre_value">
                                        <option value="mr">Mr</option>
                                        <option value="mme">Mme</option>
                                        <option value="x">X</option>
                                    </select></td>';
                                }
                                else{
                                    echo '<td><select class="modif_role" name="new_genre_value">
                                        <option value="x">X</option>
                                        <option value="mme">Mme</option>
                                        <option value="mr">Mr</option>
                                    </select></td>';
                                }
                                echo '<td><input class="admin" type="submit" name="new_genre" value="Valider"/></td>';
                            }
                            else{
                                echo '<p>'.$user["profil"]["genre"].'</p>
                                <p><button type="submit" class="edit_icon" name="modif_genre"><img class="edit_icon" src="../images/edit_icon.png"/></button></p>';
                            }

                            echo '<p>Adresse :</p>';
                            if(isset($_POST["modif_adresse"])){
                                echo '<td><input type="text" name="new_adresse_value" placeholder="'.$user["profil"]["adresse"].'"/></td>';
                                echo '<td><input class="admin" type="submit" name="new_adresse" value="Valider"/></td>';
                            }
                            else{
                                echo '<p>'.$user["profil"]["adresse"].'</p>
                                <p><button type="submit" class="edit_icon" name="modif_adresse"><img class="edit_icon" src="../images/edit_icon.png"/></button></p>';
                            }


                            echo '<p>Voyages :</p>
                            <p>...</p>
                            <p>...</p>
                            
                            <p>Date d\'inscription :</p>
                            <p>'.$user['date d\'inscription'].'</p>
                            <p></p>';
                            file_put_contents('../json/utilisateurs.json', json_encode($users, JSON_PRETTY_PRINT));
                        }
                    ?>
                    <p class="empty"> .</p>
                    <p></p>
                    <p></p>
                    <p></p>
                <input type="submit" name="deco" value="Déconnexion">
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
<?php
    if(isset($_POST["deco"])){
        session_destroy();
        header("Location: accueil.php");
    }
?>