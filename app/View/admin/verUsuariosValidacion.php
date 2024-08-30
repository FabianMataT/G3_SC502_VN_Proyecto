<?php
include_once '../layout.php';
include_once '../../Controller/adminController.php';

$rol = isset($_GET['ROL']) ? intval($_GET['ROL']) : null;
$usuarios = adminController::ObtenerUsuariosEnValidacion($rol);

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
                <h1>Lista de Usuarios</h1>

                <div class="filter-buttons">
                    <a href="verUsuarios.php?ESTADO=1" class="btn btn-success mb-3">Activos</a>
                    <a href="verUsuariosValidacion.php?ROL=4" class="btn btn-primary mb-3">En Validación</a>
                    <a href="verUsuarios.php?ESTADO=0" class="btn btn-danger mb-3">Inactivos</a>
                    <a href="verUsuarios.php" class="btn btn-info mb-3">Todos</a>
                </div>

                <table id="usuariosTable" class="table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Nombre Completo</th>
                            <th>Telefono</th>
                            <th>Email</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($usuarios) > 0): ?>
                            <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($usuario['username']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['nombre_completo']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['telefono']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                                    <td>
                                        <a href="activarUsuario.php?id_usuario=<?php echo urlencode($usuario['ID_USUARIO']); ?>" class="btn btn-info ml-2">Ver Info</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">No hay usuarios disponibles</td>
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