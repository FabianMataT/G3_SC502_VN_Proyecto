<?php
include_once '../layout.php';
include_once '../../Controller/carnetController.php';

$carnets = carnetController::obtenerCarnets();
?>

<!DOCTYPE html>
<html>

<?php
head();
?>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php
        MostrarNav();
        MostrarMenu();
        ?>

        <div class="content-wrapper">
            <section class="content">
                <div class="container">
                    <div class="p-5">
                        <div class="text-center mb-5">
                            <h1>Encontrar a tu mascota</h1>
                            <div class="row">
                                <?php
                                usort($carnets, function ($a, $b) {
                                    if ($a['ID_USUARIO'] == $_SESSION['id_usuario']) return -1;
                                    if ($b['ID_USUARIO'] == $_SESSION['id_usuario']) return 1;
                                    return 0;
                                });

                                foreach ($carnets as $carnet): ?>
                                    <div class="col-md-4">
                                        <div class="card" style="width: 18rem;">
                                            <?php if ($carnet['IMAGEN']): ?>
                                                <img src="/G3_SC502_VN_Proyecto/app/View/subirImg/<?php echo basename($carnet['IMAGEN']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($carnet['NOMBRE_ANIMAL']); ?>" style="width: 100%; height: 200px; object-fit: cover;">
                                            <?php endif; ?>
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo htmlspecialchars($carnet['NOMBRE_ANIMAL']); ?></h5>
                                                <p class="card-text">Raza: <?php echo htmlspecialchars($carnet['RAZA']); ?></p>
                                                <p class="card-text">Fecha de Rescate: <?php echo htmlspecialchars(date('d-m-Y', strtotime($carnet['FECHA_RESCATE']))); ?></p>

                                                <?php if ($carnet['ID_USUARIO'] == $_SESSION['id_usuario'] || (isset($_SESSION['ID_ROL']) && $_SESSION['ID_ROL'] == 1)): ?>
                                                    <a href="#" class="btn btn-primary btn-sm">Actualizar</a>
                                                    <a href="#" class="btn btn-danger btn-sm">Eliminar</a>
                                                <?php endif; ?>

                                                <a href="#" class="btn btn-info btn-sm">Adoptar</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
            </section>
        </div>

    </div>

    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>

</body>

</html>