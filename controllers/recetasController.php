<?php
require_once '../models/recetasModel.php';

switch ($_GET["op"]) {
    case 'listar_para_tabla':
        $receta_model = new recetasModel();
        $recetas = $receta_model->listarTodasRecetas();
        $data = array();
        foreach ($recetas as $receta) {
            $data[] = array(
                "0" => $receta['id_receta'],
                "1" => $receta['descripcion'],
                "2" => $receta['nombre_medicamento'],
                "3" => $receta['nombre_mascota'],
                "4" => '<button class="btn btn-warning" id="modificarReceta">Modificar</button>'
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
        $id_receta = isset($_POST["id_receta"]) ? trim($_POST["id_receta"]) : null;
        $id_medicamento = isset($_POST["id_medicamento"]) ? trim($_POST["id_medicamento"]) : "";
        $id_mascota = isset($_POST["id_mascota"]) ? trim($_POST["id_mascota"]) : "";
        $id_empleado = isset($_POST["id_empleado"]) ? trim($_POST["id_empleado"]) : "";
        $id_consulta = isset($_POST["id_consulta"]) ? trim($_POST["id_consulta"]) : "";
        $id_estado = isset($_POST["id_estado"]) ? trim($_POST["id_estado"]) : "";
        $descripcion = isset($_POST["descripcion"]) ? trim($_POST["descripcion"]) : "";

        $receta = new recetasModel();
        $receta->setIdReceta($id_receta);
        $receta->setIdMedicamento($id_medicamento);
        $receta->setIdMascota($id_mascota);
        $receta->setIdEmpleado($id_empleado);
        $receta->setIdConsulta($id_consulta);
        $receta->setIdEstado($id_estado);
        $receta->setDescripcion($descripcion);

        $receta->guardarReceta();
        echo 1;
        break;

    case 'mostrar':
        $id_receta = isset($_POST["id_receta"]) ? $_POST["id_receta"] : "";
        $receta = new recetasModel();
        $receta->setIdReceta($id_receta);
        $encontrado = $receta->mostrar();

        if ($encontrado != null) {
            echo json_encode($encontrado);
        } else {
            echo 0;
        }
        break;

    case 'editar':
        $id_receta = isset($_POST["id_receta"]) ? trim($_POST["id_receta"]) : "";
        $id_medicamento = isset($_POST["id_medicamento"]) ? trim($_POST["id_medicamento"]) : "";
        $id_mascota = isset($_POST["id_mascota"]) ? trim($_POST["id_mascota"]) : "";
        $id_empleado = isset($_POST["id_empleado"]) ? trim($_POST["id_empleado"]) : "";
        $id_consulta = isset($_POST["id_consulta"]) ? trim($_POST["id_consulta"]) : "";
        $id_estado = isset($_POST["id_estado"]) ? trim($_POST["id_estado"]) : "";
        $descripcion = isset($_POST["descripcion"]) ? trim($_POST["descripcion"]) : "";

        $receta = new recetasModel();
        $receta->setIdReceta($id_receta);
        $receta->setIdMedicamento($id_medicamento);
        $receta->setIdMascota($id_mascota);
        $receta->setIdEmpleado($id_empleado);
        $receta->setIdConsulta($id_consulta);
        $receta->setIdEstado($id_estado);
        $receta->setDescripcion($descripcion);

        $resultado = $receta->actualizarReceta();

        if ($resultado === true) {
            echo 1;
        } else {
            echo 0;
        }
        break;
}
?>
