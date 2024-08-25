<?php include_once '../layout.php'; ?>

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
            <div class="containerVerUsuarios">
                <h1>Lista de Usuarios</h1>
                <table id="usuariosTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Nombre Completo</th>
                            <th>Telefono</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Davix1205</td>
                            <td>David Fronteras Catellon</td>
                            <td>7788-9900</td>
                            <td>Davix500@gmail.com</td>
                            <td>Usuario</td>
                            <td>
                                <button class="btn btn-edit">Editar</button>
                                <button class="btn btn-delete">Borrar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>
</body>

</html>