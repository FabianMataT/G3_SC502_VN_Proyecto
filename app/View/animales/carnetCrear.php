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
                        <input type="hidden" id="publicationId">
                        <div>
                            <label class="text-white" for="nombre_animal">Nombre de mascota</label>
                            <input type="text" id="nombre_animal" name="nombre_animal" required>
                        </div>
                        <div>
                            <label class="text-white" for="raza">Raza</label>
                            <input type="text" id="raza" name="raza" required>
                        </div>
                        <div>
                            <label class="text-white" for="estado">Estado de la mascota</label>
                            <select id="id_estado" name="id_estado" required>
                                <option value="">Seleccione el estado</option>
                                <!-- Las opciones se cargarán dinámicamente con JavaScript -->
                            </select>
                        </div>
                        <div>
                            <label class="text-white" for="anio_rescate">Año de rescate de la mascota</label>
                            <input type="text" id="anio_rescate" name="anio_rescate" required>
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
    <script>
        $(document).ready(function () {
            cargarSelect();

            function cargarSelect() {
                $.ajax({
                    url: '/G3_SC502_VN_Proyecto/app/Controller/CarnetController.php?action=IDEstado',
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response && response.length > 0) {
                            var selectEstado = $('#id_estado');
                            selectEstado.empty();

                            $.each(response, function (index, estado) {
                                var optionText = estado.nombre_estado;
                                var optionValue = estado.id_estado;

                                selectEstado.append($('<option>', {
                                    value: optionValue,
                                    text: optionText
                                }));
                            });
                        } else {
                            alert('No se encontraron estados disponibles.');
                        }
                    },
                    error: function () {
                        alert('Hubo un error al cargar los estados.');
                    }
                });
            }

            $('#saveBtn').on('click', function (e) {
                e.preventDefault();

                var formData = new FormData($('#publicationForm')[0]);

                $.ajax({
                    url: '/G3_SC502_VN_Proyecto/app/Controller/CarnetController.php?action=Crear',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.success) {
                            alert('Carnet creado exitosamente.');
                        } else {
                            alert('Hubo un error al crear el carnet.');
                        }
                    },
                    error: function () {
                        alert('Hubo un error en la solicitud.');
                    }
                });
            });
        });
    </script>
</body>

</html>