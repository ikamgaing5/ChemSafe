<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    require __DIR__ . '/../vendor/autoload.php';

    // namespace Models;
    class Package{

        public function filtrer($donnee) {
            $donnee = stripslashes($donnee); // Supprime les antislashs
            $donnee = htmlspecialchars($donnee, ENT_QUOTES, 'UTF-8'); // Convertit les caractères spéciaux en entités HTML
            $donnee = mb_strtoupper($donnee);
            return $donnee;
        }

        public function sendResetMail($email,$fullname,$token){
            try {
                $mail = new PHPMailer(true);
                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'babaaba237@gmail.com'; // Votre adresse Gmail
                $mail->Password = 'pzvs davr fibe hpqj'; // Le mot de passe généré
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                //Recipients
                $mail->setFrom('babaaba237@gmail.com', 'ChemSafe');

                $mail->addAddress($email, $fullname);     //Add a recipient
                $mail->addBCC('babaaba237@gmail.com', 'ChemSafe');
                // $mail->addAddress('anastasiya.dmitrieva.2002@bk.ru', 'Anastasya');
                $mail->addReplyTo('babaaba237@gmail.com', 'Information');

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = '=?UTF-8?B?' . base64_encode('Modification mot de passe.') . '?=';
                $message = "Bonjour $fullname,\n\nVous avez demandé une réinitialisation de votre mot de passe. Cliquez sur ce lien pour modifier votre mot de passe : {$_ENV['URL_APP']}/change-password/$token\n\nSi vous n'êtes pas à l'origine de cette demande, ignorez ce message.";
                
                $mail->Body = $message;
                // $mail->AltBody = "Bonjour $fullname,\n\nVous avez demandé une réinitialisation de votre mot de passe. Cliquez sur ce lien pour modifier votre mot de passe : {$_ENV['URL_APP']}/change-password/$token\n\nSi vous n'êtes pas à l'origine de cette demande, ignorez ce message.";
                $mail->send();
                $mail->smtpClose();
                return true;
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                error_log("Erreur PHPMailer : {$mail->ErrorInfo}");
                return false;
            }
        }

        public function genererUsername($prenom, $nom) {
            $prenom = strtolower(trim($prenom));
            $nom = strtolower(trim($nom));
            $prenom = preg_replace('/[^a-z]/', '', $prenom);
            $nom = preg_replace('/[^a-z]/', '', $nom);
            $nombre = rand(100, 999);
            return '@'.$prenom . '.' . $nom . $nombre;
        }

        public function deletefile($file){
            if (file_exists($file)) {
                unlink($file);
                return true;
            }else {
                return false;
            }
        }

        public function filtrerMail($mail){
           return trim(strtolower(htmlspecialchars($mail)));
        }

        public function photos($file) {
            $uploadDir = __DIR__ . '/../uploads/photo/';
            $imagePath = $uploadDir . basename($file);
            
            $allowedExtensions = ["jpg", "png", "jpeg", "gif"];
            $fileExtension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
        
            // Vérification de l'extension
            if (!in_array($fileExtension, $allowedExtensions)) {
                return -1; // Extension non autorisée
            }
        
            // Vérification de l'existence du fichier
            if (file_exists($imagePath)) {
                return -2; // Le fichier existe déjà
            }
        
            // Vérification de l'existence de l'input file
            if (!isset($_FILES["imageUpload"])) {
                return -4; // Aucun fichier uploadé
            }
        
            // Vérification de la taille
            if ($_FILES["imageUpload"]["size"] > 8388608) {
                return -3; // Fichier trop volumineux (>50MB  8388608)
            }
        
            return 1; // Succès de l'upload
        }

        public function filtrerMdp($donnee){
            return htmlspecialchars($donnee, ENT_QUOTES, 'UTF-8');
        }


        public function deleteFiles($files, $type){
            if ($type == "photo") {
                $path = __DIR__. '/../uploads/photo/';
            }else {
                $path = __DIR__. '/../uploads/pdf/';
            }
            $file = $path.$files;
            if (file_exists($file)) {
                return unlink($file);
            }

        }

        public function photoExits($file){
            $uploadDir = __DIR__ . '/../uploads/photo/';
            $imagePath = $uploadDir . basename($file);
            $return = false;
            if(file_exists($imagePath)){
                $return = true;
            }
            return $return;
        }


        public function fds($file) {
            $uploadDir = __DIR__ . '/../uploads/pdf/';
            $fdsPath = $uploadDir . basename($file);
            
            $allowedExtensions = ["pdf"];
            $fileExtension = strtolower(pathinfo($fdsPath, PATHINFO_EXTENSION));
        
            // Vérification de l'extension
            if (!in_array($fileExtension, $allowedExtensions)) {
                return -1; // Extension non autorisée
            }
        
            // Vérification de l'existence du fichier
            if (file_exists($fdsPath)) {
                return -2; // Le fichier existe déjà
            }
        
            // Vérification de l'existence de l'input file
            if (!isset($_FILES["pdfUpload"])) {
                return -5; // Aucun fichier uploadé
            }
        
        
            return 1; // Succès de l'upload
        }

        

        public function message($message,$type){ 
            if ($type == "success") {
                $color = "success";
                $alert = "Succès";
                $icon = "<svg viewBox='0 0 24 24' width='24' height='24' stroke='currentColor' stroke-width='2' fill='none' stroke-linecap='round' stroke-linejoin='round' class='me-2'><polyline points='9 11 12 14 22 4'></polyline><path d='M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11'></path></svg>";
            }else {
                $color = "danger";
                $alert = "Echec";
                $icon = '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>';
            }

             $notif = "<div class='mx-1'>
                    <div class= 'alert alert-$color solid alert-dismissible fade show '>
                        $icon <strong>$alert !</strong> $message!
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='btn-close'>
                        </button>
                    </div> 
                </div>";
                return $notif;
        }
            
        
        public function afficheDate($dates){
            $date = new DateTime($dates); 
            $mois_fr = [
                1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
                5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
                9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
            ];

            
            $jour = (int)$date->format('j');
            $mois = (int)$date->format('n');
            $annee = $date->format('Y');

            $jour_formate = ($jour === 1) ? '1er' : $jour;

            return $formattedDate = "{$jour_formate} {$mois_fr[$mois]} {$annee}";
        }

        public function dateTimes($dateandtime){
            $date = new DateTime($dateandtime, new DateTimeZone('Africa/Douala')); 
            $mois_fr = [
                1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
                5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
                9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
            ];

            $jour = (int)$date->format('j');
            $mois = (int)$date->format('n');
            $annee = $date->format('Y');
            $heure = $date->format('H\hi'); 

            $jour_formate = ($jour === 1) ? '1er' : $jour;

            $formatted = "{$jour_formate} {$mois_fr[$mois]} {$annee} {$heure}";
            return $formatted;
        }


        
    }