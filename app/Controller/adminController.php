<?php
include_once '../layout.php';

class adminController
{
    //Funciones usadas en verUsuarios.php
    public static function ObtenerUsuarios($estado = null)
    {
        $conexion = AbrirBaseDatos();

        $sql = "SELECT u.NOMBRE_USUARIO AS username, 
                   CONCAT(u.NOMBRE, ' ', u.APELLIDO1, ' ', u.APELLIDO2) AS nombre_completo, 
                   u.TELEFONO AS telefono, 
                   u.CORREO AS email, 
                   r.NOMBRE_ROL AS rol,
                   u.ESTADO,
                   u.ID_USUARIO
            FROM fide_tab_usuario u
            JOIN fide_tab_rol r ON u.ID_ROL = r.ID_ROL";

        if ($estado !== null) {
            $sql .= " WHERE u.ESTADO = " . intval($estado);
        }

        $resultado = mysqli_query($conexion, $sql);

        $usuarios = [];
        if ($resultado && mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $usuarios[] = $fila;
            }
        }

        CerrarBaseDatos($conexion);

        return $usuarios;
    }

    public static function ObtenerUsuariosEnValidacion($rol = null)
    {
        $conexion = AbrirBaseDatos();
    
        $sql = "SELECT u.NOMBRE_USUARIO AS username, 
                       CONCAT(u.NOMBRE, ' ', u.APELLIDO1, ' ', u.APELLIDO2) AS nombre_completo, 
                       u.TELEFONO AS telefono, 
                       u.CORREO AS email, 
                       r.NOMBRE_ROL AS rol,
                       u.ESTADO,
                       u.ID_USUARIO,
                       u.ID_ROL
                FROM fide_tab_usuario u
                JOIN fide_tab_rol r ON u.ID_ROL = r.ID_ROL";

        if ($rol !== null) {
            $sql .= " WHERE u.ID_ROL = " . intval($rol);
        }
    
        $resultado = mysqli_query($conexion, $sql);

        $usuarios = [];
        if ($resultado && mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $usuarios[] = $fila;
            }
        }
    
        CerrarBaseDatos($conexion);
    
        return $usuarios;
    }


    public static function CambiarEstadoUsuario($id_usuario, $nuevo_estado)
    {
        $conexion = AbrirBaseDatos();

        $id_usuario = intval($id_usuario);
        $nuevo_estado = intval($nuevo_estado);

        $sql = "UPDATE fide_tab_usuario SET ESTADO = $nuevo_estado WHERE ID_USUARIO = $id_usuario";

        $resultado = mysqli_query($conexion, $sql);

        CerrarBaseDatos($conexion);

        return $resultado;
    }

    public static function EliminarUsuario($id_usuario)
    {
        $conexion = AbrirBaseDatos();

        $id_usuario = intval($id_usuario);

        $sql = "DELETE FROM fide_tab_usuario WHERE ID_USUARIO = $id_usuario";

        $resultado = mysqli_query($conexion, $sql);

        CerrarBaseDatos($conexion);

        return $resultado;
    }



    //Funciones Usadas en editarRolUsuario.php
    public static function ObtenerUsuarioPorID($id_usuario)
    {
        $conexion = AbrirBaseDatos();
        $id_usuario = intval($id_usuario);

        $sql = "SELECT u.NOMBRE_USUARIO AS username, 
                       CONCAT(u.NOMBRE, ' ', u.APELLIDO1, ' ', u.APELLIDO2) AS nombre_completo, 
                       u.ID_ROL
                FROM fide_tab_usuario u
                WHERE u.ID_USUARIO = $id_usuario";

        $resultado = mysqli_query($conexion, $sql);
        $usuario = mysqli_fetch_assoc($resultado);

        CerrarBaseDatos($conexion);

        return $usuario;
    }

    public static function ObtenerUsuarioValidacionPorID($id_usuario)
    {
        $conexion = AbrirBaseDatos();
        $id_usuario = intval($id_usuario);

        $sql = "SELECT u.NOMBRE_USUARIO AS username, 
                       CONCAT(u.NOMBRE, ' ', u.APELLIDO1, ' ', u.APELLIDO2) AS nombre_completo, 
                       u.ID_ROL,
                       u.TELEFONO,
                       u.CORREO,
                       PO.EMPRESA,
                       PO.MOTIVO_PERFIL,
                       PO.COMPROBANTE_SINPE
                FROM fide_tab_usuario u
                JOIN fide_tab_profecional PO ON u.ID_USUARIO = PO.ID_USUARIO
                where u.ID_USUARIO = $id_usuario";

        $resultado = mysqli_query($conexion, $sql);
        $usuario = mysqli_fetch_assoc($resultado);

        CerrarBaseDatos($conexion);

        return $usuario;
    }

    public static function ObtenerRoles()
    {
        $conexion = AbrirBaseDatos();

        $sql = "SELECT ID_ROL, NOMBRE_ROL FROM fide_tab_rol";
        $resultado = mysqli_query($conexion, $sql);

        $roles = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $roles[] = $fila;
        }

        CerrarBaseDatos($conexion);

        return $roles;
    }

    public static function ActualizarRolUsuario($id_usuario, $id_rol)
    {
        $conexion = AbrirBaseDatos();

        $id_usuario = intval($id_usuario);
        $id_rol = intval($id_rol);

        $sql = "UPDATE fide_tab_usuario SET ID_ROL = $id_rol WHERE ID_USUARIO = $id_usuario";
        $resultado = mysqli_query($conexion, $sql);

        CerrarBaseDatos($conexion);

        return $resultado;
    }

}
