<?php
require_once '../config/Conexion.php';

class detalleHistorialMedicoModel
{
    protected static $cnx;
    private $id_detalles_historial = null;
    private $id_historial_medico = null;
    private $descripcion = null;

    public function getIdDetallesHistorial()
    {
        return $this->id_detalles_historial;
    }

    public function setIdDetallesHistorial($id_detalles_historial)
    {
        $this->id_detalles_historial = $id_detalles_historial;
    }

    public function getIdHistorialMedico()
    {
        return $this->id_historial_medico;
    }

    public function setIdHistorialMedico($id_historial_medico)
    {
        $this->id_historial_medico = $id_historial_medico;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
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

    public function listarTodosDetalles()
    {
        $query = "SELECT * FROM FIDE_DETALLES_HISTORIAL_MEDICO_TB";
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
                $detalle = new detalleHistorialMedicoModel();
                $detalle->setIdDetallesHistorial($row['ID_DETALLES_HISTORIAL']);
                $detalle->setIdHistorialMedico($row['ID_HISTORIAL_MEDICO']);
                $detalle->setDescripcion($row['DESCRIPCION']);
                $arr[] = array(
                    'id_detalles_historial' => $detalle->getIdDetallesHistorial(),
                    'id_historial_medico' => $detalle->getIdHistorialMedico(),
                    'descripcion' => $detalle->getDescripcion(),
                );
            }

            self::desconectar();
            return $arr;
        } catch (Exception $e) {
            self::desconectar();
            return "Error " . $e->getCode() . ": " . $e->getMessage();
        }
    }

    public function guardarDetalle()
    {
        $query = "INSERT INTO FIDE_DETALLES_HISTORIAL_MEDICO_TB (ID_DETALLES_HISTORIAL, ID_HISTORIAL_MEDICO, DESCRIPCION) 
                  VALUES (:id_detalles_historial, :id_historial_medico, :descripcion)";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
            }

            oci_bind_by_name($stmt, ':id_detalles_historial', $this->id_detalles_historial);
            oci_bind_by_name($stmt, ':id_historial_medico', $this->id_historial_medico);
            oci_bind_by_name($stmt, ':descripcion', $this->descripcion);

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

    public function actualizarDetalle()
    {
        $query = "UPDATE FIDE_DETALLES_HISTORIAL_MEDICO_TB 
                  SET ID_HISTORIAL_MEDICO = :id_historial_medico, 
                      DESCRIPCION = :descripcion 
                  WHERE ID_DETALLES_HISTORIAL = :id_detalles_historial";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
            }

            $id_detalles_historial = $this->getIdDetallesHistorial();
            $id_historial_medico = $this->getIdHistorialMedico();
            $descripcion = $this->getDescripcion();

            oci_bind_by_name($stmt, ':id_detalles_historial', $id_detalles_historial);
            oci_bind_by_name($stmt, ':id_historial_medico', $id_historial_medico);
            oci_bind_by_name($stmt, ':descripcion', $descripcion);

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
