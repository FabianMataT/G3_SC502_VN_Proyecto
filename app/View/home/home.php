<?php include_once '../layout.php'; ?>

<!DOCTYPE html>
<html>

<?php
head();
?>

<style>
    .card-img-top {
        object-fit: cover;
        /* Asegura que la imagen cubra el contenedor sin distorsionarse */
        width: 100%;
        /* Ajusta el ancho de la imagen al 100% del contenedor de la tarjeta */
        height: 180px;
        /* Establece una altura fija para todas las imágenes */
    }

    .card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
</style>

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
                        </div>
                        <!-- Contenedor para las tarjetas de productos -->
                        <div id="contenidoProductos" class="row "></div>
                    </div>
                    <div class="p-5">
                        <div class="text-center">
                            <h1>Encontrar a tu mascota</h1>
                        </div>
                        <!-- Contenedor para las tarjetas de productos -->
                        <div id="contenidoCarnet" class="row "></div>
                    </div>
                </div>
            </section>
        </div>


    </div>

    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>

    <script>
        var idToUpdate;

        $(document).ready(function() {
            CargarTabla();
            CargarTablaCarnet();

            $(document).on("click", ".cambiar-btn", function() {
                var id = $(this).data("id");
                console.log("ID seleccionado:", id);
                idToUpdate = id;
            });

            // Aquí irían otros eventos y funciones relacionados con botones o modales, si los necesitas.
        });

        function CargarTabla() {
            $.getJSON("/G3_SC502_VN_Proyecto/app/Controller/ProductoController.php?action=Todos", true, function(datos) {
                console.log(datos); // Esto te ayudará a ver qué datos están siendo recibidos
                var contenido = '';
                for (var i = 0; i < datos.length; i++) {
                    contenido += '<div class="card m-4" style="background-color: #e9eaef;" style="width: 18rem; margin-bottom: 1rem; border-radius: 15px;">' +
                        '<img src="' + datos[i].imagen + '" class="card-img-top" alt="' + datos[i].titulo_publi + '" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">' +
                        '<div class="card-body text-center">' + // Centra el texto dentro del card-body
                        '<h5 class="card-text fw-bold">' + datos[i].titulo_publi + '</h5>' +
                        '<div class="d-flex justify-content-center">' + // Centra el botón horizontalmente
                        '<button type="button" class="btn text-white" style="background-color: #56b125;">Ver información</button>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                }
                $("#contenidoProductos").html(contenido);
            }).fail(function(xhr, status, error) {
                console.error('Error al cargar los productos:', xhr.responseText); // Muestra la respuesta completa del servidor
            });
        }

        function CargarTablaCarnet() {
            $.getJSON("/G3_SC502_VN_Proyecto/app/Controller/CarnetController.php?action=Todos", true, function(datos) {
                console.log(datos); // Esto te ayudará a ver qué datos están siendo recibidos
                var contenido = '';
                for (var i = 0; i < datos.length; i++) {
                    contenido += '<div class="card m-4" style="background-color: #e9eaef;" style="width: 18rem; margin-bottom: 1rem; border-radius: 15px;">' +
                        '<img src="' + datos[i].imagen + '" class="card-img-top" alt="' + datos[i].nombre_animal + '" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">' +
                        '<div class="card-body text-center">' + // Centra el texto dentro del card-body
                        '<h5 class="card-text fw-bold">' + datos[i].nombre_animal + '</h5>' +
                        '<div class="d-flex justify-content-center">' + // Centra el botón horizontalmente
                        '<button type="button" class="btn text-white" style="background-color: #56b125;">Ver información</button>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                }
                $("#contenidoCarnet").html(contenido);
            }).fail(function(xhr, status, error) {
                console.error('Error al cargar los productos:', xhr.responseText); // Muestra la respuesta completa del servidor
            });
        }
    </script>
</body>

</html>