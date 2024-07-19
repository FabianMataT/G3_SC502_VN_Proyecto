<?php
include_once 'layout.php';
include_once '../Controller/login_Controller.php';
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
            <section class="content_login">
                <div class="contenedor-imagen">
                    <img class="imagen" src="https://us.123rf.com/450wm/photodeti/photodeti1807/photodeti180700124/104281525-pembroke-welsh-corgi-cachorro-y-gatito-atigrado-se-miran-en-un-c%C3%A9sped-de-verano.jpg?ver=6" alt="login" width="700px" height="600px" />
                </div>
                <div class="container-login">
                    <form action="" method="post">
                        <h1 style="text-align:center;">Crear Carnet Animal</h1>
                        <div class="input-group mb-3">
                            <input type="hidden" id="publicationId">
                            <div>
                                <label for="name">Nombre de mascota</label>
                                <input type="text" id="name" required>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <div>
                                <label for="raza">Raza</label>
                                <input type="text" id="raza" required>
                            </div>
                        </div>
                        <div>
                            <label for="estado">Estado de la mascota</label>
                            <textarea type="text" id="estado" required></textarea>
                        </div>
                        <div class="input-group mb-3">
                            <div>
                                <label for="año">Año de rescate de la mascota</label>
                                <textarea type="text" id="año" required></textarea>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <div>
                                <label for="description">Descripción</label>
                                <textarea id="description" required></textarea>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <div>
                                <label for="image">Imagen</label>
                                <input type="file" id="image" accept="image/*">
                            </div>
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