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
    <title>Visualizar Pessoa</title>
</head>
<body>
    <h2>Visualizar Pessoa</h2>

    <?php
    require_once("conexao.php");

    $idPessoa = $_GET["id"]; // Supondo que você passe o ID da pessoa pela URL

    // Consulta SQL para buscar os dados da pessoa e o nome do usuário associado
    $sql = "SELECT pessoa.nome, pessoa.email, pessoa.endereco, pessoa.telefones, usuario.nome AS nome_usuario 
            FROM pessoa 
            INNER JOIN usuario ON pessoa.id_usuario = usuario.id 
            WHERE pessoa.id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $idPessoa);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        $nome = $row["nome"];
        $email = $row["email"];
        $endereco = $row["endereco"];
        $telefonesJson = $row["telefones"];
        $nomeUsuario = $row["nome_usuario"];

        // Decodificar o JSON de telefones
        $telefonesArray = json_decode($telefonesJson, true);
    } else {
        echo "Pessoa não encontrada.";
        exit;
    }

    $stmt->close();
    ?>

    <form>
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $nome; ?>" readonly>
        <br><br>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="<?php echo $email; ?>" readonly>
        <br><br>

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" value="<?php echo $endereco; ?>" readonly>
        <br><br>

        <label for="telefones">Telefones:</label>
        <?php
        foreach ($telefonesArray as $telefone) {
            echo '<input type="text" name="telefones[]" value="' . $telefone . '" readonly>';
        }
        ?>
        <br><br>

        <label for="nomeUsuario">Nome do Usuário:</label>
        <input type="text" id="nomeUsuario" name="nomeUsuario" value="<?php echo $nomeUsuario; ?>" readonly>
        <br><br>
    </form>
</body>
</html>
