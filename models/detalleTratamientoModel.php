
<?php
require_once '../config/Conexion.php';

class detalleTratamientoModel
{
    protected static $cnx;
    private $id_detalles_tratamientos = null;
    private $id_tratamiento = null;
    private $id_medicamento = null;
    private $id_estado = null;
    private $duracion_tratamiento = null;
    private $descripcion_tratamiento = null;

    public function getIdDetallesTratamientos()
    {
        return $this->id_detalles_tratamientos;
    }

    public function setIdDetallesTratamientos($id_detalles_tratamientos)
    {
        $this->id_detalles_tratamientos = $id_detalles_tratamientos;
    }

    public function getIdTratamiento()
    {
        return $this->id_tratamiento;
    }

    public function setIdTratamiento($id_tratamiento)
    {
        $this->id_tratamiento = $id_tratamiento;
    }

    public function getIdMedicamento()
    {
        return $this->id_medicamento;
    }

    public function setIdMedicamento($id_medicamento)
    {
        $this->id_medicamento = $id_medicamento;
    }

    public function getIdEstado()
    {
        return $this->id_estado;
    }

    public function setIdEstado($id_estado)
    {
        $this->id_estado = $id_estado;
    }

    public function getDuracionTratamiento()
    {
        return $this->duracion_tratamiento;
    }

    public function setDuracionTratamiento($duracion_tratamiento)
    {
        $this->duracion_tratamiento = $duracion_tratamiento;
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
        self::$cnx = null;
    }

