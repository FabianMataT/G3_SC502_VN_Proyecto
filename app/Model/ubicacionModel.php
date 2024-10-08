<?php 
    include_once "conexionDB.php";

    class ubicacionModel
    {
        public static function getProvincias() {
            $conexion = AbrirBaseDatos();
            $sql = $conexion->query("SELECT * FROM fide_tab_provincia");

            $provincias = array();

            while ($row = $sql->fetch_assoc()) {
                $provincias[] = $row;
            }
            CerrarBaseDatos($conexion);
            return $provincias;
        }

        public static function getCantones($COD_PROVINCIA) {
            $conexion = AbrirBaseDatos();
            $sql = $conexion->query("SELECT * FROM fide_tab_canton WHERE COD_PROVINCIA='$COD_PROVINCIA'");

            $cantones = array();

            while ($row = $sql->fetch_assoc()) {
                $cantones[] = $row;
            }
            CerrarBaseDatos($conexion);
            return $cantones;
        }

        public static function getDistritos($COD_CANTON) {
            $conexion = AbrirBaseDatos();
            $sql = $conexion->query("SELECT * FROM fide_tab_distrito WHERE COD_CANTON='$COD_CANTON'");

            $distritos = array();

            while ($row = $sql->fetch_assoc()) {
                $distritos[] = $row;
            }
            CerrarBaseDatos($conexion);
            return $distritos;
        }
    }
?>