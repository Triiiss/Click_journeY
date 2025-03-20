<?php
    session_start();
    if(empty($_SESSION["connexion"]) || $_SESSION["connexion"]!="connected"){
        header("Location :accueil.php");
    }
    if(empty($_SESSION["role"]) || $_SESSION["role"]!="admin"){
        header("Location :accueil.php");
    }

    if(!isset($_SESSION["display"])){
        $_SESSION["display"] = array();
    }
?>

<!DOCTYPE php>
<php>
    <head>
        <meta charset="utf-8"/>
        <title>camping de l'extreme - Admin</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    </head>
    <body>
        <h1 class="titre">Camping de l'Extreme <img src="../images/logo.png" class="logo" alt="logo de l'image"/></h1>
        <a class="accueil" href="accueil.php">Accueil</a><br/>

        <ul class="bandeau">
            <nav class="bandeau">
                <li class="bandeau"><a class="bandeau" href="presentation.php">PRESENTATION</a></li>
                <li class="bandeau"><a class="bandeau" href="recherche.php">ITINERAIRES</a></li>
                <li class="bandeau" id="current"><a class="bandeau" href="admin.php">ADMIN</a></li>
                <li class="profil"><a class="profil" href="profil.php"> 
                <img src="../images/profil_picture.webp" class="profil_picture" alt="Profil"/></a>
                </li>
            </nav>
        </ul>

        <table class="admin">
            <caption class="admin">Liste des utilisateurs</caption>
        <thead>
            <tr>
                <th class"admin" colspan="2">Login</th>
                <th class"admin" colspan="2">Password</th>
                <th class"admin" colspan="2">Email</th>
                <th class"admin" colspan="2">Nom</th>
                <th class"admin" colspan="2">Prénom</th>
                <th class"admin" colspan="2">Date d'inscription</th>
                <th class"admin" colspan="2">Statut</th>
                <th class"admin" colspan="2">Actions</th>
                
            </tr>
        </thead>
        <tbody>
            <form action="admin.php" method="post">
                <?php
                        /*Récupérer le fichier sous forme d'array */
                        $json_users=file_get_contents("../json/utilisateurs.json");
                        $users=json_decode($json_users, true);

                        foreach($users as $k=> $user){
                            /* Changer les informations*/
                            if(isset($_POST["new".$user['login']."_login"])){
                                $newlogin=1;
                                $json_users=file_get_contents("../json/utilisateurs.json");
                                $json_users=json_decode($json_users, true);
                                foreach($json_users as $login){
                                    if(isset($login["login"]) && $login["login"] === $_POST["new".$user['login']."_login_value"]){
                                        $newlogin=0;
                                        break;
                                    }
                                }
                                if(strlen($_POST["new".$user['login']."_login_value"]) < 2){
                                    $newlogin=0;
                                }

                                if(isset($newlogin) && $newlogin == 1){
                                    $users[$k]['login'] = $_POST["new".$user['login']."_login_value"];
                                    $user['login'] = $_POST["new".$user['login']."_login_value"];
                                }

                            }
                            if(isset($_POST["new".$user['login']."_mdp"]) && !empty($_POST["new".$user['login']."_mdp_value"])){
                                $users[$k]['mdp'] = $_POST["new".$user['login']."_mdp_value"];
                                $user['mdp'] = $_POST["new".$user['login']."_mdp_value"];
                            }
                            if(isset($_POST["new".$user['login']."_email"]) && !empty($_POST["new".$user['login']."_email_value"])){
                                $users[$k]['email'] = $_POST["new".$user['login']."_email_value"];
                                $user['email'] = $_POST["new".$user['login']."_email_value"];
                            }
                            if(isset($_POST["new".$user['login']."_nom"]) && !empty($_POST["new".$user['login']."_nom_value"])){
                                $users[$k]['profil']['nom'] = $_POST["new".$user['login']."_nom_value"];
                                $user['profil']['nom'] = $_POST["new".$user['login']."_nom_value"];
                            }
                            if(isset($_POST["new".$user['login']."_prenom"]) && !empty($_POST["new".$user['login']."_prenom_value"])){
                                $users[$k]['profil']['prenom'] = $_POST["new".$user['login']."_prenom_value"];
                                $user['profil']['prenom'] = $_POST["new".$user['login']."_prenom_value"];
                            }
                            if(isset($_POST["new".$user['login']."_role"]) && !empty($_POST["new".$user['login']."_role_value"])){
                                $users[$k]['role'] = $_POST["new".$user['login']."_role_value"];
                                $user['role'] = $_POST["new".$user['login']."_role_value"];
                            }
                            if(isset($_POST["new".$user['login']."_adresse"]) && !empty($_POST["new".$user['login']."_adresse_value"])){
                                $users[$k]['profil']['adresse'] = $_POST["new".$user['login']."_adresse_value"];
                                $user['profil']['adresse'] = $_POST["new".$user['login']."_adresse_value"];
                            }
                            if(isset($_POST["new".$user['login']."_tel"]) && !empty($_POST["new".$user['login']."_tel_value"])){
                                $users[$k]['profil']['tel'] = $_POST["new".$user['login']."_tel_value"];
                                $user['profil']['tel'] = $_POST["new".$user['login']."_tel_value"];
                            }
                            if(isset($_POST["new".$user['login']."_dob"]) && !empty($_POST["new".$user['login']."_dob_value"])){
                                $users[$k]['profil']['date de naissance'] = $_POST["new".$user['login']."_dob_value"];
                                $user['profil']['date de naissance'] = $_POST["new".$user['login']."_dob_value"];
                            }
                            if(isset($_POST["new".$user['login']."_genre"]) && !empty($_POST["new".$user['login']."_genre_value"])){
                                $users[$k]['profil']['genre'] = $_POST["new".$user['login']."_genre_value"];
                                $user['profil']['genre'] = $_POST["new".$user['login']."_genre_value"];
                            }

                            /*Delete a user */
                            if(isset($_POST["supprimer_".$user['login']])){
                                unset($users[$k]);
                            }
                            else{/*Afficher les informations*/
                                echo '<tr>';
                                /*Login */
                                if(isset($_POST["modif_".$user['login']."_login"])){
                                    /* Met un input text pour modifier */
                                    echo '<td><input class="modifier" type="text" name="new'.$user['login'].'_login_value" placeholder="'.$user['login'].'"/></td>';
                                    echo '<td><input class="admin" type="submit" name="new'.$user['login'].'_login" value="Valider"/></td>';
                                }
                                else{
                                    echo '<td>'.$user['login'].' </td>
                                    <td><button type="submit" class="edit_icon" name="modif_'.$user['login'].'_login"><img class="edit_icon" src="../images/edit_icon.png"/></button></td>';
                                }
    
                                /*Mot de passe */
                                if(isset($_POST["modif_".$user['login']."_mdp"])){
                                    echo '<td><input class="modifier" type="text" name="new'.$user['login'].'_mdp_value" placeholder="'.$user['mdp'].'"/></td>';
                                    echo '<td><input class="admin" type="submit" name="new'.$user['login'].'_mdp" value="Valider"/></td>';
                                }
                                else{
                                    echo '<td>'.$user['mdp'].' </td>
                                    <td><button type="submit" class="edit_icon" name="modif_'.$user['login'].'_mdp"><img class="edit_icon" src="../images/edit_icon.png"/></button></td>';
                                }
    
                                /*Email */
                                if(isset($_POST["modif_".$user['login']."_email"])){
                                    echo '<td><input class="modifier" type="text" name="new'.$user['login'].'_email_value" placeholder="'.$user['email'].'"/></td>';
                                    echo '<td><input class="admin" type="submit" name="new'.$user['login'].'_email" value="Valider"/></td>';
                                }
                                else{
                                    echo '<td>'.$user['email'].' </td>
                                    <td><button type="submit" class="edit_icon" name="modif_'.$user['login'].'_email"><img class="edit_icon" src="../images/edit_icon.png"/></button></td>';
                                }

                                /*Nom */
                                if(isset($_POST["modif_".$user['login']."_nom"])){
                                    echo '<td><input class="modifier" type="text" name="new'.$user['login'].'_nom_value" placeholder="'.$user['profil']['nom'].'"/></td>';
                                    echo '<td><input class="admin" type="submit" name="new'.$user['login'].'_nom" value="Valider"/></td>';
                                }
                                else{
                                    echo '<td>'.$user['profil']['nom'].' </td>
                                    <td><button type="submit" class="edit_icon" name="modif_'.$user['login'].'_nom"><img class="edit_icon" src="../images/edit_icon.png"/></button></td>';
                                }
    
                                /*Prenom */
                                if(isset($_POST["modif_".$user['login']."_prenom"])){
                                    echo '<td><input class="modifier" type="text" name="new'.$user['login'].'_prenom_value" placeholder="'.$user['profil']['prenom'].'"/></td>';
                                    echo '<td><input class="admin" type="submit" name="new'.$user['login'].'_prenom" value="Valider"/></td>';
                                }
                                else{
                                    echo '<td>'.$user['profil']['prenom'].' </td>
                                    <td><button type="submit" class="edit_icon" name="modif_'.$user['login'].'_prenom"><img class="edit_icon" src="../images/edit_icon.png"/></button></td>';
                                }
    
                                echo '<td colspan="2">'.$user['date d\'inscription'].'</td>';
    
                                /*Role */
                                if(isset($_POST["modif_".$user['login']."_role"])){
                                    /*echo '<td><input class="modifier" type="text" name="new'.$user['login'].'_role_value" placeholder="'.$user['role'].'"/></td>';*/
                                    if($user['role'] == "admin"){
                                        echo '<td><select class="modif_role" name="new'.$user['login'].'_role_value">
                                            <option value="admin">Admin</option>
                                            <option value="client">Client</option>
                                            <option value="vip">VIP</option>
                                        </select></td>';
                                    }
                                    else{
                                        echo '<td><select class="modif_role" name="new'.$user['login'].'_role_value">
                                            <option value="client">Client</option>
                                            <option value="admin">Admin</option>
                                            <option value="vip">VIP</option>
                                        </select></td>';
                                    }
                                    echo '<td><input class="admin" type="submit" name="new'.$user['login'].'_role" value="Valider"/></td>';
                                }
                                else{
                                    echo '<td>'.$user['role'].' </td>
                                    <td><button type="submit" class="edit_icon" name="modif_'.$user['login'].'_role"><img class="edit_icon" src="../images/edit_icon.png"/></button></td>';
                                }
    
                                /*Change la valeur de displaye[indice du user] pour savoir si on affiche ou non le "plus" */
                                if(isset($_POST["plus_".$user['login']])){
                                    $_SESSION["display"][$k]=1;
                                }
                                if(isset($_POST["moins_".$user['login']])){
                                    $_SESSION["display"][$k]=0;
                                }
    
                                /*Affiche le "voir plus" */
                                if(isset($_SESSION["display"][$k]) && $_SESSION["display"][$k] == 1){
                                    echo '<td><input type="submit" class="admin" name="moins_'.$user['login'].'" value="Réduire"><input type="submit" class="admin" name="supprimer_'.$user['login'].'" value="Supprimer"></td></tr>
                                    
                                    <tr>
                                        <td class="empty" colspan="2"></td>
                                        <td colspan="2"><b>Voyages:</b><input type="submit" class="admin" name="plus_'.$user['login'].'" value="Voir plus"></td>';
                                        
                                        /*Adresse */
                                        if(isset($_POST["modif_".$user['login']."_adresse"])){
                                            echo '<td><input class="modifier" type="text" name="new'.$user['login'].'_adresse_value" placeholder="'.$user['profil']['adresse'].'"/></td>';
                                            echo '<td><input class="admin" type="submit" name="new'.$user['login'].'_adresse" value="Valider"/></td>';
                                        }
                                        else{
                                            echo '<td><b>Adresse: </b>'.$user['profil']['adresse'].' </td>
                                            <td><button type="submit" class="edit_icon" name="modif_'.$user['login'].'_adresse"><img class="edit_icon" src="../images/edit_icon.png"/></button></td>';
                                        }
    
                                        /*Numéro de téléphone */
                                        if(isset($_POST["modif_".$user['login']."_tel"])){
                                            echo '<td><input class="modifier" type="text" name="new'.$user['login'].'_tel_value" placeholder="'.$user['profil']['telephone'].'"/></td>';
                                            echo '<td><input class="admin" type="submit" name="new'.$user['login'].'_tel" value="Valider"/></td>';
                                        }
                                        else{
                                            echo '<td><b>Tel: </b>'.$user['profil']['telephone'].' </td>
                                            <td><button type="submit" class="edit_icon" name="modif_'.$user['login'].'_tel"><img class="edit_icon" src="../images/edit_icon.png"/></button></td>';
                                        }
                                        
                                        /*Date de naissance (dob = Date of birth) */
                                        if(isset($_POST["modif_".$user['login']."_dob"])){
                                            echo '<td><input class="modifier" type="text" name="new'.$user['login'].'_dob_value" placeholder="'.$user['profil']['date de naissance'].'"/></td>';
                                            echo '<td><input class="admin" type="submit" name="new'.$user['login'].'_dob" value="Valider"/></td>';
                                        }
                                        else{
                                            echo '<td><b>Annif: </b>'.$user['profil']['date de naissance'].' </td>
                                            <td><button type="submit" class="edit_icon" name="modif_'.$user['login'].'_dob"><img class="edit_icon" src="../images/edit_icon.png"/></button></td>';
                                        }
                                        
                                        /*Genre */
                                        if(isset($_POST["modif_".$user['login']."_genre"])){
                                            echo '<td><input class="modifier" type="text" name="new'.$user['login'].'_genre_value" placeholder="'.$user['profil']['genre'].'"/></td>';
                                            echo '<td><input class="admin" type="submit" name="new'.$user['login'].'_genre" value="Valider"/></td>';
                                        }
                                        else{
                                            echo '<td><b>Genre: </b>'.$user['profil']['genre'].' </td>
                                            <td><button type="submit" class="edit_icon" name="modif_'.$user['login'].'_genre"><img class="edit_icon" src="../images/edit_icon.png"/></button></td>';
                                        }
    
                                        echo '</tr>';
                                }
                                else{
                                    echo '<td><input type="submit" class="admin" name="plus_'.$user['login'].'" value="Voir plus"><input type="submit" class="admin" name="supprimer_'.$user['login'].'" value="Supprimer"></td></tr>';
                                }
                            }
                        }
                        file_put_contents('../json/utilisateurs.json', json_encode($users, JSON_PRETTY_PRINT));
                ?>
            </form>
        </tbody>
    </table>

    <br><br>
    <div class="afterimage">
        <span class="first-afterimage">Nous contacter :</span>
        <p>Email : contact@campingextreme.com<br/>Téléphone : 01 23 45 67 89</p>
        <br/>
    </div>
    </body>
</php>
