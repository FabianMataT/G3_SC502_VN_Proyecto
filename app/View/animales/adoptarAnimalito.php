<?php include_once '../layout.php'; ?>

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
                    <p>Adopta a un animalito</p>
                </div>

                <div class="containerB">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <br>
                            <br>
                            <div class="text-center">
                                <img src="https://us.123rf.com/450wm/photodeti/photodeti1807/photodeti180700124/104281525-pembroke-welsh-corgi-cachorro-y-gatito-atigrado-se-miran-en-un-c%C3%A9sped-de-verano.jpg?ver=6" alt="Animalito" class="img-fluid">
                                <p id="animalitoNombre" class="texto-animalito">Nombre: Lucy</p>
                                <div class="textarea">
                                    <textarea readonly name="descripcion-animalito" id="descripcion-animalito">Lucy es una adorable cachorra que busca un hogar amoroso.</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-donacion">
                                <form action="#" method="post">
                                    <div class="form-group">
                                        <input type="text" id="nombre" name="nombre" placeholder="Nombre Completo" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" id="email" name="email" placeholder="Correo Electrónico" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="telefono" name="telefono" placeholder="Teléfono" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="direccion" name="direccion" placeholder="Dirección" required>
                                    </div>
                                    <div class="form-group">
                                        <textarea id="mensaje" name="mensaje" rows="4" placeholder="Mensaje" required></textarea>
                                    </div>
                                    <div class="containerB">
                                        <button type="submit" class="btn-custom1">Enviar Solicitud</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </div>

    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>
</body>

</html>