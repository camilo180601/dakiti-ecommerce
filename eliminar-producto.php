<?php
require_once 'config/database.php';

if(isset($_SESSION['usuario-adm']) && isset($_GET['id'])){
	$producto_id = $_GET['id'];
	
	$sql = "DELETE FROM productos WHERE id = $producto_id";
	$borrar = mysqli_query($db, $sql);
	$dir='images/productos/'.$producto_id;
	$files= scandir($dir);
	function borra_dir($dir){
		
		$files= scandir($dir);
		foreach ($files as $file) {
			if($file != '.' && $file != '..'){
				unlink($dir.'/'.$file);
			}
		}
		rmdir($dir);
	}
	borra_dir($dir);
}

header("Location: administrar.php");