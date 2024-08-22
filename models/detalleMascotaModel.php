<?php
require_once '../config/Conexion.php';

class detalleMascotaModel
{
    protected static $cnx;
    private $id_detalles_mascotas = null;
    private $id_mascota = null;
    private $peso = null;
    private $especie = null;
    private $raza = null;
    private $genero = null;

    public function getIdDetallesMascotas()
    {
        return $this->id_detalles_mascotas;
    }

    public function setIdDetallesMascotas($id_detalles_mascotas)
    {
        $this->id_detalles_mascotas = $id_detalles_mascotas;
    }

    public function getIdMascota()
    {
        return $this->id_mascota;
    }

    public function setIdMascota($id_mascota)
    {
        $this->id_mascota = $id_mascota;
    }

    public function getPeso()
    {
        return $this->peso;
    }

    public function setPeso($peso)
    {
        $this->peso = $peso;
    }

    public function getEspecie()
    {
        return $this->especie;
    }

    public function setEspecie($especie)
    {
        $this->especie = $especie;
    }

    public function getRaza()
    {
        return $this->raza;
    }

    public function setRaza($raza)
    {
        $this->raza = $raza;
    }

    public function getGenero()
    {
        return $this->genero;
    }

    public function setGenero($genero)
    {
        $this->genero = $genero;
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

    private function validarIdMascota()
    {
        $query = "SELECT COUNT(*) AS count FROM FIDE_MASCOTAS_TB WHERE ID_MASCOTA = :id_mascota";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            oci_bind_by_name($stmt, ':id_mascota', $this->id_mascota);
            if (!oci_execute($stmt)) {
                throw new Exception('Error al ejecutar la consulta: ' . oci_error($stmt)['message']);
            }
            $row = oci_fetch_assoc($stmt);
            self::desconectar();
            return $row['COUNT'] > 0;
        } catch (Exception $e) {
            self::desconectar();
            return false;
        }
    }

    private function validarIdDetallesMascotasUnico()
    {
        $query = "SELECT COUNT(*) AS count FROM FIDE_DETALLES_MASCOTAS_TB WHERE ID_DETALLES_MASCOTAS = :id_detalles_mascotas";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            oci_bind_by_name($stmt, ':id_detalles_mascotas', $this->id_detalles_mascotas);
            if (!oci_execute($stmt)) {
                throw new Exception('Error al ejecutar la consulta: ' . oci_error($stmt)['message']);
            }
            $row = oci_fetch_assoc($stmt);
            self::desconectar();
            return $row['COUNT'] == 0;
        } catch (Exception $e) {
            self::desconectar();
            return false;
        }
    }

    private function validarIdMascotaEnDetalles()
    {
        $query = "SELECT COUNT(*) AS count FROM FIDE_DETALLES_MASCOTAS_TB WHERE ID_MASCOTA = :id_mascota";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            oci_bind_by_name($stmt, ':id_mascota', $this->id_mascota);
            if (!oci_execute($stmt)) {
                throw new Exception('Error al ejecutar la consulta: ' . oci_error($stmt)['message']);
            }
            $row = oci_fetch_assoc($stmt);
            self::desconectar();
            return $row['COUNT'] == 0; // No debe haber ningún detalle con el mismo ID de mascota
        } catch (Exception $e) {
            self::desconectar();
            return false;
        }
    }

    public function listarTodosDetalles()
    {
        $query = "SELECT d.id_detalles_mascotas, d.id_mascota, d.peso, d.especie, d.raza, d.genero, m.nombre_mascota
                  FROM FIDE_DETALLES_MASCOTAS_TB d
                  JOIN FIDE_MASCOTAS_TB m ON d.id_mascota = m.id_mascota";
        $arr = array();
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            if (!oci_execute($stmt)) {
                throw new Exception('Error al ejecutar la consulta: ' . oci_error($stmt)['message']);
            }

            while ($row = oci_fetch_assoc($stmt)) {
                $arr[] = array(
                    'id_detalles_mascotas' => $row['ID_DETALLES_MASCOTAS'],
                    'id_mascota' => $row['ID_MASCOTA'],
                    'peso' => $row['PESO'],
                    'especie' => $row['ESPECIE'],
                    'raza' => $row['RAZA'],
                    'genero' => $row['GENERO'],
                    'nombre_mascota' => $row['NOMBRE_MASCOTA']
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
        if (!$this->validarIdMascota()) {
            echo json_encode(array("error" => "El ID de mascota no existe."));
            return;
        }

        if (!$this->validarIdMascotaEnDetalles()) {
            echo json_encode(array("error" => "Ya existe un detalle de mascota con el mismo ID de mascota."));
            return;
        }

        $query = "INSERT INTO FIDE_DETALLES_MASCOTAS_TB (ID_DETALLES_MASCOTAS, ID_MASCOTA, PESO, ESPECIE, RAZA, GENERO)
                  VALUES (:id_detalles_mascotas, :id_mascota, :peso, :especie, :raza, :genero)";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            oci_bind_by_name($stmt, ':id_detalles_mascotas', $this->id_detalles_mascotas);
            oci_bind_by_name($stmt, ':id_mascota', $this->id_mascota);
            oci_bind_by_name($stmt, ':peso', $this->peso);
            oci_bind_by_name($stmt, ':especie', $this->especie);
            oci_bind_by_name($stmt, ':raza', $this->raza);
            oci_bind_by_name($stmt, ':genero', $this->genero);

            if (!oci_execute($stmt)) {
                throw new Exception('Error al ejecutar la consulta: ' . oci_error($stmt)['message']);
            }
            self::desconectar();
        } catch (Exception $e) {
            self::desconectar();
            echo json_encode(array("error" => $e->getMessage()));
        }
    }

    public function actualizarDetalle()
    {
        $query = "UPDATE FIDE_DETALLES_MASCOTAS_TB
                  SET PESO = :peso, 
                      ESPECIE = :especie, 
                      RAZA = :raza, 
                      GENERO = :genero 
                  WHERE ID_DETALLES_MASCOTAS = :id_detalles_mascotas";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            oci_bind_by_name($stmt, ':id_detalles_mascotas', $this->id_detalles_mascotas);
            oci_bind_by_name($stmt, ':peso', $this->peso);
            oci_bind_by_name($stmt, ':especie', $this->especie);
            oci_bind_by_name($stmt, ':raza', $this->raza);
            oci_bind_by_name($stmt, ':genero', $this->genero);

            if (!oci_execute($stmt)) {
                throw new Exception('Error al ejecutar la consulta: ' . oci_error($stmt)['message']);
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
