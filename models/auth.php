<?php
class Auth
{
    private $id;
    private $idusine;
    private $nom;
    private $prenom;
    private $mail;
    private $role;

    public function __construct($id, $idusine, $nom, $prenom, $mail, $role)
    {
        $this->id = $id;
        $this->idusine = $idusine;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->mail = $mail;
        $this->role = $role;
    }

    public static function fromArray(array $data): Auth
    {
        return new self(
            $data['iduser'],
            $data['idusine'],
            $data['nomuser'],
            $data['prenomuser'],
            $data['mailuser'],
            $data['role']
        );
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }


    // Méthode statique qui retourne l'utilisateur connecté
    public static function user()
    {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        return null;
    }

    // Méthode à appeler pour stocker l'utilisateur (par exemple après connexion)
    public static function login(Auth $user)
    {
        $_SESSION['user'] = $user;
    }




}