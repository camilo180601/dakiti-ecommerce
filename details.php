<?php
require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if($id == '' || $token == ''){
    echo 'Error al procesar la petición';
    exit;
} else{

    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if($token == $token_tmp){

        $sql = $con->prepare("SELECT count(id) FROM productos WHERE id=? AND activo=1");
        $sql->execute([$id]);
        if($sql->fetchColumn() > 0){
            $sql = $con->prepare("SELECT nombre, descripcion, precio, descuento, cantidad FROM productos WHERE id=? AND activo=1
            LIMIT 1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $nombre = $row['nombre'];
            $descripcion = $row['descripcion'];
            $precio = $row['precio'];
            $descuento = $row['descuento'];
            $cantidad_stock = $row['cantidad'];
            $precio_desc = $precio - (($precio*$descuento)/100);
            $dir_images = 'images/productos/'.$id.'/';

            $rutaImg = $dir_images . 'principal.jpg';
            
            if(!file_exists($rutaImg)){
                $rutaImg = 'images/no-photo.jpg';
            }

            $imagenes = array();
            if(file_exists($dir_images))
            {
                $dir = dir($dir_images);
            
                while(($archivo = $dir->read()) != false){
                    if($archivo != 'principal.jpg' && (strpos($archivo, 'jpg') || strpos($archivo, 'jpeg'))){
                        $imagenes[] = $dir_images . $archivo;
                    }
                }
                $dir->close();
            }
        }
        

    } else{

        echo 'Error al procesar la petición';
        exit;

    }
}

include 'layout/header.php';
?>

<main>
    <div class="container">

        <div class="row">
            <div class="col-md-6 order-md-1">

                <div id="carouselImages" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="<?php echo $rutaImg; ?>" alt="producto" class="d-block w-80">
                        </div>
                        <?php foreach($imagenes as $img) {?>
                        <div class="carousel-item">
                            <img src="<?php echo $img; ?>" alt="producto" class="d-block w-80">
                        </div>
                        <?php } ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselImages"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>



            </div>
            <div class="col-md-6 order-md-2">

                <h2><?php echo $nombre; ?></h2>

                <?php if($descuento > 0) {?>

                <p><del><?php echo MONEDA  . number_format($precio, 2, '.', ','); ?></del></p>

                <h2>
                    <?php echo MONEDA  . number_format($precio_desc, 2, '.', ','); ?>
                    <small class="text-success"> <?php echo $descuento; ?>% descuento</small>
                </h2>

                <?php } else{ ?>


                <h2><?php echo MONEDA  . number_format($precio, 2, '.', ','); ?></h2>

                <?php } ?>

                <p class="lead">
                    <?php echo $descripcion; ?>
                </p>

                <div class="col-3 my-3">
                    <b>Cantidad: </b><input type="number" name="cantdetail" id="cantdetail" min="1"
                        max="<?= $cantidad_stock ?>" value="1">

                </div>

                <div class="d-grid gap-3 col-10 mx-auto">
                    <a href="checkout.php" class="btn btn-primary" id="comprar" type="button"
                        onclick="addProducto(<?php echo $id; ?>, cantdetail.value, '<?php echo $token_tmp; ?>')">Comprar
                        Ahora</a>
                    <button class="btn btn-outline-primary" id="addcar" type="button" data-bs-toggle="modal"
                        data-bs-target="#Modaladv"
                        onclick="addProducto(<?php echo $id; ?>, cantdetail.value, '<?php echo $token_tmp; ?>')">Agregar
                        al Carrito</button>

                </div>

            </div>

        </div>


    </div>

</main>
<div class="modal fade" id="Modaladv" tabindex="-1" aria-labelledby="ModaladvLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModaladvLabel">Alerta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
</script>

<script>   
    
function addProducto(id, cantdetail, token) {
    let url = 'clases/carrito.php'
    let formData = new FormData()
    formData.append('id', id)
    formData.append('cantdetail', cantdetail)
    formData.append('token', token)

    fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors'

        }).then(response => response.json())
        .then(data => {
            if (data.ok) {
                let elemento = document.getElementById("num_cart")
                elemento.innerHTML = data.numero

            }
        })
}

$(function() {
    $('#addcar').click(function() {
        let cant = $('#cantdetail').val()
        $('#modal-body').text('Agregaste '+cant+' unidades del producto <?php echo $nombre ?> al carrito.')
    })
})

$(function() {

$('#cantdetail').on('keyup', function() {
    let max = $(this).attr('max')
    let cant = $(this).val()
    console.log(cant)
    if (cant > parseInt(max, 10)) {
        $(this).val(max)
    }
    if (cant < 0) {
        $(this).val(1)
    }

})
$('#cantdetail').on('blur', function() {
    let cant = $(this).val()
    if (cant == '') {
        $(this).val(1)
    }
})

})
</script>

<!--
        Author: Camilo Lopez
        2022
    -->
</body>
<?php
include 'layout/footer.php';
?>

</html>