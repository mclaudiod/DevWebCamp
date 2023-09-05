(function() {
    const graph = document.querySelector('#gift-graph');

    if (graph) {
        obtainData();

        async function obtainData() {
            const url = '/api/gifts';
            const answer = await fetch(url);
            const result = await answer.json();

            console.log(result);

            const ctx = document.getElementById('gift-graph').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: result.map(gift => gift.name),
                    datasets: [{
                        label: '',
                        data: result.map(gift => gift.total),
                        backgroundColor: [
                            '#ea580c',
                            '#84cc16',
                            '#22d3ee',
                            '#a855f7',
                            '#ef4444',
                            '#14b8a6',
                            '#db2777',
                            '#e11d48',
                            '#7e22ce'
                        ]
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
    }
})();