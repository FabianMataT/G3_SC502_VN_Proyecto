<?php
include_once 'conexionDB.php';

class adopcionModel
{

    // Función para obtener los datos del usuario por ID
    public static function obtenerUsuarioPorID($id_usuario)
    {

        $conexion = AbrirBaseDatos();
        $query = "SELECT * FROM fide_tab_usuario WHERE ID_USUARIO = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('i', $id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $resultado;
    }

    // Función para guardar la solicitud de adopción en la base de datos
    public static function guardarSolicitudAdopcion($nombre, $email, $telefono, $direccion, $mensaje)
    {
        $conexion = AbrirBaseDatos();
        $query = "INSERT INTO fide_tab_adopcion (nombre, email, telefono, direccion, mensaje) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('sssss', $nombre, $email, $telefono, $direccion, $mensaje);
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }
}
