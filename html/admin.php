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
                <th>login</th>
                <th>Password</th>
                <th>Email</th>
                <th>Statut</th>
                <th>nom</th>
                <th>prénom</th>
                <th>genre</th>
                <th>tel</th>
                <th>date naissance</th>
                <th>adresse</th>
                <th>date d'inscription</th>
                <th>Actions</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
                    $json_users=file_get_contents("../json/utilisateurs.json");
                    $users=json_decode($json_users, true);
                    foreach($users as $k=> $user){
                        echo '
                        <tr>
                            <td>'.$user['login'].'  <img class="edit_icon" src="../images/edit_icon.png"/> </td>
                            <td>'.$user['mdp'].'</td>
                            <td>'.$user['email'].'</td>
                            <td>'.$user['role'].'</td>
                            <td>'.$user['profil']['nom'].'</td>
                            <td>'.$user['profil']['prenom'].'</td>
                            <td>'.$user['profil']['genre'].'</td>
                            <td>'.$user['profil']['telephone'].'</td>
                            <td>'.$user['profil']['date de naissance'].'</td>
                            <td>'.$user['profil']['adresse'].'</td>
                            <td>'.$user['date d\'inscription'].'</td>
                            <td><button class="admin">Modifier</button><button class="admin">Supprimer</button></td>
                        </tr>';
                    }
            ?>
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
