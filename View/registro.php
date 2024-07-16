<?php
include_once 'layout.php';
include_once '../Controller/registro_Controller.php';
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
            <section class="content_registro">
                <div class="contenido-imagen">
                    <img class="imagen" src="https://us.123rf.com/450wm/photodeti/photodeti1807/photodeti180700124/104281525-pembroke-welsh-corgi-cachorro-y-gatito-atigrado-se-miran-en-un-c%C3%A9sped-de-verano.jpg?ver=6" alt="alt" width="700px" height="650px" />
                </div>
                <div class="container-registro">
                    <form action="" method="post">
                        <h2 style="text-align:center;">Registro</h2>
                        <label for="nombreCompleto" class="form-label">Tipo de cuenta:</label>
                        <div class="input-group mb-3">
                            <select id="tipoCuenta" name="tipoCuenta" class="form-control" required>
                                <option value="usuario">Usuario</option>
                                <option value="profesional">Profesional</option>
                            </select>
                        </div>
                        <label for="nombreCompleto" class="form-label">Nombre completo:</label>
                        <div class="input-group mb-3">
                            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre" required>
                            <input type="text" id="apellido1" name="apellido1" class="form-control" placeholder="Apellido1">
                            <input type="text" id="apellido2" name="apellido2" class="form-control" placeholder="Apellido2">
                        </div>
                        <label for="nombreUsuario" class="form-label">Nombre de Usuario:</label>
                        <div class="input-group mb-3">
                            <input type="text" id="nombreUsuario" name="nombreUsuario" class="form-control" placeholder="nombre de usuario" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <label for="correo" class="form-label">Teléfono:</label>
                        <div class="input-group mb-3">
                            <input type="number" id="telefono" name="telefono" class="form-control" placeholder="85734589" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-phone"></span>
                                </div>
                            </div>
                        </div>
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
                        <div id="camposUsuario" class="hidden">
                            <label for="empresa" class="form-label">Empresa</label>
                            <div class="input-group mb-3">
                                <input type="text" id="empresa" name="empresa" class="form-control" placeholder="empresa" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                            <label for="motivo" class="form-label">Ubicación</label>
                            <div class="input-group mb-3">
                                <select id="provincia" name="provincia" class="form-control" required>
                                    <option value="san jose">san jose</option>
                                    <option value="cartago">cartago</option>
                                </select>
                                <select id="canton" name="canton" class="form-control" required>
                                    <option value="jose">Central</option>
                                    <option value="tago">cartago</option>
                                </select>
                                <select id="distrito" name="provincia" class="form-control" required>
                                    <option value="df">Safsf</option>
                                    <option value="ctago">Pitahaya</option>
                                </select>
                                <input type="text" id="otrassenas" name="otrassenas" class="form-control" placeholder="Otras señas" required>
                            </div>
                            <label for="motivo" class="form-label">¿Porque quieres tener un perfil "profesional"?</label>
                            <div class="input-group mb-3">
                                <input type="text" id="motivo" name="motivo" class="form-control" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <?php
                        if (isset($_POST["msj"])) {
                            echo '<div class="alert alert-danger">' . $_POST["msj"] . '</div>';
                        }
                        ?>
                        <button type="submit" value="registro" name="btnRegistrarse" class="btn btn-primary">Registrarse</button>
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