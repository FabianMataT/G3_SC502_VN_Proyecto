<?php
include_once 'conexionDB.php';

class adopcionModel
{
    public static function registrarSolicitud($id_usuario, $id_carnet, $nombre_usuario, $num_telefono, $correo, $mensaje)
    {
        $conexion = AbrirBaseDatos();

        $sql = "INSERT INTO fide_tab_adopcion (ID_USUARIO, ID_CARNET, NOMBRE_USUARIO, NUM_TELEFONO, CORREO, MENSAJE) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("iisiss", $id_usuario, $id_carnet, $nombre_usuario, $num_telefono, $correo, $mensaje);

        $resultado = $stmt->execute();
        $stmt->close();
        CerrarBaseDatos($conexion);

        return $resultado;
    }


    public static function ObtenerUsuarioPorID($id_usuario)
    {
        $conexion = AbrirBaseDatos();
        $id_usuario = intval($id_usuario);

        $sql = "SELECT u.NOMBRE_USUARIO AS username, 
                       CONCAT(u.NOMBRE, ' ', u.APELLIDO1, ' ', u.APELLIDO2) AS nombre_completo, 
                       u.TELEFONO,
                       u.CORREO
                FROM fide_tab_usuario u
                WHERE u.ID_USUARIO = $id_usuario";

        $resultado = mysqli_query($conexion, $sql);
        $usuario = mysqli_fetch_assoc($resultado);

        CerrarBaseDatos($conexion);

        return $usuario;
    }


    public static function ObtenerSolicitudesAdopcion($id_usuario)
    {
        $conexion = AbrirBaseDatos();

        $sql = "SELECT A.NOMBRE_USUARIO, 
                   A.NUM_TELEFONO,
                   C.NOMBRE_ANIMAL,
                   A.ID_ADOPCION
            FROM fide_tab_adopcion A
            JOIN fide_tab_carnet C ON A.ID_CARNET = C.ID_CARNET
            WHERE C.ID_USUARIO = $id_usuario";

        $resultado = mysqli_query($conexion, $sql);

        $solicitudes = [];
        if ($resultado && mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $solicitudes[] = $fila;
            }
        }

        CerrarBaseDatos($conexion);

        return $solicitudes;
    }



    public static function ObtenerSolicitudAdopcion($id_adopcion)
    {
        $conexion = AbrirBaseDatos();

        $sql = "SELECT A.NOMBRE_USUARIO, 
                   A.NUM_TELEFONO, 
                   A.CORREO,
                   A.MENSAJE,
                   A.ID_ADOPCION,
                   C.NOMBRE_ANIMAL,
                   C.RAZA,
                   C.FECHA_RESCATE,
                   C.DESCRIPCION,
                   C.IMAGEN
            FROM fide_tab_adopcion A
            JOIN fide_tab_carnet C ON A.ID_CARNET = C.ID_CARNET
            WHERE A.ID_ADOPCION = $id_adopcion";

        $resultado = mysqli_query($conexion, $sql);

        $solicitud = [];
        if ($resultado && mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $solicitud[] = $fila;
            }
        }

        CerrarBaseDatos($conexion);

        return $solicitud;
    }

    public static function RechazarSolicitud($id_adopcion)
    {
        $conexion = AbrirBaseDatos();
        $conexion->begin_transaction();
        try {
            $sql_carnet = "SELECT ID_CARNET FROM fide_tab_adopcion WHERE ID_ADOPCION = ?";
            $stmt_carnet = $conexion->prepare($sql_carnet);
            $stmt_carnet->bind_param("i", $id_adopcion);
            $stmt_carnet->execute();
            $stmt_carnet->bind_result($id_carnet);
            $stmt_carnet->fetch();
            $stmt_carnet->close();

            $sql_update = "UPDATE fide_tab_carnet SET ID_ESTADO = 2 WHERE ID_CARNET = ?";
            $stmt_update = $conexion->prepare($sql_update);
            $stmt_update->bind_param("i", $id_carnet);
            $stmt_update->execute();
            $stmt_update->close();

            $sql_delete = "DELETE FROM fide_tab_adopcion WHERE ID_ADOPCION = ?";
            $stmt_delete = $conexion->prepare($sql_delete);
            $stmt_delete->bind_param("i", $id_adopcion);
            $resultado = $stmt_delete->execute();
            $stmt_delete->close();
            $conexion->commit();
            CerrarBaseDatos($conexion);
            return $resultado;
        } catch (Exception $e) {
            $conexion->rollback();
            CerrarBaseDatos($conexion);
            return false;
        }
    }
}
