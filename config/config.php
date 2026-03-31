<?php
/**
 * ====================================================
 * FICHIER DE CONFIGURATION - config.php
 * ====================================================
 * Gestion des connexions à la base de données
 * et constantes globales du projet
 */

// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'gestion_notes');
define('DB_CHARSET', 'utf8mb4');

// Chemins de l'application
define('BASE_PATH', dirname(__FILE__));
define('ASSETS_PATH', BASE_PATH . '/assets');
define('IMAGES_PATH', BASE_PATH . '/images');
define('UPLOADS_PATH', BASE_PATH . '/uploads');

// Paramètres généraux
define('APP_NAME', 'Gestion Académique LMD');
define('APP_VERSION', '2.0');
define('TIMEZONE', 'UTC');

// Configuration de date
date_default_timezone_set(TIMEZONE);

/**
 * ====================================================
 * CLASSE DE CONNEXION À LA BASE DE DONNÉES
 * ====================================================
 */
class Database {
    private $connection;
    private static $instance;

    // Singleton - une seule instance de la connexion
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Constructeur privé pour éviter l'instanciation directe
    private function __construct() {
        try {
            $this->connection = new mysqli(
                DB_HOST,
                DB_USER,
                DB_PASS,
                DB_NAME
            );

            // Configuration du charset
            $this->connection->set_charset(DB_CHARSET);

            // Vérification de la connexion
            if ($this->connection->connect_error) {
                throw new Exception("Erreur de connexion: " . $this->connection->connect_error);
            }
        } catch (Exception $e) {
            die("Erreur de base de données: " . $e->getMessage());
        }
    }

    // Obtenir la connexion
    public function getConnection() {
        return $this->connection;
    }

    // Exécuter une requête préparée
    public function prepare($query) {
        return $this->connection->prepare($query);
    }

    // Fermer la connexion
    public function close() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}

/**
 * ====================================================
 * FONCTION UTILITAIRE - Récupérer la connexion
 * ====================================================
 */
function getDB() {
    return Database::getInstance()->getConnection();
}

/**
 * ====================================================
 * TRAITEMENT DES ERREURS ET LOG
 * ====================================================
 */
function logError($message, $type = 'ERROR') {
    $logDir = BASE_PATH . '/logs';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    $date = date('Y-m-d H:i:s');
    $logFile = $logDir . '/' . date('Y-m-d') . '.log';
    file_put_contents($logFile, "[$date] [$type] $message\n", FILE_APPEND);
}

/**
 * ====================================================
 * FONCTIONS UTILITAIRES GÉNÉRALES
 * ====================================================
 */

// Nettoyer les entrées
function clean($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Formater une date
function formatDate($date, $format = 'd/m/Y') {
    return date($format, strtotime($date));
}

// Formater une note
function formatGrade($note) {
    if ($note === null) return '-';
    return number_format($note, 2, '.', ' ');
}

// Obtenir la mention selon la moyenne
function getMention($moyenne) {
    if ($moyenne >= 16) return 'Très Bien';
    if ($moyenne >= 14) return 'Bien';
    if ($moyenne >= 12) return 'Assez Bien';
    if ($moyenne >= 10) return 'Passable';
    return 'Non Admis';
}

// Calculer la moyenne
function calculerMoyenne($notes) {
    if (empty($notes)) return 0;
    return array_sum($notes) / count($notes);
}

// Vérifier si un étudiant est admis
function isAdmitted($moyenne) {
    return $moyenne >= 10;
}

// Formater l'affichage d'erreurs
function showError($message) {
    return "<div class='alert alert-danger' role='alert'>" . htmlspecialchars($message) . "</div>";
}

// Formater l'affichage de succès
function showSuccess($message) {
    return "<div class='alert alert-success' role='alert'>" . htmlspecialchars($message) . "</div>";
}

// Rediriger vers une page
function redirect($path) {
    header("Location: " . BASE_PATH . "/" . $path);
    exit();
}

// Obtenir un paramètre GET sécurisé
function getParam($key, $default = null) {
    return isset($_GET[$key]) ? clean($_GET[$key]) : $default;
}

// Obtenir un paramètre POST sécurisé
function postParam($key, $default = null) {
    return isset($_POST[$key]) ? clean($_POST[$key]) : $default;
}

?>
