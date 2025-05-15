<?php
require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
class Token
{


    public static function create($conn, $email, $token)
    {
        // Enregistre le token
        $req = $conn->prepare("INSERT INTO password_resets (email, token) VALUES (:email, :token)");
        $req->bindParam(':email', $email);
        $req->bindParam(':token', $token);
        return $req->execute();
    }

    public static function select($conn, $email)
    {
        $req = $conn->prepare("SELECT * FROM users WHERE email = :mail");
        $req->bindParam(':mail', $email);
        $req->execute();
        return $req->fetch();
    }

    public static function verif($conn, $token)
    {
        $req = $conn->prepare("SELECT * FROM password_resets WHERE token = ?");
        $req->execute([$token]);
        return $req->fetch();
    }
}