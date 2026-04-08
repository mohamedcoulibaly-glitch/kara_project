<?php
/**
 * Script de réinitialisation des mots de passe
 * À exécuter une seule fois depuis le navigateur
 * Supprimez ce fichier après utilisation pour des raisons de sécurité
 */

require_once __DIR__ . '/config/config.php';

// Vérifier si le script a déjà été exécuté
if (isset($_GET['executed'])) {
    echo "<h1>Mots de passe réinitialisés avec succès !</h1>";
    echo "<p>Vous pouvez maintenant vous connecter avec :</p>";
    echo "<ul>";
    echo "<li><strong>Admin :</strong> admin@univ.local / Admin2026!</li>";
    echo "<li><strong>Scolarite :</strong> scolarite.sim@univ.local / Demo2026!</li>";
    echo "<li><strong>Directeur :</strong> directeur.sim@univ.local / Demo2026!</li>";
    echo "<li><strong>Enseignant :</strong> enseignant.sim@univ.local / Demo2026!</li>";
    echo "</ul>";
    echo "<p><a href='login.php'>Aller à la page de connexion</a></p>";
    exit;
}

try {
    $db = getDB();
    
    // Mots de passe hachés
    $adminPass = password_hash('Admin2026!', PASSWORD_DEFAULT);
    $demoPass = password_hash('Demo2026!', PASSWORD_DEFAULT);
    
    // Vérifier si la table utilisateur existe
    $result = $db->query("SHOW TABLES LIKE 'utilisateur'");
    if ($result->num_rows === 0) {
        die("Erreur : La table 'utilisateur' n'existe pas. Importez d'abord la base de données.");
    }
    
    // Mettre à jour ou créer l'admin
    $stmt = $db->prepare("SELECT id_user FROM utilisateur WHERE email = ?");
    $stmt->bind_param("s", $adminEmail);
    
    $adminEmail = 'admin@univ.local';
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Mettre à jour l'admin existant
        $update = $db->prepare("UPDATE utilisateur SET password = ?, role = 'Admin', statut = 'Actif' WHERE email = ?");
        $update->bind_param("ss", $adminPass, $adminEmail);
        $update->execute();
        echo "Admin mis à jour<br>";
    } else {
        // Créer l'admin
        $insert = $db->prepare("INSERT INTO utilisateur (nom, prenom, email, password, role, statut) VALUES (?, ?, ?, ?, ?, ?)");
        $nom = 'Admin';
        $prenom = 'Système';
        $role = 'Admin';
        $statut = 'Actif';
        $insert->bind_param("ssssss", $nom, $prenom, $adminEmail, $adminPass, $role, $statut);
        $insert->execute();
        echo "Admin créé<br>";
    }
    
    // Créer les autres utilisateurs de test
    $users = [
        ['Scolarite', 'Sim', 'scolarite.sim@univ.local', 'Scolarite'],
        ['Directeur', 'Sim', 'directeur.sim@univ.local', 'Directeur'],
        ['Enseignant', 'Sim', 'enseignant.sim@univ.local', 'Enseignant'],
    ];
    
    $insertUser = $db->prepare("INSERT IGNORE INTO utilisateur (nom, prenom, email, password, role, statut) VALUES (?, ?, ?, ?, ?, 'Actif')");
    
    foreach ($users as $user) {
        $insertUser->bind_param("sssss", $user[0], $user[1], $user[2], $demoPass, $user[3]);
        $insertUser->execute();
        echo "Utilisateur {$user[2]} créé/mis à jour<br>";
    }
    
    // Rediriger vers la page de succès
    header("Location: reset_password.php?executed=1");
    exit;
    
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>