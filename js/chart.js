$(function() {
    $.ajax({
      url: '/../controllers', // Remplacez par le fichier PHP qui récupère les données
      method: 'GET',
      dataType: 'json',
      success: function(response) {
        var ctx = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: response.labels,  // Les étiquettes de chaque danger
            datasets: [{
              label: 'Nombre de produits',
              data: response.values,  // Les nombres de produits pour chaque danger
              backgroundColor: 'rgba(54, 162, 235, 0.2)',
              borderColor: 'rgba(54, 162, 235, 1)',
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: true
                }
              }]
            }
          }
        });
      }
    });
  });
  