<?php include_once 'layout.php'; ?>

<!DOCTYPE html>
<html>
<?php head(); ?>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php MostrarNav(); ?>
        <?php MostrarMenu(); ?>

        <div class="content-wrapper">
            <section class="content">
                <div class="titulo-generico">
                    <p>Apoya a FindMyPet!</p>
                </div>

                <form action="donacion.php" method="post" enctype="multipart/form-data" class="form-donacion">

                    <div class="form-group">
                        <input type="text" name="nombre" placeholder="Nombre Completo" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="identificacion" placeholder="Identificación" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="telefono" placeholder="Número de teléfono" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <div>Elige un archivo a subir</div>
                        <input type="file" name="archivo" id="archivo" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="btnEnviar" class="btn-custom1">Enviar</button>
                    </div>

                </form>
            </section>
        </div>
    </div>

    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>



</body>

</html>