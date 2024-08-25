<?php
    include_once "../../Model/usuarioModel.php";
    include_once "../../Model/ubicacionModel.php";

    if (!empty($_POST["btnRegistrarse"])) 
    {
        $tipoCuenta = $_POST["tipoCuenta"];
        $nombre = $_POST["nombre"];
        $apellido1 = $_POST["apellido1"];
        $apellido2 = $_POST["apellido2"];
        $telefono = $_POST["telefono"];
        $username = $_POST["nombreUsuario"];
        $correo = $_POST["correo"];
        $contrasena = $_POST["password"];
        
        $mensaje = registrarUsuario($tipoCuenta, $nombre, $apellido1, $apellido2, $telefono, $username, $correo, $contrasena);
        
        if ($mensaje) {
            $_POST["msj"] = $mensaje;
        } else {
            header("location: ../auth/login.php");
            exit();
        }
    }

    function Dropdown_Menu_Provincias()
    {
        $provincias = getProvincias();
        $htmlOpciones = '';
    
        if (!empty($provincias)) {
            foreach ($provincias as $provincias) {
                $htmlOpciones .= '<option value="' . htmlspecialchars($provincias['COD_PROVINCIA']) . '">' . htmlspecialchars($provincias['DESCRIPCION']) . '</option>';
            }
        } else {
            $htmlOpciones = '<option value="">No se encontraron provincias</option>';
        }
    
        return $htmlOpciones;
    }

    function Dropdown_Menu_Cantones($COD_PROVINCIA)
    {
        $cantones = getCantones($COD_PROVINCIA);
        $htmlOpciones = '';
    
        if (!empty($cantones)) {
            foreach ($cantones as $cantones) {
                $htmlOpciones .= '<option value="' . htmlspecialchars($cantones['COD_CANTON']) . '">' . htmlspecialchars($cantones['DESCRIPCION']) . '</option>';
            }
        } else {
            $htmlOpciones = '<option value="">Tienes que seleccionar una provincia</option>';
        }
    
        return $htmlOpciones;
    }

    function Dropdown_Menu_Distritos($COD_PROVINCIA, $COD_CANTON)
    {
        $distritos = getDistritos($COD_PROVINCIA, $COD_CANTON);
        $htmlOpciones = '';
    
        if (!empty($distritos)) {
            foreach ($distritos as $distritos) {
                $htmlOpciones .= '<option value="' . htmlspecialchars($distritos['COD_DISTRITO']) . '">' . htmlspecialchars($distritos['DESCRIPCION']) . '</option>';
            }
        } else {
            $htmlOpciones = '<option value="">Tienes que seleccionar un canton</option>';
        }
    
        return $htmlOpciones;
    }

?>
