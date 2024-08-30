<?php
session_start();
include_once '../layout.php';
include_once '../../Controller/CarnetController.php';
include_once '../../Model/adopcionModel.php';

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

$idUsuario = $_SESSION['id_usuario'];
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
        <section class="content py-5">
    <div class="container">
        <div class="text-center mb-4">
            <h1 class="display-4">Adopta a un Animalito</h1>
        </div>

        <div class="row">
            <!-- Columna de Información del Animalito -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-light">
                    <?php if ($carnet['IMAGEN']): ?>
                        <img src="/G3_SC502_VN_Proyecto/app/View/subirImg/<?php echo basename($carnet['IMAGEN']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($carnet['NOMBRE_ANIMAL']); ?>" style="object-fit: cover; height: 300px;">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($carnet['NOMBRE_ANIMAL']); ?></h5>
                        <p class="card-text"><strong>Raza:</strong> <?php echo htmlspecialchars($carnet['RAZA']); ?></p>
                        <p class="card-text"><strong>Fecha de Rescate:</strong> <?php echo htmlspecialchars(date('d/m/Y', strtotime($carnet['FECHA_RESCATE']))); ?></p>
                        <p class="card-text"><strong>Descripción:</strong></p>
                        <p class="card-text"><?php echo htmlspecialchars($carnet['DESCRIPCION']); ?></p>
                    </div>
                </div>
            </div>

            <!-- Columna de Formulario de Adopción -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-light">
                    <div class="card-body">
                        <h5 class="card-title">Formulario de Adopción</h5>
                        <br></br>
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
                                <textarea class="form-control" id="mensaje" name="mensaje" rows="4" placeholder="Escribe tu dirección y la razón de por qué deseas adoptarme aquí.." required="true"></textarea>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary">Enviar Mensaje</button>
                                <a href="carnetVista.php" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .content {
        background-color: #f8f9fa;
    }

    .titulo-generico p {
        font-size: 2rem;
        font-weight: bold;
        color: #343a40;
    }

    .card {
        border-radius: 8px;
    }

    .card-img-top {
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    .card-body {
        background-color: #ffffff;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
    }

    .btn-primary:hover, .btn-secondary:hover {
        opacity: 0.9;
    }

    textarea {
        resize: none;
    }
</style>


            
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