<?php
    include_once "../Model/conexionDB.php";

if (!empty($_POST["btnIniciarSesion"])) {
    $correo=$_POST["correo"];
    $contrasena=$_POST["password"];
    $sql= AbrirBaseDatos()->query("select * from FIDE_TAB_USUARIO where CORREO='$correo' and CONTRASENA='$contrasena'");
    if($datos=$sql->fetch_object()){
        header("location: ../View/home.php");
    } else {
        $_POST["msj"] = "Correo o contraseña incorrectos.";
    }
}
?>
