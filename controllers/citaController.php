<?php
require_once '../models/citaModel.php';

switch ($_GET["op"]) {
    case 'listar_para_tabla':
        $cita_model = new citaModel();
        $citas = $cita_model->listarTodasCitas();
        $data = array();
        foreach ($citas as $cita) {
            $data[] = array(
                "0" => $cita['id_cita'],
                "1" => $cita['id_cliente'],
                "2" => $cita['fecha'],
                "3" => $cita['hora'],
                "4" => $cita['estado'], // Mostrar solo el estado como texto
                "5" => '<button class="btn btn-warning" id="modificarCita">Modificar</button>'
            );
        }
        $resultados = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($resultados);
        break;
    
    


    case 'insertar':
        $id_cliente = isset($_POST["id_cliente"]) ? trim($_POST["id_cliente"]) : 0;
        $id_estado = isset($_POST["id_estado"]) ? trim($_POST["id_estado"]) : 1;
        $hora = isset($_POST["hora"]) ? trim($_POST["hora"]) : "";
        $fecha = isset($_POST["fecha"]) ? trim($_POST["fecha"]) : "";

        $cita = new citaModel();
        $cita->setIdCliente($id_cliente);
        $cita->setIdEstado($id_estado);
        $cita->setHora($hora);
        $cita->setFecha($fecha);
        
        $cita->guardarCita();
        echo 1;
        break;


    case 'mostrar':
        $id_cita = isset($_POST["idCita"]) ? $_POST["idCita"] : "";
        $cita = new citaModel();
        $cita->setIdCita($id_cita);
        $encontrado = $cita->mostrar();

        if ($encontrado != null) {
            echo json_encode($encontrado);
        } else {
            echo 0;
        }
        break;

    case 'editar':
        $id = isset($_POST["id"]) ? trim($_POST["id"]) : "";
        $id_cliente = isset($_POST["id_cliente"]) ? trim($_POST["id_cliente"]) : 0;
        $id_estado = isset($_POST["id_estado"]) ? trim($_POST["id_estado"]) : 1;
        $hora = isset($_POST["hora"]) ? trim($_POST["hora"]) : "";
        $fecha = isset($_POST["fecha"]) ? trim($_POST["fecha"]) : "";

        $cita = new citaModel();
        $cita->setIdCita($id);
        $cita->setIdCliente($id_cliente);
        $cita->setIdEstado($id_estado);
        $cita->setHora($hora);
        $cita->setFecha($fecha);

        $resultado = $cita->actualizarCita();

        if ($resultado === true) {
            echo 1;
        } else {
            echo 0;
        }
        break;
}
?>
