<?php
include_once __DIR__ . '/../Model/adopcionModel.php';

class adopcionController
{
    public static function agregarSolicitudAdopcion()
    {
        session_start();
        $id_usuario = $_SESSION['id_usuario'];
        $id_carnet = intval($_POST['idCarnet']);
        $nombre_usuario = $_POST['nombre_usuario'];
        $num_telefono = $_POST['num_telefono'];
        $correo = $_POST['correo'];
        $mensaje = $_POST['mensaje'];

        $resultado = adopcionModel::registrarSolicitud($id_usuario, $id_carnet, $nombre_usuario, $num_telefono, $correo, $mensaje);

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

    public static function ObtenerSolicitudesAdopcion()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $id_usuario = $_SESSION['id_usuario'];
        return adopcionModel::ObtenerSolicitudesAdopcion($id_usuario);
    }


    public static function ObtenerSolicitudAdopcion($id_adopcion)
    {
        $solicitud = adopcionModel::ObtenerSolicitudAdopcion($id_adopcion);
        return $solicitud;
    }

    public static function RechazarSolicitud()
    {
        $id_adopcion = $_POST['id_adopcion'];

        $resultado = adopcionModel::RechazarSolicitud($id_adopcion);

        if ($resultado) {
            echo json_encode(['success' => true, 'message' => 'Se rechazo la solicitud de adopción exitosamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al rechazo la solicitud de adopción.']);
        }
    }
}


if (isset($_POST['action'])) {
    if ($_POST['action'] === 'EnviarMensaje') {
        adopcionController::agregarSolicitudAdopcion();
        adopcionController::actualizarEstadoCarnet();
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'Todos') {
    $solicitudes = adopcionController::ObtenerSolicitudesAdopcion();
    echo json_encode($solicitudes);
}

if (isset($_GET['action']) && $_GET['action'] === 'EliminarSolicitud') {
    adopcionController::RechazarSolicitud();
}
