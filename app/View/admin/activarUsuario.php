<?php
include_once '../layout.php';
include_once '../../Controller/adminController.php';

if (isset($_POST['id_usuario']) && isset($_POST['rol'])) {
    $id_usuario = intval($_POST['id_usuario']);
    $id_rol = intval($_POST['rol']);

    $resultado = adminController::ActualizarRolUsuario($id_usuario, $id_rol);

    if ($resultado) {
        header('Location: verUsuarios.php?mensaje=rol_actualizado');
        exit;
    } else {
        echo "Error al actualizar el rol.";
    }
}

if (isset($_GET['id_usuario'])) {
    $id_usuario = intval($_GET['id_usuario']);
    $usuario = adminController::ObtenerUsuarioValidacionPorID($id_usuario);
    $roles = adminController::ObtenerRoles();
} else {
    header('Location: verUsuarios.php');
    exit;
}

if (!$usuario) {
    echo "Usuario no encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Información del Usuario</h3>
                    </div>
                    <div class="card-body">
                        <form id="editarRolForm" method="POST" action="editarRolUsuario.php">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" id="username" value="<?php echo htmlspecialchars($usuario['username']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="nombre_completo">Nombre Completo:</label>
                                <input type="text" class="form-control" id="nombre_completo" value="<?php echo htmlspecialchars($usuario['nombre_completo']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono:</label>
                                <input type="text" class="form-control" id="telefono" value="<?php echo htmlspecialchars($usuario['TELEFONO']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="email">Correo Electrónico:</label>
                                <input type="text" class="form-control" id="email" value="<?php echo htmlspecialchars($usuario['CORREO']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="empresa">Empresa:</label>
                                <input type="text" class="form-control" id="empresa" value="<?php echo htmlspecialchars($usuario['EMPRESA']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="motivo">Motivo:</label>
                                <textarea class="form-control" id="motivo" rows="3" disabled><?php echo htmlspecialchars($usuario['MOTIVO_PERFIL']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="comprobante_sinpe">Comprobante SINPE:</label>
                                <?php if ($usuario['COMPROBANTE_SINPE']): ?>
                                    <img src="/G3_SC502_VN_Proyecto/app/View/subirImg/<?php echo basename($usuario['COMPROBANTE_SINPE']); ?>" class="card-img-top" style="object-fit: cover; width: 250px; height: 250px;">
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="rol">Rol:</label>
                                <select class="form-control" id="rol" name="rol">
                                    <?php foreach ($roles as $rol): ?>
                                        <option value="<?php echo $rol['ID_ROL']; ?>" <?php echo $rol['ID_ROL'] == $usuario['ID_ROL'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($rol['NOMBRE_ROL']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <input type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>">
                            <button type="button" class="btn btn-primary" id="guardarCambios">Guardar Cambios</button>
                            <a href="verUsuarios.php" class="btn btn-danger">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#guardarCambios').click(function() {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡Cambiaras el rango del Usuario!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, guardar cambios',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#editarRolForm').submit();
                    }
                });
            });
        });
    </script>
</body>

</html>