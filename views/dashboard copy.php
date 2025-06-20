<?php
$current_page = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if ($current_page == 'dashboard') {
    $message = 'Tableau de bord.';
}

$conn = Database::getInstance()->getConnection();
$atelier = new Atelier();
$produit = new Produit();
// $user = new User($conn);
$contenir = new Contenir();
$package = new Package();

$iduser = Auth::user()->iduser;
$req = User::getUserById(Database::getInstance()->getConnection(), $iduser);
$nom = Auth::user()->nomuser;
$allProductFDS = $produit->ProduitFDS($conn);
$idusine = Auth::user()->idusine;
$_SESSION['chemin'] = "dashboard";
$nomUsine = Usine::getNameById($conn, $idusine);
$isSuperAdmin = false;
$NbreProduit = 0;


if (Auth::user()->role == 'superadmin') {
    $isSuperAdmin = true;
    $NbreProduit = $produit->NbreProduits(Database::getInstance()->getConnection());
} else {
    // foreach (Contenir::NbreProduitParAtelier($conn) as $key) {
    //     echo $NbreProduit += (Contenir::AllWorkshop($conn, $key['idatelier']));
    //     echo  "<br>";
    //  }
    $NbreProduit = Contenir::AllProductOfFactory($conn, Auth::user()->idusine);
}
$_SESSION['vue'] = "dashboard";
//  die();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="DexignLab">
    <meta name="robots" content="">
    <meta name="keywords"
        content="school, school admin, education, academy, admin dashboard, college, college management, education management, institute, school management, school management system, student management, teacher management, university, university management">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" type="image/png" href="/images/favicon.png" />

    <!-- Pour Apple (optionnel mais recommandé) -->
    <link rel="apple-touch-icon" href="/images/favion.png">

    <!-- Pour navigateur Microsoft (optionnel) -->
    <meta name="msapplication-TileImage" content="/images/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/css/style.css" rel="stylesheet">
    <script src="/js/chart.umd.js"></script>
    <script src="/js/jsquery.min.js"></script>
    <link href="/vendor/wow-master/css/libs/animate.css" rel="stylesheet">
    <link href="/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/vendor/bootstrap-select-country/css/bootstrap-select-country.min.css">
    <link rel="stylesheet" href="/vendor/jquery-nice-select/css/nice-select.css">
    <link href="/vendor/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=experiment" /> -->

    <link href="/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/vendor/swiper/css/swiper-bundle.min.css">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/dashboard.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/all.css">

    <!-- <link href="/../css/style.css" rel="stylesheet"> -->


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
        <?php require_once __DIR__ . '/../layouts/nav.php'; ?>

        <?php require_once __DIR__ . '/../layouts/dlabnav.php'; ?>
        <div class="wallet-bar-close"></div>

        <div class="content-body">
            <div class="container-fluid">
                <div class="row">
                    <?php
                    if (isset($_SESSION['insert']['type']) && $_SESSION['insert']['type'] == "insertok") {
                        echo $package->message("Le produit a été ajoutée, pensez à ajouter sa FDS dès que possible", "success");
                    } elseif (isset($_SESSION['insertinfoFDS']) && $_SESSION['insertinfoFDS'] == true) {
                        echo $package->message("Le produit et sa FDS ont été ajouté", "success");
                    }
                    unset($_SESSION['insertinfoFDS'], $_SESSION['insert'])
                        ?>

                    <?php require_once __DIR__ . '/../layouts/info.php' ?>
                    <div class="col-xl-12">
                        <div class="shadow-lg page-titles">
                            <div class="d-flex align-items-center flex-wrap ">
                                <h2 class="heading">Bienvenue dans ChemSafe! <span style="color: red;">
                                        <?= $nom ?> </span>.</h2>
                                <input type="hidden" id="id_usine" value="<?= $idusine ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Calendrier -->
                    <div class="d-flex flex-column flex-lg-row">
                        <div class="col-12 col-lg-3 mb-3 mb-lg-0 wow fadeInUp" style="margin-right: 15px;"
                            data-wow-delay="1.5s">
                            <div class="shadow-lg card">
                                <div class="card-header pb-0 border-0 flex-wrap">
                                    <div>
                                        <div class="mb-0">
                                            <h2 class="heading mb-0">Calendrier de ChemSafe</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body text-center event-calender py-0 px-1">
                                    <input type='text' class="form-control d-none" id='datetimepicker1'>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-xl-12 wow fadeInUp" data-wow-delay="2s">
                                <div class="shadow-lg card">
                                    <div class="card-header border-0 ">
                                        <h4 class="heading fs-4">Maintenez le curseur sur une zone du graphe pour
                                            afficher ses informations.</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 mb-3 mb-lg-0  wow fadeInUp" data-wow-delay="2s">
                                <div class="shadow-lg card">
                                    <div class="card-header border-0 ">
                                        <h4 class="heading m-0"><?php if (Auth::user()->role == 'superadmin') { ?>Les
                                                Ateliers de ChemSafe<?php } else { ?>
                                                Atelier de l'<?= Usine::getNameById($conn, $idusine) ?>
                                            <?php } ?>
                                        </h4>

                                    </div>
                                    <div class="container">
                                        <div class="row" id="graphRow">
                                            <div class="col-12">
                                                <div class="card-body">
                                                    <canvas id="atelierChart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 p-0 wow fadeInUp" data-wow-delay="2s">
                                <div class="container" style="margin-top: 0px;">
                                    <div class="row" id="graphRow">
                                        <div class="col-md-12">
                                            <div class="card shadow-sm">
                                                <div class="card-header border-0">
                                                    <h6 class="mb-0">Répartition des dangers des produits</h6>
                                                </div>

                                                <div class="chart-container">
                                                    <canvas id="dangerChart"></canvas>
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
        </div>
    </div>

    <?php

    if (Auth::user()->role == 'superadmin') {
        require_once __DIR__ . '/../utilities/grapheSuper.php';
        echo '<script src="/js/dangerChart.js"></script>';
    } else {
        require_once __DIR__ . '/../utilities/grapheDanger.php';
        require_once __DIR__ . '/../utilities/graphedashoboard.php';
    }
    require_once __DIR__ . '/../utilities/all-js.php'
        ?>
    <!-- <script src="/../../js/demo.js"></script> -->



</body>