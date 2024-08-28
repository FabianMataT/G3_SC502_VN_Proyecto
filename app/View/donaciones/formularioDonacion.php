<?php
session_start(); // Inicia la sesión

include_once '../layout.php';
include_once '../../Controller/donacionController.php';

// Verifica si el ID del usuario está establecido en la sesión
$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : null;

$mostrarModal = false; // Bandera para mostrar el modal

if (!$id_usuario) {
    // Si no hay sesión, activar la bandera para mostrar el modal
    $mostrarModal = true;
} else {
    $usuario = donacionController::ObtenerUsuarioPorIDDonacion($id_usuario);

    if (!$usuario) {
        echo "Usuario no encontrado.";
        exit;
    }

    // Obtener los datos necesarios desde el array $usuario
    $nombre_completo = isset($usuario['nombre_completo']) ? $usuario['nombre_completo'] : '';
    $telefono = isset($usuario['TELEFONO']) ? $usuario['TELEFONO'] : '';
    $email = isset($usuario['CORREO']) ? $usuario['CORREO'] : '';
}

// Verificar el mensaje en la URL
$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';

// Procesar la donación si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$mostrarModal) {
    donacionController::ProcesarDonacion();
}
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

                <?php if (!$mostrarModal): ?>
                    <form action="" method="post" enctype="multipart/form-data" class="form-donacion">
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
                <?php endif; ?>
            </section>
        </div>
    </div>

    <!-- Modal para mostrar cuando no hay sesión iniciada -->
    <div class="modal fade" id="modalNoSesion" tabindex="-1" role="dialog" aria-labelledby="modalNoSesionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNoSesionLabel">Iniciar Sesión Requerida</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Para realizar una donación, primero debes iniciar sesión o registrarte.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <a href="../auth/login.php" class="btn btn-primary">Iniciar Sesión</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de éxito -->
    <div class="modal fade" id="modalExitoDonacion" tabindex="-1" role="dialog" aria-labelledby="modalExitoDonacionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalExitoDonacionLabel">Donación Realizada con Éxito</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¡Gracias por tu donación! La transacción ha sido procesada con éxito.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>

    <script>
        $(document).ready(function() {
            // Mostrar el modal si la bandera $mostrarModal es true
            <?php if ($mostrarModal): ?>
                $('#modalNoSesion').modal('show');
            <?php endif; ?>

            // Mostrar el modal de éxito si el parámetro de mensaje es 'exito'
            <?php if ($mensaje === 'exito'): ?>
                $('#modalExitoDonacion').modal('show');
            <?php endif; ?>

            // Redirigir al home cuando se cierra el modal de éxito
            $('#modalExitoDonacion').on('hidden.bs.modal', function (e) {
                window.location.href = '../home/home.php'; // Cambia a la ruta de tu página de inicio
            });
        });
    </script>
</body>
</html>
