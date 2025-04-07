<?php 
    require_once __DIR__. '/../../utilities/session.php';


    // require_once __DIR__. '/../../core/connexion.php';
    require_once __DIR__. '/../../models/atelier.php';
    require_once __DIR__. '/../../models/produit.php';
    require_once __DIR__. '/../../models/contenir.php';
    require_once __DIR__. '/../../models/connexion.php';
    require_once __DIR__. '/../../models/package.php';
    
    $conn = Database::getInstance()->getConnection();


    // $conn = getConnection();
    $atelier = new Atelier();
    $produit = new Produit();
    $contenir = new Contenir();
    $package = new Package();
    // $idatelier = $_GET['workshop'];
    // $idatelier = $params['idatelier'];

    $nomatelier = $atelier ->getName($conn,$idatelier);

    $current_page = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    if (strpos($current_page, 'all-product') === 0) {
        $message = "Produits de l'atelier $nomatelier.";
    }

    $produitsNonAssocies =$produit->getProduitsNonAssocies($conn, $idatelier);

    if (isset($_SESSION['add-success']) && $_SESSION['add-success']['type'] == true && isset($_SESSION['add-success']['info'])) {
        $prodAdd = $_SESSION['add-success']['info']['produit'];
        $nombre = count($prodAdd);
       
        $nom = ""; 
        if (is_array($prodAdd)) {
            foreach ($prodAdd as $key) {
                $nomm = $produit->getNameById($conn, $key);
                $nom .= $nomm.", ";
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

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=experiment" />
        
        <!-- <link href="/../../vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet"> -->
        
        <link rel="stylesheet" href="/../../vendor/swiper/css/swiper-bundle.min.css">
        
        

         <link rel="stylesheet" href="/css/style.css">
         <link rel="stylesheet" href="/css/all-product.css">
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

            
            <?php require_once __DIR__. '/../../layouts/navbar.php' ?>
                
            <?php require_once __DIR__. '/../../layouts/dlabnav.php'; ?>

            <div class="content-body"> 
                <!-- container starts -->
                <div class="container-fluid">
                    
                    <?php 
                    if (isset($_SESSION['info']['type']) && $_SESSION['info']['type'] = 'deletesuccess') {
                        $message = "Le produit <strong> ".$_SESSION['info']['nomprod']."</strong> et ses fichiers ont été supprimé de l'atelier <strong> ".$_SESSION['info']['nomatelier']."</strong>";
                                $type = "danger";
                                echo $package -> message($message,"success");
                                unset($_SESSION['info']);
                    }elseif (isset($_SESSION['info']['type']) && $_SESSION['info']['type'] = 'deletefailed') {
                        $message = "Un problème est survenu lors de la suppression";
                        echo $package -> message($message,"danger");
                        unset($_SESSION['info']);
                    }elseif (isset( $_SESSION['add-success']['type'] ) &&  $_SESSION['add-success']['type']  = true) {
                        if ($nombre>1) {
                            $message = "Les produits $nom ont été ajouté avec succès";
                        }else {
                            $message = "Le produit $nom a été ajouté avec succès";
                        }
                        
                        echo $package -> message($message,"success");
                        unset($_SESSION['add-success']);
                    }
                    ?>

                    <div class="demo-view">
                        <div class="col-xl-12">
                            <div class="shadow-lg page-title flex-wrap d-none d-xl-block">
                                <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                    <div>
                                        <u><a class="text-primary fw-bold fs-5" href="/dashboard">Tableau de bord</a></u>
                                        <i class="bi bi-caret-right-fill"></i>
                                        <u><a href="/workshop/all-workshop" class="text-primary fw-bold fs-5">Nos Ateliers</a></u>
                                        <i class="bi bi-caret-right-fill"></i>
                                        <span  class="card-title fw-bold fs-5">
                                            <?php if (isset($_SESSION['idatelier'])) echo $nomatelier; ?>
                                        </span>
                                    </div>
                                </div>
                
                                <div class="shadow-lg page-title d-xl-none text-center py-2">
                                
                                    <u><a href="/workshop/all-workshop" class="text-primary fw-bold fs-5"><i class="bi bi-caret-right-fill"></i>
                                        Nos Ateliers
                                    </a></u>
                                </div>
                            </div>

                            <div class="row">
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

                            <div class="container-fluid pt-0 ps-0 pe-lg-4 pe-0">		
                                <div class="shadow-lg card" id="accordion-one">
                                    <div class="card-header flex-wrap px-3">
                                        <div>
                                            
                                            <h6 class="card-title">Produits / Liste des Produits</h6>
                                            <p class="m-0 subtitle">Ici vous pouvez voir tous les produits enregistrés dans l'atelier <strong><?=$nomatelier?></strong></p>
                                        </div>
                                        <div class="d-flex">
                                            
                                            
                                                <ul class="nav nav-tabs dzm-tabs" id="myTab" role="tablist">
                                                
                                                    <li class="nav-item " role="presentation">
                                                        
                                                        <div class="d-flex">
                                                            <button type="submit" name="supprimeretudiant" class="btn btn-danger" value="tout supprimer" >tout supprimer	</button>
                                                            <?php require_once __DIR__.'/add-product.php'; ?>
                                                        </div>
                                                        
                                                    
                                                    </li>

                                                
                                                </ul>
                                        
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
                                                                <th>Nom du produit</th>
                                                                <th>Type d'emballage</th>
                                                                <th>Vol/Poids</th>
                                                                <th>Plus d'info</th>
                                                                <th>Médias</th>
                                                                <?php if (isset( $_SESSION['log']['type']) && $_SESSION['log']['type'] == 'admin') { ?>
                                                                    <th class="text-end">Action</th>    
                                                                <?php   } ?>
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php 
                                                                $produitParAtelier = $contenir -> getProduitByAtelier($conn, $idatelier);
                                                                if (count($produitParAtelier) <= 0) { ?>
                                                                <tr>
                                                                        <td colspan='6'>Aucun résultat trouvé</td>
                                                                    </tr>
                                                            <?php  }else {
                                                                foreach ($produitParAtelier as $keys) {
                                                                    $prod = $produit -> OneProduct($conn, $keys['idprod']);
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="trans-list">
                                                                        <?php	
                                                                        // echo "<img src='./upload/".$row['name']."' alt='' class='avatar me-3'>";
                                                                            ?>
                                                                        <h4><?=$prod['nomprod']?></h4>
                                                                    </div>
                                                                </td>
                                                                <td><span class="text-primary font-w600"><?=$prod['type_emballage']?></span></td>
                                                                <td>
                                                                    <div class="mb-0"><?=$prod['poids']?></div>
                                                                </td>
                                                                <td><a href="/product/more-detail/<?=IdEncryptor::encode($prod['idprod'])?>" class="btn btn-secondary shadow btn-xs sharp me-1"><i class="bi bi-info-circle-fill"></i></a></td>
                                                                <td>
                                                                    <div class="d-flex">
                                                                        <?php require __DIR__. '/photo.php'?>
                                                                        <?php require __DIR__. '/fds.php'?>
                                                                    </div>
                                                                </td>
                                                                <?php if (isset( $_SESSION['log']['type']) && $_SESSION['log']['type'] == 'admin') { ?>
                                                                    <td>
                                                                        <div class="d-flex">
                                                                            <a href="/product/edit-product/<?=IdEncryptor::encode($prod['idprod'])?>" class="btn btn-primary shadow btn-xs sharp me-1">
                                                                                <i class="fa fa-pencil"></i>
                                                                            </a>
                                                                            <?php require __DIR__. '/delete.php' ?>
                                                                        </div>
                                                                    </td>
                                                                <?php } ?>
                                                    

                                                            </tr>
                                                            <?php }} ?>
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
    </body>
	<!-- <script src="/../../vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script> -->

    <script src="/vendor/chart.js/Chart.bundle.min.js"></script>

    <script src="/vendor/global/global.min.js"></script>
    <script src="/js/dlabnav-init.js"></script>
    <script src="/js/cha.js"></script>
    <script src="/js/chartt.js"></script>
    <script src="/js/custom.min.js"></script>
    <!-- <script src="/../../js/chart.js"></script> -->
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
    <script>
    $(function() {
        // Vérifier si l'appareil est mobile
        const isMobile = window.innerWidth < 768;
        
        // Récupérer l'ID de l'atelier depuis la page
        const idatelier = '<?php echo $idChiffre; ?>';
        
        
        // Appel AJAX pour récupérer les données
        $.ajax({
            url: '/api/product/dangers/' + idatelier,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                renderDangerChart(data);
            },
            error: function(xhr, status, error) {
                console.error('Erreur lors de la récupération des données:', error);
            }
        });
        
        function renderDangerChart(data) {
            // Préparation des données
            const labels = data.map(item => item.nomdanger);
            const counts = data.map(item => item.count);
            const backgroundColors = generateColors(data.length, 0.6);
            const borderColors = generateColors(data.length, 1);
            
            // Configuration adaptée pour mobile
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
                maintainAspectRatio: !isMobile, // Désactiver le ratio d'aspect fixe sur mobile
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
                            maxRotation: isMobile ? 90 : 0, // Rotation des étiquettes sur mobile
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
                            title: function(context) {
                                // Afficher le nom complet dans l'infobulle
                                return labels[context[0].dataIndex];
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
        
        // Abréger les étiquettes longues pour mobile
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
</html>
