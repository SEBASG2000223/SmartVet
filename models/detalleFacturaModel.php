<?php
require_once '../config/Conexion.php';

class detalleFacturaModel
{
    protected static $cnx;
    private $id_detalles_facturas = null;
    private $id_factura = null;
    private $id_estado = null;
    private $total = null;
    private $fecha = null;

    public function getIdDetallesFacturas()
    {
        return $this->id_detalles_facturas;
    }

    public function setIdDetallesFacturas($id_detalles_facturas)
    {
        $this->id_detalles_facturas = $id_detalles_facturas;
    }

    public function getIdFactura()
    {
        return $this->id_factura;
    }

    public function setIdFactura($id_factura)
    {
        $this->id_factura = $id_factura;
    }

    public function getIdEstado()
    {
        return $this->id_estado;
    }

    public function setIdEstado($id_estado)
    {
        $this->id_estado = $id_estado;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
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

    public function guardarDetalleFactura()
{
    $query = "BEGIN
                  -- Verificar si el id_factura existe en FIDE_FACTURAS_TB
                  DECLARE
                      v_count NUMBER;
                  BEGIN
                      SELECT COUNT(*)
                      INTO v_count
                      FROM FIDE_FACTURAS_TB
                      WHERE id_factura = :id_factura;

                      IF v_count = 0 THEN
                          RAISE_APPLICATION_ERROR(-20001, 'El id_factura no existe en FIDE_FACTURAS_TB.');
                      END IF;

                      -- Verificar si el id_factura ya existe en FIDE_DETALLES_FACTURAS_TB
                      SELECT COUNT(*)
                      INTO v_count
                      FROM FIDE_DETALLES_FACTURAS_TB
                      WHERE id_factura = :id_factura;

                      IF v_count > 0 THEN
                          RAISE_APPLICATION_ERROR(-20002, 'El id_factura ya existe en FIDE_DETALLES_FACTURAS_TB.');
                      END IF;

                      -- Insertar el nuevo detalle de factura
                      INSERT INTO FIDE_DETALLES_FACTURAS_TB (id_detalles_facturas, id_factura, id_estado, total, fecha)
                      VALUES (:id_detalles_facturas, :id_factura, :id_estado, :total, TO_DATE(:fecha, 'YYYY-MM-DD HH24:MI:SS'));

                  END;
                  COMMIT;
              END;";

    try {
        self::getConexion();
        $stmt = oci_parse(self::$cnx, $query);
        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
        }
        $fecha = date('Y-m-d H:i:s', strtotime($this->getFecha())); // Convertir a formato 'YYYY-MM-DD HH:MM:SS'

        oci_bind_by_name($stmt, ':id_detalles_facturas', $this->id_detalles_facturas);
        oci_bind_by_name($stmt, ':id_factura', $this->id_factura);
        oci_bind_by_name($stmt, ':id_estado', $this->id_estado);
        oci_bind_by_name($stmt, ':total', $this->total);
        oci_bind_by_name($stmt, ':fecha', $fecha);

        if (!oci_execute($stmt, OCI_COMMIT_ON_SUCCESS)) {
            $e = oci_error($stmt);
            throw new Exception($e['message']);
        }

        self::desconectar();
        return true;
    } catch (Exception $e) {
        self::desconectar();
        return false;  // Cambiado para devolver falso en caso de error
    }
}


    public function listarTodosDetalles()
    {
        $query = "SELECT * FROM FIDE_DETALLES_FACTURAS_TB";
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
                    'id_detalles_facturas' => $row['ID_DETALLES_FACTURAS'],
                    'id_factura' => $row['ID_FACTURA'],
                    'id_estado' => $row['ID_ESTADO'],
                    'total' => $row['TOTAL'],
                    'fecha' => $row['FECHA'],
                );
            }

            self::desconectar();
            return $arr;
        } catch (Exception $e) {
            self::desconectar();
            return "Error " . $e->getCode() . ": " . $e->getMessage();
        }
    }

    public function actualizarDetalleFactura()
    {
        $query = "UPDATE FIDE_DETALLES_FACTURAS_TB 
                  SET id_estado = :id_estado, 
                      total = :total, 
                      fecha = TO_DATE(:fecha, 'YYYY-MM-DD HH24:MI:SS') 
                  WHERE id_detalles_facturas = :id_detalles_facturas";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
            }

            $id_detalles_facturas = $this->getIdDetallesFacturas();
            $id_estado = $this->getIdEstado();
            $total = $this->getTotal();
            $fecha = date('Y-m-d H:i:s', strtotime($this->getFecha())); // Convertir a formato 'YYYY-MM-DD HH:MM:SS'


            oci_bind_by_name($stmt, ':id_detalles_facturas', $id_detalles_facturas);
            oci_bind_by_name($stmt, ':id_estado', $id_estado);
            oci_bind_by_name($stmt, ':total', $total);
            oci_bind_by_name($stmt, ':fecha', $fecha);

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
