<?php
include_once 'layout.php';
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

                <div class="container_producto">
                    <h1 style="text-align:center;">Crear Publicacion</h1>

                    <form id="publicationForm">
                        <input type="hidden" id="publicationId">
                        <div>
                            <label for="title">Título</label>
                            <input type="text" id="title" required>
                        </div>
                        <div>
                            <label for="description">Descripción</label>
                            <textarea id="description" required></textarea>
                        </div>
                        <div>
                            <label for="ubicacion">Ubicacion</label>
                            <textarea type="text" id="ubicacion"></textarea>
                        </div>
                        <div>
                            <label for="image">Imagen</label>
                            <input type="file" id="image" accept="image/*" required>
                        </div>
                        <button type="submit" id="saveBtn">Guardar</button>
                    </form>
                </div>

            </section>
        </div>

    </div>

    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
</body>

</html>