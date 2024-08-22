<?php
require_once '../models/facturaModel.php';

switch ($_GET["op"]) {
    case 'listar_para_tabla':
        $factura_model = new facturaModel();
        $facturas = $factura_model->listarFacturasConCliente();
        $data = array();
        foreach ($facturas as $factura) {
            $data[] = array(
                "0" => $factura['id_factura'],
                "1" => $factura['id_cliente'],
                "2" => $factura['id_consulta'],
                "3" => $factura['nombre_cliente'],
                
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
        case 'obtener_cliente_por_consulta':
            $id_consulta = isset($_POST["id_consulta"]) ? trim($_POST["id_consulta"]) : "";
        
            $factura_model = new facturaModel();
            $id_cliente = $factura_model->obtenerIdClientePorConsulta($id_consulta);
        
            echo json_encode(array("id_cliente" => $id_cliente));
            break;
        
            case 'insertar':
              
                $id_cliente = isset($_POST["id_cliente"]) ? trim($_POST["id_cliente"]) : "";
                $id_consulta = isset($_POST["id_consulta"]) ? trim($_POST["id_consulta"]) : "";
            
                $factura = new facturaModel();
              
                $factura->setIdCliente($id_cliente);
                $factura->setIdConsulta($id_consulta);
            
                $factura->guardarFactura();
                break;
            

    case 'mostrar':
        $id_factura = isset($_POST["id_factura"]) ? $_POST["id_factura"] : "";
        $factura = new facturaModel();
        $factura->setIdFactura($id_factura);
        $encontrado = $factura->mostrar(); // Método 'mostrar' no está definido en facturaModel, necesitarás implementarlo

        if ($encontrado != null) {
            echo json_encode($encontrado);
        } else {
            echo 0;
        }
        break;

    
}
?>
