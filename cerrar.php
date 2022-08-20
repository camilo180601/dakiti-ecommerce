<?php
    session_start();
    if(isset($_SESSION['usuario-adm'])){
        session_destroy();
    }
    header('Location: index.php');
    
?>