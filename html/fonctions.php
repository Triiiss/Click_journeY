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
            return array();
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

            if (file_exists("../images/profil_picture/profil_picture_".$_SESSION['login'])){
                echo ' class="profil" href="profil.php"> <img src="../images/profil_picture/profil_picture_'.$_SESSION['login'].'" class="profil_picture" alt="Profil"/></a>';
            }
            else{
                echo ' class="profil" href="profil.php"> <img src="../images/profil_picture/default.webp" class="profil_picture" alt="Profil"/></a>';
            }

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
    
    function getAPIKey($vendeur){
        if(in_array($vendeur, array('MI-1_A', 'MI-1_B', 'MI-1_C', 'MI-1_D', 'MI-1_E', 'MI-1_F', 'MI-1_G', 'MI-1_H', 'MI-1_I', 'MI-1_J', 'MI-2_A', 'MI-2_B', 'MI-2_C', 'MI-2_D', 'MI-2_E', 'MI-2_F', 'MI-2_G', 'MI-2_H', 'MI-2_I', 'MI-2_J', 'MI-3_A', 'MI-3_B', 'MI-3_C', 'MI-3_D', 'MI-3_E', 'MI-3_F', 'MI-3_G', 'MI-3_H', 'MI-3_I', 'MI-3_J', 'MI-4_A', 'MI-4_B', 'MI-4_C', 'MI-4_D', 'MI-4_E', 'MI-4_F', 'MI-4_G', 'MI-4_H', 'MI-4_I', 'MI-4_J', 'MI-5_A', 'MI-5_B', 'MI-5_C', 'MI-5_D', 'MI-5_E', 'MI-5_F', 'MI-5_G', 'MI-5_H', 'MI-5_I', 'MI-5_J', 'MEF-1_A', 'MEF-1_B', 'MEF-1_C', 'MEF-1_D', 'MEF-1_E', 'MEF-1_F', 'MEF-1_G', 'MEF-1_H', 'MEF-1_I', 'MEF-1_J', 'MEF-2_A', 'MEF-2_B', 'MEF-2_C', 'MEF-2_D', 'MEF-2_E', 'MEF-2_F', 'MEF-2_G', 'MEF-2_H', 'MEF-2_I', 'MEF-2_J', 'MIM_A', 'MIM_B', 'MIM_C', 'MIM_D', 'MIM_E', 'MIM_F', 'MIM_G', 'MIM_H', 'MIM_I', 'MIM_J', 'SUPMECA_A', 'SUPMECA_B', 'SUPMECA_C', 'SUPMECA_D', 'SUPMECA_E', 'SUPMECA_F', 'SUPMECA_G', 'SUPMECA_H', 'SUPMECA_I', 'SUPMECA_J', 'TEST'))) {
            return substr(md5($vendeur), 1, 15);
        }
        return "zzzz";
    }
?>
                        
                        