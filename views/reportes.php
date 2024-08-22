<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes de la Clínica Veterinaria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .report-section {
            margin-top: 30px;
        }
        .report-icon {
            font-size: 2em;
            margin-right: 10px;
        }
        .btn-back {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="bg-dark text-white text-center py-3">
        <h1 class="display-4">Reportes de la Clínica Veterinaria</h1>
        <p class="lead">Selecciona un reporte para visualizar</p>
    </header>

    <!-- Botón Regresar -->
    <div class="container text-center btn-back">
        <a href="principal.php" class="btn btn-secondary btn-lg">
            <i class="fas fa-arrow-left"></i> Regresar
        </a>
    </div>

    <!-- Contenido de Reportes -->
    <div class="container my-4">
        <div class="list-group">
            <a href="https://app.powerbi.com/groups/me/reports/93ede8df-cf46-40a3-a5f0-85b4a3a795f1/03d1abb675736430defc?ctid=dde2fb8f-d8e0-445e-b851-e69c198c1e59&experience=power-bi" target="_blank" class="list-group-item list-group-item-action">
                <i class="report-icon fas fa-users"></i> Lista de Clientes con sus Mascotas
            </a>
            <a href="https://app.powerbi.com/groups/me/reports/93ede8df-cf46-40a3-a5f0-85b4a3a795f1/de96f15b24059a45b098?ctid=dde2fb8f-d8e0-445e-b851-e69c198c1e59&experience=power-bi" target="_blank" class="list-group-item list-group-item-action">
                <i class="report-icon fas fa-calendar-day"></i> Monto Recaudado por Mes
            </a>
            <a href="https://app.powerbi.com/groups/me/reports/93ede8df-cf46-40a3-a5f0-85b4a3a795f1/d6d7df37bdd7baeb0aa0?ctid=dde2fb8f-d8e0-445e-b851-e69c198c1e59&experience=power-bi" target="_blank" class="list-group-item list-group-item-action">
                <i class="report-icon fas fa-syringe"></i> Cantidad de Tratamientos Realizados
            </a>
            <a href="https://app.powerbi.com/groups/me/reports/93ede8df-cf46-40a3-a5f0-85b4a3a795f1/01f960199d4265c0cc2e?ctid=dde2fb8f-d8e0-445e-b851-e69c198c1e59&experience=power-bi" target="_blank" class="list-group-item list-group-item-action">
                <i class="report-icon fas fa-users"></i> Información de los Empleados
            </a>
            <a href="https://app.powerbi.com/groups/me/reports/93ede8df-cf46-40a3-a5f0-85b4a3a795f1/94e00e25e080ecce760c?ctid=dde2fb8f-d8e0-445e-b851-e69c198c1e59&experience=power-bi" target="_blank" class="list-group-item list-group-item-action">
                <i class="report-icon fas fa-pills"></i> Lista de Medicamentos Más Vendidos
            </a>
            <a href="https://app.powerbi.com/groups/me/reports/93ede8df-cf46-40a3-a5f0-85b4a3a795f1/49a4d2a8e12fae2dfab1?ctid=dde2fb8f-d8e0-445e-b851-e69c198c1e59&experience=power-bi" target="_blank" class="list-group-item list-group-item-action">
                <i class="report-icon fas fa-calendar-check"></i> Cantidad de Citas por Estado
            </a>
            <a href="https://app.powerbi.com/groups/me/reports/93ede8df-cf46-40a3-a5f0-85b4a3a795f1/69e33a4d248d170ffe09?ctid=dde2fb8f-d8e0-445e-b851-e69c198c1e59&experience=power-bi" target="_blank" class="list-group-item list-group-item-action">
                <i class="report-icon fas fa-calendar-week"></i> Informe de Citas por Empleado
            </a>
            <a href="https://app.powerbi.com/groups/me/reports/93ede8df-cf46-40a3-a5f0-85b4a3a795f1/861db05a159b3ad114bd?ctid=dde2fb8f-d8e0-445e-b851-e69c198c1e59&experience=power-bi" target="_blank" class="list-group-item list-group-item-action">
                <i class="report-icon fas fa-receipt"></i> Total Facturado Según la Consulta
            </a>
            <a href="https://app.powerbi.com/groups/me/reports/93ede8df-cf46-40a3-a5f0-85b4a3a795f1/2b530bd330f764682fc8?ctid=dde2fb8f-d8e0-445e-b851-e69c198c1e59&experience=power-bi" target="_blank" class="list-group-item list-group-item-action">
                <i class="report-icon fas fa-notes-medical"></i> Informe Historial Médico
            </a>
            <a href="https://app.powerbi.com/groups/me/reports/93ede8df-cf46-40a3-a5f0-85b4a3a795f1/7f8a0cca5b66a0996ef3?ctid=dde2fb8f-d8e0-445e-b851-e69c198c1e59&experience=power-bi" target="_blank" class="list-group-item list-group-item-action">
                <i class="report-icon fas fa-chart-pie"></i> Gráfico para Saber el Porcentaje de Citas Canceladas
            </a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
