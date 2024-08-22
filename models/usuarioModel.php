<?php
require_once '../config/Conexion.php';

class usuarioModel
{
    protected static $cnx;
    private $id_usuario = null;
    private $id_empleado = null;
    private $id_rol = null;
    private $id_estado = null;
    private $nombre_usuario = null;
    private $contrasena = null;
    private $correo = null;

    // Getters y setters
    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    public function setIdUsuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    public function getIdEmpleado()
    {
        return $this->id_empleado;
    }

    public function setIdEmpleado($id_empleado)
    {
        $this->id_empleado = $id_empleado;
    }

    public function getIdRol()
    {
        return $this->id_rol;
    }

    public function setIdRol($id_rol)
    {
        $this->id_rol = $id_rol;
    }

    public function getIdEstado()
    {
        return $this->id_estado;
    }

    public function setIdEstado($id_estado)
    {
        $this->id_estado = $id_estado;
    }

    public function getNombreUsuario()
    {
        return $this->nombre_usuario;
    }

    public function setNombreUsuario($nombre_usuario)
    {
        $this->nombre_usuario = $nombre_usuario;
    }

    public function getContrasena()
    {
        return $this->contrasena;
    }

    public function setContrasena($contrasena)
    {
        $this->contrasena = $contrasena;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function setCorreo($correo)
    {
        $this->correo = $correo;
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

    public function listarTodosUsuarios()
    {
        $query = "SELECT * FROM FIDE_USUARIOS_TB";
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

            $estados = self::obtenerEstados();
            $roles = self::obtenerRoles();

            while ($row = oci_fetch_assoc($stmt)) {
                $usuario = new usuarioModel();
                $usuario->setIdUsuario($row['ID_USUARIO']);
                $usuario->setIdEmpleado($row['ID_EMPLEADO']);
                $usuario->setIdRol($row['ID_ROL']);
                $usuario->setIdEstado($row['ID_ESTADO']);
                $usuario->setNombreUsuario($row['NOMBRE_USUARIO']);
          
                $usuario->setCorreo($row['CORREO']);
                $arr[] = array(
                    'id_usuario' => $usuario->getIdUsuario(),
                    'id_empleado' => $usuario->getIdEmpleado(),
                    'id_rol' => $roles[$usuario->getIdRol()],
                    'id_estado' => $estados[$usuario->getIdEstado()],
                    'nombre_usuario' => $usuario->getNombreUsuario(),
                    'correo' => $usuario->getCorreo(),
                );
            }

            self::desconectar();
            return $arr;
        } catch (Exception $e) {
            self::desconectar();
            return "Error " . $e->getCode() . ": " . $e->getMessage();
        }
    }

    public function guardarUsuario()
    {
        $query = "INSERT INTO FIDE_USUARIOS_TB (ID_USUARIO, ID_EMPLEADO, ID_ROL, ID_ESTADO, NOMBRE_USUARIO, CORREO) 
                  VALUES (:id_usuario, :id_empleado, :id_rol, :id_estado, :nombre_usuario, :correo)";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
            }

            oci_bind_by_name($stmt, ':id_usuario', $this->id_usuario);
            oci_bind_by_name($stmt, ':id_empleado', $this->id_empleado);
            oci_bind_by_name($stmt, ':id_rol', $this->id_rol);
            oci_bind_by_name($stmt, ':id_estado', $this->id_estado);
            oci_bind_by_name($stmt, ':nombre_usuario', $this->nombre_usuario);
            oci_bind_by_name($stmt, ':correo', $this->correo);

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

    public static function obtenerRoles()
{
    return array(
        1 => 'Administrador',
        2 => 'Doctor',
        3 => 'Cajero',
        4 => 'Recepcionista',
        5 => 'Empleado',
        6 => 'Encargado Inventario',
        7 => 'Administrador',
        8 => 'Doctor',
        9 => 'Cajero',
        10 => 'Recepcionista',
        11 => 'Empleado',
        12 => 'Encargado Inventario'
    );
}


    public function actualizarUsuario()
    {
        $query = "UPDATE FIDE_USUARIOS_TB 
                  SET ID_EMPLEADO = :id_empleado, 
                      ID_ROL = :id_rol, 
                      ID_ESTADO = :id_estado, 
                      NOMBRE_USUARIO = :nombre_usuario, 
                      CORREO = :correo 
                  WHERE ID_USUARIO = :id_usuario";
        try {
            self::getConexion();
            $stmt = oci_parse(self::$cnx, $query);
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . oci_error(self::$cnx)['message']);
            }

            $id_usuario = $this->getIdUsuario();
            $id_empleado = $this->getIdEmpleado();
            $id_rol = $this->getIdRol();
            $id_estado = $this->getIdEstado();
            $nombre_usuario = $this->getNombreUsuario();
            $contrasena = $this->getContrasena();
            $correo = $this->getCorreo();

            oci_bind_by_name($stmt, ':id_usuario', $id_usuario);
            oci_bind_by_name($stmt, ':id_empleado', $id_empleado);
            oci_bind_by_name($stmt, ':id_rol', $id_rol);
            oci_bind_by_name($stmt, ':id_estado', $id_estado);
            oci_bind_by_name($stmt, ':nombre_usuario', $nombre_usuario);
            oci_bind_by_name($stmt, ':correo', $correo);

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
