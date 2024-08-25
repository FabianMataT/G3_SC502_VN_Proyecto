<?php
class Conexion 
{
    private $mysqli;

    function AbrirBaseDatos($query)
    {
        // Datos de la conexión
        $servidor = 'localhost';
        $baseDatos = 'G3_SC502_VN_PPROYECTO';
        $usuario = 'FIND_MY_PET';
        $contrasena = '12345';

        $this->mysqli = new mysqli($servidor, $usuario, $contrasena, $baseDatos);

        // Verificar conexión
        if ($this->mysqli->connect_error) {
            die('Error en conexión: ' . $this->mysqli->connect_error);
        }
        
        $this->mysqli->autocommit(TRUE);
        $resultado = $this->mysqli->query($query);

        // Verificar errores en la consulta
        if (!$resultado) {
            die('Error en la consulta: ' . $this->mysqli->error);
        }

        return $resultado;
    }
    
    function CerrarBaseDatos()
    {
        $this->mysqli->close();
    }
}
?>
