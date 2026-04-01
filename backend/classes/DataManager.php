<?php
/**
 * ====================================================
 * CLASSE DE GESTION DES ÉTUDIANTS
 * ====================================================
 */
class EtudiantManager {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    // Récupérer un étudiant par ID
    public function getById($id_etudiant) {
        $query = "SELECT e.*, f.nom_filiere, d.nom_dept 
                  FROM etudiant e 
                  LEFT JOIN filiere f ON e.id_filiere = f.id_filiere 
                  LEFT JOIN departement d ON f.id_dept = d.id_dept 
                  WHERE e.id_etudiant = ?";
        
        $stmt = $this->db->prepare($query);
        if ($stmt === false) {
            logError("Erreur de préparation de requête: " . $this->db->error);
            return null;
        }
        
        $stmt->bind_param("i", $id_etudiant);
        if (!$stmt->execute()) {
            logError("Erreur d'exécution: " . $stmt->error);
            return null;
        }
        
        return $stmt->get_result()->fetch_assoc();
    }

    // Récupérer tous les étudiants
    public function getAll($limite = null, $offset = 0) {
        $query = "SELECT e.*, f.nom_filiere, d.nom_dept 
                  FROM etudiant e 
                  LEFT JOIN filiere f ON e.id_filiere = f.id_filiere 
                  LEFT JOIN departement d ON f.id_dept = d.id_dept 
                  WHERE e.statut = 'Actif'";
        
        if ($limite) {
            $query .= " LIMIT ? OFFSET ?";
            $stmt = $this->db->prepare($query);
            if ($stmt === false) {
                logError("Erreur de préparation de requête: " . $this->db->error);
                return [];
            }
            $stmt->bind_param("ii", $limite, $offset);
        } else {
            $stmt = $this->db->prepare($query);
            if ($stmt === false) {
                logError("Erreur de préparation de requête: " . $this->db->error);
                return [];
            }
        }
        
        if (!$stmt->execute()) {
            logError("Erreur d'exécution: " . $stmt->error);
            return [];
        }
        
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Récupérer les étudiants par filière
    public function getByFiliere($id_filiere) {
        $query = "SELECT e.*, f.nom_filiere 
                  FROM etudiant e 
                  LEFT JOIN filiere f ON e.id_filiere = f.id_filiere 
                  WHERE e.id_filiere = ? AND e.statut = 'Actif' 
                  ORDER BY e.nom, e.prenom";
        
        $stmt = $this->db->prepare($query);
        if ($stmt === false) {
            logError("Erreur de préparation de requête: " . $this->db->error);
            return [];
        }
        
        $stmt->bind_param("i", $id_filiere);
        if (!$stmt->execute()) {
            logError("Erreur d'exécution: " . $stmt->error);
            return [];
        }
        
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Rechercher un étudiant
    public function search($terme) {
        $terme = "%$terme%";
        $query = "SELECT e.*, f.nom_filiere 
                  FROM etudiant e 
                  LEFT JOIN filiere f ON e.id_filiere = f.id_filiere 
                  WHERE e.matricule LIKE ? OR e.nom LIKE ? OR e.prenom LIKE ? 
                  ORDER BY e.nom DESC LIMIT 50";
        
        $stmt = $this->db->prepare($query);
        if ($stmt === false) {
            logError("Erreur de préparation de requête: " . $this->db->error);
            return [];
        }
        
        $stmt->bind_param("sss", $terme, $terme, $terme);
        if (!$stmt->execute()) {
            logError("Erreur d'exécution: " . $stmt->error);
            return [];
        }
        
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Insérer un étudiant
    public function insert($data) {
        $query = "INSERT INTO etudiant (matricule, nom, prenom, email, telephone, date_naissance, 
                  lieu_naissance, sexe, nationalite, id_filiere) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($query);
        if ($stmt === false) {
            logError("Erreur de préparation de requête: " . $this->db->error);
            return false;
        }
        
        $stmt->bind_param("sssssssssi", 
            $data['matricule'], $data['nom'], $data['prenom'], $data['email'],
            $data['telephone'], $data['date_naissance'], $data['lieu_naissance'],
            $data['sexe'], $data['nationalite'], $data['id_filiere']
        );
        
        if (!$stmt->execute()) {
            logError("Erreur d'insertion: " . $stmt->error);
            return false;
        }
        
        return true;
    }

    // Mettre à jour un étudiant
    public function update($id_etudiant, $data) {
        $query = "UPDATE etudiant SET nom = ?, prenom = ?, email = ?, telephone = ?, 
                  date_naissance = ?, lieu_naissance = ?, sexe = ?, nationalite = ?, 
                  id_filiere = ?, semestre_actuel = ? 
                  WHERE id_etudiant = ?";
        
        $stmt = $this->db->prepare($query);
        if ($stmt === false) {
            logError("Erreur de préparation de requête: " . $this->db->error);
            return false;
        }
        
        $stmt->bind_param("sssssssssii",
            $data['nom'], $data['prenom'], $data['email'], $data['telephone'],
            $data['date_naissance'], $data['lieu_naissance'], $data['sexe'],
            $data['nationalite'], $data['id_filiere'], $data['semestre_actuel'], $id_etudiant
        );
        
        if (!$stmt->execute()) {
            logError("Erreur de mise à jour: " . $stmt->error);
            return false;
        }
        
        return true;
    }

    // Obtenir le parcours académique d'un étudiant
    public function getParcours($id_etudiant) {
        $query = "SELECT DISTINCT n.*, ec.nom_ec, ue.libelle_ue, ue.credits_ects 
                  FROM note n
                  JOIN ec ON n.id_ec = ec.id_ec
                  JOIN ue ON ec.id_ue = ue.id_ue
                  WHERE n.id_etudiant = ?
                  ORDER BY n.date_examen DESC";
        
        $stmt = $this->db->prepare($query);
        if ($stmt === false) {
            logError("Erreur de préparation de requête: " . $this->db->error);
            return [];
        }
        
        $stmt->bind_param("i", $id_etudiant);
        if (!$stmt->execute()) {
            logError("Erreur d'exécution: " . $stmt->error);
            return [];
        }
        
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}

/**
 * ====================================================
 * CLASSE DE GESTION DES NOTES
 * ====================================================
 */
class NoteManager {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    // Récupérer les notes d'un étudiant par EC
    public function getNotesByEtudiant($id_etudiant, $session = 'Normale') {
        $query = "SELECT n.*, ec.nom_ec, ue.libelle_ue, ue.code_ue 
                  FROM note n
                  JOIN ec ON n.id_ec = ec.id_ec
                  JOIN ue ON ec.id_ue = ue.id_ue
                  WHERE n.id_etudiant = ? AND n.session = ?
                  ORDER BY ue.code_ue";
        
        $stmt = $this->db->prepare($query);
        if ($stmt === false) {
            logError("Erreur de préparation de requête: " . $this->db->error);
            return [];
        }
        
        $stmt->bind_param("is", $id_etudiant, $session);
        if (!$stmt->execute()) {
            logError("Erreur d'exécution: " . $stmt->error);
            return [];
        }
        
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Calculer la moyenne générale d'un étudiant
    public function getMoyenneGenerale($id_etudiant) {
        $query = "SELECT AVG(n.valeur_note) as moyenne 
                  FROM note n
                  WHERE n.id_etudiant = ? AND n.session = 'Normale'";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_etudiant);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['moyenne'] ?? 0;
    }

    // Calculer la moyenne par semestre
    public function getMoyenneSemestre($id_etudiant, $semestre) {
        $query = "SELECT AVG(n.valeur_note) as moyenne 
                  FROM note n
                  JOIN ec ON n.id_ec = ec.id_ec
                  JOIN ue ON ec.id_ue = ue.id_ue
                  JOIN programme p ON (ue.id_ue = p.id_ue)
                  WHERE n.id_etudiant = ? AND p.semestre = ? AND n.session = 'Normale'";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $id_etudiant, $semestre);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['moyenne'] ?? 0;
    }

    // Insérer une note
    public function insert($id_etudiant, $id_ec, $valeur_note, $session = 'Normale') {
        $date_examen = date('Y-m-d');
        $query = "INSERT INTO note (id_etudiant, id_ec, valeur_note, session, date_examen) 
                  VALUES (?, ?, ?, ?, ?) 
                  ON DUPLICATE KEY UPDATE valeur_note = ?, date_modification = NOW()";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iidss d", $id_etudiant, $id_ec, $valeur_note, $session, $date_examen, $valeur_note);
        
        return $stmt->execute();
    }

    // Obtenir les relevés de notes complets
    public function getReleve($id_etudiant) {
        $query = "SELECT 
                    p.semestre,
                    ue.code_ue,
                    ue.libelle_ue,
                    ue.credits_ects,
                    ec.nom_ec,
                    n.valeur_note,
                    n.session,
                    (SELECT AVG(valeur_note) FROM note WHERE id_etudiant = ? AND id_ec = n.id_ec) as moyenne_ec
                  FROM note n
                  JOIN ec ON n.id_ec = ec.id_ec
                  JOIN ue ON ec.id_ue = ue.id_ue
                  JOIN programme p ON ue.id_ue = p.id_ue
                  WHERE n.id_etudiant = ?
                  ORDER BY p.semestre, ue.code_ue";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $id_etudiant, $id_etudiant);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}

/**
 * ====================================================
 * CLASSE DE GESTION DES FILIERES ET UE
 * ====================================================
 */
class FiliereManager {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    // Récupérer toutes les filières
    public function getAll() {
        $query = "SELECT f.*, d.nom_dept, COUNT(e.id_etudiant) as nb_etudiants 
                  FROM filiere f
                  LEFT JOIN departement d ON f.id_dept = d.id_dept
                  LEFT JOIN etudiant e ON f.id_filiere = e.id_filiere
                  GROUP BY f.id_filiere
                  ORDER BY f.nom_filiere";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Récupérer une filière avec ses UE par semestre
    public function getMaquette($id_filiere) {
        $query = "SELECT 
                    p.semestre,
                    ue.id_ue,
                    ue.code_ue,
                    ue.libelle_ue,
                    ue.credits_ects,
                    cc.coefficient_ue,
                    cc.volume_horaire_total,
                    GROUP_CONCAT(ec.nom_ec) as elements
                  FROM programme p
                  JOIN ue ON p.id_ue = ue.id_ue
                  LEFT JOIN ec ON ue.id_ue = ec.id_ue
                  LEFT JOIN configuration_coefficients cc ON (ue.id_ue = cc.id_ue AND cc.id_filiere = p.id_filiere)
                  WHERE p.id_filiere = ?
                  GROUP BY p.semestre, ue.id_ue
                  ORDER BY p.semestre, ue.code_ue";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_filiere);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Obtenir les UE d'un semestre
    public function getUESemestre($id_filiere, $semestre) {
        $query = "SELECT 
                    ue.id_ue,
                    ue.code_ue,
                    ue.libelle_ue,
                    ue.credits_ects,
                    COUNT(ec.id_ec) as nb_ec,
                    GROUP_CONCAT(ec.nom_ec) as elements
                  FROM programme p
                  JOIN ue ON p.id_ue = ue.id_ue
                  LEFT JOIN ec ON ue.id_ue = ec.id_ue
                  WHERE p.id_filiere = ? AND p.semestre = ?
                  GROUP BY ue.id_ue
                  ORDER BY ue.code_ue";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $id_filiere, $semestre);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}

/**
 * ====================================================
 * CLASSE DE GESTION DES DÉLIBÉRATIONS
 * ====================================================
 */
class DeliberationManager {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    // Créer une délibération
    public function create($id_etudiant, $semestre, $data) {
        $code = 'DEL-' . date('YmdHis') . '-' . $id_etudiant;
        $date_deliberation = $data['date_deliberation'] ?? date('Y-m-d');
        
        $query = "INSERT INTO deliberation (code_deliberation, id_etudiant, semestre, 
                  moyenne_semestre, statut, mention, credits_obtenus, date_deliberation, 
                  responsable_deliberation, observations)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("siidsiiiss",
            $code, $id_etudiant, $semestre,
            $data['moyenne_semestre'], $data['statut'], $data['mention'],
            $data['credits_obtenus'], $date_deliberation,
            $data['responsable_deliberation'], $data['observations']
        );
        
        if ($stmt->execute()) {
            return $this->db->insert_id;
        }
        return false;
    }

    // Récupérer une délibération
    public function getById($id_deliberation) {
        $query = "SELECT d.*, e.matricule, e.nom, e.prenom, f.nom_filiere 
                  FROM deliberation d
                  JOIN etudiant e ON d.id_etudiant = e.id_etudiant
                  LEFT JOIN filiere f ON e.id_filiere = f.id_filiere
                  WHERE d.id_deliberation = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_deliberation);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Récupérer les délibérations par étudiant
    public function getByEtudiant($id_etudiant) {
        $query = "SELECT d.*, e.nom, e.prenom 
                  FROM deliberation d
                  JOIN etudiant e ON d.id_etudiant = e.id_etudiant
                  WHERE d.id_etudiant = ?
                  ORDER BY d.semestre DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_etudiant);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}

/**
 * ====================================================
 * CLASSE DE GESTION DES SESSIONS DE RATTRAPAGE
 * ====================================================
 */
class SessionRattrapageManager {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    // Créer une session
    public function create($data) {
        $code = 'RATT-' . date('YmdHis');
        
        $query = "INSERT INTO session_rattrapage (code_session, date_debut, date_fin, id_filiere, statut, description)
                  VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sssiis", $code, $data['date_debut'], $data['date_fin'],
                          $data['id_filiere'], $data['statut'], $data['description']);
        
        return $stmt->execute() ? $this->db->insert_id : false;
    }

    // Récupérer toutes les sessions
    public function getAll() {
        $query = "SELECT s.*, f.nom_filiere, COUNT(ir.id_inscription) as nb_inscrits 
                  FROM session_rattrapage s
                  LEFT JOIN filiere f ON s.id_filiere = f.id_filiere
                  LEFT JOIN inscription_rattrapage ir ON s.id_session = ir.id_session
                  GROUP BY s.id_session
                  ORDER BY s.date_debut DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Inscrire un étudiant
    public function inscribeEtudiant($id_etudiant, $id_session, $id_ec) {
        $query = "INSERT INTO inscription_rattrapage (id_etudiant, id_session, id_ec, statut)
                  VALUES (?, ?, ?, 'Inscrit')";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iii", $id_etudiant, $id_session, $id_ec);
        
        return $stmt->execute();
    }

    // Récupérer les inscrits d'une session
    public function getInscrits($id_session) {
        $query = "SELECT ir.*, e.matricule, e.nom, e.prenom, ec.nom_ec, ue.code_ue
                  FROM inscription_rattrapage ir
                  JOIN etudiant e ON ir.id_etudiant = e.id_etudiant
                  JOIN ec ON ir.id_ec = ec.id_ec
                  JOIN ue ON ec.id_ue = ue.id_ue
                  WHERE ir.id_session = ?
                  ORDER BY e.nom, e.prenom";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_session);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}

?>
