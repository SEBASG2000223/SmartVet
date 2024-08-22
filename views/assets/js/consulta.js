function limpiarForms() {
    $('#consulta_add').trigger('reset');
    $('#consulta_update').trigger('reset');
}

function cancelarForm() {
    limpiarForms();
    $('#formulario_add').show();
    $('#formulario_update').hide();
}

function listarConsultasTodos() {
    tabla = $('#tbllistado').dataTable({
        aProcessing: true, 
        aServerSide: true, 
        dom: 'Bfrtip', 
        buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
        ajax: {
            url: '../controllers/consultaController.php?op=listar_para_tabla',
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
    listarConsultasTodos();
});

$('#consulta_add').on('submit', function (event) {
    event.preventDefault();
    $('#btnRegistrar').prop('disabled', true);
    var formData = new FormData($('#consulta_add')[0]);
    $.ajax({
        url: '../controllers/consultaController.php?op=insertar',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            var response = datos.trim();
            if (response == '1') {
                toastr.success('Consulta registrada');
                $('#consulta_add')[0].reset();
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

function convertirFecha(fecha) {
    const partes = fecha.split('-');
    return `20${partes[2]}-${partes[1]}-${partes[0]}`;
}

function convertirHora(hora) {
    const partesHora = hora.split(' ')[1].split(':'); 
    return `${partesHora[0]}:${partesHora[1]}:00`; 
}

$('#tbllistado tbody').on('click', 'button[id="modificarConsulta"]', function () {
    var data = $('#tbllistado').DataTable().row($(this).parents('tr')).data();
    limpiarForms();
    $('#formulario_add').hide();
    $('#formulario_update').show();

    $('#EId').val(data[0]);
    $('#Eid_mascota').val(data[1]);
    $('#Eid_cliente').val(data[2]);
    $('#Eid_empleado').val(data[3]);
    $('#Efecha').val(convertirFecha(data[4])); 
    $('#Edescripcion').val(data[5]);
    $('#Eprecio').val(data[6]);
    $('#Eid_estado').val(data[7]);
    return false;
});

$('#consulta_update').on('submit', function (event) {
    event.preventDefault();
    bootbox.confirm('¿Desea modificar los datos?', function (result) {
        if (result) {
            var formData = new FormData($('#consulta_update')[0]);
            $.ajax({
                url: '../controllers/consultaController.php?op=editar',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (datos) {
                    console.log('Respuesta del servidor:', datos); 
                    if (datos.trim() == '1') {
                        toastr.success('Consulta actualizada exitosamente');
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
