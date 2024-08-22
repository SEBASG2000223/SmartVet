<?php
require_once '../config/Conexion.php';

class consultaModel
{
    protected static $cnx;

    private $id_consulta;
    private $id_mascota;
    private $id_cliente;
    private $fecha;
    private $descripcion;
    private $precio;
    private $id_estado;
    private $ID_EMPLEADO;

    public function getIdConsulta()
    {
        return $this->id_consulta;
    }

    public function setIdConsulta($id_consulta)
    {
        $this->id_consulta = $id_consulta;
    }


    public function getIdEmpleado()
    {
        return $this->ID_EMPLEADO;
    }

    public function setIdEmpleado($ID_EMPLEADO)
    {
        $this->ID_EMPLEADO = $ID_EMPLEADO;
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

    public function getIdEstado()
    {
        return $this->id_estado;
    }

    public function setIdEstado($id_estado)
    {
        $this->id_estado = $id_estado;
    }

    public static function getConexion()
    {
        self::$cnx = Conexion::conectarOracle();
    }

    public static function desconectar()
    {
        if (self::$cnx !== null) {
            oci_close(self::$cnx);
            self::$cnx = null;
        }
    }

    // Método para obtener el ID del cliente asociado a una mascota
    public function obtenerClientePorMascota($id_mascota)
    {
        $query = "SELECT id_cliente FROM FIDE_MASCOTAS_TB WHERE id_mascota = :id_mascota";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
            }

            oci_bind_by_name($stmt, ':id_mascota', $id_mascota);

            if (!oci_execute($stmt)) {
                $e = oci_error($stmt);
                throw new Exception($e['message']);
            }

            $row = oci_fetch_assoc($stmt);
            self::desconectar();

            return $row ? $row['ID_CLIENTE'] : null;

        } catch (Exception $e) {
            self::desconectar();
            return "Error " . $e->getCode() . ": " . $e->getMessage();
        }
    }

    // Método para listar consultas con joins para mostrar el nombre de la mascota y el cliente
    public function listarConsultasConDetalles()
{
    // Obtén los estados en un array
    $estados = self::obtenerEstados();

    $query = "SELECT c.id_consulta, c.id_mascota, c.ID_ESTADO, c.ID_EMPLEADO, c.id_cliente, c.fecha, c.descripcion, c.precio, 
                     m.nombre_mascota, cl.nombre_cliente || ' ' || cl.apellido_cliente AS nombre_cliente
              FROM FIDE_CONSULTAS_TB c
              INNER JOIN FIDE_MASCOTAS_TB m ON c.id_mascota = m.id_mascota
              INNER JOIN FIDE_CLIENTES_TB cl ON m.id_cliente = cl.id_cliente";
    $arr = array();
    try {
        self::getConexion();
        $stmt = oci_parse(self::$cnx, $query);
        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
        }

        if (!oci_execute($stmt)) {
            throw new Exception('Error al ejecutar la consulta: ' . oci_error($stmt)['message']);
        }

        while ($row = oci_fetch_assoc($stmt)) {
            // Asigna el estado en texto a la fila de resultados
            $row['NOMBRE_ESTADO'] = isset($estados[$row['ID_ESTADO']]) ? $estados[$row['ID_ESTADO']] : 'Desconocido';
            $arr[] = $row;
        }

        self::desconectar();
        return $arr;

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
    // Método para guardar una consulta
    public function guardarConsulta()
    {
        $query = "INSERT INTO FIDE_CONSULTAS_TB (id_consulta, id_mascota, id_cliente, ID_EMPLEADO, fecha, descripcion, precio, id_estado) 
                  VALUES (:id_consulta, :id_mascota, :id_cliente, :ID_EMPLEADO, TO_DATE(:fecha, 'DD-MM-YYYY'), :descripcion, :precio, :id_estado)";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
            }

            $fecha = date('d-m-Y', strtotime($this->getFecha())); // Debe estar en formato 'DD-MM-YYYY'


            oci_bind_by_name($stmt, ':id_consulta', $this->id_consulta);
            oci_bind_by_name($stmt, ':id_mascota', $this->id_mascota);
            oci_bind_by_name($stmt, ':id_cliente', $this->id_cliente);
            oci_bind_by_name($stmt, ':ID_EMPLEADO', $this->ID_EMPLEADO);
            oci_bind_by_name($stmt, ':fecha', $fecha);
            oci_bind_by_name($stmt, ':descripcion', $this->descripcion);
            oci_bind_by_name($stmt, ':precio', $this->precio);
            oci_bind_by_name($stmt, ':id_estado', $this->id_estado);

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

    // Método para actualizar una consulta
    public function actualizarConsulta()
    {
        $query = "UPDATE FIDE_CONSULTAS_TB 
                  SET id_mascota = :id_mascota, 
                      id_cliente = :id_cliente,
                      ID_EMPLEADO = :ID_EMPLEADO, 
                      fecha = TO_DATE(:fecha, 'DD-MM-YYYY'), 
                      descripcion = :descripcion, 
                      precio = :precio,
                      id_estado = :id_estado
                  WHERE id_consulta = :id_consulta";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
            }

            $fecha = date('d-m-Y', strtotime($this->getFecha())); // Convertir a formato 'DD-MM-YYYY'
            $id_estado = $this->getIdEstado();

            oci_bind_by_name($stmt, ':id_consulta', $this->id_consulta);
            oci_bind_by_name($stmt, ':id_mascota', $this->id_mascota);
            oci_bind_by_name($stmt, ':id_cliente', $this->id_cliente);
            oci_bind_by_name($stmt, ':ID_EMPLEADO', $this->ID_EMPLEADO);
            oci_bind_by_name($stmt, ':fecha', $fecha);
            oci_bind_by_name($stmt, ':descripcion', $this->descripcion);
            oci_bind_by_name($stmt, ':precio', $this->precio);
            oci_bind_by_name($stmt, ':id_estado', $id_estado);

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
