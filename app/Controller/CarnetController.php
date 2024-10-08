<?php
include_once __DIR__ . '/../Model/carnetModel.php';

class carnetController
{

    public static function crearCarnet()
    {
        session_start();
        $id_usuario = $_SESSION['id_usuario'];
        $nombre_animal = $_POST['nombre_animal'];
        $raza = $_POST['raza'];
        $fecha_rescate = $_POST['fecha_rescate'];
        $descripcion = $_POST['descripcion'];

        $imagen = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $temp_name = $_FILES['image']['tmp_name'];
            $file_name = basename($_FILES['image']['name']);
            $upload_dir = '../View/subirImg/';
            $target_file = $upload_dir . $file_name;

            $file_type = mime_content_type($temp_name);
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($file_type, $allowed_types)) {
                echo json_encode(['success' => false, 'message' => 'Tipo de archivo no permitido.']);
                return;
            }

            if (move_uploaded_file($temp_name, $target_file)) {
                $imagen = $file_name;
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al subir la imagen.']);
                return;
            }
        }

        $resultado = carnetModel::crearCarnet($id_usuario, $nombre_animal, $raza, $fecha_rescate, $descripcion, $imagen);
        echo json_encode(['success' => $resultado, 'message' => $resultado ? 'Carnet creado exitosamente.' : 'Error al crear el carnet.']);
    }


    public static function obtenerCarnets()
    {
        return carnetModel::obtenerCarnets();
    }


    public static function obtenerCarnetsUsuario()
    {
        session_start();
        $id_usuario = $_SESSION['id_usuario'];
        return carnetModel::obtenerCarnetsPorUsuario($id_usuario);
    }


    public static function eliminarCarnet($idCarnet)
    {
        $resultado = carnetModel::eliminarCarnet($idCarnet);
        echo json_encode(['success' => $resultado, 'message' => $resultado ? 'Carnet eliminado exitosamente.' : 'Error al eliminar el carnet.']);
    }

    public static function actualizarCarnet()
    {
        session_start();
        $idCarnet = intval($_POST['idCarnet']);
        $nombre_animal = $_POST['nombre_animal'];
        $raza = $_POST['raza'];
        $fecha_rescate = $_POST['fecha_rescate'];
        $descripcion = $_POST['descripcion'];

        $imagen = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $temp_name = $_FILES['image']['tmp_name'];
            $file_name = basename($_FILES['image']['name']);
            $upload_dir = '../View/subirImg/';
            $target_file = $upload_dir . $file_name;

            $file_type = mime_content_type($temp_name);
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($file_type, $allowed_types)) {
                echo json_encode(['success' => false, 'message' => 'Tipo de archivo no permitido.']);
                return;
            }

            if (move_uploaded_file($temp_name, $target_file)) {
                $imagen = $file_name;
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al subir la imagen.']);
                return;
            }
        }

        $resultado = carnetModel::actualizarCarnet($idCarnet, $nombre_animal, $raza, $fecha_rescate, $descripcion, $imagen);
        echo json_encode(['success' => $resultado, 'message' => $resultado ? 'Carnet actualizado exitosamente.' : 'Error al actualizar el carnet.']);
    }

    public static function actualizarEstadoCarnet($idCarnet, $nuevoEstado)
    {
        session_start();
        $id_usuario = $_SESSION['id_usuario'];
        $carnet = carnetModel::obtenerCarnetPorId($idCarnet);

        if ($carnet && $carnet['ID_USUARIO'] == $id_usuario) {
            $resultado = carnetModel::actualizarEstadoCarnet($idCarnet, $nuevoEstado);
            echo json_encode(['success' => $resultado, 'message' => $resultado ? 'Estado actualizado exitosamente.' : 'Error al actualizar el estado.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No tienes permiso para actualizar este carnet.']);
        }
    }
}

if (isset($_POST['action'])) {
    if ($_POST['action'] === 'Crear') {
        carnetController::crearCarnet();
    } elseif ($_POST['action'] === 'Eliminar' && isset($_POST['idCarnet'])) {
        $idCarnet = intval($_POST['idCarnet']);
        carnetController::eliminarCarnet($idCarnet);
    } elseif ($_POST['action'] === 'Actualizar') {
        carnetController::actualizarCarnet();
    } elseif ($_POST['action'] === 'ActualizarEstado' && isset($_POST['idCarnet']) && isset($_POST['nuevoEstado'])) {
        $idCarnet = intval($_POST['idCarnet']);
        $nuevoEstado = intval($_POST['nuevoEstado']);
        carnetController::actualizarEstadoCarnet($idCarnet, $nuevoEstado);
    }
}
