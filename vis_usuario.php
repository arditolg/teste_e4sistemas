<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Visualizar Usuário</title>
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

    <h2>Dados do Usuário</h2>
    <form>
        <label for="nome">Nome:</label>
        <span id="nome"><?php echo $nome; ?></span><br>

        <label for="email">Email:</label>
        <span id="email"><?php echo $email; ?></span><br>

        <label for="usuario">Usuário:</label>
        <span id="usuario"><?php echo $usuario; ?></span><br>

        <label for="senha">Senha:</label>
        <span id="senha">********</span><br>

        <label for="status">Status:</label>
        <span id="status"><?php echo $status; ?></span><br>
    </form>

    <?php
    // Feche a conexão com o banco de dados
    $conexao->close();
    ?>
</body>
</html>
