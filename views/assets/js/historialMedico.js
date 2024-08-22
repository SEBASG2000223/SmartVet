function limpiarForms() {
    $('#historial_medico_add').trigger('reset');
    $('#historial_medico_update').trigger('reset');
}

function cancelarForm() {
    limpiarForms();
    $('#formulario_add').show();
    $('#formulario_update').hide();
}

function listarHistorialesTodos() {
    tabla = $('#tbllistado').dataTable({
        aProcessing: true,
        aServerSide: true,
        dom: 'Bfrtip',
        buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
        ajax: {
            url: '../controllers/historialMedicoController.php?op=listar_para_tabla',
            type: 'GET',
            dataType: 'json',
            error: function (e) {
                console.log('Error al listar historiales médicos:', e.responseText);
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
            url: '../controllers/historialMedicoController.php?op=obtener_mascota_por_consulta',
            type: 'POST',
            data: { id_consulta: id_consulta },
            dataType: 'json',
            success: function (data) {
                if (data.id_mascota) {
                    $('#id_mascota').val(data.id_mascota);
                } else {
                    $('#id_mascota').val('');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                toastr.error('Error al obtener la mascota: ' + textStatus + ' - ' + errorThrown);
            }
        });
    }
});

$(function () {
    $('#formulario_update').hide();
    listarHistorialesTodos();
});

$('#historial_medico_add').on('submit', function (event) {
    event.preventDefault();
    $('#btnRegistrar').prop('disabled', true);
    var formData = new FormData($('#historial_medico_add')[0]);
    $.ajax({
        url: '../controllers/historialMedicoController.php?op=insertar',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',  // Asegurarse de que la respuesta es JSON
        success: function (response) {
            if (response.success) {
                toastr.success('Historial médico registrado');
                $('#historial_medico_add')[0].reset();
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
