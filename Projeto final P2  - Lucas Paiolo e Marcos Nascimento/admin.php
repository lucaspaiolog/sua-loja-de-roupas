<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $image = $_POST['image'];
        $category = $_POST['category'];

        // Inserir novo produto no banco de dados
        $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image, category) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $description, $price, $image, $category]);
        $success_message = "Produto criado com sucesso!";
    }

    if (isset($_POST['delete'])) {
        $product_id = $_POST['product_id'];

        // Excluir o produto do banco de dados
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        $delete_message = "Produto excluído com sucesso!";
    }

    if (isset($_POST['delete_order'])) {
        $order_id = $_POST['order_id'];

        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("DELETE FROM order_items WHERE order_id = ?");
            $stmt->execute([$order_id]);

            $stmt = $pdo->prepare("DELETE FROM orders WHERE id = ?");
            $stmt->execute([$order_id]);

            $pdo->commit();

            $success_message = "Pedido excluído com sucesso!";
        } catch (Exception $e) {
            $pdo->rollBack();
            $error_message = "Erro ao excluir o pedido: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <style>
    /* Estilização geral */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    /* Cabeçalho do painel */
    .top-bar {
        background-color: #3B5998;
        color: white;
        text-align: center;
        padding: 10px;
        font-weight: bold;
    }

    header {
        background-color: #2C3E50;
        color: white;
        padding: 20px 0;
        text-align: center;
    }

    header h1 {
        font-size: 32px;
        margin: 0;
    }

    /* Conteúdo do painel */
    .admin-container {
        max-width: 1200px;
        margin: 30px auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h2 {
        color: #3B5998;
        font-size: 24px;
        margin-bottom: 20px;
        text-align: center;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        color: #2C3E50;
        margin-bottom: 5px;
    }

    .form-group input, .form-group textarea, .form-group select {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border-radius: 8px;
        border: 1px solid #ddd;
        font-size: 16px;
    }

    .form-group button {
        background-color: #3B5998;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
    }

    .form-group button:hover {
        background-color: #2C3E50;
    }

    .success-message, .delete-message {
        color: #28a745;
        text-align: center;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .error-message {
        color: #dc3545;
        text-align: center;
        font-weight: bold;
        margin-bottom: 20px;
    }

    /* Listagem de produtos e pedidos */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table th, table td {
        padding: 15px;
        text-align: center;
        border: 1px solid #ddd;
    }

    table th {
        background-color: #3B5998;
        color: white;
    }

    table td {
        background-color: #f9f9f9;
    }

    table td button {
        background-color: #dc3545;
        color: white;
        padding: 8px 12px;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
    }

    table td button:hover {
        background-color: #c82333;
    }

    /* Rodapé */
    .back-button {
        margin-top: 20px;
        text-align: center;
    }

    .back-button a {
        display: inline-block;
        background-color: #3B5998;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
    }

    .back-button {
        margin-top: 20px;
        text-align: center;
    }

    .back-button a {
        display: inline-block;
        background-color: #3B5998;
        color: white;
        padding: 10px 20px;
        text-decoration: none ;
        border-radius: 1px;
    }

    .back-button a:hover {
        background-color: #2C3E50; 
        text-decoration: none; 
    }
</style>

</head>
<body>

<div class="admin-container">
    <h1>Painel do Admin</h1>

    <?php if (isset($success_message)) { echo "<p class='success-message'>$success_message</p>"; } ?>
    <?php if (isset($delete_message)) { echo "<p class='delete-message'>$delete_message</p>"; } ?>
    <?php if (isset($error_message)) { echo "<p class='error-message'>$error_message</p>"; } ?>

    <h2>Criar Novo Produto</h2>
    <form method="POST" action="admin.php">
        <div class="form-group">
            <label for="name">Nome do Produto</label>
            <input type="text" name="name" id="name" required>
        </div>
        <div class="form-group">
            <label for="description">Descrição</label>
            <textarea name="description" id="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="price">Preço</label>
            <input type="text" name="price" id="price" required>
        </div>
        <div class="form-group">
            <label for="image">Link da Imagem</label>
            <input type="text" name="image" id="image" required>
        </div>
        <div class="form-group">
            <label for="category">Categoria</label>
            <select name="category" id="category" required>
                <option value="arvores">Tênis</option>
                <option value="enfeites">Camisetas</option>
                <option value="luzes">Bermudas</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" name="create">Criar Produto</button>
        </div>
    </form>

    <h2>Produtos Criados</h2>
    <div class="product-list">
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Ações</th>
            </tr>
            <?php
            // Buscar todos os produtos
            $stmt = $pdo->prepare("SELECT * FROM products");
            $stmt->execute();
            $products = $stmt->fetchAll();

            foreach ($products as $product):
            ?>
            <tr>
                <td><?= $product['id'] ?></td>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= htmlspecialchars($product['category']) ?></td>
                <td>
                    <!-- Botão para excluir o produto -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <button type="submit" name="delete" onclick="return confirm('Tem certeza de que deseja excluir este produto?')">Excluir</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <h2>Pedidos</h2>
    <div class="order-list">
        <table>
            <tr>
                <th>ID</th>
                <th>Total</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
            <?php
            // Buscar todos os pedidos
            $stmt = $pdo->prepare("SELECT * FROM orders");
            $stmt->execute();
            $orders = $stmt->fetchAll();

            foreach ($orders as $order):
            ?>
            <tr>
                <td><?= $order['id'] ?></td>
                <td>R$ <?= number_format($order['total_price'], 2, ',', '.') ?></td>
                <td><?= date("d/m/Y H:i", strtotime($order['created_at'])) ?></td>
                <td>
                    <!-- Botão para excluir o pedido -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                        <button type="submit" name="delete_order" onclick="return confirm('Tem certeza de que deseja excluir este pedido?')">Excluir</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <br>
    <div class="form-group">
            <button class='back-button'><a href="index.php">Voltar</a></button>
        </div>
</div>

</body>
</html>
