<?php
require 'db.php';
session_start(); // Inicia a sessão para verificar se o usuário está logado

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja de Roupas</title>
    <style>
        /* Estilização geral */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Barra superior */
        .top-bar {
            background-color: #3B5998;
            color: white;
            text-align: center;
            padding: 10px;
            font-weight: bold;
        }

        /* Cabeçalho */
        header {
            background-color: #2C3E50;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        .header-title {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .nav-bar {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .nav-bar a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
        }

        .nav-bar a:hover {
            text-decoration: underline;
        }

        /* Conteúdo principal */
        main {
            padding: 20px;
            text-align: center;
        }

        h1 {
            color: #2C3E50;
            font-size: 28px;
        }

        .categories {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .category {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .category img {
            width: 100%;
            border-radius: 10px;
        }

        .category h2 {
            color: #3B5998;
            margin: 15px 0;
        }

        .category button {
            background-color: #3B5998;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        .category button:hover {
            background-color: #2C3E50;
        }

        /* Rodapé */
        footer {
            background-color: #2C3E50;
            color: white;
            text-align: center;
            padding: 120px;
            margin-top: 20px;
            font-size: 20px;
        }
    </style>
</head>
<body>
<div class="top-bar">COMPRE AS MELHORES ROUPAS ONLINE</div>
<header>
    <div class="header-title">A SUA LOJA DE ROUPAS</div>
    <nav class="nav-bar">
        <a href="tenis.php">Tênis</a>
        <a href="camisetas.php">Camisetas</a>
        <a href="bermudas.php">Bermudas</a>
        <a href="sobre.html">Sobre</a>
        <!-- Verifica se o usuário está logado -->
        <?php if (isset($_SESSION['users_id'])): ?>
            <!-- Se o usuário estiver logado, exibe o link de logout -->
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <!-- Caso contrário, exibe o link de login -->
            <a href="login.php">Login</a>
        <?php endif; ?>
        <a href="carrinho.php">Carrinho</a>
        <a href="historico.php">Histórico</a>
    </nav>
</header>
<main>
    <h1>Bem-vindo à Sua Loja de Roupas!</h1>
    <section class="categories">
        <div class="category">
            <img src="https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/475f293b99c74963aca7b77bbf55893a_9366/Tenis_Campus_00s_Preto_JK3370_01_00_standard.jpg" alt="Tênis">
            <h2>Tênis</h2>
            <a href="tenis.php"><button>Comprar</button></a>
        </div>
        <div class="category">
            <img src="https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/d96e4d8390d74711a6990b73efcd1a5c_9366/Camiseta_Adicolor_Oversize_Cinza_IZ2480_01_laydown.jpg" alt="Camisetas">
            <h2>Camisetas</h2>
            <a href="camisetas.php"><button>Comprar</button></a>
        </div>
        <div class="category">
            <img src="https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/9b3e88eeb3d54845b3ae8c616e5f94b8_9366/Shorts_Essential_Tres_Listras_Chelsea_Preto_JE6436_01_laydown.jpg" alt="Bermudas">
            <h2>Bermudas</h2>
            <a href="bermudas.php"><button>Comprar</button></a>
        </div>
    </section>
</main>
<footer>
    <p>© 2024 por A Sua Loja de Roupas.</p>
</footer>
</body>
</html>

