<?php
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

        <ul class="bandeau">
            <nav class="bandeau">
                <li class="bandeau"><a class="bandeau" href="presentation.php">PRESENTATION</a></li>
                <li class="bandeau"><a class="bandeau" href="recherche.php">ITINERAIRES</a></li>
                <li class="bandeau"><a class="bandeau" href="connexion.php">CONNEXION</a></li>
                <li class="bandeau" id="current"><a class="bandeau" id="current" href="inscription.php">INSCRIPTION</a></li>
            </nav>
        </ul>
			
            <form action="inscription.php" method="post">
                <fieldset class="formulaire inscription">
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
                        $json_users=file_get_contents("../json/utilisateurs.json");
                        $users=json_decode($json_users, true);
                        foreach($users as $k=> $user){
                            if(isset($user["login"]) && $user["login"] === $login){
                                $newlogin=0;
                                break;
                            }
                        }
                        if($newlogin == 0){
                            echo '<p></p>
                            <span class="etoile">L\'identifiant est déjà pris</span>';
                            $newlogin=0;
                        }
                        else{
                            $newlogin=1;
                        }
                    ?>

                    <label for="mdp" >Mot de passe : <span class="etoile">*</span> </label>
                    <input type="password" name="mdp" required>
                    <?php
                        $maj=0;
                        $min=0;
                        $num=0;
                        $spe=0;
                        foreach(str_split($mdp) as $letter){
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
                        else{
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
                                "telephone"=> $telephone, 
                                "date de naissance"=> $date, 
                                "adresse"=> $adresse);
                
                            // On rempli la fiche de l'utilisateur dans un array
                            $nouvel_utilisateur=array(
                                "login"=> $login,
                                "mdp"=> $mdp,
                                "email"=> $email, 
                                "role"=> "client", 
                                "profil"=> $profil,
                                "voyages"=> array(),
                                "date d'inscription"=> date("Y-m-d"));
                            
                            
                            //Récupère les données
                
                            $json_data = file_get_contents("../json/utilisateurs.json");
                            if($json_data === false){
                                die("Erreur de lecture du fichier json");
                            }
                            $users = json_decode($json_data, true);
                
                            $users[] = $nouvel_utilisateur;
                
                            //On le met dans un fichier json
                            file_put_contents('../json/utilisateurs.json', json_encode($users, JSON_PRETTY_PRINT));
                
                            // Dire à la session qu'on est connecté, et renvoyer à l'accueil
                            $_SESSION["connexion"] = "connected";
                            $_SESSION["login"] = $login;
                            $_SESSION["role"] = "normal";
                            $_SESSION["user_index"] = array_​key_​last($users)-1;
                
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