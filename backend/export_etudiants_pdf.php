<?php
/**
 * ====================================================
 * BACKEND: Export PDF Répertoire Étudiants
 * ====================================================
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/classes/DataManager.php';

// Vérifier l'authentification
if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "/login.php?error=session_expiree");
    exit;
}

// Fallback if FPDF is not installed: simple HTML print
if (!file_exists(__DIR__ . '/libs/fpdf/fpdf.php')) {
    $db = getDB();
    $id_filiere = (int)($_GET['filiere'] ?? 0);
    
    $query = "SELECT e.*, f.nom_filiere FROM etudiant e 
              LEFT JOIN filiere f ON e.id_filiere = f.id_filiere";
    if ($id_filiere) {
        $query .= " WHERE e.id_filiere = $id_filiere";
    }
    $res = $db->query($query);
    $etudiants = $res->fetch_all(MYSQLI_ASSOC);
    
    $filiere_name = "Toutes les filières";
    if ($id_filiere) {
         $f_res = $db->query("SELECT nom_filiere FROM filiere WHERE id_filiere = $id_filiere");
         $filiere_name = $f_res->fetch_assoc()['nom_filiere'] ?? "Inconnue";
    }
    
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Liste des Étudiants - <?= $filiere_name ?></title>
        <style>
            body { font-family: 'Inter', sans-serif; padding: 40px; color: #333; }
            .header { text-align: center; margin-bottom: 40px; border-bottom: 2px solid #003fb1; padding-bottom: 20px; }
            h1 { color: #003fb1; margin: 0; }
            table { w-full: 100%; width: 100%; border-collapse: collapse; margin-top: 20px; }
            th, td { border: 1px solid #ddd; padding: 12px; text-align: left; font-size: 12px; }
            th { bg-color: #f8f9fa; background-color: #f8f9fa; font-weight: bold; text-transform: uppercase; }
            .footer { margin-top: 50px; text-align: right; font-size: 10px; color: #777; }
            @media print { .btn-print { display: none; } }
            .btn-print { background: #003fb1; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; float: right; }
        </style>
    </head>
    <body onload="if(confirm('Imprimer ce document ?')) window.print()">
        <button class="btn-print" onclick="window.print()">Imprimer</button>
        <div class="header">
            <h1>RÉPERTOIRE DES ÉTUDIANTS</h1>
            <p>Filière: <strong><?= htmlspecialchars($filiere_name) ?></strong></p>
            <p>Date d'édition: <?= date('d/m/Y H:i') ?></p>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Matricule</th>
                    <th>Nom & Prénom</th>
                    <th>Email</th>
                    <th>Filière</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($etudiants as $et): ?>
                <tr>
                    <td><?= $et['matricule'] ?></td>
                    <td><?= htmlspecialchars($et['nom'] . ' ' . $et['prenom']) ?></td>
                    <td><?= $et['email'] ?></td>
                    <td><?= htmlspecialchars($et['nom_filiere'] ?? '-') ?></td>
                    <td><?= $et['statut'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="footer">
            <p>Système de Gestion Académique LMD - Document Officiel</p>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Logic with FPDF would go here if library was present
?>
