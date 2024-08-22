<?php
require_once '../models/detalleHistorialMedicoModel.php';

switch ($_GET["op"]) {
    case 'listar_para_tabla':
        $detalle_model = new detalleHistorialMedicoModel();
        $detalles = $detalle_model->listarTodosDetalles();
        if (is_array($detalles)) {
            $data = array();
            foreach ($detalles as $detalle) {
                $data[] = array(
                    "0" => $detalle['id_detalles_historial'],
                    "1" => $detalle['id_historial_medico'],
                    "2" => $detalle['descripcion'],
                    "3" => '<button class="btn btn-warning" id="modificarDetalle">Modificar</button>'
                );
            }
            $resultados = array(
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData" => $data
            );
            echo json_encode($resultados);
        } else {
            echo json_encode(array("error" => "No se pudieron obtener los detalles."));
        }
        break;
    

    case 'insertar':
        $id_detalles_historial = isset($_POST["id_detalles_historial"]) ? trim($_POST["id_detalles_historial"]) : null;
        $id_historial_medico = isset($_POST["id_historial_medico"]) ? trim($_POST["id_historial_medico"]) : "";
        $descripcion = isset($_POST["descripcion"]) ? trim($_POST["descripcion"]) : "";

        $detalle = new detalleHistorialMedicoModel();
        $detalle->setIdDetallesHistorial($id_detalles_historial);
        $detalle->setIdHistorialMedico($id_historial_medico);
        $detalle->setDescripcion($descripcion);

        $detalle->guardarDetalle();
        echo 1;
        break;

    case 'mostrar':
        $id_detalles_historial = isset($_POST["id_detalles_historial"]) ? $_POST["id_detalles_historial"] : "";
        $detalle = new detalleHistorialMedicoModel();
        $detalle->setIdDetallesHistorial($id_detalles_historial);
        $encontrado = $detalle->listarTodosDetalles(); // O un método específico para mostrar un detalle

        if ($encontrado != null) {
            echo json_encode($encontrado);
        } else {
            echo 0;
        }
        break;

    case 'editar':
        $id_detalles_historial = isset($_POST["id_detalles_historial"]) ? trim($_POST["id_detalles_historial"]) : "";
        $id_historial_medico = isset($_POST["id_historial_medico"]) ? trim($_POST["id_historial_medico"]) : "";
        $descripcion = isset($_POST["descripcion"]) ? trim($_POST["descripcion"]) : "";

        $detalle = new detalleHistorialMedicoModel();
        $detalle->setIdDetallesHistorial($id_detalles_historial);
        $detalle->setIdHistorialMedico($id_historial_medico);
        $detalle->setDescripcion($descripcion);

        $resultado = $detalle->actualizarDetalle();

        if ($resultado === true) {
            echo 1;
        } else {
            echo 0;
        }
        break;
}
?>
