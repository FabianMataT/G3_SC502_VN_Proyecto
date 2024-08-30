<?php
include_once "conexionDB.php";

class usuarioModel
{
    public static function iniciarSesion($correo, $contrasena)
    {
        $conexion = AbrirBaseDatos();
        $sql = $conexion->query("SELECT * FROM FIDE_TAB_USUARIO WHERE CORREO='$correo' AND CONTRASENA='$contrasena'");

        if ($sql->num_rows > 0) {
            return $sql->fetch_object();
        } else {
            return false;
        }
    }

    public static function validarCorreo($correo)
    {
        $conexion = AbrirBaseDatos();
        $stmt = $conexion->prepare("SELECT * FROM FIDE_TAB_USUARIO WHERE CORREO = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();

        $correo_existe = $stmt->num_rows > 0;

        $stmt->close();
        CerrarBaseDatos($conexion);

        return $correo_existe;
    }


    public static function registrarUsuario($nombre, $apellido1, $apellido2, $telefono, $username, $correo, $contrasena)
    {
        $conexion = AbrirBaseDatos();
        $sql = "INSERT INTO FIDE_TAB_USUARIO (ID_ROL, NOMBRE_USUARIO, NOMBRE, APELLIDO1, APELLIDO2, TELEFONO, CORREO, CONTRASENA) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $rol = 2;

        $contrasenaHasheada = password_hash($contrasena, PASSWORD_BCRYPT);

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("isssssss", $rol, $username, $nombre, $apellido1, $apellido2, $telefono, $correo, $contrasenaHasheada);

        $resultado = $stmt->execute();
        $stmt->close();
        CerrarBaseDatos($conexion);
        return $resultado;
    }



    public static function registrarUsuarioProfecional($nombre, $apellido1, $apellido2, $telefono, $username, $correo, $contrasena, $codProvincia, $codCanton, $codDistrito, $otrasSenas, $empresa, $motivo_perfil, $comprobante_sinpe)
    {
        $conexion = AbrirBaseDatos();
        $rol = 4;

        $contrasenaHasheada = password_hash($contrasena, PASSWORD_BCRYPT);

        $insercion_usuario = $conexion->query("INSERT INTO FIDE_TAB_USUARIO (ID_ROL, NOMBRE_USUARIO, NOMBRE, APELLIDO1, APELLIDO2, TELEFONO, CORREO, CONTRASENA) 
                    VALUES ('$rol', '$username', '$nombre', '$apellido1', '$apellido2', '$telefono', '$correo', '$contrasenaHasheada')");
        if ($insercion_usuario) {
            $id_u = $conexion->insert_id;
            $insercion_ubicacion = $conexion->query("INSERT INTO FIDE_TAB_UBICACION (COD_PROVINCIA, COD_CANTON, COD_DISTRITO, OTRAS_SENAS) 
                            VALUES ('$codProvincia', '$codCanton', '$codDistrito', '$otrasSenas')");
            if ($insercion_ubicacion) {
                $id_ubi = $conexion->insert_id;
                $insercion_profesional = $conexion->query("INSERT INTO FIDE_TAB_PROFECIONAL (ID_USUARIO, ID_UBICACION, EMPRESA, MOTIVO_PERFIL, COMPROBANTE_SINPE) 
                            VALUES ('$id_u', '$id_ubi', '$empresa', '$motivo_perfil', '$comprobante_sinpe')");
                if ($insercion_profesional) {
                    return ['success' => true, 'message' => 'Usuario profesional registrado exitosamente.'];
                } else {
                    return ['success' => false, 'message' => 'Error al registrar el perfil profesional.'];
                }
            } else {
                return ['success' => false, 'message' => 'Error al registrar la ubicación.'];
            }
        } else {
            return ['success' => false, 'message' => 'Error al registrar el usuario.'];
        }
    }
}
