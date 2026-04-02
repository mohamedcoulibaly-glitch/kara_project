<?php
// Création des backends manquants selon l'audit

$backends_to_create = [
    'login_backend.php' => [
        'description' => 'Authentification utilisateur',
        'content' => '<?php
require_once "../config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    
    // Validation des champs
    if (empty($email) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Email et mot de passe requis"]);
        exit;
    }
    
    // Vérification de l\'utilisateur
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
?>'
    ],

    'gestion_utilisateurs_backend.php' => [
        'description' => 'Gestion des utilisateurs (CRUD)',
        'content' => '<?php
require_once "../config/config.php";

session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] != "Admin") {
    header("Location: ../login.php");
    exit;
}

$action = $_GET["action"] ?? "list";

switch ($action) {
    case "list":
        $db = getDB();
        $result = $db->query("SELECT id_user, email, nom, prenom, role, statut FROM utilisateur ORDER BY email");
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        echo json_encode(["users" => $users]);
        break;
        
    case "add":
        $data = json_decode(file_get_contents("php://input"), true);
        $email = $data["email"];
        $nom = $data["nom"];
        $prenom = $data["prenom"];
        $role = $data["role"];
        $password = password_hash($data["password"], PASSWORD_DEFAULT);
        
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO utilisateur (email, nom, prenom, password, role, statut) VALUES (?, ?, ?, ?, ?, \'Actif\')");
        $stmt->bind_param("sssss", $email, $nom, $prenom, $password, $role);
        
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Utilisateur créé"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erreur lors de la création"]);
        }
        break;
        
    case "edit":
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data["id"];
        $email = $data["email"];
        $nom = $data["nom"];
        $prenom = $data["prenom"];
        $role = $data["role"];
        $statut = $data["statut"];
        
        $db = getDB();
        $stmt = $db->prepare("UPDATE utilisateur SET email = ?, nom = ?, prenom = ?, role = ?, statut = ? WHERE id_user = ?");
        $stmt->bind_param("sssssi", $email, $nom, $prenom, $role, $statut, $id);
        
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Utilisateur mis à jour"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erreur lors de la mise à jour"]);
        }
        break;
        
    case "delete":
        $id = $_POST["id"];
        $db = getDB();
        $stmt = $db->prepare("UPDATE utilisateur SET statut = \'Suspendu\' WHERE id_user = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Utilisateur suspendu"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erreur lors de la suppression"]);
        }
        break;
        
    default:
        echo json_encode(["success" => false, "message" => "Action non reconnue"]);
}
?>'
    ],

    'profil_utilisateur_backend.php' => [
        'description' => 'Profil utilisateur et changement de mot de passe',
        'content' => '<?php
require_once "../config/config.php";

session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit;
}

$action = $_GET["action"] ?? "view";
$user_id = $_SESSION["user_id"];

switch ($action) {
    case "view":
        $db = getDB();
        $stmt = $db->prepare("SELECT id_user, email, nom, prenom, role, statut, last_login FROM utilisateur WHERE id_user = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        echo json_encode(["user" => $user]);
        break;
        
    case "update_profile":
        $data = json_decode(file_get_contents("php://input"), true);
        $nom = $data["nom"];
        $prenom = $data["prenom"];
        
        $db = getDB();
        $stmt = $db->prepare("UPDATE utilisateur SET nom = ?, prenom = ? WHERE id_user = ?");
        $stmt->bind_param("ssi", $nom, $prenom, $user_id);
        
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Profil mis à jour"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erreur lors de la mise à jour"]);
        }
        break;
        
    case "change_password":
        $data = json_decode(file_get_contents("php://input"), true);
        $old_password = $data["old_password"];
        $new_password = $data["new_password"];
        
        $db = getDB();
        $stmt = $db->prepare("SELECT password FROM utilisateur WHERE id_user = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if (password_verify($old_password, $user["password"])) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE utilisateur SET password = ? WHERE id_user = ?");
            $stmt->bind_param("si", $hashed_password, $user_id);
            
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "Mot de passe changé"]);
            } else {
                echo json_encode(["success" => false, "message" => "Erreur lors du changement"]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Ancien mot de passe incorrect"]);
        }
        break;
        
    default:
        echo json_encode(["success" => false, "message" => "Action non reconnue"]);
}
?>'
    ],

    'audit_logs_backend.php' => [
        'description' => 'Journalisation des actions utilisateurs',
        'content' => '<?php
require_once "../config/config.php";

session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] != "Admin") {
    header("Location: ../login.php");
    exit;
}

$action = $_GET["action"] ?? "list";

switch ($action) {
    case "list":
        $db = getDB();
        $result = $db->query("SELECT * FROM audit_log ORDER BY timestamp DESC LIMIT 100");
        $logs = [];
        while ($row = $result->fetch_assoc()) {
            $logs[] = $row;
        }
        echo json_encode(["logs" => $logs]);
        break;
        
    case "export":
        $db = getDB();
        $result = $db->query("SELECT * FROM audit_log ORDER BY timestamp DESC");
        
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=audit_logs_" . date("Y-m-d_His") . ".csv");
        
        $output = fopen("php://output", "w");
        fputcsv($output, ["ID", "User ID", "Action", "Table", "Record ID", "Old Values", "New Values", "IP", "Timestamp"]);
        
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }
        
        fclose($output);
        break;
        
    default:
        echo json_encode(["success" => false, "message" => "Action non reconnue"]);
}
?>'
    ],

    'parametres_systeme_backend.php' => [
        'description' => 'Configuration système',
        'content' => '<?php
require_once "../config/config.php";

session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] != "Admin") {
    header("Location: ../login.php");
    exit;
}

$action = $_GET["action"] ?? "list";

switch ($action) {
    case "list":
        $db = getDB();
        $result = $db->query("SELECT * FROM app_settings");
        $settings = [];
        while ($row = $result->fetch_assoc()) {
            $settings[] = $row;
        }
        echo json_encode(["settings" => $settings]);
        break;
        
    case "update":
        $data = json_decode(file_get_contents("php://input"), true);
        $key = $data["key"];
        $value = $data["value"];
        
        $db = getDB();
        $stmt = $db->prepare("UPDATE app_settings SET setting_value = ?, updated_at = NOW(), updated_by = ? WHERE setting_key = ?");
        $stmt->bind_param("sii", $value, $_SESSION["user_id"], $key);
        
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Paramètre mis à jour"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erreur lors de la mise à jour"]);
        }
        break;
        
    default:
        echo json_encode(["success" => false, "message" => "Action non reconnue"]);
}
?>'
    ]
];

// Création des fichiers
foreach ($backends_to_create as $filename => $info) {
    $filepath = "backend/" . $filename;
    if (!file_exists($filepath)) {
        file_put_contents($filepath, $info["content"]);
        echo "✓ Créé: $filepath<br>";
    } else {
        echo "✗ Existe déjà: $filepath<br>";
    }
}

echo "<h2>Création des backends terminée</h2>";
echo "<p><a href='login.php'>Retour à la page de connexion</a></p>";
?>