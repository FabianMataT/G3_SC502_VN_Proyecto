<?php
include_once 'conexionDB.php';

class adopcionModel
{
  // Método para registrar una solicitud de adopción
    public static function registrarSolicitud($id_usuario, $id_carnet, $nombre_usuario, $num_telefono, $correo, $mensaje)
    {
        // Abre la conexión a la base de datos
        $conexion = AbrirBaseDatos();

        // Prepara la consulta SQL para insertar los datos
        $sql = "INSERT INTO fide_tab_adopcion (ID_USUARIO, ID_CARNET, NOMBRE_USUARIO, NUM_TELEFONO, CORREO, MENSAJE) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        
        // Asocia los parámetros de la consulta con las variables pasadas a la función
        $stmt->bind_param("iisiss", $id_usuario, $id_carnet, $nombre_usuario, $num_telefono, $correo, $mensaje);

        // Ejecuta la consulta y guarda el resultado
        $resultado = $stmt->execute();

        // Cierra la sentencia y la conexión
        $stmt->close();
        CerrarBaseDatos($conexion);

        // Devuelve el resultado de la operación (true o false)
        return $resultado;
    }

    // Nuevo método para obtener los datos del usuario por su ID
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

    
}
