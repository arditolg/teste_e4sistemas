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
    <title>Cadastro de Usuário</title>
</head>
<body>
    <h2>Cadastro de Usuário</h2>
    <?php
    require_once("conexao.php");

    $nome = $email = $usuario = $senha = $status = "";
    $nomeErr = $emailErr = $usuarioErr = $senhaErr = $statusErr = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["nome"])) {
            $nomeErr = "O nome é obrigatório";
        } else {
            $nome = $_POST["nome"];
        }

        if (empty($_POST["email"])) {
            $emailErr = "O email é obrigatório";
        } else {
            $email = $_POST["email"];
        }

        if (empty($_POST["usuario"])) {
            $usuarioErr = "O nome de usuário é obrigatório";
        } else {
            $usuario = $_POST["usuario"];
        }

        if (empty($_POST["senha"])) {
            $senhaErr = "A senha é obrigatória";
        } else {
            $senha = $_POST["senha"];
        }

        if (empty($_POST["status"])) {
            $statusErr = "O status é obrigatório";
        } else {
            $status = $_POST["status"];
        }

        if (empty($nomeErr) && empty($emailErr) && empty($usuarioErr) && empty($senhaErr) && empty($statusErr)) {
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuario (nome, email, usuario, senha, status) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("sssss", $nome, $email, $usuario, $senhaHash, $status);

            if ($stmt->execute()) {
                echo "<p>Usuário cadastrado com sucesso!</p>";

                header("Location: index.php");
                exit();
            } else {
                echo "<p>Erro ao cadastrar o usuário. Tente novamente.</p>";
            }

            $stmt->close();
        }
    }
    ?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome">
        <span class="error"><?php echo $nomeErr; ?></span><br><br>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email">
        <span class="error"><?php echo $emailErr; ?></span><br><br>

        <label for="usuario">Nome de Usuário:</label>
        <input type="text" id="usuario" name="usuario">
        <span class="error"><?php echo $usuarioErr; ?></span><br><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha">
        <span class="error"><?php echo $senhaErr; ?></span><br><br>

        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="ativo">Ativo</option>
            <option value="inativo">Inativo</option>
        </select>
        <span class="error"><?php echo $statusErr; ?></span><br><br>

        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>
