<?php
// require_once __DIR__. '/../../utilities/session.php';


// // require_once __DIR__. '/../../core/connexion.php';
// require_once __DIR__. '/../../models/atelier.php';
// require_once __DIR__. '/../../models/produit.php';
// require_once __DIR__. '/../../models/contenir.php';
// require_once __DIR__. '/../../models/connexion.php';
// require_once __DIR__. '/../../models/package.php';

$conn = Database::getInstance()->getConnection();


// $conn = getConnection();
$atelier = new Atelier();
$produit = new Produit();
$contenir = new Contenir();
$package = new Package();
// $idatelier = $_GET['workshop'];
// $idatelier = $params['idatelier'];

// $nomatelier = $atelier ->getName($conn,$idatelier);
$idusine = Auth::user()->idusine;
$current_page = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if (strpos($current_page, 'product/all-product') === 0) {
    $message = "Produits de l'" . Usine::getNameById($conn, $_SESSION['idusine']);
    $chemin = "product/all-product";
}

// $produitsNonAssocies =$produit->getProduitsNonAssocies($conn, $idatelier);

if (isset($_SESSION['add-success']) && $_SESSION['add-success']['type'] == true && isset($_SESSION['add-success']['info'])) {
    $prodAdd = $_SESSION['add-success']['info']['produit'];
    $nombre = count($prodAdd);

    $nom = "";
    if (is_array($prodAdd)) {
        foreach ($prodAdd as $key) {
            $nomm = $produit->getNameById($conn, $key);
            $nom .= $nomm . ", ";
        }
    }
}

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 20; // Nombre de produits par page
$offset = ($page - 1) * $limit;

$produits = $produit->getProduitByWorkshops($conn, $limit, $offset);
$total_produits = $produit->countProduits($conn);
$total_pages = ceil($total_produits / $limit);

$parAtelier = [];
$communs = [];
foreach ($produits as $key) {
    if ($key['nb_ateliers'] > 1) {
        $communs[] = $key;
    } else {
        $ateliers = $key['ateliers'];
        if (!isset($parAtelier[$ateliers])) {
            $parAtelier[$ateliers] = [];
        }
        $parAtelier[$ateliers][] = $key;
    }
}

// $_SESSION['idatelier'] = IdEncryptor::encode($idatelier);


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="shortcut icon" type="image/png" href="images/favicon.png" > -->
    <link href="/vendor/wow-master/css/libs/animate.css" rel="stylesheet" media="print" onload="this.media='all'">
    <link href="/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" media="print"
        onload="this.media='all'">
    <link rel="stylesheet" href="/vendor/bootstrap-select-country/css/bootstrap-select-country.min.css" media="print"
        onload="this.media='all'">
    <link rel="stylesheet" href="/vendor/jquery-nice-select/css/nice-select.css" media="print"
        onload="this.media='all'">
    <link href="/vendor/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" media="print"
        onload="this.media='all'">

    <link rel="stylesheet"  href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=experiment"
        media="print" onload="this.media='all'">

    <link href="/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet" media="print"
        onload="this.media='all'">

    <link rel="stylesheet" href="/vendor/swiper/css/swiper-bundle.min.css" media="print" onload="this.media='all'">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        media="print" onload="this.media='all'">
    <link href="/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/all.css">
    <script src="/js/all.js" defer></script>

</head>

<?php if (isset($_SESSION['insert']['openModal'])): ?>
<script>
$(document).ready(function() {
    $('#modalFDS<?= $_SESSION['insert']['openModal'] ?>').modal('show');
});
</script>
<?php
    unset($_SESSION['insert']['openModal']); // pour ne pas réouvrir à chaque reload
