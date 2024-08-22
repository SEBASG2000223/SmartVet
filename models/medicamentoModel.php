<?php
require_once '../config/Conexion.php';

class medicamentoModel
{
    protected static $cnx;
    private $id_medicamento = null;
    private $nombre_medicamento = null;
    private $descripcion_medicamento = null;
    private $id_inventario = null;

    public function getIdMedicamento()
    {
        return $this->id_medicamento;
    }

    public function setIdMedicamento($id_medicamento)
    {
        $this->id_medicamento = $id_medicamento;
    }

    public function getNombreMedicamento()
    {
        return $this->nombre_medicamento;
    }

    public function setNombreMedicamento($nombre_medicamento)
    {
        $this->nombre_medicamento = $nombre_medicamento;
    }

    public function getDescripcionMedicamento()
    {
        return $this->descripcion_medicamento;
    }

    public function setDescripcionMedicamento($descripcion_medicamento)
    {
        $this->descripcion_medicamento = $descripcion_medicamento;
    }

    public function getIdInventario()
    {
        return $this->id_inventario;
    }

    public function setIdInventario($id_inventario)
    {
        $this->id_inventario = $id_inventario;
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

    public function listarTodosMedicamentos()
    {
        $query = "SELECT * FROM FIDE_MEDICAMENTOS_TB";
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
                $medicamento = new medicamentoModel();
                $medicamento->setIdMedicamento($row['ID_MEDICAMENTO']);
                $medicamento->setNombreMedicamento($row['NOMBRE_MEDICAMENTO']);
                $medicamento->setDescripcionMedicamento($row['DESCRIPCION_MEDICAMENTO']);
                $medicamento->setIdInventario($row['ID_INVENTARIO']);
                $arr[] = array(
                    'id_medicamento' => $medicamento->getIdMedicamento(),
                    'nombre_medicamento' => $medicamento->getNombreMedicamento(),
                    'descripcion_medicamento' => $medicamento->getDescripcionMedicamento(),
                    'id_inventario' => $medicamento->getIdInventario(),
                );
            }

            self::desconectar();
            return $arr;
        } catch (Exception $e) {
            self::desconectar();
            return "Error " . $e->getCode() . ": " . $e->getMessage();
        }
    }

    public function guardarMedicamento()
    {
        $query = "INSERT INTO FIDE_MEDICAMENTOS_TB (ID_MEDICAMENTO, NOMBRE_MEDICAMENTO, DESCRIPCION_MEDICAMENTO, ID_INVENTARIO) VALUES (:id_medicamento, :nombre_medicamento, :descripcion_medicamento, :id_inventario)";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
            }

            oci_bind_by_name($stmt, ':id_medicamento', $this->id_medicamento);
            oci_bind_by_name($stmt, ':nombre_medicamento', $this->nombre_medicamento);
            oci_bind_by_name($stmt, ':descripcion_medicamento', $this->descripcion_medicamento);
            oci_bind_by_name($stmt, ':id_inventario', $this->id_inventario);

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

    public function actualizarMedicamento()
    {
        $query = "UPDATE FIDE_MEDICAMENTOS_TB 
                  SET NOMBRE_MEDICAMENTO = :nombre_medicamento, 
                      DESCRIPCION_MEDICAMENTO = :descripcion_medicamento, 
                      ID_INVENTARIO = :id_inventario 
                  WHERE ID_MEDICAMENTO = :id_medicamento";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
            }
    
            $id_medicamento = $this->getIdMedicamento();
            $nombre_medicamento = $this->getNombreMedicamento();
            $descripcion_medicamento = $this->getDescripcionMedicamento();
            $id_inventario = $this->getIdInventario();
    
            oci_bind_by_name($stmt, ':id_medicamento', $id_medicamento);
            oci_bind_by_name($stmt, ':nombre_medicamento', $nombre_medicamento);
            oci_bind_by_name($stmt, ':descripcion_medicamento', $descripcion_medicamento);
            oci_bind_by_name($stmt, ':id_inventario', $id_inventario);
    
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
