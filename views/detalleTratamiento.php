
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Detalles de Tratamiento</title>
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
        <!-- Formulario para Agregar Detalle de Tratamiento -->
        <div class="row">
            <div class="col-md-12" id="formulario_add">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Agregar un Detalle de Tratamiento</h3>
                    </div>
                    <div class="card-body">
                        <form id="detalle_add" method="POST">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="id_tratamiento">ID Tratamiento</label>
                                    <input type="number" class="form-control" id="id_tratamiento" name="id_tratamiento" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="id_medicamento">ID Medicamento</label>
                                    <input type="number" class="form-control" id="id_medicamento" name="id_medicamento" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="duracion">Duración de Tratamiento</label>
                                    <input type="text" class="form-control" id="duracion" name="duracion" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="id_estado">Estado</label>
                                    <select class="form-control" id="id_estado" name="id_estado" required>
                                        <option value="1">Activo</option>
                                        <option value="2">Inactivo</option>
                                        <option value="3">Pendiente</option>
                                        <option value="4">Pagado</option>
                                        <option value="5">Cancelado</option>
                                        <option value="6">Completado</option>
                                        <option value="7">En Proceso</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="descripcion">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
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

        <!-- Formulario para Modificar Detalle de Tratamiento -->
        <div class="row">
            <div class="col-md-12" id="formulario_update" style="display: none;">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Modificar un Detalle de Tratamiento</h3>
                    </div>
                    <div class="card-body">
                        <form id="detalle_update" method="POST">
                            <input type="hidden" id="EId" name="id">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="Eid_tratamiento">ID Tratamiento</label>
                                    <input type="number" class="form-control" id="Eid_tratamiento" name="id_tratamiento" required >
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Eid_medicamento">ID Medicamento</label>
                                    <input type="number" class="form-control" id="Eid_medicamento" name="id_medicamento" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Eduracion">Duración de Tratamiento</label>
                                    <input type="text" class="form-control" id="Eduracion" name="duracion" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Eid_estado">Estado</label>
                                    <select class="form-control" id="Eid_estado" name="id_estado" required>
                                        <option value="1">Activo</option>
                                        <option value="2">Inactivo</option>
                                        <option value="3">Pendiente</option>
                                        <option value="4">Pagado</option>
                                        <option value="5">Cancelado</option>
                                        <option value="6">Completado</option>
                                        <option value="7">En Proceso</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="Edescripcion">Descripción</label>
                                    <textarea class="form-control" id="Edescripcion" name="descripcion" rows="3" required></textarea>
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

        <!-- Tabla para Listar Detalles de Tratamiento -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Detalles de Tratamientos Existentes</h3>
                    </div>
                    <div class="card-body p-0">
                        <table id="tbllistado" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                <th>ID</th>
                                    <th>ID Tratamiento</th>
                                    <th>ID Medicamento</th>
                                    <th>Duración de Tratamiento</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Datos se cargarán dinámicamente -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>ID Tratamiento</th>
                                    <th>ID Medicamento</th>
                                    <th>Duración de Tratamiento</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
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
<script src="assets/js/detalleTratamiento.js"></script>
</body>
</html>