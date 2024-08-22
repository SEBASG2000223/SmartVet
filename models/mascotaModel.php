<?php
require_once '../config/Conexion.php';

class mascotaModel
{
    protected static $cnx;
    private $id_mascota = null;
    private $nombre_mascota = null;
    private $id_tratamiento = null;
    private $id_cliente = null;

    public function getIdMascota()
    {
        return $this->id_mascota;
    }

    public function setIdMascota($id_mascota)
    {
        $this->id_mascota = $id_mascota;
    }

    public function getNombreMascota()
    {
        return $this->nombre_mascota;
    }

    public function setNombreMascota($nombre_mascota)
    {
        $this->nombre_mascota = $nombre_mascota;
    }

    public function getIdTratamiento()
    {
        return $this->id_tratamiento;
    }

    public function setIdTratamiento($id_tratamiento)
    {
        $this->id_tratamiento = $id_tratamiento;
    }

    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    public function setIdCliente($id_cliente)
    {
        $this->id_cliente = $id_cliente;
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

    // Validar si el cliente existe en la base de datos
    private function clienteExiste($id_cliente)
    {
        $query = "SELECT COUNT(*) AS count FROM FIDE_CLIENTES_TB WHERE ID_CLIENTE = :id_cliente";
        self::getConexion();
        $stmt = oci_parse(self::$cnx, $query);
        oci_bind_by_name($stmt, ':id_cliente', $id_cliente);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);
        self::desconectar();
        return ($row['COUNT'] > 0);
    }

    public function listarTodasMascotas()
{
    $query = "SELECT m.*, c.NOMBRE_CLIENTE, c.APELLIDO_CLIENTE 
              FROM FIDE_MASCOTAS_TB m 
              JOIN FIDE_CLIENTES_TB c ON m.ID_CLIENTE = c.ID_CLIENTE";
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

        // Obtén los tratamientos
        $tratamiento = self::obtenerTratamientos();

        while ($row = oci_fetch_assoc($stmt)) {
            $mascota = new mascotaModel();
            $mascota->setIdMascota($row['ID_MASCOTA']);
            $mascota->setNombreMascota($row['NOMBRE_MASCOTA']);
            $mascota->setIdTratamiento($row['ID_TRATAMIENTO']);
            $mascota->setIdCliente($row['ID_CLIENTE']);

            // Verifica si el tratamiento existe en el array antes de acceder a él
            $idTratamiento = $mascota->getIdTratamiento();
            $nombreTratamiento = array_key_exists($idTratamiento, $tratamiento) ? $tratamiento[$idTratamiento] : 'Desconocido';

            $arr[] = array(
                'id_mascota' => $mascota->getIdMascota(),
                'nombre_mascota' => $mascota->getNombreMascota(),
                'id_tratamiento' => $nombreTratamiento,
                'id_cliente' => $mascota->getIdCliente(),
                'nombre_cliente' => $row['NOMBRE_CLIENTE'],
                'apellido_cliente' => $row['APELLIDO_CLIENTE']
            );
        }

        self::desconectar();
        return $arr;
    } catch (Exception $e) {
        self::desconectar();
        return "Error " . $e->getCode() . ": " . $e->getMessage();
    }
}


    public static function obtenerTratamientos()
{
    return array(
        1 => 'Vacunacion anual',
        2 => 'Desparasitacion interna',
        3 => 'Limpieza dental',
        4 => 'Corte de unas',
        5 => 'Tratamiento para pulgas y garrapatas',
        6 => 'Castracion',
        7 => 'Estilizado de pelaje',
        8 => 'Examen fisico general',
        9 => 'Extraccion de cuerpo extrano',
        10 => 'Cirugia de emergencia',
        11 => 'Tratamiento de heridas',
        12 => 'Terapia de oxigeno',
        13 => 'Hospitalizacion con monitoreo',
        14 => 'Terapia con fluidos intravenosos',
        15 => 'Analisis de sangre',
        16 => 'Radiografia',
        17 => 'Ecografia',
        18 => 'Vacunacion contra la rabia',
        19 => 'Desinfeccion de oido',
        20 => 'Control de peso',
        21 => 'Revision de tiroides',
        22 => 'Tratamiento para alergias',
        23 => 'Cuidado post-operatorio',
        24 => 'Terapia con laser',
        25 => 'Entrenamiento de conducta',
        26 => 'Control de artritis',
        27 => 'Tratamiento de infecciones urinarias',
        28 => 'Tratamiento de parasitos externos',
        29 => 'Vacunacion contra leptospirosis',
        30 => 'Control de diabetes',
        31 => 'Tratamiento de enfermedades respiratorias',
        32 => 'Revision cardiologica',
        33 => 'Tratamiento para la dermatitis',
        34 => 'Revision oftalmologica',
        35 => 'Tratamiento de fracturas',
        36 => 'Rehabilitacion fisica',
        37 => 'Tratamiento para problemas de piel',
        38 => 'Terapia nutricional',
        39 => 'Vacunacion contra moquillo',
        40 => 'Tratamiento para enfermedades infecciosas',
        41 => 'Analisis de heces',
        42 => 'Tratamiento para dolor cronico',
        43 => 'Limpieza de oidos',
        44 => 'Tratamiento para convulsiones',
        45 => 'Revision ortopedica',
        46 => 'Cuidado de heridas quirurgicas',
        47 => 'Vacunacion contra parvovirus',
        48 => 'Vacunacion contra hepatitis canina',
        49 => 'Control de plagas intestinales',
        50 => 'Examen dental completo',
        51 => 'Chequeo general de salud'
    );
}


    public function guardarMascota()
    {
        if (!$this->clienteExiste($this->id_cliente)) {
            return json_encode(array("error" => "El cliente no existe"));
        }

        $query = "INSERT INTO FIDE_MASCOTAS_TB (ID_MASCOTA, NOMBRE_MASCOTA, ID_TRATAMIENTO, ID_CLIENTE) VALUES (:id_mascota, :nombre_mascota, :id_tratamiento, :id_cliente)";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
            }

            oci_bind_by_name($stmt, ':id_mascota', $this->id_mascota);
            oci_bind_by_name($stmt, ':nombre_mascota', $this->nombre_mascota);
            oci_bind_by_name($stmt, ':id_tratamiento', $this->id_tratamiento);
            oci_bind_by_name($stmt, ':id_cliente', $this->id_cliente);

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

    public function actualizarMascota()
    {
        if (!$this->clienteExiste($this->id_cliente)) {
            return json_encode(array("error" => "El cliente no existe"));
        }

        $query = "UPDATE FIDE_MASCOTAS_TB 
                  SET NOMBRE_MASCOTA = :nombre_mascota, 
                      ID_TRATAMIENTO = :id_tratamiento, 
                      ID_CLIENTE = :id_cliente 
                  WHERE ID_MASCOTA = :id_mascota";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
            }

            $id_mascota = $this->getIdMascota();
            $nombre_mascota = $this->getNombreMascota();
            $id_tratamiento = $this->getIdTratamiento();
            $id_cliente = $this->getIdCliente();

            oci_bind_by_name($stmt, ':id_mascota', $id_mascota);
            oci_bind_by_name($stmt, ':nombre_mascota', $nombre_mascota);
            oci_bind_by_name($stmt, ':id_tratamiento', $id_tratamiento);
            oci_bind_by_name($stmt, ':id_cliente', $id_cliente);

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
