<?php

// require_once __DIR__. '/../core/connexion.php';

class User
{
    // private $conn;

    // public function __construct($conn)
    // {
    //     $this->conn = $conn;
    // }

    public function ifUserExist($conn, $mailuser)
    {
        $req = $conn->prepare("SELECT * FROM user WHERE mailuser = :mailuser ");
        $req->bindParam(':mailuser', $mailuser);
        $req->execute();
        return $req->rowCount();
    }

    public static function ifUseExist($conn, $nomuser)
    {
        $req = $conn->prepare("SELECT * FROM user WHERE nomuser = :nomuser ");
        $req->bindParam(':nomuser', $nomuser);
        $req->execute();
        return $req->rowCount();
    }


    public function Insert($conn, $idusine, $nomuser, $prenomuser, $mailuser, $mdp, $role, $supp)
    {

        if ($this->ifUseExist($conn, $nomuser) >= 1) {
            return 0;
        } else {
            $req = $conn->prepare("INSERT INTO user(idusine,nomuser,prenomuser,mailuser,role,mdp,supp) VALUES (:idusine,:nomuser,:prenomuser,:mailuser,:role,:mdp,:supp)");
            $req->bindParam(":idusine", $idusine);
            $req->bindParam(":nomuser", $nomuser);
            $req->bindParam(":prenomuser", $prenomuser);
            $req->bindParam(":mailuser", $mailuser);
            $req->bindParam(":mdp", $mdp);
            $req->bindParam(":role", $role);
            $req->bindParam(":supp", $supp);
            if ($req->execute()) {
                return 1; // insertion ok
            } else {
                return -1; // problème lors de l'insertion
            }

        }
    }


    public static function getUserByMail($conn, $mailuser)
    {
        $req = $conn->prepare("SELECT * FROM user WHERE mailuser = :mailuser");
        $req->bindParam(':mailuser', $mailuser);
        $req->execute();
        return $req->fetch();
    }


    public static function getUserById($conn, $iduser)
    {
        $req = $conn->prepare("SELECT * FROM user WHERE iduser = :iduser");
        $req->bindParam(':iduser', $iduser);
        $req->execute();
        return $req->fetch();
    }

    public static function login($conn, $mail, $password)
    {
        $req = $conn->prepare("SELECT * FROM user WHERE mailuser = :mail");
        $req->bindParam(':mail', $mail);
        $raw = $req->fetch();
        if ($raw && password_verify($password, $raw['password'])) {
            return true;
        } else {
            return false;
        }
    }

    public static function loginWithUser($conn, $nom, $mdp)
    {
        $req = $conn->prepare('SELECT * FROM user WHERE nomuser = :nomuser AND mdp = :mdp');
        $req->bindParam(':nomuser', $nom);
        $req->bindParam(':mdp', $mdp);
        $req->execute();
        return $req->rowCount();
    }



    public static function loginWithUsername($conn, $nom, $mdp)
    {
        $req = $conn->prepare('SELECT * FROM user WHERE nomuser = :nomuser');
        $req->bindParam(':nomuser', $nom);
        $req->execute();
        $raw = $req->fetch();
        if ($raw['mdp'] == $mdp) {
            return true;
        } else {
            return false;
        }
    }

    public static function getOne($conn, $id)
    {
        $req = $conn->prepare("SELECT * FROM user WHERE iduser = :iduser");
        $req->bindParam(':iduser', $id);
        $req->execute();
        return $req->fetch();
    }

    public static function getIDbynom($conn, $nom)
    {
        $req = $conn->prepare("SELECT * FROM user WHERE nomuser = :nomuser");
        $req->bindParam(':nomuser', $nom);
        $req->execute();
        $raw = $req->fetch();
        return $raw['iduser'];
    }

    public static function getIDbyMail($conn, $mail)
    {
        $req = $conn->prepare("SELECT id FROM user WHERE mailuser = :mail ");
        $req->bindParam(':mail', $mail);
        $req->execute();
        $raw = $req->fetch();
        return $raw['iduser'];
    }


    public static function getRole($conn, $id)
    {
        $req = $conn->prepare("SELECT role FROM user WHERE iduser = :id ");
        $req->bindParam(':id', $id);
        $req->execute();
        $raw = $req->fetch();
        return $raw['role'];
    }

    public static function getAllUserActive($conn)
    {
        $supp = false;
        $req = $conn->prepare("SELECT * FROM user WHERE supp = :supp");
        $req->bindParam(':supp', $supp);
        $req->execute();
        return $req->fetchAll();
    }


    public static function suppUser($conn, $iduser)
    {
        $supp = true;
        $active = false;
        $req = $conn->prepare("UPDATE user SET supp = :supp, active = :active WHERE iduser = :iduser");
        $req->bindParam(':supp', $supp);
        $req->bindParam(':active', $active);
        $req->bindParam(':iduser', $iduser);
        $req->execute();
        return true;
    }


    public static function getPrenomUser($conn, $iduser)
    {
        $req = $conn->prepare("SELECT * FROM user WHERE iduser = :iduser");
        $req->bindParam(':iduser', $iduser);
        $req->execute();
        $raw = $req->fetchAll();
        return $raw['prenomuser'];
    }


    public static function Exist($conn, $mail, $id)
    {
        $req = $conn->prepare("SELECT * FROM user mailuser = :mailuser AND iduser != :iduser");
        $req->bindParma(':mailuser', $mail);
        return $req->rowCount();
    }

    public function Update($conn, $iduser, $mailuser, $numuser, $nomuser, $prenomuser, $username, $mdp, $photo)
    {
        if ($this->Exist($conn, $mailuser, $iduser) >= 1) {
            return -1; // déjà en bd
        } else {
            $mdp = password_hash($mdp, PASSWORD_BCRYPT);
            $req = $conn->prepare("UPDATE user SET nomuser = :nom, prenomuser = :prenom, mailuser = :mail, numuser = :num mdp = :mdp photo = :photo WHERE iduser = :id");
            $req->execute(array(
                'nom' => $nomuser,
                'prenom' => $prenomuser,
                'mail' => $mailuser,
                'num' => $numuser,
                'mdp' => $mdp,
                'photo' => $photo,
                'id' => $iduser
            ));
            if ($req->execute()) {
                return 1; // modification ok
            } else {
                return 0; // Problème de modification
            }
        }
    }

    public static function nbreUser($conn)
    {
        $supp = false;
        $req = $conn->prepare("SELECT * FROM user WHERE supp = :supp");
        $req->bindParam(':supp', $supp);
        $req->execute();
        return $req->rowCount();
    }

}

