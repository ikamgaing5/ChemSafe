<?php
class Usine
{
    public static function create($conn, $nom)
    {
        $req = $conn->prepare("INSERT INTO usine (nom) VALUES (:nom)");
        $req->bindParam(':nom', $nom);
        return $req->execute();
    }


    public static function update($conn, $nom, $idusine)
    {
        $req = $conn->prepare("UPDATE usine SET nom = :nom WHERE idusine = :idusine");
        $req->bindParam(':nom', $nom);
        $req->bindParam(':idusine', $idusine);
        return $req->execute();
    }

    public static function delete($conn, $id)
    {
        $req = $conn->prepare("DELETE FROM usine WHERE idusine = :idusine");
        $req->bindParam(':idusine', $id);
        $req->execute();
    }

    public static function AllFactory($conn)
    {
        $req = $conn->prepare("SELECT * FROM usine");
        $req->execute();
        return $req->fetchAll();
    }

    public static function NbresUsine($conn)
    {
        $req = $conn->prepare("SELECT * FROM usine");
        $req->execute();
        return $req->rowCount();
    }

    public static function getNameById($conn, $id)
    {
        $req = $conn->prepare("SELECT nom FROM usine WHERE idusine = :idusine");
        $req->execute(["idusine" => $id]);
        $raw = $req->fetch();
        return $raw['nom'];
    }

    // public static function NumberOf
}