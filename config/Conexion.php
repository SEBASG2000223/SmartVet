<?php

class Conexion
{
    private static $oracleConnection = null;
    private static $mysqlConnection = null;

    public static function conectarOracle()
    {
        if (self::$oracleConnection === null) {
            self::$oracleConnection = oci_connect("PROYECTO_GRUPO2", "PROYECTO1234", "localhost/xe");

            if (!self::$oracleConnection) {
                $m = oci_error();
                die("Error de conexión a Oracle: " . $m['message']);
            }
        }

        return self::$oracleConnection;
    }

  }
?>
