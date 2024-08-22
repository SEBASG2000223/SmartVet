<?php
require_once '../config/Conexion.php';

class inventarioModel
{
    protected static $cnx;
    private $id_inventario = null;
    private $id_medicamento = null;
    private $precio = null;
    private $cantidad = null;
    private $nombre_medicamento = null;

    public function getIdInventario()
    {
        return $this->id_inventario;
    }

    public function setIdInventario($id_inventario)
    {
        $this->id_inventario = $id_inventario;
    }

    public function getIdMedicamento()
    {
        return $this->id_medicamento;
    }

    public function setIdMedicamento($id_medicamento)
    {
        $this->id_medicamento = $id_medicamento;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    public function getNombreMedicamento()
    {
        return $this->nombre_medicamento;
    }

    public function setNombreMedicamento($nombre_medicamento)
    {
        $this->nombre_medicamento = $nombre_medicamento;
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

    public function listarTodosInventarios()
    {
        $query = "
            SELECT 
                inv.id_inventario, 
                inv.precio, 
                inv.cantidad, 
                med.nombre_medicamento 
            FROM 
                FIDE_INVENTARIO_TB inv
            JOIN 
                FIDE_MEDICAMENTOS_TB med 
            ON 
                inv.id_medicamento = med.id_medicamento
        ";

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
                $inventario = new inventarioModel();
                $inventario->setIdInventario($row['ID_INVENTARIO']);
                $inventario->setPrecio($row['PRECIO']);
                $inventario->setCantidad($row['CANTIDAD']);
                $inventario->setNombreMedicamento($row['NOMBRE_MEDICAMENTO']);
                
                $arr[] = array(
                    'id_inventario' => $inventario->getIdInventario(),
                    'precio' => $inventario->getPrecio(),
                    'cantidad' => $inventario->getCantidad(),
                    'nombre_medicamento' => $inventario->getNombreMedicamento(),
                );
            }

            self::desconectar();
            return $arr;
        } catch (Exception $e) {
            self::desconectar();
            return "Error " . $e->getCode() . ": " . $e->getMessage();
        }
    }

    private function validarIdMedicamento($id_medicamento)
    {
        $query = "SELECT COUNT(*) AS count FROM FIDE_MEDICAMENTOS_TB WHERE ID_MEDICAMENTO = :id_medicamento";
        self::getConexion();
        $stmt = oci_parse(self::$cnx, $query);
        oci_bind_by_name($stmt, ':id_medicamento', $id_medicamento);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);
        self::desconectar();
        return $row['COUNT'] > 0;
    }

    // Función para verificar que el id_medicamento no exista ya en FIDE_INVENTARIO_TB
    private function existeIdMedicamentoEnInventario($id_medicamento)
    {
        $query = "SELECT COUNT(*) AS count FROM FIDE_INVENTARIO_TB WHERE ID_MEDICAMENTO = :id_medicamento";
        self::getConexion();
        $stmt = oci_parse(self::$cnx, $query);
        oci_bind_by_name($stmt, ':id_medicamento', $id_medicamento);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);
        self::desconectar();
        return $row['COUNT'] > 0;
    }

    public function guardarInventario()
    {

       // Validar existencia de id_medicamento en FIDE_MEDICAMENTOS_TB
    if (!$this->validarIdMedicamento($this->getIdMedicamento())) {
        echo json_encode(array("error" => "El id_medicamento no existe en la tabla FIDE_MEDICAMENTOS_TB."));
        return;
    }

    // Validar que no se repita id_medicamento en la tabla FIDE_INVENTARIO_TB
    if ($this->existeIdMedicamentoEnInventario($this->getIdMedicamento())) {
        echo json_encode(array("error" => "El id_medicamento ya existe en la tabla FIDE_INVENTARIO_TB."));
        return;
    }
        $query = "INSERT INTO FIDE_INVENTARIO_TB (ID_INVENTARIO, ID_MEDICAMENTO, PRECIO, CANTIDAD) 
                  VALUES (:id_inventario, :id_medicamento, :precio, :cantidad)";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
            }

            oci_bind_by_name($stmt, ':id_inventario', $this->id_inventario);
            oci_bind_by_name($stmt, ':id_medicamento', $this->id_medicamento);
            oci_bind_by_name($stmt, ':precio', $this->precio);
            oci_bind_by_name($stmt, ':cantidad', $this->cantidad);

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

    public function actualizarInventario()
    {
        $query = "UPDATE FIDE_INVENTARIO_TB 
                  SET ID_MEDICAMENTO = :id_medicamento, 
                      PRECIO = :precio, 
                      CANTIDAD = :cantidad 
                  WHERE ID_INVENTARIO = :id_inventario";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
            }

            $id_inventario = $this->getIdInventario();
            $id_medicamento = $this->getIdMedicamento();
            $precio = $this->getPrecio();
            $cantidad = $this->getCantidad();

            oci_bind_by_name($stmt, ':id_inventario', $id_inventario);
            oci_bind_by_name($stmt, ':id_medicamento', $id_medicamento);
            oci_bind_by_name($stmt, ':precio', $precio);
            oci_bind_by_name($stmt, ':cantidad', $cantidad);

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
