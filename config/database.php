<?php
$server = "localhost";
$database = "tienda_dakiti";
$username = "root";
$password = "";

$db = mysqli_connect($server, $username, $password, $database);
mysqli_query($db, "SET NAMES 'utf8'");

if(!isset($_SESSION)){
    session_start();
}

class Database
{
    private $hostname = "localhost";
    private $database = "tienda_dakiti";
    private $username = "root";
    private $password = "";
    private $charset = "utf8";

    function conectar()
    {
        try {
            $conexion = "mysql:host=" . $this->hostname . "; dbname=" . $this->database .";
            charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $pdo = new PDO($conexion, $this->username, $this->password, $options);

            return $pdo;

        } catch (PDOException $e) {
            echo 'Error conexion: ' . $e->getMessage();
            exit;
        }
    }

}

?>
