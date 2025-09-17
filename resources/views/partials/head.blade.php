<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? 'ISP-DPSP' }}</title>

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

<!-- Chart.js para gráficos del dashboard -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
<!-- Plugin de Chart.js para mostrar datos en los gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
