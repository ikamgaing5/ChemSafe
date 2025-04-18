<?php 
    require_once __DIR__. '/../../utilities/session.php';
    require_once __DIR__. '/../../models/atelier.php';
    require_once __DIR__. '/../../models/produit.php';
	require_once __DIR__.'/../../models/danger.php';
    require_once __DIR__. '/../../models/contenir.php';
    require_once __DIR__. '/../../models/connexion.php';
    require_once __DIR__. '/../../models/package.php';
	require_once __DIR__. '/../../models/possede.php';
    
    $conn = Database::getInstance()->getConnection();


    // $conn = getConnection();
	// $danger = new Danger();
    $atelier = new Atelier();
    $produit = new Produit();
    $contenir = new Contenir();
    $package = new Package();
	$danger = new Danger();

	$idusine = $_SESSION['idusine'];
	$infoproduit = $produit->OneProduct($conn,$idprod);
	$allAtelier = $atelier ->AllAtelier($conn,$idusine);


	$allDangers = $danger->all($conn); // tous les dangers
	$linkedDangers = $danger->getDangersByProduitId($conn, $idprod); // dangers du produit
	
	// On extrait juste les ID pour vérifier les sélectionnés
	$selectedIds = array_column($linkedDangers, 'iddanger');


	// $allAteliers = $atelier-($conn); // tous les ateliers
	$linkedAteliers =$atelier->getAteliersByProduitId($conn, $idprod); // ceux liés au produit
	$selectedAtelierIds = array_column($linkedAteliers, 'idatelier');

    $current_page = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    if (strpos($current_page, 'product/edit') === 0) {
        $message = "<span class='fs-4'> Modificaion du Produit ".$infoproduit['nomprod']."</span>";
    }


