<?php include_once '../layout.php';
include_once '../../Controller/carnetController.php';
include_once '../../Controller/productoController.php';

$carnets = carnetController::obtenerCarnets();
$productos = productoController::imprimirProductos();
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
            <section class="content">
                <div class="container">
                    <div class="p-5">
                        <div class="text-center">
                            <h1>Productos</h1>
                            <div id="productosCarousel" class="carousel slide mt-4" data-ride="carousel">
                                <div class="carousel-inner" style="background-color: white; padding: 20px; border-radius: 10px;">
                                    <?php foreach ($productos as $index => $producto): ?>
                                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                            <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                                <div class="row" style="max-width: 80%;"> <!-- Limita el ancho máximo -->
                                                    <div class="col-md-4">
                                                        <?php if ($producto['IMAGEN']): ?>
                                                            <img src="/G3_SC502_VN_Proyecto/app/View/subirImg/<?php echo basename($producto['IMAGEN']); ?>" class="d-block w-100" alt="<?php echo htmlspecialchars($producto['TITULO_PUBLI']); ?>" style="object-fit: cover; height: 100%;">
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="card-body text-left">
                                                            <h3 class="card-text"><?php echo htmlspecialchars($producto['TITULO_PUBLI']); ?></h3>
                                                            <p class="card-text">Descripción: <?php echo htmlspecialchars($producto['DESCRIPCION']); ?></p>
                                                            <p class="card-text"><strong>Teléfono: </strong><?php echo htmlspecialchars($producto['TELEFONO']); ?></p>
                                                            <h4 class="card-text">Ubicación:</h4>
                                                            <p class="card-text">Provincia: <?php echo htmlspecialchars($producto['PROVINCIA']); ?></p>
                                                            <p class="card-text">Cantón: <?php echo htmlspecialchars($producto['CANTON']); ?></p>
                                                            <p class="card-text">Distrito: <?php echo htmlspecialchars($producto['DISTRITO']); ?></p>
                                                            <p class="card-text">Otras señas: <?php echo htmlspecialchars($producto['OTRAS_SENAS']); ?></p>
                                                            <?php if ($_SESSION['id_rol'] == 1 || $producto['ID_USUARIO'] == $_SESSION['id_usuario']): ?>
                                                                <a href="../productos/productoActualizar.php?id_producto=<?php echo $producto['ID_PRODUCTO']; ?>" class="btn btn-primary btn-sm">Actualizar</a>
                                                                <a href="#" class="btn btn-danger btn-sm eliminar-producto" data-id="<?php echo $producto['ID_PRODUCTO']; ?>">Eliminar</a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <a class="carousel-control-prev" href="#productosCarousel" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: black;"></span> <!-- Botón anterior en negro -->
                                    <span class="sr-only">Anterior</span>
                                </a>
                                <a class="carousel-control-next" href="#productosCarousel" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: black;"></span> <!-- Botón siguiente en negro -->
                                    <span class="sr-only">Siguiente</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="p-5">
                        <div class="text-center">
                            <h1>Encontrar a tu mascota</h1>
                            <div class="row">
                                <?php foreach ($carnets as $carnet): ?>
                                    <div class="col-md-4">
                                        <div class="card" style="width: 18rem;">
                                            <?php if ($carnet['IMAGEN']): ?>
                                                <img src="/G3_SC502_VN_Proyecto/app/View/subirImg/<?php echo basename($carnet['IMAGEN']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($carnet['NOMBRE_ANIMAL']); ?>" style="object-fit: cover; width: 100%; height: 200px;">
                                            <?php endif; ?>
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo htmlspecialchars($carnet['NOMBRE_ANIMAL']); ?></h5>
                                                <p class="card-text">Raza: <?php echo htmlspecialchars($carnet['RAZA']); ?></p>
                                                <p class="card-text">Fecha de Rescate: <?php echo htmlspecialchars(date('d-m-Y', strtotime($carnet['FECHA_RESCATE']))); ?></p>

                                                <!-- Verificación de permisos para mostrar los botones -->
                                                <?php if ($_SESSION['id_rol'] == 1 || $carnet['ID_USUARIO'] == $_SESSION['id_usuario']): ?>
                                                    <a href="#" class="btn btn-primary btn-sm">Actualizar</a>
                                                    <a href="#" class="btn btn-danger btn-sm">Eliminar</a>
                                                <?php endif; ?>


                                                <a href="#" class="btn btn-info btn-sm">Adoptar</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
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
            $('.eliminar-producto').on('click', function(e) {
                e.preventDefault();
                var id_producto = $(this).data('id'); 
                $.ajax({
                    url: '../../Controller/productoController.php?action=EliminarProducto',
                    type: 'POST',
                    data: { id_producto: id_producto }, 
                    success: function(response) {
                        try {
                            var data = JSON.parse(response);
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: data.message,
                                }).then(() => {
                                    location.reload(); 
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