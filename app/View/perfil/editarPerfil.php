<?php
include_once '../layout.php';
include_once '../../Controller/perfilController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../login.php');
    exit();
}

$perfilController = new PerfilController();
$idUsuario = $_SESSION['id_usuario'];

// Obtener la información del usuario
$usuario = $perfilController->ObtenerUsuarioPorID($idUsuario);
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
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Editar Perfil</h3>
                                </div>
                                <div class="card-body">
                                    <form id="editarPerfilForm">
                                        <div class="form-group">
                                            <label for="nombre">Nombre:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                                </div>
                                                <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="apellido1">Apellido 1:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <input type="text" id="apellido1" name="apellido1" class="form-control" value="<?php echo htmlspecialchars($usuario['apellido1']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="apellido2">Apellido 2:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <input type="text" id="apellido2" name="apellido2" class="form-control" value="<?php echo htmlspecialchars($usuario['apellido2']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="telefono">Teléfono:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                </div>
                                                <input type="number" id="telefono" name="telefono" class="form-control" value="<?php echo htmlspecialchars($usuario['telefono']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="username">Nombre de Usuario:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                </div>
                                                <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($usuario['username']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="correo">Correo Electrónico:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                </div>
                                                <input type="email" id="correo" name="correo" class="form-control" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-save"></i> Guardar Cambios
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#editarPerfilForm').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                    url: '../../Controller/perfilController.php?action=update',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Éxito',
                                text: 'Perfil actualizado correctamente.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = 'verPerfil.php';
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Hubo un problema al actualizar el perfil: ' + (response.error || 'Error desconocido'),
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr) {
                        console.log("Error Response Text:", xhr.responseText);
                        Swal.fire({
                            title: 'Error',
                            text: 'Hubo un problema al comunicarse con el servidor.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });

            });
        });
    </script>
</body>

</html>