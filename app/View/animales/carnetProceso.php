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
                        <!-- Sección de carnets con ID_ESTADO = 3 -->
                        <div class="text-center">
                            <h1>Mis Mascotas en Proceso de Adopción</h1>
                            <div class="row">
                                <?php foreach ($carnets as $carnet): ?>
                                    <?php if ($carnet['ID_USUARIO'] == $_SESSION['id_usuario'] && $carnet['ID_ESTADO'] == 3): ?>
                                        <div class="col-md-4">
                                            <div class="card" style="width: 18rem;">
                                                <?php if ($carnet['IMAGEN']): ?>
                                                    <img src="/G3_SC502_VN_Proyecto/app/View/subirImg/<?php echo basename($carnet['IMAGEN']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($carnet['NOMBRE_ANIMAL']); ?>" style="object-fit: cover; width: 100%; height: 200px;">
                                                <?php endif; ?>
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo htmlspecialchars($carnet['NOMBRE_ANIMAL']); ?></h5>
                                                    <p class="card-text">Raza: <?php echo htmlspecialchars($carnet['RAZA']); ?></p>
                                                    <p class="card-text">Fecha de Rescate: <?php echo htmlspecialchars(date('d-m-Y', strtotime($carnet['FECHA_RESCATE']))); ?></p>

                                                    <button type="button" class="btn btn-success btn-sm" onclick="cambiarEstado(<?php echo urlencode($carnet['ID_CARNET']); ?>, 1)">Adoptado</button>
                                                    <button type="button" class="btn btn-warning btn-sm" onclick="cambiarEstado(<?php echo urlencode($carnet['ID_CARNET']); ?>, 2)">Reposicionar</button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Sección de carnets con ID_ESTADO = 1 -->
                        <div class="text-center mt-5">
                            <h1>Mis Mascotas Adoptadas</h1>
                            <div class="row">
                                <?php foreach ($carnets as $carnet): ?>
                                    <?php if ($carnet['ID_USUARIO'] == $_SESSION['id_usuario'] && $carnet['ID_ESTADO'] == 1): ?>
                                        <div class="col-md-4">
                                            <div class="card" style="width: 18rem;">
                                                <?php if ($carnet['IMAGEN']): ?>
                                                    <img src="/G3_SC502_VN_Proyecto/app/View/subirImg/<?php echo basename($carnet['IMAGEN']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($carnet['NOMBRE_ANIMAL']); ?>" style="object-fit: cover; width: 100%; height: 200px;">
                                                <?php endif; ?>
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo htmlspecialchars($carnet['NOMBRE_ANIMAL']); ?></h5>
                                                    <p class="card-text">Raza: <?php echo htmlspecialchars($carnet['RAZA']); ?></p>
                                                    <p class="card-text">Fecha de Rescate: <?php echo htmlspecialchars(date('d-m-Y', strtotime($carnet['FECHA_RESCATE']))); ?></p>

                                                    <button type="button" class="btn btn-warning btn-sm" onclick="cambiarEstado(<?php echo urlencode($carnet['ID_CARNET']); ?>, 2)">Reposicionar</button>
                                                </div>
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
        function cambiarEstado(idCarnet, nuevoEstado) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción cambiará el estado de la mascota.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, cambiar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../../Controller/CarnetController.php',
                        type: 'POST',
                        data: {
                            action: 'ActualizarEstado',
                            idCarnet: idCarnet,
                            nuevoEstado: nuevoEstado
                        },
                        success: function(response) {
                            try {
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
                            } catch (e) {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Error al procesar la respuesta del servidor.',
                                    icon: 'error'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Error',
                                text: 'No se pudo realizar la petición al servidor.',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        }
    </script>
</body>

</html>