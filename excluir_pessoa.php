<?php
require_once("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $idPessoa = $_GET["id"];

        // Execute a consulta SQL para excluir o usuário
        $sql = "DELETE FROM pessoa WHERE id = $idPessoa";

        if ($conexao->query($sql) === TRUE) {
            // Redirecione de volta para a página de lista de usuários após a exclusão
            header("Location: index.php");
            exit();
        } else {
            echo "Erro ao excluir o usuário.";
        }
    }
}
?>