?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- <link rel="shortcut icon" type="image/png" href="images/favicon.png" > -->
        <link href="/../../vendor/wow-master/css/libs/animate.css" rel="stylesheet">
        <link href="/../../vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/../../vendor/bootstrap-select-country/css/bootstrap-select-country.min.css">
        <link rel="stylesheet" href="/../../vendor/jquery-nice-select/css/nice-select.css">
        <link href="/../../vendor/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=experiment" />
        
        <link href="/../../vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
        
        <link rel="stylesheet" href="/../../vendor/swiper/css/swiper-bundle.min.css">
        
        
        <link href="/../css/style.css" rel="stylesheet">

        <style>
            @font-face {
            font-family: 'Material Icons';
            font-style: normal;
            font-weight: 400;
            src: url(flUhRq6tzZclQEJ-Vdg-IuiaDsNc.woff2) format('woff2');
            }

            .material-icons {
            font-family: 'Material Icons';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-smoothing: antialiased;
            }
			html,body{
        height: auto !important;
        overflow-y: auto !important;
    }
    *{
        overflow: visible;
    }
    ::-webkit-scrollbar{
        width: 8px;
    }
    ::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover{
        background: #555;
    }




		</style>
			
		</head>
		<script>
			window.addEventListener('load', ()=>{
				document.body.style.overflowY = 'auto';
				document.documentElement.style.overflow = 'auto';
				document.querySelectorAll('*').forEach(el=>{
					const style = getComputedStyle(el);
					if (style.overflow === 'hidden' ||style.overflowY === 'hidden' ) {
						el.style.overflow = 'visible';
						el.style.overflowY = 'auto';
					}
				});
			});
		</script>
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


		<form action="/product/edit-product" enctype="multipart/form-data" method="POST">
        <div class="content-body">
		

			<div class="container-fluid">
				<div class="row">
				<?php 
                	// echo $message_succes;
					
				?>

					<div class="col-xl-12">
						<div class="shadow-lg card">
							<div class="card-header">
								<h5 class="mb-0">Details du produit</h5>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-xl-3 col-lg-4">
										<label style="font-weight: 700;" class="form-label text-primary">Photo<span class="required">*</span></label>
										<div class="avatar-upload">
											<div class="avatar-preview">
												<div id="imagePreview" style="background-image: url(/../../uploads/photo/<?=$infoproduit['photo']; ?>);"> 			
												</div>
											</div>

											
												<input type="file" name="imageUpload" class="form-control d-none" accept="image/*" id="imageUpload" >
												<label style="font-weight: 700;" for="imageUpload" class="btn btn-primary mt-2 btn-sm">Choisir la photo</label>
												<a href="javascript:void" class="btn btn-danger light remove-img ms-2 btn-sm">Retirer</a>
											
										</div>	


										

									</div>
									<div class="col-xl-9 col-lg-8">
										<div class="row">
											<div class="col-xl-6 col-sm-6">
												<div class="mb-3">
												  <label style="font-weight: 700;" for="exampleFormControlInput1" class="form-label text-primary">Nom du produit<span class="required">*</span></label>
												  <input type="text" class="form-control" name="nom" id="nom" placeholder="Le nom du produit" value="<?php if(isset($_SESSION['insert']['info'])){ echo $_SESSION['insert']['info']['nom']; }else{ echo $infoproduit['nomprod']; } ?>">
                                                  <span class="fw-bold text-danger" id="messageNom" style="display: none;"></span>
												</div>
												
                                                <div class="mb-3">
												  <label style="font-weight: 700;"  class="form-label text-primary">Emballage et Poids/Volume du produit<span class="required">*</span></label>
													<div class="d-flex">
														<div class="d-flex flex-column">
                                                            <input type="text" class="form-control" name="emballage" placeholder="Type d'Emballage" id="emballage" value="<?php if(isset($_SESSION['insert']['info'])){ echo $_SESSION['insert']['info']['emballage']; }else{ echo $infoproduit['type_emballage']; } ?>">
                                                            <span class="fw-bold text-danger" id="messageEmballage" style="display: none;"></span>
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <input type="text" class="form-control w-50 ms-3" name="vol" id="vol" value="<?php if(isset($_SESSION['insert']['info'])){ echo $_SESSION['insert']['info']['vol']; }else{ echo $infoproduit['poids']; } ?>" placeholder="Vol/Poids">
                                                            <span class="fw-bold text-danger" id="messageVol" style="display: none;"></span>
                                                        </div>
													</div>
												</div>
                                                
                                                
                                                
                                                <div class="mb-3">
													<label style="font-weight: 700;" for="exampleFormControlInput1" class="form-label text-primary">Danger<span class="required">*</span></label>
													<div class="mb-3">
													<select multiple name="danger[]" class="form-control">
													<?php foreach ($allDangers as $danger): ?>
													<?php if (in_array($danger['iddanger'], $selectedIds)) { ?>
														<option value="<?= $danger['iddanger'] ?>" selected>
															<?= htmlspecialchars($danger['nomdanger']) ?>
														</option>
													<?php } else { ?>
														<option value="<?= $danger['iddanger'] ?>">
															<?= htmlspecialchars($danger['nomdanger']) ?>
														</option>
													<?php } ?>
													<?php endforeach; ?>
													</select>
                                                        <span id="messageDanger" class="text-danger fw-bold" style="display:none;"></span>
														<span id="message-conflit-danger" class="text-danger fw-bold" style="display:none;"></span>
										            </div>
                                                    <!-- <span class="fw-bold text-danger" id="messageDanger" style="display: none;"></span> -->
												</div>

												<div class="mb-3">
													<label style="font-weight: 700;" for="exampleFormControlInput1" class="form-label text-primary">Atelier d'utilisation<span class="required">*</span></label>
													<div class="mb-3">
														<select multiple class="form-control" name="atelier[]" id="atelier">
															<?php foreach ($allAtelier as $atelier): ?>
																<?php if (in_array($atelier['idatelier'], $selectedAtelierIds)) { ?>
																	<option value="<?= $atelier['idatelier'] ?>" selected>
																		<?= htmlspecialchars($atelier['nomatelier']) ?>
																	</option>
																<?php } else { ?>
																	<option value="<?= $atelier['idatelier'] ?>">
																		<?= htmlspecialchars($atelier['nomatelier']) ?>
																	</option>
																<?php } ?>
															<?php endforeach; ?>
														</select>
                                                        <span id="messageAtelier" class="text-danger fw-bold" style="display:none;"></span>
										            </div>

												</div>
												

												<div class="mb-3">
												    <label style="font-weight: 700;" for="risque" class="form-label text-primary">Risque<span class="required">*</span></label>
												    <textarea class="form-control" name="risque"  id="risque" rows="6"> <?php if(isset($_SESSION['insert']['info'])){ echo $_SESSION['insert']['info']['risque']; }else{ echo $infoproduit['risque']; } ?></textarea>
                                                    <span class="fw-bold text-danger" id="messageRisque" style="display: none;"></span>
												</div>

											</div>
											<div class="col-xl-6 col-sm-6">
                                                <div class="mb-3">
												    <label style="font-weight: 700;"  class="form-label text-primary">Fabircant et Nature du produit<span class="required">*</span></label>
													<div class="d-flex">
														<div class="d-flex flex-column">
                                                        <input type="text" class="form-control" name="fabriquant" placeholder="Fabricant" id="fabriquant" value="<?php if(isset($_SESSION['insert']['info'])){ echo $_SESSION['insert']['info']['fabriquant']; }else{ echo $infoproduit['fabriquant']; } ?> ">
                                                        <span class="fw-bold text-danger" id="messageFabriquant" style="display: none;"></span>
                                                        </div>
                                                        
                                                        <div class="d-flex flex-column">
                                                            <input type="text" class="form-control w-50 ms-3" name="nature" id="nature" placeholder="Nature" value="<?php if(isset($_SESSION['insert']['info'])){ echo $_SESSION['insert']['info']['nature']; }else{ echo $infoproduit['nature']; } ?>">
                                                            <span class="fw-bold text-danger" id="messageNature" style="display: none;"></span>
                                                        </div>

													</div>
												</div>

												<div class="mb-3">
												    <label style="font-weight: 700;" for="utilisation" class="form-label text-primary">Utilisation<span class="required">*</span></label>
												    <textarea class="form-control" name="utilisation"  id="utilisation" rows="6"><?php if(isset($_SESSION['insert']['info'])){ echo $_SESSION['insert']['info']['utilisation']; }else{ echo $infoproduit['utilisation']; } ?></textarea>
                                                    <span class="fw-bold text-danger" id="messageUtilisation" style="display: none;"></span>
												</div>

												<div class="mb-3">
													<label style="font-weight: 700;" for="DispoFDS" class="form-label text-primary">Disponibilité FDS<span class="required">*</span></label>
													<div class="mb-3">
														<select class="default-select form-control wide form-control-sm" name="DispoFDS" id="DispoFDS">
															<option value="oui">OUI</option>
															<option value="non">NON</option>
														</select>
										            </div>
												</div>

												<div class="mb-3" id="FDSDisplay">

                                                <label style="font-weight: 700;" class="form-label text-primary">Fichier PDF <span class="required">*</span></label>
                                                <div class="pdf-upload">
                                                    <div class="pdf-preview mt-2" id="pdfPreview" style="display: none;">
                                                        <iframe id="pdfViewer" src="" width="100%" height="400px" style="border: 1px solid #ccc;"></iframe>
                                                    </div>

                                                    <input type="file" name="pdfUpload" class="form-control d-none" accept="application/pdf" id="pdfUpload">
                                                    <span id="messageFDS" class="text-danger fw-bold" style="display:none;"></span>
                                                    <label style="font-weight: 700;" for="pdfUpload" class="btn btn-primary mt-2 btn-sm">Choisir le PDF</label>
                                                    <a href="javascript:void(0)" class="btn btn-danger light remove-pdf ms-2 btn-sm">Retirer</a>
                                                </div>

												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-12">
					<div class="shadow-lg card" >
						<div class="card-header">
							<h5 class="mb-0">Details de l'authentification</h5>
						</div>
						<div class="card-body" >
							<div class="row">
								<div class="col-xl-6 col-sm-6">
									<div class="mb-3">
										<label style="font-weight: 700;" for="exampleFormControlInput8" class="form-label text-primary">Nom d'utilisateur<span class="required">*</span></label>
										<input type="text" class="form-control" id="username" name="username" placeholder="Votre nom d'utilisateur">
									  </div>
								
								</div>
								<div class="col-xl-6 col-sm-6">
									<div class="mb-3">
										<label style="font-weight: 700;" for="exampleFormControlInput8" class="form-label text-primary">Mot de passe<span class="required">*</span></label>
										<input type="text" class="form-control" id="password" name="password" placeholder="Votre mot de passe" maxlenght="6">
									  </div>
						
								</div>
							</div>
							<div class="float-end">
								<!-- <button type="submit" id="submitBtn" class="btn btn-primary" disabled>Soumettre</button> -->

								<!-- <input type="submit" id="submitBtn" disabled class="btn btn-primary"> -->
							</div>
							<div class="text-end mt-4">
							<button type="submit" id="submitBtn" class="btn btn-primary" disabled>Soumettre</button>
							
						</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		</form>

		</div>
