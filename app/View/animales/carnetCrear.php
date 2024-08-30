<?php
include_once '../layout.php';
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
                    <h1 style="text-align:center;" class="text-white">Crear Carnet Animal</h1>

                    <form class="m-5" id="publicationForm" enctype="multipart/form-data" method="post">
                        <div>
                            <label class="text-white" for="nombre_animal">Nombre de mascota</label>
                            <input type="text" id="nombre_animal" name="nombre_animal" required>
                        </div>
                        <div>
                            <label class="text-white" for="raza">Raza</label>
                            <input type="text" id="raza" name="raza" required>
                        </div>
                        <div>
                            <label class="text-white" for="fecha_rescate">Fecha de rescate de la mascota</label>
                            <input type="date" id="fecha_rescate" name="fecha_rescate" required>
                        </div>
                        <div>
                            <label class="text-white" for="descripcion">Descripción</label>
                            <textarea id="descripcion" name="descripcion" required></textarea>
                        </div>
                        <div>
                            <label class="text-white" for="image">Imagen</label>
                            <input class="text-white" type="file" id="image" name="image" required>
                        </div>
                        <button type="button" class="btn-primary rounded-3" id="saveBtn">Guardar</button>
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
                formData.append('action', 'Crear'); // Asegúrate de agregar el campo 'action'

                $.ajax({
                    url: '../../Controller/carnetController.php', // No es necesario pasar action en la URL si lo haces en el formData
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
                                    $('#publicationForm')[0].reset();
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