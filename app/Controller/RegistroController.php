<?php
include_once __DIR__ . '/../Model/ubicacionModel.php';
include_once __DIR__ . '/../Model/usuarioModel.php';

class registroController
{

    public static function EnviarCorreo($asunto, $contenido, $destinatario)
    {
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';

        $correoSalida = "clasesphp@outlook.com";
        $contrasennaSalida = "phpclases2024*";

        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';

        $mail->IsSMTP();
        $mail->IsHTML(true);
        $mail->Host = 'smtp.office365.com';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = $correoSalida;
        $mail->Password = $contrasennaSalida;

        $mail->SetFrom($correoSalida);
        $mail->Subject = $asunto;
        $mail->MsgHTML($contenido);
        $mail->AddAddress($destinatario);

        $mail->send();
    }


    public static function Dropdown_Menu_Provincias()
    {
        $provincias = ubicacionModel::getProvincias();
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

    public static function Dropdown_Menu_Cantones($COD_PROVINCIA)
    {
        $cantones = ubicacionModel::getCantones($COD_PROVINCIA);
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

    public static function Dropdown_Menu_Distritos($COD_CANTON)
    {
        $distritos = ubicacionModel::getDistritos($COD_CANTON);
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


    public static function registrarUsuario()
    {
        $nombre = $_POST["nombre"];
        $apellido1 = $_POST["apellido1"];
        $apellido2 = $_POST["apellido2"];
        $telefono = $_POST["telefono"];
        $username = $_POST["nombreUsuario"];
        $correo = $_POST["correo"];
        $contrasena = $_POST["password"];
        $resultado = usuarioModel::validarCorreo($correo);

        if ($resultado) {
            echo json_encode(['success' => false, 'message' => 'Error: El correo ya se encuentra registrado en la aplicación']);
        } else {
            $registrar = usuarioModel::registrarUsuario($nombre, $apellido1, $apellido2, $telefono, $username, $correo, $contrasena);
            if ($registrar) {
                echo json_encode(['success' => true, 'message' => 'Cuenta registrada correctamente.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al registrar la cuenta.']);
            }
        }
    }


    public static function registrarProfecional()
    {
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

        $imagen = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $temp_name = $_FILES['image']['tmp_name'];
            $file_name = basename($_FILES['image']['name']);
            $upload_dir = '../View/subirImg/';
            $target_file = $upload_dir . $file_name;

            $file_type = mime_content_type($temp_name);
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($file_type, $allowed_types)) {
                echo json_encode(['success' => false, 'message' => 'Tipo de archivo no permitido.']);
                return;
            }

            if (move_uploaded_file($temp_name, $target_file)) {
                $imagen = $file_name;
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al subir la imagen.']);
                return;
            }
        }

        $resultado = usuarioModel::validarCorreo($correo);

        if ($resultado) {
            echo json_encode(['success' => false, 'message' => 'Error: El correo ya se encuentra registrado en la aplicación']);
        } else {
            $registrar = usuarioModel::registrarUsuarioProfecional($nombre, $apellido1, $apellido2, $telefono, $username, $correo, $contrasena, $codProvincia, $codCanton, $codDistrito, $otrasSenas, $empresa, $motivo_perfil, $imagen);
            if ($registrar) {
                echo json_encode(['success' => true, 'message' => 'Cuenta registrada correctamente, tu cuenta se encuentra en validacion. El administrador a sido notificado sobre tu solicitud, proto sera procesada.']);
                $contenido = "<html><body>
                Estimado(a) Administrador <br/><br/>
                Se  a registrado una empresa que quiere tener el perfil profecional llamdaa: <b>" . $empresa . "</b><br/>
                Por favor, revisa el modulo de usuarios para que valores la cuenta.<br/><br/>
                Muchas gracias.
                </body></html>";
                $destinatario = "find.my.pet24h@gmail.com";
                registroController::EnviarCorreo('Acceso al Sistema', $contenido, $destinatario);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al registrar la cuenta.']);
            }
        }
    }

}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'cargarCanton') {
            $codigoProvincia = $_POST['codigoProvincia'];
            $resultados = registroController::Dropdown_Menu_Cantones($codigoProvincia);
            echo ($resultados);
            exit;
        } elseif ($_POST['action'] === 'cargarDistrito') {
            $codigoCanton = $_POST['codigoCanton'];
            $resultados = registroController::Dropdown_Menu_Distritos($codigoCanton);

            echo ($resultados);
        }
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'RegistrarUsuarioNormal') {
    registroController::registrarUsuario();
}

if (isset($_GET['action']) && $_GET['action'] === 'RegistrarUsuarioProfecional') {
    registroController::registrarProfecional();
}
