<?php
session_start();
include_once '../layout.php';
include_once '../../Controller/CarnetController.php';
include_once '../../Model/adopcionModel.php'; // Incluye el modelo de adopcion para obtener los datos del usuario

if (!isset($_GET['idCarnet'])) {
    header('Location: carnetVista.php');
    exit;
}

$idCarnet = intval($_GET['idCarnet']);
$carnet = carnetModel::obtenerCarnetPorId($idCarnet);

if (!$carnet) {
    header('Location: carnetVista.php');
    exit;
}

// Obtener el ID del usuario de la sesión
$idUsuario = $_SESSION['id_usuario'];
// Obtener los datos del usuario desde la base de datos usando el ID
$usuario = adopcionModel::obtenerUsuarioPorId($idUsuario);

if (!$usuario) {
    header('Location: carnetVista.php');
    exit;
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
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6">
                            <div class="card border-primary mt-5">
                                <div class="card-header bg-primary text-white">
                                    <h4 class="mb-0 text-center">Carnet del Animal</h4>
                                </div>
                                <div class="card-body">
                                    <!-- Display Image -->
                                    <div class="text-center mb-3">
                                        <?php if ($carnet['IMAGEN']): ?>
                                            <img src="/G3_SC502_VN_Proyecto/app/View/subirImg/<?php echo basename($carnet['IMAGEN']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($carnet['NOMBRE_ANIMAL']); ?>" style="object-fit: cover; width: 100%; height: 200px;">
                                        <?php endif; ?>
                                    </div>

                                    <!-- Animal Information -->
                                    <div class="mb-4">
                                        <h5>Nombre del Animal:</h5>
                                        <p><?php echo htmlspecialchars($carnet['NOMBRE_ANIMAL']); ?></p>
                                        <h5>Raza:</h5>
                                        <p><?php echo htmlspecialchars($carnet['RAZA']); ?></p>
                                        <h5>Fecha de Rescate:</h5>
                                        <p><?php echo htmlspecialchars(date('d/m/Y', strtotime($carnet['FECHA_RESCATE']))); ?></p>
                                        <h5>Descripción:</h5>
                                        <p><?php echo htmlspecialchars($carnet['DESCRIPCION']); ?></p>
                                    </div>

                                    <!-- Formulario de Mensaje -->
                                    <div class="mb-4">
                                        <form id="solicitarAdopcion" enctype="multipart/form-data">
                                            <input type="hidden" name="idCarnet" value="<?php echo htmlspecialchars($idCarnet); ?>">
                                            <div class="form-group">
                                                <label for="nombre_usuario">Nombre de Usuario:</label>
                                                <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" value="<?php echo htmlspecialchars($usuario['username']); ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="num_telefono">Número de Teléfono:</label>
                                                <input type="text" class="form-control" id="num_telefono" name="num_telefono" value="<?php echo htmlspecialchars($usuario['TELEFONO']); ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="correo">Correo Electrónico:</label>
                                                <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario['CORREO']); ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="mensaje">Dirección y Mensaje:</label>
                                                <textarea class="form-control" id="mensaje" name="mensaje" rows="3" placeholder="Escribe tu dirección y la razón de por qué deseas adoptarme aquí.."></textarea>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Enviar Mensaje</button>
                                                <a href="carnetVista.php" class="btn btn-secondary">Cancelar</a>
                                            </div>
                                        </form>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </div>

    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#solicitarAdopcion').on('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                formData.append('action', 'EnviarMensaje');

                $.ajax({
                    url: '../../Controller/adopcionController.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log('Response from server:', response);
                        try {
                            var result = JSON.parse(response);
                            if (result.success) {
                                Swal.fire({
                                    title: 'Éxito',
                                    text: result.message,
                                    icon: 'success'
                                }).then(() => {
                                    window.location.href = 'carnetVista.php';
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: result.message,
                                    icon: 'error'
                                });
                            }
                        } catch (e) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Respuesta del servidor no válida.',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        Swal.fire({
                            title: 'Error',
                            text: 'Hubo un problema al procesar la solicitud.',
                            icon: 'error'
                        });
                    }
                });

            });
        });
    </script>

    
</body>

</html>