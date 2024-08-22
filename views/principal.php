<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de la Clínica Veterinaria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Estilo para los cards */
        .card {
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: scale(1.05); /* Añade un efecto de escala al pasar el mouse */
        }
        .card-header {
            font-size: 1.5em; /* Aumenta el tamaño del texto en el encabezado */
            font-weight: bold; /* Hace el texto en el encabezado en negrita */
        }
        .card-body i {
            font-size: 3em; /* Aumenta el tamaño de los iconos */
            margin-bottom: 20px;
            color: black; /* Cambia el color de los iconos a negro */
        }
        .card-body .btn {
            font-size: 1.2em; /* Aumenta el tamaño del texto en el botón */
            padding: 15px; /* Aumenta el padding del botón para hacerlo más grande */
        }
        .card {
            padding: 20px; /* Añade padding interno a los cards */
        }
        .container {
            margin-top: 30px; /* Añade margen superior a la container para separarla del header */
        }
        .row > div {
            margin-bottom: 30px; /* Añade margen inferior a cada card para separarlos más */
        }
        .report-section {
            margin-top: 50px;
        }
        .report-iframe {
            width: 100%;
            height: 600px;
            border: none;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="bg-dark text-white text-center py-3">
        <h1 class="display-4">Gestión de la Clínica Veterinaria SmartVet</h1>
        <p class="lead">Accede a las diferentes secciones del sistema</p>
    </header>

    <!-- Navegación con Cards -->
    <div class="container my-4">
        <div class="row">
            <!-- Primer Card -->
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-header">Citas</div>
                    <div class="card-body text-center">
                        <i class="fas fa-calendar-alt"></i>
                        <a href="cita.php" class="btn btn-primary w-100">Ver citas</a>
                    </div>
                </div>
            </div>
            <!-- Segundo Card -->
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-header">Clientes</div>
                    <div class="card-body text-center">
                        <i class="fas fa-users"></i>
                        <a href="cliente.php" class="btn btn-primary w-100">Ver clientes</a>
                    </div>
                </div>
            </div>
            <!-- Tercer Card -->
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-header">Consultas</div>
                    <div class="card-body text-center">
                        <i class="fas fa-stethoscope"></i>
                        <a href="consulta.php" class="btn btn-primary w-100">Ver consultas</a>
                    </div>
                </div>
            </div>
            <!-- Cuarto Card -->
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-header">Detalles Historial Médico</div>
                    <div class="card-body text-center">
                        <i class="fas fa-notes-medical"></i>
                        <a href="detalleHistorialMedico.php" class="btn btn-primary w-100">Ver detalles</a>
                    </div>
                </div>
            </div>
            <!-- Quinto Card -->
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-header">Detalles Mascotas</div>
                    <div class="card-body text-center">
                        <i class="fas fa-paw"></i>
                        <a href="detalleMascota.php" class="btn btn-primary w-100">Ver detalles de mascotas</a>
                    </div>
                </div>
            </div>
            <!-- Sexto Card -->
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-header">Detalles Factura</div>
                    <div class="card-body text-center">
                        <i class="fas fa-file-invoice"></i>
                        <a href="detalleFactura.php" class="btn btn-primary w-100">Ver detalles de factura</a>
                    </div>
                </div>
            </div>
            <!-- Séptimo Card -->
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-header">Facturas</div>
                    <div class="card-body text-center">
                        <i class="fas fa-receipt"></i>
                        <a href="factura.php" class="btn btn-primary w-100">Ver facturas</a>
                    </div>
                </div>
            </div>
            <!-- Octavo Card -->
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-header">Historial Médico</div>
                    <div class="card-body text-center">
                        <i class="fas fa-history"></i>
                        <a href="historialMedico.php" class="btn btn-primary w-100">Ver historial médico</a>
                    </div>
                </div>
            </div>
            <!-- Noveno Card -->
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-header">Inventario</div>
                    <div class="card-body text-center">
                        <i class="fas fa-boxes"></i>
                        <a href="inventario.php" class="btn btn-primary w-100">Ver inventario</a>
                    </div>
                </div>
            </div>
            <!-- Décimo Card -->
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-header">Mascotas</div>
                    <div class="card-body text-center">
                        <i class="fas fa-dog"></i>
                        <a href="mascota.php" class="btn btn-primary w-100">Ver mascotas</a>
                    </div>
                </div>
            </div>
            <!-- Décimo Primer Card -->
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-header">Medicamentos</div>
                    <div class="card-body text-center">
                        <i class="fas fa-pills"></i>
                        <a href="medicamento.php" class="btn btn-primary w-100">Ver medicamentos</a>
                    </div>
                </div>
            </div>
            <!-- Décimo Segundo Card -->
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-header">Recetas</div>
                    <div class="card-body text-center">
                        <i class="fas fa-prescription"></i>
                        <a href="recetas.php" class="btn btn-primary w-100">Ver recetas</a>
                    </div>
                </div>
            </div>
            <!-- Décimo Tercer Card -->
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-header">Tratamientos</div>
                    <div class="card-body text-center">
                        <i class="fas fa-syringe"></i>
                        <a href="tratamiento.php" class="btn btn-primary w-100">Ver tratamientos</a>
                    </div>
                </div>
            </div>
            <!-- Décimo Cuarto Card -->
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-header">Usuarios</div>
                    <div class="card-body text-center">
                        <i class="fas fa-user"></i>
                        <a href="usuario.php" class="btn btn-primary w-100">Ver usuarios</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Reportes -->
        <div class="report-section text-center">
            <h2 class="my-4">Reportes</h2>
            <a href="reportes.php" target="_blank" class="btn btn-warning btn-lg">
                <i class="fas fa-chart-bar"></i> Ver Reportes
            </a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
