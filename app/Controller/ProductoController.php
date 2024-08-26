<?php

session_start();

require_once '../Model/conexion.php';
require_once '../Model/Methods/ProductoM.php';
require_once '../Model/Entities/Producto.php';

class ProductoController
{

    function Todos()
    {
        // Crear una instancia del modelo de productos
        $productoM = new ProductoM();
    
        // Llamar al método 'Todos' del modelo para obtener todos los productos
        $todos = $productoM->Todos();
    
        // Consultar ubicaciones
        $ubicaciones = $productoM->Ubicacion();
        $ubicacionesMap = [];
        foreach ($ubicaciones as $ubicacion) {
            $ubicacionesMap[$ubicacion['id_ubicacion']] = $ubicacion;
        }
    
        // Comprobar si se obtuvieron productos
        if ($todos === null) {
            $datos = [];
        } else {
            // Mapear cada registro a un formato adecuado, incluyendo la descripción de la ubicación
            $datos = array_map(function ($registro) use ($ubicacionesMap) {
                $ubicacion = $ubicacionesMap[$registro->getId_ubicacion()] ?? null;
                $ubicacionDescripcion = $ubicacion ? $ubicacion['provincia'] . ' - ' . $ubicacion['canton'] . ' - ' . $ubicacion['distrito'] : 'Desconocida';
                return [
                    'id_producto' => $registro->getId_producto(),
                    'id_usuario' => $registro->getId_usuario(),
                    'ubicacion_descripcion' => $ubicacionDescripcion,
                    'titulo_publi' => $registro->getTitulo_publi(),
                    'descripcion' => $registro->getDescripcion(),
                    'imagen' => $registro->getImagen()
                ];
            }, $todos);
        }
    
        header('Content-Type: application/json');
        echo json_encode($datos);
    }
    


    // METODO PARA CREAR PRODUCTO
    function Crear()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo_publi = $_POST['titulo_publi'] ?? null;
            $descripcion = $_POST['descripcion'] ?? null;
            $id_ubicacion = $_POST['id_ubicacion'] ?? null;

            if (!$titulo_publi || !$descripcion) {
                echo json_encode(['success' => false, 'message' => 'Título y Descripción son obligatorios.']);
                return;
            }

            //VALIDACION DE IMAGEN
            $imagen = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                $temp_name = $_FILES['image']['tmp_name']; // ARCHIVO TEMPORAL
                $file_name = basename($_FILES['image']['name']); //NOMBRE DEL ARCHIVO
                $upload_dir = '../View/subirImg/'; //Direccion de la carpeta donde se guarda la imagen
                $target_file = $upload_dir . $file_name;

                // Validar tipo de archivo y tamaño
                $file_type = mime_content_type($temp_name);
                $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($file_type, $allowed_types)) {
                    echo json_encode(['success' => false, 'message' => 'Tipo de archivo no permitido.']);
                    return;
                }

                if (move_uploaded_file($temp_name, $target_file)) {
                    $imagen = $target_file;
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al subir la imagen.']);
                    return;
                }
            }

            // Crear el objeto Producto
            $producto = new Producto();
            $producto->setTitulo_publi($titulo_publi);
            $producto->setDescripcion($descripcion);
            $producto->setId_ubicacion($id_ubicacion);
            $producto->setImagen($imagen);
            $producto->setEstado(1); // Estado activo

            $productoM = new ProductoM();
            $resultado = $productoM->NuevoProducto($producto);


            header('Content-Type: application/json');
            echo json_encode(['success' => $resultado]);
            exit; // Asegura que no se envíe ninguna salida adicional
        } else {
            echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
        }
    }

    //METODO PARA PASAR A 0 EL ESTADO
    function Eliminar()
    {
        $p = new Producto();
        $p->setId_producto($_POST["id_producto"]);
        $p->setEstado($_POST["estado"]); // TRAER Estado = 0

        $iM = new ProductoM(); 

        // Cambia el método 'Desactivar' para que solo desactive el producto
        $resultado = $iM->Desactivar($p);

        // Responder con JSON indicando si la operación fue exitosa
        header('Content-Type: application/json');
        echo json_encode(['success' => $resultado]);
    }


    //METODO TRAER UBICACIONES
    function Ubicacion()
    {
        $productoM = new ProductoM();
        $todos = $productoM->Ubicacion();

        if ($todos === null) {
            $datos = [];
        } else {
            $datos = array_map(function ($registro) {
                return [
                    'id_ubicacion' => $registro['id_ubicacion'],
                    'provincia' => $registro['provincia'],
                    'canton' => $registro['canton'],
                    'distrito' => $registro['distrito'],
                    'otras_senas' => $registro['otras_senas'],
                ];
            }, $todos);
        }

        echo json_encode($datos);
    }

   // Método para actualizar un producto
