<?php
include_once '../layout.php';
include_once '../../Controller/productoController.php';

if (!isset($_GET['id_producto']) || empty($_GET['id_producto'])) {
    die('ID del producto no proporcionado.');
}

$id_producto = intval($_GET['id_producto']);
$producto = productoController::obtenerProducto($id_producto);

if (!$producto) {
    die('Producto no encontrado.');
}
?>

<!DOCTYPE html>
<html>

<?php
head();
?>

<body class="hold-transition sidebar-mini" style="background-color: #f4f6f9;">
    <div class="wrapper">

        <?php
        MostrarNav();
        MostrarMenu();
        ?>

        <div class="content-wrapper">
            <section class="content">

                <div class="container_producto" style="
                            background-image: url('../dist/img/fondo.jpg'); 
                            background-size: cover; 
                            background-position: center; 
                            padding: 20px; 
                            border-radius: 8px;">
                    <h1 class="text-white" style="text-align:center;">Actualizar Producto</h1>

                    <form id="publicationForm" class="m-5" enctype="multipart/form-data" method="post">
                        <input type="hidden" id="publicationId" name="id_producto" value="<?php echo htmlspecialchars($producto['ID_PRODUCTO']); ?>">
                        <div>
                            <label class="text-white" for="title">Título</label>
                            <input type="text" id="titulo_publi" name="titulo_publi" value="<?php echo htmlspecialchars($producto['TITULO_PUBLI']); ?>" required>
                        </div>
                        <div>
                            <label class="text-white" for="description">Descripción</label>
                            <textarea id="descripcion" name="descripcion" required><?php echo htmlspecialchars($producto['DESCRIPCION']); ?></textarea>
                        </div>
                        <div>
                            <label class="text-white" for="image">Imagen</label>
                            <input class="text-white" type="file" id="image" name="image">
                            <?php if ($producto['IMAGEN']): ?>
                                <img src="/G3_SC502_VN_Proyecto/app/View/subirImg/<?php echo basename($producto['IMAGEN']); ?>" alt="Imagen actual" style="max-width: 100px; max-height: 100px;">
                            <?php endif; ?>
                        </div>
                        <button type="button" class="btn-primary" id="saveBtn">Guardar</button>
                    </form>
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
            $('#saveBtn').on('click', function(e) {
                e.preventDefault();

                var formData = new FormData($('#publicationForm')[0]);

                $.ajax({
                    url: '../../Controller/productoController.php?action=EditarProducto',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        try {
                            var data = JSON.parse(response);
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: data.message,
                                }).then(() => {
                                    window.location.href = 'verProductos.php'; 
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
            });
        });
    </script>
</body>

</html>
