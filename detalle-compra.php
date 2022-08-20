<?php
require_once 'config/database.php';
require_once 'config/config.php';
require_once 'layout/header.php';
?>
<?php
if (isset($_SESSION['usuario-adm'])) :
    $id_compra = $_GET['id'];
    $consulta = "SELECT * FROM detalle_compra WHERE id_compra = $id_compra";
    $query = mysqli_query($db, $consulta);
?>
    <br>
    <div class="container">
        <div class="row">

            <div class="welcome">
                <h1>Bienvenido/a <?= $_SESSION['usuario-adm']['nombre'] ?></h1> 
                <a href="cerrar.php" class="btn btn-danger">Cerrar Sesión</a>
            </div>

        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">id Compra</th>
                    <th scope="col">id Producto</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Cantidad</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($query as $array): 
    
            ?>
                <tr>
                    <td><?=$array['id']?></td>
                    <td><?=$array['id_compra']?></td>
                    <td><?=$array['id_producto']?></td>
                    <td><?=$array['nombre']?></td>
                    <td><?=$array['precio']?></td>
                    <td><?=$array['cantidad']?></td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>

    </div>

<?php
else :
    header('Location: loginadmin.php');

endif;
?>
<?php
require_once 'layout/footer.php'
?>