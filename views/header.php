
<style>
    .navbar-nav {
        flex-direction: row;
        justify-content: center;
    }
    .nav-item {
        margin-left: 15px;
        margin-right: 15px;
    }
    .nav-link {
        transition: color 0.3s ease, background-color 0.3s ease;
    }
    .nav-link:hover {
        color: #f8f9fa;
        background-color: #343a40;
        border-radius: 0.25rem;
    }
    .active {
        font-weight: bold;
        color: #ffc107;
        background-color: #495057;
        border-radius: 0.25rem;
    }
</style>

</head>
<body>
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
                <li class="nav-item"><a class="nav-link" href="mascota.php">Mascotas</a></li>
                <li class="nav-item"><a class="nav-link" href="detalleMascota.php">Detalles Mascota</a></li>
                <li class="nav-item"><a class="nav-link" href="consulta.php">Consultas</a></li>
                <li class="nav-item"><a class="nav-link" href="usuario.php">Usuarios</a></li>
                <li class="nav-item"><a class="nav-link" href="tratamiento.php">Tratamientos</a></li>
                <li class="nav-item"><a class="nav-link" href="detalleTratamiento.php">Detalle Tratamiento</a></li>
                <li class="nav-item"><a class="nav-link" href="historialMedico.php">Historial Médico</a></li>
                <li class="nav-item"><a class="nav-link" href="medicamento.php">Medicamentos</a></li>
                <li class="nav-item"><a class="nav-link" href="inventario.php">Inventario</a></li>

                <!-- Dropdown Mantenimiento -->
                <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Mantenimiento
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        <li><a class="dropdown-item" href="detalleFactura.php">Detalles Factura</a></li>
        <li><a class="dropdown-item" href="recetas.php">Recetas</a></li>
        <li><a class="dropdown-item" href="detalleHistorialMedico.php">Detalle Historial Médico</a></li>
        <li><a class="dropdown-item" href="factura.php">Facturas</a></li>
    </ul>
</li>

            </ul>
        </div>
    </div>
</nav>


    <!-- Bootstrap JS -->

</body>
</html>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener la URL actual
        var currentPath = window.location.pathname;
        
        // Obtener todos los enlaces de navegación
        var navLinks = document.querySelectorAll('.navbar-nav .nav-link');
        
        navLinks.forEach(function(link) {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            }
        });
    });
</script>
<!-- jQuery (opcional si no es necesario para otras cosas, pero útil para algunas funciones de Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Popper.js (necesario para Bootstrap 4 y 5) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
