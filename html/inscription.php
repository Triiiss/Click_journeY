<?php
    session_start();
?>

<!DOCTYPE php>
<php>
    <head>
        <meta charset="utf-8"/>
        <title>camping de l'extreme - Inscription</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    </head>
    <body>
            <h1 class="titre">Camping de l'Extreme <img src="../images/logo.png" class="logo" alt="logo de l'image"/></h1>
            <a class="accueil" href="accueil.php">Accueil</a><br/>

        <ul class="bandeau">
            <nav class="bandeau">
                <li class="bandeau"><a class="bandeau" href="presentation.php">PRESENTATION</a></li>
                <li class="bandeau"><a class="bandeau" href="recherche.php">ITINERAIRES</a></li>
                <li class="bandeau"><a class="bandeau" href="connexion.php">CONNEXION</a></li>
                <li class="bandeau" id="current"><a class="bandeau" id="current" href="inscription.php">INSCRIPTION</a></li>
                <li class="profil"><a class="profil" href="profil.php"> 
                <img src="../images/profil_picture.webp" class="profil_picture" alt="Profil"/></a>
                </li>
            </nav>
        </ul>
			
            <form action="../php/inscription.php" method="post">
                <fieldset class="formulaire">
                    <legend>Formulaire d'inscription</legend>
                    <label for="genre" >Genre :</label>
                    <div class="inscription">
                        Monsieur<input type="radio" name="genre" value="mr"/>
                        Madame<input type="radio" name="genre" value="mme"/>
                        Autre<input type="radio" name="genre" value="autre"/>
                    </div>
                    <label for="prenom">Prénom : <span class="etoile">*</span> </label>
                    <input type="text" name="prenom" minlength="2" placeholder="Emilie" required>

                    <label for="nom" >Nom : <span class="etoile">*</span> </label>
                    <input type="text" name="nom" minlength="2" placeholder="Dupont" required>

                    <label for="email" >Email : <span class="etoile">*</span> </label>
                    <input type="email" name="email" placeholder="email@gmail.com" required>
                    
                    <label for="tel" >Numéro de téléphone</label>
                    <input type="tel" name="tel" placeholder="01 23 45 67 89" pattern="[0-9]*">

                    <label for="age">Date de naissance :</label>
                    <input type="date" name="age"/>

                    <label for="adresse">Adresse :</label>
                    <input type="text" name="adresse" placeholder="01 rue de la paix Paris"/>

                    <label for="login" >Identifiant : <span class="etoile">*</span> </label>
                    <input type="text" name="login" required>

                    <label for="mdp" >Mot de passe : <span class="etoile">*</span> </label>
                    <input type="password" name="mdp" required>

                    <label for="mdpcfrm" >Confirmation mot de passe : <span class="etoile">*</span> </label>
                    <input type="password" name="mdpcfrm" required>
                    
                    <label for="conditions"></label>
                    <span><input name="conditions" type="checkbox" value="conditions" required/>   <span class="etoile">*</span>Accepter <a href="conditions.php" target="_blank">conditions d'utilisation</a></span>
            
                    <label for="submit"><span class="champs">Les champs obligatoire sont suivis par une étoile rouge <span class="etoile">*</span></span></label>
                    <button class="inscription" name="submit" type="submit" >S'inscrire</button>

                    <p>Déjà inscrit ? <a href="connexion.php">Connectez vous</a></p>
                </fieldset>
        </form>

        <?php
            $genre=$_POST["genre"];
            $prenom=$_POST["prenom"];
            $nom=$_POST["nom"];
            $email=$_POST["email"];
            $telephone=$_POST["tel"];
            $date=$_POST["age"];
            $adresse=$_POST["adresse"];
            $login=$_POST["login"];
            $mdp=$_POST["mdp"];
            $mdpcfrm=$_POST["mdpcfrm"];
            $conditions=$_POST["conditions"];


            if((!isset($prenom)) || (!isset($nom)) || (!isset($email)) || (!isset($login)) || (!isset($mdp)) || (!isset($mdpcfrm)) || (!isset($conditions)) || (strlen($prenom) == 0) || (strlen($nom) == 0) || (strlen($email) == 0) || (strlen($login) == 0) || (strlen($mdp) == 0) || (strlen($mdpcfrm) == 0)){          // Vérifie que les informations + importantes sont remplies
                    echo "Les champs obligatoires n'ont pas été remplis";
            }
            else{
                    if($mdp!=$mdpcfrm){             // Les mots de passe sont les mêmes
                            echo "Mots de passe différents";
                    }
                    else{                           // Tout est bon
                            echo "Inscription en cours...";
                            /* Si les informations non required sont vides, on met un - à la place*/
                            if (!isset($genre) || strlen($genre) == 0){
                                    $genre = "-";
                            }
                            if (!isset($telephone) || strlen($telephone) == 0 || !is_numeric($telephone) || strlen($telephone) != 10){
                                    $telephone = "-";
                            }
                            if (!isset($date) || strlen($date) == 0){
                                    $date = "-";
                            }
                            if (!isset($adresse) || strlen($adresse) == 0){
                                    $adresse = "-";
                            }

                            // Profil = informations complémentaires
                            $profil=array("prenom"=> $prenom, "nom"=> $nom, "email"=> $email, "genre"=> $genre, "telephone"=> $telephone, "date de naissance"=> $date, "adresse"=> $adresse);

                            // On rempli la fiche de l'utilisateur dans un array
                            $nouvel_utilisateur=array("login"=> $login, "mdp"=> $mdp,"email"=> $email, "role"=> "normal", "profil"=> $profil, "date d'inscription"=> date("Y-m-d"));

                            //On le met dans un fichier json
                            file_put_contents('../json/utilisateurs.json', json_encode($nouvel_utilisateur, JSON_PRETTY_PRINT), FILE_APPEND);
                    }
            }
        ?>
        <br/>
        <p>Accès temporaire au <a href="profil.php">profil</a> et à <a href="admin.php">l'admin</a></p>

        <br><br>
        <div class="afterimage">
            <span class="first-afterimage">Nous contacter :</span>
            <p>Email : contact@campingextreme.com<br/>Téléphone : 01 23 45 67 89</p>
            <br/>
        </div>
    </body>
</php>
