<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Usuarios</title>
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
                        <h3 class="card-title">Agregar un Usuario</h3>
                    </div>
                    <div class="card-body">
                        <form id="usuario_add" method="POST">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="correo">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="correo" name="correo" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="nombre_usuario">Nombre de Usuario</label>
                                    <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="id_empleado">ID Empleado</label>
                                    <input type="text" class="form-control" id="id_empleado" name="id_empleado" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="id_rol">ID Rol</label>
                                    <select class="form-control" id="id_rol" name="id_rol" required>
                                        <option value="1">Administrador</option>
                                        <option value="2">Doctor</option>
                                        <option value="3">Cajero</option>
                                        <option value="4">Recepcionista</option>
                                        <option value="5">Empleado</option>
                                        <option value="6">Encargado Inventario</option>
                                        <option value="7">Administrador</option>
                                        <option value="8">Doctor</option>
                                        <option value="9">Cajero</option>
                                        <option value="10">Recepcionista</option>
                                        <option value="11">Empleado</option>
                                        <option value="12">Encargado Inventario</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="id_estado">ID Estado</label>
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
                        <h3 class="card-title">Modificar un Usuario</h3>
                    </div>
                    <div class="card-body">
                        <form id="usuario_update" method="POST">
                            <input type="hidden" id="EId" name="id_usuario">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="Ecorreo">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="Ecorreo" name="correo" required readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Enombre_usuario">Nombre de Usuario</label>
                                    <input type="text" class="form-control" id="Enombre_usuario" name="nombre_usuario" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Eid_empleado">ID Empleado</label>
                                    <input type="text" class="form-control" id="Eid_empleado" name="id_empleado" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Eid_rol">ID Rol</label>
                                    <select class="form-control" id="Eid_rol" name="id_rol" required>
                                    <option value="1">Administrador</option>
                                        <option value="2">Doctor</option>
                                        <option value="3">Cajero</option>
                                        <option value="4">Recepcionista</option>
                                        <option value="5">Empleado</option>
                                        <option value="6">Encargado Inventario</option>
                                        <option value="7">Administrador</option>
                                        <option value="8">Doctor</option>
                                        <option value="9">Cajero</option>
                                        <option value="10">Recepcionista</option>
                                        <option value="11">Empleado</option>
                                        <option value="12">Encargado Inventario</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Eid_estado">ID Estado</label>
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
                        <h3 class="card-title">Usuarios existentes</h3>
                    </div>
                    <div class="card-body p-0">
                        <table id="tbllistado" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>id_usuario</th>
                                    <th>id_empleado</th>
                                    <th>id_rol</th>
                                    <th>id_estado</th>
                                    <th>nombre_usuario</th>
                                    <th>correo</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Datos se cargarán dinámicamente -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>id_usuario</th>
                                    <th>id_empleado</th>
                                    <th>id_rol</th>
                                    <th>id_estado</th>
                                    <th>nombre_usuario</th>
                                    <th>correo</th>
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
<script src="assets/js/usuario.js"></script>
</body>
</html>
