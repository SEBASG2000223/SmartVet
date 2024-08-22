<?php
require_once '../models/tratamientoModel.php';

switch ($_GET["op"]) {
    case 'listar_para_tabla':
        $tratamiento_model = new tratamientoModel();
        $tratamientos = $tratamiento_model->listarTodosTratamientos();
        $data = array();
        foreach ($tratamientos as $tratamiento) {
            $data[] = array(
                "0" => $tratamiento['id_tratamiento'],
                "1" => $tratamiento['descripcion_tratamiento'],
                "2" => '<button class="btn btn-warning" id="modificarTratamiento">Modificar</button>'
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
        $id_tratamiento = isset($_POST["id_tratamiento"]) ? trim($_POST["id_tratamiento"]) : null;
        $descripcion_tratamiento = isset($_POST["descripcion_tratamiento"]) ? trim($_POST["descripcion_tratamiento"]) : "";

        $tratamiento = new tratamientoModel();
        $tratamiento->setIdTratamiento($id_tratamiento);
        $tratamiento->setDescripcionTratamiento($descripcion_tratamiento);

        $tratamiento->guardarTratamiento();
        echo 1;
        break;

    case 'mostrar':
        $id_tratamiento = isset($_POST["id_tratamiento"]) ? $_POST["id_tratamiento"] : "";
        $tratamiento = new tratamientoModel();
        $tratamiento->setIdTratamiento($id_tratamiento);
        $encontrado = $tratamiento->mostrar();

        if ($encontrado != null) {
            echo json_encode($encontrado);
        } else {
            echo 0;
        }
        break;

    case 'editar':
        $id_tratamiento = isset($_POST["id_tratamiento"]) ? trim($_POST["id_tratamiento"]) : "";
        $descripcion_tratamiento = isset($_POST["descripcion_tratamiento"]) ? trim($_POST["descripcion_tratamiento"]) : "";

        $tratamiento = new tratamientoModel();
        $tratamiento->setIdTratamiento($id_tratamiento);
        $tratamiento->setDescripcionTratamiento($descripcion_tratamiento);

        $resultado = $tratamiento->actualizarTratamiento();

        if ($resultado === true) {
            echo 1;
        } else {
            echo 0;
        }
        break;
}
?>
