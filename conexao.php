<?php
$servername = "localhost";
$username = "root"; 
$password = "";           
$dbname = "e4sistemas";

$conexao = mysqli_connect($servername, $username, $password, $dbname);

if (!$conexao) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}
?>
