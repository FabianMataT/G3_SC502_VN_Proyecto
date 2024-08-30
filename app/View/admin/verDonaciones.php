<?php
include_once '../layout.php';
include_once '../../Controller/donacionController.php';

$donaciones = donacionController::ObtenerDonaciones();

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
            <div class="container">
                <h1>Lista de Donaciones</h1>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre de Usuario</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($donaciones) > 0): ?>
                            <?php foreach ($donaciones as $donacion): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($donacion['username']); ?></td>
                                    <td><?php echo htmlspecialchars($donacion['CORREO']); ?></td>
                                    <td><?php echo htmlspecialchars($donacion['TELEFONO']); ?></td>
                                    <td>
                                        <a href="donacionesDetalles.php?id_donacion=<?php echo urlencode($donacion['ID_DONACION']); ?>" class="btn btn-info">Ver más</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No hay donaciones disponibles</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>
</body>

</html>