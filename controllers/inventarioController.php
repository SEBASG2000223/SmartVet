<?php
require_once '../models/inventarioModel.php';

switch ($_GET["op"]) {
    case 'listar_para_tabla':
        $inventario_model = new inventarioModel();
        $inventarios = $inventario_model->listarTodosInventarios();
        $data = array();
        foreach ($inventarios as $inventario) {
            $data[] = array(
                "0" => $inventario['id_inventario'],
                "1" => $inventario['nombre_medicamento'],
                "2" => $inventario['precio'],
                "3" => $inventario['cantidad'],
                "4" => '<button class="btn btn-warning" id="modificarInventario">Modificar</button>'
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
        $id_inventario = isset($_POST["id_inventario"]) ? trim($_POST["id_inventario"]) : null;
        $id_medicamento = isset($_POST["id_medicamento"]) ? trim($_POST["id_medicamento"]) : "";
        $precio = isset($_POST["precio"]) ? trim($_POST["precio"]) : "";
        $cantidad = isset($_POST["cantidad"]) ? trim($_POST["cantidad"]) : "";

        $inventario = new inventarioModel();
        $inventario->setIdInventario($id_inventario);
        $inventario->setIdMedicamento($id_medicamento);
        $inventario->setPrecio($precio);
        $inventario->setCantidad($cantidad);

        $inventario->guardarInventario();
        echo 1;
        break;

    case 'mostrar':
        $id_inventario = isset($_POST["id_inventario"]) ? $_POST["id_inventario"] : "";
        $inventario = new inventarioModel();
        $inventario->setIdInventario($id_inventario);
        $encontrado = $inventario->mostrar();

        if ($encontrado != null) {
            echo json_encode($encontrado);
        } else {
            echo 0;
        }
        break;

    case 'editar':
        $id_inventario = isset($_POST["id_inventario"]) ? trim($_POST["id_inventario"]) : "";
        $id_medicamento = isset($_POST["id_medicamento"]) ? trim($_POST["id_medicamento"]) : "";
        $precio = isset($_POST["precio"]) ? trim($_POST["precio"]) : "";
        $cantidad = isset($_POST["cantidad"]) ? trim($_POST["cantidad"]) : "";

        $inventario = new inventarioModel();
        $inventario->setIdInventario($id_inventario);
        $inventario->setIdMedicamento($id_medicamento);
        $inventario->setPrecio($precio);
        $inventario->setCantidad($cantidad);

        $resultado = $inventario->actualizarInventario();

        if ($resultado === true) {
            echo 1;
        } else {
            echo 0;
        }
        break;
}
?>
