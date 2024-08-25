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
                    <h1 class="text-white" style="text-align:center;">Crear Producto</h1>

                    <!-- Cambia de <div> a <form> -->
                    <form id="publicationForm" class="m-5" enctype="multipart/form-data" method="post">
                        <input type="hidden" id="publicationId">
                        <div>
                            <label class="text-white" for="title">Título</label>
                            <input type="text" id="titulo_publi" name="titulo_publi" required>
                        </div>
                        <div>
                            <label class="text-white" for="description">Descripción</label>
                            <textarea id="descripcion" name="descripcion" required></textarea>
                        </div>
                        <div>
                            <label  class="text-white" for="ubicacion">Ubicacion</label>
                            <select class="form-select" aria-label="Default select example" id="id_ubicacion" name="id_ubicacion">
                            </select>
                        </div>
                        <div>
                            <label class="text-white" for="image">Imagen</label>
                            <input class="text-white" type="file" id="image" name="image" required>
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


    <script>
        $(document).ready(function () {
            cargarSelect()
            function cargarSelect(){
                $.ajax({
                    url: '/G3_SC502_VN_Proyecto/app/Controller/ProductoController.php?action=Ubicacion',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // Verificar si la respuesta contiene datos
                        if (response && response.length > 0) {
                            var selectUbicacion = $('#id_ubicacion');
                            // Limpiar el select antes de llenarlo
                            selectUbicacion.empty();

                            // Recorrer cada objeto en la respuesta
                            $.each(response, function(index, ubicacion) {
                                // Crear la opción con el formato "Provincia - Cantón - Distrito"
                                var optionText = ubicacion.provincia + ' - ' + ubicacion.canton + ' - ' + ubicacion.distrito;
                                var optionValue = ubicacion.id_ubicacion;

                                // Agregar la opción al select
                                selectUbicacion.append($('<option>', {
                                    value: optionValue,
                                    text: optionText
                                }));
                            });
                        }
                    },
                    error: function() {
                        alert('Hubo un error al cargar las ubicaciones.');
                    }
                });
            }

            $('#saveBtn').on('click', function(e) {
                e.preventDefault();

                // Crear un FormData object
                var formData = new FormData($('#publicationForm')[0]);

                $.ajax({
                    url: '/G3_SC502_VN_Proyecto/app/Controller/ProductoController.php?action=Crear', // Cambia esto por la URL correcta
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if(response.success) {
                            alert('Producto creado exitosamente.');
                        } else {
                            alert('Hubo un error al crear el producto.');
                        }
                    },
                    error: function() {
                        alert('Hubo un error en la solicitud.');
                    }
                });
            });
        });
    </script>
</body>

</html>