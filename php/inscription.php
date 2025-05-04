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

<?php   // Teste si les conditions marchent
    $safemdp = password_safe($mdp);
    $newlogin = new_login($login,"../json/utilisateurs.json");

    if($mdp!==$mdpcfrm){             // Les mots de passe sont les mêmes
            $samepass=0;
    }
    else{
        $samepass=1;
    }
    if(empty($prenom) || empty($nom) || empty($email) || empty($login) || empty($mdp) || empty($mdpcfrm)){          // Vérifie que les informations + importantes sont remplies
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
            "genre"=> $genre, 
            "tel"=> $telephone, 
            "dob"=> $date, 
            "adresse"=> $adresse);

        // On rempli la fiche de l'utilisateur dans un array
        $nouvel_utilisateur=array(
            "login"=> $login,
            "mdp"=> $mdp,
            "email"=> $email, 
            "role"=> "client", 
            "profil"=> $profil,
            "voyages_achete"=> [],
            "voyages_favoris"=> [],
            "voyages_panier"=> [],
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
        $_SESSION["role"] = "client";

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
    <script src="../javascript/formulaires.js"></script>
            <h1 class="titre">
                Camping de l'Extreme <img src="../images/logo.png" class="logo" alt="logo de l'image"/>
                <button class="chg_theme"> 
                    <img src="../images/mode_sombre.png" class="mode_sombre" alt="Mode sombre"/>
                </button>
            </h1>
        
            <a class="accueil" href="accueil.php">Accueil</a><br/>

            <?php bandeau("inscription");?>
			
            <form action="inscription.php" method="post">
                <fieldset class="formulaire">
                    <legend>Formulaire d'inscription</legend>
                    <label for="genre" >Genre :</label>
                    <div class="inscription">
                        Monsieur<input type="radio" name="genre" value="mr" <?php if(isset($_POST["genre"]) && $_POST["genre"] == "mr"){echo 'checked';}?>/>
                        Madame<input type="radio" name="genre" value="mme" <?php if(isset($_POST["genre"]) && $_POST["genre"] == "mme"){echo 'checked';}?>/>
                        Autre<input type="radio" name="genre" value="x" <?php if(isset($_POST["genre"]) && $_POST["genre"] == "x"){echo 'checked';}?>/>
                    </div>
                    <label for="prenom">Prénom : <span class="etoile">*</span> </label>
                    <input type="text" name="prenom" minlength="2" placeholder="Emilie" <?php if(isset($_POST["prenom"])){echo 'value="'.$_POST["prenom"].'"';}?> required>

                    <label for="nom" >Nom : <span class="etoile">*</span> </label>
                    <input type="text" name="nom" minlength="2" placeholder="Dupont" <?php if(isset($_POST["nom"])){echo 'value="'.$_POST["nom"].'"';}?> required>

                    <label for="email" >Email : <span class="etoile">*</span> </label>
                    <input type="email" name="email" placeholder="email@gmail.com" <?php if(isset($_POST["email"])){echo 'value="'.$_POST["email"].'"';}?> required>
                    
                    <label for="tel" >Numéro de téléphone</label>
                    <input id="tel" type="tel" name="tel" placeholder="01 23 45 67 89" pattern="^(\d{2} ?){4}\d{2}$" maxlength="14" <?php if(isset($_POST["tel"])){echo 'value="'.$_POST["tel"].'"';}?>>
                    <script>
                        document.getElementById("tel").addEventListener('input', function (e) {
                            let value = e.target.value.replace(/\D/g, ''); // Enlève tout sauf les chiffres
                            let formatted = value.match(/.{1,2}/g)?.join(' ') ?? '';
                            e.target.value = formatted.substring(0, 14); // Limite à 14 caractères avec espaces
                        });
                    </script>

                    <label for="age">Date de naissance :</label>
                    <input type="date" name="age" <?php if(isset($_POST["age"])){echo 'value="'.$_POST["age"].'"';}?>/>

                    <label for="adresse">Adresse :</label>
                    <input type="text" name="adresse" placeholder="01 rue de la paix Paris" <?php if(isset($_POST["adresse"])){echo 'value="'.$_POST["adresse"].'"';}?>/>

                    <label for="login" >Identifiant : <span class="etoile">*</span> </label>
                    <input type="text" name="login" placeholder="Pseudo" required>
                    <?php
                        if($newlogin == 0 && isset($login)){
                            echo '<p></p>
                            <span class="etoile">L\'identifiant est déjà pris</span>';
                        }
                        
                    ?>

                    <label for="mdp" >Mot de passe : <span class="etoile">*</span> </label>
                    <span>
                        <input type="password" name="mdp" id="password_first" placeholder="********" required>
                        <button type="button" class="edit_icon" onclick="hide_view(1)">
                            <img id="icon_first" src="../images/view.png"/>
                        </button>
                    </span>
                    <span></span>
                    <div><span id="all_conditions" class="etoile">Le mdp a besoin de</span> <span id="length" class="etoile">8min</span> <span id="maj" class="etoile">1 maj</span> <span id="min" class="etoile">1 min</span> <span id="num" class="etoile">1 chiffre</span> <span id="spe" class="etoile">1 car. spécial (!, *, #, %, _)</span></div>
                    <script>
                        document.getElementById("password_first").addEventListener("input", function () {
                        const pwd = this.value;

                        const longEnough = pwd.length >= 8;
                        const hasUpper = /[A-Z]/.test(pwd);
                        const hasLower = /[a-z]/.test(pwd);
                        const hasNumber = /[0-9]/.test(pwd);
                        const hasSpecial = /[!*#%_]/.test(pwd);
                        
                        updateChecklist("length", longEnough);
                        updateChecklist("maj", hasUpper);
                        updateChecklist("min", hasLower);
                        updateChecklist("num", hasNumber);
                        updateChecklist("spe", hasSpecial);
                        updateChecklist("all_conditions", longEnough && hasUpper && hasLower && hasNumber && hasSpecial);
                        });


                        function updateChecklist(id, valid) {
                        const el = document.getElementById(id);
                        if (valid) {
                            el.style.color = "green";
                        } else {
                            el.style.color = "red";
                        }
                        }
                    </script>


                    <label for="mdpcfrm" >Confirmation mot de passe : <span class="etoile">*</span> </label>
                    <span>
                        <input type="password" name="mdpcfrm" id="password_second" placeholder="********" required>
                        <button type="button" class="edit_icon" onclick="hide_view(2)">
                            <img id="icon_second" src="../images/view.png"/>
                        </button>
                    </span>
                    <span></span>
                    <span id="same_mdp" class="etoile"></span>
                    
                    <script>
                        let password_first_input = document.getElementById("password_first");
                        let password_second_input = document.getElementById("password_second");
                        const el = document.getElementById("same_mdp");

                        function same_mdp(){
                            const password_first = password_first_input.value;
                            const password_second = password_second_input.value;

                            if (password_second === "") {
                                el.textContent = ""; // Ne rien afficher tant que le champ est vide
                            } else if (password_first === password_second) {
                                el.textContent = "Les mots de passe correspondent";
                                el.style.color = "green";
                            } else {
                                el.textContent = "Les mots de passe sont différents";
                                el.style.color = "red";
                            }
                        }

                        password_first_input.addEventListener("input", same_mdp);
                        password_second_input.addEventListener("input", same_mdp);
                    </script>
                    
                    <label for="conditions"></label>
                    <span><input name="conditions" type="checkbox" value="conditions" required/>   <span class="etoile">*</span>Accepter <a href="conditions.php" target="_blank">conditions d'utilisation</a></span>
            
                    <label for="submit"><span class="champs">Les champs obligatoire sont suivis par une étoile rouge <span class="etoile">*</span></span></label>
                    <button class="inscription" name="submit" type="button" onclick="verification_inscription()">S'inscrire</button>

                    <p>Déjà inscrit ? <a class="orange" href="connexion.php">Connectez vous</a></p>
                    
                </fieldset>
        </form>

        <br/>

        <br><br>
        <div class="afterimage">
            <span class="first-afterimage">Nous contacter :</span>
            <p>Email : contact@campingextreme.com<br/>Téléphone : 01 23 45 67 89</p>
            <br/>
        </div>

        <script src="../javascript/chg_theme.js"></script>
    </body>
</php>