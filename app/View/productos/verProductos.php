<?php
include_once '../layout.php';
?>

<!DOCTYPE html>
<html>

<?php
head();
?>

<body class="hold-transition sidebar-mini">

    <?php
    MostrarNav();
    MostrarMenu();
    ?>

    <div class="wrapper">
        <div class="container">

            <div class="containerVerProductos">
                <h1>Lista de Publicaciones</h1>
                <table id="publicationTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Ubicación</th>
                            <th>Imagen</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaProductos" class="font">

                    </tbody>
                </table>
            </div>

            </section>
        </div>

    </div>

    <!-- Modal Estado Desactivar -->
    <div class="modal fade" id="ModalDesactivar" tabindex="-1" aria-labelledby="ModalDesactivar" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalver">Eliminar </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="btnEstadoD"
                            data-id="ID_DEL_ELEMENTO_PARA_DESACTIVAR">Desactivar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Actualizar Producto -->
    <div class="modal fade" id="ModalAP" tabindex="-1" aria-labelledby="ModalAPLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalAPLabel">Actualizar Producto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="publicationForm" enctype="multipart/form-data" method="post">
                        <input type="hidden" id="publicationId">
                        <div>
                            <label for="title">Título</label>
                            <input type="text" id="titulo_publi" name="titulo_publi" required>
                        </div>
                        <div>
                            <label for="description">Descripción</label>
                            <textarea id="descripcion" name="descripcion" required></textarea>
                        </div>
                        <div>
                            <label for="ubicacion">Ubicacion</label>
                            <select class="form-select" aria-label="Default select example" id="id_ubicacion"
                                name="id_ubicacion">
                            </select>
                        </div>
                        <div>
                            <label for="image">Imagen</label>
                            <input type="file" id="image" name="image" required>
                        </div>
                        <button type="button" class="btn-primary" id="saveBtn">Editar</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>
</body>

<script>
    $(document).ready(function () {
        CargarTabla();

        // Evento para abrir el modal de eliminación
        $(document).on("click", ".btn-danger.cambiar-btn", function () {
            var id = $(this).data("id");
            var nombreProducto = $(this).data("row").titulo_publi; // Obtener el nombre del producto
            console.log("Producto para eliminar con ID:", id, "y nombre:", nombreProducto);

            // Actualizar el contenido del modal con el nombre del producto
            $("#modalver").text("¿Desea eliminar el producto '" + nombreProducto + "'?");
            $("#btnEstadoD").data("id", id); // Actualiza el data-id del botón en el modal
            $("#ModalDesactivar").modal("show"); // Muestra el modal
        });

        // Evento para eliminar producto
        $("#btnEstadoD").click(function () {
            var idProducto = $(this).data("id");
            console.log("Eliminando producto con ID:", idProducto);

            // Hacer la petición AJAX para eliminar el producto
            $.ajax({
                type: "POST",
                url: "/G3_SC502_VN_Proyecto/app/Controller/ProductoController.php",
                data: {
                    action: "Eliminar",
                    id_producto: idProducto,
                    estado: 0 // Cambiar el estado a 0 (desactivado)
                },
                success: function (response) {
                    console.log(response); // Verifica la respuesta del servidor
                    if (response.success) {
                        // Refrescar la tabla después de eliminar
                        CargarTabla();
                        $('#ModalDesactivar').modal('hide'); // Cerrar el modal al eliminar
                    } else {
                        alert("Error al eliminar el producto");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error al eliminar el producto:", xhr.responseText);
                }
            });
        });

        // Evento para abrir el modal de actualización
        $(document).on("click", ".btn-primary.cambiar-btn", function () {
            var id = $(this).data("id");
            var datosProducto = $(this).data("row");
            console.log('Producto para actualizar:', datosProducto);

            // Llenar el formulario con los datos del producto seleccionado
            $("#publicationId").val(datosProducto.id_producto);
            $("#titulo_publi").val(datosProducto.titulo_publi);
            $("#descripcion").val(datosProducto.descripcion);

            $.ajax({
                url: '/G3_SC502_VN_Proyecto/app/Controller/ProductoController.php?action=Ubicacion',
                type: 'get',
                dataType: 'json',
                success: function (ubicaciones) {
                    ubicaciones.forEach(function (ubicacion) {
                        $("#id_ubicacion").append(new Option(
                            `${ubicacion.provincia} - ${ubicacion.canton} - ${ubicacion.distrito}`,
                            ubicacion.id_ubicacion,
                            ubicacion.id_ubicacion === datosProducto.id_ubicacion
                        ));
                    });
                }
            });
            // Llenar el select con las ubicaciones
            $("#id_ubicacion").val(datosProducto.id_ubicacion);

            // En caso de que quieras cargar todas las ubicaciones disponibles


            // Manejo de la imagen actual
            $("#image").val(''); // Deja el campo de la imagen vacío (puedes decidir si quieres mostrar la imagen actual o no)

            $("#ModalAP").modal('show');
        });
    });

    function CargarTabla() {
        $.getJSON("/G3_SC502_VN_Proyecto/app/Controller/ProductoController.php?action=Todos", function (datos) {
            console.log(datos); // Esto te ayudará a ver qué datos están siendo recibidos
            var contenido = '';
            for (var i = 0; i < datos.length; i++) {
                contenido += '<tr>' +
                    '<td>' + datos[i].id_producto + '</td>' +
                    '<td>' + datos[i].titulo_publi + '</td>' +
                    '<td>' + datos[i].descripcion + '</td>' +
                    '<td>' + datos[i].ubicacion_descripcion + '</td>' +  // Mostrar descripción en lugar de ID
                    '<td><img src="' + datos[i].imagen + '" width="100"></td>' +
                    '<td class="text-center">' +
                    '<div class="btn-group" role="group">' +
                    '<button type="button" class="btn btn-primary cambiar-btn mr-2" data-id="' + datos[i].id_producto + '" data-row=\'' + JSON.stringify(datos[i]) + '\'>Actualizar</button>' +
                    '<button type="button" class="btn btn-danger cambiar-btn" data-id="' + datos[i].id_producto + '" data-row=\'' + JSON.stringify(datos[i]) + '\'>Eliminar</button>' +
                    '</div>' +
                    '</td>' +
                    '</tr>';
            }
            $("#tablaProductos").html(contenido);
        }).fail(function (xhr, status, error) {
            console.error('Error al cargar los productos:', xhr.responseText); // Muestra la respuesta completa del servidor
        });
    }



    $("#saveBtn").click(function () {
        var formData = new FormData($("#publicationForm")[0]);
        formData.append('id_producto', $("#publicationId").val());

        $.ajax({
            url: '/G3_SC502_VN_Proyecto/app/Controller/ProductoController.php?action=Actualizar',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                try {
                    // Asegurarse de que la respuesta es un objeto JSON
                    var jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;

                    if (jsonResponse.success) {
                        $('#ModalAP').modal('hide');
                        CargarTabla(); // Refrescar la tabla con los nuevos datos
                    } else {
                        alert("Error al actualizar el producto: " + jsonResponse.message);
                    }
                } catch (e) {
                    console.error("Error al procesar la respuesta del servidor:", e);
                    alert("Error inesperado en la respuesta del servidor.");
                }
            },
            error: function (xhr, status, error) {
                console.error("Error al actualizar el producto:", xhr.responseText);
            }
        });
    });

</script>

</html>