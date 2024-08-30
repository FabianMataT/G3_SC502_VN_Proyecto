<?php
session_start();
include_once '../layout.php';
include_once '../../Controller/CarnetController.php';

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
                                    <h4 class="mb-0 text-center">Actualizar Carnet</h4>
                                </div>
                                <div class="card-body">
                                    <form id="formActualizarCarnet" enctype="multipart/form-data">
                                        <input type="hidden" name="idCarnet" value="<?php echo htmlspecialchars($idCarnet); ?>">
                                        <div class="form-group">
                                            <label for="nombre_animal">Nombre del Animal</label>
                                            <input type="text" class="form-control" id="nombre_animal" name="nombre_animal" value="<?php echo htmlspecialchars($carnet['NOMBRE_ANIMAL']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="raza">Raza</label>
                                            <input type="text" class="form-control" id="raza" name="raza" value="<?php echo htmlspecialchars($carnet['RAZA']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="fecha_rescate">Fecha de Rescate</label>
                                            <input type="date" class="form-control" id="fecha_rescate" name="fecha_rescate" value="<?php echo htmlspecialchars(date('Y-m-d', strtotime($carnet['FECHA_RESCATE']))); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="descripcion">Descripción</label>
                                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo htmlspecialchars($carnet['DESCRIPCION']); ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="image">Imagen (opcional)</label>
                                            <input type="file" class="form-control-file" id="image" name="image">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Actualizar</button>
                                            <a href="carnetVista.php" class="btn btn-secondary">Cancelar</a>
                                        </div>
                                    </form>
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
            $('#formActualizarCarnet').on('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                formData.append('action', 'Actualizar');

                $.ajax({
                    url: '../../Controller/CarnetController.php',
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