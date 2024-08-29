<?php include_once '../layout.php';
include_once '../../Controller/CarnetController.php';

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
                            <h1>Lista de Animales</h1>
                        </div>
                        <div class="row">
                            <?php foreach ($carnets as $carnet): ?>
                                <div class="col-md-4">
                                    <div class="card" style="width: 18rem;">
                                        <?php if ($carnet['IMAGEN']): ?>
                                            <img src="/G3_SC502_VN_Proyecto/app/View/subirImg/<?php echo basename($carnet['IMAGEN']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($carnet['NOMBRE_ANIMAL']); ?>">
                                        <?php endif; ?>
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo htmlspecialchars($carnet['NOMBRE_ANIMAL']); ?></h5>
                                            <p class="card-text">Raza: <?php echo htmlspecialchars($carnet['RAZA']); ?></p>
                                            <p class="card-text">Fecha de Rescate: <?php echo htmlspecialchars(date('d-m-Y', strtotime($carnet['FECHA_RESCATE']))); ?></p>
                                            <a href="#" class="btn btn-primary btn-sm">Actualizar</a>
                                            <a href="#" class="btn btn-danger btn-sm">Eliminar</a>
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