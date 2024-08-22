<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de la Clínica Veterinaria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-nav {
            flex-direction: row;
            justify-content: center;
        }
        .nav-item {
            margin-left: 15px;
            margin-right: 15px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand mx-auto" href="principal.php">Clínica Veterinaria</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="cita.php">Citas</a></li>
                    <li class="nav-item"><a class="nav-link" href="cliente.php">Clientes</a></li>
                    <li class="nav-item"><a class="nav-link" href="consulta.php">Consultas</a></li>
                    <li class="nav-item"><a class="nav-link" href="detalleHistorialMedico.php">Historial Médico</a></li>
                    <li class="nav-item"><a class="nav-link" href="detalleMascota.php">Detalles Mascota</a></li>
                    <li class="nav-item"><a class="nav-link" href="detalleFactura.php">Detalles Factura</a></li>
                    <li class="nav-item"><a class="nav-link" href="factura.php">Facturas</a></li>
                    <li class="nav-item"><a class="nav-link" href="historialMedico.php">Historial Médico</a></li>
                    <li class="nav-item"><a class="nav-link" href="inventario.php">Inventario</a></li>
                    <li class="nav-item"><a class="nav-link" href="mascota.php">Mascotas</a></li>
                    <li class="nav-item"><a class="nav-link" href="medicamento.php">Medicamentos</a></li>
                    <li class="nav-item"><a class="nav-link" href="recetas.php">Recetas</a></li>
                    <li class="nav-item"><a class="nav-link" href="tratamiento.php">Tratamientos</a></li>
                    <li class="nav-item"><a class="nav-link" href="usuario.php">Usuarios</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
 