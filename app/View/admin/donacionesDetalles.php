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
<html>

<?php head(); ?>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php MostrarNav(); ?>
        <?php MostrarMenu(); ?>

        <div class="content-wrapper">
            <div class="container">
                <h1>Detalles de la Donación</h1>
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Información del Usuario</h3>
                        <p><strong>Nombre de Usuario:</strong> <?php echo htmlspecialchars($usuario['NOMBRE_USUARIO']); ?></p>
                        <p><strong>Nombre Completo:</strong> <?php echo htmlspecialchars($usuario['nombre_completo']); ?></p>
                        <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($usuario['TELEFONO']); ?></p>
                        <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($usuario['CORREO']); ?></p>

                        <?php if ($donacion['LINK_COMPROBANTE']): ?>
                            <img src="/G3_SC502_VN_Proyecto/app/View/dist/uploads/<?php echo basename($donacion['LINK_COMPROBANTE']); ?>" class="img-fluid" alt="Comprobante de Donación" style="object-fit: contain; width: 100%; max-height: 400px;">
                        <?php endif; ?>
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