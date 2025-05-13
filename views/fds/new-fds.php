<?php 
    // require_once __DIR__. '/../../utilities/session.php';
    $nom = "";


	
	// require_once __DIR__. '/../../utilities/session.php';
	// require_once __DIR__. '/../../models/produit.php';
	// require_once __DIR__. '/../../models/package.php';
	// require_once __DIR__. '/../../models/connexion.php';
    $conn = Database::getInstance()->getConnection();


	$produit = new Produit();
	$package = new Package();
    
    $nom = $produit->getNameById($conn, $idprod);
    
    $current_page = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    if (strpos($current_page, 'info-fds/new-info-fds') === 0) {
        $message = "Informations de la FDS du produit $nom.";
    }

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="/vendor/wow-master/css/libs/animate.css" rel="stylesheet">
        <link href="/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/vendor/bootstrap-select-country/css/bootstrap-select-country.min.css">
        <link rel="stylesheet" href="/vendor/jquery-nice-select/css/nice-select.css">
        <link href="/vendor/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=experiment" />
        
        <link href="/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
        
        <link rel="stylesheet" href="/vendor/swiper/css/swiper-bundle.min.css">
        
        
        <link href="/css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="/css/all.css">
        <script src="/js/all.js"></script>
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


		<form action="/fds/add-info" enctype="multipart/form-data" method="POST">
        <div class="content-body">
		
        
			<div class="container-fluid">
				<div class="row">
				<?php 
					if (isset($_SESSION['insert']['type']) && $_SESSION['insert']['type'] === "insertfalse") { 
						$message = "Problème lors de l'insertion";
						echo $package -> message($message,"danger");
					}elseif (isset($_SESSION['insert']['type']) && $_SESSION['insert']['type'] === "insertok") {
						$message = "Le produit a été ajoutée";
						echo $package -> message($message,"success");
					}elseif (isset($_SESSION['insert']['type']) && $_SESSION['insert']['type'] === "doublonProduit") {
						$message = "Ce Produit existe déjà ";
						echo $package->message($message, "danger");
						// 
						// echo $package -> message($message,$type);
					}elseif (isset($_SESSION['insert']['type']) && $_SESSION['insert']['type'] === true) {
						$message = "La FDS a bien été enregistrée, veuillez enregistrer ses informations";
						echo $package -> message($message,"success");
					}
				?>

					<div class="col-xl-12">
						<div class="shadow-lg card">
							<div class="card-header">
								<h5 class="mb-0">Informations de la FDS du produit </h5>
							</div>
							<div class="card-body">
                                <div class="row gx-5">
                                    <div class="col-12">
                                        <div class="row">

                                            <!-- Colonne gauche -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <input type="hidden" name="idprod" value="<?=$idprod?>">
                                                    <label class="form-label text-primary fw-bold">Danger Physique <span class="required">*</span></label>
                                                    <textarea class="form-control" id="physique" name="physique" rows="6"></textarea>
                                                    <span class="fw-bold text-danger" id="messageNom" style="display: none;"></span>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label text-primary fw-bold">Danger pour la santé <span class="required">*</span></label>
                                                    <textarea class="form-control" id="sante" name="sante" rows="6"></textarea>
                                                    <span class="fw-bold text-danger" id="messageUtilisation" style="display: none;"></span>
                                                </div>   

                                                <div class="mb-3">
                                                    <label class="form-label text-primary fw-bold">Caractéristiques des PPT chimiques <span class="required">*</span></label>
                                                    <textarea class="form-control" id="ppt" name="ppt" rows="6"></textarea>
                                                    <span id="messageDanger" class="text-danger fw-bold" style="display:none;"></span>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label text-primary fw-bold">Stabilité <span class="required">*</span></label>
                                                    <textarea class="form-control" id="stabilite" name="stabilite" rows="6"></textarea>
                                                    <span id="messageAtelier" class="text-danger fw-bold" style="display:none;"></span>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label text-primary fw-bold">Conditions à éviter<span class="required">*</span></label>
                                                    <textarea class="form-control" name="eviter" id="eviter" rows="6"></textarea>
                                                    <span class="fw-bold text-danger" id="messageRisque" style="display: none;"></span>
                                                </div>
                                            </div>

                                            <!-- Colonne droite -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label text-primary fw-bold">Matériaux incompatibles <span class="required">*</span></label>
                                                    <textarea class="form-control" id="incompatible" name="incompatible" rows="4"></textarea>
                                                    <span class="fw-bold text-danger" id="messageUtilisation" style="display: none;"></span>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label text-primary fw-bold">Réactivité <span class="required">*</span></label>
                                                    <textarea class="form-control" id="reactivite" name="reactivite" rows="4"></textarea>
                                                    <span class="fw-bold text-danger" id="messageUtilisation" style="display: none;"></span>
                                                </div>


                                                <div class="mb-3">
                                                    <label class="form-label text-primary fw-bold">Manipulation / Stockage<span class="required">*</span></label>
                                                    <textarea class="form-control" id="manipulation" name="manipulation" rows="6"></textarea>
                                                    <span class="fw-bold text-danger" id="messageUtilisation" style="display: none;"></span>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label text-primary fw-bold">Premiers secours<span class="required">*</span></label>
                                                    <textarea class="form-control" id="secours" name="secours" rows="6"></textarea>
                                                    <span class="fw-bold text-danger" id="messageUtilisation" style="display: none;"></span>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label text-primary fw-bold">EPI<span class="required">*</span></label>
                                                    <textarea class="form-control" id="epi" name="epi" rows="6"></textarea>
                                                    <span class="fw-bold text-danger" id="messageUtilisation" style="display: none;"></span>
                                                </div>
                                            </div>

                                        </div> <!-- Fin .row interne -->
                                    </div> <!-- Fin col-12 -->
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-end">
                                    <button type="submit" id="submitBtn" class="btn btn-primary" >Soumettre</button>
                                </div>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</form>
	   
	</div>
    <?php unset($_SESSION['insert']); ?>


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

	
    