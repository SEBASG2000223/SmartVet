<?php
require_once '../config/Conexion.php';

class historialMedicoModel
{
    protected static $cnx;
    private $id_historial_medico = null;
    private $id_mascota = null;
    private $id_consulta = null;
    private $id_tratamiento = null;
    private $id_medicamento = null;

    public function getIdHistorialMedico()
    {
        return $this->id_historial_medico;
    }

    public function setIdHistorialMedico($id_historial_medico)
    {
        $this->id_historial_medico = $id_historial_medico;
    }

    public function getIdMascota()
    {
        return $this->id_mascota;
    }

    public function setIdMascota($id_mascota)
    {
        $this->id_mascota = $id_mascota;
    }

    public function getIdConsulta()
    {
        return $this->id_consulta;
    }

    public function setIdConsulta($id_consulta)
    {
        $this->id_consulta = $id_consulta;
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

    public function listarHistoriales()
    {
        $query = "SELECT hm.id_historial_medico, hm.id_mascota, hm.id_consulta,
                         m.nombre_mascota, med.nombre_medicamento, t.descripcion_tratamiento
                  FROM FIDE_HISTORIAL_MEDICO_TB hm
                  JOIN FIDE_MASCOTAS_TB m ON hm.id_mascota = m.id_mascota
                  JOIN FIDE_MEDICAMENTOS_TB med ON hm.id_medicamento = med.id_medicamento
                  JOIN FIDE_TRATAMIENTOS_TB t ON hm.id_tratamiento = t.id_tratamiento";
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
                    'id_historial_medico' => $row['ID_HISTORIAL_MEDICO'],
                    'id_mascota' => $row['ID_MASCOTA'],
                    'id_consulta' => $row['ID_CONSULTA'],
                    'nombre_mascota' => $row['NOMBRE_MASCOTA'],
                    'nombre_medicamento' => $row['NOMBRE_MEDICAMENTO'],
                    'descripcion_tratamiento' => $row['DESCRIPCION_TRATAMIENTO'],
                );
            }

            self::desconectar();
            return $arr;
        } catch (Exception $e) {
            self::desconectar();
            return "Error " . $e->getCode() . ": " . $e->getMessage();
        }
    }

    public function guardarHistorialMedico()
    {
        if (!$this->consultaExiste($this->getIdConsulta())) {
            echo json_encode(array("error" => "El id_consulta no existe en la tabla FIDE_CONSULTAS_TB."));
            return;
        }
    
        if ($this->historialExiste($this->getIdConsulta())) {
            echo json_encode(array("error" => "El id_consulta ya existe en el historial médico."));
            return;
        }
    
        $query = "INSERT INTO FIDE_HISTORIAL_MEDICO_TB (id_mascota, id_consulta, id_tratamiento, id_medicamento)
                  VALUES (:id_mascota, :id_consulta, :id_tratamiento, :id_medicamento)";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
            }
    
            $id_mascota = $this->getIdMascota();
            $id_consulta = $this->getIdConsulta();
            $id_tratamiento = $this->getIdTratamiento();
            $id_medicamento = $this->getIdMedicamento();
    
            oci_bind_by_name($stmt, ':id_mascota', $id_mascota);
            oci_bind_by_name($stmt, ':id_consulta', $id_consulta);
            oci_bind_by_name($stmt, ':id_tratamiento', $id_tratamiento);
            oci_bind_by_name($stmt, ':id_medicamento', $id_medicamento);
    
            if (!oci_execute($stmt)) {
                $e = oci_error($stmt);
                throw new Exception($e['message']);
            }
            self::desconectar();
            echo json_encode(array("success" => "Historial médico registrado correctamente."));
        } catch (Exception $e) {
            self::desconectar();
            echo json_encode(array("error" => $e->getMessage()));
        }
    }

    private function consultaExiste($id_consulta)
    {
        $query = "SELECT COUNT(*) AS count 
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
            return $row['COUNT'] > 0;
        } catch (Exception $e) {
            self::desconectar();
            return "Error " . $e->getCode() . ": " . $e->getMessage();
        }
    }

    private function historialExiste($id_consulta)
    {
        $query = "SELECT COUNT(*) AS count 
                  FROM FIDE_HISTORIAL_MEDICO_TB 
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

    public function obtenerIdMascotaPorConsulta($id_consulta)
    {
        $query = "SELECT id_mascota 
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
            return $row ? $row['ID_MASCOTA'] : null;
        } catch (Exception $e) {
            self::desconectar();
            return "Error " . $e->getCode() . ": " . $e->getMessage();
        }
    }
}
?>
