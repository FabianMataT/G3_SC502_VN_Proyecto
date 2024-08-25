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
                <h1>Lista de Carnets</h1>
                <table id="publicationTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Estado</th>
                            <th>Nombre</th>
                            <th>Raza</th>
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

    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>
</body>

<script>
    // Espera a que el documento esté listo para ejecutar el código
    $(document).ready(function () {
        var estados = {}; // Objeto para almacenar la descripción de los estados

        // Solicita los estados disponibles desde el servidor
        $.getJSON("/G3_SC502_VN_Proyecto/app/Controller/CarnetController.php?action=IDEstado", function (data) {
            // Al recibir la respuesta, almacena la descripción de cada estado en el objeto 'estados'
            data.forEach(function (estado) {
                estados[estado.id_estado] = estado.nombre_estado; // Mapea el ID del estado a su nombre
            });
            // Una vez que los estados se han cargado, llama a la función para cargar la tabla de productos
            CargarTabla();
        }).fail(function (xhr, status, error) {
            // En caso de error, muestra un mensaje en la consola
            console.error('Error al cargar los estados:', xhr.responseText);
        });

        // Función para cargar la tabla con los carnets
        function CargarTabla() {
            // Solicita los datos de todos los carnets desde el servidor
            $.getJSON("/G3_SC502_VN_Proyecto/app/Controller/CarnetController.php?action=Todos", function (datos) {
                var contenido = ''; // Variable para acumular el HTML de la tabla
                for (var i = 0; i < datos.length; i++) {
                    // Obtiene la descripción del estado para cada carnet
                    var estadoDescripcion = estados[datos[i].id_estado] || 'Desconocido';
                    // Construye una fila de tabla con los datos del carnet
                    contenido += '<tr>' +
                        '<td>' + datos[i].id_carnet + '</td>' +
                        '<td>' + estadoDescripcion + '</td>' + // Muestra la descripción del estado
                        '<td>' + datos[i].nombre_animal + '</td>' +
                        '<td>' + datos[i].raza + '</td>' +
                        '<td><img src="' + datos[i].imagen + '" width="100"></td>' +
                        '<td>' +
                        '<button type="button" class="btn btn-danger cambiar-btn" data-id_carnet="' + datos[i].id_carnet + '" data-row=\'' + JSON.stringify(datos[i]) + '\'>Eliminar</button>' +
                        '</td>' +
                        '</tr>';
                }
                // Inserta el contenido generado en el cuerpo de la tabla
                $("#tablaProductos").html(contenido);
            }).fail(function (xhr, status, error) {
                // En caso de error, muestra un mensaje en la consola
                console.error('Error al cargar los productos:', xhr.responseText);
            });
        }

        // Evento para abrir el modal de eliminación cuando se hace clic en un botón de eliminar
        $(document).on("click", ".btn-danger.cambiar-btn", function () {
            var id = $(this).data("id_carnet");
            var nombre_animal = $(this).data("row").nombre_animal;
            // Actualiza el texto del modal con el nombre del animal que se va a eliminar
            $("#modalver").text("¿Desea eliminar el carnet '" + nombre_animal + "'?");
            // Guarda el ID del carnet en el botón del modal para usarlo más tarde
            $("#btnEstadoD").data("id", id);
            // Muestra el modal de eliminación
            $("#ModalDesactivar").modal("show");
        });

        // Evento para eliminar un carnet cuando se hace clic en el botón del modal
        $("#btnEstadoD").click(function () {
            var idCarnet = $(this).data("id");
            // Envía una solicitud POST para eliminar el carnet
            $.ajax({
                type: "POST",
                url: "/G3_SC502_VN_Proyecto/app/Controller/CarnetController.php",
                data: {
                    action: "Eliminar",
                    id_carnet: idCarnet,
                    estado: 0 // Cambia el estado del carnet a 0 (desactivado)
                },
                success: function (response) {
                    if (response.success) {
                        // Si la eliminación es exitosa, recarga la tabla y cierra el modal
                        CargarTabla();
                        $('#ModalDesactivar').modal('hide');
                    } else {
                        // Muestra un mensaje de error si la eliminación falla
                        alert("Error al eliminar el producto: " + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    // Muestra un mensaje de error en la consola en caso de fallo de la solicitud
                    console.error("Error al eliminar el producto:", xhr.responseText);
                }
            });
        });
    });
</script>


</html>