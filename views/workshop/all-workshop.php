<?php 
	require_once __DIR__. '/../../utilities/session.php';
        $current_page = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
		$conn = Database::getInstance()->getConnection();
		
	
			
			if (strpos($current_page, 'workshop/all-workshop') === 0) {
				$nom = Usine::getNameById($conn,$idusine);
				$message = "Liste des Ateliers de l'$nom.";
			}	
			if ($current_page == 'workshop/all-workshop') {
				$message = 'Liste des Ateliers de toutes les Usines.';
			}
		




        // require_once __DIR__. '/../../core/connexion.php';
        require_once __DIR__. '/../../models/atelier.php';
        require_once __DIR__. '/../../models/package.php';
        require_once __DIR__. '/../../models/produit.php';
        require_once __DIR__. '/../../models/user.php';
        require_once __DIR__. '/../../models/contenir.php';
		require_once __DIR__. '/../../utilities/session.php';
		// require_once __DIR__. '/../../models/connexion.php';
		

        // $conn = getConnection();
        $atelier = new Atelier();
        $produit = new Produit();
        $user = new User($conn);
        $contenir = new Contenir();
		$package = new Package();
		// $idusine = $_GET['idusine'];

	    // if($_SESSION['log']['type'] == 'admin'){ 	
		// 	$allAtelier =  $atelier -> AllAtelier($conn,$idusine);
		// }



?>

<!DOCTYPE html>
<html lang="fr" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

		<link href="/../../vendor/wow-master/css/libs/animate.css" rel="stylesheet">
        <link href="/../../vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/../../vendor/bootstrap-select-country/css/bootstrap-select-country.min.css">
        <link rel="stylesheet" href="/../../vendor/jquery-nice-select/css/nice-select.css">
        <link href="/../../vendor/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=experiment" />
        
        <link href="/../../vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
        
        <link rel="stylesheet" href="/vendor/swiper/css/swiper-bundle.min.css">
        
        
        <link href="/../css/style.css" rel="stylesheet">
		<link href="/../css/all-workshop.css" rel="stylesheet">
		<link rel="stylesheet" href="/css/all.css">
		<script src="/js/all.js"></script>
	
