<?php
require_once '../config/Conexion.php';

class consultaModel
{
    protected static $cnx;
    private $id_consulta = null;
    private $id_mascota = null;
    private $id_cliente = null;
    private $id_empleado = null;
    private $id_estado = null;
    private $fecha = null;
    private $descripcion = null;
    private $precio = null;

    public function getIdConsulta()
    {
        return $this->id_consulta;
    }

    public function setIdConsulta($id_consulta)
    {
        $this->id_consulta = $id_consulta;
    }

    public function getIdMascota()
    {
        return $this->id_mascota;
    }

    public function setIdMascota($id_mascota)
    {
        $this->id_mascota = $id_mascota;
    }

    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    public function setIdCliente($id_cliente)
    {
        $this->id_cliente = $id_cliente;
    }

    public function getIdEmpleado()
    {
        return $this->id_empleado;
    }

    public function setIdEmpleado($id_empleado)
    {
        $this->id_empleado = $id_empleado;
    }

    public function getIdEstado()
    {
        return $this->id_estado;
    }

    public function setIdEstado($id_estado)
    {
        $this->id_estado = $id_estado;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    public static function getConexion()
    {
        self::$cnx = Conexion::conectarOracle();
    }

    public static function desconectar()
    {
        self::$cnx = null;
    }

    public function listarTodasConsultas()
    {
        $query = "SELECT * FROM FIDE_CONSULTAS_TB";
        $arr = array();
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            oci_execute($stmt);

            $estados = self::obtenerEstados(); // Obtener los nombres de los estados

            while ($row = oci_fetch_assoc($stmt)) {
                $consulta = new consultaModel();
                $consulta->setIdConsulta($row['ID_CONSULTA']);
                $consulta->setIdMascota($row['ID_MASCOTA']);
                $consulta->setIdCliente($row['ID_CLIENTE']);
                $consulta->setIdEmpleado($row['ID_EMPLEADO']);
                $consulta->setIdEstado($row['ID_ESTADO']);
                $consulta->setFecha($row['FECHA']);
                $consulta->setDescripcion($row['DESCRIPCION']);
                $consulta->setPrecio($row['PRECIO']);
                $arr[] = array(
                    'id_consulta' => $consulta->getIdConsulta(),
                    'id_mascota' => $consulta->getIdMascota(),
                    'id_cliente' => $consulta->getIdCliente(),
                    'id_empleado' => $consulta->getIdEmpleado(),
                    'fecha' => $consulta->getFecha(),
                    'descripcion' => $consulta->getDescripcion(),
                    'precio' => $consulta->getPrecio(),
                    'estado' => $estados[$consulta->getIdEstado()] // Mostrar el nombre del estado
                );
            }

            self::desconectar();
            return $arr;
        } catch (Exception $e) {
            self::desconectar();
            return "Error " . $e->getCode() . ": " . $e->getMessage();
        }
    }

    public function mostrar()
{
    $query = "SELECT * FROM FIDE_CONSULTAS_TB WHERE ID_CONSULTA = :id_consulta";
    try {
        self::getConexion();
        $stmt = oci_parse(self::$cnx, $query);
        oci_bind_by_name($stmt, ':id_consulta', $this->id_consulta);
        oci_execute($stmt);
        
        $row = oci_fetch_assoc($stmt);
        if ($row) {
            $consulta = array(
                'id_consulta' => $row['ID_CONSULTA'],
                'id_mascota' => $row['ID_MASCOTA'],
                'id_cliente' => $row['ID_CLIENTE'],
                'id_empleado' => $row['ID_EMPLEADO'],
                'id_estado' => $row['ID_ESTADO'],
                'fecha' => $row['FECHA'],
                'descripcion' => $row['DESCRIPCION'],
                'precio' => $row['PRECIO']
            );
            self::desconectar();
            return $consulta;
        } else {
            self::desconectar();
            return null;
        }
    } catch (Exception $e) {
        self::desconectar();
        return "Error " . $e->getCode() . ": " . $e->getMessage();
    }
}


