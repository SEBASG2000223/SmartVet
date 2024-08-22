<?php
require_once '../config/Conexion.php';

class facturaModel
{
    protected static $cnx;
    private $id_factura = null;
    private $id_cliente = null;
    private $id_consulta = null;

    public function getIdFactura()
    {
        return $this->id_factura;
    }

    public function setIdFactura($id_factura)
    {
        $this->id_factura = $id_factura;
    }

    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    public function setIdCliente($id_cliente)
    {
        $this->id_cliente = $id_cliente;
    }

    public function getIdConsulta()
    {
        return $this->id_consulta;
    }

    public function setIdConsulta($id_consulta)
    {
        $this->id_consulta = $id_consulta;
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

    public function listarFacturasConCliente()
    {
        $query = "SELECT f.id_factura, f.id_cliente, f.id_consulta, 
                         c.nombre_cliente
                  FROM FIDE_FACTURAS_TB f
                  JOIN FIDE_CLIENTES_TB c ON f.id_cliente = c.id_cliente";
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
                $arr[] = array(
                    'id_factura' => $row['ID_FACTURA'],
                    'id_cliente' => $row['ID_CLIENTE'],
                    'id_consulta' => $row['ID_CONSULTA'],
                    'nombre_cliente' => $row['NOMBRE_CLIENTE'],

                );
            }

            self::desconectar();
            return $arr;
        } catch (Exception $e) {
            self::desconectar();
            return "Error " . $e->getCode() . ": " . $e->getMessage();
        }
    }

    public function guardarFactura()
    {
        // Verificar si la consulta ya existe
        if ($this->consultaExisteEnFactura($this->getIdConsulta())) {
            echo json_encode(array("error" => "La factura para esta consulta ya existe."));
            return;
        }
    
        $query = "INSERT INTO FIDE_FACTURAS_TB (id_cliente, id_consulta)
                  VALUES (:id_cliente, :id_consulta)";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
            }
    
            $id_cliente = $this->getIdCliente();
            $id_consulta = $this->getIdConsulta();
    
            oci_bind_by_name($stmt, ':id_cliente', $id_cliente);
            oci_bind_by_name($stmt, ':id_consulta', $id_consulta);
    
            if (!oci_execute($stmt)) {
                $e = oci_error($stmt);
                throw new Exception($e['message']);
            }
            self::desconectar();
            echo json_encode(array("success" => "Factura registrada correctamente."));
        } catch (Exception $e) {
            self::desconectar();
            echo json_encode(array("error" => $e->getMessage()));
        }
    }
    public function consultaExisteEnFactura($id_consulta)
{
    $query = "SELECT COUNT(*) AS count 
              FROM FIDE_FACTURAS_TB 
              WHERE id_consulta = :id_consulta";
    try {
        self::getConexion();
        $stmt = oci_parse(self::$cnx, $query);
        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
        }

        oci_bind_by_name($stmt, ':id_consulta', $id_consulta);

        if (!oci_execute($stmt)) {
            throw new Exception('Error al ejecutar la consulta: ' . oci_error($stmt)['message']);
        }

        $row = oci_fetch_assoc($stmt);
        self::desconectar();
        return $row['COUNT'] > 0;
    } catch (Exception $e) {
        self::desconectar();
        return "Error " . $e->getCode() . ": " . $e->getMessage();
    }
}

    public function obtenerIdClientePorConsulta($id_consulta)
    {
        $query = "SELECT id_cliente 
                  FROM FIDE_CONSULTAS_TB 
                  WHERE id_consulta = :id_consulta";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
            }
    
            oci_bind_by_name($stmt, ':id_consulta', $id_consulta);
    
            if (!oci_execute($stmt)) {
                throw new Exception('Error al ejecutar la consulta: ' . oci_error($stmt)['message']);
            }
    
            $row = oci_fetch_assoc($stmt);
            self::desconectar();
            return $row ? $row['ID_CLIENTE'] : null;
        } catch (Exception $e) {
            self::desconectar();
            return "Error " . $e->getCode() . ": " . $e->getMessage();
        }
    }
    
    
}
?>
