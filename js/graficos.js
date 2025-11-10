function grafiPie(paramsone, paramstow, paramsthree, paramstitle) {

    var exists = Chart.getChart(paramsone);
    exists?.destroy();

    const ctx = document.getElementById(paramsone).getContext('2d');


    const dados = {
        labels: paramstow,
        datasets: [{
            data: paramsthree,
            // label: '# de inscritos',
            backgroundColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(23, 141, 8, 1)'
            ],
            hoverOffset: 4
        }]
    };

    // const optiondados = {
    //     responsive: true,
    //     plugins: {
    //         datalabels: {
    //             formatter: (value, context) => {
    //                 let percentage = (value / context.chart._metasets
    //                 [context.datasetIndex].total * 100)
    //                     .toFixed(2) + '%';
    //                 return percentage + '\n' + value;
    //             },
    //             color: '#fff',
    //             font: {
    //                 size: 14,
    //             }
    //         }
    //     },
    //     plugins: [ChartDataLabels]

    // };

    // const optionsZero = {
    //     tooltips: {
    //         enabled: true
    //     },
    //     plugins: {
    //         datalabels: {
    //             formatter: (value, ctx) => {

    //                 let sum = ctx.dataset._meta[0].total;
    //                 let percentage = (value * 100 / sum).toFixed(2) + "%";
    //                 return percentage;


    //             },
    //             color: '#fff',
    //         }
    //     }
    // };

    //     const optionsOne = {
    //         title: {
    //             display: true,
    //             text: paramstitle
    //         },
    //         cutout: '40%',
    //         radius: 250
    //     },

    const optionsTwo = {
        responsive: true,
        plugins: {
            tooltip: {
                callbacks: {
                    label: function (context) {
                        let label = context.label || '';
                        let value = context.raw || 0;
                        let total =
                            context.dataset.data.
                                reduce((acc, curr) => acc + curr, 0);
                        let percentage = (value / total * 100).toFixed(2) + '%';
                        return label + ': ' + value + ' (' + percentage + ')';
                    }
                }
            }
        }
    };

    

    const confdados = {
        type: 'pie',
        data: dados,
        options: optionsTwo
    };


    new Chart(ctx,
        confdados
    );

}