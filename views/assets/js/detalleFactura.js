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
            url: '../controllers/detalleFacturaController.php?op=listar_para_tabla',
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
        url: '../controllers/detalleFacturaController.php?op=insertar',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log('Respuesta del servidor:', datos); // Para depurar, muestra la respuesta completa
            try {
                var response = JSON.parse(datos); // Asegúrate de que la respuesta es JSON válida
                if (response.status === "success") {
                    toastr.success('Detalle de factura registrado exitosamente');
                    $('#detalle_add')[0].reset();
                    tabla.ajax.reload(); // Recarga la tabla usando la API de DataTables
                } else {
                    toastr.error('Error al tratar de ingresar los datos: ' + response.status);
                }
            } catch (error) {
                toastr.error('Error al procesar la respuesta del servidor: ' + error.message);
            }
            $('#btnRegistrar').removeAttr('disabled');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            toastr.error('Error: ' + textStatus + ' - ' + errorThrown);
            $('#btnRegistrar').removeAttr('disabled');
        }
    });
});


$('#tbllistado tbody').on('click', 'button[id="modificarDetalleFactura"]', function () {
    var data = $('#tbllistado').DataTable().row($(this).parents('tr')).data();
    limpiarForms();
    $('#formulario_add').hide();
    $('#formulario_update').show();

    $('#EIdDetalles').val(data[0]);
    $('#EIdFactura').val(data[1]);
    $('#EIdEstado').val(data[2]);
    $('#ETotal').val(data[3]);
    return false;
});

$('#detalle_update').on('submit', function (event) {
    event.preventDefault();
    bootbox.confirm('¿Desea modificar los datos?', function (result) {
        if (result) {
            var formData = new FormData($('#detalle_update')[0]);
            $.ajax({
                url: '../controllers/detalleFacturaController.php?op=editar',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (datos) {
                    console.log('Respuesta del servidor:', datos);
                    if (datos.trim() == '1') {
                        toastr.success('Detalle de factura actualizado exitosamente');
                        tabla.ajax.reload(); // Cambiado para usar la API de DataTables
                        limpiarForms();
                        $('#formulario_update').hide();
                        $('#formulario_add').show();
                    } else {
                        toastr.error('Error: No se pudieron actualizar los datos. Respuesta del servidor: ' + datos);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log('Error AJAX:', jqXHR.responseText);
                    toastr.error('Error de comunicación: ' + textStatus + ' - ' + errorThrown);
                }
            });
        }
    });
});
