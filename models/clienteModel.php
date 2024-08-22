<?php
require_once '../config/Conexion.php';

class clienteModel
{
    protected static $cnx;
    private $id_cliente = null;
    private $nombre_cliente = null;
    private $apellido_cliente = null;
    private $telefono = null;
    private $correo = null;

    // Getters y setters
    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    public function setIdCliente($id_cliente)
    {
        $this->id_cliente = $id_cliente;
    }

    public function getNombreCliente()
    {
        return $this->nombre_cliente;
    }

    public function setNombreCliente($nombre_cliente)
    {
        $this->nombre_cliente = $nombre_cliente;
    }

    public function getApellidoCliente()
    {
        return $this->apellido_cliente;
    }

    public function setApellidoCliente($apellido_cliente)
    {
        $this->apellido_cliente = $apellido_cliente;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function setCorreo($correo)
    {
        $this->correo = $correo;
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

    public function listarTodosClientes()
    {
        $query = "SELECT * FROM FIDE_CLIENTES_TB";
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
                $cliente = new clienteModel();
                $cliente->setIdCliente($row['ID_CLIENTE']);
                $cliente->setNombreCliente($row['NOMBRE_CLIENTE']);
                $cliente->setApellidoCliente($row['APELLIDO_CLIENTE']);
                $cliente->setTelefono($row['TELEFONO']);
                $cliente->setCorreo($row['CORREO']);
                $arr[] = array(
                    'id_cliente' => $cliente->getIdCliente(),
                    'nombre_cliente' => $cliente->getNombreCliente(),
                    'apellido_cliente' => $cliente->getApellidoCliente(),
                    'telefono' => $cliente->getTelefono(),
                    'correo' => $cliente->getCorreo(),
                );
            }

            self::desconectar();
            return $arr;
        } catch (Exception $e) {
            self::desconectar();
            return "Error " . $e->getCode() . ": " . $e->getMessage();
        }
    }

    public function guardarCliente()
    {
        $query = "INSERT INTO FIDE_CLIENTES_TB (ID_CLIENTE, NOMBRE_CLIENTE, APELLIDO_CLIENTE, TELEFONO, CORREO) 
                  VALUES (:id_cliente, :nombre_cliente, :apellido_cliente, :telefono, :correo)";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
            }

            oci_bind_by_name($stmt, ':id_cliente', $this->id_cliente);
            oci_bind_by_name($stmt, ':nombre_cliente', $this->nombre_cliente);
            oci_bind_by_name($stmt, ':apellido_cliente', $this->apellido_cliente);
            oci_bind_by_name($stmt, ':telefono', $this->telefono);
            oci_bind_by_name($stmt, ':correo', $this->correo);

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

    public function actualizarCliente()
    {
        $query = "UPDATE FIDE_CLIENTES_TB 
                  SET NOMBRE_CLIENTE = :nombre_cliente, 
                      APELLIDO_CLIENTE = :apellido_cliente, 
                      TELEFONO = :telefono, 
                      CORREO = :correo 
                  WHERE ID_CLIENTE = :id_cliente";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
            }

            $id_cliente = $this->getIdCliente();
            $nombre_cliente = $this->getNombreCliente();
            $apellido_cliente = $this->getApellidoCliente();
            $telefono = $this->getTelefono();
            $correo = $this->getCorreo();

            oci_bind_by_name($stmt, ':id_cliente', $id_cliente);
            oci_bind_by_name($stmt, ':nombre_cliente', $nombre_cliente);
            oci_bind_by_name($stmt, ':apellido_cliente', $apellido_cliente);
            oci_bind_by_name($stmt, ':telefono', $telefono);
            oci_bind_by_name($stmt, ':correo', $correo);

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
