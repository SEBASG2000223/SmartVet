<?php
require_once '../models/detalleTratamientoModel.php';

switch ($_GET["op"]) {
    case 'listar_para_tabla':
        $detalle_model = new detalleTratamientoModel();
        $detalles = $detalle_model->listarDetallesTratamientos();
        $data = array();
        foreach ($detalles as $detalle) {
            $data[] = array(
                "0" => $detalle['id_detalles_tratamientos'],
                "1" => $detalle['id_tratamiento'],
                "2" => $detalle['id_medicamento'],
                "3" => $detalle['duracion_tratamiento'],
                "4" => $detalle['descripcion_tratamiento'],
                "5" => $detalle['estado'], // Mostrar solo el estado como texto
                "6" => '<button class="btn btn-warning" id="modificarDetalle">Modificar</button>'
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
        $id_tratamiento = isset($_POST["id_tratamiento"]) ? trim($_POST["id_tratamiento"]) : 0;
        $id_medicamento = isset($_POST["id_medicamento"]) ? trim($_POST["id_medicamento"]) : 0;
        $id_estado = isset($_POST["id_estado"]) ? trim($_POST["id_estado"]) : 1;
        $duracion_tratamiento = isset($_POST["duracion_tratamiento"]) ? trim($_POST["duracion_tratamiento"]) : "";
        $descripcion_tratamiento = isset($_POST["descripcion_tratamiento"]) ? trim($_POST["descripcion_tratamiento"]) : "";

        $detalle = new detalleTratamientoModel();
        $detalle->setIdTratamiento($id_tratamiento);
        $detalle->setIdMedicamento($id_medicamento);
        $detalle->setIdEstado($id_estado);
        $detalle->setDuracionTratamiento($duracion_tratamiento);
        $detalle->setDescripcionTratamiento($descripcion_tratamiento);

        $detalle->guardarDetalleTratamiento();
        echo 1;
        break;

    case 'mostrar':
        $id_detalles_tratamientos = isset($_POST["idDetallesTratamientos"]) ? $_POST["idDetallesTratamientos"] : "";
        $detalle = new detalleTratamientoModel();
        $detalle->setIdDetallesTratamientos($id_detalles_tratamientos);
        $encontrado = $detalle->mostrar();

        if ($encontrado != null) {
            echo json_encode($encontrado);
        } else {
            echo 0;
        }
        break;

        case 'editar':
            $id = isset($_POST["id"]) ? trim($_POST["id"]) : "";
            $id_tratamiento = isset($_POST["id_tratamiento"]) ? trim($_POST["id_tratamiento"]) : 0;
            $id_medicamento = isset($_POST["id_medicamento"]) ? trim($_POST["id_medicamento"]) : 0;
            $id_estado = isset($_POST["id_estado"]) ? trim($_POST["id_estado"]) : 1;
            $duracion_tratamiento = isset($_POST["duracion_tratamiento"]) ? trim($_POST["duracion_tratamiento"]) : "";
            $descripcion_tratamiento = isset($_POST["descripcion_tratamiento"]) ? trim($_POST["descripcion_tratamiento"]) : "";
        
            $detalle = new detalleTratamientoModel();
            $resultado = $detalle->actualizarDetalleTratamiento($id, $id_tratamiento, $id_medicamento, $duracion_tratamiento, $descripcion_tratamiento, $id_estado);
        
            if ($resultado) {
                echo 1; // Actualización exitosa
            } else {
                echo 0; // Error en la actualización
            }
            break;
}
?>