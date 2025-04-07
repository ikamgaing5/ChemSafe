<?php 
    require_once __DIR__. '/../utilities/session.php';
        $current_page = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        if ($current_page == 'dashboard') {
            $message = 'Tableau de bord.';
        }
        
        // require_once __DIR__. '/../core/connexion.php';
        require_once __DIR__. '/../models/atelier.php';
        require_once __DIR__. '/../models/produit.php';
        require_once __DIR__. '/../models/user.php';
        require_once __DIR__. '/../models/contenir.php';

        // $conn = getConnection();
        
        require_once __DIR__. '/../models/connexion.php';
        $conn = Database::getInstance()->getConnection();
        $atelier = new Atelier();
        $produit = new Produit();
        $user = new User($conn);
        $contenir = new Contenir();

        $iduser = $_SESSION['id'];
        $req = $user->getUserById($conn,$iduser);
        $nom = $req['nomuser'];
        $allProductFDS = $produit -> ProduitFDS($conn);


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="DexignLab" >
	<meta name="robots" content="" >
	<meta name="keywords" content="school, school admin, education, academy, admin dashboard, college, college management, education management, institute, school management, school management system, student management, teacher management, university, university management" >
	<meta name="format-detection" content="telephone=no">

	
	<meta name="viewport" content="width=device-width, initial-scale=1">
        <script>
            if (!sessionStorage.getItem("reloaded")) {
                sessionStorage.setItem("reloaded", "true");
                location.reload();
            }
        </script>
		
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/jquery-nice-select@1.1.0/css/nice-select.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/lokesh-coder/bootstrap-select-country@latest/css/bootstrap-select-country.min.css" rel="stylesheet"> -->
    <!-- <link rel="stylesheet" href="/css/custom.css"> -->
        
        
        <link href="/../css/style.css" rel="stylesheet">
	


	
        <link href="/../vendor/wow-master/css/libs/animate.css" rel="stylesheet">
        <link href="/../vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/../vendor/bootstrap-select-country/css/bootstrap-select-country.min.css">
        <link rel="stylesheet" href="/../vendor/jquery-nice-select/css/nice-select.css">
        <link href="/../vendor/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=experiment" />
        
        <link href="/../vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
        
        <link rel="stylesheet" href="/../vendor/swiper/css/swiper-bundle.min.css">
        
        
        <link href="/../css/style.css" rel="stylesheet">
	
	
    <!-- <link href="/../css/style.css" rel="stylesheet"> -->

