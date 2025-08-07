import ApexCharts from 'apexcharts';

document.addEventListener('DOMContentLoaded', function () {
    const orderData = window.ordersByDay;

    const dates = orderData.map(item => item.date);
    const counts = orderData.map(item => item.total);

    const options = {
        chart: {
            type: 'area',
            height: 350,
            toolbar: {
                show: false
            }
        },
        series: [{
            name: 'Pedidos',
            data: counts
        }],
        xaxis: {
            categories: dates,
            labels: {
                style: {
                    colors: document.documentElement.classList.contains('dark') ? '#d1d5db' : '#4b5563'
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: document.documentElement.classList.contains('dark') ? '#d1d5db' : '#4b5563'
                }
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
            width: 2
        },
        colors: ['#3b82f6'],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.3,
                stops: [0, 90, 100]
            }
        },
        tooltip: {
            theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
        },
        grid: {
            borderColor: document.documentElement.classList.contains('dark') ? '#374151' : '#e5e7eb',
        }
    };

    const chart = new ApexCharts(document.querySelector("#orders-chart"), options);
    chart.render();
});
