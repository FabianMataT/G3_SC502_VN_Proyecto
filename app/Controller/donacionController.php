<?php

include_once '../../Model/conexionDB.php';

class donacionController
{
    public static function ObtenerUsuarioPorIDDonacion($id_usuario)
    {
        $conexion = AbrirBaseDatos();
        $id_usuario = intval($id_usuario);

        $sql = "SELECT u.NOMBRE_USUARIO AS username, 
                       CONCAT(u.NOMBRE, ' ', u.APPELIDO1, ' ', u.APPELIDO2) AS nombre_completo, 
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

    // Método para procesar la donación
    public static function ProcesarDonacion()
    {
        if (isset($_SESSION['id_usuario']) && $_SESSION['id_usuario']) {
            $id_usuario = $_SESSION['id_usuario'];

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo'])) {
                $nombreArchivo = $_FILES['archivo']['name'];
                $rutaTemporal = $_FILES['archivo']['tmp_name'];

                // Define la carpeta de destino
                $carpetaDestino = 'C:/xampp/htdocs/G3_SC502_VN_Proyecto/app/View/dist/uploads/';

                // Asegúrate de que la carpeta exista
                if (!file_exists($carpetaDestino)) {
                    mkdir($carpetaDestino, 0777, true);
                }

                // Define la ruta completa de destino
                $rutaDestino = $carpetaDestino . basename($nombreArchivo);

                // Mueve el archivo subido a la carpeta destino
                if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
                    // Guardar información en la base de datos
                    if (self::GuardarDonacion($id_usuario, $rutaDestino)) {
                        // Redirigir a una página de éxito
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
}
?>
