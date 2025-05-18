<?php


$conn = Database::getInstance()->getConnection();


// $conn = getConnection();
$atelier = new Atelier();
$produit = new Produit();
$contenir = new Contenir();
$package = new Package();
// $idatelier = $_GET['workshop'];
// $idatelier = $params['idatelier'];

$nomatelier = $atelier->getName($conn, $idatelier);

$current_page = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if (strpos($current_page, 'all-product') === 0) {
    $message = "Produits de l'atelier $nomatelier.";
    $chemin = "/all-products/" . IdEncryptor::encode($idatelier);
}

$produitsNonAssocies = $produit->getProduitsNonAssocies($conn, $idatelier);

if (isset($_SESSION['add-success']) && $_SESSION['add-success']['type'] == true) {
    $prodAdd = $_SESSION['add-success']['info']['produit'];
    $nombre = count($prodAdd);

    $noms = "";
    if (is_array($prodAdd)) {
        foreach ($prodAdd as $key) {
            $nomm = $produit->getNameById($conn, $key);
            $noms .= $nomm . ", ";
        }
    }
}

$_SESSION['idatelier'] = IdEncryptor::encode($idatelier);


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

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=experiment" />

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
        <?php require_once __DIR__ . '/../../layouts/navbar.php' ?>

        <?php require_once __DIR__ . '/../../layouts/dlabnav.php'; ?>

        <div class="content-body">
            <!-- container starts -->
            <div class="container-fluid">
                <?php
                if (isset($_SESSION['info']['type']) && $_SESSION['info']['type'] === 'deletesuccess') {
                    $message = "Le produit <strong> " . $_SESSION['info']['nomprod'] . "</strong> et ses fichiers ont été supprimé de l'atelier <strong> " . $_SESSION['info']['nomatelier'] . "</strong>";
                    $type = "danger";
                    echo $package->message($message, "success");
                    unset($_SESSION['info']);
                } elseif (isset($_SESSION['info']['type']) && $_SESSION['info']['type'] === 'deletefailed') {
                    $message = "Un problème est survenu lors de la suppression";
                    echo $package->message($message, "danger");
                    unset($_SESSION['info']);
                } elseif (isset($_SESSION['add-success']['type']) && $_SESSION['add-success']['type'] === true) {
                    if ($nombre > 1) {
                        $message = "Les produits $noms ont été ajouté avec succès";
                    } else {
                        $message = "Le produit $noms a été ajouté avec succès";
                    }
                    echo $package->message($message, "success");
                    unset($_SESSION['add-success']);
                } elseif (isset($_SESSION['add-fds']) && $_SESSION['add-fds'] === true) {
                    $message = "La FDS a été ajoutée avec succès";
                    echo $package->message($message, "success");
                    unset($_SESSION['add-fds']);
                } elseif (isset($_SESSION['add-fds']) && $_SESSION['add-fds'] === false) {
                    $message = "Problème lors de l'insertion de la FDS";
                    echo $package->message($message, "danger");
                    unset($_SESSION['add-fds']);
                } elseif (isset($_SESSION['insertinfoFDS']) && $_SESSION['insertinfoFDS'] === true) {
                    $message = "Les informations de la FDS ont été enregistrée";
                    echo $package->message($message, "success");
                    unset($_SESSION['insertinfoFDS']);
                }
                if (isset($_SESSION['addphoto'])) {
                    switch ($_SESSION['addphoto']['erreur']) {
                        case 'taille':
                            $message = "La taille de la photo envoyée pour le produit <strong>" . $_SESSION['addphoto']['nomproduit'] . "</strong> dépasse la limite qui est de 5 Mo";
                            $type = "danger";
                            break;
                        case 'nom':
                            $message = "La photo envoyée pour le produit<strong>" . $_SESSION['addphoto']['nomproduit'] . "</strong> est déjà associée à un autre produit";
                            $type = "danger";
                            break;
                        case 'extension':
                            $message = "L'extension de la photo envoyée pour le produit<strong>" . $_SESSION['addphoto']['nomproduit'] . "</strong> n'est pas prise en charge";
                            $type = "danger";
                            break;
                        case 'erreur':
                            $message = "Une erreur est survenué lors de l'envoie de la photo envoyée pour le produit<strong>" . $_SESSION['addphoto']['nomproduit'] . "</strong>, veuillez réesayer";
                            $type = "danger";
                            break;
                        default:
                            $message = "La photo envoyée pour le produit <strong>" . $_SESSION['addphoto']['nomproduit'] . "</strong> a été enregistrée avec succès";
                            $type = "success";
                            break;
                    }
                    echo $package->message($message, $type);
                }
                ?>


                <div class="demo-view">
                    <div class="col-xl-12">
                        <div class="shadow-lg page-title flex-wrap d-none d-xl-block">
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                <div>
                                    <u><a class="text-primary fw-bold fs-5" href="/dashboard">Tableau de bord</a></u>
                                    <i class="bi bi-caret-right-fill"></i>
                                    <u><a href="/workshop/all-workshop/<?= IdEncryptor::encode(Auth::user()->idusine) ?>"
                                            class="text-primary fw-bold fs-5">Nos Ateliers</a></u>
                                    <i class="bi bi-caret-right-fill"></i>
                                    <span class="card-title fw-bold fs-5">
                                        <?php if (isset($_SESSION['idatelier']))
                                            echo $nomatelier; ?>
                                    </span>
                                </div>
                            </div>

                            <div class="shadow-lg page-title d-xl-none text-center py-2">

                                <u><a href="/workshop/all-workshop" class="text-primary fw-bold fs-5"><i
                                            class="bi bi-caret-right-fill"></i>
                                        Nos Ateliers
                                    </a></u>
                            </div>
                        </div>

                        <div class="row" id="graphRow" style="display: none;">
                            <div class="col-xl-8 col-md-8 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Répartition Des Dangers Par Produit</h4>
                                        <canvas id="dangerChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4 col-sm-12 mt-sm-3 mt-md-0">
                                <div class="content-box">
                                    <div id="customLegend" class="custom-legend"></div>
                                </div>
                            </div>
                        </div>


                        <div id="dangersList" style="display: none;" class="card mt-3">
                            <div class="card-body">
                                <h4 class="card-title">Liste des dangers et nombre de produits concernés</h4>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Danger</th>
                                                <th class="text-center">Nombre de Produits</th>
                                            </tr>
                                        </thead>
                                        <tbody id="dangersListBody">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="container-fluid pt-0 ps-0  pe-0">
                            <div class="shadow-lg card" id="accordion-one">
                                <div class="card-header flex-wrap px-3">
                                    <div>
                                        <h6 class="card-title">Produits / Liste des Produits</h6>
                                        <p class="m-0 subtitle">Ici vous pouvez voir tous les produits enregistrés dans
                                            l'atelier <strong><?= $nomatelier ?></strong></p>
                                    </div>
                                    <div class="d-flex">
                                        <ul class="nav nav-tabs dzm-tabs" id="myTab" role="tablist">

                                            <li class="nav-item " role="presentation">

                                                <div class="d-flex">
                                                    <button type="submit" name="supprimeretudiant"
                                                        class="btn btn-danger" value="tout supprimer">tout supprimer
                                                    </button>
                                                    <?php require_once __DIR__ . '/add-product.php'; ?>
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

                                                        <?php
                                                        $produitParAtelier = $contenir->getProduitByAtelier($conn, $idatelier);
                                                        if (count($produitParAtelier) <= 0) { ?>
                                                            <tr>
                                                                <td colspan='6'>Aucun produit enregistré. </td>
                                                            </tr>
                                                        <?php } else {
                                                            foreach ($produitParAtelier as $keys) {
                                                                $prod = $produit->OneProduct($conn, $keys['idprod']);
                                                                ?>
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
                                                                    <?php if (Auth::user()->role == 'admin') { ?>
                                                                        <td>
                                                                            <div class="d-flex">
                                                                                <?php require __DIR__ . '/delete.php' ?>
                                                                            </div>
                                                                        </td>
                                                                    <?php } ?>


                                                                </tr>
                                                            <?php }
                                                        } ?>
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
            </div>
        </div>
    </div>

    <?php require_once __DIR__ . '/../../utilities/all-js.php' ?>
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
    <script>

        document.addEventListener('DOMContentLoaded', function () {
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
    <script>
        $(function () {
            // Vérifier si l'appareil est mobile
            const isMobile = window.innerWidth < 768;

            // Récupérer l'ID de l'atelier depuis la page
            const idatelier = '<?php echo $idChiffre; ?>';

            // Appel AJAX pour récupérer les données
            $.ajax({
                url: '/api/product/dangers/' + idatelier,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Vérifier s'il y a au moins 3 dangers différents
                    if (data.length >= 3) {
                        // Afficher la ligne du graphique
                        $('#graphRow').show();
                        // Rendre le graphique
                        renderDangerChart(data);
                    } else {
                        // Afficher la liste des dangers si moins de 3 dangers
                        $('#dangersList').show();
                        renderDangersList(data);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Erreur lors de la récupération des données:', error);
                    // Afficher un message d'erreur
                    $('<div class="alert alert-danger mt-3">Erreur lors du chargement des données</div>').insertAfter('#graphRow');
                }
            });

            // Fonction pour afficher la liste des dangers
            function renderDangersList(data) {
                const tableBody = $('#dangersListBody');
                tableBody.empty();

                // Trier les données par nombre de produits (décroissant)
                data.sort((a, b) => b.count - a.count);

                // Créer une ligne pour chaque danger
                data.forEach(item => {
                    const row = $('<tr>');
                    const dangerCell = $('<td>').text(item.nomdanger);
                    const countCell = $('<td class="text-center">').text(item.count);

                    // Ajouter un attribut title avec la liste des produits
                    if (item.products && item.products.length > 0) {
                        const productsList = item.products.join(', ');
                        row.attr('title', 'Produits: ' + productsList);

                        // Ajouter une classe pour indiquer qu'il y a une info-bulle
                        row.addClass('has-tooltip');

                        // Initialiser tooltip Bootstrap si disponible
                        if ($.fn.tooltip) {
                            row.tooltip({
                                placement: 'top',
                                html: true,
                                template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner text-start" style="max-width: 300px;"></div></div>',
                                title: function () {
                                    let content = '<strong>Produits concernés:</strong>';
                                    item.products.forEach(product => {
                                        content += `- ${product}<br>`;
                                    });
                                    return content;
                                }
                            });
                        }
                    }

                    row.append(dangerCell);
                    row.append(countCell);
                    tableBody.append(row);
                });
            }

            function renderDangerChart(data) {
                // Code du graphique identique à celui précédemment fourni
                const labels = data.map(item => item.nomdanger);
                const counts = data.map(item => item.count);
                const backgroundColors = generateColors(data.length, 0.6);
                const borderColors = generateColors(data.length, 1);

                const chartData = {
                    labels: isMobile ? labels.map(label => abbreviateLabel(label)) : labels,
                    datasets: [{
                        label: 'Nombre de produits',
                        data: counts,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 1
                    }]
                };

                const options = {
                    responsive: true,
                    maintainAspectRatio: !isMobile,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                font: {
                                    size: isMobile ? 10 : 12
                                }
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: isMobile ? 8 : 12
                                },
                                maxRotation: isMobile ? 90 : 0,
                                minRotation: isMobile ? 45 : 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                title: function (context) {
                                    return labels[context[0].dataIndex];
                                },
                                label: function (context) {
                                    const dataIndex = context.dataIndex;
                                    const danger = data[dataIndex];

                                    // Afficher le nombre total de produits
                                    const result = [`Total: ${danger.count} produit(s)`];

                                    // Ajouter la liste des produits
                                    if (danger.products && danger.products.length > 0) {
                                        result.push('');
                                        result.push('Produits concernés:');
                                        danger.products.forEach(product => {
                                            result.push(`- ${product}`);
                                        });
                                    }

                                    return result;
                                }
                            }
                        }
                    }
                };

                var ctx = document.getElementById('dangerChart').getContext('2d');
                var dangerChart = new Chart(ctx, {
                    type: 'bar',
                    data: chartData,
                    options: options
                });

                // Générer la légende personnalisée
                generateCustomLegend(labels, backgroundColors);
            }

            // Fonction pour abréger les étiquettes sur mobile
            function abbreviateLabel(label) {
                if (isMobile) {
                    if (label.length > 10) {
                        return label.substring(0, 7) + '...';
                    }
                }
                return label;
            }

            function generateColors(count, alpha) {
                const colors = [];
                const hueStep = 360 / count;

                for (let i = 0; i < count; i++) {
                    const hue = i * hueStep;
                    colors.push(`hsla(${hue}, 70%, 60%, ${alpha})`);
                }

                return colors;
            }

            function generateCustomLegend(labels, colors) {
                const legendContainer = document.getElementById('customLegend');

                // Titre de la légende
                legendContainer.innerHTML = '<h5 class="legend-title">Légende</h5>';

                // Sur mobile, utiliser un affichage horizontal
                if (isMobile) {
                    legendContainer.classList.add('mobile-legend');
                }

                // Créer les éléments de légende
                labels.forEach((label, index) => {
                    const legendItem = document.createElement('div');
                    legendItem.className = 'legend-item';

                    const colorBox = document.createElement('div');
                    colorBox.className = 'legend-color';
                    colorBox.style.backgroundColor = colors[index];

                    const labelText = document.createElement('span');
                    labelText.className = 'legend-text';
                    labelText.textContent = label;

                    legendItem.appendChild(colorBox);
                    legendItem.appendChild(labelText);
                    legendContainer.appendChild(legendItem);
                });
            }
        });
    </script>
</body>

</html>