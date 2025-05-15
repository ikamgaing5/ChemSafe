<?php
// namespace Models;

class Suppression
{


    public function ifAtelierExist($conn, $idatelier)
    {
        $req = $conn->prepare("SELECT * FROM historique_supp WHERE idatelier = :idatelier");
        $req->bindParam(':idatelier', $idatelier);
        $req->execute();
        return $req->fetchAll();
    }


    public function ifUserExist($conn, $iduser)
    {
        $req = $conn->prepare("SELECT * FROM user WHERE iduser = :iduser");
        $req->bindParam(':iduser', $iduser);
        $req->execute();
        return $req->fetchAll();
    }

    public function ifProduitExist($conn, $idprod)
    {
        $req = $conn->prepare("SELECT * FROM produit WHERE idprod = :idprod");
        $req->bindParam(':idprod', $idprod);
        $req->execute();
        return $req->fetchAll();
    }


    public function AddAtelier($conn, $idatelier)
    {
        if ($this->ifAtelierExist($conn, $idatelier)) {
            return false;
        } else {
            $req = $conn->prepare("INSERT INTO historique_supp(idatelier, date) VALUES(:idatelier, NOW())");
            $req->bindParam(':idatelier', $idatelier);
            return true;
        }
    }


    public function AddUser($conn, $iduser)
    {
        if ($this->ifUserExist($conn, $iduser)) {
            return false;
        } else {
            $req = $conn->prepare("INSERT INTO historique_supp(iduser, date) VALUES(:iduser, NOW())");
            $req->bindParam(':iduser', $iduser);
            return true;
        }
    }

    public function AddProduit($conn, $idproduit)
    {
        if ($this->ifproduitExist($conn, $idproduit)) {
            return false;
        } else {
            $req = $conn->prepare("INSERT INTO historique_supp(idprod, date) VALUES(:idprod, NOW())");
            $req->bindParam(':idprod', $idproduit);
            return true;
        }
    }


}