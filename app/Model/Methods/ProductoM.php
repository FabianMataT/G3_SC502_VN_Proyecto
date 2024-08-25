<?php

class ProductoM
{

    function Todos()
    {
        $retVal = array();

        $conexion = new Conexion();
        $sql = "SELECT * FROM `fide_tab_productos` WHERE `ESTADO` = 1;";

        $resultado = $conexion->AbrirBaseDatos($sql);

        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = $resultado->fetch_assoc()) {

                $e = new Producto();
                $e->setId_producto($fila["ID_PRODUCTO"]);
                $e->setId_usuario($fila["ID_USUARIO"]);
                $e->setId_ubicacion($fila["ID_UBICACION"]);
                $e->setTitulo_publi($fila["TITULO_PUBLI"]);
                $e->setDescripcion($fila["DESCRIPCION"]);
                $e->setImagen($fila["IMAGEN"]);
                $e->setEstado($fila["ESTADO"]);
                $retVal[] = $e;
            }
        } else {
            $retVal = null;
        }
        $conexion->CerrarBaseDatos();

        return $retVal;
    }

    function NuevoProducto(Producto $producto)
    {
        $retVal = false;
        $conexion = new Conexion();
        $sql = "INSERT INTO `fide_tab_productos`"
            . "(`ID_UBICACION`, "
            . "`TITULO_PUBLI`, "
            . "`DESCRIPCION`, "
            . "`IMAGEN`, "
            . "`ESTADO`) "
            . "VALUES "
            . "('" . $producto->getId_ubicacion() . "',"
            . "'" . $producto->getTitulo_publi() . "',"
            . "'" . $producto->getDescripcion() . "',"
            . "'" . $producto->getImagen() . "',"
            . "'" . $producto->getEstado() . "')";

        if ($conexion->AbrirBaseDatos($sql))
            $retVal = true;
        $conexion->CerrarBaseDatos();
        return $retVal;
    }


    function BuscarProducto($titulo)
    {

        $p = new Producto();

        $conexion = new Conexion();

        $sql = "SELECT * FROM `fide_tab_productos` WHERE `TITULO_PUBLI` = '" . $titulo . "';";

        $resultado = $conexion->AbrirBaseDatos($sql);

        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $p->setId_producto($fila["ID_PRODUCTO"]);
                $p->setId_usuario($fila["ID_USUARIO"]);
                $p->setId_ubicacion($fila["ID_UBICACION"]);
                $p->setTitulo_publi($fila["TITULO_PUBLI"]);
                $p->setDescripcion($fila["DESCRIPCION"]);
                $p->setImagen($fila["IMAGEN"]);
                $p->setEstado($fila["ESTADO"]);
            }
        } else {
            $p = null;
        }
        $conexion->CerrarBaseDatos();

        return $p;
    }

    function Desactivar(Producto $f)
    {
        $retVal = false;
        $conexion = new Conexion();
        $sql = "UPDATE `fide_tab_productos` SET "
            . "`ESTADO` = '" . $f->getEstado() . ""
            . "' WHERE `ID_PRODUCTO` = " . $f->getId_producto();
        if ($conexion->AbrirBaseDatos($sql))
            $retVal = true;
        $conexion->CerrarBaseDatos();
        return $retVal;
    }

    function Ubicacion()
    {
        $retVal = array();

        $conexion = new Conexion();
        $sql = "SELECT 
                u.ID_UBICACION,
                p.DESCRIPCION AS PROVINCIA,
                c.DESCRIPCION AS CANTON,
                d.DESCRIPCION AS DISTRITO,
                u.OTRAS_SENAS
            FROM 
                fide_tab_ubicacion u
            INNER JOIN 
                fide_tab_provincia p ON u.COD_PROVINCIA = p.COD_PROVINCIA
            INNER JOIN 
                fide_tab_canton c ON u.COD_CANTON = c.COD_CANTON AND u.COD_PROVINCIA = c.COD_PROVINCIA
            INNER JOIN 
                fide_tab_distrito d ON u.COD_DISTRITO = d.COD_DISTRITO AND u.COD_CANTON = d.COD_CANTON AND u.COD_PROVINCIA = d.COD_PROVINCIA;";

        $resultado = $conexion->AbrirBaseDatos($sql);

        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $retVal[] = array(
                    'id_ubicacion' => $fila["ID_UBICACION"],
                    'provincia' => $fila["PROVINCIA"],
                    'canton' => $fila["CANTON"],
                    'distrito' => $fila["DISTRITO"],
                    'otras_senas' => $fila["OTRAS_SENAS"]
                );
            }
        } else {
            $retVal = null;
        }

        $conexion->CerrarBaseDatos();

        return $retVal;
    }

    function ActualizarProducto($producto)
    {
        $conexion = new Conexion();
        $sql = "UPDATE fide_tab_productos SET 
            TITULO_PUBLI = '" . $producto['titulo_publi'] . "',
            DESCRIPCION = '" . $producto['descripcion'] . "',
            ID_UBICACION = '" . $producto['id_ubicacion'] . "',
            IMAGEN = '" . $producto['imagen'] . "'
            WHERE ID_PRODUCTO = '" . $producto['id_producto'] . "'";

        $resultado = $conexion->AbrirBaseDatos($sql);

        $conexion->CerrarBaseDatos();

        return $resultado;
    }

    function ObtenerProductoPorId($id_producto)
    {
        $conexion = new Conexion();
        $sql = "SELECT * FROM fide_tab_productos WHERE ID_PRODUCTO = '$id_producto' LIMIT 1";
        $resultado = $conexion->AbrirBaseDatos($sql);

        if ($resultado->num_rows > 0) {
            $producto = $resultado->fetch_assoc();
        } else {
            $producto = null;
        }

        $conexion->CerrarBaseDatos();

        return $producto;
    }



}
