function limpiarForms() {
    $('#cita_add').trigger('reset');
    $('#cita_update').trigger('reset');
}

function cancelarForm() {
    limpiarForms();
    $('#formulario_add').show();
    $('#formulario_update').hide();
}

function listarCitasTodos() {
    tabla = $('#tbllistado').dataTable({
        aProcessing: true, 
        aServerSide: true, 
        dom: 'Bfrtip', 
        buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
        ajax: {
            url: '../controllers/citaController.php?op=listar_para_tabla',
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
    listarCitasTodos();
});

$('#cita_add').on('submit', function (event) {
    event.preventDefault();
    $('#btnRegistrar').prop('disabled', true);
    var formData = new FormData($('#cita_add')[0]);
    $.ajax({
        url: '../controllers/citaController.php?op=insertar',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            var response = datos.trim();
            if (response == '1') {
                toastr.success('Cita registrada');
                $('#cita_add')[0].reset();
                tabla.api().ajax.reload();
            } else if (response == '2') {
                toastr.error('La cita ya existe.');
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

function convertirFecha(fecha) {
    const partes = fecha.split('/');
    return `20${partes[2]}-${partes[1]}-${partes[0]}`;
}

function convertirHora(hora) {
    const partesHora = hora.split(' ')[1].split(':'); 
    return `${partesHora[0]}:${partesHora[1]}:00`; 
}

$('#tbllistado tbody').on('click', 'button[id="modificarCita"]', function () {
    var data = $('#tbllistado').DataTable().row($(this).parents('tr')).data();
    limpiarForms();
    $('#formulario_add').hide();
    $('#formulario_update').show();

    $('#EId').val(data[0]);
    $('#Eid_cliente').val(data[1]);
    $('#Efecha').val(convertirFecha(data[2])); 
    $('#Ehora').val(convertirHora(data[3]));   
    $('#Eid_estado').val(data[4]);
    return false;
});

$('#cita_update').on('submit', function (event) {
    event.preventDefault();
    bootbox.confirm('¿Desea modificar los datos?', function (result) {
        if (result) {
            var formData = new FormData($('#cita_update')[0]);
            $.ajax({
                url: '../controllers/citaController.php?op=editar',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (datos) {
                    console.log('Respuesta del servidor:', datos); 
                    if (datos.trim() == '1') {
                        toastr.success('Cita actualizada exitosamente');
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
