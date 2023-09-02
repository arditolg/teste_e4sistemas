<?php
// Inclua o arquivo de conexão com o banco de dados
require_once("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifique se os campos obrigatórios foram enviados
    if (isset($_POST["id"]) && isset($_POST["nome"]) && isset($_POST["email"]) && isset($_POST["usuario"]) && isset($_POST["status"])) {
        // Receba os dados do formulário
        $id = $_POST["id"];
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $usuario = $_POST["usuario"];
        $status = $_POST["status"];

        // Verifique se a senha foi fornecida
        if (isset($_POST["senha"]) && !empty($_POST["senha"])) {
            // Se a senha foi fornecida, criptografe-a
            $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);
            $sql = "UPDATE usuario SET nome = '$nome', email = '$email', usuario = '$usuario', senha = '$senha', status = '$status' WHERE id = $id";
        } else {
            // Se a senha não foi fornecida, mantenha a senha existente no banco de dados
            $sql = "UPDATE usuario SET nome = '$nome', email = '$email', usuario = '$usuario', status = '$status' WHERE id = $id";
        }

        // Execute a consulta SQL para atualizar os dados do usuário
        if ($conexao->query($sql) === TRUE) {
            echo "Dados do usuário atualizados com sucesso.";

            header("Location: index.php");
            exit();
        } else {
            echo "Erro ao atualizar os dados do usuário: " . $conexao->error;
        }

        // Feche a conexão com o banco de dados
        $conexao->close();
    } else {
        echo "Campos obrigatórios não foram enviados.";
    }
} else {
    echo "Requisição inválida.";
}
?>
