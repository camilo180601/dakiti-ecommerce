<?php

require 'config/config.php';
require 'config/database.php';

$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT id, nombre, precio, descuento FROM productos WHERE activo=1 AND cantidad>0");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
include 'layout/header.php';
?>

<main>
    <div class="container">

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php foreach($resultado as $row) { ?>
            <div class="col">
                <div class="card shadow-sm">
                    <?php

                        $id = $row['id'];
                        $imagen = "images/productos/" .$id. "/principal.jpg";

                        if(!file_exists($imagen)){
                            $imagen = "images/no-photo.jpg";
                        }

                        ?>
                    <img src="<?php echo $imagen; ?>" alt="producto">
                    <div class="card-body">
                        <h5 class="card-title"><b><?php echo $row['nombre']; ?></b></h5>
                        <?php
                        if($row['descuento'] == 0){
                        ?>
                            <br>
                            <h4 class="card-text">$ <?php echo number_format($row['precio'], 2, '.', ','); ?></h4>
                            <br>
            
                        <?php
                        }else{
                            $precio_desc=$row['precio']-(($row['precio']*$row['descuento'])/100);
                        ?>    
                            <p class="card-text"><del>$ <?php echo number_format($row['precio'], 2, '.', ',') ?></del><br><?php echo '<h4> $'.number_format($precio_desc, 2, '.', ',').  '  <span class="text-success"> -' .$row['descuento'].'% </span></h4>'; ?></p>
                        <?php
                        }
                        ?>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="details.php?id=<?php echo $row['id']; ?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>"
                                    class="btn btn-primary">Detalles</a>

                            </div>
                            <button class="btn btn-outline-success" type="button" data-bs-toggle="modal" data-bs-target="#Modaladv"
                                onclick="addProducto(<?php echo $row['id']; ?>, '<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>')">Agregar
                                al
                                Carrito</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="Modaladv" tabindex="-1" aria-labelledby="ModaladvLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModaladvLabel">Alerta</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="modal-body">Agregaste 1 unidad del producto seleccionado</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
</script>

<script>
function addProducto(id, token) {
    let url = 'clases/carrito.php'
    let formData = new FormData()
    formData.append('id', id)
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
</script>
</body>
<?php
include 'layout/footer.php';
?>

</html>