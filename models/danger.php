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

        public function getDangerStatsByAtelier($conn, $idatelier) {
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
        
        // Nouvelle méthode pour récupérer les produits par danger
        public function getProductsByDanger($conn, $idatelier) {
            // Requête SQL pour obtenir les produits par danger pour un atelier spécifique
            $sql = "SELECT d.iddanger, d.nomdanger, p.idprod, p.nomprod 
                    FROM Danger d
                    JOIN Possede po ON d.iddanger = po.iddanger
                    JOIN Produit p ON po.idprod = p.idprod
                    JOIN Contenir c ON p.idprod = c.idprod
                    WHERE c.idatelier = :idatelier
                    ORDER BY d.nomdanger, p.nomprod";
            
            $req = $conn->prepare($sql);
            $req->bindParam(':idatelier', $idatelier, PDO::PARAM_INT);
            $req->execute();
            
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }
        
    }