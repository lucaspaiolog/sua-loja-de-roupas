<?php
session_start();
require 'db.php';

// Verifica se o carrinho tem itens
if (empty($_SESSION['cart'])) {
    echo "<p>Seu carrinho está vazio. <a href='index.php'>Voltar à loja</a></p>";
    exit();
}

// Quando o formulário é enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $address = htmlspecialchars($_POST['address']);
    $payment_method = htmlspecialchars($_POST['payment_method']);
    $cart = $_SESSION['cart'];
    $total_price = 0;

    foreach ($cart as $product_id => $details) {
        $total_price += $details['price'] * $details['quantity'];
    }

    $pdo->beginTransaction();
    try {
        // Salvar pedido
        $stmt = $pdo->prepare("
            INSERT INTO orders (user_id, shipping_address, payment_method, total_price, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ");
        $stmt->execute([$user_id, $address, $payment_method, $total_price]);
        $order_id = $pdo->lastInsertId();

        // Salvar itens do pedido
        $stmt = $pdo->prepare("
            INSERT INTO order_items (order_id, product_id, quantity)
            VALUES (?, ?, ?)
        ");
        foreach ($cart as $product_id => $details) {
            $stmt->execute([$order_id, $product_id, $details['quantity']]);
        }

        $pdo->commit();
        unset($_SESSION['cart']);
        header("Location: historico.php");
        exit();

    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Erro ao finalizar a compra: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra</title>
    <style>
        
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
    color: #333;
}

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

.container {
    width: 90%;
    max-width: 800px;
    margin: 20px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #3B5998;
    margin-bottom: 20px;
}

form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

label {
    font-weight: bold;
    font-size: 1.1em;
    color: #2C3E50;
}

input, select {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}

button {
    padding: 15px;
    background-color: #3B5998;
    color: white;
    font-size: 18px;
    font-weight: bold;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-align: center;
}

button:hover {
    background-color: #2C3E50;
}

@media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    h1 {
        font-size: 24px;
    }

    button {
        font-size: 16px;
    }
}
</style>
</head>
<body>
    <div class="container">
        <h1>Finalizar Compra</h1>
        <form method="POST">
            <label for="address">Endereço de Entrega</label>
            <input type="text" name="address" id="address" required>

            <label for="payment_method">Forma de Pagamento</label>
            <select name="payment_method" id="payment_method" required>
                <option value="cartao">Cartão de Crédito</option>
                <option value="boleto">Boleto Bancário</option>
                <option value="pix">PIX</option>
            </select>

            <button type="submit">Confirmar Compra</button>
        </form>
    </div>
</body>
</html>


