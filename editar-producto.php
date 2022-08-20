<?php require_once 'config/database.php'; ?>
<?php require_once 'config/config.php'; ?>

<?php require_once 'layout/header.php'; ?>
<?php

    $producto_id = $_GET['id'];
	$consulta="SELECT * FROM productos WHERE id = $producto_id";
    $query = mysqli_query($db, $consulta);
    $productoadm = mysqli_fetch_array($query);
	

if(isset($_SESSION['usuario-adm'])):
?>
    <div class="container">
        <br>
        <h1 class="titulo-adm">Editar Producto: <?=$productoadm['nombre'] ?></h1>
        <br>
        <form action="guardar-producto.php?editar=<?=$productoadm['id']?>" method="POST" class="form-control" enctype="multipart/form-data">
            <div class="mb-3">
            <label for="nombre" >Nombre</label>
            <input class="form-control form-control-lg" type="text" name="nombre" value="<?=$productoadm['nombre']?>">
            </div>
            <br>
            
            <div class="mb-3">
            <label for="descripcion">Descripción</label><br>
            <textarea name="descripcion" cols="170" rows="5"><?=$productoadm['descripcion']?></textarea>
            </div>

            <div class="mb-3">
            <label for="precio">Precio</label>
            <input class="form-control form-control-lg" type="number" name="precio" value="<?=$productoadm['precio']?>">
            </div>

            <div class="mb-3">
            <label for="descuento" >Descuento</label>
            <input class="form-control form-control-lg" type="number" name="descuento" value="<?=$productoadm['descuento']?>">
            </div>

            <div class="mb-3">
            <label for="cantidad">Cantidad</label>
            <input class="form-control form-control-lg" type="number" name="cantidad" value="<?=$productoadm['cantidad']?>">
            </div>

            <div class="mb-3">
            <label for="foto">Foto</label>
            <input class="form-control form-control-lg" type="file" name="foto" >
            </div>


            <div class="mb-3">
            <input class="btn btn-success form-control form-control-lg" type="submit" value="Guardar">
            </div>
        </form>
    </div>
<?php
else:
    header('Location: index.php');
endif;
?>
<?php
    require_once 'layout/footer.php';
?>
