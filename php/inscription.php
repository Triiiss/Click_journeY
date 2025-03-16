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
                if (!isset($telephone) || strlen($telephone) == 0){
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