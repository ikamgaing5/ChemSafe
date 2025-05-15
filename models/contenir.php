<?php
class Contenir
{

    public function Insert($conn, $idprod, $idatelier)
    {
        $req = $conn->prepare("INSERT INTO contenir(idprod, idatelier) VALUES (:idprod, :idatelier)");
        $req->bindParam(':idprod', $idprod);
        $req->bindParam(':idatelier', $idatelier);
        return $req->execute();
    }


    public static function AllWorkshop($conn)
    {
        $req = $conn->prepare("SELECT DISTINCT id FROM contenir");
        $req->execute();
        return $req->rowCount();
    }

    public static function AllProductOfFactory($conn, $idusine)
    {
        $req = $conn->prepare("SELECT DISTINCT idprod FROM contenir c LEFT JOIN atelier a ON c.idatelier = a.idatelier LEFT JOIN usine u ON u.idusine = a.idusine WHERE a.idusine = :idusine");
        $req->bindParam(':idusine', $idusine);
        $req->execute();
        return $req->rowCount();
    }

    public static function SelectAll($conn)
    {
        $req = $conn->prepare("SELECT * FROM contenir");
        $req->execute();
        return $req->fetchAll();
    }

    public function SelectOne($conn, $idatelier)
    {
        $req = $conn->prepare("SELECT * FROM contenir WHERE idatelier = :idatelier");
        $req->bindParam(':idatelier', $idatelier);
        $req->execute();
        return $req->fetchAll();
    }

    public static function NbreProduitParAtelier($conn, $idatelier)
    {
        $req = $conn->prepare("SELECT * FROM contenir WHERE idatelier = :idatelier");
        $req->bindParam(':idatelier', $idatelier);
        $req->execute();
        return $req->rowCount();
    }

    public function NbresProduitFDS($conn, $idatelier, $idprod)
    {
        $req = $conn->prepare("SELECT * FROM contenir WHERE idatelier = :idatelier AND idprod = :idprod");
        $req->bindParam(':idatelier', $idatelier);
        $req->bindParam(':idprod', $idprod);
        $req->execute();
        return $req->rowCount();
    }


    public function getProduitByAtelier($conn, $idatelier)
    {
        $req = $conn->prepare("SELECT * FROM contenir WHERE idatelier = :idatelier");
        $req->bindParam(':idatelier', $idatelier);
        $req->execute();
        return $req->fetchAll();
    }

    public static function getNumberOfProductByWorkshop($conn, $idatelier)
    {
        $req = $conn->prepare("SELECT DISTINCT idprod FROM contenir WHERE idatelier = :idatelier");
        $req->bindParam(':idatelier', $idatelier);
        $req->execute();
        return $req->rowCount();
    }

    public function Delete($conn, $idprod)
    {
        $req = $conn->prepare("DELETE FROM contenir WHERE idprod = :idprod");
        $req->bindParam(':idprod', $idprod);
        return $req->execute();
    }


}