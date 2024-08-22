<?php
require_once '../models/detalleFacturaModel.php';

switch ($_GET["op"]) {
    case 'listar_para_tabla':
        $detalle_factura_model = new detalleFacturaModel();
        $detalles = $detalle_factura_model->listarTodosDetalles();
        $data = array();
        foreach ($detalles as $detalle) {
            $data[] = array(
                "0" => $detalle['id_detalles_facturas'],
                "1" => $detalle['id_factura'],
                "2" => $detalle['id_estado'],
                "3" => $detalle['total'],
                "4" => $detalle['fecha'],
                "5" => '<button class="btn btn-warning" id="modificarDetalleFactura">Modificar</button>'
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
            $id_detalles_facturas = isset($_POST["id_detalles_facturas"]) ? trim($_POST["id_detalles_facturas"]) : null;
            $id_factura = isset($_POST["id_factura"]) ? trim($_POST["id_factura"]) : "";
            $id_estado = isset($_POST["id_estado"]) ? trim($_POST["id_estado"]) : "";
            $total = isset($_POST["total"]) ? trim($_POST["total"]) : "";
            $fecha = isset($_POST["fecha"]) ? trim($_POST["fecha"]) : "";
        
            $detalle_factura = new detalleFacturaModel();
            $detalle_factura->setIdDetallesFacturas($id_detalles_facturas);
            $detalle_factura->setIdFactura($id_factura);
            $detalle_factura->setIdEstado($id_estado);
            $detalle_factura->setTotal($total);
            $detalle_factura->setFecha($fecha);
        
            $resultado = $detalle_factura->guardarDetalleFactura();
        
            if ($resultado === true) {
                echo json_encode(array("status" => "success"));
            } else {
                echo json_encode(array("status" => "error", "message" => $resultado));
            }
            break;
        
        

    case 'actualizar':
        $id_detalles_facturas = isset($_POST["id_detalles_facturas"]) ? trim($_POST["id_detalles_facturas"]) : "";
        $id_estado = isset($_POST["id_estado"]) ? trim($_POST["id_estado"]) : "";
        $total = isset($_POST["total"]) ? trim($_POST["total"]) : "";
        $fecha = isset($_POST["fecha"]) ? trim($_POST["fecha"]) : "";

        $detalle_factura = new detalleFacturaModel();
        $detalle_factura->setIdDetallesFacturas($id_detalles_facturas);
        $detalle_factura->setIdEstado($id_estado);
        $detalle_factura->setTotal($total);
        $detalle_factura->setFecha($fecha);

        $resultado = $detalle_factura->actualizarDetalleFactura();
        echo json_encode(array("status" => $resultado === true ? "success" : $resultado));
        break;
}
?>
