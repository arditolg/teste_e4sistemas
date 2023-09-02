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
    <title>Menu Dinâmico</title>
    <style>
        /* Estilos para o menu (mantidos como antes) */
        .menu ul {
            list-style: none;
            padding: 0;
        }

        .menu ul li {
            display: inline-block;
            position: relative;
        }

        .menu ul li a {
            display: block;
            padding: 10px 20px;
            text-decoration: none;
        }

        .menu ul li ul {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
        }

        .menu ul li:hover ul {
            display: block;
        }

        .menu ul li ul li {
            display: block;
        }

        /* Estilos para a div de conteúdo */
        #conteudo {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="menu">
        <ul>
            <li>
                <a href="logout.php">Logout</a>
            </li>
            <li>
                <a href="#">Usuários</a>
                <ul>
                    <li><a href="list_usuario.php" class="link-conteudo">Listagem de Usuários</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Pessoa</a>
                <ul>
                    <li><a href="list_pessoa.php" class="link-conteudo">Listagem de Pessoas</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <!-- Div para exibir o conteúdo da página -->
    <div id="conteudo">
        <!-- O conteúdo da página será carregado aqui -->
    </div>

    <!-- JavaScript para carregar o conteúdo dinamicamente -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Selecione todos os links com a classe "link-conteudo"
            var links = document.querySelectorAll(".link-conteudo");

            // Adicione um evento de clique a cada link
            links.forEach(function(link) {
                link.addEventListener("click", function(e) {
                    e.preventDefault(); // Evita que o link seja seguido

                    // Carregue o conteúdo da página vinculada na div "conteudo"
                    var url = this.getAttribute("href");
                    carregarConteudo(url);
                });
            });

            // Função para carregar o conteúdo da página na div "conteudo"
            function carregarConteudo(url) {
                var conteudoDiv = document.getElementById("conteudo");

                // Use XMLHttpRequest para carregar a página
                var xhr = new XMLHttpRequest();
                xhr.open("GET", url, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        conteudoDiv.innerHTML = xhr.responseText;
                    }
                };
                xhr.send();
            }
        });
    </script>
</body>
</html>
