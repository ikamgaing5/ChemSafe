<?php 
    // require_once __DIR__. '/../utilities/session.php';
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
        $idusine = $_SESSION['idusine'];
        $_SESSION['chemin'] = "dashboard";
        $nomUsine = Usine::getNameById($conn,$idusine);

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
	<link rel="icon" type="image/png" href="/images/favicon.png" />

    <!-- Pour Apple (optionnel mais recommandé) -->
    <link rel="apple-touch-icon" href="/images/favion.png">

    <!-- Pour navigateur Microsoft (optionnel) -->
    <meta name="msapplication-TileImage" content="/images/favicon.png">
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
		
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/jquery-nice-select@1.1.0/css/nice-select.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/lokesh-coder/bootstrap-select-country@latest/css/bootstrap-select-country.min.css" rel="stylesheet"> -->
    <!-- <link rel="stylesheet" href="/css/custom.css"> -->
        
        
        <link href="/../css/style.css" rel="stylesheet">
	
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.js"></script> -->
    
        <script src="/js/chart.umd.js"></script>
        <script src="/js/jsquery.min.js"></script>
	
        <link href="/../vendor/wow-master/css/libs/animate.css" rel="stylesheet">
        <link href="/../vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/../vendor/bootstrap-select-country/css/bootstrap-select-country.min.css">
        <link rel="stylesheet" href="/../vendor/jquery-nice-select/css/nice-select.css">
        <link href="/../vendor/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

        <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=experiment" /> -->
        
        <link href="/../vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
        
        <link rel="stylesheet" href="/../vendor/swiper/css/swiper-bundle.min.css">
        
        
        <link href="/../css/style.css" rel="stylesheet">
        <link href="/css/dashboard.css" rel="stylesheet">
	
	
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
                    <div class="d-flex">
                        <div class="col-xl-5 wow fadeInUp" style="margin-right: 15px;" data-wow-delay="1.5s">
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
                        <div class="row">
                            <div class="col-xl-12 wow fadeInUp" data-wow-delay="2s" style="margin-bottom:-10px;" >
                                <div class="shadow-lg card">
                                    <div class="card-header border-0 ">
                                        <h6 class="heading fs-6">Maintenez le curseur sur un zone du graphe pour afficher ses informations</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 wow fadeInUp" data-wow-delay="2s">
                                <div class="shadow-lg card">
                                    <div class="card-header border-0 px-3">
                                        <h4 class="heading m-0">Atelier de l'<?=Usine::getNameById($conn,$idusine)?> </h4>
                                        
                                    </div>
                                    <div class="container" style="margin-top: -10px;" >
                                        <div class="row" id="graphRow">
                                            <div class="col-12">
                                                <div class="card-body">
                                                    <canvas id="atelierChart"></canvas>
                                                </div>
                                                
                                                <!-- <h5 class="legend-title px-1">Légende des ateliers</h5>
                                                <div class="legend-container px-1" id="legendContainer"></div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 wow fadeInUp" data-wow-delay="2s">
                                <div class="shadow-lg card">
                                    <div class="card-header border-0 px-3">
                                        <h4 class="heading m-0">Liste des Atelier de l'<?=Usine::getNameById($conn,$idusine)?> </h4>
                                        
                                    </div>
                                    <div class="container py-3" style="margin-top: -10px;" >
                                        <div class="row" id="graphRow">
                                            <div class="col-12">
                                                <div class="card-body">
                                                    <canvas  id="atelierChart"></canvas>
                                                </div>
                                                
                                                <!-- <h5 class="legend-title px-1">Légende des ateliers</h5>
                                                <div class="legend-container px-1" id="legendContainer"></div> -->
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
        <script>
        $(function() {
            // Vérifier si l'appareil est mobile
            const isMobile = window.innerWidth < 768;
            
            // ID de l'usine (à récupérer dynamiquement si nécessaire)
            const idUsine = <?=$idusine?>; // Exemple statique
            
            // Appel AJAX pour récupérer les données
            $.ajax({
                url: '/showgraph', // Votre script PHP
                method: 'GET',
                data: { idusine: idUsine },
                dataType: 'json',
                success: function(data) {
                    if (data && data.length > 0) {
                        // Rendre le graphique
                        renderAtelierChart(data);
                    } else {
                        // Message si pas de données
                        $('<div class="alert alert-warning mt-3">Aucune donnée disponible pour cette usine</div>').insertAfter('#graphRow');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erreur lors de la récupération des données:', error);
                    // Afficher un message d'erreur
                    $('<div class="alert alert-danger mt-3">Erreur lors du chargement des données</div>').insertAfter('#graphRow');
                }
            });
            
            function renderAtelierChart(data) {
                const nomAteliers = data.map(item => item.nom_atelier);
                const totalProduits = data.map(item => item.total_produits);
                
                // Utiliser des couleurs prédéfinies pour un meilleur contraste visuel
                const colors = generatePredefinedColors(nomAteliers.length);
                
                const chartData = {
                    labels: nomAteliers,
                    datasets: [{
                        data: totalProduits,
                        backgroundColor: colors.backgroundColors,
                        borderColor: colors.borderColors,
                        borderWidth: 1,
                        borderRadius: 2,
                        hoverOffset: 10
                    }]
                };
                
                const options = {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '45%',
                    plugins: {
                        legend: {
                            display: false // Nous utilisons une légende personnalisée
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.9)',
                            titleColor: '#333',
                            bodyColor: '#555',
                            bodyFont: {
                                size: 14
                            },
                            padding: 5,
                            borderColor: '#ddd',
                            borderWidth: 1,
                            callbacks: {
                                title: function(context) {
                                    return nomAteliers[context[0].dataIndex];
                                },
                                label: function(context) {
                                    const dataIndex = context.dataIndex;
                                    const atelier = data[dataIndex];
                                    
                                    // Créer un tableau de lignes pour l'info-bulle
                                    const result = [
                                        `Total: ${atelier.total_produits} produit(s)`,
                                        `Avec FDS: ${atelier.produits_avec_fds} produit(s)`,
                                        `Sans FDS: ${atelier.produits_sans_fds} produit(s)`
                                    ];
                                    
                                    return result;
                                }
                            }
                        }, 
                        // Contrôler l'animation au survol
                        hover: {
                            mode: 'nearest',
                            intersect: true,
                            // Réduire la distance d'expansion au survol
                            hoverOffset: 5  // Réduire cette valeur (était à 10)
                        }
                    }
                };
                // Dans les options du graphique
                options.radius = '90%';  // Réduire légèrement la taille du donut de base
                
                var ctx = document.getElementById('atelierChart').getContext('2d');
                var atelierChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: chartData,
                    options: options
                });
                
                // Générer la légende personnalisée
                generateCustomLegend(data, nomAteliers, colors.backgroundColors);
            }
            
            // Fonction pour générer des couleurs prédéfinies visuellement distinctes
            function generatePredefinedColors(count) {
                // Palette de couleurs prédéfinies avec une meilleure distinction visuelle
                const colors = [
                    { bg: '#E57373', border: '#EF9A9A' }, // rouge
                    { bg: '#64B5F6', border: '#90CAF9' }, // bleu
                    { bg: '#FFF176', border: '#FFF59D' }, // jaune
                    { bg: '#81C784', border: '#A5D6A7' }, // vert
                    { bg: '#BA68C8', border: '#CE93D8' }, // violet
                    { bg: '#FF8A65', border: '#FFAB91' }, // orange
                    { bg: '#E6A970', border: '#F0C6A2' }, // marron clair
                    { bg: '#4DB6AC', border: '#80CBC4' }, // sarcelle
                    { bg: '#7986CB', border: '#9FA8DA' }, // indigo
                    { bg: '#A1887F', border: '#BCAAA4' }, // brun
                    { bg: '#90A4AE', border: '#B0BEC5' }, // bleu-gris
                    { bg: '#DCE775', border: '#E6EE9C' }  // vert citron
                ];
                
                const backgroundColors = [];
                const borderColors = [];
                
                for (let i = 0; i < count; i++) {
                    const colorIndex = i % colors.length;
                    backgroundColors.push(colors[colorIndex].bg);
                    borderColors.push(colors[colorIndex].border);
                }
                
                return {
                    backgroundColors: backgroundColors,
                    borderColors: borderColors
                };
            }
            
            // Générer la légende personnalisée horizontale
            function generateCustomLegend(data, labels, colors) {
                const legendContainer = document.getElementById('legendContainer');
                legendContainer.innerHTML = '';
                
                // Créer les éléments de légende
                labels.forEach((label, index) => {
                    const legendItem = document.createElement('div');
                    legendItem.className = 'legend-item';
                    legendItem.setAttribute('data-index', index);
                    
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
            
            // Fonction pour afficher les informations d'un atelier
            function afficherInfosAtelier(atelier) {
                $('#nomAtelier').text(atelier.nom_atelier);
                $('#totalProduits').text(atelier.total_produits);
                $('#produitsAvecFds').text(atelier.produits_avec_fds);
                $('#produitsSansFds').text(atelier.produits_sans_fds);
                $('#infoAtelier').slideDown(300);
            }
        });
        </script>
    <title>ChemSafe</title>
	<script src="/../vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script> 
	<script src="/js/all.js"></script>
    <!-- <script src="/../../vendor/chart.js/Chart.bundle.min.js"></script> -->
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