function Actualizar()
{
    // Verificar si la solicitud es de tipo POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtener datos del formulario (si están presentes)
        $id_producto = $_POST['id_producto'] ?? null;
        $titulo_publi = $_POST['titulo_publi'] ?? null;
        $descripcion = $_POST['descripcion'] ?? null;
        $id_ubicacion = $_POST['id_ubicacion'] ?? null;

        // Inicializar la variable para la imagen
        $imagen = null;

        // Manejo del archivo de imagen si se sube uno
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $temp_name = $_FILES['image']['tmp_name']; // Nombre temporal del archivo
            $file_name = basename($_FILES['image']['name']); // Nombre del archivo
            $upload_dir = '../View/subirImg/'; // Directorio donde se guardarán las imágenes
            $target_file = $upload_dir . $file_name; // Ruta completa del archivo destino

            // Validar el tipo de archivo
            $file_type = mime_content_type($temp_name);
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($file_type, $allowed_types)) {
                // Tipo de archivo no permitido
                echo json_encode(['success' => false, 'message' => 'Tipo de archivo no permitido.']);
                return;
            }

            // Mover el archivo al directorio destino
            if (move_uploaded_file($temp_name, $target_file)) {
                $imagen = $target_file; // Actualizar la variable de imagen con la ruta del archivo
            } else {
                // Error al mover el archivo
                echo json_encode(['success' => false, 'message' => 'Error al subir la imagen.']);
                return;
            }
        }

        // Crear una instancia del modelo de productos
        $productoM = new ProductoM();

        // Obtener el producto actual desde la base de datos para verificar el path de la imagen actual
        $productoActual = $productoM->ObtenerProductoPorId($id_producto);

        if ($productoActual === null) {
            // Si el producto no se encuentra, devolver un mensaje de error
            echo json_encode(['success' => false, 'message' => 'Producto no encontrado.']);
            return;
        }

        // Si no se subió una nueva imagen, mantener la imagen actual del producto
        if ($imagen === null) {
            $imagen = $productoActual['IMAGEN']; // Mantener la imagen actual
        }

        // Preparar los datos del producto para la actualización
        $producto = [
            'id_producto' => $id_producto,
            'titulo_publi' => $titulo_publi,
            'descripcion' => $descripcion,
            'id_ubicacion' => $id_ubicacion,
            'imagen' => $imagen,
        ];

        // Actualizar el producto en la base de datos
        $resultado = $productoM->ActualizarProducto($producto);

        // Devolver el resultado de la operación
        echo json_encode(['success' => $resultado]);
    } else {
        // Si el método de la solicitud no es POST, devolver un mensaje de error
        echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
    }
}

}

// Verifica si existe el parámetro 'action' en la consulta de la URL (método GET)
if (isset($_GET['action'])) {
    // Crea una instancia del controlador de productos
    $controlador = new ProductoController();

    // Determina la acción a realizar basada en el valor del parámetro 'action'
    switch ($_GET['action']) {
        case 'Todos':
            // Llama al método 'Todos' del controlador para obtener todos los productos
            $controlador->Todos();
            break;
        case 'Crear':
            // Llama al método 'Crear' del controlador para crear un nuevo producto
            $controlador->Crear();
            // Se omite el 'break' aquí, lo que significa que también se ejecutará el siguiente caso
        case 'Ubicacion':
            // Llama al método 'Ubicacion' del controlador para obtener las ubicaciones
            $controlador->Ubicacion();
            break;
        case 'Actualizar':
            // Llama al método 'Actualizar' del controlador para actualizar un producto existente
            $controlador->Actualizar();
            break;
        // Agrega más casos si hay otras acciones disponibles en tu controlador
    }
}

// Verifica si existe el parámetro 'action' en los datos del formulario (método POST)
if (isset($_POST['action'])) {
    // Crea una instancia del controlador de productos
    $controlador = new ProductoController();

    // Determina la acción a realizar basada en el valor del parámetro 'action'
    switch ($_POST['action']) {
        case 'Eliminar':
            // Llama al método 'Eliminar' del controlador para eliminar un producto
            $controlador->Eliminar();
            break;
        // Agrega más casos si hay otras acciones disponibles en tu controlador
    }
}
