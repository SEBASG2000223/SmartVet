<?php
require_once '../models/detalleMascotaModel.php';

switch ($_GET["op"]) {
    case 'listar_para_tabla':
        $detalle_model = new detalleMascotaModel();
        $detalles = $detalle_model->listarTodosDetalles();
        $data = array();
        foreach ($detalles as $detalle) {
            $data[] = array(
                "0" => $detalle['id_detalles_mascotas'],
                "1" => $detalle['id_mascota'],
                "2" => $detalle['peso'],
                "3" => $detalle['especie'],
                "4" => $detalle['raza'],
                "5" => $detalle['genero'],
                "6" => $detalle['nombre_mascota'],
                "7" => '<button class="btn btn-warning" id="modificarDetalle">Modificar</button>'
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
        $id_detalles_mascotas = isset($_POST["id_detalles_mascotas"]) ? trim($_POST["id_detalles_mascotas"]) : null;
        $id_mascota = isset($_POST["id_mascota"]) ? trim($_POST["id_mascota"]) : null;
        $peso = isset($_POST["peso"]) ? trim($_POST["peso"]) : "";
        $especie = isset($_POST["especie"]) ? trim($_POST["especie"]) : "";
        $raza = isset($_POST["raza"]) ? trim($_POST["raza"]) : "";
        $genero = isset($_POST["genero"]) ? trim($_POST["genero"]) : "";

        $detalle = new detalleMascotaModel();
        $detalle->setIdDetallesMascotas($id_detalles_mascotas);
        $detalle->setIdMascota($id_mascota);
        $detalle->setPeso($peso);
        $detalle->setEspecie($especie);
        $detalle->setRaza($raza);
        $detalle->setGenero($genero);

        $resultado = $detalle->guardarDetalle();

       echo 1;
        break;

    case 'mostrar':
        $id_detalles_mascotas = isset($_POST["id_detalles_mascotas"]) ? trim($_POST["id_detalles_mascotas"]) : "";
        $detalle = new detalleMascotaModel();
        $detalle->setIdDetallesMascotas($id_detalles_mascotas);
        $encontrado = $detalle->mostrar();

        if ($encontrado != null) {
            echo json_encode($encontrado);
        } else {
            echo 0;
        }
        break;

    case 'editar':
        $id_detalles_mascotas = isset($_POST["id_detalles_mascotas"]) ? trim($_POST["id_detalles_mascotas"]) : "";
        $peso = isset($_POST["peso"]) ? trim($_POST["peso"]) : "";
        $especie = isset($_POST["especie"]) ? trim($_POST["especie"]) : "";
        $raza = isset($_POST["raza"]) ? trim($_POST["raza"]) : "";
        $genero = isset($_POST["genero"]) ? trim($_POST["genero"]) : "";

        $detalle = new detalleMascotaModel();
        $detalle->setIdDetallesMascotas($id_detalles_mascotas);
        $detalle->setPeso($peso);
        $detalle->setEspecie($especie);
        $detalle->setRaza($raza);
        $detalle->setGenero($genero);

        $resultado = $detalle->actualizarDetalle();

        if ($resultado === true) {
            echo 1;
        } else {
            echo json_encode(array("error" => $resultado));
        }
        break;
}
?>
