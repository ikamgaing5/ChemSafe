<?php
class matiere {

    public function ifMatiereExist($conn,$nomMatiere,$codematiere){
        $req = $conn-> prepare("SELECT * FROM matiere WHERE nommatiere = :nommatiere OR codematiere = :codematiere");
        $req -> bindParam(':nommatiere', $nomMatiere);
        $req -> bindParam(':codematiere', $codematiere);
        $req -> execute();
        return $req ->rowCount();
    }

    public function creatematiere($conn,$nommatiere,$nbrecreditmatiere,$codematiere): bool{
        if ($this->ifMatiereExist($conn,$nommatiere,$codematiere)) {
            return false;
        }else {
            $req = $conn -> prepare ("INSERT INTO matiere(`nommatiere`,'codematiere',`nbrecreditmatiere') VALUES (:nom,:code,:nbrecredit)");
                $req -> bindParam(':nom',$nommatiere);
                $req -> bindParam(':mail', $codematiere);
                $req -> bindParam(':username', $nbrecreditmatiere);
                return true;
        }
    }
    public function getNamematiere($conn,$id){
        $req = $conn -> prepare ("SELECT `nommatiere` FROM matiere WHERE idmatiere = ? ");
        $req -> execute ([$id]);
        return $req -> fetch();
    }
    
    public function getcodematiere($conn,$id){
        $req = $conn -> prepare ("SELECT `codematiere` FROM matiere WHERE code = ? ");
        $req -> execute ([$id]);
        return $req -> fetch();
    }
    public function getnbrecreditmatiere($conn,$id){
        $req = $conn -> prepare ("SELECT `nbrecreditmatiere` FROM matiere WHERE nbrecrdit = ? ");
        $req -> execute ([$id]);
        return $req -> fetch();
    }
    public function updatematiere($conn,$nomMatiere,$codematiere,$nbrecreditmatiere) {
        if ($this->ifMatiereExist($conn,$nomMatiere,$codematiere)) {
            return false;
        }else {
            
        }
    }
    public function delete($conn,$id) {
        $req = $conn -> prepare("SELECT * FROM enseigne WHERE idmatiere = :idmatiere");
        $req -> bindParam(":idmatiere", $id);
           if ($req -> rowCount() == 0) {
            $reqs = $conn -> prepare('DELETE FROM matiere WHERE idmatiere = :id');
            $reqs -> bindParam(':id',$id);
            $reqs -> execute();
            return true;
           } else {
            return false;
    }
    }
}
?>