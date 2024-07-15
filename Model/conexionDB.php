<?php

    function AbrirBaseDatos()
    {
        return mysqli_connect('127.0.0.1:3309', 'root', '', 'G3_SC502_VN_PPROYECTO');
    }

    function CerrarBaseDatos($conexion)
    {
        mysqli_close($conexion);
    }

?>