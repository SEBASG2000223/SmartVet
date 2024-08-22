<?php
require_once '../models/mascotaModel.php';

switch ($_GET["op"]) {
    case 'listar_para_tabla':
        $mascota_model = new mascotaModel();
        $mascotas = $mascota_model->listarTodasMascotas();
        $data = array();
        foreach ($mascotas as $mascota) {
            $data[] = array(
                "0" => $mascota['id_mascota'],
                "1" => $mascota['nombre_mascota'],
                "2" => $mascota['id_tratamiento'],
                "3" => $mascota['id_cliente'],
                "4" => $mascota['nombre_cliente'] . ' ' . $mascota['apellido_cliente'],
                "5" => '<button class="btn btn-warning" id="modificarMascota">Modificar</button>'
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
        $id_mascota = isset($_POST["id_mascota"]) ? trim($_POST["id_mascota"]) : null;
        $nombre_mascota = isset($_POST["nombre_mascota"]) ? trim($_POST["nombre_mascota"]) : "";
        $id_tratamiento = isset($_POST["id_tratamiento"]) ? trim($_POST["id_tratamiento"]) : null;
        $id_cliente = isset($_POST["id_cliente"]) ? trim($_POST["id_cliente"]) : null;

        $mascota = new mascotaModel();
        $mascota->setIdMascota($id_mascota);
        $mascota->setNombreMascota($nombre_mascota);
        $mascota->setIdTratamiento($id_tratamiento);
        $mascota->setIdCliente($id_cliente);

        $mascota->guardarMascota();
        echo 1;
        break;

    case 'mostrar':
        $id_mascota = isset($_POST["idMascota"]) ? $_POST["idMascota"] : "";
        $mascota = new mascotaModel();
        $mascota->setIdMascota($id_mascota);
        $encontrada = $mascota->mostrar();

        if ($encontrada != null) {
            echo json_encode($encontrada);
        } else {
            echo 0;
        }
        break;

    case 'editar':
        $id_mascota = isset($_POST["id"]) ? trim($_POST["id"]) : "";
        $nombre_mascota = isset($_POST["nombre_mascota"]) ? trim($_POST["nombre_mascota"]) : "";
        $id_tratamiento = isset($_POST["id_tratamiento"]) ? trim($_POST["id_tratamiento"]) : null;
        $id_cliente = isset($_POST["id_cliente"]) ? trim($_POST["id_cliente"]) : "";

        $mascota = new mascotaModel();
        $mascota->setIdMascota($id_mascota);
        $mascota->setNombreMascota($nombre_mascota);
        $mascota->setIdTratamiento($id_tratamiento);
        $mascota->setIdCliente($id_cliente);

        $resultado = $mascota->actualizarMascota();

        if ($resultado === true) {
            echo 1;
        } else {
            echo 0;
        }
        break;
}
?>
