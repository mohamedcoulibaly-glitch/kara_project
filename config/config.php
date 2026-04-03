<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
/**
 * ====================================================
 * FICHIER DE CONFIGURATION - config.php
 * ====================================================
 * Gestion des connexions à la base de données
 * et constantes globales du projet
 */

/**
 * Vérifier si l'utilisateur est connecté
 */
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

/**
 * Système d'autorisation par rôle
 */
function checkAuth($required_roles = [])
{
    // Si pas de session active, rediriger vers login
    if (!isset($_SESSION['user_id'])) {
        // Pour les requêtes AJAX, retourner JSON
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo json_encode(['error' => 'Session expirée', 'redirect' => BASE_URL . '/login.php']);
            exit;
        }
        header("Location: " . BASE_URL . "/login.php?error=votre_session_a_expiree");
        exit;
    }

    // Si des rôles sont requis, vérifier le rôle de l'utilisateur
    if (!empty($required_roles) && !in_array($_SESSION['user_role'] ?? '', $required_roles)) {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo json_encode(['error' => 'Accès refusé', 'required_roles' => $required_roles]);
            exit;
        }
        header("Location: " . BASE_URL . "/index.php?error=acces_refuse");
        exit;
    }
}

/**
 * Logger les actions des utilisateurs (Audit)
 */
function logUserAction($action, $table_name = null, $record_id = null, $old_values = null, $new_values = null)
{
    if (!isset($_SESSION['user_id']))
        return;

    $db = getDB();
    $user_id = $_SESSION['user_id'];
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

    $query = "INSERT INTO audit_log (user_id, action, table_name, record_id, old_values, new_values, ip_address) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = Database::getInstance()->prepare($query);
    if ($stmt) {
        $old_json = $old_values ? json_encode($old_values, JSON_UNESCAPED_UNICODE) : null;
        $new_json = $new_values ? json_encode($new_values, JSON_UNESCAPED_UNICODE) : null;
        $stmt->bind_param("issssss", $user_id, $action, $table_name, $record_id, $old_json, $new_json, $ip_address);
        $stmt->execute();
    }
}

/**
 * Obtenir les informations de l'utilisateur connecté
 */
function getCurrentUser()
{
    if (!isset($_SESSION['user_id']))
        return null;

    $query = "SELECT id_user, email, nom, prenom, role, statut, last_login 
              FROM utilisateur WHERE id_user = ?";
    $stmt = Database::getInstance()->prepare($query);
    if ($stmt) {
        $stmt->bind_param("i", $_SESSION['user_id']);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result ? $result->fetch_assoc() : null;
        }
    }
    return null;
}

// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'gestion_notes');
define('DB_CHARSET', 'utf8mb4');

define('BASE_PATH', dirname(__FILE__));
define('BASE_URL', '/kara_project'); // Ajusté selon votre dossier XAMPP
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
 * TRAITEMENT DES ERREURS ET LOG
 * ====================================================
 * DÉFINI EN PREMIER - Utilisé par d'autres classes
 */
function logError($message, $type = 'ERROR')
{
    $logDir = BASE_PATH . '/logs';
    if (!is_dir($logDir)) {
        @mkdir($logDir, 0755, true);
    }

    $date = date('Y-m-d H:i:s');
    $logFile = $logDir . '/' . date('Y-m-d') . '.log';
    @file_put_contents($logFile, "[$date] [$type] $message\n", FILE_APPEND);
}

/**
 * ====================================================
 * CLASSE WRAPPER POUR GÉRER LES ERREURS
 * ====================================================
 * SafeStatement encapsule les prepared statements
 * et gère automatiquement les erreurs
 */
class SafeStatement
{
    private $stmt;
    private $error = false;

    public function __construct($stmt)
    {
        if ($stmt === false) {
            $this->error = true;
            $this->stmt = null;
        } else {
            $this->stmt = $stmt;
        }
    }

    public function bind_param($types, &...$vars)
    {
        if ($this->error || !$this->stmt) {
            return false;
        }

        if (!$this->stmt->bind_param($types, ...$vars)) {
            $this->error = true;
            return false;
        }
        return true;
    }

    public function execute()
    {
        if ($this->error || !$this->stmt) {
            return false;
        }

        if (!$this->stmt->execute()) {
            $this->error = true;
            return false;
        }
        return true;
    }

    public function get_result()
    {
        if ($this->error || !$this->stmt) {
            return false;
        }
        return $this->stmt->get_result();
    }

    public function __get($name)
    {
        if ($this->stmt) {
            return $this->stmt->$name;
        }
        return null;
    }
}

/**
 * ====================================================
 * CLASSE DE CONNEXION À LA BASE DE DONNÉES
 * ====================================================
 */
class Database
{
    private $connection;
    private static $instance;

