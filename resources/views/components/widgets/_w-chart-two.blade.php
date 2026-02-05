{{-- 

/**
*
* Created a new component <x-rtl.widgets._w-chart-two/>.
* 
*/

--}}


<div class="widget widget-chart-two">
    <div class="widget-heading">
        <h5>{{ $title }}</h5>
    </div>
    <div class="widget-content">
        <div id="{{ $chartId ?? 'chart-2' }}"></div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    try {
        const chartData = @json($chartData ?? []);
        if (!chartData.series || !chartData.labels) return;

        // Detectar tema actual
        let themeObj = JSON.parse(sessionStorage.getItem("theme") || '{}');
        let darkMode = themeObj?.settings?.layout?.darkMode ?? false;

        // Configuración original de Cork
        let options = {
            chart: {
                type: 'donut',
                width: 370,
                height: 430,
            },
            colors: ['#622bd7', '#e2a03f', '#e7515a', '#009688'],
            dataLabels: {
                enabled: false,
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                fontSize: '14px',
                markers: {
                    width: 10,
                    height: 10,
                    offsetX: -5,
                    offsetY: 0,
                },
                itemMargin: {
                    horizontal: 10,
                    vertical: 30,
                },
            },
            plotOptions: {
                pie: {
                    expandOnClick: false,
                    donut: {
                        size: '75%',
                        background: 'transparent',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '29px',
                                fontFamily: 'Nunito, sans-serif',
                                color: undefined,
                                offsetY: -10,
                            },
                            value: {
                                show: true,
                                fontSize: '26px',
                                fontFamily: 'Nunito, sans-serif',
                                color: darkMode ? '#1ad271' : '#0e1726',
                                offsetY: 16,
                                formatter: function (val) {
                                    return val;
                                },
                            },
                            total: {
                                show: true,
                                showAlways: true,
                                label: 'Total',
                                color: '#888ea8',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                },
                            },
                        },
                    },
                },
            },
            stroke: {
                show: true,
                width: 15,
                colors: darkMode ? '#0e1726' : '#fff', // grosor y color del borde interno
            },
            series: chartData.series,
            labels: chartData.labels,
            responsive: [
                {
                    breakpoint: 1440,
                    options: {
                        chart: { width: 325 },
                    },
                },
                {
                    breakpoint: 1199,
                    options: {
                        chart: { width: 380 },
                    },
                },
                {
                    breakpoint: 575,
                    options: {
                        chart: { width: 320 },
                    },
                },
            ],
        };

        // Renderizar gráfico
        let chart = new ApexCharts(document.querySelector("#{{ $chartId ?? 'chart-2' }}"), options);
        chart.render();

        // Escuchar cambios de tema
        document.querySelector('.theme-toggle')?.addEventListener('click', function () {
            let themeObj = JSON.parse(sessionStorage.getItem("theme") || '{}');
            let dark = themeObj?.settings?.layout?.darkMode ?? false;
            chart.updateOptions({
                stroke: { colors: dark ? '#0e1726' : '#fff' },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                value: {
                                    color: dark ? '#bfc9d4' : '#0e1726',
                                },
                            },
                        },
                    },
                },
            });
        });
    } catch (e) {
        console.error(e);
    }
});
</script>
