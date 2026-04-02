<?php
require_once 'config/config.php';

echo "<h1>Test du mot de passe administrateur</h1>";

$db = getDB();
$result = $db->query('SELECT id_user, email, password, role, statut FROM utilisateur WHERE email = "admin@univ.local"');
$row = $result->fetch_assoc();

echo "<p>Mot de passe hashé: " . $row['password'] . "</p>";
echo "<p>Test verification: " . (password_verify('admin123', $row['password']) ? 'OK' : 'KO') . "</p>";

if (password_verify('admin123', $row['password'])) {
    echo "<p style='color:green'>✓ Le mot de passe est correctement configuré !</p>";
    echo "<p>Vous pouvez maintenant vous connecter avec :</p>";
    echo "<ul>";
    echo "<li>Email: admin@univ.local</li>";
    echo "<li>Mot de passe: admin123</li>";
    echo "</ul>";
} else {
    echo "<p style='color:red'>✗ Le mot de passe n'est pas correctement configuré.</p>";
    echo "<p>Réinitialisation du mot de passe...</p>";

    $hashed_password = password_hash('admin123', PASSWORD_DEFAULT);
    $result = $db->query("UPDATE utilisateur SET password = '$hashed_password' WHERE email = 'admin@univ.local'");

    if ($result) {
        echo "<p style='color:green'>✓ Mot de passe réinitialisé avec succès !</p>";
    } else {
        echo "<p style='color:red'>✗ Erreur lors de la réinitialisation.</p>";
    }
}

echo "<p><a href='login.php'>Aller à la page de connexion</a></p>";
?>