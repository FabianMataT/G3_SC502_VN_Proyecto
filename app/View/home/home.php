<?php include_once '../layout.php';
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
                        <div class="text-center">
                            <h1>Productos</h1>
                        </div>
                        <!-- Contenedor para las tarjetas de productos -->
                        <div id="contenidoProductos" class="row "></div>
                    </div>
                    <div class="p-5">
                        <div class="text-center">
                            <h1>Encontrar a tu mascota</h1>
                            <div class="row">
                                <?php foreach ($carnets as $carnet): ?>
                                    <div class="col-md-4">
                                        <div class="card" style="width: 18rem;">
                                            <?php if ($carnet['IMAGEN']): ?>
                                                <img src="/G3_SC502_VN_Proyecto/app/View/subirImg/<?php echo basename($carnet['IMAGEN']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($carnet['NOMBRE_ANIMAL']); ?>" style="object-fit: cover; width: 100%; height: 200px;">
                                            <?php endif; ?>
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo htmlspecialchars($carnet['NOMBRE_ANIMAL']); ?></h5>
                                                <p class="card-text">Raza: <?php echo htmlspecialchars($carnet['RAZA']); ?></p>
                                                <p class="card-text">Fecha de Rescate: <?php echo htmlspecialchars(date('d-m-Y', strtotime($carnet['FECHA_RESCATE']))); ?></p>

                                                <!-- Verificación de permisos para mostrar los botones -->
                                                <?php if ($_SESSION['id_rol'] == 1 || $carnet['ID_USUARIO'] == $_SESSION['id_usuario']): ?>
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
                    </div>
            </section>
        </div>


    </div>

    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>

</body>

</html>