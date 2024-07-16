<?php
    include_once "../Model/conexionDB.php";

if (!empty($_POST["btnIniciarSesion"])) {
    $correo=$_POST["correo"];
    $contrasena=$_POST["password"];
    $conexion = AbrirBaseDatos();
    $sql= $conexion->query("SELECT * FROM FIDE_TAB_USUARIO WHERE CORREO='$correo' AND CONTRASENA='$contrasena'");
    if($datos=$sql->fetch_object()){
        if ($datos->ID_ROL == 4) {
            CerrarBaseDatos($conexion);
            $_POST["msj"] = "La cuenta está en validación.";
        } else {
            CerrarBaseDatos($conexion);
            header("location: ../View/home.php");
        }
    } else {
        CerrarBaseDatos($conexion);
        $_POST["msj"] = "Correo o contraseña incorrectos.";
    }
}
?>
