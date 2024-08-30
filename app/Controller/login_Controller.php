<?php
include_once  __DIR__ . '/../Model/conexionDB.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["id_rol"])) {
    $_SESSION["id_rol"] = 0;
}

if (!isset($_SESSION["username"])) {
    $_SESSION["username"] = '';
}

if (!empty($_POST["btnIniciarSesion"])) {
    $correo = $_POST["correo"];
    $contrasena = $_POST["password"];
    $conexion = AbrirBaseDatos();
    $sql = $conexion->query("SELECT * FROM FIDE_TAB_USUARIO WHERE CORREO='$correo'");

    if ($datos = $sql->fetch_object()) {
        if ($datos->ESTADO == 0) {
            CerrarBaseDatos($conexion);
            $_SESSION['error_mensaje'] = "ERROR: ESTE USUARIO FUE BLOQUEADO. CONTACTE CON UN ADMINISTRADOR PARA SU DESBLOQUEO.";
        } elseif ($datos->ID_ROL == 4) {
            CerrarBaseDatos($conexion);
            $_POST["msj"] = "La cuenta está en validación.";
        } else {
            if (password_verify($contrasena, $datos->CONTRASENA)) {
                $_SESSION['id_usuario'] = $datos->ID_USUARIO;
                $_SESSION['id_rol'] = $datos->ID_ROL;
                $_SESSION['nombre'] = $datos->NOMBRE;
                $_SESSION['apellido1'] = $datos->APELLIDO1;
                $_SESSION['apellido2'] = $datos->APELLIDO2;
                $_SESSION['telefono'] = $datos->TELEFONO;
                $_SESSION['username'] = $datos->NOMBRE_USUARIO;
                $_SESSION['correo'] = $datos->CORREO;
                CerrarBaseDatos($conexion);
                header("location: ../home/home.php");
                exit;
            } else {
                CerrarBaseDatos($conexion);
                $_POST["msj"] = "Correo o contraseña incorrectos.";
            }
        }
    } else {
        CerrarBaseDatos($conexion);
        $_POST["msj"] = "Correo o contraseña incorrectos.";
    }
}

