<?php
include_once 'conexionDB.php';

class carnetModel
{

    public static function crearCarnet($id_usuario, $nombre_animal, $raza, $fecha_rescate, $descripcion, $imagen, $id_estado = 2)
    {
        $conexion = AbrirBaseDatos();

        $sql = "INSERT INTO fide_tab_carnet (ID_USUARIO, NOMBRE_ANIMAL, RAZA, FECHA_RESCATE, DESCRIPCION, IMAGEN, ID_ESTADO) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("isssssi", $id_usuario, $nombre_animal, $raza, $fecha_rescate, $descripcion, $imagen, $id_estado);

        $resultado = $stmt->execute();
        $stmt->close();
        CerrarBaseDatos($conexion);

        return $resultado;
    }

    public static function obtenerCarnets()
    {
        $conexion = AbrirBaseDatos();
        $idUsuario = $_SESSION['id_usuario'];

        $sql = "SELECT * FROM fide_tab_carnet 
                ORDER BY CASE 
                    WHEN ID_USUARIO = '$idUsuario' THEN 0 
                    ELSE 1 
                END, FECHA_RESCATE DESC";

        $resultado = $conexion->query($sql);
        $carnets = array();

        while ($row = $resultado->fetch_assoc()) {
            $carnets[] = $row;
        }

        CerrarBaseDatos($conexion);
        return $carnets;
    }

    public static function eliminarCarnet($idCarnet)
    {
        $conexion = AbrirBaseDatos();
        $idCarnet = intval($idCarnet);

        $sql = "DELETE FROM fide_tab_carnet WHERE ID_CARNET = $idCarnet";

        $resultado = mysqli_query($conexion, $sql);

        CerrarBaseDatos($conexion);

        return $resultado;
    }

    public static function obtenerCarnetPorId($idCarnet)
    {
        $conexion = AbrirBaseDatos();
        $idCarnet = intval($idCarnet);

        $sql = "SELECT * FROM fide_tab_carnet WHERE ID_CARNET = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $idCarnet);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $carnet = $resultado->fetch_assoc();
        $stmt->close();
        CerrarBaseDatos($conexion);

        return $carnet;
    }

    public static function actualizarCarnet($idCarnet, $nombre_animal, $raza, $fecha_rescate, $descripcion, $imagen = null)
    {
        $conexion = AbrirBaseDatos();
        
        $sql = "UPDATE fide_tab_carnet SET NOMBRE_ANIMAL = ?, RAZA = ?, FECHA_RESCATE = ?, DESCRIPCION = ?" . 
               ($imagen ? ", IMAGEN = ?" : "") . " WHERE ID_CARNET = ?";
        
        $stmt = $conexion->prepare($sql);

        if ($imagen) {
            $stmt->bind_param("sssssi", $nombre_animal, $raza, $fecha_rescate, $descripcion, $imagen, $idCarnet);
        } else {
            $stmt->bind_param("ssssi", $nombre_animal, $raza, $fecha_rescate, $descripcion, $idCarnet);
        }

        $resultado = $stmt->execute();
        $stmt->close();
        CerrarBaseDatos($conexion);

        return $resultado;
    }

}
