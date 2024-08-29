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
}
