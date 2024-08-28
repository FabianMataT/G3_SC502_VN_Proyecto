<?php

include_once  __DIR__ . '/../Model/conexionDB.php';

class PerfilController
{
    public static function ObtenerUsuarioPorID($id_usuario)
    {
        $conexion = AbrirBaseDatos();
        $id_usuario = intval($id_usuario);

        $sql = "SELECT u.NOMBRE_USUARIO AS username, 
                       u.NOMBRE AS nombre, 
                       u.APPELLIDO1 AS apellido1, 
                       u.APPELLIDO2 AS apellido2, 
                       u.TELEFONO AS telefono,
                       u.CORREO AS correo,
                       r.NOMBRE_ROL AS rol
                FROM fide_tab_usuario u
                JOIN fide_tab_rol r ON u.ID_ROL = r.ID_ROL
                WHERE u.ID_USUARIO = $id_usuario";

        $resultado = mysqli_query($conexion, $sql);
        $usuario = mysqli_fetch_assoc($resultado);

        CerrarBaseDatos($conexion);

        return $usuario;
    }

    public static function ActualizarPerfil($id_usuario, $nombre, $apellido1, $apellido2, $telefono, $nombre_usuario, $correo)
    {
        $conexion = AbrirBaseDatos();
        $id_usuario = intval($id_usuario);

        $sql = "UPDATE fide_tab_usuario SET 
        NOMBRE = '$nombre',
        APPELLIDO1 = '$apellido1',
        APPELLIDO2 = '$apellido2',
        TELEFONO = '$telefono',
        NOMBRE_USUARIO = '$nombre_usuario',
        CORREO = '$correo'
    WHERE ID_USUARIO = $id_usuario";

        $resultado = mysqli_query($conexion, $sql);

        if (!$resultado) {
            $error = mysqli_error($conexion);
            CerrarBaseDatos($conexion);
            return ['success' => false, 'error' => $error];
        }

        CerrarBaseDatos($conexion);
        return ['success' => true];
    }

    public static function EliminarCuenta($id_usuario)
{
    $conexion = AbrirBaseDatos();
    $sql = "DELETE FROM fide_tab_usuario WHERE ID_USUARIO = $id_usuario";
    $resultado = mysqli_query($conexion, $sql);

    CerrarBaseDatos($conexion);

    if ($resultado) {
        header("Location: ../app/View/auth/login.php");
        exit();
    }

    return $resultado;
}

}

if (isset($_GET['action'])) {
    session_start();
    $action = $_GET['action'];

    if ($action === 'update') {
        header('Content-Type: application/json');

        if (!isset($_SESSION['id_usuario'])) {
            echo json_encode(['success' => false, 'error' => 'ID de usuario no encontrado en la sesión']);
            exit;
        }

        $id_usuario = intval($_SESSION['id_usuario']);

        $nombre = $_POST['nombre'] ?? '';
        $apellido1 = $_POST['apellido1'] ?? '';
        $apellido2 = $_POST['apellido2'] ?? '';
        $telefono = intval($_POST['telefono'] ?? 0);
        $username = $_POST['username'] ?? '';
        $correo = $_POST['correo'] ?? '';


        if (empty($nombre) || empty($apellido1) || empty($apellido2) || empty($telefono) || empty($username) || empty($correo)) {
            echo json_encode(['success' => false, 'error' => 'Todos los campos son obligatorios']);
            exit;
        }

        $resultado = PerfilController::ActualizarPerfil($id_usuario, $nombre, $apellido1, $apellido2, $telefono, $username, $correo);

        if ($resultado['success']) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $resultado['error'] ?? 'Error desconocido']);
        }
    }
}
