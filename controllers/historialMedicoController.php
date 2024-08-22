<?php
require_once '../models/historialMedicoModel.php';

switch ($_GET["op"]) {
    case 'listar_para_tabla':
        $historial_model = new historialMedicoModel();
        $historiales = $historial_model->listarHistoriales();
        $data = array();
        foreach ($historiales as $historial) {
            $data[] = array(
                "0" => $historial['id_historial_medico'],
                "1" => $historial['id_mascota'],
                "2" => $historial['id_consulta'],
                "3" => $historial['nombre_mascota'],
                "4" => $historial['nombre_medicamento'],
                "5" => $historial['descripcion_tratamiento'],
                "6" => '<button class="btn btn-warning" id="modificarInventario">Modificar</button>'

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

    case 'obtener_mascota_por_consulta':
        $id_consulta = isset($_POST["id_consulta"]) ? trim($_POST["id_consulta"]) : "";
        $historial_model = new historialMedicoModel();
        $id_mascota = $historial_model->obtenerIdMascotaPorConsulta($id_consulta);
        echo json_encode(array("id_mascota" => $id_mascota));
        break;

    case 'insertar':
        $id_mascota = isset($_POST["id_mascota"]) ? trim($_POST["id_mascota"]) : "";
        $id_consulta = isset($_POST["id_consulta"]) ? trim($_POST["id_consulta"]) : "";
        $id_tratamiento = isset($_POST["id_tratamiento"]) ? trim($_POST["id_tratamiento"]) : "";
        $id_medicamento = isset($_POST["id_medicamento"]) ? trim($_POST["id_medicamento"]) : "";

        $historial = new historialMedicoModel();
        $historial->setIdMascota($id_mascota);
        $historial->setIdConsulta($id_consulta);
        $historial->setIdTratamiento($id_tratamiento);
        $historial->setIdMedicamento($id_medicamento);
        $historial->guardarHistorialMedico();
        break;

    case 'mostrar':
        $id_historial_medico = isset($_POST["id_historial_medico"]) ? $_POST["id_historial_medico"] : "";
        $historial = new historialMedicoModel();
        $historial->setIdHistorialMedico($id_historial_medico);
        $encontrado = $historial->mostrar(); // Método 'mostrar' no está definido en historialMedicoModel, necesitarás implementarlo

        if ($encontrado != null) {
            echo json_encode($encontrado);
        } else {
            echo 0;
        }
        break;
}
?>
