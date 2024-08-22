<?php
require_once '../config/Conexion.php';

class tratamientoModel
{
    protected static $cnx;
    private $id_tratamiento = null;
    private $descripcion_tratamiento = null;

    // Getters y setters
    public function getIdTratamiento()
    {
        return $this->id_tratamiento;
    }

    public function setIdTratamiento($id_tratamiento)
    {
        $this->id_tratamiento = $id_tratamiento;
    }

    public function getDescripcionTratamiento()
    {
        return $this->descripcion_tratamiento;
    }

    public function setDescripcionTratamiento($descripcion_tratamiento)
    {
        $this->descripcion_tratamiento = $descripcion_tratamiento;
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

    public function listarTodosTratamientos()
    {
        $query = "SELECT * FROM PROYECTO_GRUPO2.FIDE_TRATAMIENTOS_TB";
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
                $tratamiento = new tratamientoModel();
                $tratamiento->setIdTratamiento($row['ID_TRATAMIENTO']);
                $tratamiento->setDescripcionTratamiento($row['DESCRIPCION_TRATAMIENTO']);
                $arr[] = array(
                    'id_tratamiento' => $tratamiento->getIdTratamiento(),
                    'descripcion_tratamiento' => $tratamiento->getDescripcionTratamiento(),
                );
            }

            self::desconectar();
            return $arr;
        } catch (Exception $e) {
            self::desconectar();
            return "Error " . $e->getCode() . ": " . $e->getMessage();
        }
    }

    public function guardarTratamiento()
    {
        $query = "INSERT INTO FIDE_TRATAMIENTOS_TB (ID_TRATAMIENTO, DESCRIPCION_TRATAMIENTO) 
                  VALUES (:id_tratamiento, :descripcion_tratamiento)";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
            }

            oci_bind_by_name($stmt, ':id_tratamiento', $this->id_tratamiento);
            oci_bind_by_name($stmt, ':descripcion_tratamiento', $this->descripcion_tratamiento);

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

    public function actualizarTratamiento()
    {
        $query = "UPDATE FIDE_TRATAMIENTOS_TB 
                  SET DESCRIPCION_TRATAMIENTO = :descripcion_tratamiento
                  WHERE ID_TRATAMIENTO = :id_tratamiento";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
            }

            $id_tratamiento = $this->getIdTratamiento();
            $descripcion_tratamiento = $this->getDescripcionTratamiento();

            oci_bind_by_name($stmt, ':id_tratamiento', $id_tratamiento);
            oci_bind_by_name($stmt, ':descripcion_tratamiento', $descripcion_tratamiento);

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
