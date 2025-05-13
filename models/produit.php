<?php

class Produit
{

    public function create($conn, $nom, $emballage, $poids, $nature, $utilisation, $fabricant, $photo, $fds, $danger, $risque)
    {
        if ($this->Exist($conn, $nom) == 0) {
            $req = $conn->prepare("INSERT INTO produit(nomprod, type_emballage, poids, nature, utilisation, fabriquant, photo,fds, danger,risque) VALUES(:nom, :type_emballage, :poids, :nature, :utilisation, :fabricant, :photo, :fds, :danger, :risque)");
            $req->bindParam(':nom', $nom);
            $req->bindParam(':type_emballage', $emballage);
            $req->bindParam(':poids', $poids);
            $req->bindParam(':nature', $nature);
            $req->bindParam(':utilisation', $utilisation);
            $req->bindParam(':fabricant', $fabricant);
            $req->bindParam(':photo', $photo);
            $req->bindParam(':fds', $fds);
            $req->bindParam(':danger', $danger);
            $req->bindParam(':risque', $risque);
            if ($req->execute()) {
                return 1; // insertion ok
            } else {
                return 0; // echec insertion
            }
        } else {
            return -1; // produit déjà dans la base
        }

    }
    public function getProduitByWorkshop($conn)
    {
        $sql = "SELECT p.idprod,p.nomprod,p.type_emballage,p.poids,p.nature,p.utilisation, p.fabriquant, p.photo,p.fds, p.danger,p.risque, GROUP_CONCAT(a.nomatelier ORDER BY a.nomatelier SEPARATOR ', ') AS ateliers, COUNT(DISTINCT a.idatelier) AS nb_ateliers FROM produit p JOIN contenir c ON p.idprod = c.idprod JOIN atelier a ON a.idatelier = c.idatelier GROUP BY p.idprod";
        $req = $conn->prepare($sql);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Exist($conn, $nom)
    {
        $req = $conn->prepare("SELECT * FROM produit WHERE nomprod = :nom");
        $req->bindParam(':nom', $nom);
        $req->execute();
        return $req->rowCount();
    }

    public function photoExist($conn, $photo)
    {
        $req = $conn->prepare("SELECT * FROM produit WHERE photo = :photo");
        $req->bindParam(':photo', $photo);
        $req->execute();

        $result = [];
        $result['all'] = $req->fetchAll();
        $result['exists'] = count($result['all']) > 0;

        return $result;
    }

    public function getNameByPhoto($conn, $photo)
    {
        $req = $conn->prepare("SELECT * FROM produit WHERE photo = :photo");
        $req->bindParam(':photo', $photo);
        $req->execute();
        $raw = $req->fetch();
        return $raw['nomprod'];
    }

    public function getProduitsPagines($conn, $limit, $offset)
    {
        $sql = "SELECT p.idprod, p.nomprod, p.type_emballage, p.poids, p.nature, p.utilisation,
            p.fabriquant, p.photo, p.fds, p.danger, p.risque,
            GROUP_CONCAT(a.nomatelier ORDER BY a.nomatelier SEPARATOR ', ') AS ateliers,
            COUNT(DISTINCT a.idatelier) AS nb_ateliers
                FROM produit p
                JOIN contenir c ON p.idprod = c.idprod
                JOIN atelier a ON a.idatelier = c.idatelier
                GROUP BY p.idprod
                LIMIT :limit OFFSET :offset";

        $req = $conn->prepare($sql);
        $req->bindValue(':limit', $limit, PDO::PARAM_INT);
        $req->bindValue(':offset', $offset, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getProduitByWorkshops($conn, $limit = 20, $offset = 0)
    {
        $sql = "SELECT p.idprod, p.nomprod, p.type_emballage, p.poids, p.nature, p.utilisation,
                           p.fabriquant, p.photo, p.fds, p.danger, p.risque,
                           GROUP_CONCAT(DISTINCT a.nomatelier ORDER BY a.nomatelier SEPARATOR ', ') AS ateliers,
                           COUNT(DISTINCT a.idatelier) AS nb_ateliers
                    FROM produit p
                    INNER JOIN contenir c ON p.idprod = c.idprod
                    INNER JOIN atelier a ON a.idatelier = c.idatelier
                    WHERE a.active = 'true'
                    GROUP BY p.idprod, p.nomprod, p.type_emballage, p.poids, p.nature, p.utilisation,
                             p.fabriquant, p.photo, p.fds, p.danger, p.risque
                    LIMIT :limit OFFSET :offset";

        $req = $conn->prepare($sql);
        $req->bindValue(':limit', $limit, PDO::PARAM_INT);
        $req->bindValue(':offset', $offset, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }


    public function countProduits($conn)
    {
        $sql = "SELECT COUNT(*) FROM produit";
        return $conn->query($sql)->fetchColumn();
    }



    public function getNameByFDS($conn, $fds)
    {
        $req = $conn->prepare("SELECT * FROM produit WHERE fds = :fds");
        $req->bindParam(':fds', $fds);
        $req->execute();
        $raw = $req->fetch();
        return $raw['nomprod'];
    }

    public function getDangerStatsByAtelier($conn, $idatelier)
    {
        // Requête SQL pour obtenir le nombre de produits par danger pour un atelier spécifique
        $sql = "SELECT d.iddanger, d.nomdanger, COUNT(p.idprod) as count 
                    FROM Danger d
                    JOIN Possede po ON d.iddanger = po.iddanger
                    JOIN Produit p ON po.idprod = p.idprod
                    JOIN Contenir c ON p.idprod = c.idprod
                    WHERE c.idatelier = :idatelier
                    GROUP BY d.iddanger, d.nomdanger
                    ORDER BY count DESC";

        $req = $conn->prepare($sql);
        $req->bindParam(':idatelier', $idatelier, PDO::PARAM_INT);
        $req->execute();

        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    function getDangerData($conn)
    {
        try {

            // Requête pour obtenir le nombre de produits par danger
            $query = " SELECT  d.iddanger, d.nomdanger AS nom_danger, COUNT(p.idprod) AS total_produits FROM danger d LEFT JOIN  possede pos ON d.iddanger = pos.iddanger LEFT JOIN  produit p ON pos.idprod = p.idprod  GROUP BY  d.iddanger, d.nomdanger  ORDER BY total_produits DESC ";

            $req = $conn->prepare($query);
            $req->execute();

            // Récupérer les résultats
            $results = $req->fetchAll(PDO::FETCH_ASSOC);

            // Retourner les résultats au format JSON
            return json_encode($results);

        } catch (PDOException $e) {
            // En cas d'erreur, renvoyer un message d'erreur
            return json_encode([
                'error' => true,
                'message' => 'Erreur de base de données: ' . $e->getMessage()
            ]);
        }
    }

    public function getDangerDatas($conn, $idusine)
    {
        try {
            $query = "
                    SELECT 
                        d.iddanger, 
                        d.nomdanger AS nom_danger, 
                        COUNT(DISTINCT p.idprod) AS total_produits
                    FROM danger d
                    LEFT JOIN possede pos ON d.iddanger = pos.iddanger
                    LEFT JOIN produit p ON pos.idprod = p.idprod
                    LEFT JOIN contenir c ON p.idprod = c.idprod
                    LEFT JOIN atelier a ON c.idatelier = a.idatelier
                    WHERE a.idusine = :idusine
                    GROUP BY d.iddanger, d.nomdanger
                    ORDER BY total_produits DESC
                ";

            $req = $conn->prepare($query);
            $req->execute([':idusine' => $idusine]);

            $results = $req->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($results);

        } catch (PDOException $e) {
            return json_encode([
                'error' => true,
                'message' => 'Erreur de base de données: ' . $e->getMessage()
            ]);
        }
    }


    function getDangerProducts($conn, $iddanger)
    {
        if (empty($iddanger)) {
            return json_encode([
                'error' => true,
                'message' => 'ID de danger non spécifié'
            ]);
        }

        $iddanger = intval($iddanger);

        try {
            $query = " SELECT p.idprod, p.nom FROM  produit p JOIN possede pos ON p.idprod = pos.idprod WHERE  pos.iddanger = :iddanger ORDER BY p.nom ASC";

            $req = $conn->prepare($query);
            $req->bindParam(':iddanger', $iddanger, PDO::PARAM_INT);
            $req->execute();
            $results = $req->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($results);

        } catch (PDOException $e) {
            return json_encode([
                'error' => true,
                'message' => 'Erreur de base de données: ' . $e->getMessage()
            ]);
        }
    }

    public function AddFds($conn, $fds, $idprod)
    {
        $req = $conn->prepare("UPDATE produit SET fds = :fds WHERE idprod = :idprod");
        $req->bindParam(':fds', $fds);
        $req->bindParam(':idprod', $idprod);
        return $req->execute();
    }

    public function getIdProductByName($conn, $nom)
    {
        $req = $conn->prepare("SELECT * FROM produit WHERE nomprod = :nomprod");
        $req->bindParam(':nomprod', $nom);
        $req->execute();
        $raw = $req->fetch();
        return $raw['idprod'];
    }

    public function getNameById($conn, $id)
    {
        $req = $conn->prepare("SELECT * FROM produit WHERE idprod = :idprod");
        $req->bindParam(':idprod', $id);
        $req->execute();
        $raw = $req->fetch();
        return $raw['nomprod'];
    }


    public function IfExist($conn, $nom, $id)
    {
        $req = $conn->prepare("SELECT * FROM produit WHERE nomprod = :nom AND idprod != :id");
        $req->bindParam(':nom', $nom);
        $req->bindParam(':id', $id);
        $req->execute();
        return $req->rowCount();
    }


    public function AllProduct($conn, )
    {
        $req = $conn->prepare("SELECT * FROM produit");
        $req->execute();
        return $req->fetchAll();
    }

    public function OneProduct($conn, $id)
    {
        $req = $conn->prepare("SELECT * FROM produit WHERE idprod = :id");
        $req->bindParam(':id', $id);
        $req->execute();
        return $req->fetch();
    }


    public function Delete($conn, $id)
    {
        $req = $conn->prepare("DELETE FROM produit WHERE idprod = :id");
        $req->bindParam(':id', $id);
        return $req->execute();
    }


    public function ProduitFDS($conn)
    {
        $req = $conn->prepare("SELECT * FROM produit WHERE fds = null");
        $req->execute();
        return $req->fetchAll();
    }

    public function ProduitSansFDS($conn)
    {
        $req = $conn->prepare("SELECT * FROM produit WHERE fds = null");
        $req->execute();
        return $req->rowCount();
    }

    public function ifProduitSansFDS($conn, $idprod)
    {
        $vide = "";
        $req = $conn->prepare("SELECT * FROM produit WHERE (fds = :vide OR fds IS NULL)  AND idprod = :idprod");
        $req->bindParam(':idprod', $idprod);
        $req->bindParam(':vide', $vide);
        $req->execute();
        return $req->rowCount() > 0;
    }

    public function ifProduitsFDS($conn, $idprod)
    {
        $req = $conn->prepare("SELECT * FROM produit WHERE fds IS NOT NULL AND idprod = :idprod");
        $req->bindParam(':idprod', $idprod);
        $req->execute();
        return $req->rowCount();
    }

    public function Update($conn, $id, $nom, $emballage, $poids, $nature, $utilisation, $fabricant, $photo, $fds, $danger, $risque)
    {
        if ($this->IfExist($conn, $nom, $id) == 0) {
            $req = $conn->prepare("UPDATE produit SET nomprod = :nom, type_emballage = :type_emballage,poids = :poids, nature = :nature, utilisation = :utilisation, fabricant = :fabricant, photo = :photo, fds = :fds, danger = :danger, risque = :risque WHERE idprod = id");
            $req->bindParam(':id', $id);
            $req->bindParam(':nom', $nom);
            $req->bindParam(':type_emballage', $emballage);
            $req->bindParam(':poids', $poids);
            $req->bindParam(':nature', $nature);
            $req->bindParam(':utilisation', $utilisation);
            $req->bindParam(':fabricant', $fabricant);
            $req->bindParam(':photo', $photo);
            $req->bindParam(':fds', $fds);
            $req->bindParam(':danger', $danger);
            $req->bindParam(':risque', $risque);
            if ($req->execute()) {
                return 1; // Modification ok
            } else {
                return -1; // Problème de modification
            }
        } else {
            return 0; // Nom déjà en bd
        }
    }

    public function NbreProduits($conn)
    {
        $req = $conn->prepare("SELECT * FROM produit");
        $req->execute();
        return $req->rowCount();
    }


    public static function getProduitsNonAssocies($conn, $idAtelier)
    {
        $req = $conn->prepare("SELECT * FROM produit p WHERE p.idprod NOT IN (SELECT idprod FROM contenir WHERE idatelier = :idatelier) ORDER BY nomprod");
        $req->bindParam(':idatelier', $idAtelier, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }


    public function ProduitSansInfoFDS($conn)
    {
        $req = $conn->prepare("SELECT p.idprod FROM produit p WHERE idprod NOT IN (SELECT idprod FROM infofds)");
        $req->execute();
        return $req->fetchAll();
    }


}



?>