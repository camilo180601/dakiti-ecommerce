<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Dakiti</title>
    <link rel="icon" type="image/jpg" href="images/logo.jpg">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link href="css/estilos.css" rel="stylesheet">

    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID; ?>&currency=<?php echo CURRENCY;?>">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <header>

        <div class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a href="index.php" class="navbar-brand ">
                    <strong>Tienda Dakiti</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader"
                    aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarHeader">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="#" class="nav-link active">Catalogo</a>

                        </li>

                        <li class="nav-item">
                            <a href="https://www.instagram.com/dakiti_s/" class="nav-link">Contacto</a>

                        </li>

                        <li class="nav-item">
                            <a href="nosotros.php" class="nav-link">Nosotros</a>
                        </li>
                    </ul>

                    <a href="checkout.php" class="btn btn-primary">
                        Carrito<span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
                    </a>

                </div>
            </div>
        </div>
    </header>
