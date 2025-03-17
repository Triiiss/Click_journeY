<?php
    session_start();
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
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Jean Dupont </td>
                <td>jean.dupont@example.com</td>
                <td>Admin</td>
                <td><button class="admin">Modifier</button><button class="admin">Supprimer</button></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Marie Durand</td>
                <td>marie.durand@example.com</td>
                <td>Utilisateur</td>
                <td><button class="admin">Modifier</button><button class="admin">Supprimer</button></td>
            </tr>
            <!-- Tu peux ajouter plus de lignes ici avec des utilisateurs supplémentaires -->
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
