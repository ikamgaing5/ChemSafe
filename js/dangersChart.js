$(function() {
    // Vérifier si l'appareil est mobile
    const isMobile = window.innerWidth < 768;
    
    // Ajuster certains paramètres en fonction de la taille de l'écran
    const chartHeight = isMobile ? 300 : 400; // Hauteur réduite sur mobile
    
    // Appel AJAX pour récupérer les données sur les dangers
    $.ajax({
        url: '/getAllDangerData',
        method: 'GET',
        data: { idusine: selectedUsineId }, // <<< à définir selon ton contexte
        dataType: 'json',
        success: function(data) {
            if (data && data.length > 0) {
                // Rendre le graphique
                renderDangerChart(data);
            } else {
                // Message si pas de données
                $('<div class="alert alert-warning mt-3">Aucune donnée de danger disponible</div>').insertAfter('#graphRow');
            }
        },
        error: function(xhr, status, error) {
            console.error('Erreur lors de la récupération des données:', error);
            // Afficher un message d'erreur
            $('<div class="alert alert-danger mt-3">Erreur lors du chargement des données</div>').insertAfter('#graphRow');
        }
    });
    
    function renderDangerChart(data) {
        const nomDangers = data.map(item => item.nom_danger);
        const totalProduits = data.map(item => item.total_produits);
        
        // Utiliser des couleurs prédéfinies pour un meilleur contraste visuel
        const colors = generatePredefinedColors(nomDangers.length);
        
        const chartData = {
            labels: nomDangers,
            datasets: [{
                data: totalProduits,
                backgroundColor: colors.backgroundColors,
                borderColor: colors.borderColors,
                borderWidth: 1,
                borderRadius: 2,
                hoverOffset: isMobile ? 5 : 10 // Réduire la valeur sur mobile
            }]
        };
        
        const options = {
            responsive: true,
            maintainAspectRatio: false,
            cutout: isMobile ? '40%' : '45%', // Cutout légèrement plus petit sur mobile
            plugins: {
                legend: {
                    display: false // Nous utilisons une légende personnalisée
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#333',
                    bodyColor: '#555',
                    bodyFont: {
                        size: isMobile ? 12 : 14 // Taille de police plus petite sur mobile
                    },
                    padding: isMobile ? 3 : 5,
                    borderColor: '#ddd',
                    borderWidth: 1,
                    callbacks: {
                        title: function(context) {
                            return nomDangers[context[0].dataIndex];
                        },
                        label: function(context) {
                            const dataIndex = context.dataIndex;
                            const danger = data[dataIndex];
                            
                            // Créer un tableau de lignes pour l'info-bulle
                            const result = [
                                `Total: ${danger.total_produits} produit(s)`,
                                `Pourcentage: ${((danger.total_produits / data.reduce((sum, item) => sum + item.total_produits, 0)) * 100).toFixed(1)}%`
                            ];
                            
                            return result;
                        }
                    }
                }, 
                // Contrôler l'animation au survol
                hover: {
                    mode: 'nearest',
                    intersect: true,
                    hoverOffset: isMobile ? 3 : 5
                }
            }
        };
        
        // Ajuster le rayon en fonction de la taille de l'écran
        options.radius = isMobile ? '85%' : '90%';
        
        // Définir la hauteur du conteneur de graphique en fonction de la taille de l'écran
        $('.chart-container').css('height', chartHeight + 'px');
        
        var ctx = document.getElementById('dangerChart').getContext('2d');
        var dangerChart = new Chart(ctx, {
            type: 'doughnut',
            data: chartData,
            options: options
        });
        
        // Générer la légende personnalisée
        generateCustomLegend(data, nomDangers, colors.backgroundColors);
        
        // Ajouter la gestion des clics sur la légende
        attachLegendClickHandlers(dangerChart);
        
        // Gérer le redimensionnement de la fenêtre
        $(window).on('resize', function() {
            const newIsMobile = window.innerWidth < 768;
            
            // Si changement d'état (passage de desktop à mobile ou vice-versa)
            if (newIsMobile !== isMobile) {
                // Détruire et recréer le graphique avec les nouveaux paramètres
                dangerChart.destroy();
                renderDangerChart(data);
            }
        });
    }
    
    // Fonction pour générer des couleurs prédéfinies visuellement distinctes (inchangée)
    function generatePredefinedColors(count) {
        // Palette de couleurs prédéfinies avec une meilleure distinction visuelle
        const colors = [
            { bg: '#D32F2F', border: '#E53935' }, // rouge vif (danger élevé)
            { bg: '#F57C00', border: '#FB8C00' }, // orange (danger moyen-élevé)
            { bg: '#FBC02D', border: '#FDD835' }, // jaune (danger moyen)
            { bg: '#7CB342', border: '#8BC34A' }, // vert (danger faible)
            { bg: '#00897B', border: '#009688' }, // sarcelle
            { bg: '#1976D2', border: '#2196F3' }, // bleu
            { bg: '#5E35B1', border: '#673AB7' }, // violet
            { bg: '#C2185B', border: '#E91E63' }, // rose
            { bg: '#00695C', border: '#00796B' }, // vert foncé
            { bg: '#6D4C41', border: '#795548' }, // brun
            { bg: '#455A64', border: '#546E7A' }, // bleu-gris
            { bg: '#616161', border: '#757575' }  // gris
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
    
    // Générer la légende personnalisée horizontale adaptée au responsive
    function generateCustomLegend(data, labels, colors) {
        const legendContainer = document.getElementById('legendContainer');
        legendContainer.innerHTML = '';
        
        // Décider du style de légende en fonction de la taille de l'écran
        const legendClass = isMobile ? 'legend-container-mobile' : 'legend-container-desktop';
        legendContainer.className = legendClass;
        
        // Créer les éléments de légende
        labels.forEach((label, index) => {
            const legendItem = document.createElement('div');
            legendItem.className = 'legend-item';
            legendItem.setAttribute('data-index', index);
            
            const colorBox = document.createElement('div');
            colorBox.className = 'legend-color';
            colorBox.style.backgroundColor = colors[index];
            
            // Sur mobile, afficher des noms plus courts avec des ellipses si nécessaire
            const labelText = document.createElement('span');
            labelText.className = 'legend-text';
            
            // Limiter la longueur du texte sur mobile
            if (isMobile && label.length > 12) {
                labelText.textContent = `${label.substring(0, 10)}... (${data[index].total_produits})`;
                labelText.title = `${label} (${data[index].total_produits} produits)`;
            } else {
                labelText.textContent = `${label} (${data[index].total_produits})`;
            }
            
            legendItem.appendChild(colorBox);
            legendItem.appendChild(labelText);
            legendContainer.appendChild(legendItem);
            
            // Ajouter un écouteur d'événement pour afficher les détails
            legendItem.addEventListener('click', function() {
                afficherInfosDanger(data[index]);
            });
        });
    }
    
    // Ajouter la gestion des clics sur la légende
    function attachLegendClickHandlers(chart) {
        document.getElementById('legendContainer').addEventListener('click', function(e) {
            const legendItem = e.target.closest('.legend-item');
            if (legendItem) {
                const index = parseInt(legendItem.getAttribute('data-index'));
                
                // Mettre en évidence cette section du graphique
                highlightChartSegment(chart, index);
            }
        });
    }
    
    // Fonction pour mettre en évidence un segment du graphique
    function highlightChartSegment(chart, index) {
        // Réinitialiser tous les segments
        chart.data.datasets[0].backgroundColor.forEach((color, i) => {
            chart.getDatasetMeta(0).data[i].options.offset = 0;
        });
        
        // Mettre en évidence le segment sélectionné avec une valeur adaptée au responsive
        chart.getDatasetMeta(0).data[index].options.offset = isMobile ? 10 : 15;
        
        chart.update();
    }
    
    // Fonction pour afficher les informations détaillées d'un danger
    function afficherInfosDanger(danger) {
        // Récupérer les produits associés à ce danger
        $.ajax({
            url: '/getDangerProducts',
            method: 'GET',
            data: { iddanger: danger.iddanger },
            dataType: 'json',
            success: function(produits) {
                // Mettre à jour le contenu du panneau d'information
                $('#nomDanger').text(danger.nom_danger);
                $('#totalProduitsDanger').text(danger.total_produits);
                
                // Afficher la liste des produits
                const produitsList = $('#produitsList');
                produitsList.empty();
                
                if (produits && produits.length > 0) {
                    // Limiter le nombre de produits affichés sur mobile
                    const maxProducts = isMobile ? 5 : produits.length;
                    const displayedProducts = produits.slice(0, maxProducts);
                    
                    displayedProducts.forEach(produit => {
                        produitsList.append(`<li class="list-group-item">${produit.nom}</li>`);
                    });
                    
                    // Si plus de produits que la limite sur mobile, ajouter un indicateur
                    if (isMobile && produits.length > maxProducts) {
                        produitsList.append(`<li class="list-group-item text-muted">+ ${produits.length - maxProducts} autres produits...</li>`);
                    }
                } else {
                    produitsList.append('<li class="list-group-item">Aucun produit trouvé</li>');
                }
                
                // Sur mobile, faire défiler jusqu'au panneau d'info
                if (isMobile) {
                    // Afficher d'abord le panneau
                    $('#infoDanger').slideDown(300, function() {
                        // Puis défiler jusqu'à lui
                        $('html, body').animate({
                            scrollTop: $('#infoDanger').offset().top - 20
                        }, 500);
                    });
                } else {
                    // Sur desktop, juste afficher le panneau
                    $('#infoDanger').slideDown(300);
                }
            },
            error: function(xhr, status, error) {
                console.error('Erreur lors de la récupération des produits:', error);
                alert('Impossible de récupérer la liste des produits pour ce danger.');
            }
        });
    }
});