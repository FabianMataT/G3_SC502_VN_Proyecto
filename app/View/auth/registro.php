<?php
include_once '../layout.php';
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
                    <form id="publicationUsuario" enctype="multipart/form-data" method="post">
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
                        <button type="button" id="saveBtn" class="btn btn-primary">Registrarse</button>
                    </form>
                </div>
            </section>
        </div>
    </div>


    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        $(document).ready(function() {
            $('#saveBtn').on('click', function(e) {
                e.preventDefault();

                var formData = new FormData($('#publicationUsuario')[0]);

                $.ajax({
                    url: '../../Controller/RegistroController.php?action=RegistrarUsuarioNormal',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        try {
                            var data = JSON.parse(response);
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: data.message,
                                }).then(() => {
                                    window.location.href = 'login.php'; 
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message,
                                });
                            }
                        } catch (e) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error de respuesta',
                                text: 'La respuesta no es un JSON válido: ' + response,
                            });
                            console.error("Respuesta del servidor:", response);
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un error en la solicitud.',
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>