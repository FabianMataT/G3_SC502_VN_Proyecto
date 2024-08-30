<?php
    include_once __DIR__ . '/../Model/ubicacionModel.php';
    include_once __DIR__ . '/../Model/usuarioModel.php';
    

    
    function EnviarCorreo($asunto,$contenido,$destinatario)
    {
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';

        $correoSalida = "clasesphp@outlook.com";
        $contrasennaSalida = "phpclases2024*";

        $mail = new PHPMailer();
        $mail -> CharSet = 'UTF-8';

        $mail -> IsSMTP();
        $mail -> IsHTML(true); 
        $mail -> Host = 'smtp.office365.com';
        $mail -> SMTPSecure = 'tls';
        $mail -> Port = 587;                      
        $mail -> SMTPAuth = true;
        $mail -> Username = $correoSalida;               
        $mail -> Password = $contrasennaSalida;                                
        
        $mail -> SetFrom($correoSalida);
        $mail -> Subject = $asunto;
        $mail -> MsgHTML($contenido);   
        $mail -> AddAddress($destinatario);

        $mail -> send();
    }

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
            $datos = "fabianmatat.1@gmail.com";
            $contenido = "<html><body>
                Estimado(a) Administrador <br/><br/>
                Un usuario a registrado un nuevo usuario: <b></b><br/>
                Por favor ingrese a nuestro sistema para validar al usuario<br/><br/>
                Muchas gracias.
                </body></html>";

                EnviarCorreo('Acceso al Sistema', $contenido, $datos);
            header("location: ../auth/login.php");
            exit();
        }
    }
/*
    if (!empty($_POST["btnRegistrarProfecional"])) {
        $tipoCuenta = $_POST["tipoCuenta_profecional"];
        $nombre = $_POST["nombre"];
        $apellido1 = $_POST["apellido1"];
        $apellido2 = $_POST["apellido2"];
        $telefono = $_POST["telefono"];
        $username = $_POST["nombreUsuario"];
        $correo = $_POST["correo"];
        $contrasena = $_POST["password"];
        $codProvincia = $_POST["cod_provincia"];
        $codCanton = $_POST["cod_canton"];
        $codDistrito = $_POST["cod_distrito"];
        $otrasSenas = $_POST["otrassenas"];
        $empresa = $_POST["empresa"];
        $motivo_perfil = $_POST["motivo"];
        $comprobante_sinpe = null;
        $mensaje = registrarUsuarioProfecional($tipoCuenta, $nombre, $apellido1, $apellido2, $telefono, $username, $correo, $contrasena, $codProvincia, $codCanton, $codDistrito, $otrasSenas, $empresa, $motivo_perfil, $comprobante_sinpe);
        if ($mensaje) {
            $_POST["msj"] = $mensaje;
        } else {
            header("location: ../auth/login.php");
            exit();
        }
    }
    */
    function Dropdown_Menu_Provincias()
    {
        $provincias = getProvincias();
        $htmlOpciones = '';
    
        if (!empty($provincias)) {
            foreach ($provincias as $provincias) {
                $htmlOpciones .= '<option value="' . htmlspecialchars($provincias['COD_PROVINCIA']) . '">' . htmlspecialchars($provincias['PROVINCIA']) . '</option>';
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
                $htmlOpciones .= '<option value="' . htmlspecialchars($cantones['COD_CANTON']) . '">' . htmlspecialchars($cantones['CANTON']) . '</option>';
            }
        } else {
            $htmlOpciones = '<option value="">Tienes que seleccionar una provincia</option>';
        }
    
        return $htmlOpciones;
    }

    function Dropdown_Menu_Distritos($COD_CANTON)
    {
        $distritos = getDistritos($COD_CANTON);
        $htmlOpciones = '';
    
        if (!empty($distritos)) {
            foreach ($distritos as $distritos) {
                $htmlOpciones .= '<option value="' . htmlspecialchars($distritos['COD_DISTRITO']) . '">' . htmlspecialchars($distritos['DISTRITO']) . '</option>';
            }
        } else {
            $htmlOpciones = '<option value="">Tienes que seleccionar un canton</option>';
        }
    
        return $htmlOpciones;
    }


    function registrar_profecional() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tipoCuenta = $_POST["tipoCuenta_profecional"];
            $nombre = $_POST["nombre"];
            $apellido1 = $_POST["apellido1"];
            $apellido2 = $_POST["apellido2"];
            $telefono = $_POST["telefono"];
            $username = $_POST["nombreUsuario"];
            $correo = $_POST["correo"];
            $contrasena = $_POST["password"];
            $codProvincia = $_POST["cod_provincia"];
            $codCanton = $_POST["cod_canton"];
            $codDistrito = $_POST["cod_distrito"];
            $otrasSenas = $_POST["otrassenas"];
            $empresa = $_POST["empresa"];
            $motivo_perfil = $_POST["motivo"];
            $comprobante_sinpe = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                $temp_name = $_FILES['image']['tmp_name']; 
                $file_name = basename($_FILES['image']['name']); 
                $upload_dir = '../View/subirImg/';
                $target_file = $upload_dir . $file_name;

                $file_type = mime_content_type($temp_name);
                $allowed_types = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                if (!in_array($file_type, $allowed_types)) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Tipo de archivo no permitido.']);
                    exit;
                }
                if (move_uploaded_file($temp_name, $target_file)) {
                    $comprobante_sinpe = $target_file;
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Error al subir la imagen.']);
                    exit;
                }
            }
            $resultado = registrarUsuarioProfecional($tipoCuenta, $nombre, $apellido1, $apellido2, $telefono, $username, $correo, $contrasena, $codProvincia, $codCanton, $codDistrito, $otrasSenas, $empresa, $motivo_perfil, $comprobante_sinpe);
            header('Content-Type: application/json');
            echo json_encode($resultado);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
            exit; 
        }
    }



    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'cargarCanton') {
                $codigoProvincia = $_POST['codigoProvincia'];
                $resultados = Dropdown_Menu_Cantones($codigoProvincia);
                echo ($resultados);
                exit;
            } elseif ($_POST['action'] === 'cargarDistrito') {
                $codigoCanton = $_POST['codigoCanton'];
                $resultados = Dropdown_Menu_Distritos($codigoCanton);
    
                echo ($resultados);
            }
        }
        
    }

    
?>
