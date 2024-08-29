<?php
    include_once "../../Model/conexionDB.php";


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
                $conexion->query("INSERT INTO FIDE_TAB_USUARIO (ID_ROL, NOMBRE_USUARIO, NOMBRE, APPELLIDO1, APPELLIDO2, TELEFONO, CORREO, CONTRASENA) 
                    VALUES ('$rol', '$username', '$nombre', '$apellido1', '$apellido2', '$telefono', '$correo', '$contrasena')");
                return null; 
            }
        }
    }

    function registrarUsuarioProfecional($tipoCuenta, $nombre, $apellido1, $apellido2, $telefono, $username, $correo, $contrasena, $codProvincia, $codCanton, $codDistrito, $otrasSenas, $empresa, $motivo_perfil, $comprobante_sinpe) 
    {
        $conexion = AbrirBaseDatos();
        $username_repetido = $conexion->query("SELECT * FROM FIDE_TAB_USUARIO WHERE NOMBRE_USUARIO='$username'");
        $correo_repetido = $conexion->query("SELECT * FROM FIDE_TAB_USUARIO WHERE CORREO='$correo'");
        
        if ($username_repetido && $username_repetido->num_rows > 0) {
            return "El nombre de usuario ya existe.";
        } elseif ($correo_repetido && $correo_repetido->num_rows > 0) {
            return "Existe una cuenta registrada con este correo. ¿Has olvidado tu contraseña?";
        } else {
            if ($tipoCuenta === "profecional") {
                $rol = 4;
                $conexion->query("INSERT INTO FIDE_TAB_USUARIO (ID_ROL, NOMBRE_USUARIO, NOMBRE, APPELLIDO1, APPELLIDO2, TELEFONO, CORREO, CONTRASENA) 
                    VALUES ('$rol', '$username', '$nombre', '$apellido1', '$apellido2', '$telefono', '$correo', '$contrasena')");
                $conexion->query("INSERT INTO FIDE_TAB_UBICACION (COD_PROVINCIA, COD_CANTON, COD_DISTRITO, OTRAS_SENAS) 
                        VALUES ('$codProvincia', '$codCanton', '$codDistrito', '$otrasSenas')");
                $id_u = $conexion->query("SELECT ID_USUARIO FROM FIDE_TAB_USUARIO ORDER BY ID_USUARIO DESC LIMIT 1");
                $id_ubi = $conexion->query("SELECT ID_UBICACION FROM FIDE_TAB_UBICACION ORDER BY ID_UBICACION DESC LIMIT 1");

                if ($id_u->num_rows > 0 && $id_ubi->num_rows > 0 ){
                    $fila = $id_u->fetch_assoc();
                    $id_u = $fila['ID_USUARIO']; 
                    $fila = $id_ubi->fetch_assoc();
                    $id_ubi = $fila['ID_UBICACION']; 
                    $conexion->query("INSERT INTO FIDE_TAB_PROFECIONAL (ID_USUARIO, ID_UBICACION, EMPRESA, MOTIVO_PERFIL, COMPROBANTE_SINPE) 
                        VALUES ('$id_u', '$id_ubi', '$empresa', '$motivo_perfil', '$comprobante_sinpe')");
                } else {
                    echo "No se encontró el ID del usuario.";
                }                 
            }
        }
    }

?>
