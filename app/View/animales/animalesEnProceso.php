<?php
include_once '../layout.php';
include_once '../../Controller/adopcionController.php';

$solicitudes = adopcionController::ObtenerSolicitudesAdopcion();

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
            <div class="containerVerUsuarios">
                <h1>Lista de Solicitudes de adopción</h1>

                <table id="usuariosTable" class="table">
                    <thead>
                        <tr>
                            <th>Nombre del animal</th>
                            <th>Nombre del usuario</th>
                            <th>Telefono</th>
                            <th>Ver Solicitud completa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($solicitudes) > 0): ?>
                            <?php foreach ($solicitudes as $solicitud): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($solicitud['NOMBRE_ANIMAL']); ?></td>
                                    <td><?php echo htmlspecialchars($solicitud['NOMBRE_USUARIO']); ?></td>
                                    <td><?php echo htmlspecialchars($solicitud['NUM_TELEFONO']); ?></td>
                                    <td>
                                        <a href="animalSolicitudInfo.php?id_adopcion=<?php echo urlencode($solicitud['ID_ADOPCION']); ?>" class="btn btn-info ml-2">Ver Info</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">No hay solicitudes disponibles</td>
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>