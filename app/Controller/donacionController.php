<?php

include_once '../../Model/conexionDB.php';
include_once  __DIR__ . '/../Model/conexionDB.php';

class donacionController
{
    public static function ObtenerUsuarioPorIDDonacion($id_usuario)
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

    public static function GuardarDonacion($id_usuario, $ruta_comprobante)
    {
        $conexion = AbrirBaseDatos();

        $id_usuario = intval($id_usuario);
        $ruta_comprobante = mysqli_real_escape_string($conexion, $ruta_comprobante);

        $sql = "INSERT INTO fide_tab_donacion (ID_USUARIO, LINK_COMPROBANTE) VALUES ($id_usuario, '$ruta_comprobante')";

        $resultado = mysqli_query($conexion, $sql);

        CerrarBaseDatos($conexion);

        return $resultado;
    }

    public static function ObtenerDonaciones()
    {
        $conexion = AbrirBaseDatos();

        $sql = "SELECT d.ID_DONACION, 
                       u.NOMBRE_USUARIO AS username, 
                       u.CORREO, 
                       u.TELEFONO
                FROM fide_tab_donacion d
                INNER JOIN fide_tab_usuario u ON d.ID_USUARIO = u.ID_USUARIO";

        $resultado = mysqli_query($conexion, $sql);

        $donaciones = [];
        while ($row = mysqli_fetch_assoc($resultado)) {
            $donaciones[] = $row;
        }

        CerrarBaseDatos($conexion);

        return $donaciones;
    }

    // Método para procesar la donación
    public static function ProcesarDonacion()
    {
        if (isset($_SESSION['id_usuario']) && $_SESSION['id_usuario']) {
            $id_usuario = $_SESSION['id_usuario'];

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo'])) {
                $nombreArchivo = $_FILES['archivo']['name'];
                $rutaTemporal = $_FILES['archivo']['tmp_name'];

                $carpetaDestino = 'C:/xampp/htdocs/G3_SC502_VN_Proyecto/app/View/dist/uploads/';

                if (!file_exists($carpetaDestino)) {
                    mkdir($carpetaDestino, 0777, true);
                }

                $rutaDestino = $carpetaDestino . basename($nombreArchivo);

                if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
                    if (self::GuardarDonacion($id_usuario, $rutaDestino)) {
                        header('Location: formularioDonacion.php?mensaje=exito');
                        exit;
                    } else {
                        echo "Error al guardar la donación en la base de datos.";
                    }
                } else {
                    echo "Error al mover el archivo.";
                }
            } else {
                echo "No se ha subido ningún archivo.";
            }
        } else {
            header('Location: formularioDonacion.php');
            exit;
        }
    }

    public static function ObtenerDonacionPorID($id_donacion)
    {
        $conexion = AbrirBaseDatos();
        $id_donacion = intval($id_donacion);

        $sql = "SELECT d.ID_DONACION, d.ID_USUARIO, d.LINK_COMPROBANTE, 
                       u.NOMBRE_USUARIO AS username, 
                       u.CORREO, 
                       u.TELEFONO,
                       CONCAT(u.NOMBRE, ' ', u.APELLIDO1, ' ', u.APELLIDO2) AS nombre_completo
                FROM fide_tab_donacion d
                JOIN fide_tab_usuario u ON d.ID_USUARIO = u.ID_USUARIO
                WHERE d.ID_DONACION = $id_donacion";

        $resultado = mysqli_query($conexion, $sql);
        $donacion = mysqli_fetch_assoc($resultado);

        CerrarBaseDatos($conexion);

        return $donacion;
    }
}
