<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-90680653-2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-90680653-2');
    </script>
    
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <!-- <meta name="twitter:site" content="@bootstrapdash">
    <meta name="twitter:creator" content="@bootstrapdash">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Azia">
    <meta name="twitter:description" content="Responsive Bootstrap 4 Dashboard Template"> -->
    <meta name="twitter:image" content="https://www.bootstrapdash.com/azia/img/azia-social.png"> 

    <!-- Facebook -->
     <meta property="og:url" content="https://www.bootstrapdash.com/azia">
    <meta property="og:image" content="https://www.bootstrapdash.com/azia/img/azia-social.png">
    <meta property="og:image:secure_url" content="https://www.bootstrapdash.com/azia/img/azia-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600"> 

    <!-- Meta -->


    <!-- vendor css -->
    <link href="../lib/fontawesome-free/css/all.min.css" rel="stylesheet">


    <!-- azia CSS -->
    <link rel="stylesheet" href="../css/azia.css">

  </head>
  <body class="az-body">

    <div class="az-signin-wrapper">
      <div class="az-card-signin">
        <h2 class="az-logo">az<span>i</span>a</h2>
        <div class="az-signin-header">
          <h2>Ravi de vous revoir !</h2>
          <h5>Connectez-vous pour continuer</h5>

          <form action="index.html">
            <div class="form-group">
              <label>Email</label>
              <span id="messageMail" style="color:red; display:none;">Veuillez saisir une adresse mail valide</span>
              <input type="text" class="form-control" id="email" placeholder="Entrez votre adresse email">
            </div><!-- form-group -->
            <div class="form-group">
              <label>Mot de passe</label>
              <span id="messagePassword" style="color:red; display:none;"></span>
              <input type="password" id="password" class="form-control" placeholder="Entrez votre mot de passe" value="">
            </div><!-- form-group -->

            <button class="btn btn-az-primary btn-block" id="submitBtn" disabled>Se connecter</button>
          </form>
        </div><!-- az-signin-header -->
        <div class="az-signin-footer">
            
          <p><a href="">Forgot password?</a></p>
        </div><!-- az-signin-footer -->
      </div><!-- az-card-signin -->
    </div><!-- az-signin-wrapper -->

    <script src="../lib/jquery/jquery.min.js"></script>
    <script src="../lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/ionicons/ionicons.js"></script>
    <script src="../js/jquery.cookie.js" type="text/javascript"></script>
    <script src="../js/jquery.cookie.js" type="text/javascript"></script>

    <script src="../js/azia.js"></script>
    <script>
      $(function(){
        'use strict'

      });

      let password = document.getElementById('password');
let emailInput = document.getElementById('email');
let messageMail = document.getElementById('messageMail');
let messagePassword = document.getElementById('messagePassword');
let submitBtn = document.getElementById('submitBtn');

let temoinPassword = false;
let temoinMail = false;

function checkValidation() {
    // Activation / désactivation du bouton submit
    submitBtn.disabled = !(temoinMail && temoinPassword);

    // Gestion de l'affichage des messages d'erreur
    messageMail.style.display = temoinMail ? "none" : "block";
}

password.addEventListener("input", function () {
    let passwordValue = password.value;

    if (passwordValue === "") {
        messagePassword.textContent = "Le mot de passe ne peut pas être vide";
        messagePassword.style.display = "block";
        temoinPassword = false;
    } else if (passwordValue.length < 8) {
        messagePassword.textContent = "Au moins 8 caractères";
        messagePassword.style.display = "block";
        temoinPassword = false;
    } else {
        messagePassword.style.display = "none";
        temoinPassword = true;
    }

    checkValidation();
});

emailInput.addEventListener("input", function () {
    let emailValue = emailInput.value;
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    temoinMail = emailRegex.test(emailValue);
    checkValidation();
});



    </script>
  </body>
</html>
