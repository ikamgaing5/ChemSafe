<?php
  require_once 'session.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->

  <link rel="stylesheet" href="css/bootstrap.min.css">

  <link rel="stylesheet" href="css/style1.css">



<body>  
<!-- Section: Design Block -->
<section class="background-radial-gradient overflow-hidden">
  <style>
    .background-radial-gradient {
      background-color: hsl(218, 41%, 15%);
      background-image: radial-gradient(650px circle at 0% 0%,
          hsl(218, 41%, 35%) 15%,
          hsl(218, 41%, 30%) 35%,
          hsl(218, 41%, 20%) 75%,
          hsl(218, 41%, 19%) 80%,
          transparent 100%),
        radial-gradient(1250px circle at 100% 100%,
          hsl(218, 41%, 45%) 15%,
          hsl(218, 41%, 30%) 35%,
          hsl(218, 41%, 20%) 75%,
          hsl(218, 41%, 19%) 80%,
          transparent 100%);
    }

    #radius-shape-1 {
      height: 220px;
      width: 220px;
      top: -60px;
      left: -130px;
      background: radial-gradient(#0000a0 ,#0000ff);
      overflow: hidden;
    }

    #radius-shape-2 {
      border-radius: 38% 62% 63% 37% / 70% 33% 67% 30%;
      bottom: -60px;
      right: -110px;
      width: 300px;
      height: 300px;
      background: radial-gradient(#0000a0 ,#0000ff);
      overflow: hidden;
    }

    .bg-glass {
        background-color: rgba(0, 0, 0, 0.2) !important;
      backdrop-filter: saturate(200%) blur(25px);
    }
  </style>

  <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
    <div class="row gx-lg-5 align-items-center mb-5">
      <div class="col-lg-6 mb-5 mb-lg-0" style="z-index:3">
        <h6 class="my-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
          Bienvenue sur notre plate-forme <br />
          <span style="color: hsl(218, 81%, 75%)">de gestion des notes des etudiants</span>
        </h6>
        <p class="mb-4 opacity-70" style="color: hsl(218, 81%, 85%)">
         Utiliser l'experience et l'interface ergonomique de <br> 
         Noteza pour gerer les notes l'application dispose <br> 
         de toutes les fonctionnalités requises pour gerer <br> 
         votre école.
        </p>
      </div>

      <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
        <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
        <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

        <div class="card bg-glass">
          <div class="card-body px-4 py-5 px-md-5">

          <!-- Debut du formulaire -->
            <form action="controllers/etu.php" method="POST" onsubmit="return validerFormulaire()">
          <div class="text-light" style="text-align: center;"><h1>Identifiez-vous</h1></div>
          <center>
            <?php if( isset($_SESSION['form_data'])) echo '<div style="color:red;"> Identifiant ou Mot de passe Incorrect </div> '?>
          </center>
           <div style="text-align: center;">
            <span id="erreur-aff" style="color: red;"></span></div>
              <!-- Champ de l'e-mail -->
              <div class="form-outline mb-4">
                <label class="form-label text-light" for="form3Example3">Adresse e-mail </label>
                <input type="text" class="form-control" autocomplete="off" placeholder="Entrez votre adresse mail" name="entree" id="email" value="<?= isset($_SESSION['form_data']['entree']) ? htmlspecialchars($_SESSION['form_data']['entree']) : '' ?>"/>
                <span id="erreur-mail" style="color: red; font-size: 13px;"></span>
              </div>

              <div class="form-outline mb-2">
                        <label id="lan" class="text-light">Mot de passe</label>
                        <input type="password" class="form-control" name="mdp" id="mdp" value="" placeholder="Entrez votre mot de passe" />
                        <span id="erreur-mdp" style="color: red;"></span><br>
                        <a href="" style="text-decoration:none;">Mot de passe oublié?</a>
                    </div>
                    


              <!-- Bouton d'inscription -->
              <center>
                <input type="submit" class="btn btn-primary btn-block mb-4 px-5" id="Connexion" value="Connexion" name="Connexion">
              </center>
              

            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

    <!-- <script src="../js/erreurlog.js"></script>
    <script src="../js/script.js"></script> -->
    <script>
        const inputField = document.getElementById('mdp');
        const divToHide = document.getElementById('form-input');

        inputField.addEventListener('input', function() {
            if (inputField.value) {
                divToHide.style.display = 'none';
            } else {
                divToHide.style.display = 'block';
            }
        });

        function validerFormulaire() {
    let email = document.getElementById('email').value;
    let mdp = document.getElementById('mdp').value;
    if (email === '' && mdp === '') {
        document.getElementById('erreur-aff').innerText = 'Veuillez remplir les champs.';
        return false;
    } else {
        document.getElementById('erreur-aff').innerText = '';
    }
    if (email === '') {
        document.getElementById('erreur-mail').innerText = 'Veuillez saisir votre email.';
        return false;
    } else {
        document.getElementById('erreur-mail').innerText = '';
    }
    function validateEmail(email) {
        const re = /\S+@\S+\.\S+/;
        return re.test(email);
    }

    if (!validateEmail(email)) {
        document.getElementById('erreur-mail').innerText = 'Veuillez saisir une adresse email valide.';
        return false;
    } else {
        document.getElementById('erreur-mail').innerText = '';
    }

    if (mdp === '') {
        document.getElementById('erreur-mdp').innerText = 'Veuillez saisir votre mot de passe.';
        return false;
    } else {
        document.getElementById('erreur-mdp').innerText = '';
    }

    return true;
}


  


    </script>
<script src="../js/erreurform.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<?php include ('layouts/footer.php') ?>
</html>
<?php unset($_SESSION['form_data']); ?>
