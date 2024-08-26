<?php


class AdminM
{
    function ObtenerUsuarios()
{
    $conexion = AbrirBaseDatos();
    $sql = "SELECT NOMBRE_USUARIO AS username, 
                   CONCAT(NOMBRE, ' ', APPELIDO1, ' ', APPELIDO2) AS nombre_completo, 
                   TELEFONO AS telefono, 
                   CORREO AS email, 
                   ID_ROL AS rol 
            FROM fide_tab_usuario";
    $resultado = mysqli_query($conexion, $sql);

    $usuarios = [];
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $usuarios[] = $fila;
        }
    }

    CerrarBaseDatos($conexion);
    return $usuarios;
}

}
