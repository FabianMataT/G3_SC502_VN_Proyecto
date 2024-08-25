<?php 
    include_once "../../Model/conexionDB.php";

    function getProvincias() {
        $conexion = AbrirBaseDatos();
        $sql = $conexion->query("SELECT * FROM fide_tab_provincia");

        $provincias = array();

        while ($row = $sql->fetch_assoc()) {
            $provincias[] = $row;
        }
        CerrarBaseDatos($conexion);
        return $provincias;
    }

    function getCantones($COD_PROVINCIA) {
        $conexion = AbrirBaseDatos();
        $sql = $conexion->query("SELECT * FROM fide_tab_canton WHERE COD_PROVINCIA='$COD_PROVINCIA'");

        $cantones = array();

        while ($row = $sql->fetch_assoc()) {
            $cantones[] = $row;
        }
        CerrarBaseDatos($conexion);
        return $cantones;
    }

    function getDistritos($COD_PROVINCIA, $COD_CANTON) {
        $conexion = AbrirBaseDatos();
        $sql = $conexion->query("SELECT * FROM fide_tab_canton WHERE COD_PROVINCIA='$COD_PROVINCIA' AND COD_CANTON='$COD_CANTON'");

        $distritos = array();

        while ($row = $sql->fetch_assoc()) {
            $distritos[] = $row;
        }
        CerrarBaseDatos($distritos);
        return $distritos;
    }
     
?>