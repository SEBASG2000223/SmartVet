
function limpiarForms() {
    $('#detalle_add').trigger('reset');
    $('#detalle_update').trigger('reset');
}

function cancelarForm() {
    limpiarForms();
    $('#formulario_add').show();
    $('#formulario_update').hide();
}

function listarDetallesTodos() {
    tabla = $('#tbllistado').DataTable({
        aProcessing: true,
        aServerSide: true,
        dom: 'Bfrtip',
        buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
        ajax: {
            url: '../controllers/detalleTratamientoController.php?op=listar_para_tabla',
            type: 'get',
            dataType: 'json',
            error: function (e) {
                console.log(e.responseText);
            }
        },
        bDestroy: true,
        iDisplayLength: 5
    });
}

$(function () {
    $('#formulario_update').hide();
    listarDetallesTodos();
});

$('#detalle_add').on('submit', function (event) {
    event.preventDefault();
    $('#btnRegistrar').prop('disabled', true);
    var formData = new FormData($('#detalle_add')[0]);
    $.ajax({
        url: '../controllers/detalleTratamientoController.php?op=insertar',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            var response = datos.trim();
            if (response == '1') {
                toastr.success('Detalle de tratamiento registrado');
                $('#detalle_add')[0].reset();
                tabla.api().ajax.reload();
            } else if (response == '2') {
                toastr.error('El detalle de tratamiento ya existe.');
            } else {
                toastr.error('Hubo un error al tratar de ingresar los datos.');
            }
            $('#btnRegistrar').removeAttr('disabled');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            toastr.error('Error: ' + textStatus + ' - ' + errorThrown);
            $('#btnRegistrar').removeAttr('disabled');
        }
    });
});

$('#tbllistado tbody').on('click', 'button[id="modificarDetalle"]', function () {
    var data = $('#tbllistado').DataTable().row($(this).parents('tr')).data();
    limpiarForms();
    $('#formulario_add').hide();
    $('#formulario_update').show();

    $('#EId').val(data[0]);
    $('#Eid_tratamiento').val(data[1]);
    $('#Eid_medicamento').val(data[2]);
    $('#Eduracion').val(data[3]);
    $('#Edescripcion').val(data[4]);
    $('#Eid_estado').val(data[5]);
    return false;
});

$('#detalle_update').on('submit', function (event) {
    event.preventDefault();
    bootbox.confirm('¿Desea modificar los datos?', function (result) {
        if (result) {
            var formData = new FormData($('#detalle_update')[0]);
            $.ajax({
                url: '../controllers/detalleTratamientoController.php?op=editar',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (datos) {
                    if (datos.trim() == '1') {
                        toastr.success('Detalle de tratamiento actualizado exitosamente');
                        $('#tbllistado').DataTable().ajax.reload(); // Recarga la tabla
                        limpiarForms();
                        $('#formulario_update').hide();
                        $('#formulario_add').show();
                    } else {
                        toastr.error('Error: No se pudieron actualizar los datos.');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    toastr.error('Error de comunicación: ' + textStatus + ' - ' + errorThrown);
                }
            });
        }
    });
});