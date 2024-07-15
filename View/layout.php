<?php

function head(){
    echo'
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>FindMyPet!</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="dist/css/adminlte.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">
        <link rel="stylesheet" href="../View/dist/CSS/styles.css">
    </head>'
;}

    function MostrarMenu()
    {
      echo '
        <aside class="main-sidebar elevation-4">
            <a href="home.php" class="brand-link">
                <img src="dist/img/Logo.png"
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
                                    <img src="dist/img/Animales.png"
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
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i>
                                    <img src="dist/img/Productos.png"
                                    alt="Productos" width="25" height="25">
                                </i>
                                <p class="text-white-custom">
                                    Productos
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <p class="text-white-custom">Ver productos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
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
                                    <img src="dist/img/PublicarAnimal.png"
                                    alt="PublicarAnimal" width="25" height="25">
                                </i>
                                <p class="text-white-custom">
                                Publicar un animal
                                <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <p class="text-white-custom">Publicar un animal</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <p class="text-white-custom">Eliminar una publicación</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="text-white-custom">
                            <a href="#" class="nav-link">
                                <i>
                                    <img src="dist/img/Donar.png"
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
            </form>
        
            <ul class="navbar-nav ml-auto">
             <div class="form-inline ml-3"></div>
            <a href="login.php">
                <i class="far fa-user"></i>
            </a>
            </ul>
        
        </nav>
      ';
    }

    function CrudPosts(){
        echo '
            <div class="container">
                <h1>CRUD de Publicaciones</h1>

                <form id="publicationForm">
                    <input type="hidden" id="publicationId">
                    <div>
                        <label for="title">Título</label>
                        <input type="text" id="title" required>
                    </div>
                    <div>
                        <label for="description">Descripción</label>
                        <textarea id="description" required></textarea>
                    </div>
                    <div>
                        <label for="image">Imagen</label>
                        <input type="file" id="image" accept="image/*" required>
                    </div>
                    <button type="submit" id="saveBtn">Guardar</button>
                </form>
            </div>';
    }

?>