<?php unset($_SESSION['photo'],$_SESSION['insert']) ?>


    <script src="/../../vendor/global/global.min.js"></script>
	<script src="/../../vendor/chart.js/Chart.bundle.min.js"></script>
	<script src="/../../vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	<script src="/../../vendor/apexchart/apexchart.js"></script>
    <script src="/../../vendor/peity/jquery.peity.min.js"></script>
	<script src="/../../vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
	<script src="/../../vendor/swiper/js/swiper-bundle.min.js"></script>
    <script src="/../../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="/../../js/plugins-init/datatables.init.js"></script>
	<script src="/../../js/dashboard/dashboard-1.js"></script>
	<script src="/../../vendor/wow-master/dist/wow.min.js"></script>
	<script src="/../../vendor/bootstrap-datetimepicker/js/moment.js"></script>
	<script src="/../../vendor/datepicker/js/bootstrap-datepicker.min.js"></script>
	<script src="/../../vendor/bootstrap-select-country/js/bootstrap-select-country.min.js"></script>
	<script src="/../../js/dlabnav-init.js"></script>
    <script src="/../../js/custom.min.js"></script>
	<script src="/../../js/demo.js"></script>
    <script src="/../../js/new-product.js"></script> 

    
	<?php 
		if (isset($_SESSION['photo']['photo'])) {
			echo $photo = $_SESSION['photo']['photo'];
		}

	?>
	
    