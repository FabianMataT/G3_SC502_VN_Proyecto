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

$usuario = $perfilController->ObtenerUsuarioPorID($idUsuario);

?>
<!DOCTYPE html>
<html lang="es">

<?php
head();
?>

<body class="hold-transition sidebar-mini bg-light">
    <div class="wrapper">
        <?php MostrarNav(); ?>
        <?php MostrarMenu(); ?>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Perfil del Usuario</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="username"><i class="fas fa-user"></i> Nombre de Usuario:</label>
                                <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($usuario['username']); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="nombre"><i class="fas fa-user-tag"></i> Nombre:</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="apellido1"><i class="fas fa-user"></i> Apellido 1:</label>
                                <input type="text" id="apellido1" name="apellido1" class="form-control" value="<?php echo htmlspecialchars($usuario['apellido1']); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="apellido2"><i class="fas fa-user"></i> Apellido 2:</label>
                                <input type="text" id="apellido2" name="apellido2" class="form-control" value="<?php echo htmlspecialchars($usuario['apellido2']); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="telefono"><i class="fas fa-phone"></i> Teléfono:</label>
                                <input type="text" id="telefono" name="telefono" class="form-control" value="<?php echo htmlspecialchars($usuario['telefono']); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="rol"><i class="fas fa-user-shield"></i> Rol:</label>
                                <input type="text" id="rol" name="rol" class="form-control" value="<?php echo htmlspecialchars($usuario['rol']); ?>" readonly>
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='editarPerfil.php'">
                                    <i class="fas fa-edit"></i> Editar Perfil
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmarEliminar()">
                                    <i class="fas fa-trash-alt"></i> Eliminar Cuenta
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>
    <script>
        function confirmarEliminar() {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás recuperar esta cuenta!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../../Controller/perfilController.php?action=delete';
                }
            });
        }
    </script>
</body>

</html>