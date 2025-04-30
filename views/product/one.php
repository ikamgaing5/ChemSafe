<?php 
    

	// require_once __DIR__. '/../../models/package.php';
	require_once __DIR__. '/../../utilities/session.php';
	require_once __DIR__. '/../../models/produit.php';
	require_once __DIR__. '/../../models/package.php';
	require_once __DIR__. '/../../models/atelier.php';
	require_once __DIR__. '/../../core/connexion.php';
	require_once __DIR__. '/../../models/danger.php';
    require_once __DIR__. '/../../models/fds.php';
	$conn = Database::getInstance()->getConnection();

	$danger = new Danger();
	$produit = new Produit();
	$package = new Package();
	$atelier = new Atelier();
    $fds = new FDS();

   
    $idprod = IdEncryptor::decode($id);
    $nomproduit = $produit->getNameById($conn,$idprod);
    $infoFDS = $fds->getInfoByProd($conn,$idprod);
    
    $current_page = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    if (strpos($current_page, 'product/more-detail') === 0) {
        $message = "Informations du produit $nomproduit.";
    }
    // $_SESSION['idatelier'] = IdEncryptor::encode($idatelier);

    if (isset($_SESSION['idatelier'])) {
        $idatelier = IdEncryptor::decode($_SESSION['idatelier']);
        $nomatelier = $atelier->getName($conn,$idatelier);
    }

    $nomatelier = $atelier->getName($conn,$idatelier);
    
    $prod = $produit->OneProduct($conn,$idprod);
    // $danger = $prod['danger'];
    $danger_ids = explode(',', $prod['danger']);
    $nomdanger = "";
    foreach ($danger_ids as $key) {
        $req = $danger->getById($conn,$key);
        $nomdanger .= $req['nomdanger'].", ";
    }
    // var_dump($prod);
    // die();
    
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
        <div>
    
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

                <?php require_once __DIR__. '/../../layouts/navbar.php'; ?>
                <?php require_once __DIR__. '/../../layouts/dlabnav.php'; ?>
                <div class="content-body">
                    <div class="container-fluid mt-4">
                        <div class="row justify-content-center">
                        <div class="col-xl-12">
                            <div class="shadow-lg page-title flex-wrap d-none d-xl-block"> <!-- Ajout des classes de visibilité -->
                                <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                    <div>
                                        <u><a class="text-primary fw-bold fs-5" href="/dashboard">Tableau de bord</a></u>
                                        <i class="bi bi-caret-right-fill"></i>
                                        <u><a href="/workshop/all-workshop" class="text-primary fw-bold fs-5">Nos Ateliers</a></u>
                                        <i class="bi bi-caret-right-fill"></i>
                                        <u><a href="/all-products/<?=$_SESSION['idatelier']?>" class="text-primary fw-bold fs-5">
                                            <?php if (isset($_SESSION['idatelier'])) echo $nomatelier; ?>
                                        </a></u>
                                        <span class="fs-4"><i class="bi bi-caret-right-fill"></i></span>
                                        <span class="card-title fw-bold fs-5">Plus d'informations</span>
                                    </div>
                                </div>
                            </div>

                            <div class="shadow-lg page-title d-xl-none text-center py-2">
                            
                                <u><a href="/all-products/<?=$_SESSION['idatelier']?>" class="text-primary fw-bold fs-5"><i class="bi bi-caret-right-fill"></i>
                                    <?php if (isset($_SESSION['idatelier'])) echo $nomatelier; ?>
                                </a></u>
                            </div>
                        </div>


                            <div class="col-xl-12 col-lg-12">
                                <div class="card shadow-lg">
                                    <div class="card-header">
                                        <h5 class="mb-0">Détails du Produit</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <!-- Image du produit -->
                                            <div class="col-md-7">
                                                <img src="../../uploads/photo/<?=$prod['photo']?>" alt="Produit"  class="img-fluid rounded shadow">
                                            </div>

                                            <!-- Détails du produit -->
                                            <div class="col-md-5">
                                                <h3 class="mt-4"><?=$prod['nomprod']?></h3>

                                                <div class="mb-3">
                                                    <h6>Danger : </h6>
                                                    <span class="text-danger fw-bold"><?=$nomdanger?></span>
                                                </div>

                                            

                                                <p class="mb-3" >
                                                    <strong>Nature : </strong><span class="fw-bold text-primary"><?=$prod['nature']?></span>
                                                </p>

                                                <p class="mb-3" >
                                                    <strong>Fabricant : </strong><span class="fw-bold text-primary"><?=$prod['fabriquant']?></span>
                                                </p>

                                                <p class="mb-3" >
                                                    <strong>Risque : </strong><span class="fw-bold text-primary"><?=$prod['risque']?></span>
                                                </p>

                                                <div class="mb-3">
                                                    <h6>Utilisation : </h6>
                                                    <span class="text-primary fw-bold"><?=$prod['utilisation']?></span>
                                                </div>

                                                <p><strong>Type d'emballage : </strong><span class="fw-bold text-primary"><?=$prod['type_emballage']?></span></p>
                                                
                                                
                                                <p><strong>Vol/Poids : </strong><span class="fw-bold text-primary"><?=$prod['poids']?></span></p>

                                                <?php if ($prod['fds'] != NULL) { ?>
                                                    <div class="mb-3">
                                                        <h6>FDS : </h6>
                                                        <div class="d-flex align-items-center">
                                                            <strong class="text-success me-2">✔ Disponible</strong>
                                                            <?php require_once __DIR__ .'/fds.php'; ?>
                                                        </div>
                                                    </div>
                                                <?php }else { ?>
                                                    <p> FDS : <span class="text-danger"><strong>&times; Pas Disponible</strong></span></p>
                                                <?php  } ?>


                                                <p class="mt-3"><strong>Price:</strong> Contact Us</p>

                                                <div class="d-flex">
                                                    <button class="btn btn-outline-dark me-2">Talk to an Expert</button>
                                                    <button class="btn btn-primary">Add to Favorites</button>
                                                </div>
                                            </div>
                                        </div> 
                                    </div> 
                                </div>
                            </div> 
                        </div>
                        
                        
                    </div>


                    <div class="container-fluid mt-0">
                        <div class="row justify-content-center">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card shadow-lg">
                                    <div class="card-header">
                                        <h5 class="mb-0">Information FDS</h5>
                                    </div>
                                    <div class="card-body">
                                    <div class="row">
											<div class="col-xl-6 col-sm-6">
												<div class="mb-3">
                                                    <h6 class="text-primary">Risque Physique : </h6>
                                                    <span class="text-danger fw-bold"><?=$infoFDS['physique'] ?></span>
												</div>
												
                                                <div class="mb-3">
                                                    <h6 class="text-primary">Danger pour la santé : </h6>
                                                    <span class="text-danger fw-bold"><?=$infoFDS['sante'] ?></span>
												</div>
                                                                                                
                                                <!-- <div class="mb-3">
                                                    <h6 class="text-primary">Danger pour la santé : </h6>
                                                    <span class="text-danger fw-bold"><?=$nomdanger?></span>
												</div> -->

												<div class="mb-3">
                                                    <h6 class="text-primary">Caractéristiques des PPT chimiques: </h6>
                                                    <span class="text-danger fw-bold"><?=$infoFDS['ppt'] ?></span>
												</div>
												

												<div class="mb-3">
                                                    <h6 class="text-primary">Stabilité: </h6>
                                                    <span class="text-danger fw-bold"><?=$infoFDS['stabilite'] ?></span>
												</div>

                                                <div class="mb-3">
                                                    <h6 class="text-primary">Conditions à éviter: </h6>
                                                    <span class="text-danger fw-bold"><?=$infoFDS['eviter'] ?></span>
												</div>

											</div>
											<div class="col-xl-6 col-sm-6">
                                                

												<div class="mb-3">
                                                    <h6 class="text-primary">Matériaux incompatibles: </h6>
                                                    <span class="text-danger fw-bold"><?=$infoFDS['incompatible'] ?></span>
												</div>

												<div class="mb-3">
                                                    <h6 class="text-primary">Réactivité : </h6>
                                                    <span class="text-danger fw-bold"><?=$infoFDS['reactivite'] ?></span>
												</div>

												<div class="mb-3">
                                                    <h6 class="text-primary">Manipulation Stockage : </h6>
                                                    <span class="text-danger fw-bold"><?=$infoFDS['stockage'] ?></span>
                                                </div>

                                                <div class="mb-3">
                                                    <h6 class="text-primary">Premiers secours : </h6>
                                                    <span class="text-danger fw-bold"><?=$infoFDS['secours'] ?></span>
                                                </div>

                                                <div class="mb-3">
                                                    <h6 class="text-primary">EPI : </h6>
                                                    <span class="text-danger fw-bold"><?=$infoFDS['epi'] ?></span>
                                                </div>

                                                

												</div>
											</div>
										</div> <!-- Fin row -->
                                    </div> <!-- Fin card-body -->
                                </div> <!-- Fin card -->
                            </div> <!-- Fin col -->
                        </div> <!-- Fin row -->
                        
                        
                    </div>
                    
                </div>
                                            
             <!-- Fin main-wrapper -->

        </div>
        </body>


































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