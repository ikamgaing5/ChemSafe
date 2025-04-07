<?php   
    class Danger{

        public static function all($conn){
            $req = $conn->prepare("SELECT* FROM danger");
            $req->execute();
            return $req->fetchAll();
        }
        public static function getById($conn,$id){
            $req = $conn->prepare("SELECT * FROM danger WHERE iddanger = :iddanger");
            $req->bindParam(':iddanger', $id);
            $req->execute();
            return $req->fetch();
        }

        public static function getDangersByProduitId($conn, $idProduit) {
            $sql = "
                SELECT d.iddanger, d.nomdanger
                FROM danger d
                JOIN possede p ON p.iddanger = d.iddanger
                WHERE p.idprod = :idprod
            ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':idprod', $idProduit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function getNumberOfdangerofproductByWorkshop($conn,$idatelier){
            $query = "
                SELECT d.nomdanger, COUNT(p.idprod) AS count
                FROM danger d
                JOIN possede ps ON ps.iddanger = d.iddanger
                JOIN produit p ON p.idprod = ps.idprod
                JOIN contenir c ON c.idprod = p.idprod
                WHERE c.idatelier = :atelier_id
                GROUP BY d.nomdanger
            ";
            $req = $conn->prepare($query);
            $req->execute(['atelier_id' => $idatelier]);
            $data = $req->fetchAll(PDO::FETCH_ASSOC);

            // Préparer les données pour JavaScript
            $labels = [];
            $values = [];

            foreach ($data as $row) {
                $labels[] = $row['nomdanger'];
                $values[] = $row['count'];
            }

            // Encodage en JSON pour l'envoyer au script JavaScript
            return json_encode(['labels' => $labels, 'values' => $values]);

        }
        
    }