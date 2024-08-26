<?php
include_once '../layout.php';
include_once '../../Controller/adminController.php';

$estado = isset($_GET['estado']) ? intval($_GET['estado']) : null;
$usuarios = adminController::ObtenerUsuarios($estado);

// Lógica para las acciones de usuario
if (isset($_GET['accion']) && isset($_GET['id_usuario'])) {
    $accion = $_GET['accion'];
    $id_usuario = intval($_GET['id_usuario']);

    if ($accion == 'bloquear') {
        adminController::CambiarEstadoUsuario($id_usuario, 2);
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

                <div class="filter-buttons mb-3">
                    <a href="verUsuarios.php?estado=1" class="btn btn-primary">Activos</a>
                    <a href="verUsuarios.php?estado=2" class="btn btn-danger">Inactivos</a>
                    <a href="verUsuarios.php" class="btn btn-info">Todos</a>
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
                                        <?php if (isset($usuario['ID_ESTADO'])): ?>
                                            <?php if ($usuario['ID_ESTADO'] == 1): ?>
                                                <button class="btn btn-warning" onclick="confirmarAccion('bloquear', <?php echo $usuario['ID_USUARIO']; ?>)">Bloquear</button>
                                            <?php elseif ($usuario['ID_ESTADO'] == 2): ?>
                                                <button class="btn btn-success" onclick="confirmarAccion('desbloquear', <?php echo $usuario['ID_USUARIO']; ?>)">Desbloquear</button>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span>No disponible</span>
                                        <?php endif; ?>
                                        <button class="btn btn-danger ml-1" onclick="confirmarAccion('eliminar', <?php echo $usuario['ID_USUARIO']; ?>)">Eliminar</button>
                                        <a class="ml-1 btn btn-info" href="editarRolUsuario.php?id_usuario=<?php echo urlencode($usuario['ID_USUARIO']); ?>" class="btn btn-info ml-2">Cambiar Rol</a>
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
    <script>
        function confirmarAccion(accion, id_usuario) {
            let accionTexto = '';
            if (accion === 'bloquear') {
                accionTexto = 'bloquear';
            } else if (accion === 'desbloquear') {
                accionTexto = 'desbloquear';
            } else if (accion === 'eliminar') {
                accionTexto = 'eliminar';
            }
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
    </script>
</body>

</html>