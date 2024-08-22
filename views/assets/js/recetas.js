function limpiarForms() {
    $('#receta_add').trigger('reset');
    $('#receta_update').trigger('reset');
}

function cancelarForm() {
    limpiarForms();
    $('#formulario_add').show();
    $('#formulario_update').hide();
}

function listarRecetasTodas() {
    tabla = $('#tbllistado').dataTable({
        aProcessing: true, 
        aServerSide: true, 
        dom: 'Bfrtip', 
        buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
        ajax: {
            url: '../controllers/recetasController.php?op=listar_para_tabla',
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
    listarRecetasTodas();
});

$('#receta_add').on('submit', function (event) {
    event.preventDefault();
    $('#btnRegistrar').prop('disabled', true);
    var formData = new FormData($('#receta_add')[0]);
    $.ajax({
        url: '../controllers/recetasController.php?op=insertar',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            var response = datos.trim();
            if (response == '1') {
                toastr.success('Receta registrada');
                $('#receta_add')[0].reset();
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

$('#tbllistado tbody').on('click', 'button[id="modificarReceta"]', function () {
    var data = $('#tbllistado').DataTable().row($(this).parents('tr')).data();
    limpiarForms();
    $('#formulario_add').hide();
    $('#formulario_update').show();

    $('#EId').val(data[0]);
    $('#Edescripcion').val(data[1]);
    $('#Enombre_medicamento').val(data[2]);
    $('#Enombre_mascota').val(data[3]);
    return false;
});

$('#receta_update').on('submit', function (event) {
    event.preventDefault();
    bootbox.confirm('¿Desea modificar los datos?', function (result) {
        if (result) {
            var formData = new FormData($('#receta_update')[0]);
            $.ajax({
                url: '../controllers/recetasController.php?op=editar',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (datos) {
                    console.log('Respuesta del servidor:', datos); 
                    if (datos.trim() == '1') {
                        toastr.success('Receta actualizada exitosamente');
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