endif; ?>



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

        <?php require_once __DIR__ . '/../../layouts/navbar.php' ?>

        <?php require_once __DIR__ . '/../../layouts/dlabnav.php'; ?>

        <div class="content-body">

            <!-- container starts -->
            <div class="container-fluid">
                <?php
                if (isset($_SESSION['info']['type']) && $_SESSION['info']['type'] == 'deletesuccess') {
                    $message = "Le produit <strong> " . $_SESSION['info']['nomprod'] . "</strong> et ses fichiers ont été supprimé de l'atelier <strong> " . $_SESSION['info']['nomatelier'] . "</strong>";
                    $type = "danger";
                    echo $package->message($message, "success");
                    unset($_SESSION['info']);
                } elseif (isset($_SESSION['info']['type']) && $_SESSION['info']['type'] == 'deletefailed') {
                    $message = "Un problème est survenu lors de la suppression";
                    echo $package->message($message, "danger");
                    unset($_SESSION['info']);
                } elseif (isset($_SESSION['info']['type']) && $_SESSION['info']['type'] == 'doublonsFDS') {
                    $message = "Fichier trop volumineux";
                    echo $package->message($message, "danger");
                    unset($_SESSION['info']);
                } elseif (isset($_SESSION['add-success']['type']) && $_SESSION['add-success']['type'] == true) {
                    if ($nombre > 1) {
                        $message = "Les produits $nom ont été ajouté avec succès";
                    } else {
                        $message = "Le produit $nom a été ajouté avec succès";
                    }

                    echo $package->message($message, "success");
                    unset($_SESSION['add-success']);
                }
                ?>
                <div class="demo-view">
                    <div class="col-xl-12">
                        <div class="shadow-lg page-title flex-wrap d-none d-xl-block">
                            <!-- Ajout des classes de visibilité -->
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                <div>
                                    <u><a class="text-primary fw-bold fs-5" href="/dashboard">Tableau de bord</a></u>
                                    <i class="bi bi-caret-right-fill"></i>
                                    <span class="card-title fw-bold fs-5">
                                        Tous nos produits
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="shadow-lg page-title d-xl-none text-center py-2">
                            <u><a href="/workshop/all-workshop" class="text-primary fw-bold fs-5"><i
                                        class="bi bi-caret-right-fill"></i>
                                    Nos Ateliers
                                </a></u>
                        </div>
                    </div>

                    <?php if (count($communs) > 0): ?>
                    <div class="container-fluid pt-0 ps-0  pe-0">
                        <div class="shadow-lg card" id="accordion-one">
                            <div class="card-header flex-wrap px-3">
                                <div>
                                    <h6 class="card-title">Produits / Liste des Produits</h6>
                                    <p class="m-0 subtitle">Ici vous pouvez voir tous les produits enregistrés dans
                                        plusieurs ateliers </p>
                                </div>
                            </div>
                            <div class="tab-content" id="myTabContent">
                                <div class="container-fluid pt-0 ps-0 pe-0">
                                    <div class="shadow-lg card" id="accordion-one">
                                        <div class="table-responsive">
                                            <table id="basic-btn" class="display table table-striped"
                                                style="min-width: 845px">
                                                <thead>
                                                    <tr>
                                                        <th>Nom du produit</th>
                                                        <th>Type d'emballage</th>
                                                        <th>Vol/Poids</th>
                                                        <th>Plus d'info</th>
                                                        <th>Médias</th>
                                                        <th>Ateliers</th>
                                                        <?php if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin') { ?>
                                                        <th class="text-end">Action</th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($communs as $prod) { ?>
                                                    <tr>
                                                        <td>
                                                            <div class="trans-list">
                                                                <?php
                                                                        // echo "<img src='./upload/".$row['name']."' alt='' class='avatar me-3'>";
                                                                        ?>
                                                                <h4><?= $prod['nomprod'] ?></h4>
                                                            </div>
                                                        </td>
                                                        <td><span
                                                                class="text-primary font-w600"><?= $prod['type_emballage'] ?></span>
                                                        </td>
                                                        <td>
                                                            <div class="mb-0"><?= $prod['poids'] ?></div>
                                                        </td>

                                                        <td><a href="/product/more-detail/<?= IdEncryptor::encode($prod['idprod']) ?>"
                                                                class="btn btn-secondary shadow btn-xs sharp me-1"><i
                                                                    class="bi bi-info-circle-fill"></i></a></td>

                                                        <td>
                                                            <div class="d-flex">
                                                                <?php require __DIR__ . '/photo.php' ?>
                                                                <?php require __DIR__ . '/fds.php' ?>
                                                            </div>
                                                        </td>
                                                        <td><span
                                                                class="text-primary font-w600"><?= $prod['ateliers'] ?></span>
                                                        </td>
                                                        <?php if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin') { ?>
                                                        <td>
                                                            <div class="d-flex">
                                                                <a href="/product/edit-product/<?= IdEncryptor::encode($prod['idprod']) ?>"
                                                                    class="btn btn-primary shadow btn-xs sharp me-1">
                                                                    <i class="bi bi-pencil-square"></i>
                                                                </a>
                                                                <?php require __DIR__ . '/deleteall.php'; ?>
                                                            </div>
                                                        </td>
                                                        <?php } ?>


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


                    <?php endif; ?>

                    <?php foreach ($parAtelier as $key => $liste) { ?>
                    <div class="container-fluid pt-0 ps-0 pe-0">
                        <div class="shadow-lg card" id="accordion-one">
                            <div class="card-header flex-wrap ">
                                <div>
                                    <h6 class="card-title">Produits / Liste des Produits</h6>
                                    <p class="m-0 subtitle">Ici vous pouvez voir tous les produits enregistrés dans
                                        l'atelier <strong><?= $key ?></strong></p>
                                </div>
                                <div class="d-flex">
                                    <ul class="nav nav-tabs dzm-tabs" id="myTab" role="tablist">
                                        <li class="nav-item " role="presentation">
                                            <div class="d-flex">

                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--tab-content-->
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="Preview" role="tabpanel"
                                    aria-labelledby="home-tab">
                                    <div class="shadow-lg card-body p-0">
                                        <div class="table-responsive">
                                            <table id="basic-btn" class="display table table-striped"
                                                style="min-width: 845px">
                                                <thead>
                                                    <tr>
                                                        <th>Nom du produit</th>
                                                        <th>Type d'emballage</th>
                                                        <th>Vol/Poids</th>
                                                        <th>Plus d'info</th>
                                                        <th>Médias</th>
                                                        <?php if (Auth::user()->role == 'admin') { ?>
                                                        <th class="text-end">Action</th>
                                                        <?php } ?>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($liste as $prod) { ?>
                                                    <tr>
                                                        <td>
                                                            <div class="trans-list">
                                                                <h4><?= $prod['nomprod'] ?></h4>
                                                            </div>
                                                        </td>
                                                        <td><span
                                                                class="text-primary font-w600"><?= $prod['type_emballage'] ?></span>
                                                        </td>
                                                        <td>
                                                            <div class="mb-0"><?= $prod['poids'] ?></div>
                                                        </td>
                                                        <td><a href="/product/more-detail/<?= IdEncryptor::encode($prod['idprod']) ?>"
                                                                class="btn btn-secondary shadow btn-xs sharp me-1"><i
                                                                    class="bi bi-info-circle-fill"></i></a></td>
                                                        <td>
                                                            <div class="d-flex">
                                                                <?php require __DIR__ . '/photo.php' ?>
                                                                <?php require __DIR__ . '/fds.php' ?>
                                                            </div>
                                                        </td>
                                                        <?php if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin') { ?>
                                                        <td class="d-flex">
                                                            <a href="/product/edit-product/<?= IdEncryptor::encode($prod['idprod']) ?>"
                                                                class="btn btn-primary shadow btn-xs sharp me-1">
                                                                <i class="bi bi-pencil-square"></i>
                                                            </a>
                                                            <?php require __DIR__ . '/deleteall.php'; ?>

                                                        </td>
                                                        <?php } ?>


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
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>

    <!-- <script src="/vendor/global/global.min.js"></script>
    <script src="/vendor/chart.js/Chart.bundle.min.js"></script>
    <script src="/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="/vendor/apexchart/apexchart.js"></script>
    <script src="/vendor/peity/jquery.peity.min.js"></script>
    <script src="/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
    <script src="/vendor/swiper/js/swiper-bundle.min.js"></script>
    <script src="/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="/js/plugins-init/datatables.init.js"></script>
    <script src="/js/dashboard/dashboard-1.js"></script>
    <script src="/vendor/wow-master/dist/wow.min.js"></script>
    <script src="/vendor/bootstrap-datetimepicker/js/moment.js"></script>
    <script src="/vendor/datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="/vendor/bootstrap-select-country/js/bootstrap-select-country.min.js"></script>
    <script src="/js/dlabnav-init.js"></script>
    <script src="/js/custom.min.js"></script>
    <script src="/js/demo.js"></script> -->
    <?php require_once __DIR__ . '/../../utilities/all-js.php' ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let produit = document.getElementById('produit');
        let submitBtn = document.getElementById('submitBtn');
        let messageProduit = document.getElementById('messageProduit');


        function validateSelection() {
            const selectedProduit = Array.from(produit.selectedOptions).map(option => option.value);
            const isValidProduit = selectedProduit.length > 0 && !selectedProduit.includes("none");

            if (isValidProduit) {
                submitBtn.disabled = false;
                messageProduit.style.display = 'none';
            } else {
                submitBtn.disabled = true;
                messageProduit.style.display = 'block';
                messageProduit.textContent = 'Veuillez sélectionner au moins un produit.';
            }
        }

        // Écouteur d'événement
        produit.addEventListener('change', validateSelection);

        // Validation initiale au chargement
        validateSelection();
    });
    </script>