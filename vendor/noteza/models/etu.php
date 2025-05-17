<?php

    // namespace Models;
    class Etudiant {

        public function createEtu($conn,$nom,$prenom,$matricule,$mail,$num,$username,$password){

            if ($this->ifMailExist($conn,$mail) > 0) {
                return false;
            }else {
                $req = $conn -> prepare ("INSERT INTO etudiant(`idfiliere`,`nometudiant`,`prenometudiant`,`matriculeetudiant`;`mailetudiant`,`numetudiant`,`usernameetudiant`,`passwordetudiant`) VALUES (:nom,:prenom,:matricule,:mail,:num,:username,:password)");
                $req -> bindParam(':nom', $nom);
                $req -> bindParam(':prenom', $prenom);
                $req -> bindParam(':matricule', $matricule);
                $req -> bindParam(':mail', $mail);
                $req -> bindParam(':num', $num);
                $req -> bindParam(':username', $username);
                $req -> bindParam(':password', $password);
                return true;
            }

           
        }

        public function getNameEtu($conn,$id){
            $req = $conn -> prepare ("SELECT `nometudiant` FROM etudiant WHERE idetudiant = ? ");
            $req -> execute ([$id]);
            return $req -> fetch();
        }

        public function ifMatriculeExist($conn,$matricule){
            $req = $conn -> prepare ("SELECT * FROM etudiant WHERE matriculeetudiant= '$matricule'");
            $req -> execute();
            return $req -> rowCount();
        }

        public function ifMailExist($conn,$mail){
            $req = $conn -> prepare ("SELECT * FROM etudiant WHERE mailetudiant= '$mail'");
            $req -> execute();
            return $req -> rowCount();
        }

        
        public function ifEntreeExist($conn,$entree,$type){
            $req = $conn -> prepare ("SELECT * FROM etudiant WHERE '$type' = '$entree'");
            $req -> execute();
            return $req -> rowCount();
        }

        public function ifUsernameExist($conn,$username){
            $req = $conn -> prepare ("SELECT * FROM etudiant WHERE usernameetudiant= '$username'");
            $req -> execute();
            return $req -> rowCount();
        }

        public function connexionUsername($conn,$username, $mdp){
            $req = $conn -> prepare ("SELECT * FROM etudiant WHERE usernameetudiant= '$username' AND passwordetudiant = '$mdp'");
            $req -> execute();
            return $req -> rowCount();
        }


        public function connexionMail($conn,$username, $mdp){
            $req = $conn -> prepare ("SELECT * FROM etudiant WHERE mailetudiant= '$username' AND passwordetudiant = '$mdp'");
            $req -> execute();
            return $req -> rowCount();
        }


        public function connexionMatricule($conn,$username, $mdp){
            $req = $conn -> prepare ("SELECT * FROM etudiant WHERE matriculeetudiant= '$username' AND passwordetudiant = '$mdp'");
            $req -> execute();
            return $req -> rowCount();
        }

        public function connexion ($conn,$entree, $mot_passe, $type){
          if ($this -> ifEntreeExist($conn,$entree,$type)) {
            $req = $conn -> prepare ("SELECT  * FROM etudiant WHERE '$type' = '$entree' AND passwordetudiant = '$mot_passe'");
            $req->execute ();
            return $req -> fetch();
          }
          return 0;

        }
        public function AllEtudiants($conn){
            $req = $conn -> query("SELECT * FROM etudiant");
            return $req -> fetchAll();
        }
        
        public function update($conn, $nom, $prenom,$mail,$num,$password) {
           if ($this->ifMailExist($conn,$mail)) {
            return false;
           } else {
            $req = $conn->prepare('UPDATE etudiant SET nometudiant=:nometudiant, prenometudiant=:prenometudiant, mailetudiant=:mailetudiant, numetudiant=:numetudiant, passwordetudiant=:passwordetudiant');
            $req->bindParam(':nometudiant',$nom);
            $req->bindParam(':prenometudiant', $prenom);
            $req->bindParam(':mailetudiant', $mail);
            $req->bindParam(':numetudiant', $num);
            $req->bindParam(':passwordetudiant', $password);
            return true;
           }    
        }    
        
        public function delete($conn,$id) {
           $req = $conn -> prepare("SELECT * FROM note WHERE idetudiant = :idetudiant");
           $req -> bindParam(":idetudiant", $id);
           if ($req -> rowCount() == 0) {
            $reqs = $conn -> prepare('DELETE FROM etudiant WHERE idetudiant = :id');
            $reqs -> bindParam(':id',
             $id);
            $reqs -> execute();
            return true;
           } else {
            return false;
           }
           
        } 

}