
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
                    <li class="nav-item"><a class="nav-link" href="mascota.php">Mascotas</a></li>
                    <li class="nav-item"><a class="nav-link" href="detalleMascota.php">Detalles Mascota</a></li>
                    <li class="nav-item"><a class="nav-link" href="consulta.php">Consultas</a></li>
                    <li class="nav-item"><a class="nav-link" href="inventario.php">Inventario</a></li>
                    <li class="nav-item"><a class="nav-link" href="tratamiento.php">Tratamientos</a></li>
                    <li class="nav-item"><a class="nav-link" href="medicamento.php">Medicamentos</a></li>
                    <li class="nav-item"><a class="nav-link" href="factura.php">Facturas</a></li>
                    <li class="nav-item"><a class="nav-link" href="recetas.php">Recetas</a></li>
                    <li class="nav-item"><a class="nav-link" href="detalleHistorialMedico.php">Detalle Historial Médico</a></li>
                    <li class="nav-item"><a class="nav-link" href="detalleFactura.php">Detalles Factura</a></li>
                    <li class="nav-item"><a class="nav-link" href="historialMedico.php">Historial Médico</a></li>
                    <li class="nav-item"><a class="nav-link" href="usuario.php">Usuarios</a></li>
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
