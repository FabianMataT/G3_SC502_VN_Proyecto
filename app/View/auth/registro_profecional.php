<?php
include_once '../layout.php';
include_once '../../Controller/RegistroController.php';

$Dropdown_Menu_Provincias = registroController::Dropdown_Menu_Provincias();
$Dropdown_Menu_Cantones = registroController::Dropdown_Menu_Cantones(1);
$Dropdown_Menu_Distritos = registroController::Dropdown_Menu_Distritos(1);

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
            <div class="container d-flex justify-content-center">
                <div class="card shadow p-4" style="max-width: 700px; width: 100%;">
                    <form id="publicationUsuario" enctype="multipart/form-data" method="post">
                        <h2 class="text-center">Registro</h2>
                        <label for="nombreCompleto" class="form-label">Tipo de cuenta:</label>
                        <div class="input-group mb-3">
                            <select id="tipoCuenta_profecional" name="tipoCuenta_profecional" class="form-control" required>
                                <option value="profesional">Profesional</option>
                                <option value="usuario">Usuario</option>
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
                        <label for="telefono" class="form-label">Teléfono:</label>
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
                        <label for="empresa" class="form-label">Empresa</label>
                        <div class="input-group mb-3">
                            <input type="text" id="empresa" name="empresa" class="form-control" placeholder="empresa" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-building"></span>
                                </div>
                            </div>
                        </div>
                        <label for="ubicacion" class="form-label">Ubicación</label>
                        <div class="input-group mb-3">
                            <select id="provincia" name="cod_provincia" class="form-control" required>
                                <?php echo $Dropdown_Menu_Provincias; ?>
                            </select>
                            <select id="canton" name="cod_canton" class="form-control" required>
                                <?php echo $Dropdown_Menu_Cantones; ?>
                            </select>
                            <select id="distrito" name="cod_distrito" class="form-control" required>
                                <?php echo $Dropdown_Menu_Distritos; ?>
                            </select>
                            <input type="text" id="otrassenas" name="otrassenas" class="form-control" placeholder="Otras señas">
                        </div>
                        <label for="motivo" class="form-label">¿Por qué quieres tener un perfil "profesional"?</label>
                        <div class="input-group mb-3">
                            <input type="text" id="motivo" name="motivo" class="form-control">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-question"></span>
                                </div>
                            </div>
                        </div>
                        <label for="image" class="form-label">Adjunta la imagen del comprobante (Sinpe por 40mil colones al 8743-8443)</label>
                        <div class="input-group mb-3">
                            <input type="file" id="image" name="image" class="form-control-file">
                        </div>
                        <button type="button" id="saveBtn" class="btn btn-primary btn-block">Registrarse</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const tipoCuenta_profecional = document.getElementById("tipoCuenta_profecional");

        if (tipoCuenta_profecional) {
            tipoCuenta_profecional.addEventListener("change", function() {
                if (this.value === "usuario") {
                    window.location.href = "http://localhost/G3_SC502_VN_Proyecto/app/View/auth/registro.php";
                } else {
                    window.location.href = "http://localhost/G3_SC502_VN_Proyecto/app/View/auth/registro_profecional.php";
                }
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#provincia').change(function() {
                var selectedValue = $(this).val();
                $.ajax({
                    url: '../../Controller/RegistroController.php',
                    type: 'POST',
                    data: {
                        action: 'cargarCanton',
                        codigoProvincia: selectedValue
                    },

                    success: function(response) {
                        $('#canton').html(response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error en la solicitud:', textStatus, errorThrown);
                        alert(errorThrown);
                    }

                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#canton').change(function() {
                var selectedValue = $(this).val();
                $.ajax({
                    url: '../../Controller/RegistroController.php',
                    type: 'POST',
                    data: {
                        action: 'cargarDistrito',
                        codigoCanton: selectedValue
                    },
                    success: function(response) {
                        $('#distrito').html(response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error en la solicitud:', textStatus, errorThrown);
                        alert(errorThrown);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#saveBtn').on('click', function(e) {
                e.preventDefault();

                var formData = new FormData($('#publicationUsuario')[0]);

                $.ajax({
                    url: '../../Controller/RegistroController.php?action=RegistrarUsuarioProfecional',
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