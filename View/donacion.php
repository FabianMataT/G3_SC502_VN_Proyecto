<?php include_once 'layout.php'; ?>

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

                <div class="titulo-donacion">
                    <p>Apoya a FindMyPet!</p>
                </div>

                <div class="h2-donacion">
                    <h2>Realiza una donación para contribuir al mantenimiento y correcto funcionamiento de la plataforma</h2>
                </div>

                <div class="h3-donacion">
                    <h3>Podés hacerlo por medio de sinpe al siguiente número: 8888-8888</h3>

                    <h3>Recuerda mandar el comprobante a nuestro whatsapp
                        o subirlo a la plataforma directamente</h3>
                </div>

                <div class="containerB">
                    <a href="formularioDonacion.php" class="btn-custom1">¡Quiero donar!</a>
                </div>
            </section>
        </div>

    </div>

    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
</body>

</html>