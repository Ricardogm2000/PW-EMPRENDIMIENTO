<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Audio Tours EC</title>

    <!-- Google fonts -->
    <link href='http://fonts.googleapis.com/css?family=Raleway:300,500,800|Old+Standard+TT' rel='stylesheet'
        type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:300,500,800' rel='stylesheet' type='text/css'>
    <!-- Incluye la última versión de Font Awesome en tu archivo HTML principal (por ejemplo, header.php o index.php) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- font awesome -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- bootstrap -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />

    <!-- uniform -->
    <link type="text/css" rel="stylesheet" href="assets/uniform/css/uniform.default.min.css" />

    <!-- animate.css -->
    <link rel="stylesheet" href="assets/wow/animate.css" />

    <!-- gallery -->
    <link rel="stylesheet" href="assets/gallery/blueimp-gallery.min.css">

    <!-- favicon -->
    <link rel="shortcut icon" href="images/LOGO ECUA.png" type="image/x-icon">
    <link rel="icon" href="images/LOGO ECUA.png" type="image/x-icon">

    <link rel="stylesheet" href="assets/style.css">

    <style>
    /* Estilos adicionales para mejorar el diseño */
    .navbar-brand img {
        display: inline-block;
        vertical-align: middle;
    }

    .navbar-text {
        display: inline-block;
        vertical-align: middle;
        font-size: 1.0em;
        margin-left: 10px;
        color: #fff;
    }


    #cart-count {
        background-color: #ff0000;
        color: #fff;
        font-size: 0.9em;
        padding: 3px 7px;
        border-radius: 50%;
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .animate {
        animation: bounce 0.5s;
    }

    /* Estilos adicionales para mejorar el diseño */
    .navbar-nav>li>a {
        font-size: 1.2em;
        padding: 15px 20px;
        color: #fff;
        font-weight: bold; /* Añadido para negrita */

    }

    .navbar-nav>li>a:hover {
        background-color: #f8f8f8;
        color: #fff;
    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }
    </style>

</head>

<body id="home">

    <!-- header -->
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">
                    <img src="images/LOGO ECUA.png" width="70" height="70" alt="holiday crown">

                    <span class="navbar-text">Audio Tours Ecuador</span>


                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="rooms-tariff.php">¿Quiénes Somos?</a></li>
                    <li><a href="introduction.php">Aliados Estratégicos</a></li>
                    <li><a href="audioguias.php">Audioguías</a></li>
                    <li><a href="contact.php">Contacto</a></li>
                    <li>
                        <a href="carrito.php">
                            <i class="fa fa-shopping-cart"></i>
                            <span id="cart-count" class="badge">0</span>
                        </a>
                    </li>
                </ul>
            </div><!-- navbar-collapse -->
        </div><!-- container-fluid -->
    </nav>
    <!-- header -->

    <script>
    document.addEventListener('DOMContentLoaded', (event) => {
        // Inicializa el contador del carrito desde localStorage
        let cartCount = parseInt(localStorage.getItem('cartCount')) || 0;

        // Función para actualizar el contador del carrito
        function updateCartCount(newCount) {
            cartCount = newCount;
            const cartCountElement = document.getElementById('cart-count');
            if (cartCountElement) {
                cartCountElement.textContent = cartCount;

                // Añade animación para el contador
                cartCountElement.classList.add('animate');
                setTimeout(() => {
                    cartCountElement.classList.remove('animate');
                }, 1000); // Duración de la animación
            }
        }

        // Inicializa el contador en el encabezado
        updateCartCount(cartCount);
    });
    </script>