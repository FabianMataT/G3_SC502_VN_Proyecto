<?php
include_once '../../Controller/adminController.php';

session_start();

$id_usuario = $_SESSION['id_usuario'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si se subió un archivo
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = $_FILES['archivo']['name'];
        $tipoArchivo = $_FILES['archivo']['type'];
        $rutaTemporal = $_FILES['archivo']['tmp_name'];
        $errorArchivo = $_FILES['archivo']['error'];
        $tamanoArchivo = $_FILES['archivo']['size'];

        // Define la carpeta de destino
        $carpetaDestino = 'C:\xampp\htdocs\G3_SC502_VN_Proyecto\app\View\dist\uploads';

        // Asegúrate de que la carpeta exista
        if (!file_exists($carpetaDestino)) {
            mkdir($carpetaDestino, 0777, true);
        }

        // Define la ruta completa de destino
        $rutaDestino = $carpetaDestino . basename($nombreArchivo);

        // Mueve el archivo subido a la carpeta destino
        if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
            // Guardar información en la base de datos o realizar cualquier otra acción necesaria
            adminController::GuardarDonacion($id_usuario, $rutaDestino);

            // Redirigir a una página de éxito o mostrar un mensaje
            header('Location: formularioDonacion.php?mensaje=exito');
            exit;
        } else {
            echo "Error al mover el archivo.";
        }
    } else {
        echo "Error al subir el archivo.";
    }
} else {
    header('Location: formularioDonacion.php');
    exit;
}
?>
