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
        $sql = "SELECT * FROM fide_tab_carnet";
        $resultado = $conexion->query($sql);

        $carnets = [];
        if ($resultado) {
            while ($fila = $resultado->fetch_assoc()) {
                $carnets[] = $fila;
            }
        }

        CerrarBaseDatos($conexion);
        return $carnets;
    }
}
