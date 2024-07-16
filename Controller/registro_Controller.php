<?php
    include_once "../Model/conexionDB.php";

if (!empty($_POST["btnRegistrarse"])) {
    $tipoCuenta=$_POST["tipoCuenta"];
    $nombre=$_POST["nombre"];
    $apellido1=$_POST["apellido1"];
    $apellido2=$_POST["apellido2"];
    $telefono=$_POST["telefono"];
    $username=$_POST["nombreUsuario"];
    $correo=$_POST["correo"];
    $contrasena=$_POST["password"];
    $conexion = AbrirBaseDatos();
    $username_repetido= $conexion->query("SELECT * FROM FIDE_TAB_USUARIO WHERE NOMBRE_USUARIO='$username'");
    $correo_repetido= $conexion->query("SELECT * FROM FIDE_TAB_USUARIO WHERE CORREO='$correo'");
    if($username_repetido && $username_repetido->num_rows > 0){
        CerrarBaseDatos($conexion);
        $_POST["msj"] = "El nombre de usuario ya existe.";
    }elseif($correo_repetido && $correo_repetido->num_rows > 0){
        CerrarBaseDatos($conexion);
        $_POST["msj"] = "Existe una cuenta registrada con este correo. ¿Has olvidado tu contraseña?";
    }else {
        if($tipoCuenta === "usuario"){
            $rol=2;
            $insertar_usurio=AbrirBaseDatos()->query("INSERT INTO FIDE_TAB_USUARIO (ID_ROL, NOMBRE_USUARIO, NOMBRE, APPELIDO1, APPELIDO2, TELEFONO, CORREO, CONTRASENA) 
            VALUES ('$rol', '$username', '$nombre', '$apellido1', '$apellido2', '$telefono', '$correo', '$contrasena')");
            CerrarBaseDatos($conexion);
            header("location: ../View/login.php");
        }
    }
}
?>
