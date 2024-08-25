<?php
    include_once '../../Controller/login_Controller.php';

    if(session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    function head(){
        echo'
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>FindMyPet!</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
            <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
            <link rel="stylesheet" href="../dist/css/adminlte.min.css">
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">
            <link rel="stylesheet" href="../dist/css/styles.css">
            <script src="../dist/js/script.js"></script>
        </head>'
    ;}


    function MostrarMenu()
    {
        if(isset($_SESSION["id_rol"]) && $_SESSION["id_rol"] == 1 || $_SESSION["id_rol"] == 3) 
        {
         echo '
            <aside class="main-sidebar elevation-4">
                <a href="../home/home.php" class="brand-link">
                    <img src="../dist/img/Logo.png"
                        alt="FindMyPet! Logo" width="35" height="35"
                        class="brand-image img-circle elevation-3"
                        style="opacity: .8">
                    <span class="brand-text text-white-custom"><strong>FindMyPet!</strong></span>
                </a>
        
                <div class="sidebar">
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i>
                                        <img src="../dist/img/Animales.png"
                                        alt="Animales" width="25" height="25">
                                    </i>
                                    <p class="text-white-custom">
                                        Animales
                                    <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                        <p class="text-white-custom">Ver todas las mascotas</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../animales/adoptarAnimalito.php" class="nav-link">
                                        <p class="text-white-custom">Adoptar un animalito</p>
                                        </a>
                                    </li>
                                
                                </ul>
                            </li>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i>
                                        <img src="../dist/img/Productos.png"
                                        alt="Productos" width="25" height="25">
                                    </i>
                                    <p class="text-white-custom">
                                        Productos
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../productos/verProductos.php" class="nav-link">
                                            <p class="text-white-custom">Ver productos</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../productos/productoCrear.php" class="nav-link">
                                            <p class="text-white-custom">Publicar un producto</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <p class="text-white-custom">Eliminar un producto</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i>
                                        <img src="../dist/img/PublicarAnimal.png"
                                        alt="PublicarAnimal" width="25" height="25">
                                    </i>
                                    <p class="text-white-custom">
                                    Publicar un animal
                                    <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../animales/carnetCrear.php" class="nav-link">
                                            <p class="text-white-custom">Publicar un animal</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../animales/carnetEliminar.php" class="nav-link">
                                            <p class="text-white-custom">Eliminar una publicación</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="text-white-custom">
                                <a href="../donaciones/donacion.php" class="nav-link">
                                    <i>
                                        <img src="../dist/img/Donar.png"
                                        alt="Donar" width="25" height="25">
                                    </i>
                                    <p class="text-white-custom">
                                        Realizar una donación
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                            </li>';
                            if($_SESSION["id_rol"] == 1) 
                            {
                            echo '
                            <li class="nav-item has-treeview">
                                <a href="../admin/verUsuarios.php" class="nav-link">
                                    <i>
                                        <img src="../dist/img/administrador.png"
                                        alt="Usuarios" width="25" height="25">
                                    </i>
                                    <p class="text-white-custom">
                                    Ver usuarios
                                    </p>
                                </a>
                            </li>';
                            }
                        echo'
                        </ul>
                    </nav>
                </div>
            </aside>
            ';
        }
        else 
        {
         echo '
            <aside class="main-sidebar elevation-4">
                <a href="../home/home.php" class="brand-link">
                    <img src="../dist/img/Logo.png"
                        alt="FindMyPet! Logo" width="35" height="35"
                        class="brand-image img-circle elevation-3"
                        style="opacity: .8">
                    <span class="brand-text text-white-custom"><strong>FindMyPet!</strong></span>
                </a>
        
                <div class="sidebar">
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i>
                                        <img src="../dist/img/Animales.png"
                                        alt="Animales" width="25" height="25">
                                    </i>
                                    <p class="text-white-custom">
                                        Animales
                                    <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                        <p class="text-white-custom">Ver todas las mascotas</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../animales/adoptarAnimalito.php" class="nav-link">
                                        <p class="text-white-custom">Adoptar un animalito</p>
                                        </a>
                                    </li>
                                
                                </ul>
                            </li>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i>
                                        <img src="../dist/img/Productos.png"
                                        alt="Productos" width="25" height="25">
                                    </i>
                                    <p class="text-white-custom">
                                        Productos
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../productos/verProductos.php" class="nav-link">
                                            <p class="text-white-custom">Ver productos</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="text-white-custom">
                                <a href="../donaciones/donacion.php" class="nav-link">
                                    <i>
                                        <img src="../dist/img/Donar.png"
                                        alt="Donar" width="25" height="25">
                                    </i>
                                    <p class="text-white-custom">
                                        Realizar una donación
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>
            ';
        }
    }

    function MostrarNav()
    {
        echo '
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            </ul>
        
            <form class="form-inline ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
                </div>
            </div>
            </form>';
            if(($_SESSION['username']))
            {
            echo '
            <ul class="navbar-nav ml-auto">
                <div class="form-inline ml-3 d-flex align-items-center">
                    <span class="mr-2">' . htmlspecialchars($_SESSION["username"]) . '</span>
                    <a href="../auth/logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
                </ul>
                '; 
                
            }
            else
            {
            echo '

                <ul class="navbar-nav ml-auto">
                <div class="form-inline ml-3"></div>
                <a href="../auth/login.php">
                    <i class="far fa-user"></i>
                </a>
                </ul>
                ';  
            }
        echo'
        </nav>
      ';
    }

?>