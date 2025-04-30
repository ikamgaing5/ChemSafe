<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require __DIR__ . '/../vendor/autoload.php';

    // require __DIR__.'/../core/connexion.php';
    require __DIR__.'/../models/user.php';
    require __DIR__.'/../models/package.php';
    require __DIR__.'/../models/historique_acces.php';
    require __DIR__.'/../models/atelier.php'; 
    // require __DIR__.'/../models/tokens.php';
    // $conn = getConnection();
    require_once __DIR__. '/../models/connexion.php';
    $conn = Database::getInstance()->getConnection();

    class UserControllers {
        private $conn;
        private $user;
        private $historique;
        private $package;

        public function __construct($conn) {
            $this->conn = $conn;
            $this->user = new User($this->conn);
            $this->historique = new historique_acces();
            $this->package = new Package();
        }

            public function changePassword($params){
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    # code...
                }else {
                    $token = $params['token'];
                    require_once __DIR__. '/../views/user/changepassword.php';
                }
            }

            public function dashboard() {
                require __DIR__. '/../views/dashboard copy.php';
            }

            public function logout(){
                unset($_SESSION['log']);
                $_SESSION['deconnect'] = true;
                Route::redirect('/');
            }

            public function home(){
                require_once __DIR__.'/../views/home.php';
            }

            public function CreateUser(){
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $nom = htmlspecialchars($_POST['nom']);
                    $prenom = 0;
                    $mail = 0;
                    $password = htmlspecialchars($_POST['password']);
                    // $password = password_hash($password , PASSWORD_BCRYPT);
                    $role = htmlspecialchars($_POST['role']);
                    $supp = "false";
                    // Le fichier upload avec succès
                    $insert = $this->user->Insert($this->conn,$nom,$prenom,$mail,$password,$role,$supp);
                    if ($insert == 0) {
                        // email déjà en bd
                        $_SESSION['insert'] = [];
                        $_SESSION['insert']['type'] = 0;
                        $_SESSION['insert']['info'] = $_POST;
                        Route::redirect('/admin/new-user');
                    }elseif ($insert == -1) {
                        $_SESSION['insert'] = [];
                        $_SESSION['insert']['type'] = -1;
                        $_SESSION['insert']['info'] = $_POST;
                        Route::redirect('/admin/new-user');
                    }else {
                        //insertion réussi
                        $_SESSION['insert'] = [];
                        $_SESSION['insert']['type'] = 1;
                        $_SESSION['insert']['info'] = $_POST;
                        $token = bin2hex(random_bytes(32));
                        $url = "http://".$_ENV['URL_APP']."/reset-password.php?token=$token";
                        Token::create($this->conn,$mail,$token);
                        Route::redirect('/admin/new-user');
                    }     
                }else {
                    require_once __DIR__.'/../views/user/new-user.php';
                }
            }

            public function Logs(){
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $nom = htmlspecialchars($_POST['nom']);
                    $password = htmlspecialchars($_POST['password']);
                    if ($nom == '' || $password == "") {
                        $_SESSION['info'] = $_POST;
                        Route::redirect('/');
                    }
                    if ($this -> user -> loginWithUser($this->conn,$nom,$password)) {
                        $id = $this -> user -> getIDbynom($this->conn,$nom);
                        $infoUser = $this->user->getOne($this->conn,$id);
                        $_SESSION['role'] = $role = $this -> user -> getRole($this -> conn, $id);
                        // $this -> historique -> Insert($this->conn, $id);
                        $_SESSION['idusine'] = $infoUser['idusine'];
                        $_SESSION['log'] = [];
                        $_SESSION['log']['type'] = 'user';
                        $_SESSION['id'] = $id;
                        $_SESSION['log']['type'] = $infoUser['role'];
                        Route::redirect('/dashboard');
                    }else {
                        $_SESSION['login_failed'] = [];
                        $_SESSION['login_failed']['type'] = true;
                        $_SESSION['login_failed']['info'] = $_POST;
                        Route::redirect('/');
                    }
                }else {
                    // if (session_status() != PHP_SESSION_NONE) {
                    //     session_destroy();
                    // }
                    require_once __DIR__ . '/../views/index.php';
                }
            }
            
            public function updatePassword(){
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $mail = $this->package->filtrer($_POST['mail']);
                    $infouser = $this->user->getUserByMail($this->conn,$mail);
                    $nom = $infouser['nomuser'];
                    $token = bin2hex(random_bytes(32));
                    if ($this->package->sendResetMail($mail,$nom,$token)) {
                        Token::create($this->conn,$mail,$token);
                        $_SESSION['updateok'] = true;
                        Route::redirect('/update-password');
                    }else {
                        $_SESSION['updateok'] = false;
                        Route::redirect('/update-password');
                    }
                }else {
                    require_once __DIR__. '/../views/user/updatepassword.php';
                }
            }


    }