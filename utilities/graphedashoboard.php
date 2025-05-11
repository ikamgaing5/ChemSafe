<script>
    $(function() {
        const isMobile = window.innerWidth < 768;
        const isSuperAdmin = <?= $isSuperAdmin ? 'true' : 'false' ?>;
        const idUsine = <?= $idusine ?? 'null' ?>;

        // Préparer les paramètres AJAX selon le type d'utilisateur
        const ajaxParams = isSuperAdmin ? {} : { idusine: idUsine };

        $.ajax({
            url: '/showgraph',
            method: 'GET',
            data: ajaxParams,
            dataType: 'json',
            success: function(data) {
                if (data && data.length > 0) {
                    renderAtelierChart(data);
                } else {
                    $('<div class="alert alert-warning mt-3">Aucune donnée disponible</div>').insertAfter('#graphRow');
                }
            },
            error: function(xhr, status, error) {
                console.error('Erreur lors de la récupération des données:', error);
                $('<div class="alert alert-danger mt-3">Erreur lors du chargement des données</div>').insertAfter('#graphRow');
            }
        });

        function renderAtelierChart(data) {
            const nomAteliers = data.map(item => item.nom_atelier);
            const totalProduits = data.map(item => item.total_produits);
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
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#333',
                        bodyColor: '#555',
                        bodyFont: { size: 14 },
                        padding: 5,
                        borderColor: '#ddd',
                        borderWidth: 1,
                        callbacks: {
                            title: function(context) {
                                return nomAteliers[context[0].dataIndex];
                            },
                            label: function(context) {
                                const atelier = data[context.dataIndex];
                                return [
                                    `Total: ${atelier.total_produits} produit(s)`,
                                    `Avec FDS: ${atelier.produits_avec_fds} produit(s)`,
                                    `Sans FDS: ${atelier.produits_sans_fds} produit(s)`
                                ];
                            }
                        }
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true,
                        hoverOffset: 5
                    }
                },
                radius: '95%'
            };

            const ctx = document.getElementById('atelierChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: chartData,
                options: options
            });

            generateCustomLegend(data, nomAteliers, colors.backgroundColors);
        }

        function generatePredefinedColors(count) {
            const colors = [
                { bg: '#E57373', border: '#EF9A9A' },
                { bg: '#64B5F6', border: '#90CAF9' },
                { bg: '#FFF176', border: '#FFF59D' },
                { bg: '#81C784', border: '#A5D6A7' },
                { bg: '#BA68C8', border: '#CE93D8' },
                { bg: '#FF8A65', border: '#FFAB91' },
                { bg: '#E6A970', border: '#F0C6A2' },
                { bg: '#4DB6AC', border: '#80CBC4' },
                { bg: '#7986CB', border: '#9FA8DA' },
                { bg: '#A1887F', border: '#BCAAA4' },
                { bg: '#90A4AE', border: '#B0BEC5' },
                { bg: '#DCE775', border: '#E6EE9C' }
            ];
            const backgroundColors = [];
            const borderColors = [];

            for (let i = 0; i < count; i++) {
                const colorIndex = i % colors.length;
                backgroundColors.push(colors[colorIndex].bg);
                borderColors.push(colors[colorIndex].border);
            }

            return { backgroundColors, borderColors };
        }

        function generateCustomLegend(data, labels, colors) {
                    const legendContainer = document.getElementById('legendContainer');
                    legendContainer.innerHTML = '';

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
    });
</script>