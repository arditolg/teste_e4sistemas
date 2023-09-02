<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuários</title>
    <style>
        .tabela-container {
            background-color: #f2f2f2;
            padding: 20px;
            border: 1px solid #ccc;
        }

        .linha-cinza {
            background-color: #f2f2f2;
        }

        .linha-branca {
            background-color: #fff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th, table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        table th {
            background-color: #333;
            color: #fff;
        }

        a {
            text-decoration: none;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="tabela-container">
        <div class="header">
            <h2 style="float: left;">Lista de Usuários</h2>
            <h2 style="float: right;"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                <style>svg{fill:#333333}</style>
                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM160 152c0-13.3 10.7-24 24-24h88c44.2 0 80 35.8 80 80c0 28-14.4 52.7-36.3 67l34.1 75.1c5.5 12.1 .1 26.3-11.9 31.8s-26.3 .1-31.8-11.9L268.9 288H208v72c0 13.3-10.7 24-24 24s-24-10.7-24-24V264 152zm48 88h64c17.7 0 32-14.3 32-32s-14.3-32-32-32H208v64z"/></svg>
                <a href="cad_usuario.php" style="color: #333;">Cadastrar Usuário</a></h2>
            <div style="clear: both;"></div> <!-- Limpar flutuação -->
        </div>
        <?php
        require_once("conexao.php");

        $sql = "SELECT id, nome, email, status FROM usuario";
        $result = $conexao->query($sql);

        if ($result->num_rows > 0) {
            $classeLinha = "linha-cinza";

            echo "<table>";
            echo "<tr><th>Nome</th><th>Email</th><th>Status</th><th>Ações</th></tr>";

            while ($row = $result->fetch_assoc()) {
                $classeLinha = ($classeLinha == "linha-cinza") ? "linha-branca" : "linha-cinza";
                $idUsuario = $row["id"];

                echo "<tr class='$classeLinha'>";
                echo "<td>" . $row["nome"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["status"] . "</td>";
                echo "<td> <a href='edit_usuario.php?id=" . $row["id"] . "'>
                            <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'>
                            <style>
                                svg{fill:#333333}
                            </style>
                            <path d='M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z'/></svg> 
                      </a>
                      <a href='excluir_usuario.php?id=" . $row["id"] . "'>
                            <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 448 512'>
                            <style>
                                svg{fill:#333333}
                            </style>
                            <path d='M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z'/></svg>  
                        </a>
                        <a href='vis_usuario.php?id=" . $row["id"] . "'>
                            <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'>
                            <style>svg{fill:#333333}</style><path d='M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z'/></svg>
                        </td>";
                

                      
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "Nenhum usuário encontrado.";
        }

        $conexao->close();
        ?>
    </div>
</body>
</html>
