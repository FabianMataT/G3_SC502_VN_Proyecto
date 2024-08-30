<?php
include_once 'conexionDB.php';

class productoModel
{
    public static function imprimirProductos()
    {
        $conexion = AbrirBaseDatos();
        $idUsuario = $_SESSION['id_usuario'];

        $sql = "SELECT P.ID_PRODUCTO, P.ID_USUARIO, P.TITULO_PUBLI, P.DESCRIPCION, P.IMAGEN, U.TELEFONO, PU.PROVINCIA, CU.CANTON, DU.DISTRITO, UB.OTRAS_SENAS
                    FROM fide_tab_productos P
                    JOIN fide_tab_usuario U ON P.ID_USUARIO = U.ID_USUARIO
                    JOIN fide_tab_profecional PO ON P.ID_USUARIO = PO.ID_USUARIO
                    JOIN fide_tab_ubicacion UB ON PO.ID_UBICACION= UB.ID_UBICACION
                    JOIN fide_tab_provincia PU ON UB.COD_PROVINCIA = PU.COD_PROVINCIA
                    JOIN fide_tab_canton CU ON UB.COD_CANTON = CU.COD_CANTON
                    JOIN fide_tab_distrito DU ON UB.COD_DISTRITO = DU.COD_DISTRITO
                ORDER BY CASE 
                    WHEN P.ID_USUARIO = '$idUsuario' THEN 0 
                    ELSE 1 
                END";
        $resultado = $conexion->query($sql);
        $productos = array();

        while ($row = $resultado->fetch_assoc()) {
            $productos[] = $row;
        }

        CerrarBaseDatos($conexion);
        return $productos;
    }

    public static function agregarProducto($id_usuario, $titulo_publi, $descripcion, $imagen)
    {
        $conexion = AbrirBaseDatos();

        $sql = "INSERT INTO fide_tab_productos (ID_USUARIO, TITULO_PUBLI, DESCRIPCION, IMAGEN) 
                VALUES (?, ?, ?, ?)";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("isss", $id_usuario, $titulo_publi, $descripcion, $imagen);

        $resultado = $stmt->execute();
        $stmt->close();
        CerrarBaseDatos($conexion);

        return $resultado;
    }

    public static function eliminarProducto($id_producto)
    {
        $conexion = AbrirBaseDatos();

        $sql = "DELETE FROM fide_tab_productos WHERE ID_PRODUCTO = ?";
        $stmt = $conexion->prepare($sql);

        $stmt->bind_param("i", $id_producto);
        $resultado = $stmt->execute();

        $stmt->close();
        CerrarBaseDatos($conexion);

        return $resultado;
    }


    public static function obtenerProducto($id_producto)
    {
        $conexion = AbrirBaseDatos();

        $sql = "SELECT ID_PRODUCTO, ID_USUARIO, TITULO_PUBLI, DESCRIPCION, IMAGEN FROM fide_tab_productos WHERE ID_PRODUCTO = ?";
        $stmt = $conexion->prepare($sql);

        $stmt->bind_param("i", $id_producto);
        $stmt->execute();

        $resultado = $stmt->get_result();
        $producto = $resultado->fetch_assoc();

        $stmt->close();
        CerrarBaseDatos($conexion);

        return $producto;
    }

    public static function editarProducto($id_producto, $titulo_publi, $descripcion, $imagen)
    {
        $conexion = AbrirBaseDatos();

        $sql = "UPDATE fide_tab_productos 
                SET TITULO_PUBLI = ?, DESCRIPCION = ?, IMAGEN = ?
                WHERE ID_PRODUCTO = ?";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssi", $titulo_publi, $descripcion, $imagen, $id_producto);
        $resultado = $stmt->execute();

        $stmt->close();
        CerrarBaseDatos($conexion);

        return $resultado;
    }
}
