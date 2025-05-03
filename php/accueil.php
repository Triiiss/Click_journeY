<?php
    include 'fonctions.php';
    session_start();
?>

<!DOCTYPE php>
<php>
    <head>
        <meta charset="utf-8"/>
        <title>Camping de l'extreme - Accueil </title>
        <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    </head>
    <body class="accueilpage">
        <script src="../javascript/chg_theme.js"></script>
        <h1 class="titre">Camping de l'Extreme <img src="../images/logo.png" class="logo" alt="logo de l'image"/></h1>
        <a class="accueil" href="accueil.php" id="accueil">Accueil</a><br/>

        <?php bandeau("accueil");?>

        <h1 class="titre-accueil"><span>Camping de l'Extrême</span></h1>
        
        <div class="afterimageaccueil">
            <span class="first-afterimage">Accueil</span>
            <p>Le camping de l'Extreme est une agence de voyage basée sur les campings dans des conditions extrêmes.<br/>Que ce soit dans la montagne, le désert, la forêt ou un endroit hostile, Le Camping de l'extrême est là pour vous</p>
            <br>
            <p>Photos</p>
            <br>
            <p>Nous contacter :<br/>Email: contact@campingextreme.com<br/>Téléphone : 01 23 45 67 89</p>
            <br/>
        </div>
    </body>
</php>