<style>
	
    @font-face {
    font-family: 'Material Icons';
    font-style: normal;
    font-weight: 400;
    src: url("flUhRq6tzZclQEJ-Vdg-IuiaDsNc.woff2") format('woff2');
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

    .dot {
         /* background-color: #dc3545 !important;  */
         /* rouge bootstrap */
    }




</style>
	
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
   
    <div id="main-wrapper" class="wallet-open active">
	       
			
		<?php require_once __DIR__. '/../layouts/nav.php' ?>
        
		<?php require_once __DIR__. '/../layouts/dlabnav.php'; ?>
        
		
	
		
		<div class="wallet-bar-close"></div>
		
        
		<div class="content-body">
			<div class="container-fluid">
				<div class="row">
                    <?php require_once __DIR__. '/../layouts/info.php' ?>
                        <div class="col-xl-12">
							<div class="shadow-lg page-titles">
								<div class="d-flex align-items-center flex-wrap ">
									<h2 class="heading" >Bienvenue dans ChemSafe! <span style="color: red;"> <?=$nom?> .</span></h2>
								</div>
							</div>
						</div>
					
                        <!-- Calendrier -->
                        <div class="row">
                            <div class="col-xl-4 wow fadeInUp" data-wow-delay="1.5s">
                                <div class="shadow-lg card">
                                    <div class="card-header pb-0 border-0 flex-wrap">
                                        <div>
                                            <div class="mb-3">
                                                <h2 class="heading mb-0">Calendrier de </h2>	
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body text-center event-calender  py-0 px-1">
                                        <input type='text' class="form-control d-none" id='datetimepicker1'>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-8">
                                <div class="shadow-lg card">
                                    <div class="card-header py-3 border-0 px-3">
                                        <h4 class="heading m-0">Liste des Atelier de ChemSafe</h4>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive basic-tbl">
                                            <table id="teacher-table" class="tech-data" style="min-width: 798px">
                                                <thead>
                                                    <tr>
                                                        <th>Nom de l'atelier</th>
                                                        <th>Nombre de produits</th>
                                                        <th>Nombre de produit avec FDS</th>
                                                        <th class="text-end">email</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $raw = $atelier->AllAtelier($conn);

                                                    foreach ($raw as $key) {
                                                        $id = $key['idatelier'];

                                                        $produitParAtelier = $contenir -> getProduitByAtelier($conn,$id);
                                                        $nombre  = 0;
                                                        foreach ($produitParAtelier as $keys) {
                                                          $test = $produit -> ifProduitsFDS($conn,$keys['idprod']);
                                                            if ($test > 0) {
                                                                $nombre +=1;
                                                            }
                                                        }   

                                                        ?>

                                                    <tr>
                                                        <td style="font-weight: 700;"><?=$key['nomatelier']?></td>
                                                        <td style="font-weight: 700;"><?=$contenir->NbreProduitParAtelier($conn,$id)?></td>
                                                        <td style="font-weight: 700;"><?=$nombre?></td>
                                                         <td><span class="badge badge-dark"><?=$key['idatelier']?></span></td>
                                                        <!--<td>info</td>
                                                        <td><span class="badge badge-success">info</span></td>
                                                        <td class="text-end"><span class="badge badge-sm light badge-danger">info</span></td> -->
                                                    </tr>
                                                    
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
				
				
			    </div>
		    </div>
		
        
		

	    </div>

	
    



		
	
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>  -->
    

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js" integrity="sha512-SuxO9djzjML6b9w9/I07IWnLnQhgyYVSpHZx0JV97kGBfTIsUYlWflyuW4ypnvhBrslz1yJ3R+S14fdCWmSmSA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
	 <script src="/../vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script> 
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js" integrity="sha512-yDlE7vpGDP7o2eftkCiPZ+yuUyEcaBwoJoIhdXv71KZWugFqEphIS3PU60lEkFaz8RxaVsMpSvQxMBaKVwA5xg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
	
	
    <!-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/4.5.0/apexcharts.min.js" integrity="sha512-yMnvLee1a5S9nemgCoMth5YvOchnQMFMOSao/bH6SLAXZnauuHs1gd92DnE9+sVQ5aglei3LZDelg8LauSlWkw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    
	
    <!-- <script src="https://cdn.jsdelivr.net/npm/peity@3.3.0/jquery.peity.min.js"></script> -->
	<!-- <script src="/../vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script> -->
     <!-- Intégration de jQuery -->    
    <!-- -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select-country@4.2.0/dist/js/bootstrap-select-country.min.js"></script> -->

	
	
	
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js" integrity="sha512-NqYds8su6jivy1/WLoW8x1tZMRD7/1ZfhWG/jcRQLOzV1k1rIODCpMgoBnar5QXshKJGV7vi0LXLNXPoFsM5Zg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    
    <!-- <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
    <script src="/../js/plugins-init/datatables.init.js"></script> -->

	
	<script src="/../vendor/global/global.min.js"></script>
	<script src="/../vendor/chart.js/Chart.bundle.min.js"></script>
	<script src="/../vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	<script src="/../vendor/apexchart/apexchart.js"></script>
    <script src="/../vendor/peity/jquery.peity.min.js"></script>
	<script src="/../vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
	<script src="/../vendor/swiper/js/swiper-bundle.min.js"></script>
    <script src="/../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="/../js/plugins-init/datatables.init.js"></script>
	<script src="/../js/dashboard/dashboard-1.js"></script>
	<script src="/../vendor/wow-master/dist/wow.min.js"></script>
	<script src="/../vendor/bootstrap-datetimepicker/js/moment.js"></script>
	<script src="/../vendor/datepicker/js/bootstrap-datepicker.min.js"></script>
	<script src="/../vendor/bootstrap-select-country/js/bootstrap-select-country.min.js"></script>
	<script src="/../js/dlabnav-init.js"></script>
    <script src="/../js/custom.min.js"></script>
	<!-- <script src="/../../js/demo.js"></script> -->
    
	
	
</body>

