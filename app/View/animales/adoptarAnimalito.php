<?php
session_start(); // Inicia la sesión

include_once '../layout.php';
include_once '../../Controller/adopcionController.php';

// Verifica si el ID del usuario está establecido en la sesión
$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : null;

$mostrarModal = false; // Bandera para mostrar el modal

if (!$id_usuario) {
    // Si no hay sesión, activar la bandera para mostrar el modal
    $mostrarModal = true;
} else {
    $usuario = adopcionController::ObtenerUsuarioPorIDAdopcion($id_usuario);

    if (!$usuario) {
        echo "Usuario no encontrado.";
        exit;
    }

    // Obtener los datos necesarios desde el array $usuario
    $nombre_completo = isset($usuario['nombre_completo']) ? $usuario['nombre_completo'] : '';
    $telefono = isset($usuario['TELEFONO']) ? $usuario['TELEFONO'] : '';
    $email = isset($usuario['CORREO']) ? $usuario['CORREO'] : '';
    $direccion = isset($usuario['DIRECCION']) ? $usuario['DIRECCION'] : '';
}

// Verificar el mensaje en la URL
$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';

// Procesar la solicitud de adopción si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$mostrarModal) {
    adopcionController::ProcesarAdopcion();
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
                    <p>Adopta a un animalito</p>
                </div>

                <div class="containerB">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <br>
                            <br>
                            <div class="text-center">
                                <img src="https://us.123rf.com/450wm/photodeti/photodeti1807/photodeti180700124/104281525-pembroke-welsh-corgi-cachorro-y-gatito-atigrado-se-miran-en-un-c%C3%A9sped-de-verano.jpg?ver=6" alt="Animalito" class="img-fluid">
                                <p id="animalitoNombre" class="texto-animalito">Nombre: Lucy</p>
                                <div class="textarea">
                                    <textarea readonly name="descripcion-animalito" id="descripcion-animalito">Lucy es una adorable cachorra que busca un hogar amoroso.</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <?php if (!$mostrarModal): ?>
                                <div class="form-adopcion">
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo ($nombre_completo); ?>" readonly>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $telefono; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <textarea id="mensaje" name="mensaje" class="form-control" rows="4" placeholder="Mensaje" required></textarea>
                                        </div>
                                        <div class="containerB">
                                            <button type="submit" class="btn-custom1">Enviar Solicitud</button>
                                        </div>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
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
                    Para enviar una solicitud de adopción, primero debes iniciar sesión o registrarte.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <a href="../auth/login.php" class="btn btn-primary">Iniciar Sesión</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de éxito -->
    <div class="modal fade" id="modalExitoAdopcion" tabindex="-1" role="dialog" aria-labelledby="modalExitoAdopcionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalExitoAdopcionLabel">Solicitud Enviada con Éxito</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¡Gracias por tu solicitud! Nos pondremos en contacto contigo pronto.
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
                $('#modalExitoAdopcion').modal('show');
            <?php endif; ?>

            // Redirigir al home cuando se cierra el modal de éxito
            $('#modalExitoAdopcion').on('hidden.bs.modal', function(e) {
                window.location.href = '../home/home.php'; // Cambia a la ruta de tu página de inicio
            });
        });
    </script>
</body>

</html>