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

    $('#id_mascota').on('change', function () {
        var id_mascota = $(this).val();
        if (id_mascota) {
            $.ajax({
                url: '../controllers/consultaController.php?op=obtener_cliente_por_mascota',
                type: 'POST',
                data: { id_mascota: id_mascota },
                success: function (data) {
                    data = JSON.parse(data);
                    if (data.id_cliente) {
                        $('#id_cliente').val(data.id_cliente);
                    } else {
                        toastr.error('No se encontró un cliente asociado con esta mascota.');
                        $('#id_cliente').val('');
                    }
                },
                error: function (xhr, status, error) {
                    toastr.error('Ocurrió un error al buscar el cliente.');
                }
            });
        } else {
            toastr.warning('Por favor, ingrese un ID de mascota válido.');
        }
    });
    
    // Añadir el evento para el formulario de agregar consulta
    $('#consulta_add').on('submit', function (e) {
        e.preventDefault();
        var datos = $(this).serialize();
        $.ajax({
            url: '../controllers/consultaController.php?op=insertar',
            type: 'POST',
            data: datos,
            success: function (data) {
                try {
                    data = JSON.parse(data);
                    if (data.success) {
                        toastr.success(data.message);
                        limpiarForms();
                        listarConsultasTodos();
                    } else {
                        toastr.error(data.message);
                    }
                } catch (e) {
                    toastr.error('Error al procesar la respuesta del servidor.');
                }
            },
            error: function (xhr, status, error) {
                toastr.error('Ocurrió un error al agregar la consulta.');
            }
        });
    });
    
    

    // Añadir el evento para el formulario de actualizar consulta
    $('#consulta_update').on('submit', function (e) {
        e.preventDefault();
        var datos = $(this).serialize();
        $.ajax({
            url: '../controllers/consultaController.php?op=actualizar',
            type: 'POST',
            data: datos,
            success: function (data) {
                data = JSON.parse(data);
                if (data.success) {
                    toastr.success(data.message);
                    limpiarForms();
                    listarConsultasTodos();
                } else {
                    toastr.error(data.message);
                }
            },
            error: function (xhr, status, error) {
                toastr.error('Ocurrió un error al actualizar la consulta.');
            }
        });
    });

    

    // Evento para el botón "Modificar" en la tabla
    $('#tbllistado tbody').on('click', 'button[id="modificarConsulta"]', function () {
        var data = $('#tbllistado').DataTable().row($(this).parents('tr')).data();
        limpiarForms();
        $('#formulario_add').hide();
        $('#formulario_update').show();

        // Asignar valores a los campos del formulario de actualización
        $('#EId').val(data[0]);              // ID_CONSULTA
        $('#Eid_mascota').val(data[1]);       // ID_MASCOTA
        $('#Enombre_mascota').val(data[2]); 
        $('#Eid_cliente').val(data[3]);
        $('#Enombre_cliente').val(data[4]);
        $('#EID_EMPLEADO').val(data[5]);  // NOMBRE_CLIENTE
        $('#Efecha').val(convertirFecha(data[6]));            // FECHA
        $('#Edescripcion').val(data[7]);      // DESCRIPCION
        $('#Eprecio').val(data[8]); 
        $('#ENOMBRE_ESTADO').val(data[9]); 
                  // PRECIO

        return false;
    });
});

function convertirFecha(fecha) {
    const partes = fecha.split('/');
    return `20${partes[2]}-${partes[1]}-${partes[0]}`;
}

function mostrarForm(id_consulta) {
    $.post("../controllers/consultaController.php?op=mostrar", { id_consulta: id_consulta }, function (data) {
        data = JSON.parse(data);
        $('#EId').val(data.id_consulta);
        $('#Eid_mascota').val(data.id_mascota);
        $('#Eid_cliente').val(data.id_cliente);
        $('#Eemail_address').val(data.email_address);
        $('#Efull_name').val(data.full_name);
        $('#formulario_add').hide();
        $('#formulario_update').show();
    });
}


