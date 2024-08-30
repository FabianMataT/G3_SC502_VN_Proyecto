<?php
include_once '../layout.php';
include_once '../../Controller/adopcionController.php';


if (isset($_GET['id_adopcion'])) {
    $id_adopcion = intval($_GET['id_adopcion']);
    $solicitud = adopcionController::ObtenerSolicitudAdopcion($id_adopcion);
} else {
    header('Location: animalesEnProceso.php');
    exit;
}

if (!$solicitud) {
    echo "La solicitud no fue encontrada.";
    exit;
}

$solicitud = $solicitud[0];
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
                        <h3 class="card-title">Información de la Solicitud</h3>
                    </div>
                    <div class="card-body">
                        <form id="rechasarSolicitud" method="POST" action="editarRolUsuario.php">
                            <div class="form-group">
                                <label for="username">Nombre del Usuario:</label>
                                <input type="text" class="form-control" id="username" value="<?php echo htmlspecialchars($solicitud['NOMBRE_USUARIO']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono:</label>
                                <input type="text" class="form-control" id="telefono" value="<?php echo htmlspecialchars($solicitud['NUM_TELEFONO']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="email">Correo Electrónico:</label>
                                <input type="text" class="form-control" id="email" value="<?php echo htmlspecialchars($solicitud['CORREO']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="empresa">Nombre del animal:</label>
                                <input type="text" class="form-control" id="empresa" value="<?php echo htmlspecialchars($solicitud['NOMBRE_ANIMAL']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="motivo">Raza:</label>
                                <textarea class="form-control" id="motivo" rows="3" disabled><?php echo htmlspecialchars($solicitud['RAZA']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="motivo">Fecha en la que rescato el animalito:</label>
                                <textarea class="form-control" id="motivo" rows="3" disabled><?php echo htmlspecialchars($solicitud['FECHA_RESCATE']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <?php if ($solicitud['IMAGEN']): ?>
                                    <img src="/G3_SC502_VN_Proyecto/app/View/subirImg/<?php echo basename($solicitud['IMAGEN']); ?>" class="card-img-top" style="object-fit: cover; width: 250px; height: 250px;">
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="motivo">Motivo por el que quiere rescatar el animalito:</label>
                                <textarea class="form-control" id="motivo" rows="3" disabled><?php echo htmlspecialchars($solicitud['MENSAJE']); ?></textarea>
                            </div>
                            <a href="#" class="btn btn-danger btn-sm eliminar-solicitud" data-id="<?php echo $solicitud['ID_ADOPCION']; ?>">Rechazar Solicitud</a>
                            <a href="animalesEnProceso.php" class="btn btn-success">Cancelar</a>
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
        $('.eliminar-solicitud').on('click', function(e) {
            e.preventDefault();  // Evita la acción predeterminada del enlace
            var id_adopcion = $(this).data('id');  // Obtiene el ID de la adopción

            // Mostrar la alerta de confirmación
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡Quieres rechazar esta solicitud de adopción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, rechazar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, envía la solicitud al servidor
                    $.ajax({
                        url: '../../Controller/adopcionController.php?action=EliminarSolicitud',
                        type: 'POST',
                        data: {
                            id_adopcion: id_adopcion  // Envía el ID de la adopción
                        },
                        success: function(response) {
                            try {
                                var data = JSON.parse(response);
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Éxito',
                                        text: data.message,
                                    }).then(() => {
                                        window.location.href = 'animalesEnProceso.php'; 
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: data.message,
                                    });
                                }
                            } catch (e) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error de respuesta',
                                    text: 'La respuesta no es un JSON válido: ' + response,
                                });
                                console.error("Respuesta del servidor:", response);
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Hubo un error en la solicitud.',
                            });
                        }
                    });
                } else {
                    // Si el usuario cancela, simplemente no se hace nada
                    Swal.fire({
                        icon: 'info',
                        title: 'Cancelado',
                        text: 'La solicitud de adopción no fue rechazada.',
                    });
                }
            });
        });
    });
</script>
</body>

</html>