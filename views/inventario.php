<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Inventarios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
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
                        <h3 class="card-title">Agregar al Inventario</h3>
                    </div>
                    <div class="card-body">
                        <form id="inventario_add" method="POST">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="id_medicamento">ID Medicamento</label>
                                    <input type="text" class="form-control" id="id_medicamento" name="id_medicamento" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cantidad">Cantidad</label>
                                    <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="precio">Precio</label>
                                    <input type="number" class="form-control" id="precio" name="precio" required>
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
                        <h3 class="card-title">Modificar Inventario</h3>
                    </div>
                    <div class="card-body">
                        <form id="inventario_update" method="POST">
                            <input type="hidden" id="EId" name="id_inventario">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="Eid_medicamento">ID Medicamento</label>
                                    <input type="text" class="form-control" id="Eid_medicamento" name="id_medicamento" required readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Ecantidad">Cantidad</label>
                                    <input type="number" class="form-control" id="Ecantidad" name="cantidad" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Eprecio">Precio</label>
                                    <input type="number" class="form-control" id="Eprecio" name="precio" required>
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
        <div class="row">
            <div class="col-md-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Inventarios existentes</h3>
                    </div>
                    <div class="card-body p-0">
                        <table id="tbllistado" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID Inventario</th>
                                    <th>ID Medicamento</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Datos se cargarán dinámicamente -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID Inventario</th>
                                    <th>ID Medicamento</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
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
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="assets/js/inventario.js"></script>
</body>
</html>
