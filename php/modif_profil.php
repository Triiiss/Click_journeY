<?php

session_start();
$users = json_decode(file_get_contents('../json/utilisateurs.json'), true);

if(isset($_POST['index_user'])){
    $index = $_POST['index_user'];
}
else{
    $index = $_SESSION['user_index'] - 1;
}

if (!isset($users[$index])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non trouvé']);
    exit;
}

$user = &$users[$index];

if(isset($_POST['champ']) && $_POST['value']){
    $champ = $_POST['champ'];
    $value = $_POST['value'];
}
else{
    echo json_encode(['success' => false, 'message' => 'Champ ou valeur manquant']);
    exit;
}

switch ($champ) {
    case 'login':
        $user['login'] = $value;
        break;
    case 'mdp':
        require_once 'fonctions.php';
        if (password_safe($value) != 1) {
            echo json_encode(['success' => false, 'message' => 'Mot de passe trop faible']);
            exit;
        }
        $user['mdp'] = $value;
        break;
    case 'email':
        $user['email'] = $value;
        break;
    case 'nom':
        $user['profil']['nom'] = $value;
        break;
    case 'prenom':
        $user['profil']['prenom'] = $value;
        break;
    case 'adresse':
        $user['profil']['adresse'] = $value;
        break;
    case 'tel':
        $user['profil']['tel'] = $value;
        break;
    case 'dob':
        $user['profil']['dob'] = $value;
        break;
    case 'genre':
        $user['profil']['genre'] = $value;
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Champ non reconnu']);
        exit;
}

file_put_contents('../json/utilisateurs.json', json_encode($users, JSON_PRETTY_PRINT));
echo json_encode(['success' => true, 'message' => 'Mise à jour réussie']);

?>