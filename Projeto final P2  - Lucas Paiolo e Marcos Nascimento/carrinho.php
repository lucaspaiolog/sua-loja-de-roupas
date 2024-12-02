<?php
session_start(); // Iniciar sessão para acessar o carrinho

// Verificar se o carrinho está vazio
if (empty($_SESSION['cart'])) {
    $carrinhoVazio = true;
} else {
    $carrinhoVazio = false;
    $cartItems = $_SESSION['cart']; // Itens do carrinho
}

// Se o formulário para remover produto for enviado
if (isset($_POST['remove_from_cart'])) {
    $productId = $_POST['product_id'];
    unset($_SESSION['cart'][$productId]); // Remover o produto do carrinho
    header('Location: carrinho.php'); // Redirecionar para atualizar a página
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
    <style>
        /* Estilização geral */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100%;
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
            padding: 50px 0;
            text-align: center;
        }

        .header-title {
            font-size: 50px;
            margin-bottom: 10px;
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

        .cart-section {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .cart-item {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            width: 80%;
            max-width: 600px;
            margin: 10px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .cart-item img {
            width: 100%;
            max-height: 150px;
            object-fit: contain;
            border-radius: 10px;
        }

        .cart-item h3 {
            color: #3B5998;
            margin: 15px 0;
        }

        .cart-item p {
            color: #777;
        }

        .cart-item strong {
            color: #3B5998;
        }

        .remove-button {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .remove-button:hover {
            background-color: #c0392b;
        }

        .checkout-button {
            background-color: #3B5998;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 20px;
        }

        .index-button {
            background-color: #3B5998;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 20px;
        }


        .checkout-button:hover {
            background-color: #2C3E50;
        }

        /* Rodapé */
        footer {
            background-color: #2C3E50;
            color: white;
            text-align: center;
            padding: 290px;
            margin-top: 20px;
            font-size: 20px;
        }
    </style>
    </style>
</head>
<body>
<div class="top-bar">COMPRE AS MELHORES ROUPAS ONLINE</div>
<header>
    <div class="header-title">Carrinho de Compras</div>
</header>
<main>
    <?php if ($carrinhoVazio): ?>
        <h1>Seu carrinho está vazio!</h1>
        <p>Adicione produtos para continuar suas compras.</p>
        <a href="index.php">
                <button class="index-button">Ir para Página de Compra</button>
            </a>
    <?php else: ?>
        <div class="cart-section">
            <h1>Itens no Carrinho</h1>
            <?php foreach ($cartItems as $productId => $item): ?>
                <div class="cart-item">
                    <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>">
                    <h3><?= $item['name'] ?></h3>
                    <p>Quantidade: <?= $item['quantity'] ?></p>
                    <p><strong>R$ <?= number_format($item['price'], 2, ',', '.') ?></strong></p>
                    <form action="carrinho.php" method="POST">
                        <input type="hidden" name="product_id" value="<?= $productId ?>">
                        <button type="submit" name="remove_from_cart" class="remove-button">Remover do Carrinho</button>
                    </form>
                </div>
            <?php endforeach; ?>
            <a href="checkout.php">
                <button class="checkout-button">Ir para Página de Compra</button>
            </a>
        </div>
    <?php endif; ?>
</main>
<footer>
    <p>© 2024 por A Sua Loja de Roupas.</p>
</footer>
</body>
</html>

