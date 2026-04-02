<?php
require_once 'config/config.php';

echo "<h1>Réinitialisation du mot de passe administrateur</h1>";

$db = getDB();

// Mot de passe admin123 haché
$hashed_password = password_hash('admin123', PASSWORD_DEFAULT);

// Mettre à jour le mot de passe de l'utilisateur admin
$result = $db->query("UPDATE utilisateur SET password = '$hashed_password' WHERE email = 'admin@univ.local'");

if ($result) {
    echo "<p style='color:green'>✓ Mot de passe réinitialisé avec succès !</p>";
    echo "<p>L'utilisateur admin@univ.local a maintenant le mot de passe : <strong>admin123</strong></p>";
} else {
    echo "<p style='color:red'>✗ Erreur lors de la mise à jour du mot de passe.</p>";
}

echo "<p><a href='login.php'>Aller à la page de connexion</a></p>";
?>