    public function listarDetallesTratamientos()
    {
        $query = "SELECT * FROM FIDE_DETALLES_TRATAMIENTOS_TB";
        $arr = array();
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            oci_execute($stmt);

            $estados = self::obtenerEstados(); // Obtener los nombres de los estados

            while ($row = oci_fetch_assoc($stmt)) {
                $detalle = new detalleTratamientoModel();
                $detalle->setIdDetallesTratamientos($row['ID_DETALLES_TRATAMIENTOS']);
                $detalle->setIdTratamiento($row['ID_TRATAMIENTO']);
                $detalle->setIdMedicamento($row['ID_MEDICAMENTO']);
                $detalle->setIdEstado($row['ID_ESTADO']);
                $detalle->setDuracionTratamiento($row['DURACION_TRATAMIENTO']);
                $detalle->setDescripcionTratamiento($row['DESCRIPCION_TRATAMIENTO']);
                $arr[] = array(
                    'id_detalles_tratamientos' => $detalle->getIdDetallesTratamientos(),
                    'id_tratamiento' => $detalle->getIdTratamiento(),
                    'id_medicamento' => $detalle->getIdMedicamento(),
                    'duracion_tratamiento' => $detalle->getDuracionTratamiento(),
                    'descripcion_tratamiento' => $detalle->getDescripcionTratamiento(),
                    'estado' => $estados[$detalle->getIdEstado()] ?? 'Desconocido' // Mostrar el nombre del estado
                );
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

    public function guardarDetalleTratamiento()
    {
        // Validar existencia de id_tratamiento
        if (!$this->validarIdTratamiento($this->getIdTratamiento())) {
            echo json_encode(array("error" => "El id_tratamiento no existe en la tabla FIDE_TRATAMIENTOS_TB."));
            return;
        }

        // Validar existencia de id_medicamento
        if (!$this->validarIdMedicamento($this->getIdMedicamento())) {
            echo json_encode(array("error" => "El id_medicamento no existe en la tabla FIDE_MEDICAMENTOS_TB."));
            return;
        }

        // Validar que no se repita id_tratamiento en la tabla FIDE_DETALLES_TRATAMIENTOS_TB
        if ($this->existeIdTratamiento($this->getIdTratamiento())) {
            echo json_encode(array("error" => "El id_tratamiento ya existe en la tabla FIDE_DETALLES_TRATAMIENTOS_TB."));
            return;
        }

       

        $query = "INSERT INTO FIDE_DETALLES_TRATAMIENTOS_TB (ID_TRATAMIENTO, ID_MEDICAMENTO, ID_ESTADO, DURACION_TRATAMIENTO, DESCRIPCION_TRATAMIENTO) 
                  VALUES (:id_tratamiento, :id_medicamento, :id_estado, :duracion_tratamiento, :descripcion_tratamiento)";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);

            // Bind parameters
            oci_bind_by_name($stmt, ':id_tratamiento', $this->id_tratamiento);
            oci_bind_by_name($stmt, ':id_medicamento', $this->id_medicamento);
            oci_bind_by_name($stmt, ':id_estado', $this->id_estado);
            oci_bind_by_name($stmt, ':duracion_tratamiento', $this->duracion_tratamiento);
            oci_bind_by_name($stmt, ':descripcion_tratamiento', $this->descripcion_tratamiento);

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

    public function actualizarDetalleTratamiento($id, $id_tratamiento, $id_medicamento, $duracion, $descripcion, $id_estado) {
        $query = "UPDATE FIDE_DETALLES_TRATAMIENTOS_TB 
                  SET ID_TRATAMIENTO = :id_tratamiento, 
                      ID_MEDICAMENTO = :id_medicamento, 
                      DURACION_TRATAMIENTO = :duracion, 
                      DESCRIPCION_TRATAMIENTO = :descripcion, 
                      ID_ESTADO = :id_estado 
                  WHERE ID_DETALLES_TRATAMIENTOS = :id";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
    
            // Bind parameters
            oci_bind_by_name($stmt, ':id_tratamiento', $id_tratamiento);
            oci_bind_by_name($stmt, ':id_medicamento', $id_medicamento);
            oci_bind_by_name($stmt, ':duracion', $duracion);
            oci_bind_by_name($stmt, ':descripcion', $descripcion);
            oci_bind_by_name($stmt, ':id_estado', $id_estado);
            oci_bind_by_name($stmt, ':id', $id);
    
            // Ejecutar la consulta
            if (!oci_execute($stmt)) {
                $e = oci_error($stmt);
                throw new Exception($e['message']);
            }
            self::desconectar();
            return true;
        } catch (Exception $e) {
            self::desconectar();
            error_log("Error en actualizarDetalleTratamiento: " . $e->getMessage()); // Registra el error
            return false;
        }
    }
    
    private function validarIdTratamiento($id_tratamiento)
    {
        $query = "SELECT COUNT(*) AS COUNT FROM PROYECTO_GRUPO2.FIDE_TRATAMIENTOS_TB WHERE ID_TRATAMIENTO = :id_tratamiento";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            oci_bind_by_name($stmt, ':id_tratamiento', $id_tratamiento);
            oci_execute($stmt);
            $row = oci_fetch_assoc($stmt);
            self::desconectar();
            return $row['COUNT'] > 0;
        } catch (Exception $e) {
            self::desconectar();
            return false;
        }
    }

    private function validarIdMedicamento($id_medicamento)
    {
        $query = "SELECT COUNT(*) AS COUNT FROM FIDE_MEDICAMENTOS_TB WHERE ID_MEDICAMENTO = :id_medicamento";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            oci_bind_by_name($stmt, ':id_medicamento', $id_medicamento);
            oci_execute($stmt);
            $row = oci_fetch_assoc($stmt);
            self::desconectar();
            return $row['COUNT'] > 0;
        } catch (Exception $e) {
            self::desconectar();
            return false;
        }
    }

    private function existeIdTratamiento($id_tratamiento)
    {
        $query = "SELECT COUNT(*) AS COUNT FROM FIDE_DETALLES_TRATAMIENTOS_TB WHERE ID_TRATAMIENTO = :id_tratamiento";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            oci_bind_by_name($stmt, ':id_tratamiento', $id_tratamiento);
            oci_execute($stmt);
            $row = oci_fetch_assoc($stmt);
            self::desconectar();
            return $row['COUNT'] > 0;
        } catch (Exception $e) {
            self::desconectar();
            return false;
        }
    }

    private function existeIdMedicamento($id_medicamento)
    {
        $query = "SELECT COUNT(*) AS COUNT FROM FIDE_DETALLES_TRATAMIENTOS_TB WHERE ID_MEDICAMENTO = :id_medicamento";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            oci_bind_by_name($stmt, ':id_medicamento', $id_medicamento);
            oci_execute($stmt);
            $row = oci_fetch_assoc($stmt);
            self::desconectar();
            return $row['COUNT'] > 0;
        } catch (Exception $e) {
            self::desconectar();
            return false;
        }
    }
}
?>