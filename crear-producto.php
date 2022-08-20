<?php require_once 'config/database.php'; ?>
<?php require_once 'config/config.php'; ?>

<?php require_once 'layout/header.php'; ?>
<?php


if(isset($_SESSION['usuario-adm'])):
?>
    <div class="container">
        <br>
        <h1 class="titulo-adm">Crear Producto </h1>
        <br>
        <form action="guardar-producto.php" method="POST" class="form-control">
            <div class="mb-3">
            <label for="nombre" >Nombre</label>
            <input class="form-control form-control-lg" type="text" name="nombre" value="">
            </div>
            <br>
            
            <div class="mb-3">
            <label for="descripcion">Descripción</label><br>
            <textarea name="descripcion" cols="170" rows="5"></textarea>
            </div>

            <div class="mb-3">
            <label for="precio">Precio</label>
            <input class="form-control form-control-lg" type="number" name="precio" value="">
            </div>

            <div class="mb-3">
            <label for="descuento" >Descuento</label>
            <input class="form-control form-control-lg" type="number" name="descuento" value="">
            </div>

            <div class="mb-3">
            <label for="cantidad">Cantidad</label>
            <input class="form-control form-control-lg" type="number" name="cantidad" value="">
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
