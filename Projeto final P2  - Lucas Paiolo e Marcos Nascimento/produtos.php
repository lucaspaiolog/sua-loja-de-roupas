<?php
require_once 'db.php';

$category_filter = isset($_GET['category']) ? $_GET['category'] : '';
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'ASC';

$query = "SELECT name, description, price, image FROM products WHERE category LIKE :category";
if ($order_by == 'ASC') {
    $query .= " ORDER BY price ASC";
} elseif ($order_by == 'DESC') {
    $query .= " ORDER BY price DESC";
}

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute(['category' => '%' . $category_filter . '%']);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao consultar os produtos: " . $e->getMessage());
}

// Consulta para obter as categorias únicas
$categories_query = "SELECT DISTINCT category FROM products";
$categories_stmt = $pdo->prepare($categories_query);
$categories_stmt->execute();
$categories = $categories_stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Árvores de Natal</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .products-section {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 40px 20px;
            flex-wrap: wrap;
        }

        .product-card {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: calc(33.333% - 20px);
            box-sizing: border-box;
            position: relative;
        }

        .cart-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #e60023;
            color: white;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
        }

        .cart-icon-img {
            max-width: 40px;
            max-height: 40px;
        }

        .product-card img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .product-card h3 {
            margin: 15px 0;
            font-size: 1.2rem;
            color: #333;
        }

        .product-card p {
            font-size: 1rem;
            color: #666;
            margin-bottom: 10px;
        }

        .product-card strong {
            font-size: 1.2rem;
            color: #e60023;
        }

        .filter-section {
            margin: 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .filter-section select, .filter-section button {
            padding: 10px;
            font-size: 1rem;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .filter-section button {
            background-color: #28a745;
            color: white;
            cursor: pointer;
        }

        .filter-section button:hover {
            background-color: #218838;
        }

        @media (max-width: 768px) {
            .product-card {
                width: calc(50% - 20px);
            }
        }

        @media (max-width: 480px) {
            .product-card {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="top-bar">
    FAÇA SEU PEDIDO ONLINE
</div>
<header>
    <div class="header-title"><a href="index.php">A SUA BOUTIQUE DE NATAL</a></div>
    <nav class="nav-bar">
        <a href="arvores.php">ÁRVORES DE NATAL</a>
        <a href="enfeites.php">ENFEITES ESPECIAIS</a>
        <a href="luzes.php">LUZES DE NATAL</a>
        <a href="sobre.html">SOBRE</a>
        <a href="login.php">LOGIN</a>
    </nav>
    <div class="cart">
        <a class="cart" href="carrinho.php"><b>CARRINHO</b></a>
    </div>
</header>

<main>
    <section class="filter-section">
        <form method="get" action="arvores.php" style="display: flex; gap: 10px;">
            <select name="category">
                <option value="">Selecione uma categoria</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['category'] ?>" <?= $category['category'] == $category_filter ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['category']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="order_by">
                <option value="ASC" <?= $order_by == 'ASC' ? 'selected' : '' ?>>Preço: Menor para Maior</option>
                <option value="DESC" <?= $order_by == 'DESC' ? 'selected' : '' ?>>Preço: Maior para Menor</option>
            </select>

            <button type="submit">Filtrar e Ordenar</button>
        </form>
    </section>

    <!-- Exibição dos Produtos -->
    <section class="products-section">
        <?php if (!empty($produtos)): ?>
            <?php foreach ($produtos as $produto): ?>
                <div class="product-card">
                    <div class="cart-icon">
                        <img src="carrinho_icon.png" alt="Carrinho de Compras" class="cart-icon-img">
                    </div>
                    <img src="<?= htmlspecialchars($produto['image']) ?>" alt="<?= htmlspecialchars($produto['name']) ?>">
                    <h3><?= htmlspecialchars($produto['name']) ?></h3>
                    <p><?= htmlspecialchars($produto['description']) ?></p>
                    <p><strong>R$ <?= number_format($produto['price'], 2, ',', '.') ?></strong></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Não há produtos disponíveis nesta categoria.</p>
        <?php endif; ?>
    </section>
</main>

<footer>
    <div class="footer-logo">
        <a href="index.php"><h2>A SUA BOUTIQUE DE NATAL</h2></a>
    </div>
    <nav class="footer-nav">
        <a href="arvores.php">ÁRVORES DE NATAL</a>
        <a href="enfeites.php">ENFEITES ESPECIAIS</a>
        <a href="luzes.php">LUZES DE NATAL</a>
        <a href="sobre.html">SOBRE</a>
        <a href="login.php">LOGIN</a>
    </nav>
    <div class="footer-info">
        <p>© 2024 por A Sua Boutique de Natal. Projeto orgulhosamente criado por Alexandre e Henrique.</p>
    </div>
</footer>

</body>
</html>