</head>
<body>

    
	<div id="preloader">
	  <div class="loader">
		<div class="dots">
			  <div class="dot mainDot"></div>
			  <div class="dot"></div>
			  <div class="dot"></div>
			  <div class="dot"></div>
			  <div class="dot"></div>
		</div>
			
		</div>
	</div>
    
    <div id="main-wrapper">
	
        
	<?php require_once __DIR__. '/../../layouts/navbar.php' ?>
            
	<?php require_once __DIR__. '/../../layouts/dlabnav.php'; ?>

		
        <div class="content-body">
			<div class="container-fluid">
			<?php if($_SESSION['log']['type'] == 'admin' || $_SESSION['log']['type'] == 'superadmin' ){  
				require __DIR__. '/new-workshop.php';
			} ?>
				<!-- Row -->
				<div class="row">
					<?php 
						// echo $message_succes;
						if (isset($_SESSION['error']['inbd']) && $_SESSION['error']['inbd'] == true) { 
							$message = "L'atelier <strong> ".$_SESSION['error']['data']['nom']."</strong>  existe déjà";
							$type = "danger";
							echo $package -> message($message,$type);
							unset($_SESSION['error']);
						
						}elseif (isset($_SESSION['error']['success']) && $_SESSION['error']['success'] == true) {
							$message = "L'atelier ".$_SESSION['error']['data']['oldvalue']." a été remplacé par  <strong>".$_SESSION['error']['data']['nom']."</strong> ";
							echo $package->message($message, "success");
							unset($_SESSION['error']);
						}elseif (isset($_SESSION['error']['errorInsert']) && $_SESSION['error']['errorInsert'] == true) {
							$message = "L'atelier ".$_SESSION['error']['data']['oldvalue']." a été remplacé par  <strong>".$_SESSION['error']['data']['nom']."</strong> ";
							echo $package->message($message, "success");
							unset($_SESSION['error']);
						}elseif (isset($_SESSION['delete']['errorDelete'])) {
							$message = "L'atelier <strong>".$_SESSION['delete']['data']['nom']."</strong> contient au moins un produit et ne peut être suprrimé ";
							echo $package->message($message, "danger");
							unset($_SESSION['delete']);
						}elseif (isset($_SESSION['delete']['deleteok'])) {
							$message = "L'atelier <strong>".$_SESSION['delete']['data']['nom']."</strong> a bien été suprrimé ";
							echo $package->message($message, "success");
							unset($_SESSION['delete']);
						}elseif (isset($_SESSION['insertok'] )) {
							$message = "L'atelier <strong>".mb_strtoupper($_SESSION['insertok']['data']['nom'])."</strong> a été bien ajouté ";
							echo $package->message($message, "success");
							unset($_SESSION['insertok']);
						}
						
					?>
					<div class="col-xl-12">
						<div class="shadow-lg page-title flex-wrap d-none d-xl-block"> <!-- Ajout des classes de visibilité -->
							<div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
								<div>
									<u><a class="text-primary fw-bold fs-5" href="/dashboard">Tableau de bord</a></u>
									<span class="fs-4"><i class="bi bi-caret-right-fill"></i></span>
									<u><a class="text-primary fw-bold fs-5" href="/factory/all-factory" >Nos Usines</a></u>

									<span class="fs-4"><i class="bi bi-caret-right-fill"></i></span>
									<span class="card-title fw-bold fs-5">Nos Ateliers</span>
								</div>
							</div>
						</div>

						<div class="shadow-lg page-title d-xl-none text-center py-2">
						
							<u><a href="/dashboard" class="text-primary fw-bold fs-5"><i class="bi bi-caret-right-fill"></i>
								Tableau de bord
							</a></u>
							<?php if ($_SESSION['log']['type'] === 'admin') { ?>
								<div class="fs-5">
									Nombre d'atelier : <strong class="card-title fw-bold fs-5"><?=$atelier->NbreAtelierByFactory($conn,$idusine)?></strong>
								</div>
							<?php }
								if ($_SESSION['log']['type'] === 'superadmin') { ?>
								<div class="fs-5">
									Nombre d'atelier : <strong class="card-title fw-bold fs-5"><?=$atelier->NbreAtelier($conn)?></strong>
								</div>
							<?php } ?>
						</div>
					</div>
					<?php 
						$allFactory = Usine::AllFactory($conn);
						foreach ($allFactory as $key) {
							$idusine = $key['idusine'];

							// Cas pour l'admin : on vérifie si c'est bien l'usine de l'admin
							if ($_SESSION['log']['type'] === 'admin' && $idusine != $_SESSION['idusine']) {
								continue; // On saute les usines qui ne correspondent pas
							}

							if ($_SESSION['log']['type'] === 'superadmin' && $idusine != IdEncryptor::decode($params['idusine'])) {
								continue; // On saute les usines qui ne correspondent pas
							}

							$allAtelier = $atelier->AllAtelier($conn, $idusine);
					?>
					<div class="col-xl-12">
						<div class="shadow-lg page-title flex-wrap d-none d-xl-block"> <!-- Ajout des classes de visibilité -->
							<div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
								<div>
									<div class="fs-5">Atelier de l'<?=Usine::getNameById($conn,$idusine)?></div>
								</div>
								<div class="fs-5">
										Nombre d'atelier : <strong class="card-title fw-bold fs-5"><?=$atelier->NbreAtelierByFactory($conn,$idusine)?></strong>
									</div>
								
							</div>
						</div>

						<div class="shadow-lg page-title d-xl-none text-center py-2">
							<u>
								<div class="fs-5">Atelier de l'<?=Usine::getNameById($conn,$idusine)?></div>
							</u>
						</div>
					</div>
					<div class="col-xl-12">
                        <!-- Row -->
						<div class="row">
							<?php 
							// echo $message_succes;
							 ?>
                            <div class="col-xl-12">
                                 <!-- Row -->
                                <div class="main">
								<div class="scrollable-row ">

									<?php foreach ($allAtelier as $key) { 

									$infoprodbyatelier = $contenir -> getProduitByAtelier($conn,$key['idatelier']);	

									$nbreProduitSansFds = 0;
									$nombre = $contenir->NbreProduitParAtelier($conn,$key['idatelier']);
									foreach ($infoprodbyatelier as $keys) {
											
											if ($produit -> ifProduitSansFDS($conn,$keys['idprod'])) {
												$nbreProduitSansFds +=1;
											}
									}

									?>
									<div class="col-xl-3 col-lg-4 col-sm-6 px-3">
										<div class=" card contact_list text-center">
											<div class="card-body">
												<div class="user-content">
													<div class="user-info">
														<div class="user-details">
															<p style="font-weight: 700;">Atelier nommé</p>
															<h4 class="user-name mb-0"><?=$key['nomatelier'] ?></h4>
															
														</div>
													</div>
												
												</div>
												<div class="contact-icon">
													<label style="font-weight: 700;" style="font-weight: 600; font-size: 11px;padding: 0px 10px;">Nombre de produit:</label><span class="badge badge-success light"><?=$nombre?></span>

													<br>
													<label style="font-weight: 700;" style="font-weight: 600; font-size: 11px;padding: 0px 10px;">Produit sans fds: </label><span class="badge badge-danger light"><?=$nbreProduitSansFds?></span>
												</div>
												<div class="d-flex mb-3 justify-content-center align-items-center">
													<?php if($_SESSION['log']['type'] != 'user'){ ?>
														<center>
															<?php require __DIR__. '/edit.php'; ?>
															<?php require __DIR__. '/delete.php'; ?>
														</center>
													<?php } ?>
												</div>
												<div class="d-flex align-items-center">
													<a href="/all-products/<?= IdEncryptor::encode($key['idatelier']) ?>" class="btn btn-secondary btn-sm w-100 me-2">Voir les produits</a>
												</div>
											</div>
										</div>
									</div>
									<?php } ?>
									</div>
									<div class="scroll-indicator">
										<div class="scroll-indicator-text">Faites défiler pour voir plus</div>
										<div class="scroll-indicator-icon">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
												<polyline points="9 18 15 12 9 6"></polyline>
											</svg>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
					<?php
						if ($_SESSION['log']['type'] === 'admin') {
							break;
						}
						
						if ($_SESSION['log']['type'] === 'superadmin' && $idusine == IdEncryptor::decode($params['idusine'])) {
							break; 
						}


						} 
					?>
			</div>
		</div>
		
        

		
       

		
		
        


	</div>
    

	
	



		
	
    
    
	<script src="/../../vendor/global/global.min.js"></script>
	<!-- <script src="/../../vendor/chart.js/Chart.bundle.min.js"></script> -->
	<script src="/../../vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	<!-- <script src="/../../vendor/apexchart/apexchart.js"></script> -->
    <!-- <script src="/../../vendor/peity/jquery.peity.min.js"></script> -->
	<!-- <script src="/../../vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script> -->
	<!-- <script src="/../../vendor/swiper/js/swiper-bundle.min.js"></script> -->
    <!-- <script src="/../../vendor/datatables/js/jquery.dataTables.min.js"></script> -->
    <!-- <script src="/../../js/plugins-init/datatables.init.js"></script> -->
	<!-- <script src="/../../js/dashboard/dashboard-1.js"></script> -->
	<!-- <script src="/../../vendor/wow-master/dist/wow.min.js"></script> -->
	<!-- <script src="/../../vendor/bootstrap-datetimepicker/js/moment.js"></script> -->
	<!-- <script src="/../../vendor/datepicker/js/bootstrap-datepicker.min.js"></script> -->
	<!-- <script src="/../../vendor/bootstrap-select-country/js/bootstrap-select-country.min.js"></script> -->
	<script src="/../../js/dlabnav-init.js"></script>
	<script src="/../../js/all-workshop.js"></script>
    <script src="/../../js/custom.min.js"></script>
	<!-- <script src="/../../js/demo.js"></script> -->



	


    
	

</body>


</html>









