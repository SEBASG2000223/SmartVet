<?php
require_once '../models/medicamentoModel.php';
header('Content-Type: application/json; charset=utf-8');
mb_internal_encoding("UTF-8");

switch ($_GET["op"]) {
    case 'listar_para_tabla':
        $medicamento_model = new medicamentoModel();
        $medicamentos = $medicamento_model->listarMedicamentos();
        $data = array();
        
        foreach ($medicamentos as $medicamento) {
            $data[] = array(
                "id_medicamento" => isset($medicamento['id_medicamento']) ? $medicamento['id_medicamento'] : 'N/A',
                "nombre_medicamento" => isset($medicamento['nombre_medicamento']) ? $medicamento['nombre_medicamento'] : 'N/A',
                "descripcion_medicamento" => isset($medicamento['descripcion_medicamento']) ? $medicamento['descripcion_medicamento'] : 'N/A',
                "id_inventario" => isset($medicamento['id_inventario']) ? $medicamento['id_inventario'] : 'N/A',
                "acciones" => '<button class="btn btn-warning" id="modificarMedicamento">Modificar</button>'
            );
        }
        
        $resultados = array(
            "sEcho" => isset($_GET['sEcho']) ? intval($_GET['sEcho']) : 0,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        
        echo json_encode($resultados);
        break;
    
    case 'insertar':
        $id_medicamento = isset($_POST["id_medicamento"]) ? trim($_POST["id_medicamento"]) : "";
        $nombre_medicamento = isset($_POST["nombre_medicamento"]) ? trim($_POST["nombre_medicamento"]) : "";
        $descripcion_medicamento = isset($_POST["descripcion_medicamento"]) ? trim($_POST["descripcion_medicamento"]) : "";
        $id_inventario = isset($_POST["id_inventario"]) ? trim($_POST["id_inventario"]) : "";

        $medicamento = new medicamentoModel();
        $medicamento->setIdMedicamento($id_medicamento);
        $medicamento->setNombreMedicamento($nombre_medicamento);
        $medicamento->setDescripcionMedicamento($descripcion_medicamento);
        $medicamento->setIdInventario($id_inventario);
        
        $medicamento->guardarMedicamento();
        echo 1;
        break;

    case 'editar':
        $id_medicamento = isset($_POST["id_medicamento"]) ? trim($_POST["id_medicamento"]) : "";
        $nombre_medicamento = isset($_POST["nombre_medicamento"]) ? trim($_POST["nombre_medicamento"]) : "";
        $descripcion_medicamento = isset($_POST["descripcion_medicamento"]) ? trim($_POST["descripcion_medicamento"]) : "";
        $id_inventario = isset($_POST["id_inventario"]) ? trim($_POST["id_inventario"]) : "";

        $medicamento = new medicamentoModel();
        $medicamento->setIdMedicamento($id_medicamento);
        $medicamento->setNombreMedicamento($nombre_medicamento);
        $medicamento->setDescripcionMedicamento($descripcion_medicamento);
        $medicamento->setIdInventario($id_inventario);

        $resultado = $medicamento->actualizarMedicamento();

        if ($resultado === true) {
            echo 1;
        } else {
            echo 0;
        }
        break;

    case 'eliminar':
        $id_medicamento = isset($_POST["id_medicamento"]) ? trim($_POST["id_medicamento"]) : "";
        $medicamento = new medicamentoModel();
        $medicamento->setIdMedicamento($id_medicamento);

        // La función eliminarMedicamento no está definida en el modelo
        // Debes definirla si deseas implementar la funcionalidad de eliminación.
        $resultado = $medicamento->eliminarMedicamento();

        if ($resultado === true) {
            echo 1;
        } else {
            echo 0;
        }
        break;
}
?>
