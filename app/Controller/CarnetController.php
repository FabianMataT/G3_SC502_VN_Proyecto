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
        $fecha_rescate = $_POST['anio_rescate'];
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

        if ($resultado) {
            echo json_encode(['success' => true, 'message' => 'Carnet creado exitosamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al crear el carnet.']);
        }
    }


    public static function obtenerCarnets()
    {
        return carnetModel::obtenerCarnets();
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'Todos') {
    $carnets = CarnetController::obtenerCarnets();
    echo json_encode($carnets);
}

if (isset($_GET['action']) && $_GET['action'] === 'Crear') {
    carnetController::crearCarnet();
}
