<?php
require_once '../config/Conexion.php';

class customerModel
{
    protected static $cnx;
    private $customer_id = null;
    private $email_address = null;
    private $full_name = null;

    public function getCustomerId()
    {
        return $this->customer_id;
    }

    public function setCustomerId($customer_id)
    {
        $this->customer_id = $customer_id;
    }

    public function getEmailAddress()
    {
        return $this->email_address;
    }

    public function setEmailAddress($email_address)
    {
        $this->email_address = $email_address;
    }

    public function getFullName()
    {
        return $this->full_name;
    }

    public function setFullName($full_name)
    {
        $this->full_name = $full_name;
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

    public function listarTodosClientes()
    {
        $query = "SELECT * FROM CUSTOMERS";
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
                $customer = new customerModel();
                $customer->setCustomerId($row['CUSTOMER_ID']);
                $customer->setEmailAddress($row['EMAIL_ADDRESS']);
                $customer->setFullName($row['FULL_NAME']);
                $arr[] = array(
                    'customer_id' => $customer->getCustomerId(),
                    'email_address' => $customer->getEmailAddress(),
                    'full_name' => $customer->getFullName(),
                );
            }

            self::desconectar();
            return $arr;
        } catch (Exception $e) {
            self::desconectar();
            return "Error " . $e->getCode() . ": " . $e->getMessage();
        }
    }

    public function guardarCliente()
    {
        $query = "INSERT INTO CUSTOMERS (CUSTOMER_ID, EMAIL_ADDRESS, FULL_NAME) VALUES (:customer_id, :email_address, :full_name)";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
            }

            oci_bind_by_name($stmt, ':customer_id', $this->customer_id);
            oci_bind_by_name($stmt, ':email_address', $this->email_address);
            oci_bind_by_name($stmt, ':full_name', $this->full_name);

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

    public function actualizarCliente()
    {
        $query = "UPDATE CUSTOMERS 
                  SET EMAIL_ADDRESS = :email_address, 
                      FULL_NAME = :full_name 
                  WHERE CUSTOMER_ID = :customer_id";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
            }

            $customer_id = $this->getCustomerId();
            $email_address = $this->getEmailAddress();
            $full_name = $this->getFullName();

            oci_bind_by_name($stmt, ':customer_id', $customer_id);
            oci_bind_by_name($stmt, ':email_address', $email_address);
            oci_bind_by_name($stmt, ':full_name', $full_name);

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
