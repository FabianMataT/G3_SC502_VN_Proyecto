<?php

class CarnetM
{

    function Todos()
    {
        $retVal = array();

        $conexion = new Conexion();
        $sql = "SELECT * FROM `fide_tab_carnet` WHERE `ESTADO` = 1;";

        $resultado = $conexion->AbrirBaseDatos($sql);

        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = $resultado->fetch_assoc()) {

                $carnet = new Carnet();
                $carnet->setId_carnet($fila["ID_CARNET"]);
                $carnet->setId_usuario($fila["ID_USUARIO"]);
                $carnet->setId_estado($fila["ID_ESTADO"]);
                $carnet->setNombre_animal($fila["NOMBRE_ANIMAL"]);
                $carnet->setRaza($fila["RAZA"]);
                $carnet->setAnio_rescate($fila["AÑO_RESCATE"]);
                $carnet->setDescripcion($fila["DESCRIPCION"]);
                $carnet->setEstado($fila["ESTADO"]);
                $carnet->setImagen($fila["IMAGEN"]);
                $retVal[] = $carnet;
            }
        } else {
            $retVal = null;
        }
        $conexion->CerrarBaseDatos();

        return $retVal;
    }

    function NuevoCarnet(Carnet $carnet)
    {
        $retVal = false;
        $conexion = new Conexion();
        $sql = "INSERT INTO `fide_tab_carnet`"
            . "(`ID_ESTADO`, "
            . "`NOMBRE_ANIMAL`, "
            . "`RAZA`, "
            . "`AÑO_RESCATE`, "
            . "`DESCRIPCION`, "
            . "`ESTADO`, "
            . "`IMAGEN`) "
            . "VALUES "
            . "('" . $carnet->getId_estado() . "',"
            . "'" . $carnet->getNombre_animal() . "',"
            . "'" . $carnet->getRaza() . "',"
            . "'" . $carnet->getAnio_rescate() . "',"
            . "'" . $carnet->getDescripcion() . "',"
            . "'" . $carnet->getEstado() . "',"
            . "'" . $carnet->getImagen() . "')";

        if ($conexion->AbrirBaseDatos($sql))
            $retVal = true;
        $conexion->CerrarBaseDatos();
        return $retVal;
    }



    function BuscarProducto($titulo)
    {

        $p = new Carnet();

        $conexion = new Conexion();

        $sql = "SELECT * FROM `fide_tab_carnet` WHERE `IMAGEN` = '" . $titulo . "';";

        $resultado = $conexion->AbrirBaseDatos($sql);

        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $p->setId_carnet($fila["ID_CARNET"]);
                $p->setId_estado($fila["ID_ESTADO"]);
                $p->setNombre_animal($fila["NOMBRE_ANIMAL"]);
                $p->setRaza($fila["RAZA"]);
                $p->setAnio_rescate($fila["AÑO_RESCATE"]);
                $p->setEstado($fila["ESTADO"]);
                $p->setImagen($fila["IMAGEN"]);
            }
        } else {
            $p = null;
        }
        $conexion->CerrarBaseDatos();

        return $p;
    }


    function Eliminar(Carnet $f)
    {
        $retVal = false;
        $conexion = new Conexion();

        // Construir la consulta SQL para actualizar el estado a 0
        $sql = "UPDATE `fide_tab_carnet` SET `ESTADO` = 0 WHERE `ID_CARNET` = " . $f->getId_carnet();

        if ($conexion->AbrirBaseDatos($sql)) {
            $retVal = true;
        }

        $conexion->CerrarBaseDatos();
        return $retVal;
    }


    function IDEstado()
    {
        $retVal = array();

        $conexion = new Conexion();
        $sql = "SELECT 
                    c.ID_CARNET,
                    c.ID_ESTADO,
                    e.ESTADO AS NOMBRE_ESTADO
                FROM 
                    fide_tab_carnet c
                INNER JOIN 
                    fide_tab_estado e ON c.ID_ESTADO = e.ID_ESTADO;";

        $resultado = $conexion->AbrirBaseDatos($sql);

        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $retVal[] = array(
                    'id_carnet' => $fila["ID_CARNET"],
                    'id_estado' => $fila["ID_ESTADO"],
                    'nombre_estado' => $fila["NOMBRE_ESTADO"]
                );
            }
        } else {
            $retVal = null;
        }

        $conexion->CerrarBaseDatos();

        return $retVal;
    }
}
