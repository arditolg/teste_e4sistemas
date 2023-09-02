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

    session_start();

    // Verifique se o ID do usuário está na sessão
    if (isset($_SESSION["idUsuarioLogado"])) {
        // O ID do usuário está na sessão, você pode acessá-lo assim:
        $idUsuarioLogado = $_SESSION["idUsuarioLogado"];
        
        // Agora você pode usar $idUsuarioLogado em suas consultas ou lógica.
    } else {
        // Se o ID do usuário não estiver na sessão, redirecione para a página de login ou tome alguma outra ação.
        header("Location: login.php");
        exit;
    }

    $nome = $email = $endereco = $telefones = "";
    $nomeErr = $emailErr = $enderecoErr = $telefonesErr = "";

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

        if (empty($_POST["endereco"])) {
            $enderecoErr = "O endereço é obrigatório";
        } else {
            $endereco = $_POST["endereco"];
        }

        if (empty($_POST["telefones"])) {
            $telefonesErr = "Pelo menos um telefone é obrigatório";
        } else {
            $telefones = $_POST["telefones"];
        }

        if (empty($nomeErr) && empty($emailErr) && empty($enderecoErr) && empty($telefonesErr)) {
            // Você pode adicionar validações adicionais para o formato dos telefones, se necessário.

            $telefonesArray = explode(",", $telefones); // Transforma a lista de telefones em um array

            // Cria um JSON com os telefones
            $telefonesJson = json_encode($telefonesArray);

            // Substitua 'ID_DO_USUARIO_LOGADO' pelo ID do usuário logado
            $idUsuario = $idUsuarioLogado;

            $sql = "INSERT INTO pessoa (nome, email, endereco, telefones, id_usuario) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("ssssi", $nome, $email, $endereco, $telefonesJson, $idUsuario);

            if ($stmt->execute()) {
                echo "<p>Pessoa cadastrada com sucesso!</p>";

                header("Location: index.php");
                exit();
            } else {
                echo "<p>Erro ao cadastrar a pessoa. Tente novamente.</p>";
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

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco">
        <span class="error"><?php echo $enderecoErr; ?></span><br><br>

        <label for="telefones">Telefones (separe por vírgula):</label>
        <input type="text" id="telefones" name="telefones">
        <span class="error"><?php echo $telefonesErr; ?></span><br><br>

        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>
