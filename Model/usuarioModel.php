<?php
    include_once "../Model/conexionDB.php";


    function iniciarSesion($correo, $contrasena) 
    {
        $conexion = AbrirBaseDatos();
        $sql = $conexion->query("SELECT * FROM FIDE_TAB_USUARIO WHERE CORREO='$correo' AND CONTRASENA='$contrasena'");
        
        if ($sql->num_rows > 0) {
            return $sql->fetch_object();
        } else {
            return false;
        }
    }

    function registrarUsuario($tipoCuenta, $nombre, $apellido1, $apellido2, $telefono, $username, $correo, $contrasena) 
    {
        $conexion = AbrirBaseDatos();
        $username_repetido = $conexion->query("SELECT * FROM FIDE_TAB_USUARIO WHERE NOMBRE_USUARIO='$username'");
        $correo_repetido = $conexion->query("SELECT * FROM FIDE_TAB_USUARIO WHERE CORREO='$correo'");
        
        if ($username_repetido && $username_repetido->num_rows > 0) {
            return "El nombre de usuario ya existe.";
        } elseif ($correo_repetido && $correo_repetido->num_rows > 0) {
            return "Existe una cuenta registrada con este correo. ¿Has olvidado tu contraseña?";
        } else {
            if ($tipoCuenta === "usuario") {
                $rol = 2;
                $conexion->query("INSERT INTO FIDE_TAB_USUARIO (ID_ROL, NOMBRE_USUARIO, NOMBRE, APPELIDO1, APPELIDO2, TELEFONO, CORREO, CONTRASENA) 
                    VALUES ('$rol', '$username', '$nombre', '$apellido1', '$apellido2', '$telefono', '$correo', '$contrasena')");
                return null; 
            }
        }
    }

?>
