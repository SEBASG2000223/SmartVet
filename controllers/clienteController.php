<?php
require_once '../models/clienteModel.php';

switch ($_GET["op"]) {
    case 'listar_para_tabla':
        $cliente_model = new clienteModel();
        $clientes = $cliente_model->listarTodosClientes();
        $data = array();
        foreach ($clientes as $cliente) {
            $data[] = array(
                "0" => $cliente['id_cliente'],
                "1" => $cliente['nombre_cliente'],
                "2" => $cliente['apellido_cliente'],
                "3" => $cliente['telefono'],
                "4" => $cliente['correo'],
                "5" => '<button class="btn btn-warning" id="modificarCliente">Modificar</button>'
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
        $id_cliente = isset($_POST["id_cliente"]) ? trim($_POST["id_cliente"]) : null;
        $nombre_cliente = isset($_POST["nombre_cliente"]) ? trim($_POST["nombre_cliente"]) : "";
        $apellido_cliente = isset($_POST["apellido_cliente"]) ? trim($_POST["apellido_cliente"]) : "";
        $telefono = isset($_POST["telefono"]) ? trim($_POST["telefono"]) : "";
        $correo = isset($_POST["correo"]) ? trim($_POST["correo"]) : "";

        $cliente = new clienteModel();
        $cliente->setIdCliente($id_cliente);
        $cliente->setNombreCliente($nombre_cliente);
        $cliente->setApellidoCliente($apellido_cliente);
        $cliente->setTelefono($telefono);
        $cliente->setCorreo($correo);

        $cliente->guardarCliente();
        echo 1;
        break;

    case 'mostrar':
        $id_cliente = isset($_POST["id_cliente"]) ? $_POST["id_cliente"] : "";
        $cliente = new clienteModel();
        $cliente->setIdCliente($id_cliente);
        $encontrado = $cliente->mostrar();

        if ($encontrado != null) {
            echo json_encode($encontrado);
        } else {
            echo 0;
        }
        break;

    case 'editar':
        $id_cliente = isset($_POST["id_cliente"]) ? trim($_POST["id_cliente"]) : "";
        $nombre_cliente = isset($_POST["nombre_cliente"]) ? trim($_POST["nombre_cliente"]) : "";
        $apellido_cliente = isset($_POST["apellido_cliente"]) ? trim($_POST["apellido_cliente"]) : "";
        $telefono = isset($_POST["telefono"]) ? trim($_POST["telefono"]) : "";
        $correo = isset($_POST["correo"]) ? trim($_POST["correo"]) : "";

        $cliente = new clienteModel();
        $cliente->setIdCliente($id_cliente);
        $cliente->setNombreCliente($nombre_cliente);
        $cliente->setApellidoCliente($apellido_cliente);
        $cliente->setTelefono($telefono);
        $cliente->setCorreo($correo);

        $resultado = $cliente->actualizarCliente();

        if ($resultado === true) {
            echo 1;
        } else {
            echo 0;
        }
        break;
}
?>
