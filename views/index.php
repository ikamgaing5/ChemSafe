<?php

	require_once __DIR__ . '/../utilities/session.php';


	$alerterror = "";
    

			$alerterror = '<div class="mx-3 alert alert-secondary alert-dismissible fade show">
						<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
						<strong>Une erreur est survenue!</strong> nom d\'utilisateur ou mot de passe incorrect.
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
						</button>
			</div> ';

			if(isset($_SESSION['info'])){
				$alerterror = '<div class="mx-3 alert alert-secondary alert-dismissible fade show">
						<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
						<strong>Une erreur est survenue!</strong> nom d\'utilisateur ou mot de passe incorrect.
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
						</button>
			</div> ';
			}


?>




<!DOCTYPE html>
<html lang="fr" class="h-100">
 
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	
	<title>ChemSafe</title>


	<!-- <link rel="shortcut icon" type="image/png" href="images/favicon.png" > -->
	<link href="/../vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
    <link href="/../css/style.css" rel="stylesheet">

</head>

<body class="body  h-100" >
	<div class="authincation d-flex flex-column flex-lg-row flex-column-fluid">
		<div class="login-aside text-center  d-flex flex-column flex-row-auto" >
			<div class="d-flex flex-column-auto flex-column pt-lg-40 pt-5">
				<div class="text-center mb-lg-4 mb-2 pt-5 logo">
					<!-- <img src="images/logo-whit.png" alt=""> -->
				</div>
				<h3 class="mb-2 text-white">Bon retour!</h3>
				<p class="mb-4">Utilisez l'experience et l'interface ergonomique de <br> pour gerer les produits chimiques! l'application dispose de toutes les fonctionnalités requises pour gerer votre usine! </br><b>matricule=admin , password = admin99</b></p>
			</div>
			<!-- <div class="aside-image position-relative" style="background-image:url(images/background/pic-2.png);">
				<img class="img1 move-1" src="images/background/pic3.png" alt="">
				<img class="img2 move-2" src="images/background/pic4.png" alt="">
				<img class="img3 move-3" src="images/background/pic5.png" alt="">
				
			</div> -->
		</div>
		<div class="container flex-row-fluid d-flex flex-column my-3 justify-content-center position-relative overflow-hidden p-7 mx-auto" style="background-color: write;">
			<div class="d-flex justify-content-center h-100 align-items-center">
				<div class="shadow-lg authincation-content style-2" style="background-color: #fff">
					<div class="row no-gutters">
						<div class="col-xl-12 tab-content">
							<div id="sign-up" class="auth-form tab-pane fade show active  form-validation">
								<form action="/" method="POST">
									<div class="text-center mb-4">

									<?php if (isset($_SESSION['login_failed'])) {echo $alerterror;}	?>

                                 <?php	
								 
								
								if(isset($_SESSION['deconnect'])){
									
									echo '<div class="alert alert-success alert-dismissible fade show">
									<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>	
									<strong>Succès!</strong> Vous etes maintenant deconnecté! Veuillez vous reconnecter pour continuer à  utiliser ChemSafe
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
									</button>
								</div>';
								}
								?>

										<h3 class="text-center mb-2 text-black">Se connecter</h3>
										<span>Connecter vous pour acceder à l'application </span>
									</div>
								
									
									<div class="mb-3 mx-3">
										<label style="font-weight: 700;" for="exampleFormControlInput1" class="form-label mb-2 fs-13 label-color font-w500">Nom d'utilisateur</label>
									  <input type="text" class="form-control" name="nom" id="exampleFormControlInput1" value="<?php if(isset($_SESSION['login_failed'])){ echo $_SESSION['login_failed']['info']['nom'];} if(isset($_SESSION['info'])){echo $_SESSION['info']['nom'];} ?>">
									  
									</div>
									<div class="mb-3 mx-3">
										<label style="font-weight: 700;" for="exampleFormControlInput1" class="form-label mb-2 fs-13 label-color font-w500">Mot de passe</label>
									  <input type="password" class="form-control" name="password" id="exampleFormControlInput2" value="">
									</div>
									
									<div class="mx-3">
										<input type="submit" name="seconnecter" value="Se connecter"  class="btn btn-block btn-primary " />
									</div>
									
								</form>
								<div class="new-account mt-3 text-center">
									<p class="font-w500"><a class="text-primary" href="/update-password" data-toggle="tab">Mot de passe oublié ?</a></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		function OnSubmit(){

		}
	</script>

    
    
    <script src="/../vendor/global/global.min.js"></script>
    <script src="/../js/custom.min.js"></script>
    <script src="/../js/dlabnav-init.js"></script>
	
</body>

<?php 
	if (session_status() != PHP_SESSION_NONE) {
		session_destroy();
	}
