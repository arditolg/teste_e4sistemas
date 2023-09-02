<?php
session_start(); // Inicie a sessão

// Verifique se a variável de sessão de ID do usuário logado está definida

if (!isset($_SESSION["idUsuarioLogado"])) {
    // Se não estiver logado, redirecione para a página de login
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
</head>
<body>
    <?php
    // Inclua o arquivo de conexão com o banco de dados
    require_once("conexao.php");

    // Verifique se o ID do usuário foi passado via GET
    if (isset($_GET["id"])) {
        $idUsuario = $_GET["id"];

        // Consulta SQL para obter os dados do usuário pelo ID
        $sql = "SELECT nome, email, usuario, senha, status FROM usuario WHERE id = $idUsuario";
        $result = $conexao->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            // Recupere os valores dos campos
            $nome = $row["nome"];
            $email = $row["email"];
            $usuario = $row["usuario"];
            $senha = $row["senha"];
            $status = $row["status"];
        } else {
            echo "Usuário não encontrado.";
            exit();
        }
    } else {
        echo "ID do usuário não especificado.";
        exit();
    }
    ?>

    <h2>Editar Usuário</h2>
    <form action="atualizar_usuario.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $idUsuario; ?>">

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $nome; ?>"><br>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="<?php echo $email; ?>"><br>

        <label for="usuario">Usuário:</label>
        <input type="text" id="usuario" name="usuario" value="<?php echo $usuario; ?>"><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" value="<?php echo $senha; ?>"><br>

        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="ativo" <?php echo ($status == 'ativo') ? 'selected' : ''; ?>>Ativo</option>
            <option value="inativo" <?php echo ($status == 'inativo') ? 'selected' : ''; ?>>Inativo</option>
        </select><br>

        <input type="submit" value="Salvar Alterações">
    </form>

    <?php
    // Feche a conexão com o banco de dados
    $conexao->close();
    ?>
</body>
</html>
