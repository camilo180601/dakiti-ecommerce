<?php
require 'config/config.php';
require 'config/database.php';
include 'layout/header.php';
?>

    <?php
        if(isset($_SESSION['usuario-adm'])){
            header("Location: administrar.php");
        }
    ?>
    <div class="container">

        <br>
        <?php if(isset($_SESSION['error_login'])): ?>
        <div class="alert alert-danger">
            <?=$_SESSION['error_login']?>
        </div>
        <?php endif; ?>
        <br>

        <h1 class="text-center">Administrador/a Dakiti</h1>
        <form action="validar-datos.php" method="post">

            <div class="mb-3">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" class="form-control" name="correo" id="correo" aria-describedby="helpId" placeholder="Escriba su correo">

            </div>

            <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="Escriba su contraseña">

            </div>

            <input type="submit" value="Entrar" class="btn btn-success">

        </form>
    </div>
<?php
include 'layout/footer.php';
?>
