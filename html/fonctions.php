<?php
    session_start();

    function get_data($path = "../json/utilisateurs.json"){
        if(!file_exists($path)){
            echo "Erreur : Le fichier n'existe pas";
            return null;
        }
        if (!is_readable($path)) {
            echo "Erreur : Le fichier n'est pas lisible.";
            return null;
        }

        $contenu=file_get_contents($path);

        if ($contenu == false){
                echo "Erreur : Lecture du fichier.";
                return null;
        }

        $donnees=json_decode($contenu,true);
        if($donnees == null){
            echo "Erreur : Décodage JSON échoué.";
            return null;
        }

        return $donnees;
    }

    function password_safe($pasword){
        $maj=0;
        $min=0;
        $num=0;
        $spe=0;
        foreach(str_split($pasword) as $letter){
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
        if (strlen($pasword)>=8 && $maj == 1 && $min == 1 && $num == 1 && $spe == 1){
            return 1;
        }
        else{
            return 0;
        }
    }

    function new_login($login,$path = "../json/utilisateurs.json"){
        $users=get_data("../json/utilisateurs.json");

        if(strlen($login)<2){
            return 0;
        }

        if($users === null){
            return 1;
        }
        else{

            foreach($users as $logins){
                if(isset($logins["login"]) && $logins["login"] === $login){
                    return 0;
                    break;
                }
            }
            return 1;
        }
    }

    function bandeau($page){
        echo '<ul class="bandeau">
            <nav class="bandeau">
                <li class="bandeau"';

        if ($page == "presentation"){
            echo ' id="current"><a id="current"';
        }
        else{
            echo '><a';
        }
        echo ' class="bandeau" href="presentation.php">PRESENTATION</a></li>
                <li class="bandeau"';
        if ($page == "recherche"){
            echo ' id="current"><a id="current"';
        }
        else{
            echo '><a';
        }
        echo ' class="bandeau" href="recherche.php">ITINERAIRES</a></li>';

        if(isset($_SESSION["connexion"]) && $_SESSION["connexion"] == "connected"){
            if(isset($_SESSION["role"]) && $_SESSION["role"] == "admin"){
                echo '<li class="bandeau"';
                if($page == "admin"){
                    echo ' id="current"><a id="current"';
                }
                else{
                    echo '><a';
                }
                echo ' class="bandeau" href="admin.php">ADMIN</a></li>';
            }

            echo '<li class="profil"';
            if($page == "profil"){
                echo ' id="current"><a id="current"';
            }
            else{
                echo '><a';
            }
            echo ' class="profil" href="profil.php"> <img src="../images/profil_picture.webp" class="profil_picture" alt="Profil"/></a>';
        }
        else{
            echo '
                <li class="bandeau"';
            if($page == "connexion"){
                echo ' id="current"><a id="current"';
            }
            else{
                echo '><a';
            }
            echo ' class="bandeau" href="connexion.php">CONNEXION</a></li>';

            echo '
                <li class="bandeau"';
            if($page == "inscription"){
                echo ' id="current"><a id="current"';
            }
            else{
                echo '><a';
            }
            echo ' class="bandeau" href="inscription.php">INSCRIPTION</a></li>';
        }

        echo '
        </nav>
        </ul>';
    }

?>
                        
                        