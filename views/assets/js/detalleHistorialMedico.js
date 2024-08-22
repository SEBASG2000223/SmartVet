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
    tabla = $('#tbllistado').dataTable({
        aProcessing: true, 
        aServerSide: true, 
        dom: 'Bfrtip', 
        buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
        ajax: {
            url: '../controllers/detalleHistorialMedicoController.php?op=listar_para_tabla',
            type: 'get',
            dataType: 'json',
            success: function(data) {
                console.log('Datos recibidos:', data);  // Aquí se muestran los datos recibidos en la consola
                tabla.clear().rows.add(data.aaData).draw();  // Agrega los datos a la tabla y redibuja
            },
            error: function(e) {
                console.log('Error en la llamada AJAX:', e.responseText);  // Muestra el error si la llamada AJAX falla
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
        url: '../controllers/detalleHistorialMedicoController.php?op=insertar',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            var response = datos.trim();
            if (response == '1') {
                toastr.success('Detalle registrado');
                $('#detalle_add')[0].reset();
                tabla.api().ajax.reload();
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

    $('#EIdDetallesHistorial').val(data[0]);
    $('#EIdHistorialMedico').val(data[1]);
    $('#EDescripcion').val(data[2]);
    return false;
});

$('#detalle_update').on('submit', function (event) {
    event.preventDefault();
    bootbox.confirm('¿Desea modificar los datos?', function (result) {
        if (result) {
            var formData = new FormData($('#detalle_update')[0]);
            $.ajax({
                url: '../controllers/detalleHistorialMedicoController.php?op=editar',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (datos) {
                    console.log('Respuesta del servidor:', datos); 
                    if (datos.trim() == '1') {
                        toastr.success('Detalle actualizado exitosamente');
                        tabla.api().ajax.reload(); 
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
