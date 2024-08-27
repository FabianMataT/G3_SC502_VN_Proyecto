<?php
include_once '../layout.php';
include_once '../../Controller/adminController.php';


$id_usuario = $_SESSION['id_usuario'];

$usuario = adminController::ObtenerUsuarioPorIDDonacion($id_usuario);

if (!$usuario) {
    echo "Usuario no encontrado.";
    exit;
}

// Obtener los datos necesarios desde el array $usuario
$nombre_completo = isset($usuario['nombre_completo']) ? $usuario['nombre_completo'] : '';
$telefono = isset($usuario['TELEFONO']) ? $usuario['TELEFONO'] : '';
$email = isset($usuario['CORREO']) ? $usuario['CORREO'] : '';
?>

<!DOCTYPE html>
<html>
<?php head(); ?>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php MostrarNav(); ?>
        <?php MostrarMenu(); ?>

        <div class="content-wrapper">
            <section class="content">
                <div class="titulo-generico">
                    <p>Apoya a FindMyPet!</p>
                </div>

                <form action="procesarDonacion.php" method="post" enctype="multipart/form-data" class="form-donacion">
                    <div class="form-group">
                        <label for="nombre">Nombre Completo:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre_completo; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Número de teléfono:</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $telefono; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="archivo">Elige un archivo a subir:</label>
                        <input type="file" name="archivo" id="archivo" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="btnEnviar" class="btn-custom1">Enviar</button>
                    </div>
                </form>
            </section>
        </div>
    </div>

    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>
</body>

</html>