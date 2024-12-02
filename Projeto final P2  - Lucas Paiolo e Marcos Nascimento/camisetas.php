<?php
require_once 'db.php';
session_start(); // Começando a sessão para gerenciar o carrinho

// Verificar se o produto foi adicionado ao carrinho
if (isset($_POST['add_to_cart'])) {
// Verifica se o usuário está logado (presumindo que 'user_id' esteja na sessão)
        if (!isset($_SESSION['users_id'])) {
            // Usuário não está logado, redireciona para a página de login ou exibe mensagem
            header('Location: login.php'); // Substitua 'login.php' pela sua página de login
            exit();
        }

    $productId = $_POST['product_id'];
    $quantity = 1; // Quantidade inicial como 1

    // Obter detalhes do produto
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->bindParam(':id', $productId);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Se o produto já está no carrinho, atualize a quantidade
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] += $quantity;
    } else {
        // Caso contrário, adicione um novo item ao carrinho
        $_SESSION['cart'][$productId] = [
            'name' => $product['name'],
            'price' => $product['price'],
            'image' => $product['image'],
            'quantity' => $quantity
        ];
    }

    // Redirecionar para o carrinho após adicionar o produto
    header('Location: carrinho.php');
    exit();
}

// Consulta para buscar os produtos de Tênis
$query = "SELECT * FROM products WHERE category = 'Camisetas'";
$stmt = $pdo->query($query);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camisetas</title>
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

        .products-section {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .product-card {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Ajustando o tamanho das imagens */
        .product-card img {
            width: 100%;
            max-height: 250px; /* Definindo uma altura máxima para as imagens */
            object-fit: contain; /* Mantendo a proporção da imagem */
            border-radius: 10px;
        }

        .product-card h3 {
            color: #3B5998;
            margin: 15px 0;
        }

        .product-card p {
            color: #777;
        }

        .product-card strong {
            color: #3B5998;
        }

        /* Botão adicionar ao carrinho */
        .add-to-cart {
            background-color: #3B5998;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        .add-to-cart:hover {
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
    <div class="header-title">Camisetas</div>
</header>
<main>
    <section class="products-section">
        <?php foreach ($produtos as $produto): ?>
            <div class="product-card">
                <img src="<?= $produto['image'] ?>" alt="<?= $produto['name'] ?>">
                <h3><?= $produto['name'] ?></h3>
                <p><?= $produto['description'] ?></p>
                <p><strong>R$ <?= number_format($produto['price'], 2, ',', '.') ?></strong></p>
                <!-- Formulário para adicionar ao carrinho -->
                <form action="tenis.php" method="POST">
                    <input type="hidden" name="product_id" value="<?= $produto['id'] ?>">
                    <button type="submit" name="add_to_cart" class="add-to-cart">Adicionar ao Carrinho</button>
                </form>
            </div>
        <?php endforeach; ?>
    </section>
</main>
<footer>
    <p>© 2024 por A Sua Loja de Roupas.</p>
</footer>
</body>
</html>