    public static function obtenerEstados()
    {
        return array(
            1 => 'Activo',
            2 => 'Inactivo',
            3 => 'Pendiente',
            4 => 'Pagado',
            5 => 'Cancelado',
            6 => 'Completado',
            7 => 'En Proceso'
        );
    }
    
    public function guardarConsulta()
    {
        $query = "INSERT INTO FIDE_CONSULTAS_TB (ID_MASCOTA, ID_CLIENTE, ID_EMPLEADO, ID_ESTADO, FECHA, DESCRIPCION, PRECIO) 
                  VALUES (:id_mascota, :id_cliente, :id_empleado, :id_estado, TO_DATE(:fecha, 'DD-MM-YYYY'), :descripcion, :precio)";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);

            // Convertir fecha a formato compatible con Oracle
            $fecha = date('d-m-Y', strtotime($this->getFecha())); // Debe estar en formato 'DD-MM-YYYY'

            // Bind parameters
            oci_bind_by_name($stmt, ':id_mascota', $this->id_mascota);
            oci_bind_by_name($stmt, ':id_cliente', $this->id_cliente);
            oci_bind_by_name($stmt, ':id_empleado', $this->id_empleado);
            oci_bind_by_name($stmt, ':id_estado', $this->id_estado);
            oci_bind_by_name($stmt, ':fecha', $fecha);
            oci_bind_by_name($stmt, ':descripcion', $this->descripcion);
            oci_bind_by_name($stmt, ':precio', $this->precio);

            // Ejecutar la consulta
            if (!oci_execute($stmt)) {
                $e = oci_error($stmt);
                throw new Exception($e['message']);
            }
            self::desconectar();
        } catch (Exception $e) {
            self::desconectar();
            echo json_encode(array("error" => $e->getMessage()));
        }
    }

    public function actualizarConsulta()
    {
        $query = "UPDATE FIDE_CONSULTAS_TB 
                  SET ID_MASCOTA = :id_mascota, 
                      ID_CLIENTE = :id_cliente, 
                      ID_EMPLEADO = :id_empleado, 
                      ID_ESTADO = :id_estado, 
                      FECHA = TO_DATE(:fecha, 'DD-MM-YYYY'), 
                      DESCRIPCION = :descripcion, 
                      PRECIO = :precio 
                  WHERE ID_CONSULTA = :id_consulta";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);

            $id_consulta = $this->getIdConsulta();
            $id_mascota = $this->getIdMascota();
            $id_cliente = $this->getIdCliente();
            $id_empleado = $this->getIdEmpleado();
            $id_estado = $this->getIdEstado();

            // Convertir fecha a formato compatible con Oracle
            $fecha = date('d-m-Y', strtotime($this->getFecha())); // Debe estar en formato 'DD-MM-YYYY'

            oci_bind_by_name($stmt, ':id_consulta', $id_consulta);
            oci_bind_by_name($stmt, ':id_mascota', $id_mascota);
            oci_bind_by_name($stmt, ':id_cliente', $id_cliente);
            oci_bind_by_name($stmt, ':id_empleado', $id_empleado);
            oci_bind_by_name($stmt, ':id_estado', $id_estado);
            oci_bind_by_name($stmt, ':fecha', $fecha);
            oci_bind_by_name($stmt, ':descripcion', $this->descripcion);
            oci_bind_by_name($stmt, ':precio', $this->precio);

            oci_execute($stmt);
            self::desconectar();
            return true;
        } catch (Exception $Exception) {
            self::desconectar();
            return "Error " . $Exception->getCode() . ": " . $Exception->getMessage();
        }
    }

    public function eliminarConsulta()
    {
        $query = "DELETE FROM FIDE_CONSULTAS_TB WHERE ID_CONSULTA = :id_consulta";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);

            $id_consulta = $this->getIdConsulta();
            oci_bind_by_name($stmt, ':id_consulta', $id_consulta);

            if (!oci_execute($stmt)) {
                $e = oci_error($stmt);
                throw new Exception($e['message']);
            }
            self::desconectar();
            return true;
        } catch (Exception $e) {
            self::desconectar();
            return "Error " . $e->getCode() . ": " . $e->getMessage();
        }
    }
}
?>
