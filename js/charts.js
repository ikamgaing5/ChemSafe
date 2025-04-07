$(function() {
    var atelierId = $('#atelierId').val(); // ID de l'atelier passé dynamiquement via un champ caché ou une autre méthode

    $.ajax({
        url: '/all-products/' + atelierId, // Remplacer par l'URL correcte de votre route
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // Assurez-vous que 'response' contient bien les labels et les valeurs
            var chartData = {
                labels: response.labels,
                datasets: [{
                    label: 'Danger Count',
                    data: response.values,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            };

            var options = {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        },
                        gridLines: {
                            color: "rgba(204, 204, 204,0.1)"
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            color: "rgba(204, 204, 204,0.1)"
                        }
                    }]
                },
                legend: {
                    display: false
                },
                elements: {
                    point: {
                        radius: 0
                    }
                }
            };

            var ctx = $("#dangerChart")[0].getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: options
            });
        },
        error: function(xhr, status, error) {
            console.error("Erreur lors de la récupération des données : ", error);
        }
    });
});
