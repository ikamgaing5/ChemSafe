<?php

    // insertion du fichier contenant la classe Etudiant
    require_once '../models/etu.php';

    // insertion du fichier de connexion à la base de données
    require_once '../connexion.php';

    require_once '../session.php';

    $etu = new Etudiant();

    // Gestion de la connexion
    if (isset($_POST["Connexion"])) {
       
        function estEmailValide($entree) {
            return filter_var($entree, FILTER_VALIDATE_EMAIL) !== false;
        }
    
        function commenceParArobase($chaine) {
            // Vérifie si la chaîne n'est pas vide et commence par '@'
            return !empty($chaine) && $chaine[0] === '@';
        }


        $entree = htmlspecialchars($_POST["entree"]);
        $mdp = htmlspecialchars($_POST["mdp"]);

        if (estEmailValide($entree)) {
           if ($etu -> connexionMail($conn,$entree,$mdp)) {
            header('location:../home.php');
           }else {
            $_SESSION['form_data'] = $_POST;
            header('location:../inde.php');
           }
        } 
        if (commenceParArobase($entree)) {
            if ($etu -> connexionUsername($conn,$entree,$mdp)) {
                header('location:../home.php');
               }
        }

        
        if (!estEmailValide($entree) && !commenceParArobase($entree)) {
            if ($etu -> connexionMatricule($conn,$entree,$mdp)) {
                header('location:../home.php');
               }
        }   
    }





