<?php

if(isset($_POST)){

    require_once 'config/database.php';
    $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db, $_POST['nombre']) : false;
    $descripcion = isset($_POST['descripcion']) ? mysqli_real_escape_string($db, $_POST['descripcion']) : false;
    $precio = isset($_POST['precio']) ? (int)$_POST['precio'] : false;
    $descuento = isset($_POST['descuento']) ? (int)$_POST['descuento'] : false;
    $cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : false;



    if (isset($_FILES)) {
        //Recogemos el archivo enviado por el formulario
        $archivo = $_FILES['foto']['name'];
        
        //Si el archivo contiene algo y es diferente de vacio
        if (isset($archivo) && $archivo != "") {
            //Obtenemos algunos datos necesarios sobre el archivo
            $tipo = $_FILES['foto']['type'];
            $temp = $_FILES['foto']['tmp_name'];
            //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
            if (!((strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")))) {
                header("Location: administrar.php");
            } else {
                //Si la imagen es correcta en tamaño y tipo
                //Se intenta subir al servidor
                $path = "images/productos/".$_GET['editar'];
                if(is_dir($path)){
                    if (move_uploaded_file($temp, 'images/productos/'.$_GET['editar'].'/'. $archivo)) {
                        //Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
                        chmod('images/productos/'.$_GET['editar'].'/'. $archivo, 0777);
            
        
                    } else {
                        //Si no se ha podido subir la imagen, mostramos un mensaje de error
                        header("Location: administrar.php");
                    }
                }else{
                    mkdir($path, 0777, true);
                    if (move_uploaded_file($temp, 'images/productos/'.$_GET['editar'].'/'. $archivo)) {
                        //Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
                        chmod('images/productos/'.$_GET['editar'].'/'. $archivo, 0777);
                    
        
                    } else {
                        //Si no se ha podido subir la imagen, mostramos un mensaje de error
                        header("Location: administrar.php");
                    }

                }
            }
        }
    }



    if (isset($_GET['editar'])) {
        $producto_id = $_GET['editar'];

        $sql = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio=$precio, descuento=$descuento, cantidad=$cantidad " .
            " WHERE id = $producto_id";
    } else {
        $sql = "INSERT INTO productos VALUES(null, '$nombre', '$descripcion', $precio, $descuento, $cantidad, 1, 1);";
    }
    $guardar = mysqli_query($db, $sql);

    header("Location: administrar.php");

}
