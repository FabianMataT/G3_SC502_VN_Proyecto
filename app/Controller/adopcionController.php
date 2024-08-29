<?php
// Incluye el modelo que maneja la interacción con la base de datos
include_once '../../Model/adopcionModel.php';

class adopcionController {

    // Función para obtener los datos del usuario por ID
    public static function ObtenerUsuarioPorIDAdopcion($id_usuario) {
        // Llama al modelo para obtener los datos del usuario
        $usuario = adopcionModel::obtenerUsuarioPorID($id_usuario);
        return $usuario;
    }

    // Función para procesar la solicitud de adopción
    public static function ProcesarAdopcion() {
        // Verificar si los campos requeridos están presentes
        if (isset($_POST['nombre']) && isset($_POST['email']) && isset($_POST['telefono']) && isset($_POST['direccion']) && isset($_POST['mensaje'])) {
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $telefono = $_POST['telefono'];
            $direccion = $_POST['direccion'];
            $mensaje = $_POST['mensaje'];

            // Guardar la solicitud de adopción en la base de datos
            $resultado = adopcionModel::guardarSolicitudAdopcion($nombre, $email, $telefono, $direccion, $mensaje);

            if ($resultado) {
                // Redirigir con un mensaje de éxito
                header('Location: adopcion.php?mensaje=exito');
                exit;
            } else {
                // Manejar el error si la solicitud no pudo ser guardada
                echo "Hubo un problema al procesar la solicitud. Por favor, inténtalo de nuevo.";
            }
        } else {
            echo "Todos los campos son obligatorios.";
        }
    }
}
?>
