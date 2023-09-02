<?php
session_start(); // Inicia a sessão
session_destroy(); // Destrói a sessão atual
header("Location: login.php"); // Redireciona para a página de login (substitua 'login.php' pelo caminho correto)
exit();
?>