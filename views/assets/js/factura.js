function limpiarForms() {
    $('#factura_add').trigger('reset');
    $('#factura_update').trigger('reset');
}

function cancelarForm() {
    limpiarForms();
    $('#formulario_add').show();
    $('#formulario_update').hide();
}

function listarFacturasTodos() {
    tabla = $('#tbllistado').dataTable({
        aProcessing: true,
        aServerSide: true,
        dom: 'Bfrtip',
        buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
        ajax: {
            url: '../controllers/facturaController.php?op=listar_para_tabla',
            type: 'GET',
            dataType: 'json',
            error: function (e) {
                console.log('Error al listar facturas:', e.responseText);
            }
        },
        bDestroy: true,
        iDisplayLength: 5
    });
}

$('#id_consulta').on('change', function () {
    var id_consulta = $(this).val();
    if (id_consulta) {
        $.ajax({
            url: '../controllers/facturaController.php?op=obtener_cliente_por_consulta',
            type: 'POST',
            data: { id_consulta: id_consulta },
            dataType: 'json',
            success: function (data) {
                if (data.id_cliente) {
                    $('#id_cliente').val(data.id_cliente);
                } else {
                    $('#id_cliente').val('');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                toastr.error('Error al obtener el cliente: ' + textStatus + ' - ' + errorThrown);
            }
        });
    }
});

$(function () {
    $('#formulario_update').hide();
    listarFacturasTodos();
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
        dataType: 'json',  // Asegurarse de que la respuesta es JSON
        success: function (response) {
            if (response.status === 'success') {
                toastr.success('Detalle de factura registrado');
                $('#detalle_add')[0].reset();
                tabla.ajax.reload(); // Recargar la tabla
            } else {
                toastr.error('Hubo un error al tratar de ingresar los datos.');
            }
            $('#btnRegistrar').prop('disabled', false);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            toastr.error('Error: ' + textStatus + ' - ' + errorThrown);
            $('#btnRegistrar').prop('disabled', false);
        }
    });
});




