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
                    <img class="imagen" src="https://us.123rf.com/450wm/photodeti/photodeti1807/photodeti180700124/104281525-pembroke-welsh-corgi-cachorro-y-gatito-atigrado-se-miran-en-un-c%C3%A9sped-de-verano.jpg?ver=6" alt="login" width="700px" height="600px"/>
                </div>
                <div class="container-login">
                    <form action="" method="post">
                        <h2 style="text-align:center;">Iniciar Sesión.</h2>
                        <label for="correo" class="form-label">Correo:</label>
                        <div class="input-group mb-3">
                            <input type="email" id="correo" name="correo" class="form-control" placeholder="email@ejemplo.com" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <label for="password" class="form-label">Contraseña:</label>
                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control" id="password" placeholder="contraseña" required="true" />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <?php
                        if (isset($_POST["msj"])) {
                            echo '<div class="alert alert-danger">' . $_POST["msj"] . '</div>';
                        }
                        ?>
                        <div class="mb-3">
                            <a style="color:white;" href="#">¿Olvidaste tu contraseña?</a>
                        </div>
                        <button type="submit" value="Login" name="btnIniciarSesion" class="btn btn-primary">Ingresar</button>
                    </form>
                    <br>
                    <a style="color:white;" href="registro.php">No tienes una cuenta creada?</a>
                    <br>
                    <a href="registro.php" class="btn btn-primary">Registrarse</a>
                </div>
            </section>
        </div>
    </div>

    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>

</body>

</html>