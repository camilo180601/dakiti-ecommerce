<?php
require '../config/config.php';
require '../config/database.php';


if(isset($_POST['id'])){

    $db = new Database();
    $cantdetail = isset($_POST['cantdetail']) ? $_POST['cantdetail'] : 1;
    $con = $db->conectar();

    $id= $_POST['id'];
    $token= $_POST['token'];

    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if($token == $token_tmp && $cantdetail > 0 && is_numeric($cantdetail)){

        if($_SESSION['carrito']['productos'][$id]){
            $sql = $con->prepare("SELECT cantidad FROM productos WHERE id=? AND activo=1");
            $sql->execute([$id]);
            $row_prod=$sql->fetch(PDO :: FETCH_ASSOC);
            if($row_prod['cantidad']==$_SESSION['carrito']['productos'][$id]){
                $datos['ok'] = false;
            } else {
                $_SESSION['carrito']['productos'][$id] +=$cantdetail;
            }
            
        } else{
            $_SESSION['carrito']['productos'][$id] = $cantdetail;
        }
        $datos['numero'] = count($_SESSION['carrito']['productos']);
        $datos['ok'] = true;

    } else{
        $datos['ok'] = false;
    }

} else{
    $datos['ok'] = false;
}

echo json_encode($datos);
?>