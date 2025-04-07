<?php

class Filere {

    public function iffiliereExist($conn,$nomfiliere,$codefiliere, $responsablefiliere, 
    $niveaufiliere, $descriptionfiliere, $etudiant_inscrit){
        $req = $conn-> prepare("SELECT * FROM filiere WHERE nomfiliere = :nomfiliere OR codefiliere = :codematiere 
        OR responsablefilere = :responsablefiliere OR niveaufiliere = :niveaufiliere OR descritionfiliere = :descriptionfiliere
         OR etudiant_incrit = :etudiant_incrit");
        $req -> bindParam(':nomfiliere', $nomfiliere);
        $req -> bindParam(':codefiliere', $codefiliere);
        $req -> bindParam(':responsablefiliere', $responsablefiliere);
        $req -> bindParam(':niveaufiliere', $niveaufiliere);
        $req -> bindParam(':descriptionfiliere', $descriptionfiliere);
        $req -> bindParam(':etudiant_inscritfiliere', $etudiant_inscrit);
        $req -> execute();
        return $req ->rowCount();
    }

    public function createfiliere($conn,$nomfiliere,$codefiliere,$responsablefiliere,$niveaufiliere,$descriptionfiliere, 
    $etudiant_inscrit){
        if ($this->iffiliereExist($conn,$nomfiliere,$codefiliere,)) {
            return false;
        }else {
            $req = $conn -> prepare ("INSERT INTO matiere(`nommatiere`,'codematiere',`nbrecreditmatiere') VALUES (:nom,:code,:nbrecredit)");
                $req -> bindParam(':nom',$nommatiere);
                $req -> bindParam(':mail', $codematiere);
                $req -> bindParam(':username', $nbrecreditmatiere);
                return true;
    }            
    }
}
?>