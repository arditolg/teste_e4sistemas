<?php
require_once("conexao.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifique se os campos obrigatórios estão definidos
    if (isset($_POST["id_pessoa"], $_POST["nome"], $_POST["email"], $_POST["endereco"], $_POST["telefones"])) {
        $idPessoa = $_POST["id_pessoa"];
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $endereco = $_POST["endereco"];
        $telefonesArray = $_POST["telefones"];

        // Converta a matriz de telefones em JSON
        $telefonesJson = json_encode($telefonesArray);

        // Atualize os dados da pessoa no banco de dados
        $sql = "UPDATE pessoa SET nome=?, email=?, endereco=?, telefones=? WHERE id=?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssssi", $nome, $email, $endereco, $telefonesJson, $idPessoa);

        if ($stmt->execute()) {
            echo "Dados atualizados com sucesso!";

            header("Location: index.php");
            exit();
        } else {
            echo "Erro ao atualizar os dados: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Campos obrigatórios não foram fornecidos.";
    }
} else {
    echo "Acesso inválido ao script.";
}
?>
