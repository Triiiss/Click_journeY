<?php
    include 'fonctions.php';
    session_start();
?>

<!DOCTYPE php>
<php>
	<head>
        <meta charset="UTF-8" />
        <title> Camping de l'extrême - présentation</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css"/>
	</head>
	
	<body class="presentation">
                <h1 class="titre">
                        Camping de l'Extreme <img src="../images/logo.png" class="logo" alt="logo de l'image"/>
                        <button class="chg_theme"> 
                                <img src="../images/mode_sombre.png" class="mode_sombre" alt="Mode sombre"/>
                        </button>
                </h1>
        
                <a class="accueil" href="accueil.php">Accueil</a><br/>
                
                <?php bandeau("presentation");?>
        

                <span class="presentation"> Présentation : </span><br/>

                <span class="recherche_rapide">Rechercher rapide : <input type="text" name="rchpage"></span>

                <h2 class="presentation">Bienvenue sur Camping de l'Extême !</h2>

                <h3 class="presentation">Votre agence de voyage dédiée aux aventuriers !</h3>
                <p class="presentation">Que vous soyez passionné par la montagne, les déserts, la toundra ou les régions polaires, nous sommes là pour vous aider à vivre des expériences uniques en pleine nature. Notre mission : vous accompagner dans la découverte et la planification de campings dans des environnements extrêmes.</p>
                        
                <h3 class="presentation">Pourquoi choisir Camping de l'Extême ?</h3>
                <ul class="presentation">
                        <li>Expertise dans les conditions extrêmes : Nous avons une connaissance approfondie des terrains les plus difficiles et des exigences particulières des campings en milieux isolés et sauvages.</li>
                        <li>Sécurité avant tout : Nous nous assurons que vous soyez parfaitement équipé et préparé pour affronter les défis de ces environnements, tout en garantissant votre sécurité et votre confort.</li>
                        <li>Planning personnalisé : Chaque aventure est différente, et c’est pourquoi nous créons des plans de voyage sur mesure pour répondre à vos besoins spécifiques, que vous soyez débutant ou expert en camping.</li>
                        <li>Destinations uniques : Des forêts profondes aux sommets enneigés, en passant par les déserts infinis, nous vous proposons une gamme de destinations peu accessibles, loin des sentiers battus.</li>
                </ul>
                <p class="presentation">Que vous souhaitiez partir en autonomie ou avec des guides expérimentés, nous vous fournissons toutes les informations et les outils nécessaires pour organiser votre voyage de manière simple et efficace.<br/><br/>Explorez. Dépassez vos limites. Racontez votre aventure.<br/><br/>Rejoignez-nous sur Camping de l'Extrême et préparez-vous à vivre une expérience inoubliable, au cœur des paysages les plus fascinants et extrêmes de notre planète.</p>
                        
                <h2 class="presentation">Notre équipe :</h2>
                <p class="presentation">Thémis Tran Tu Thien<br/>Florian Bruyant<br/>Alexis Guimbard</p>
                
                <br><br>
                <div class="afterimage">
                        <span class="first-afterimage">Nous contacter :</span>
                        <p>Email : contact@campingextreme.com<br/>Téléphone : 01 23 45 67 89</p>
                        <br/>
                </div>

                <script src="../javascript/chg_theme.js"></script>
	</body>
</php>
