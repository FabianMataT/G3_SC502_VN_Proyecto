<?php
include_once '../layout.php';
include_once '../../Controller/donacionController.php';

if (isset($_GET['id_donacion'])) {
    $id_donacion = intval($_GET['id_donacion']);
    $donacion = donacionController::ObtenerDonacionPorID($id_donacion);
    $usuario = donacionController::ObtenerUsuarioPorIDDonacion($donacion['ID_USUARIO']);
} else {
    echo "ID de donación no proporcionado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<?php head(); ?>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php MostrarNav(); ?>
        <?php MostrarMenu(); ?>

        <div class="content-wrapper">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card shadow-lg border-0">
                            <div class="card-header bg-primary text-white">
                                <h1 class="card-title mb-0">Detalles de la Donación 🐾</h1>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3 class="mb-4">Información del Usuario 🐶</h3>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"><strong>Nombre de Usuario:</strong> <?php echo htmlspecialchars($usuario['username']); ?></li>
                                            <li class="list-group-item"><strong>Nombre Completo:</strong> <?php echo htmlspecialchars($usuario['nombre_completo']); ?></li>
                                            <li class="list-group-item"><strong>Teléfono:</strong> <?php echo htmlspecialchars($usuario['TELEFONO']); ?></li>
                                            <li class="list-group-item"><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($usuario['CORREO']); ?></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-center justify-content-center">
                                        <?php if ($donacion['LINK_COMPROBANTE']): ?>
                                            <img src="/G3_SC502_VN_Proyecto/app/View/dist/uploads/<?php echo basename($donacion['LINK_COMPROBANTE']); ?>" class="img-fluid rounded border" alt="Comprobante de Donación" style="object-fit: contain; max-height: 400px;">
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <a href="verDonaciones.php" class="btn btn-dark">Volver a Donaciones 🏠</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>
</body>

</html>