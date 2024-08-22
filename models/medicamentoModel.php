<?php
require_once '../config/Conexion.php';
header('Content-Type: text/html; charset=utf-8');

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
        self::$cnx = null;
    }

    public function listarMedicamentos()
{
    $conn = Conexion::conectarOracle();
    $query = "SELECT id_medicamento, nombre_medicamento, descripcion_medicamento, id_inventario FROM FIDE_MEDICAMENTOS_TB";
    $stmt = oci_parse($conn, $query);
    
    if (!oci_execute($stmt)) {
        $e = oci_error($stmt);
        die("Error en la ejecución de la consulta: " . $e['message']);
    }
    
    $medicamentos = array();
    while ($row = oci_fetch_assoc($stmt)) {
        $medicamentos[] = $row;
    }
    
    oci_free_statement($stmt);
    oci_close($conn);
    

    
    return $medicamentos;
}


    public function guardarMedicamento()
    {
        $query = "INSERT INTO FIDE_MEDICAMENTOS_TB (id_medicamento, nombre_medicamento, descripcion_medicamento, id_inventario) VALUES (:id_medicamento, :nombre_medicamento, :descripcion_medicamento, :id_inventario)";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);

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
                  SET nombre_medicamento = :nombre_medicamento, 
                      descripcion_medicamento = :descripcion_medicamento, 
                      id_inventario = :id_inventario 
                  WHERE id_medicamento = :id_medicamento";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);

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
