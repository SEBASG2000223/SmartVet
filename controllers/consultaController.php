<?php
require_once '../models/consultaModel.php';

switch ($_GET["op"]) {
    case 'listar_para_tabla':
        $consulta_model = new consultaModel();
        $consultas = $consulta_model->listarConsultasConDetalles();
        $data = array();
        foreach ($consultas as $consulta) {
            $data[] = array(
                "0" => isset($consulta['ID_CONSULTA']) ? $consulta['ID_CONSULTA'] : '',
                "1" => isset($consulta['ID_MASCOTA']) ? $consulta['ID_MASCOTA'] : '',
                "2" => isset($consulta['NOMBRE_MASCOTA']) ? $consulta['NOMBRE_MASCOTA'] : '',
                "3" => isset($consulta['ID_CLIENTE']) ? $consulta['ID_CLIENTE'] : '',
                "4" => isset($consulta['NOMBRE_CLIENTE']) ? $consulta['NOMBRE_CLIENTE'] : '',
                "5" => isset($consulta['ID_EMPLEADO']) ? $consulta['ID_EMPLEADO'] : '',
                "6" => isset($consulta['FECHA']) ? $consulta['FECHA'] : '',
                "7" => isset($consulta['DESCRIPCION']) ? $consulta['DESCRIPCION'] : '',
                "8" => isset($consulta['PRECIO']) ? $consulta['PRECIO'] : '',
                "9" => isset($consulta['NOMBRE_ESTADO']) ? $consulta['NOMBRE_ESTADO'] : '',  // Aquí se añade el estado
                "10" => '<button class="btn btn-warning" id="modificarConsulta">Modificar</button>'
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
            $id_mascota = isset($_POST["id_mascota"]) ? trim($_POST["id_mascota"]) : "";
            
            // Obtener el id_cliente asociado a la mascota
            $consulta = new consultaModel();
            $id_cliente = $consulta->obtenerClientePorMascota($id_mascota);
            
            if ($id_cliente === null) {
                echo json_encode(array("error" => "No se encontró un cliente asociado a la mascota."));
                return;
            }
            
            $fecha = isset($_POST["fecha"]) ? trim($_POST["fecha"]) : "";
            $descripcion = isset($_POST["descripcion"]) ? trim($_POST["descripcion"]) : "";
            $precio = isset($_POST["precio"]) ? trim($_POST["precio"]) : "";
            $id_estado = isset($_POST["id_estado"]) ? trim($_POST["id_estado"]) : 1;
            $ID_EMPLEADO = isset($_POST["ID_EMPLEADO"]) ? trim($_POST["ID_EMPLEADO"]) : 1;
        
            // Asignar los valores al modelo
            $consulta->setIdMascota($id_mascota);
            $consulta->setIdCliente($id_cliente); 
            $consulta->setIdEmpleado($ID_EMPLEADO); // Este valor se obtuvo automáticamente
            $consulta->setFecha($fecha);
            $consulta->setDescripcion($descripcion);
            $consulta->setPrecio($precio);
            $consulta->setIdEstado($id_estado);
        
            // Guardar la consulta en la base de datos
            $resultado = $consulta->guardarConsulta();
    if ($resultado === 1) {
        echo json_encode(array("success" => true, "message" => "Consulta agregada correctamente."));
    } else {
        echo json_encode(array("success" => false, "message" => $resultado));
    }
    break;
            break;
        

            case 'obtener_cliente_por_mascota':
                $id_mascota = isset($_POST["id_mascota"]) ? trim($_POST["id_mascota"]) : "";
                
                $consulta = new consultaModel();
                $id_cliente = $consulta->obtenerClientePorMascota($id_mascota);
                
                if ($id_cliente !== null) {
                    echo json_encode(array("id_cliente" => $id_cliente));
                } else {
                    echo json_encode(array("id_cliente" => ""));
                }
                break;

                
    case 'mostrar':
        $id_consulta = isset($_POST["id_consulta"]) ? $_POST["id_consulta"] : "";
        $consulta = new consultaModel();
        $consulta->setIdConsulta($id_consulta);
        $encontrado = $consulta->listarConsultasConDetalles();

        if ($encontrado != null) {
            echo json_encode($encontrado);
        } else {
            echo 0;
        }
        break;

    case 'editar':
        $id_consulta = isset($_POST["id_consulta"]) ? trim($_POST["id_consulta"]) : "";
        $id_mascota = isset($_POST["id_mascota"]) ? trim($_POST["id_mascota"]) : "";
        $id_cliente = isset($_POST["id_cliente"]) ? trim($_POST["id_cliente"]) : "";
        $ID_EMPLEADO = isset($_POST["ID_EMPLEADO"]) ? trim($_POST["ID_EMPLEADO"]) : 1;
        $fecha = isset($_POST["fecha"]) ? trim($_POST["fecha"]) : "";
        $descripcion = isset($_POST["descripcion"]) ? trim($_POST["descripcion"]) : "";
        $precio = isset($_POST["precio"]) ? trim($_POST["precio"]) : "";
        $id_estado = isset($_POST["id_estado"]) ? trim($_POST["id_estado"]) : 1;


        $consulta = new consultaModel();
        $consulta->setIdConsulta($id_consulta);
        $consulta->setIdMascota($id_mascota);
        $consulta->setIdCliente($id_cliente);
        $consulta->setIdEmpleado($ID_EMPLEADO);
        $consulta->setFecha($fecha);
        $consulta->setDescripcion($descripcion);
        $consulta->setPrecio($precio);
        $consulta->setIdEstado($id_estado);

        $resultado = $consulta->actualizarConsulta();
        if ($resultado === true) {
            echo json_encode(array("success" => true, "message" => "Consulta actualizada correctamente."));
        } else {
            echo json_encode(array("success" => false, "message" => $resultado));
        }
        break;

    // Agrega más casos según las necesidades de la aplicación...
}
?>
