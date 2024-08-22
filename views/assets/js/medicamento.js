function limpiarForms() {
    $('#medicamento_add').trigger('reset');
    $('#medicamento_update').trigger('reset');
}

function cancelarForm() {
    limpiarForms();
    $('#formulario_add').show();
    $('#formulario_update').hide();
}

function listarMedicamentosTodos() {
    tabla = $('#tbllistado').DataTable({
        processing: true,
        serverSide: true,
        dom: 'Bfrtip',
        buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
        ajax: {
            url: '../controllers/medicamentoController.php?op=listar_para_tabla',
            type: 'GET',
            dataType: 'json',
            error: function (xhr, error, thrown) {
                console.error('Error en la solicitud AJAX:', thrown);
                console.error('Detalles del error:', xhr.responseText);
            }
        },
        destroy: true,
        pageLength: 5,
        columns: [
            { data: 'id_medicamento' },
            { data: 'nombre_medicamento' },
            { data: 'descripcion_medicamento' },
            { data: 'id_inventario' },
            { data: 'acciones' }
        ]
    });
}

$(function () {
    listarMedicamentosTodos();
});

$('#medicamento_add').on('submit', function (event) {
    event.preventDefault();
    $('#btnRegistrar').prop('disabled', true);
    var formData = new FormData($('#medicamento_add')[0]);
    $.ajax({
        url: '../controllers/medicamentoController.php?op=insertar',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            var response = datos.trim();
            if (response == '1') {
                toastr.success('Medicamento registrado');
                $('#medicamento_add')[0].reset();
                tabla.ajax.reload();
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

$('#tbllistado tbody').on('click', 'button[id="modificarMedicamento"]', function () {
    var data = $('#tbllistado').DataTable().row($(this).parents('tr')).data();
    limpiarForms();
    $('#formulario_add').hide();
    $('#formulario_update').show();

    $('#EId').val(data.id_medicamento);
    $('#Enombre_medicamento').val(data.nombre_medicamento);
    $('#Edescripcion_medicamento').val(data.descripcion_medicamento);
    $('#Eid_inventario').val(data.id_inventario);
    return false;
});

$('#medicamento_update').on('submit', function (event) {
    event.preventDefault();
    bootbox.confirm('¿Desea modificar los datos?', function (result) {
        if (result) {
            var formData = new FormData($('#medicamento_update')[0]);
            $.ajax({
                url: '../controllers/medicamentoController.php?op=editar',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (datos) {
                    if (datos.trim() == '1') {
                        toastr.success('Medicamento actualizado exitosamente');
                        tabla.ajax.reload();
                        limpiarForms();
                        $('#formulario_update').hide();
                        $('#formulario_add').show();
                    } else {
                        toastr.error('Error: No se pudieron actualizar los datos. Respuesta del servidor: ' + datos);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    toastr.error('Error de comunicación: ' + textStatus + ' - ' + errorThrown);
                }
            });
        }
    });
});
