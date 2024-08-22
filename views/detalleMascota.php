<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Detalles de Mascotas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body>
<header>
    <?php include 'header.php'; ?>
</header>

<section>
    <div class="container mt-4">
        <!-- Formulario para agregar detalle de mascota -->
        <div class="row">
            <div class="col-md-12" id="formulario_add">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Agregar un Detalle de Mascota</h3>
                    </div>
                    <div class="card-body">
                        <form id="detalle_add" method="POST">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="id_mascota">ID de Mascota</label>
                                    <input type="number" class="form-control" id="id_mascota" name="id_mascota" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="peso">Peso</label>
                                    <input type="text" class="form-control" id="peso" name="peso" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="especie">Especie</label>
                                    <input type="text" class="form-control" id="especie" name="especie" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="raza">Raza</label>
                                    <input type="text" class="form-control" id="raza" name="raza" required>
                                </div>
                                <div class="form-group col-md-4">
    <label for="genero">Género</label>
    <select class="form-control" id="genero" name="genero" required>
        <option value="" disabled selected>Selecciona una opción</option>
        <option value="M">Masculino</option>
        <option value="F">Femenino</option>
    </select>
</div>

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input type="submit" id="btnRegistrar" class="btn btn-success" value="Registrar">
                                    <input type="reset" class="btn btn-warning" value="Borrar datos">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario para actualizar detalle de mascota -->
        <div class="row">
            <div class="col-md-12" id="formulario_update" style="display: none;">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Modificar un Detalle de Mascota</h3>
                    </div>
                    <div class="card-body">
                        <form id="detalle_update" method="POST">
                            <input type="hidden" id="EIdDetallesMascotas" name="id_detalles_mascotas">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="EIdMascota">ID de Mascota</label>
                                    <input type="number" class="form-control" id="EIdMascota" name="id_mascota" required readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Epeso">Peso</label>
                                    <input type="text" class="form-control" id="Epeso" name="peso" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Eespecie">Especie</label>
                                    <input type="text" class="form-control" id="Eespecie" name="especie" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Eraza">Raza</label>
                                    <input type="text" class="form-control" id="Eraza" name="raza" required>
                                </div>
                               
                                <div class="form-group col-md-4">
    <label for="Egenero">Género</label>
    <select class="form-control" id="Egenero" name="genero" required>
        <option value="" disabled selected>Selecciona una opción</option>
        <option value="M">Masculino</option>
        <option value="F">Femenino</option>
    </select>
</div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input type="submit" class="btn btn-warning" value="Modificar">
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="button" class="btn btn-info" value="Cancelar" onclick="cancelarForm()">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <!-- Tabla para mostrar los detalles de mascotas -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Detalles de Mascotas Existentes</h3>
                    </div>
                    <div class="card-body p-0">
                        <table id="tbllistado" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>ID de Mascota</th>
                                    <th>Peso</th>
                                    <th>Especie</th>
                                    <th>Raza</th>
                                    <th>Género</th>
                                    <th>Nombre de Mascota</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Datos se cargarán dinámicamente -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>ID de Mascota</th>
                                    <th>Peso</th>
                                    <th>Especie</th>
                                    <th>Raza</th>
                                    <th>Género</th>
                                    <th>Nombre de Mascota</th>
                                    <th>Opciones</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="assets/js/detalleMascota.js"></script>
</body>
</html>
