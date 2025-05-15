<?php

require __DIR__ . '/../vendor/autoload.php';

class Database
{
    private static $instance = null;
    private $conn;

    private $host;
    private $port;
    private $dbname;
    private $username;
    private $password;

    // Constructeur pour initialiser les valeurs
    private function __construct()
    {
        // Charger les variables d'environnement
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        // Assigner les valeurs des variables d'environnement
        $this->host = $_ENV['DB_HOST'];
        $this->port = $_ENV['DB_PORT'];
        $this->dbname = $_ENV['DB_NAME'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];

        // Connexion à la base de données
        $this->connect();
    }

    // Méthode pour établir la connexion à la base de données
    private function connect()
    {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    // Méthode statique pour obtenir l'instance unique de la classe Database
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    // Méthode pour obtenir la connexion
    public function getConnection()
    {
        return $this->conn;
    }
}

// Utilisation
$db = Database::getInstance();
$conn = $db->getConnection();
