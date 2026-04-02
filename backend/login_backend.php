<?php
require_once "../config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    
    // Validation des champs
    if (empty($email) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Email et mot de passe requis"]);
        exit;
    }
    
    // Vérification de l'utilisateur
    $db = getDB();
    $stmt = $db->prepare("SELECT id_user, email, password, role, statut FROM utilisateur WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if ($user && $user["statut"] == "Actif" && password_verify($password, $user["password"])) {
        // Connexion réussie
        session_start();
        $_SESSION["user_id"] = $user["id_user"];
        $_SESSION["user_role"] = $user["role"];
        $_SESSION["user_email"] = $user["email"];
        
        // Mise à jour du dernier login
        $stmt = $db->prepare("UPDATE utilisateur SET last_login = NOW() WHERE id_user = ?");
        $stmt->bind_param("i", $user["id_user"]);
        $stmt->execute();
        
        echo json_encode(["success" => true, "redirect" => "../index.php"]);
    } else {
        echo json_encode(["success" => false, "message" => "Email ou mot de passe incorrect"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Méthode non autorisée"]);
}
?>