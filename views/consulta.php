<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Consultas</title>
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
        <div class="row">
            <div class="col-md-12" id="formulario_add">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Agregar una Consulta</h3>
                    </div>
                    <div class="card-body">
                        <form id="consulta_add" method="POST">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="id_mascota">ID Mascota</label>
                                    <input type="number" class="form-control" id="id_mascota" name="id_mascota" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="id_cliente">ID Cliente</label>
                                    <input type="number" class="form-control" id="id_cliente" name="id_cliente" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="id_empleado">ID Empleado</label>
                                    <input type="number" class="form-control" id="id_empleado" name="id_empleado" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="fecha">Fecha</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="descripcion">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="precio">Precio</label>
                                    <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
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

        <div class="row">
            <div class="col-md-12" id="formulario_update" style="display: none;">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Modificar una Consulta</h3>
                    </div>
                    <div class="card-body">
                        <form id="consulta_update" method="POST">
                            <input type="hidden" id="EId" name="id">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="Eid_mascota">ID Mascota</label>
                                    <input type="number" class="form-control" id="Eid_mascota" name="id_mascota" required readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Eid_cliente">ID Cliente</label>
                                    <input type="number" class="form-control" id="Eid_cliente" name="id_cliente" required readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Eid_empleado">ID Empleado</label>
                                    <input type="number" class="form-control" id="Eid_empleado" name="id_empleado" required readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Efecha">Fecha</label>
                                    <input type="date" class="form-control" id="Efecha" name="fecha" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Edescripcion">Descripción</label>
                                    <textarea class="form-control" id="Edescripcion" name="descripcion" rows="3" required></textarea>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Eprecio">Precio</label>
                                    <input type="number" class="form-control" id="Eprecio" name="precio" step="0.01" required>
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

        <div class="row">
            <div class="col-md-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Consultas existentes</h3>
                    </div>
                    <div class="card-body p-0">
                        <table id="tbllistado" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Mascota</th>
                                    <th>Cliente</th>
                                    <th>Empleado</th>
                                    <th>Fecha</th>
                                    <th>Descripción</th>
                                    <th>Precio</th>
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
                                    <th>Mascota</th>
                                    <th>Cliente</th>
                                    <th>Empleado</th>
                                    <th>Fecha</th>
                                    <th>Descripción</th>
                                    <th>Precio</th>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="assets/js/consulta.js"></script>
</body>
</html>
