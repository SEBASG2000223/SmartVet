<?php
require_once '../models/usuarioModel.php';

switch ($_GET["op"]) {
    case 'listar_para_tabla':
        $usuario_model = new usuarioModel();
        $usuarios = $usuario_model->listarTodosUsuarios();
        $data = array();
        foreach ($usuarios as $usuario) {
            $data[] = array(
                "0" => $usuario['id_usuario'],
                "1" => $usuario['id_empleado'],
                "2" => $usuario['id_rol'],
                "3" => $usuario['id_estado'],
                "4" => $usuario['nombre_usuario'],
                "5" => $usuario['correo'],
                "6" => '<button class="btn btn-warning" id="modificarUsuario">Modificar</button>'
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
        $id_usuario = isset($_POST["id_usuario"]) ? trim($_POST["id_usuario"]) : null;
        $id_empleado = isset($_POST["id_empleado"]) ? trim($_POST["id_empleado"]) : "";
        $id_rol = isset($_POST["id_rol"]) ? trim($_POST["id_rol"]) : "";
        $id_estado = isset($_POST["id_estado"]) ? trim($_POST["id_estado"]) : "";
        $nombre_usuario = isset($_POST["nombre_usuario"]) ? trim($_POST["nombre_usuario"]) : "";
        $correo = isset($_POST["correo"]) ? trim($_POST["correo"]) : "";

        $usuario = new usuarioModel();
        $usuario->setIdUsuario($id_usuario);
        $usuario->setIdEmpleado($id_empleado);
        $usuario->setIdRol($id_rol);
        $usuario->setIdEstado($id_estado);
        $usuario->setNombreUsuario($nombre_usuario);
        $usuario->setCorreo($correo);

        $usuario->guardarUsuario();
        echo 1;
        break;

    case 'mostrar':
        $id_usuario = isset($_POST["id_usuario"]) ? $_POST["id_usuario"] : "";
        $usuario = new usuarioModel();
        $usuario->setIdUsuario($id_usuario);
        $encontrado = $usuario->mostrar();

        if ($encontrado != null) {
            echo json_encode($encontrado);
        } else {
            echo 0;
        }
        break;

    case 'editar':
        $id_usuario = isset($_POST["id_usuario"]) ? trim($_POST["id_usuario"]) : "";
        $id_empleado = isset($_POST["id_empleado"]) ? trim($_POST["id_empleado"]) : "";
        $id_rol = isset($_POST["id_rol"]) ? trim($_POST["id_rol"]) : "";
        $id_estado = isset($_POST["id_estado"]) ? trim($_POST["id_estado"]) : "";
        $nombre_usuario = isset($_POST["nombre_usuario"]) ? trim($_POST["nombre_usuario"]) : "";
        $correo = isset($_POST["correo"]) ? trim($_POST["correo"]) : "";

        $usuario = new usuarioModel();
        $usuario->setIdUsuario($id_usuario);
        $usuario->setIdEmpleado($id_empleado);
        $usuario->setIdRol($id_rol);
        $usuario->setIdEstado($id_estado);
        $usuario->setNombreUsuario($nombre_usuario);
        $usuario->setCorreo($correo);

        $resultado = $usuario->actualizarUsuario();

        if ($resultado === true) {
            echo 1;
        } else {
            echo 0;
        }
        break;
}
?>
