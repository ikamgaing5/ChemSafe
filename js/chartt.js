
$(function() {
  // Récupérer l'ID de l'atelier depuis la page
  const idatelier = '<?php echo $idChiffre; ?>'; // ID chiffré
  
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
  
  // Fonction pour générer le graphique
  function renderDangerChart(data) {
    // Préparation des données pour Chart.js
    const labels = data.map(item => item.nomdanger);
    const counts = data.map(item => item.count);
    
    // Génération de couleurs dynamiques
    const backgroundColors = generateColors(data.length, 0.2);
    const borderColors = generateColors(data.length, 1);
    
    // Configuration des données
    const chartData = {
      labels: labels,
      datasets: [{
        label: 'Nombre de produits',
        data: counts,
        backgroundColor: backgroundColors,
        borderColor: borderColors,
        borderWidth: 1
      }]
    };
    
    // Options du graphique
    const options = {
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            precision: 0
          }
        }
      }
    };
    
    // Création du graphique
    var ctx = document.getElementById('dangerChart').getContext('2d');
    var dangerChart = new Chart(ctx, {
      type: 'bar',
      data: chartData,
      options: options
    });
  }
  
  // Fonction pour générer des couleurs
  function generateColors(count, alpha) {
    const colors = [];
    const hueStep = 360 / count;
    
    for (let i = 0; i < count; i++) {
      const hue = i * hueStep;
      colors.push(`hsla(${hue}, 70%, 60%, ${alpha})`);
    }
    
    return colors;
  }
});
