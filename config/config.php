<?php

define("CLIENT_ID", "Adv8RsgmRtA6iL34RNxUVWGBOkUb9jDGqrUiF8xu3xMLKKOowbBMKID_oapHoITdUch2PX0M4BsPlb4v");
define("CURRENCY", "USD");
define("KEY_TOKEN", "d@kiti-123");
define("MONEDA", "$");

if(!isset($_SESSION)){
    session_start();
}
$num_cart=0;
if(isset($_SESSION['carrito']['productos']))
{
    $num_cart = count($_SESSION['carrito']['productos']);
}
?>
