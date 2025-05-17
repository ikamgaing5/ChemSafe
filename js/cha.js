$(function() {
    // Vérifier si l'appareil est mobile
    const isMobile = window.innerWidth < 768;
    
    // Récupérer l'ID de l'atelier depuis la page
    const idatelier = '<?php echo $idChiffre; ?>';

    // const idatelier = document.getElementById('idatelier').value;
    
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
