<?php
    include_once __DIR__ . '/../Model/productoModel.php';

    class productoController
    {
        public static function imprimirProductos()
        {
            return productoModel::imprimirProductos();
        }

        public static function agregarProducto()
        {
            session_start();
            $id_usuario = $_SESSION['id_usuario'];
            $titulo_publi = $_POST['titulo_publi'];
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

            $resultado = productoModel::agregarProducto($id_usuario, $titulo_publi, $descripcion, $imagen);

            if ($resultado) {
                echo json_encode(['success' => true, 'message' => 'Producto creado exitosamente.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al crear el Producto.']);
            }
        }


        public static function eliminarProducto()
        {
            $id_producto = $_POST['id_producto'];

            $resultado = productoModel::eliminarProducto($id_producto);

            if ($resultado) {
                echo json_encode(['success' => true, 'message' => 'Producto eliminado exitosamente.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al eliminar el Producto.']);
            }
        }

        public static function obtenerProducto($id_producto)
        {
            $producto = productoModel::obtenerProducto($id_producto);
            return $producto;
        }


        public static function editarProducto()
        {
            $id_producto = $_POST['id_producto'];
            $titulo_publi = $_POST['titulo_publi'];
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

            $resultado = productoModel::editarProducto($id_producto, $titulo_publi, $descripcion, $imagen);

            if ($resultado) {
                echo json_encode(['success' => true, 'message' => 'Producto editado exitosamente.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al editar el Producto.']);
            }
        }

    }

    if (isset($_GET['action']) && $_GET['action'] === 'Todos') {
        $productos = ProductoController::imprimirProductos();
        echo json_encode($productos);
    }

    if (isset($_GET['action']) && $_GET['action'] === 'Crear') {
        ProductoController::agregarProducto();
    }

    if (isset($_GET['action']) && $_GET['action'] === 'EliminarProducto') {
        ProductoController::eliminarProducto();
    }

    if (isset($_GET['action']) && $_GET['action'] === 'EditarProducto') {
        ProductoController::editarProducto();
    }

?>