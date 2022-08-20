<?php
// Iniciar la sesión y la conexión a bd
require_once 'config/database.php';

// Recoger datos del formulario
if(isset($_POST)){
	
	/*if(isset($_SESSION['error_login'])){
		session_unset($_SESSION['error_login']);
	}*/
			
	// Recoger datos del formulario
	$email = trim($_POST['correo']);
	$password = $_POST['password'];
	
	// Consulta para comprobar las credenciales del usuario
	$sql = "SELECT * FROM usuario_admin WHERE correo = '$email'";
	$login = mysqli_query($db, $sql);

	
	
	if($login && mysqli_num_rows($login) == 1){
		$usuario = mysqli_fetch_assoc($login);
		
		// Comprobar la contraseña
		$verify = password_verify($password, $usuario['password']);
		
		if($verify){
			// Utilizar una sesión para guardar los datos del usuario logueado
			$_SESSION['usuario-adm'] = $usuario;
			header('Location: administrar.php');
			
		}else{
			// Si algo falla enviar una sesión con el fallo
			$_SESSION['error_login'] = "Login incorrecto!";
			header('Location: loginadmin.php');
			
		}
	}else{
		// mensaje de error
		$_SESSION['error_login'] = "Login incorrecto!";
		header('Location: loginadmin.php');
	}
	
}

// Redirigir al index.php
//header('Location: index.php');