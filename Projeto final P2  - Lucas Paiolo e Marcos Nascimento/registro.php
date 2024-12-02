<?php
require_once 'db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validação dos campos
    if (empty($name)) {
        $errors[] = "O campo Nome de Usuário é obrigatório.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "E-mail inválido.";
    }

    if (empty($password) || strlen($password) < 6) {
        $errors[] = "A senha deve ter pelo menos 6 caracteres.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "As senhas não coincidem.";
    }

    // Inserção no banco de dados
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
            $stmt->execute([
                'name' => $name,
                'email' => $email,
                'password' => $hashed_password
            ]);

            header("Location: login.php");
            exit;
        } catch (PDOException $e) {
            $errors[] = "Erro ao criar conta: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2C3E50;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-form {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .login-form h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .login-form label {
            font-weight: bold;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }

        .login-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .login-form button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        .login-form button:hover {
            background-color: #218838;
        }

        .login-form .error {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-bottom: 10px;
        }

        .login-form .register-btn {
            background-color: #007bff;
            margin-top: 10px;
        }

        .login-form .register-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h1>Crie sua conta</h1>
        <form action="registro.php" method="POST">
            <?php if (!empty($errors)): ?>
                <div class="error">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div>
                <label for="name">Nome de Usuário:</label>
                <input type="text" name="name" id="name" required>
            </div>

            <div>
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div>
                <label for="password">Senha:</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div>
                <label for="confirm_password">Confirme a Senha:</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
            </div>

            <button type="submit">Registrar</button>
        </form>
    </div>
</body>
</html>
