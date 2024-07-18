<?php
include_once 'layout.php';
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
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Ejemplo de Título</td>
                            <td>Ejemplo de Descripción</td>
                            <td>Ejemplo de Ubicación</td>
                            <td><img src="ruta/a/la/imagen.jpg" alt="Imagen" class="thumbnail"></td>
                            <td>
                                <button class="btn btn-edit">Editar</button>
                                <button class="btn btn-delete">Borrar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            </section>
        </div>

    </div>

    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
</body>

</html>