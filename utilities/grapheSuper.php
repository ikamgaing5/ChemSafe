<script>
$(function() {
    $.ajax({
        url: '/showgraphs',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log('Données reçues pour le graph:', data);
            if (!data || !data.length) {
                $('#atelierChart').parent().append(
                  '<div class="alert alert-warning">Aucune donnée disponible</div>'
                );
                return;
            }
            renderAtelierChart(data);
        },
        error: function(_, __, err) {
            console.error('Erreur:', err);
            $('#atelierChart').parent().append(
              '<div class="alert alert-danger">Erreur lors du chargement des données</div>'
            );
        }
    });

    function renderAtelierChart(data) {
        const labels = data.map(d => d.nom_atelier);
        const totals = data.map(d => d.total_produits);
        const colors = generatePredefinedColors(labels.length);

        const ctx = document.getElementById('atelierChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: totals,
                    backgroundColor: colors.backgroundColors,
                    borderColor: colors.borderColors,
                    borderWidth: 1,
                    borderRadius: 2,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '45%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(255,255,255,0.9)',
                        titleColor: '#333',
                        bodyColor: '#555',
                        padding: 6,
                        borderColor: '#ddd',
                        borderWidth: 1,
                        callbacks: {
                            title: ctxArr => data[ctxArr[0].dataIndex].nom_atelier,
                            label: ctxArr => {
                                const item = data[ctxArr.dataIndex];
                                const pct = item.total_usine
                                  ? ((item.total_produits / item.total_usine) * 100).toFixed(2)
                                  : '0.00';
                                return [
                                    `Usine : ${item.nom}`,
                                    `Total : ${item.total_produits} produit(s)`,
                                    `Avec FDS : ${item.produits_avec_fds}`,
                                    `Sans FDS : ${item.produits_sans_fds}`,
                                    `Part de l'usine : ${pct} %`
                                ];
                            }
                        }
                    },
                    hover: { mode: 'nearest', intersect: true, hoverOffset: 5 }
                },
                radius: '95%'
            }
        });

        // légende personnalisée
        const legendEl = document.getElementById('legendContainer');
        legendEl.innerHTML = '';
        labels.forEach((lab, i) => {
            const div = document.createElement('div');
            div.className = 'd-flex align-items-center me-3 mb-2';
            div.innerHTML = `
                <span style="
                  display:inline-block;
                  width:12px;height:12px;
                  background:${colors.backgroundColors[i]};
                  border:1px solid ${colors.borderColors[i]};
                  border-radius:2px;
                  margin-right:6px;"></span>
                <small>${lab}</small>
            `;
            legendEl.appendChild(div);
        });
    }

    function generatePredefinedColors(count) {
        const palette = [
            { bg: '#E57373', border: '#EF9A9A' }, { bg: '#64B5F6', border: '#90CAF9' },
            { bg: '#FFF176', border: '#FFF59D' }, { bg: '#81C784', border: '#A5D6A7' },
            { bg: '#BA68C8', border: '#CE93D8' }, { bg: '#FF8A65', border: '#FFAB91' },
            { bg: '#E6A970', border: '#F0C6A2' }, { bg: '#4DB6AC', border: '#80CBC4' },
            { bg: '#7986CB', border: '#9FA8DA' }, { bg: '#A1887F', border: '#BCAAA4' },
            { bg: '#90A4AE', border: '#B0BEC5' }, { bg: '#DCE775', border: '#E6EE9C' }
        ];
        const bgs = [], borders = [];
        for (let i = 0; i < count; i++) {
            const c = palette[i % palette.length];
            bgs.push(c.bg);
            borders.push(c.border);
        }
        return { backgroundColors: bgs, borderColors: borders };
    }
});
</script>
