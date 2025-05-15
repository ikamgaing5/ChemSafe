<?php 
    require_once __DIR__. '/../../utilities/session.php';


    // require_once __DIR__. '/../../core/connexion.php';

    // require_once __DIR__. '/../../models/connexion.php';
    require_once __DIR__. '/../../models/package.php';
    require_once __DIR__. '/../../models/user.php';
    // require_once __DIR__. '/../../models/historique.php';
    
    $conn = Database::getInstance()->getConnection();


    $user = new User();
    $package = new Package();
    // $historique = new Historique();

    $current_page = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    if ($current_page == 'history/user') {
        $message = 'Historique de Connexion.';
    }

    // $allUser = Historique::getAllIdUser($conn);
    $allUser = historique_acces::GetID($conn);

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

        <link rel="stylesheet" href="/css/style.css">
        <link rel="stylesheet" href="/css/all-product.css">
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
                <!-- container starts -->
                <div class="container-fluid">
                    <div class="demo-view">
                    <?php  
                        foreach ($allUser as $keys) {
                            $key = historique_acces::SelectOne($conn,$keys['iduser']);
                            // var_dump($key);
                                
                    ?>
                        <div class="col-xl-12">
                            <div class="container-fluid pt-0 ps-0  pe-0">		
                                <div class="shadow-lg card" id="accordion-one">
                                    <div class="card-header flex-wrap px-3">
                                        <div>
                                            <h6 class="card-title">Historique / Historique d'accès à ChemSafe</h6>
                                            <p class="m-0 subtitle">Ici vous pouvez voir toutes les connexions à ChemSafe</p>
                                        </div>
                                    </div>
                                    <!--tab-content-->
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="Preview" role="tabpanel" aria-labelledby="home-tab">
                                            <div class="shadow-lg card-body p-0">
                                                <div class="table-responsive">
                                                    <table id="basic-btn"  class="display table table-striped" style="min-width: 845px">
                                                        <thead>
                                                            <tr>
                                                                <th>Nom de l'utilisateur</th>
                                                                <th>Date</th>
                                                                <th>Heure</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php 
                                                            foreach ($key as $value) {
                                                                $nomss = $user->getOne($conn,$keys['iduser']);
                                                                $temps = strtotime($value['time']);
                                                        ?>
                                                            
                                                           
                                                            <tr>
                                                                <td>
                                                                    <div class="trans-list">
                                                                        <h4><?=$nomss['nomuser']?></h4>
                                                                    </div>
                                                                </td>
                                                                <td><span class="text-primary font-w600"><?= $package->afficheDate($value['created_at'])?></span></td>
                                                                
                                                                <td><span class="text-primary font-w600"><?=date('H\hi', $temps)?></span></td>
                                                                <td>
                                                                    <div class="mb-0"><?=$value['action']?></div>
                                                                </td>
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
                    <?php } ?>
                    </div>			
                </div>
            </div>
        </div>
    </body>

        <?php 
		require_once __DIR__. '/../../utilities/all-js.php';