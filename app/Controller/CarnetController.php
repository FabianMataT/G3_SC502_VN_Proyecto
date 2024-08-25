<?php

// Inicia la sesión para gestionar el estado de la sesión del usuario
session_start();

// Incluye los archivos necesarios para la conexión a la base de datos, métodos del modelo y entidades
require_once '../../Model/conexion.php';
require_once '../../Model/Methods/CarnetM.php';
require_once '../../Model/Entities/Carnet.php';

// Define la clase CarnetController
class CarnetController
{
    // Método para obtener todos los carnets
    function Todos()
    {
        // Crea una instancia del modelo CarnetM
        $carnetM = new CarnetM();
        // Obtiene todos los carnets del modelo
        $todos = $carnetM->Todos();

        // Verifica si se obtuvieron carnets
        if ($todos === null) {
            $datos = [];
        } else {
            // Mapea los datos obtenidos a un formato específico
            $datos = array_map(function ($registro) {
                return [
                    'id_carnet' => $registro->getId_carnet(),
                    'id_estado' => $registro->getId_estado(),
                    'nombre_animal' => $registro->getNombre_animal(),
                    'raza' => $registro->getRaza(),
                    'anio_rescate' => $registro->getAnio_rescate(),
                    'descripcion' => $registro->getDescripcion(),
                    'imagen' => $registro->getImagen()
                ];
            }, $todos);
        }

        // Establece el encabezado de la respuesta como JSON y devuelve los datos
        header('Content-Type: application/json');
        echo json_encode($datos);
    }

    // Método para crear un nuevo carnet
    function Crear()
    {
        // Verifica si la solicitud es de tipo POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoge los datos del formulario
            $id_estado = $_POST['id_estado'] ?? null;
            $nombre_animal = $_POST['nombre_animal'] ?? null;
            $raza = $_POST['raza'] ?? null;
            $anio_rescate = $_POST['anio_rescate'] ?? null;
            $descripcion = $_POST['descripcion'] ?? null;

            // Verifica que los campos obligatorios estén presentes
            if (!$nombre_animal || !$descripcion) {
                echo json_encode(['success' => false, 'message' => 'Nombre del animal y Descripción son obligatorios.']);
                return;
            }

            // Manejo del archivo de imagen
            $imagen = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                $temp_name = $_FILES['image']['tmp_name'];
                $file_name = basename($_FILES['image']['name']);
                $upload_dir = '../View/subirImg/'; // Directorio donde se subirá la imagen
                $target_file = $upload_dir . $file_name;

                // Validar tipo de archivo y tamaño
                $file_type = mime_content_type($temp_name);
                $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($file_type, $allowed_types)) {
                    echo json_encode(['success' => false, 'message' => 'Tipo de archivo no permitido.']);
                    return;
                }

                // Mueve el archivo subido al directorio de destino
                if (move_uploaded_file($temp_name, $target_file)) {
                    $imagen = $target_file;
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al subir la imagen.']);
                    return;
                }
            }

            // Crea una instancia de la entidad Carnet
            $carnet = new Carnet();
            $carnet->setId_estado($id_estado);
            $carnet->setNombre_animal($nombre_animal);
            $carnet->setRaza($raza);
            $carnet->setAnio_rescate($anio_rescate);
            $carnet->setDescripcion($descripcion);
            $carnet->setEstado(1); // Estado activo
            $carnet->setImagen($imagen);

            // Crea una instancia del modelo CarnetM y llama al método para agregar el nuevo carnet
            $carnetM = new CarnetM();
            $resultado = $carnetM->NuevoCarnet($carnet);

            // Establece el encabezado de la respuesta como JSON y devuelve el resultado
            header('Content-Type: application/json');
            echo json_encode(['success' => $resultado]);
            exit; // Asegura que no se envíe ninguna salida adicional
        } else {
            // Responde con un error si el método de solicitud no es POST
            echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
        }
    }

    // Método para eliminar un carnet (o desactivarlo)
    function Eliminar()
    {
        // Crea una instancia de la entidad Carnet
        $carnet = new Carnet();
        $carnet->setId_carnet($_POST["id_carnet"]);
        $carnet->setEstado($_POST["estado"]); // Estado = 0 para indicar que está desactivado
    
        // Crea una instancia del modelo CarnetM y llama al método para eliminar el carnet
        $carnetM = new CarnetM();
        $resultado = $carnetM->Eliminar($carnet);
        
        // Establece el encabezado de la respuesta como JSON y devuelve el resultado
        header('Content-Type: application/json');
        echo json_encode(['success' => $resultado]);
    }

    // Método para obtener los estados disponibles
    function IDEstado()
    {
        // Crea una instancia del modelo CarnetM
        $carnetM = new CarnetM();
        // Obtiene todos los estados del modelo
        $todos = $carnetM->IDEstado();

        // Verifica si se obtuvieron estados
        if ($todos === null) {
            $datos = [];
        } else {
            // Mapea los datos obtenidos a un formato específico
            $datos = array_map(function ($registro) {
                return [
                    'id_carnet' => $registro['id_carnet'],
                    'id_estado' => $registro['id_estado'],
                    'nombre_estado' => $registro['nombre_estado']
                ];
            }, $todos);
        }

        // Establece el encabezado de la respuesta como JSON y devuelve los datos
        header('Content-Type: application/json');
        echo json_encode($datos);
    }
}

// Parte que determina qué acción ejecutar basada en los parámetros de la URL (método GET)
if (isset($_GET['action'])) {
    // Crea una instancia del controlador CarnetController
    $controlador = new CarnetController();

    // Determina la acción a ejecutar basada en el valor del parámetro 'action'
    switch ($_GET['action']) {
        case 'Todos':
            $controlador->Todos();
            break; // Asegúrate de que todos los casos terminen con un break

        case 'Crear':
            $controlador->Crear();
            break;

        case 'IDEstado':
            $controlador->IDEstado();
            break;
    }
}

// Parte que determina qué acción ejecutar basada en los datos del formulario (método POST)
if (isset($_POST['action'])) {
    // Crea una instancia del controlador CarnetController
    $controlador = new CarnetController();

    // Determina la acción a ejecutar basada en el valor del parámetro 'action'
    switch ($_POST['action']) {
        case 'Eliminar':
            $controlador->Eliminar();
            break;
        // Agrega más casos si tienes otras acciones
    }
}
