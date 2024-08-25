<?php

    function AbrirBaseDatos()
    {
        return mysqli_connect('localhost:3306', 'FIND_MY_PET', '12345', 'G3_SC502_VN_PPROYECTO');
    }

    function CerrarBaseDatos($conexion)
    {
        mysqli_close($conexion);
    }

?>