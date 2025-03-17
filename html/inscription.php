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
            </nav>
        </ul>
			
            <form action="inscription.php" method="post">
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


                        if((!isset($prenom)) || (!isset($nom)) || (!isset($email)) || (!isset($login)) || (!isset($mdp)) || (!isset($mdpcfrm)) || (!isset($conditions)) || empty($prenom) || empty($nom) || empty($email) || empty($login) || empty($mdp) || empty($mdpcfrm)){          // Vérifie que les informations + importantes sont remplies
                                echo '<p>Les champs obligatoires n\'ont pas été remplis</p>';
                        }
                        else{
                                if($mdp!==$mdpcfrm){             // Les mots de passe sont les mêmes
                                        echo '<p>Les mots de passe sont différents</p>';
                                }
                                else{                           // Tout est bon
                                        echo '<p>Inscription en cours...</p>';
                                        /* Si les informations non required sont vides, on met un - à la place*/
                                        if (!isset($genre) || empty($genre)){
                                                $genre = "-";
                                        }
                                        if (!isset($telephone) || empty($telephone) || !is_numeric($telephone) || empty($telephone) != 10){
                                                $telephone = "-";
                                        }
                                        if (!isset($date) || empty($date)){
                                                $date = "-";
                                        }
                                        if (!isset($adresse) || empty($adresse)){
                                                $adresse = "-";
                                        }

                                        // Profil = informations complémentaires
                                        $profil=array(
                                            "prenom"=> $prenom, 
                                            "nom"=> $nom, 
                                            "email"=> $email, 
                                            "genre"=> $genre, 
                                            "telephone"=> $telephone, 
                                            "date de naissance"=> $date, 
                                            "adresse"=> $adresse);

                                        // On rempli la fiche de l'utilisateur dans un array
                                        $nouvel_utilisateur=array(
                                            "login"=> $login, 
                                            "mdp"=> $mdp,
                                            "email"=> $email, 
                                            "role"=> "normal", 
                                            "profil"=> $profil,
                                            "voyages"=> array(),
                                            "date d'inscription"=> date("Y-m-d"));
                                        
                                        $json_data = file_get_contents("../json/utilisateurs.json");
                                        if($json_data === false){
                                            die("Erreur de lecture du fichier json");
                                        }
                                        $users = json_decode($json_data, true);

                                        $users[] = $nouvel_utilisateur;

                                        //On le met dans un fichier json
                                        if (file_put_contents('../json/utilisateurs.json', json_encode($users, JSON_PRETTY_PRINT))===false){
                                            die("Erreur de sauvegarde de fichier json");
                                        }

                                        // Dire à la session qu'on est connecté, et renvoyer à l'accueil
                                        $_SESSION["connexion"] = "connected";
                                        $_SESSION["login"] = $login;
                                        $_SESSION["role"] = "admin";

                                        header("Location: accueil.php");
                                }
                        }
                    ?>
                </fieldset>
        </form>

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