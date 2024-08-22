<?php
require_once '../config/Conexion.php';

class recetasModel
{
    protected static $cnx;
    private $id_receta = null;
    private $id_medicamento = null;
    private $id_mascota = null;
    private $id_empleado = null;
    private $id_consulta = null;
    private $id_estado = null;
    private $descripcion = null;

    public function getIdReceta()
    {
        return $this->id_receta;
    }

    public function setIdReceta($id_receta)
    {
        $this->id_receta = $id_receta;
    }

    public function getIdMedicamento()
    {
        return $this->id_medicamento;
    }

    public function setIdMedicamento($id_medicamento)
    {
        $this->id_medicamento = $id_medicamento;
    }

    public function getIdMascota()
    {
        return $this->id_mascota;
    }

    public function setIdMascota($id_mascota)
    {
        $this->id_mascota = $id_mascota;
    }

    public function getIdEmpleado()
    {
        return $this->id_empleado;
    }

    public function setIdEmpleado($id_empleado)
    {
        $this->id_empleado = $id_empleado;
    }

    public function getIdConsulta()
    {
        return $this->id_consulta;
    }

    public function setIdConsulta($id_consulta)
    {
        $this->id_consulta = $id_consulta;
    }

    public function getIdEstado()
    {
        return $this->id_estado;
    }

    public function setIdEstado($id_estado)
    {
        $this->id_estado = $id_estado;
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

    public function listarTodasRecetas()
    {
        $query = "
            SELECT 
                r.id_receta, 
                r.descripcion, 
                m.nombre_medicamento, 
                ms.nombre_mascota 
            FROM 
                FIDE_RECETAS_TB r
            JOIN 
                FIDE_MEDICAMENTOS_TB m ON r.id_medicamento = m.id_medicamento
            JOIN 
                FIDE_MASCOTAS_TB ms ON r.id_mascota = ms.id_mascota";
        
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
                    'id_receta' => $row['ID_RECETA'],
                    'descripcion' => $row['DESCRIPCION'],
                    'nombre_medicamento' => $row['NOMBRE_MEDICAMENTO'],
                    'nombre_mascota' => $row['NOMBRE_MASCOTA'],
                );
            }

            self::desconectar();
            return $arr;
        } catch (Exception $e) {
            self::desconectar();
            return "Error " . $e->getCode() . ": " . $e->getMessage();
        }
    }

    public function guardarReceta()
    {
        $query = "INSERT INTO FIDE_RECETAS_TB (id_receta, id_medicamento, id_mascota, id_empleado, id_consulta, id_estado, descripcion) 
                  VALUES (:id_receta, :id_medicamento, :id_mascota, :id_empleado, :id_consulta, :id_estado, :descripcion)";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
            }

            oci_bind_by_name($stmt, ':id_receta', $this->id_receta);
            oci_bind_by_name($stmt, ':id_medicamento', $this->id_medicamento);
            oci_bind_by_name($stmt, ':id_mascota', $this->id_mascota);
            oci_bind_by_name($stmt, ':id_empleado', $this->id_empleado);
            oci_bind_by_name($stmt, ':id_consulta', $this->id_consulta);
            oci_bind_by_name($stmt, ':id_estado', $this->id_estado);
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

    public function actualizarReceta()
    {
        $query = "UPDATE FIDE_RECETAS_TB 
                  SET id_medicamento = :id_medicamento, 
                      id_mascota = :id_mascota, 
                      id_empleado = :id_empleado, 
                      id_consulta = :id_consulta, 
                      id_estado = :id_estado, 
                      descripcion = :descripcion
                  WHERE id_receta = :id_receta";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
            }

            oci_bind_by_name($stmt, ':id_receta', $this->id_receta);
            oci_bind_by_name($stmt, ':id_medicamento', $this->id_medicamento);
            oci_bind_by_name($stmt, ':id_mascota', $this->id_mascota);
            oci_bind_by_name($stmt, ':id_empleado', $this->id_empleado);
            oci_bind_by_name($stmt, ':id_consulta', $this->id_consulta);
            oci_bind_by_name($stmt, ':id_estado', $this->id_estado);
            oci_bind_by_name($stmt, ':descripcion', $this->descripcion);

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
