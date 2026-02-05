<div class="widget widget-chart-one">
    <div class="widget-heading">
        <h5>{{ $title }}</h5>
        <div class="task-action">
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <svg ...></svg>
                </a>
                <div class="dropdown-menu left">
                    <a class="dropdown-item" href="javascript:void(0);">Semanal</a>
                    <a class="dropdown-item" href="javascript:void(0);">Mensual</a>
                    <a class="dropdown-item" href="javascript:void(0);">Anual</a>
                </div>
            </div>
        </div>
    </div>

    <div class="widget-content">
        <!-- Aquí uso el chartId dinámico -->
        <div id="{{ $chartId }}"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const chartData = @json($chartData ?? []);
    if (!chartData.labels || !chartData.series) return;

    const options = {
        chart: {
            type: 'area',
            height: 365,
            fontFamily: 'Nunito, sans-serif',
            zoom: { enabled: false },
            toolbar: { show: false },
            dropShadow: { enabled: true, opacity: 0.2, blur: 10, left: -7, top: 22 }
        },
        series: chartData.series,
        colors: ['#e7515a', '#FFA500'], // rojo pánico, naranja manilla desconectada
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        markers: { size: 5 },
        tooltip: { shared: true, intersect: false, theme: 'dark' },
        legend: { position: 'top', horizontalAlign: 'right', offsetY: -50, fontSize: '16px' },
        xaxis: {
            categories: chartData.labels,
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: { style: { fontSize: '12px', fontFamily: 'Nunito, sans-serif' } },
            title: { text: 'Mes' }
        },
        yaxis: {
            labels: { style: { fontSize: '12px', fontFamily: 'Nunito, sans-serif' } }
        },
        grid: { borderColor: '#191e3a', strokeDashArray: 5, xaxis: { lines: { show: true } }, yaxis: { lines: { show: false } } },
        fill: { type: 'gradient', gradient: { type: 'vertical', shadeIntensity: 1, opacityFrom: .19, opacityTo: .05, stops: [100, 100] } },
        responsive: [{ breakpoint: 575, options: { legend: { offsetY: -50 } } }]
    };

    const chart = new ApexCharts(document.querySelector("#{{ $chartId ?? 'eventosChart' }}"), options);
    chart.render();
});
</script>
