<?php
require_once 'config/database.php';
require_once 'config/config.php';
require_once 'layout/header.php';
?>
<?php
if (isset($_SESSION['usuario-adm'])) :
    $consulta="SELECT * FROM productos";
    $query = mysqli_query($db, $consulta);
    $array = mysqli_fetch_array($query);
?>
    <br>
    <div class="container">
        <div class="row">

            <div class="welcome">
                <h1>Bienvenido/a <?= $_SESSION['usuario-adm']['nombre'] ?></h1> 

                <a href="cerrar.php" class="btn btn-danger">Cerrar Sesión</a>
                <a href="compras.php" class="btn btn-primary">Gestionar Compras</a>
                
                
            </div>

        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Descuento</th>
                    <th scope="col">Cantidad-Stock</th>
                    <th><a href="crear-producto.php" class="btn btn-primary">Agregar Producto</a> </th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($query as $row): 
                $imagen = "images/productos/" .$row['id']. "/principal.jpg";
                if(!file_exists($imagen)){
                    $imagen = "images/no-photo.jpg";
                }
            ?>
                <tr>
                    
                    <td><?=$row['id']?></td>
                    <td><img class="img-thumbnail img-fluid" width="100" src="<?php echo $imagen; ?>" alt="Principal.jpg"></td>
                    <td><?=$row['nombre']?></td>
                    <td><?=$row['descripcion']?></td>
                    <td><?=$row['precio']?></td>
                    <td><?=$row['descuento']?></td>
                    <td><?=$row['cantidad']?></td>
                    <td>
                        <a href="editar-producto.php?id=<?=$row['id']?>" class="btn btn-warning">Editar</a>
                        |
                        <a href="eliminar-producto.php?id=<?=$row['id']?>" class="btn btn-danger">Eliminar</a>
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