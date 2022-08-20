<?php
require_once 'config/database.php';
require_once 'config/config.php';
require_once 'layout/header.php';
?>
<?php
if (isset($_SESSION['usuario-adm'])) :
    $consulta="SELECT * FROM compra";
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
                    <th scope="col">Estado</th>
                    <th scope="col">id</th>
                    <th scope="col">id Transacción</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Status</th>
                    <th scope="col">Email</th>
                    <th scope="col">id Cliente</th>
                    <th scope="col">Dirección</th>
                    <th scope="col">Ciudad</th>
                    <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($query as $row): 
    
            ?>
                <tr>
                    <td> <input type="checkbox" id="check">Completado</td>
                    <td><?=$row['id']?></td>
                    <td><?=$row['id_transaccion']?></td>
                    <td><?=$row['fecha']?></td>
                    <td><?=$row['status']?></td>
                    <td><?=$row['email']?></td>
                    <td><?=$row['id_cliente']?></td>
                    <td><?=$row['direccion']?></td>
                    <td><?=$row['ciudad']?></td>
                    <td><?=$row['total']?></td>

                    <td>
                        <a href="detalle-compra.php?id=<?=$row['id']?>" class="btn btn-primary">Detalle Compra</a>
                    </td>
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