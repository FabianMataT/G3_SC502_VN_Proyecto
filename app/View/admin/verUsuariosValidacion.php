<?php
include_once '../layout.php';
include_once '../../Controller/adminController.php';

$estado = isset($_GET['ESTADO']) ? intval($_GET['ESTADO']) : null;
$usuarios = adminController::ObtenerUsuarios($estado);

// Lógica para las acciones de usuario
if (isset($_GET['accion']) && isset($_GET['id_usuario'])) {
    $accion = $_GET['accion'];
    $id_usuario = intval($_GET['id_usuario']);

    if ($accion == 'bloquear') {
        adminController::CambiarEstadoUsuario($id_usuario, 0);
    } elseif ($accion == 'desbloquear') {
        adminController::CambiarEstadoUsuario($id_usuario, 1);
    } elseif ($accion == 'eliminar') {
        adminController::EliminarUsuario($id_usuario);
    }

    header('Location: verUsuarios.php');
    exit;
}
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
                    <a href="verUsuarios.php?ESTADO=1" class="btn btn-primary mb-3">Activos</a>
                    <a href="verUsuarios.php?ESTADO=0" class="btn btn-danger mb-3">Inactivos</a>
                    <a href="verUsuarios.php?ROL=4" class="btn btn-danger mb-3">En Validación</a>
                    <a href="verUsuarios.php" class="btn btn-info mb-3">Todos</a>
                </div>

                <table id="usuariosTable" class="table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Nombre Completo</th>
                            <th>Telefono</th>
                            <th>Email</th>
                            <th>Rol</th>
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
                                        <?php if (isset($usuario['ESTADO'])): ?>
                                            <?php if ($usuario['ESTADO'] == 1): ?>
                                                <button type="button" class="btn btn-warning" onclick="confirmarAccion('bloquear', <?php echo urlencode($usuario['ID_USUARIO']); ?>)">Bloquear</button>
                                            <?php elseif ($usuario['ESTADO'] == 0): ?>
                                                <button type="button" class="btn btn-success" onclick="confirmarAccion('desbloquear', <?php echo urlencode($usuario['ID_USUARIO']); ?>)">Desbloquear</button>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span>No disponible</span>
                                        <?php endif; ?>
                                        <a href="editarRolUsuario.php?id_usuario=<?php echo urlencode($usuario['ID_USUARIO']); ?>" class="btn btn-info ml-2">Cambiar Rol</a>
                                        <button type="button" class="btn btn-danger ml-2" onclick="confirmarEliminacion(<?php echo urlencode($usuario['ID_USUARIO']); ?>)">Eliminar</button>
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
    <script>
        function confirmarAccion(accion, id_usuario) {
            let accionTexto = accion === 'bloquear' ? 'bloquear' : 'desbloquear';
            Swal.fire({
                title: `¿Estás seguro de que deseas ${accionTexto} este usuario?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, continuar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `verUsuarios.php?accion=${accion}&id_usuario=${id_usuario}`;
                }
            });
        }

        function confirmarEliminacion(id_usuario) {
            Swal.fire({
                title: '¿Estás seguro de que deseas eliminar este usuario?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `verUsuarios.php?accion=eliminar&id_usuario=${id_usuario}`;
                }
            });
        }
    </script>
    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>