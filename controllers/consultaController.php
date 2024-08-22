<?php
require_once '../models/consultaModel.php';

switch ($_GET["op"]) {
    case 'listar_para_tabla':
        $consulta_model = new consultaModel();
        $consultas = $consulta_model->listarTodasConsultas();
        $data = array();
        foreach ($consultas as $consulta) {
            $data[] = array(
                "0" => $consulta['id_consulta'],
                "1" => $consulta['id_mascota'],
                "2" => $consulta['id_cliente'],
                "3" => $consulta['id_empleado'],
                "4" => $consulta['fecha'],
                "5" => $consulta['descripcion'],
                "6" => $consulta['precio'],
                "7" => $consulta['estado'], // Mostrar solo el estado como texto
                "8" => '<button class="btn btn-warning" id="modificarConsulta">Modificar</button>'
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
            $id_mascota = isset($_POST["id_mascota"]) ? trim($_POST["id_mascota"]) : 0;
            $id_empleado = isset($_POST["id_empleado"]) ? trim($_POST["id_empleado"]) : 0;
            $id_estado = isset($_POST["id_estado"]) ? trim($_POST["id_estado"]) : 1;
            $fecha = isset($_POST["fecha"]) ? trim($_POST["fecha"]) : "";
            $descripcion = isset($_POST["descripcion"]) ? trim($_POST["descripcion"]) : "";
            $precio = isset($_POST["precio"]) ? trim($_POST["precio"]) : 0;
        
            $consulta = new consultaModel();
            $consulta->setIdMascota($id_mascota);
            // El ID del cliente se establece en el modelo automáticamente
            $consulta->setIdEmpleado($id_empleado);
            $consulta->setIdEstado($id_estado);
            $consulta->setFecha($fecha);
            $consulta->setDescripcion($descripcion);
            $consulta->setPrecio($precio);
            
            $consulta->guardarConsulta();
            echo 1;
            break;

    case 'mostrar':
        $id_consulta = isset($_POST["idConsulta"]) ? $_POST["idConsulta"] : "";
        $consulta = new consultaModel();
        $consulta->setIdConsulta($id_consulta);
        $encontrado = $consulta->mostrar();

        if ($encontrado != null) {
            echo json_encode($encontrado);
        } else {
            echo 0;
        }
        break;

        case 'editar':
            $id = isset($_POST["id"]) ? trim($_POST["id"]) : "";
            $id_mascota = isset($_POST["id_mascota"]) ? trim($_POST["id_mascota"]) : 0;
            $id_empleado = isset($_POST["id_empleado"]) ? trim($_POST["id_empleado"]) : 0;
            $id_estado = isset($_POST["id_estado"]) ? trim($_POST["id_estado"]) : 1;
            $fecha = isset($_POST["fecha"]) ? trim($_POST["fecha"]) : "";
            $descripcion = isset($_POST["descripcion"]) ? trim($_POST["descripcion"]) : "";
            $precio = isset($_POST["precio"]) ? trim($_POST["precio"]) : 0;
        
            $consulta = new consultaModel();
            $consulta->setIdConsulta($id);
            $consulta->setIdMascota($id_mascota);
            // El ID del cliente se establece en el modelo automáticamente
            $consulta->setIdEmpleado($id_empleado);
            $consulta->setIdEstado($id_estado);
            $consulta->setFecha($fecha);
            $consulta->setDescripcion($descripcion);
            $consulta->setPrecio($precio);
        
            $resultado = $consulta->actualizarConsulta();
        
            if ($resultado === true) {
                echo 1;
            } else {
                echo 0;
            }
            break;

    case 'eliminar':
        $id_consulta = isset($_POST["idConsulta"]) ? $_POST["idConsulta"] : "";
        $consulta = new consultaModel();
        $consulta->setIdConsulta($id_consulta);
        $resultado = $consulta->eliminarConsulta();

        if ($resultado === true) {
            echo 1;
        } else {
            echo 0;
        }
        break;
}
?>