    // Singleton - une seule instance de la connexion
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Constructeur privé pour éviter l'instanciation directe
    private function __construct()
    {
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
    public function getConnection()
    {
        return $this->connection;
    }

    // Exécuter une requête préparée - retourne automatiquement un wrapper sécurisé
    public function prepare($query)
    {
        $stmt = $this->connection->prepare($query);
        if ($stmt === false) {
            logError("Erreur de préparation: " . $this->connection->error . " | Query: " . substr($query, 0, 100));
            return new SafeStatement(false);
        }
        return new SafeStatement($stmt);
    }

    // Fermer la connexion
    public function close()
    {
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
function getDB()
{
    return Database::getInstance()->getConnection();
}

/**
 * ====================================================
 * FONCTIONS DE GESTION DES REQUÊTES SÉCURISÉES
 * ====================================================
 */

/**
 * Exécute une requête SELECT en toute sécurité
 * Retourne le résultat ou false en cas d'erreur
 */
function safeQuery($query, $bindParams = [])
{
    try {
        $db = getDB();
        if (!$db) {
            logError("Erreur: Connexion à la base de données impossible");
            return false;
        }

        $stmt = $db->prepare($query);
        if ($stmt === false) {
            logError("Erreur de préparation de requête: " . $db->error);
            return false;
        }

        if (!empty($bindParams)) {
            // Construire les types et les références pour bind_param
            $types = '';
            $values = [];
            foreach ($bindParams as $param) {
                if (is_int($param)) {
                    $types .= 'i';
                } elseif (is_float($param)) {
                    $types .= 'd';
                } else {
                    $types .= 's';
                }
                $values[] = $param;
            }
            
            if (!$stmt->bind_param($types, ...$values)) {
                logError("Erreur de binding: " . $stmt->error);
                return false;
            }
        }

        if (!$stmt->execute()) {
            logError("Erreur d'exécution de requête: " . $stmt->error);
            return false;
        }

        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : false;
    } catch (Exception $e) {
        logError("Exception lors de l'exécution: " . $e->getMessage());
        return false;
    }
}

/**
 * Exécute une requête SELECT et retourne une seule ligne
 */
function safeQuerySingle($query, $bindParams = [])
{
    try {
        $db = getDB();
        if (!$db) {
            logError("Erreur: Connexion à la base de données impossible");
            return false;
        }

        $stmt = $db->prepare($query);
        if ($stmt === false) {
            logError("Erreur de préparation de requête: " . $db->error);
            return false;
        }

        if (!empty($bindParams)) {
            // Construire les types et les références pour bind_param
            $types = '';
            $values = [];
            foreach ($bindParams as $param) {
                if (is_int($param)) {
                    $types .= 'i';
                } elseif (is_float($param)) {
                    $types .= 'd';
                } else {
                    $types .= 's';
                }
                $values[] = $param;
            }
            
            if (!$stmt->bind_param($types, ...$values)) {
                logError("Erreur de binding: " . $stmt->error);
                return false;
            }
        }

        if (!$stmt->execute()) {
            logError("Erreur d'exécution de requête: " . $stmt->error);
            return false;
        }

        $result = $stmt->get_result();
        return $result ? $result->fetch_assoc() : false;
    } catch (Exception $e) {
        logError("Exception lors de l'exécution: " . $e->getMessage());
        return false;
    }
}

/**
 * Exécute une requête UPDATE/INSERT/DELETE en toute sécurité
 */
function safeExecute($query, $bindParams = [])
{
    try {
        $db = getDB();
        if (!$db) {
            logError("Erreur: Connexion à la base de données impossible");
            return false;
        }

        $stmt = $db->prepare($query);
        if ($stmt === false) {
            logError("Erreur de préparation de requête: " . $db->error);
            return false;
        }

        if (!empty($bindParams)) {
            // Construire les types et les références pour bind_param
            $types = '';
            $values = [];
            foreach ($bindParams as $param) {
                if (is_int($param)) {
                    $types .= 'i';
                } elseif (is_float($param)) {
                    $types .= 'd';
                } else {
                    $types .= 's';
                }
                $values[] = $param;
            }
            
            if (!$stmt->bind_param($types, ...$values)) {
                logError("Erreur de binding: " . $stmt->error);
                return false;
            }
        }

        if (!$stmt->execute()) {
            logError("Erreur d'exécution de requête: " . $stmt->error);
            return false;
        }

        return true;
    } catch (Exception $e) {
        logError("Exception lors de l'exécution: " . $e->getMessage());
        return false;
    }
}

/**
 * ====================================================
 * FONCTIONS UTILITAIRES GÉNÉRALES
 * ====================================================
 */

// Nettoyer les entrées
function clean($data)
{
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Formater une date
function formatDate($date, $format = 'd/m/Y')
{
    return date($format, strtotime($date));
}

// Formater une note
function formatGrade($note)
{
    if ($note === null)
        return '-';
    return number_format($note, 2, '.', ' ');
}

// Obtenir la mention selon la moyenne
function getMention($moyenne)
{
    if ($moyenne >= 16)
        return 'Très Bien';
    if ($moyenne >= 14)
        return 'Bien';
    if ($moyenne >= 12)
        return 'Assez Bien';
    if ($moyenne >= 10)
        return 'Passable';
    return 'Non Admis';
}

// Calculer la moyenne
function calculerMoyenne($notes)
{
    if (empty($notes))
        return 0;
    return array_sum($notes) / count($notes);
}

// Vérifier si un étudiant est admis
function isAdmitted($moyenne)
{
    return $moyenne >= 10;
}

// Formater l'affichage d'erreurs
function showError($message)
{
    return "<div class='alert alert-danger' role='alert'>" . htmlspecialchars($message) . "</div>";
}

// Formater l'affichage de succès
function showSuccess($message)
{
    return "<div class='alert alert-success' role='alert'>" . htmlspecialchars($message) . "</div>";
}

// Rediriger vers une page
function redirect($path)
{
    header("Location: " . BASE_URL . "/" . $path);
    exit();
}

// Obtenir un paramètre GET sécurisé
function getParam($key, $default = null)
{
    return isset($_GET[$key]) ? clean($_GET[$key]) : $default;
}

// Obtenir un paramètre POST sécurisé
function postParam($key, $default = null)
{
    return isset($_POST[$key]) ? clean($_POST[$key]) : $default;
}

?>