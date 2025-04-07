

<?php
function getConnection() {
    $dsn = 'mysql:host=localhost;dbname=chemsafe;charset=utf8';
    $username = 'root';
    $password = '';

    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
}
