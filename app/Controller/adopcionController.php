<?php
include_once '../Model/adopcionModel.php';

class adopcionController
{
    public static function agregarSolicitudAdopcion()
    {
        session_start();

        // Obtiene los datos del formulario enviados por POST
        $id_usuario = $_SESSION['id_usuario'];
        $id_carnet = intval($_POST['idCarnet']);
        $nombre_usuario = $_POST['nombre_usuario'];
        $num_telefono = $_POST['num_telefono'];  // Asegúrate que el nombre coincide con el del formulario
        $correo = $_POST['correo'];
        $mensaje = $_POST['mensaje'];

        // Llama al modelo para registrar la solicitud en la base de datos
        $resultado = adopcionModel::registrarSolicitud($id_usuario, $id_carnet, $nombre_usuario, $num_telefono, $correo, $mensaje);

        // Devuelve una respuesta basada en el resultado de la inserción
        if ($resultado) {
            echo json_encode(['success' => true, 'message' => 'Solicitud de adopción enviada exitosamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al enviar la solicitud de adopción.']);
        }
    }

    public static function actualizarEstadoCarnet()
    {
        $conexion = AbrirBaseDatos();

        $id_carnet = intval($_POST['idCarnet']);

        $sql = "UPDATE fide_tab_carnet SET ID_ESTADO = ? WHERE ID_CARNET = ?";
        $stmt = $conexion->prepare($sql);
        $nuevo_estado = 3;

        $stmt->bind_param("ii", $nuevo_estado, $id_carnet);
        $resultado = $stmt->execute();

        $stmt->close();
        CerrarBaseDatos($conexion);

        return $resultado;
    }
}

// Manejador de solicitudes
if (isset($_POST['action'])) {
    if ($_POST['action'] === 'EnviarMensaje') {
        adopcionController::agregarSolicitudAdopcion();
        adopcionController::actualizarEstadoCarnet();
    }
}
