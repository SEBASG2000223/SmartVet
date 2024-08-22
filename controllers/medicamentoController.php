<?php
require_once '../models/medicamentoModel.php';

switch ($_GET["op"]) {
    case 'listar_para_tabla':
        $medicamento_model = new medicamentoModel();
        $medicamentos = $medicamento_model->listarTodosMedicamentos();
        $data = array();
        foreach ($medicamentos as $medicamento) {
            $data[] = array(
                "0" => $medicamento['id_medicamento'],
                "1" => $medicamento['nombre_medicamento'],
                "2" => $medicamento['descripcion_medicamento'],
                "3" => $medicamento['id_inventario'],
                "4" => '<button class="btn btn-warning" id="modificarMedicamento">Modificar</button>'
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
        $id_medicamento = isset($_POST["id_medicamento"]) ? trim($_POST["id_medicamento"]) : null;
        $nombre_medicamento = isset($_POST["nombre_medicamento"]) ? trim($_POST["nombre_medicamento"]) : "";
        $descripcion_medicamento = isset($_POST["descripcion_medicamento"]) ? trim($_POST["descripcion_medicamento"]) : "";
        $id_inventario = isset($_POST["id_inventario"]) ? trim($_POST["id_inventario"]) : null;

        $medicamento = new medicamentoModel();
        $medicamento->setIdMedicamento($id_medicamento);
        $medicamento->setNombreMedicamento($nombre_medicamento);
        $medicamento->setDescripcionMedicamento($descripcion_medicamento);
        $medicamento->setIdInventario($id_inventario);

        $medicamento->guardarMedicamento();
        echo 1;
        break;

    case 'mostrar':
        $id_medicamento = isset($_POST["id_medicamento"]) ? $_POST["id_medicamento"] : "";
        $medicamento = new medicamentoModel();
        $medicamento->setIdMedicamento($id_medicamento);
        $encontrado = $medicamento->mostrar();

        if ($encontrado != null) {
            echo json_encode($encontrado);
        } else {
            echo 0;
        }
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
                echo "Error al actualizar: $resultado";
            }
            break;
        
}
?>
