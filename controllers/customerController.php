<?php
require_once '../models/customerModel.php';

switch ($_GET["op"]) {
    case 'listar_para_tabla':
        $customer_model = new customerModel();
        $clientes = $customer_model->listarTodosClientes();
        $data = array();
        foreach ($clientes as $cliente) {
            $data[] = array(
                "0" => $cliente['customer_id'],
                "1" => $cliente['email_address'],
                "2" => $cliente['full_name'],
                "3" => '<button class="btn btn-warning" id="modificarCliente">Modificar</button>'
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
        $customer_id = isset($_POST["customer_id"]) ? trim($_POST["customer_id"]) : null;
        $email_address = isset($_POST["email_address"]) ? trim($_POST["email_address"]) : "";
        $full_name = isset($_POST["full_name"]) ? trim($_POST["full_name"]) : "";

        $customer = new customerModel();
        $customer->setCustomerId($customer_id);
        $customer->setEmailAddress($email_address);
        $customer->setFullName($full_name);

        $customer->guardarCliente();
        echo 1;
        break;

    case 'mostrar':
        $customer_id = isset($_POST["customerId"]) ? $_POST["customerId"] : "";
        $customer = new customerModel();
        $customer->setCustomerId($customer_id);
        $encontrado = $customer->mostrar();

        if ($encontrado != null) {
            echo json_encode($encontrado);
        } else {
            echo 0;
        }
        break;

    case 'editar':
        $customer_id = isset($_POST["id"]) ? trim($_POST["id"]) : "";
        $email_address = isset($_POST["email_address"]) ? trim($_POST["email_address"]) : "";
        $full_name = isset($_POST["full_name"]) ? trim($_POST["full_name"]) : "";

        $customer = new customerModel();
        $customer->setCustomerId($customer_id);
        $customer->setEmailAddress($email_address);
        $customer->setFullName($full_name);

        $resultado = $customer->actualizarCliente();

        if ($resultado === true) {
            echo 1;
        } else {
            echo 0;
        }
        break;
}
?>
