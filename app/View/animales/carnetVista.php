<?php
session_start();
include_once '../layout.php';
include_once '../../Controller/CarnetController.php';

$carnets = carnetController::obtenerCarnets();
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
                    <div class="p-5">
                        <div class="text-center">
                            <h1>Encontrar a tu mascota</h1>
                            <div class="row">
                                <?php foreach ($carnets as $carnet): ?>
                                    <?php if ($carnet['ID_ESTADO'] == 2): ?>
                                        <div class="col-md-4">
                                            <div class="card" style="width: 18rem;">
                                                <?php if ($carnet['IMAGEN']): ?>
                                                    <img src="/G3_SC502_VN_Proyecto/app/View/subirImg/<?php echo basename($carnet['IMAGEN']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($carnet['NOMBRE_ANIMAL']); ?>" style="object-fit: cover; width: 100%; height: 200px;">
                                                <?php endif; ?>
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo htmlspecialchars($carnet['NOMBRE_ANIMAL']); ?></h5>
                                                    <p class="card-text">Raza: <?php echo htmlspecialchars($carnet['RAZA']); ?></p>
                                                    <p class="card-text">Fecha de Rescate: <?php echo htmlspecialchars(date('d-m-Y', strtotime($carnet['FECHA_RESCATE']))); ?></p>

                                                    <?php if ($_SESSION['id_rol'] == 1 || $carnet['ID_USUARIO'] == $_SESSION['id_usuario']): ?>
                                                        <a href="carnetActualizar.php?idCarnet=<?php echo $carnet['ID_CARNET']; ?>" class="btn btn-primary btn-sm">Actualizar</a>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmarEliminacion(<?php echo urlencode($carnet['ID_CARNET']); ?>)">Eliminar</button>
                                                    <?php endif; ?>

<<<<<<< Updated upstream
                                                <a href="../animales/adoptarAnimalito.php" class="btn btn-info btn-sm">Adoptar</a>
=======
                                                    <a href="#" class="btn btn-info btn-sm">Adoptar</a>
                                                </div>
>>>>>>> Stashed changes
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
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
        function confirmarEliminacion(idCarnet) {
            Swal.fire({
                title: '¿Estás seguro de que deseas eliminar este carnet?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../../Controller/CarnetController.php',
                        type: 'POST',
                        data: {
                            action: 'Eliminar',
                            idCarnet: idCarnet
                        },
                        success: function(response) {
                            var result = JSON.parse(response);
                            if (result.success) {
                                Swal.fire({
                                    title: 'Éxito',
                                    text: result.message,
                                    icon: 'success'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: result.message,
                                    icon: 'error'
                                });
                            }
                        }
                    });
                }
            });
        }
    </script>
</body>

</html>