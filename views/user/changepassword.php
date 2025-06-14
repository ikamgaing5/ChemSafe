<?php 
// une vérfication du role doit être faite pour pouvoir choisir le type d'utilisateur à créer, si le role est admin alors il y'aura une liste déroulante pour soit un rh soit un membre de la sécurité et si le role est rh alors le type d'utilisateur sera figé sur user on va utiliser un if

?>

<?php 
    require_once __DIR__. '/../../utilities/session.php';
    $current_page = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    if (preg_match('#^change-password(?:/|$)#', $current_page)) {
        $message = 'Réinitialisation du mot de passe.';
    }
    
	
	// require_once __DIR__. '/../../models/package.php';
	require_once __DIR__. '/../../models/package.php';
	require_once __DIR__. '/../../core/connexion.php';
    require_once __DIR__. '/../../models/user.php';
	
    $conn = Database::getInstance()->getConnection();

	$package = new Package();
	$user = new User($conn);
    $token = $params['token'];
    // $reset = Token::verif($conn,$token);
    $reset = true;



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
   
    <div id="main-wrapper">

        
            
       

        <?php if($reset){ ?>
		<form onsubmit="return validForm()" action="/user/new-user" enctype="multipart/form-data" method="POST">
            <div class="content-body">
                <div class="container-fluid">
                        <?php 
                            $nomuser ="";
                            if (isset($_SESSION['insert']['type']) && $_SESSION['insert']['type'] == 1){
                                $message = "L'utilisateur <strong>". $_SESSION['insert']['info']['nom'] ."</strong> a été ajouté avec succès";
                                echo $package -> message($message,"success");
                            }elseif (isset($_SESSION['insert']['type']) && $_SESSION['insert']['type'] == 0 ){
                                $message = "L'utilisateur <strong>". $_SESSION['insert']['info']['nom'] ."</strong> existe déjà";
                                $nomuser = $_SESSION['insert']['info']['nom'];
                                echo $package -> message($message,"danger");
                            }elseif (isset($_SESSION['insert']['type']) &&  $_SESSION['insert']['type'] == -1){ 
                                $message = "Problème lors de l'insertion";
                                $nomuser = $_SESSION['insert']['info']['nom'];
                                echo $package -> message($message,"danger");
                            }
                        ?>
                    <div class="col-xl-12">
                        <div class="shadow-lg card" >
                            <div class="card-header">
                                <h5 class="mb-0">Details de l'Utilisateur</h5>
                            </div>
                            <div class="card-body" >
                                <div class="row">
                                    <div class="col-xl-6 col-sm-6">
                                        <div class="mb-3">
                                            <label style="font-weight: 700;" for="exampleFormControlInput8" class="form-label text-primary">Nom d'utilisateur<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="nomuser" name="nom" placeholder="Entrez le nom d'utilisateur" value="<?=$nomuser?>">
                                            <span id="messageNom"  class="fw-bold text-danger"></span>
                                        </div>

                                        
                                    
                                    </div>
                                    <div class="col-xl-6 col-sm-6">
                                        <div class="mb-3">
                                            <label style="font-weight: 700;" for="exampleFormControlInput8" class="form-label text-primary">Mot de passe<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="password" name="password" placeholder="Entrez le mot de passe" maxlenght="6">
                                            <span id="messageMdp"  class="fw-bold text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="text-end ">
                                    <button type="submit"  id="submitBtn" class="btn btn-primary" >Soumettre</button>
                                </div>   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
	    </form>
	   <?php }else{ ?>
       <div class="col-xl-12">
            <div class="shadow-lg card" >
                <div class="card-header">
                    <h5 class="mb-0">Details de l'Utilisateur</h5>
                </div>
                <div class="card-body" >
                    Le lien a expiré
                </div>
            </div>
        </div>
        <?php } ?>
	</div>
<?php unset($_SESSION['insert']) ?>


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
    <script src="/../../js/new-user.js"></script>
