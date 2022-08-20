<?php

require 'config/config.php';
require 'config/database.php';


$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$lista_carrito = array();

if($productos != null){
    foreach($productos as $clave => $cantidad){
        $sql = $con->prepare("SELECT id, nombre, precio, descuento, $cantidad AS cantidad FROM productos WHERE id=? AND activo=1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);

    }
} else {
    header("Location: index.php");
    exit;
}
include 'layout/header.php';
?>

    <main>
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <div class="payment-method--payment-method--header--252Wi">
                        <h2 class="udlite-heading-xl">Metodos de pago</h2>
                        <h2 class="udlite-text-xs  payment-method--secure-connection--1K5Y8">
                            <span >Conexión Segura </span>
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTJE8PJdk-3QHw6ZXUSBMRHLP6RVnchBnn9CQ&usqp=CAU" width="12" height="14" alt="Pago Seguro">
                        </h2>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div id="paypal-button-container"></div>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>SubTotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($lista_carrito == null){
                            echo '<tr><td colspan="5" class="text-center"><b>Lista Vacia</b></td></tr>';
                        } else{

                            $total = 0;
                            foreach($lista_carrito as $producto){
                                $_id = $producto['id'];
                                $nombre = $producto['nombre'];
                                $precio = $producto['precio'];
                                $descuento= $producto['descuento'];
                                $cantidad= $producto['cantidad'];
                                $precio_desc = $precio - (($precio * $descuento) / 100);
                                $subtotal = $cantidad * $precio_desc;
                                $total += $subtotal;

                            ?>


                                <tr>
                                    <td><?php echo $nombre; ?></td>
                                    <td>
                                        <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]">
                                            <?php echo MONEDA . number_format($subtotal, 2, '.', ','); ?></div>
                                    </td>
                                </tr>
                                <?php } ?>

                                <tr>
                                    <td colspan="2">
                                        <p class="h3 text-end" id="total">
                                            <?php echo MONEDA . number_format($total, 2, '.', ','); ?>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <script>
    paypal.Buttons({

        createOrder: (data, actions) => {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: <?php echo $total; ?>
                    }
                }]
            });
        },

        onApprove: (data, actions) => {
            let URL = 'clases/captura.php'
            actions.order.capture().then(function(detalles) {

                console.log(detalles)

                let url = 'clases/captura.php'
                return fetch(url, {
                    method: 'POST',
                    headers: {
                        'content-type': 'application/json'
                    },
                    body: JSON.stringify({
                        detalles: detalles
                    })
                })
                .then(function(response) {
                    window.location.href = "pagocompletado.php?key=" + detalles['id'];
                })
            });
        },

        onCancel: function(data) {
            alert("Pago Cancelado");
            console.log(data);

        }
    }).render('#paypal-button-container');
    </script>
</body>
<?php
include 'layout/footer.php';
?>
</html>