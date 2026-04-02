<?php
require_once 'config/config.php';

echo "<h1>Utilisateurs dans la base de données</h1>";

$db = getDB();
$result = $db->query('SELECT id_user, email, nom, prenom, role, statut FROM utilisateur');

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Email</th><th>Nom</th><th>Prénom</th><th>Rôle</th><th>Statut</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id_user'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['nom'] . "</td>";
        echo "<td>" . $row['prenom'] . "</td>";
        echo "<td>" . $row['role'] . "</td>";
        echo "<td>" . $row['statut'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Aucun utilisateur trouvé dans la base de données.</p>";
}

echo "<h2>Test de connexion</h2>";
echo "<p>Essayez avec ces identifiants :</p>";
echo "<ul>";
echo "<li>Email: admin@univ.local</li>";
echo "<li>Mot de passe: admin123</li>";
echo "</ul>";

echo "<p><a href='login.php'>Retour à la page de connexion</a></p>";
?>