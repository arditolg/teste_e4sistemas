<?php
require_once("conexao.php");

$idUsuarioLogado = null;

$usuario = $senha = "";
$usuarioErr = $senhaErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    if (empty($usuarioErr) && empty($senhaErr)) {
        $sql = "SELECT id, senha FROM usuario WHERE usuario = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $senhaHash);
            $stmt->fetch();

            if (password_verify($senha, $senhaHash)) {
                $idUsuarioLogado = $id;
                session_start();
                $_SESSION["idUsuarioLogado"] = $idUsuarioLogado;
                header("Location: index.php");
                exit;
            } else {
                $senhaErr = "Senha incorreta";
            }
        } else {
            $usuarioErr = "Nome de usuário não encontrado";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php
    if (!empty($usuarioErr) || !empty($senhaErr)) {
        echo "<div style='color: red;'>Erro: " . $usuarioErr . " " . $senhaErr . "</div>";
    }
    ?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="usuario">Nome de Usuário:</label>
        <input type="text" id="usuario" name="usuario">
        <br><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha">
        <br><br>

        <input type="submit" value="Entrar">
    </form>
</body>
</html>
