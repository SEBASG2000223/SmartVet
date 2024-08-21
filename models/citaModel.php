<?php
require_once '../config/Conexion.php';

class citaModel
{
    protected static $cnx;
    private $id_cita = null;
    private $id_cliente = null;
    private $id_estado = null;
    private $hora = null;
    private $fecha = null;

    public function getIdCita()
    {
        return $this->id_cita;
    }

    public function setIdCita($id_cita)
    {
        $this->id_cita = $id_cita;
    }

    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    public function setIdCliente($id_cliente)
    {
        $this->id_cliente = $id_cliente;
    }

    public function getIdEstado()
    {
        return $this->id_estado;
    }

    public function setIdEstado($id_estado)
    {
        $this->id_estado = $id_estado;
    }

    public function getHora()
    {
        return $this->hora;
    }

    public function setHora($hora)
    {
        $this->hora = $hora;
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
        self::$cnx = null;
    }

    public function listarTodasCitas()
{
    $query = "SELECT * FROM FIDE_CITAS_TB";
    $arr = array();
    try {
        self::getConexion();
        $stmt = oci_parse(self::$cnx, $query);
        oci_execute($stmt);

        $estados = self::obtenerEstados(); // Obtener los nombres de los estados

        while ($row = oci_fetch_assoc($stmt)) {
            $cita = new citaModel();
            $cita->setIdCita($row['ID_CITA']);
            $cita->setIdCliente($row['ID_CLIENTE']);
            $cita->setIdEstado($row['ID_ESTADO']);
            $cita->setHora($row['HORA']);
            $cita->setFecha($row['FECHA']);
            $arr[] = array(
                'id_cita' => $cita->getIdCita(),
                'id_cliente' => $cita->getIdCliente(),
                'fecha' => $cita->getFecha(),
                'hora' => $cita->getHora(),
                'estado' => $estados[$cita->getIdEstado()] ?? 'Desconocido' // Mostrar el nombre del estado
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
    
    public function guardarCita()
{
    $query = "INSERT INTO FIDE_CITAS_TB (ID_CLIENTE, ID_ESTADO, HORA, FECHA) VALUES (:id_cliente, :id_estado, TO_TIMESTAMP(:hora, 'HH24:MI:SS'), TO_DATE(:fecha, 'DD-MM-YYYY'))";
    try {
        self::getConexion();
        $stmt = oci_parse(self::$cnx, $query);

        // Convertir hora y fecha a formatos compatibles con Oracle
        $hora = date('H:i:s', strtotime($this->getHora())); // Debe estar en formato 'HH24:MI:SS'
        $fecha = date('d-m-Y', strtotime($this->getFecha())); // Debe estar en formato 'DD-MM-YYYY'

        // Bind parameters
        oci_bind_by_name($stmt, ':id_cliente', $this->id_cliente);
        oci_bind_by_name($stmt, ':id_estado', $this->id_estado);
        oci_bind_by_name($stmt, ':hora', $hora);
        oci_bind_by_name($stmt, ':fecha', $fecha);

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



    public function actualizarCita()
{
    $query = "UPDATE FIDE_CITAS_TB 
              SET ID_CLIENTE = :id_cliente, 
                  ID_ESTADO = :id_estado, 
                  HORA = TO_TIMESTAMP(:hora, 'HH24:MI:SS'), 
                  FECHA = TO_DATE(:fecha, 'DD-MM-YYYY') 
              WHERE ID_CITA = :id_cita";
    try {
        self::getConexion();
        $stmt = oci_parse(self::$cnx, $query);

        $id_cita = $this->getIdCita();
        $id_cliente = $this->getIdCliente();
        $id_estado = $this->getIdEstado();

        // Asume que el formato de fecha que recibes es 'YYYY-MM-DD' y el de la hora es 'HH:MI:SS'
        $hora = date('H:i:s', strtotime($this->getHora())); // Convertir a formato 'HH:MI:SS'
        $fecha = date('d-m-Y', strtotime($this->getFecha())); // Convertir a formato 'DD-MM-YYYY'

        oci_bind_by_name($stmt, ':id_cita', $id_cita);
        oci_bind_by_name($stmt, ':id_cliente', $id_cliente);
        oci_bind_by_name($stmt, ':id_estado', $id_estado);
        oci_bind_by_name($stmt, ':hora', $hora);
        oci_bind_by_name($stmt, ':fecha', $fecha);

        oci_execute($stmt);
        self::desconectar();
        return true;
    } catch (Exception $Exception) {
        self::desconectar();
        return "Error " . $Exception->getCode() . ": " . $Exception->getMessage();
    }
}





}
?>
