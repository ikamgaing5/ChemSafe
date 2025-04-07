<?php
class Note {

    public function createNote($conn,$note,$notecredit,$idetudiant,$idadministrateur) {
        if($this->ifnoteExist($conn,$note,$notecredit,$idetudiant,$idadministrateur)) {
            return false;
        }else {
            $req = $conn -> prepare ("INSERT INTO note(`note`,'notecredit') VALUES (:note,:notecrdit)");
                $req -> bindParam(':note',$note);
                $req -> bindParam(':notecredit', $notecredit);
                return true;
    }
    }
}
?>