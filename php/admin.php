<?php
    include 'fonctions.php';
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

    if (!isset($_SESSION["npage"])){
        $_SESSION["npage"]=1;
    }
    $maxusers=5;
    $infos = array("login","mdp","email","nom","prenom","role","adresse","tel","dob","genre");
?>

<!DOCTYPE php>
<php>
    <head>
        <meta charset="utf-8"/>
        <title>camping de l'extreme - Admin</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    </head>
    <body>
        <script src="../javascript/informations.js"></script>
        <script src="../javascript/chg_theme.js"></script>
        <h1 class="titre">Camping de l'Extreme <img src="../images/logo.png" class="logo" alt="logo de l'image"/></h1>
        <a class="accueil" href="accueil.php">Accueil</a><br/>

        <?php bandeau("admin");?>

        <form action="admin.php" method="post" id="form_admin">
            <table class="admin">
                <caption class="admin">Liste des utilisateurs</caption>
            <thead>
                <tr>
                    <th class="admin" colspan="2">Login</th>
                    <th class="admin" colspan="2">Password</th>
                    <th class="admin" colspan="2">Email</th>
                    <th class="admin" colspan="2">Nom</th>
                    <th class="admin" colspan="2">Prénom</th>
                    <th class="admin" colspan="2">Date d'inscription</th>
                    <th class="admin" colspan="2">Statut</th>
                    <th class="admin" colspan="2">Actions</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                        /*Récupérer le fichier sous forme d'array */
                        $users=get_data("../json/utilisateurs.json");
                        $voyages=get_data("../json/voyages.json");
                        if($voyages===null){
                            echo "<p>Problème de récupération des données côté serveur</p>";
                        }
                        if($users === null){
                            echo "<p>Problème de récupération des données côté serveur</p>";
                        }

                        else{
                            $maxpage=(array_key_last($users)+1)/$maxusers;
                            /*Pour défiler les pages */
                            if (isset($_POST["plus_defil"]) && $_SESSION["npage"] < $maxpage){
                                $_SESSION["npage"]++;
                            }
                            else if(isset($_POST["moins_defil"]) && $_SESSION["npage"] > 1){
                                $_SESSION["npage"]--;
                            }
                            for($i=1;$i<=$maxpage+1;$i++){
                                if(isset($_POST["goto_".$i])){
                                    $_SESSION["npage"]=$i;
                                }                                
                            }

                            $users_shown = array_slice($users,$maxusers*($_SESSION["npage"]-1),$maxusers);

                            foreach($users_shown as $k=> $user){
                                /*Delete a user */
                                if(isset($_POST["supprimer_".$user['login']])){
                                    unset($users[$k+($_SESSION["npage"]-1)*$maxusers]);
                                    $users = array_values($users);
                                }
                                else{
                                    /*Change la valeur de display[indice du user] pour savoir si on affiche ou non le "plus" */
                                    if(isset($_POST["plus_".$user['login']])){
                                        $_SESSION["display"][$k]=1;
                                    }
                                    if(isset($_POST["moins_".$user['login']])){
                                        $_SESSION["display"][$k]=0;
                                    }
                                    if(isset($_POST["plus_".$user['login']."_voyages"])){
                                        $_SESSION["voyage"][$k]=1;
                                    }
                                    if(isset($_POST["moins_".$user['login']."_voyages"])){
                                        $_SESSION["voyage"][$k]=0;
                                    }
                                    

                                    /* Changer les informations*/
                                    if(isset($_POST["new".$user['login']."_login"])){
                                        $newlogin=new_login($_POST["new".$user['login']."_login_value"],"../json/utilisateurs.json");
                                        
                                        if($newlogin == 1){
                                            $users[$k+($_SESSION["npage"]-1)*$maxusers]['login'] = $_POST["new".$user['login']."_login_value"];
                                            $user['login'] = $_POST["new".$user['login']."_login_value"];
                                        }
    
                                    }
                                    if(isset($_POST["new".$user['login']."_mdp"]) && !empty($_POST["new".$user['login']."_mdp_value"])){
                                        $users[$k+($_SESSION["npage"]-1)*$maxusers]['mdp'] = $_POST["new".$user['login']."_mdp_value"];
                                        $user['mdp'] = $_POST["new".$user['login']."_mdp_value"];
                                    }
                                    if(isset($_POST["new".$user['login']."_email"]) && !empty($_POST["new".$user['login']."_email_value"])){
                                        $users[$k+($_SESSION["npage"]-1)*$maxusers]['email'] = $_POST["new".$user['login']."_email_value"];
                                        $user['email'] = $_POST["new".$user['login']."_email_value"];
                                    }
                                    if(isset($_POST["new".$user['login']."_nom"]) && !empty($_POST["new".$user['login']."_nom_value"])){
                                        $users[$k+($_SESSION["npage"]-1)*$maxusers]['profil']['nom'] = $_POST["new".$user['login']."_nom_value"];
                                        $user['profil']['nom'] = $_POST["new".$user['login']."_nom_value"];
                                    }
                                    if(isset($_POST["new".$user['login']."_prenom"]) && !empty($_POST["new".$user['login']."_prenom_value"])){
                                        $users[$k+($_SESSION["npage"]-1)*$maxusers]['profil']['prenom'] = $_POST["new".$user['login']."_prenom_value"];
                                        $user['profil']['prenom'] = $_POST["new".$user['login']."_prenom_value"];
                                    }
                                    if(isset($_POST["new".$user['login']."_role"]) && !empty($_POST["new".$user['login']."_role_value"])){
                                        $users[$k+($_SESSION["npage"]-1)*$maxusers]['role'] = $_POST["new".$user['login']."_role_value"];
                                        $user['role'] = $_POST["new".$user['login']."_role_value"];
                                    }
                                    if(isset($_POST["new".$user['login']."_adresse"]) && !empty($_POST["new".$user['login']."_adresse_value"])){
                                        $users[$k+($_SESSION["npage"]-1)*$maxusers]['profil']['adresse'] = $_POST["new".$user['login']."_adresse_value"];
                                        $user['profil']['adresse'] = $_POST["new".$user['login']."_adresse_value"];
                                    }
                                    if(isset($_POST["new".$user['login']."_tel"]) && !empty($_POST["new".$user['login']."_tel_value"])){
                                        $users[$k+($_SESSION["npage"]-1)*$maxusers]['profil']['tel'] = $_POST["new".$user['login']."_tel_value"];
                                        $user['profil']['tel'] = $_POST["new".$user['login']."_tel_value"];
                                    }
                                    if(isset($_POST["new".$user['login']."_dob"]) && !empty($_POST["new".$user['login']."_dob_value"])){
                                        $users[$k+($_SESSION["npage"]-1)*$maxusers]['profil']['dob'] = $_POST["new".$user['login']."_dob_value"];
                                        $user['profil']['dob'] = $_POST["new".$user['login']."_dob_value"];
                                    }
                                    if(isset($_POST["new".$user['login']."_genre"]) && !empty($_POST["new".$user['login']."_genre_value"])){
                                        $users[$k+($_SESSION["npage"]-1)*$maxusers]['profil']['genre'] = $_POST["new".$user['login']."_genre_value"];
                                        $user['profil']['genre'] = $_POST["new".$user['login']."_genre_value"];
                                    }
                                    for($i=max(count($user["voyages_achete"]),count($user["voyages_favoris"]),count($user["voyages_panier"]));$i>=0;$i--){
                                        if(isset($_POST["supp_".$user['login']."_panier_".$i])){
                                            unset($user["voyages_panier"][$i]);
                                            unset($users[$k+($_SESSION["npage"]-1)*$maxusers]["voyages_panier"][$i]);

                                            $user["voyages_panier"] = array_values($user["voyages_panier"]);
                                            $users[$k+($_SESSION["npage"]-1)*$maxusers]["voyages_panier"] = array_values($users[$k+($_SESSION["npage"]-1)*$maxusers]["voyages_panier"]);
                                        }
                                        if(isset($_POST["supp_".$user['login']."_fav_".$i])){
                                            unset($user["voyages_favoris"][$i]);
                                            unset($users[$k+($_SESSION["npage"]-1)*$maxusers]["voyages_favoris"][$i]);

                                            $user["voyages_favoris"] = array_values($user["voyages_favoris"]);
                                            $users[$k+($_SESSION["npage"]-1)*$maxusers]["voyages_favoris"] = array_values($users[$k+($_SESSION["npage"]-1)*$maxusers]["voyages_favoris"]);
                                        }
                                        if(isset($_POST["supp_".$user['login']."_achat_".$i])){
                                            unset($user["voyages_achete"][$i]);
                                            unset($users[$k+($_SESSION["npage"]-1)*$maxusers]["voyages_achete"][$i]);

                                            $user["voyages_achete"] = array_values($user["voyages_achete"]);
                                            $users[$k+($_SESSION["npage"]-1)*$maxusers]["voyages_achete"] = array_values($users[$k+($_SESSION["npage"]-1)*$maxusers]["voyages_achete"]);
                                        }
                                    }

                                    /*Afficher les informations*/
                                    echo '<tr>';
                                    /*Login */
                                    echo '
                                    <td><span class="login_info_'.$k.'">'.$user['login'].' </span>
                                    <span class="hidden login_edit_'.$k.'"><input class="modifier" type="text" name="new'.$user['login'].'_login_value" placeholder="'.$user['login'].'"/></span></td>

                                    <td><span class="login_info_'.$k.'"><button type="button" class="edit_icon" onclick="edit_infos('.$k.',\'login\')"><img class="edit_icon" src="../images/edit_icon.png"/></button></span>
                                    <span class="hidden login_edit_'.$k.'"><input class="admin" type="submit" name="new'.$user['login'].'_login" value="Valider" onclick="waiting_time(event,\'form_admin\')"/><input class="edit_icon" type="button" value="X" onclick="cancel_edit('.$k.',\'login\')"/></span></td>';

                                    /*Mot de passe */
                                    echo '
                                    <td><span class="mdp_info_'.$k.'">'.$user['mdp'].' </span>
                                    <span class="hidden mdp_edit_'.$k.'"><input class="modifier" type="text" name="new'.$user['login'].'_mdp_value" placeholder="'.$user['mdp'].'"/></span></td>

                                    <td><span class="mdp_info_'.$k.'"><button type="button" class="edit_icon" onclick="edit_infos('.$k.',\'mdp\')"><img class="edit_icon" src="../images/edit_icon.png"/></button></span>
                                    <span class="hidden mdp_edit_'.$k.'"><input class="admin" type="submit" name="new'.$user['login'].'_mdp" value="Valider" onclick="waiting_time(event,\'form_admin\')"/><input class="edit_icon" type="button" value="X" onclick="cancel_edit('.$k.',\'mdp\')"/></span></td>';
                                    
        
                                    /*Email */
                                    echo '
                                    <td><span class="email_info_'.$k.'">'.$user['email'].' </span>
                                    <span class="hidden email_edit_'.$k.'"><input class="modifier" type="text" name="new'.$user['login'].'_email_value" placeholder="'.$user['email'].'"/></span></td>

                                    <td><span class="email_info_'.$k.'"><button type="button" class="edit_icon" onclick="edit_infos('.$k.',\'email\')"><img class="edit_icon" src="../images/edit_icon.png"/></button></span>
                                    <span class="hidden email_edit_'.$k.'"><input class="admin" type="submit" name="new'.$user['login'].'_email" value="Valider" onclick="waiting_time(event,\'form_admin\')"/><input class="edit_icon" type="button" value="X" onclick="cancel_edit('.$k.',\'email\')"/></span></td>';


                                    /*Nom */
                                    echo '
                                    <td><span class="nom_info_'.$k.'">'.$user['profil']['nom'].' </span>
                                    <span class="hidden nom_edit_'.$k.'"><input class="modifier" type="text" name="new'.$user['login'].'_nom_value" placeholder="'.$user['profil']['nom'].'"/></span></td>

                                    <td><span class="nom_info_'.$k.'"><button type="button" class="edit_icon" onclick="edit_infos('.$k.',\'nom\')"><img class="edit_icon" src="../images/edit_icon.png"/></button></span>
                                    <span class="hidden nom_edit_'.$k.'"><input class="admin" type="submit" name="new'.$user['login'].'_nom" value="Valider" onclick="waiting_time(event,\'form_admin\')"/><input class="edit_icon" type="button" value="X" onclick="cancel_edit('.$k.',\'nom\')"/></span></td>';

        
                                    /*Prenom */
                                    echo '
                                    <td><span class="prenom_info_'.$k.'">'.$user['profil']['prenom'].' </span>
                                    <span class="hidden prenom_edit_'.$k.'"><input class="modifier" type="text" name="new'.$user['login'].'_prenom_value" placeholder="'.$user['profil']['prenom'].'"/></span></td>

                                    <td><span class="prenom_info_'.$k.'"><button type="button" class="edit_icon" onclick="edit_infos('.$k.',\'prenom\')"><img class="edit_icon" src="../images/edit_icon.png"/></button></span>
                                    <span class="hidden prenom_edit_'.$k.'"><input class="admin" type="submit" name="new'.$user['login'].'_prenom" value="Valider" onclick="waiting_time(event,\'form_admin\')"/><input class="edit_icon" type="button" value="X" onclick="cancel_edit('.$k.',\'prenom\')"/></span></td>';

        
                                    echo '<td colspan="2">'.$user['date d\'inscription'].'</td>';
        
                                    /*Role */
                                    echo '
                                    <td><span class="role_info_'.$k.'">'.$user['role'].' </span>
                                    <span class="hidden role_edit_'.$k.'">';
                                    
                                        if($user['role'] == "admin"){
                                            echo '<select class="modif_role" name="new'.$user['login'].'_role_value">
                                                <option value="admin">Admin</option>
                                                <option value="client">Client</option>
                                                <option value="vip">VIP</option>
                                            </select>';
                                        }
                                        else{
                                            echo '<select class="modif_role" name="new'.$user['login'].'_role_value">
                                                <option value="client">Client</option>
                                                <option value="admin">Admin</option>
                                                <option value="vip">VIP</option>
                                            </select>';
                                        }
                                    echo '</span></td>

                                    <td><span class="role_info_'.$k.'"><button type="button" class="edit_icon" onclick="edit_infos('.$k.',\'role\')"><img class="edit_icon" src="../images/edit_icon.png"/></button></span>
                                    <span class="hidden role_edit_'.$k.'"><input class="admin" type="submit" name="new'.$user['login'].'_role" value="Valider" onclick="waiting_time(event,\'form_admin\')"/><input class="edit_icon" type="button" value="X" onclick="cancel_edit('.$k.',\'role\')"/></span></td>';

        
                                    /*Affiche le "voir plus" */
                                    if(isset($_SESSION["display"][$k]) && $_SESSION["display"][$k] == 1){
                                        echo '<td><input type="submit" class="admin" name="moins_'.$user['login'].'" value="Réduire"><input type="submit" class="admin" name="supprimer_'.$user['login'].'" value="Supprimer" onclick="waiting_time(event,\'form_admin\')"></td></tr>
                                        
                                        <tr>
                                            <td class="empty" colspan="2"></td>';

                                            if(isset($_SESSION["voyage"][$k]) && $_SESSION["voyage"][$k] == 1){
                                                echo '<td colspan="2"><b>Voyages:</b><input type="submit" class="admin" name="moins_'.$user['login'].'_voyages" value="Réduire"></td>';
                                            }
                                            else{
                                                echo '<td colspan="2"><b>Voyages:</b><input type="submit" class="admin" name="plus_'.$user['login'].'_voyages" value="Voir +"></td>';
                                            }
                                            
                                            
                                            /*Adresse */
                                            echo '
                                            <td><span class="adresse_info_'.$k.'"><b>Adresse: </b>'.$user['profil']['adresse'].' </span>
                                            <span class="hidden adresse_edit_'.$k.'"><input class="modifier" type="text" name="new'.$user['login'].'_adresse_value" placeholder="'.$user['profil']['adresse'].'"/></span></td>
        
                                            <td><span class="adresse_info_'.$k.'"><button type="button" class="edit_icon" onclick="edit_infos('.$k.',\'adresse\')"><img class="edit_icon" src="../images/edit_icon.png"/></button></span>
                                            <span class="hidden adresse_edit_'.$k.'"><input class="admin" type="submit" name="new'.$user['login'].'_adresse" value="Valider" onclick="waiting_time(event,\'form_admin\')"/><input class="edit_icon" type="button" value="X" onclick="cancel_edit('.$k.',\'adresse\')"/></span></td>';

                                            /*Numéro de téléphone */
                                            echo '
                                            <td><span class="telephone_info_'.$k.'"><b>Tel: </b>'.$user['profil']['tel'].' </span>
                                            <span class="hidden telephone_edit_'.$k.'"><input class="modifier" type="text" name="new'.$user['login'].'_tel_value" placeholder="'.$user['profil']['tel'].'"/></span></td>
        
                                            <td><span class="telephone_info_'.$k.'"><button type="button" class="edit_icon" onclick="edit_infos('.$k.',\'telephone\')"><img class="edit_icon" src="../images/edit_icon.png"/></button></span>
                                            <span class="hidden telephone_edit_'.$k.'"><input class="admin" type="submit" name="new'.$user['login'].'_tel" value="Valider" onclick="waiting_time(event,\'form_admin\')"/><input class="edit_icon" type="button" value="X" onclick="cancel_edit('.$k.',\'telephone\')"/></span></td>';


                                            /*Date de naissance (dob = Date of birth) */
                                            echo '
                                            <td><span class="dob_info_'.$k.'"><b>Annif: </b>'.$user['profil']['dob'].' </span>
                                            <span class="hidden dob_edit_'.$k.'"><input class="modifier" type="text" name="new'.$user['login'].'_dob_value" placeholder="'.$user['profil']['dob'].'"/></span></td>
        
                                            <td><span class="dob_info_'.$k.'"><button type="button" class="edit_icon" onclick="edit_infos('.$k.',\'dob\')"><img class="edit_icon" src="../images/edit_icon.png"/></button></span>
                                            <span class="hidden dob_edit_'.$k.'"><input class="admin" type="submit" name="new'.$user['login'].'_dob" value="Valider" onclick="waiting_time(event,\'form_admin\')"/><input class="edit_icon" type="button" value="X" onclick="cancel_edit('.$k.',\'dob\')"/></span></td>';

                                            
                                            /*Genre */
                                            echo '
                                            <td><span class="genre_info_'.$k.'"><b>Genre: </b>'.$user['profil']['genre'].' </span>
                                            <span class="hidden genre_edit_'.$k.'">';
                                            if($user['profil']['genre'] == "mme"){
                                                    echo '<select class="modif_role" name="new'.$user['login'].'_genre_value">
                                                        <option value="mme">Mme</option>
                                                        <option value="mr">Mr</option>
                                                        <option value="x">X</option>
                                                    </select>';
                                                }
                                                else if($user['profil']['genre'] == "mr"){
                                                    echo '<select class="modif_role" name="new'.$user['login'].'_genre_value">
                                                        <option value="mr">Mr</option>
                                                        <option value="mme">Mme</option>
                                                        <option value="x">X</option>
                                                    </select>';
                                                }
                                                else{
                                                    echo '<select class="modif_role" name="new'.$user['login'].'_genre_value">
                                                        <option value="x">X</option>
                                                        <option value="mme">Mme</option>
                                                        <option value="mr">Mr</option>
                                                    </select>';
                                                }
                                            echo '</span></td>
        
                                            <td><span class="genre_info_'.$k.'"><button type="button" class="edit_icon" onclick="edit_infos('.$k.',\'genre\')"><img class="edit_icon" src="../images/edit_icon.png"/></button></span>
                                            <span class="hidden genre_edit_'.$k.'"><input class="admin" type="submit" name="new'.$user['login'].'_genre" value="Valider" onclick="waiting_time(event,\'form_admin\')"/><input class="edit_icon" type="button" value="X" onclick="cancel_edit('.$k.',\'genre\')"/></span></td>';

                                            echo '</tr>';

                                            /*Afficher tous les voyages */
                                            if(isset($_SESSION["voyage"][$k]) && $_SESSION["voyage"][$k] == 1){
                                                echo '<tr>
                                                    <td class="empty" colspan="2"></td>
                                                    <td colspan="2"> <b>Panier :</b></td>';
                                                    if (empty($user["voyages_panier"])){
                                                        echo '<td colspan="2">None</td>';
                                                    }
                                                    else{
                                                        echo '<td>'.$voyages[$user["voyages_panier"][0]["id"]]["titre"].'</td>
                                                        <td><button type="submit" class="edit_icon" name="supp_'.$user['login'].'_panier_0">X</button></td>';
                                                    }
                                                    echo '<td colspan="2"><b>Favoris :</b></td>';
                                                    if (empty($user["voyages_favoris"])){
                                                        echo '<td colspan="2">None</td>';
                                                    }
                                                    else{
                                                        echo '<td>'.$voyages[$user["voyages_favoris"][0]]["titre"].'</td>
                                                        <td><button type="submit" class="edit_icon" name="supp_'.$user['login'].'_fav_0">X</button></td>';
                                                    }
                                                    echo '<td colspan="2"><b>Déjà acheté :</b></td>';
                                                    if (empty($user["voyages_achete"])){
                                                        echo '<td colspan="2">None</td>';
                                                    }
                                                    else{
                                                        echo '<td>'.$voyages[$user["voyages_achete"][0]["id"]]["titre"].'</td>
                                                        <td><button type="submit" class="edit_icon" name="supp_'.$user['login'].'_achat_0">X</button></td>';
                                                    }

                                                for ($i=1;$i<max(count($user["voyages_achete"]),count($user["voyages_favoris"]),count($user["voyages_panier"]));$i++){
                                                    echo '</tr>
                                                            <td class="empty" colspan="4"></td>';
                                                    if (isset($user["voyages_panier"][$i])){
                                                        echo '<td>'.$voyages[$user["voyages_panier"][$i]["id"]]["titre"].'</td>
                                                        <td><button type="submit" class="edit_icon" name="supp_'.$user['login'].'_panier_'.$i.'">X</button></td>';
                                                    }
                                                    else{
                                                        echo '<td class="empty" colspan="2"></td>';
                                                    }
                                                    echo '<td class="empty" colspan="2"></td>';
                                                    if (isset($user["voyages_favoris"][$i])){
                                                        echo '<td>'.$voyages[$user["voyages_favoris"][$i]]["titre"].'</td>
                                                        <td><button type="submit" class="edit_icon" name="supp_'.$user['login'].'_fav_'.$i.'">X</button></td>';
                                                    }
                                                    else{
                                                        echo '<td class="empty" colspan="2"></td>';
                                                    }
                                                    echo '<td class="empty" colspan="2"></td>';
                                                    if (isset($user["voyages_achete"][$i])){
                                                        echo '<td>'.$voyages[$user["voyages_achete"][$i]["id"]]["titre"].'</td>
                                                        <td><button type="submit" class="edit_icon" name="supp_'.$user['login'].'_achat_'.$i.'">X</button></td>';
                                                    }
                                                

                                                    echo '<tr>';                                                        
                                                }
                                            }
                                    }
                                    else{
                                        echo '<td><input type="submit" class="admin" name="plus_'.$user['login'].'" value="Voir +"><input type="submit" class="admin" name="supprimer_'.$user['login'].'" value="Supprimer" onclick="waiting_time(event,\'form_admin\')"></td></tr>';
                                    }
                                }
                            }
                        }
                        file_put_contents('../json/utilisateurs.json', json_encode($users, JSON_PRETTY_PRINT));
                ?>
            </tbody>
        </table>
        
        <ul class="admin_defil">
            <nav class="admin_defil">
                <?php
                    if($_SESSION["npage"] <= 1){
                        echo '<li class="admin_stop"><button class="admin_stop" name="moins_defil">_</button></li>';
                    }
                    else{
                        echo '<li class="admin_defil"><button class="admin_defil" name="moins_defil"><<</button></li>';
                    }

                    if($_SESSION["npage"] <= 1){
                        echo '
                        <li class="admin_defil"><button class="admin_stop" name="goto_'.$_SESSION["npage"].'">_'.$_SESSION["npage"].'_</button></li>';

                            if($maxpage > 1){
                                echo '
                            <li class="admin_defil"><button class="admin_defil" name="goto_'.($_SESSION["npage"]+1).'">_'.($_SESSION["npage"]+1).'_</button></li>';
                            }
                            if($maxpage > 2){
                                echo '
                            <li class="admin_defil"><button class="admin_defil" name="goto_'.($_SESSION["npage"]+2).'">_'.($_SESSION["npage"]+2).'_</button></li>';
                            }
                            if($maxpage > 3){
                                echo '
                            <li class="admin_defil"><button class="admin_defil" name="goto_'.($_SESSION["npage"]+3).'">_'.($_SESSION["npage"]+3).'_</button></li>';
                            }
                            if($maxpage > 4){
                                echo '
                            <li class="admin_defil"><button class="admin_defil" name="goto_'.($_SESSION["npage"]+4).'">_'.($_SESSION["npage"]+4).'_</button></li>';
                            }
                    }
                    else if($_SESSION["npage"] >= $maxpage){
                        if ($maxpage > 4){
                            echo '
                            <li class="admin_defil"><button class="admin_defil" name="goto_'.($_SESSION["npage"]-4).'">_'.($_SESSION["npage"]-4).'_</button></li>';
                        }
                        if ($maxpage > 3){
                            echo '
                            <li class="admin_defil"><button class="admin_defil" name="goto_'.($_SESSION["npage"]-3).'">_'.($_SESSION["npage"]-3).'_</button></li>';
                        }
                        if ($maxpage > 2){
                            echo '
                            <li class="admin_defil"><button class="admin_defil" name="goto_'.($_SESSION["npage"]-2).'">_'.($_SESSION["npage"]-2).'_</button></li>';
                        }
                        if ($maxpage > 1){
                            echo '
                            <li class="admin_defil"><button class="admin_defil" name="goto_'.($_SESSION["npage"]-1).'">_'.($_SESSION["npage"]-1).'_</button></li>';
                        }
                        echo '
                            <li class="admin_defil"><button class="admin_stop" name="goto_'.$_SESSION["npage"].'">_'.$_SESSION["npage"].'_</button></li>';
                    }
                    else{
                        if($maxpage > 4 && $_SESSION["npage"] > 2){
                            echo '
                            <li class="admin_defil"><button class="admin_defil" name="goto_'.($_SESSION["npage"]-2).'">_'.($_SESSION["npage"]-2).'_</button></li>';
                        }
                        if($maxpage > 2){
                            echo '
                            <li class="admin_defil"><button class="admin_defil" name="goto_'.($_SESSION["npage"]-1).'">_'.($_SESSION["npage"]-1).'_</button></li>';
                        }

                        echo '
                            <li class="admin_defil"><button class="admin_stop" name="goto_'.$_SESSION["npage"].'">_'.$_SESSION["npage"].'_</button></li>';

                        if($maxpage > 2){
                            echo '
                        <li class="admin_defil"><button class="admin_defil" name="goto_'.($_SESSION["npage"]+1).'">_'.($_SESSION["npage"]+1).'_</button></li>';
                        }
                        if($maxpage > 4 && $_SESSION["npage"] < $maxpage - 2){
                            echo '
                        <li class="admin_defil"><button class="admin_defil" name="goto_'.($_SESSION["npage"]+2).'">_'.($_SESSION["npage"]+2).'_</button></li>';
                        }
                    }

                    if ($_SESSION["npage"] >= $maxpage){
                        echo '<li class="admin_stop"><button class="admin_stop" name="plus_defil">_</button></li>';
                    }
                    else{
                        echo '<li class="admin_defil"><button class="admin_defil" name="plus_defil">>></button></li>';
                    }
                ?>
            </nav>
        </ul>
    
    </form>

    <br><br>
    <div class="afterimage">
        <span class="first-afterimage">Nous contacter :</span>
        <p>Email : contact@campingextreme.com<br/>Téléphone : 01 23 45 67 89</p>
        <br/>
    </div>
    </body>
</php>
