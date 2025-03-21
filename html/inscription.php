<?php
    include 'fonctions.php';
    session_start();
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

    $required=0;
    $samepass=0;
    $newlogin=1;
    $safemdp=0;

    if($_SESSION["connexion"]=="connected"){
        header("Location: accueil.php");
    }
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

            <?php bandeau("inscription");?>
			
            <form action="inscription.php" method="post">
                <fieldset class="formulaire">
                    <legend>Formulaire d'inscription</legend>
                    <label for="genre" >Genre :</label>
                    <div class="inscription">
                        Monsieur<input type="radio" name="genre" value="mr"/>
                        Madame<input type="radio" name="genre" value="mme"/>
                        Autre<input type="radio" name="genre" value="x"/>
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
                    <input type="text" name="login" placeholder="pseudo" required>

                    <?php
                        $newlogin = new_login($login,"../json/utilisateurs.json");

                        if($newlogin == 0){
                            echo '<p></p>
                            <span class="etoile">L\'identifiant est déjà pris</span>';
                        }
                        
                    ?>

                    <label for="mdp" >Mot de passe : <span class="etoile">*</span> </label>
                    <input type="password" name="mdp" required>
                    <?php
                        $safemdp = password_safe($mdp);
                        if ($safemdp == 0){
                            echo '<p></p>
                                            <span class="etoile">Le mdp a besoin de 8min 1 maj 1 min 1 chiffre 1 car. spécial (!, *, #, %, _)</span>';
                        }
                    ?>

                    <label for="mdpcfrm" >Confirmation mot de passe : <span class="etoile">*</span> </label>
                    <input type="password" name="mdpcfrm" required>
                    <?php
                        if($mdp!==$mdpcfrm){             // Les mots de passe sont les mêmes
                                echo '<p></p>
                                <span class="etoile">Les mots de passe sont différents</span>';
                                $samepass=0;
                        }
                        else{
                            $samepass=1;
                        }
                    ?>
                    
                    <label for="conditions"></label>
                    <span><input name="conditions" type="checkbox" value="conditions" required/>   <span class="etoile">*</span>Accepter <a href="conditions.php" target="_blank">conditions d'utilisation</a></span>
            
                    <label for="submit"><span class="champs">Les champs obligatoire sont suivis par une étoile rouge <span class="etoile">*</span></span></label>
                    <button class="inscription" name="submit" type="submit" >S'inscrire</button>

                    <p>Déjà inscrit ? <a href="connexion.php">Connectez vous</a></p>
                    
                    <?php
                        if(empty($prenom) || empty($nom) || empty($email) || empty($login) || empty($mdp) || empty($mdpcfrm)){          // Vérifie que les informations + importantes sont remplies
                                echo '<span class="etoile">Les champs obligatoires n\'ont pas été remplis</span>';
                                $required=0;
                        }
                        else{
                            $required=1;
                        }
                    
                        if($required == 1 && $newlogin == 1 && $samepass == 1 && $safemdp == 1){
                            echo '<p>Inscription en cours...</p>';
                            /* Si les informations non required sont vides, on met un - à la place*/
                            if (!isset($genre) || empty($genre)){
                                    $genre = "-";
                            }
                            if (!isset($telephone) || empty($telephone)){
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
                                "tel"=> $telephone, 
                                "dob"=> $date, 
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
                            
                            
                            //Récupère les données
                
                            $users = get_data("../json/utilisateurs.json");
                            if ($users === null){
                                $users = array();
                            }
                
                            $users[] = $nouvel_utilisateur;
                
                            //On le met dans un fichier json
                            file_put_contents('../json/utilisateurs.json', json_encode($users, JSON_PRETTY_PRINT));
                
                            // Dire à la session qu'on est connecté, et renvoyer à l'accueil
                            $_SESSION["user_index"] = array_key_last($users)+1;
                            $_SESSION["connexion"] = "connected";
                            $_SESSION["login"] = $login;
                            $_SESSION["role"] = "normal";
                
                            header("Location: accueil.php");
                        }
                    ?>
                </fieldset>
        </form>

        <br/>

        <br><br>
        <div class="afterimage">
            <span class="first-afterimage">Nous contacter :</span>
            <p>Email : contact@campingextreme.com<br/>Téléphone : 01 23 45 67 89</p>
            <br/>
        </div>
    </body>
</php>