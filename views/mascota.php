<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Mascotas</title>
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
                        <h3 class="card-title">Agregar una Mascota</h3>
                    </div>
                    <div class="card-body">
                        <form id="mascota_add" method="POST">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="nombre_mascota">Nombre de la Mascota</label>
                                    <input type="text" class="form-control" id="nombre_mascota" name="nombre_mascota" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="id_cliente">ID Cliente</label>
                                    <input type="number" class="form-control" id="id_cliente" name="id_cliente" required>
                                </div>
                                <div class="form-group col-md-4">
    <label for="id_tratamiento">Tratamiento</label>
    <select class="form-control" id="id_tratamiento" name="id_tratamiento" required>
        <option value="">Seleccione un tratamiento</option>
        <option value="1">Vacunacion anual</option>
        <option value="2">Desparasitacion interna</option>
        <option value="3">Limpieza dental</option>
        <option value="4">Corte de unas</option>
        <option value="5">Tratamiento para pulgas y garrapatas</option>
        <option value="6">Castracion</option>
        <option value="7">Estilizado de pelaje</option>
        <option value="8">Examen fisico general</option>
        <option value="9">Extraccion de cuerpo extrano</option>
        <option value="10">Cirugia de emergencia</option>
        <option value="11">Tratamiento de heridas</option>
        <option value="12">Terapia de oxigeno</option>
        <option value="13">Hospitalizacion con monitoreo</option>
        <option value="14">Terapia con fluidos intravenosos</option>
        <option value="15">Analisis de sangre</option>
        <option value="16">Radiografia</option>
        <option value="17">Ecografia</option>
        <option value="18">Vacunacion contra la rabia</option>
        <option value="19">Desinfeccion de oido</option>
        <option value="20">Control de peso</option>
        <option value="21">Revision de tiroides</option>
        <option value="22">Tratamiento para alergias</option>
        <option value="23">Cuidado post-operatorio</option>
        <option value="24">Terapia con laser</option>
        <option value="25">Entrenamiento de conducta</option>
        <option value="26">Control de artritis</option>
        <option value="27">Tratamiento de infecciones urinarias</option>
        <option value="28">Tratamiento de parasitos externos</option>
        <option value="29">Vacunacion contra leptospirosis</option>
        <option value="30">Control de diabetes</option>
        <option value="31">Tratamiento de enfermedades respiratorias</option>
        <option value="32">Revision cardiologica</option>
        <option value="33">Tratamiento para la dermatitis</option>
        <option value="34">Revision oftalmologica</option>
        <option value="35">Tratamiento de fracturas</option>
        <option value="36">Rehabilitacion fisica</option>
        <option value="37">Tratamiento para problemas de piel</option>
        <option value="38">Terapia nutricional</option>
        <option value="39">Vacunacion contra moquillo</option>
        <option value="40">Tratamiento para enfermedades infecciosas</option>
        <option value="41">Analisis de heces</option>
        <option value="42">Tratamiento para dolor cronico</option>
        <option value="43">Limpieza de oidos</option>
        <option value="44">Tratamiento para convulsiones</option>
        <option value="45">Revision ortopedica</option>
        <option value="46">Cuidado de heridas quirurgicas</option>
        <option value="47">Vacunacion contra parvovirus</option>
        <option value="48">Vacunacion contra hepatitis canina</option>
        <option value="49">Control de plagas intestinales</option>
        <option value="50">Examen dental completo</option>
        <option value="51">Chequeo general de salud</option>
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
                        <h3 class="card-title">Modificar una Mascota</h3>
                    </div>
                    <div class="card-body">
                        <form id="mascota_update" method="POST">
                            <input type="hidden" id="EId" name="id">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="Enombre_mascota">Nombre de la Mascota</label>
                                    <input type="text" class="form-control" id="Enombre_mascota" name="nombre_mascota" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Eid_cliente">ID Cliente</label>
                                    <input type="text" class="form-control" id="Eid_cliente" name="id_cliente" required readonly>
                                </div>
                                <div class="form-group col-md-4">
    <label for="Eid_tratamiento">Tratamiento</label>
    <select class="form-control" id="Eid_tratamiento" name="id_tratamiento" required>
        <option value="">Seleccione un tratamiento</option>
        <option value="1">Vacunacion anual</option>
        <option value="2">Desparasitacion interna</option>
        <option value="3">Limpieza dental</option>
        <option value="4">Corte de unas</option>
        <option value="5">Tratamiento para pulgas y garrapatas</option>
        <option value="6">Castracion</option>
        <option value="7">Estilizado de pelaje</option>
        <option value="8">Examen fisico general</option>
        <option value="9">Extraccion de cuerpo extrano</option>
        <option value="10">Cirugia de emergencia</option>
        <option value="11">Tratamiento de heridas</option>
        <option value="12">Terapia de oxigeno</option>
        <option value="13">Hospitalizacion con monitoreo</option>
        <option value="14">Terapia con fluidos intravenosos</option>
        <option value="15">Analisis de sangre</option>
        <option value="16">Radiografia</option>
        <option value="17">Ecografia</option>
        <option value="18">Vacunacion contra la rabia</option>
        <option value="19">Desinfeccion de oido</option>
        <option value="20">Control de peso</option>
        <option value="21">Revision de tiroides</option>
        <option value="22">Tratamiento para alergias</option>
        <option value="23">Cuidado post-operatorio</option>
        <option value="24">Terapia con laser</option>
        <option value="25">Entrenamiento de conducta</option>
        <option value="26">Control de artritis</option>
        <option value="27">Tratamiento de infecciones urinarias</option>
        <option value="28">Tratamiento de parasitos externos</option>
        <option value="29">Vacunacion contra leptospirosis</option>
        <option value="30">Control de diabetes</option>
        <option value="31">Tratamiento de enfermedades respiratorias</option>
        <option value="32">Revision cardiologica</option>
        <option value="33">Tratamiento para la dermatitis</option>
        <option value="34">Revision oftalmologica</option>
        <option value="35">Tratamiento de fracturas</option>
        <option value="36">Rehabilitacion fisica</option>
        <option value="37">Tratamiento para problemas de piel</option>
        <option value="38">Terapia nutricional</option>
        <option value="39">Vacunacion contra moquillo</option>
        <option value="40">Tratamiento para enfermedades infecciosas</option>
        <option value="41">Analisis de heces</option>
        <option value="42">Tratamiento para dolor cronico</option>
        <option value="43">Limpieza de oidos</option>
        <option value="44">Tratamiento para convulsiones</option>
        <option value="45">Revision ortopedica</option>
        <option value="46">Cuidado de heridas quirurgicas</option>
        <option value="47">Vacunacion contra parvovirus</option>
        <option value="48">Vacunacion contra hepatitis canina</option>
        <option value="49">Control de plagas intestinales</option>
        <option value="50">Examen dental completo</option>
        <option value="51">Chequeo general de salud</option>
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
        <div class="row">
            <div class="col-md-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Mascotas existentes</h3>
                    </div>
                    <div class="card-body p-0">
                        <table id="tbllistado" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre de la Mascota</th>
                                    <th>Tratamiento</th>
                                    <th>ID Cliente</th>
                                    <th>Nombre Cliente</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Datos se cargarán dinámicamente -->
                            </tbody>
                            <tfoot>
                                <tr>
                                <th>ID</th>
                                    <th>Nombre de la Mascota</th>
                                    <th>Tratamiento</th>
                                    <th>ID Cliente</th>
                                    <th>Nombre Cliente</th>
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
<script src="assets/js/mascota.js"></script>
</body>
</html>