<?php
class historique_acces
{


    public static function Insert($conn, $iduser, $action)
    {
        date_default_timezone_set('Africa/Douala');
        $created_at = date("Y-m-d");
        $time = date("H:i:s");
        $req = $conn->prepare("INSERT INTO historique_acces(iduser,created_at,time,action) VALUES(:iduser,:created_at,:time,:action)");
        $req->bindParam(':iduser', $iduser);
        $req->bindParam(':created_at', $created_at);
        $req->bindParam(':action', $action);
        $req->bindParam(':time', $time);
        return $req->execute();
    }

    public static function SelectAll($conn)
    {
        $req = $conn->prepare("SELECT * FROM historique_acces");
        $req->execute();
        return $req->fetchAll();
    }

    public static function GetID($conn)
    {
        $req = $conn->prepare("SELECT DISTINCT iduser FROM historique_acces");
        $req->execute();
        return $req->fetchAll();
    }

    public static function SelectOne($conn, $iduser)
    {
        $req = $conn->prepare("SELECT * FROM historique_acces WHERE iduser = :iduser");
        $req->bindParam('iduser', $iduser);
        $req->execute();
        return $req->fetchAll();
    }
}