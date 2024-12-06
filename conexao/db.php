<?php
$host = "10.137.174.45";
$user = "suporte";
$pass = "InicioOK2015";
$dbname = "scrap";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Conexão falhou: ' . $conn->connect_error]));
}
?>