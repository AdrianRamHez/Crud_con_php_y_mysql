<?php

$sevidor = "mysql:dbname=bdempresa; host=localhost";
$usuario = "root";
$password = "123456";

try {
    $pdo = new PDO($sevidor, $usuario, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
    //echo "Conectado...";
} catch (PDOException $e) {
    echo "Conexion mala :( ".$e->getMessage();
}

?>