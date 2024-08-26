<?php

include_once '../layout.php';

class adminController
{
    public static function ObtenerUsuarios($estado = null)
    {
        $conexion = AbrirBaseDatos();

        $sql = "SELECT u.NOMBRE_USUARIO AS username, 
                       CONCAT(u.NOMBRE, ' ', u.APPELIDO1, ' ', u.APPELIDO2) AS nombre_completo, 
                       u.TELEFONO AS telefono, 
                       u.CORREO AS email, 
                       r.NOMBRE_ROL AS rol,
                       u.ID_ESTADO,
                       u.ID_USUARIO
                FROM fide_tab_usuario u
                JOIN fide_tab_rol r ON u.ID_ROL = r.ID_ROL";

        if ($estado !== null) {
            $sql .= " WHERE u.ID_ESTADO = " . intval($estado);
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

        $sql = "UPDATE fide_tab_usuario SET ID_ESTADO = $nuevo_estado WHERE ID_USUARIO = $id_usuario";

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
}
