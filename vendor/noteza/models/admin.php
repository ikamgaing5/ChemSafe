<?php

    class Admin{


        public function ifMailExist($conn,$mail){
            $req = $conn -> prepare ("SELECT * FROM administrateur WHERE mailadmin= '$mail'");
            $req -> execute();
            return $req -> rowCount();
        }
        public function createAdmin($conn,$nom,$mail,$username,$password){

            if ($this->ifMailExist($conn,$mail) > 0) {
                return false;
            }else {
                $req = $conn -> prepare ("INSERT INTO administrateur(`nomadmin`,`mailadmin`;`usernameadmin,`passwordadmin) VALUES (:nom,:mail,:username,:password)");
                $req -> bindParam(':nom', $nom);
                $req -> bindParam(':mail', $mail);
                $req -> bindParam(':username', $username);
                $req -> bindParam(':password', $password);
                return true;
            }
    }

    public function getNameadmin($conn,$id){
        $req = $conn -> prepare ("SELECT `nomadmin` FROM adminiteur WHERE idadmin = ? ");
        $req -> execute ([$id]);
        return $req -> fetch();
    }
    public function ifMatriculeExist($conn,$matricule){
        $req = $conn -> prepare ("SELECT * FROM administrateur WHERE matriculeadmin= '$matricule'");
        $req -> execute();
        return $req -> rowCount();
    }
    public function ifEntreeExist($conn,$entree,$type){
        $req = $conn -> prepare ("SELECT * FROM administrateur WHERE '$type' = '$entree'");
        $req -> execute();
        return $req -> rowCount();
    }

    public function ifUsernameExist($conn,$username){
        $req = $conn -> prepare ("SELECT * FROM administrateur WHERE usernameadmin= '$username'");
        $req -> execute();
        return $req -> rowCount();
    }

    public function connexionUsername($conn,$username, $mdp){
        $req = $conn -> prepare ("SELECT * FROM administrateur WHERE usernameadmin= '$username' AND passwordadmin = '$mdp'");
        $req -> execute();
        return $req -> rowCount();
    }


    public function connexionMail($conn,$username, $mdp){
        $req = $conn -> prepare ("SELECT * FROM administrateur WHERE mailadmin= '$username' AND passwordadmin = '$mdp'");
        $req -> execute();
        return $req -> rowCount();
    }
    public function connexionMatricule($conn,$username, $mdp){
        $req = $conn -> prepare ("SELECT * FROM administrateur WHERE matriculeadmin= '$username' AND passwordadmin = '$mdp'");
        $req -> execute();
        return $req -> rowCount();
    }

    public function connexion ($conn,$entree, $mot_passe, $type){
      if ($this -> ifEntreeExist($conn,$entree,$type)) {
        $req = $conn -> prepare ("SELECT  * FROM administrateur WHERE '$type' = '$entree' AND passwordadmin = '$mot_passe'");
        $req->execute ();
        return $req -> fetch();
      }
      return 0;

    }
    public function AllAdministrateur($conn){
        $req = $conn -> query("SELECT * FROM administrateur");
        return $req -> fetchAll();
    }

}

