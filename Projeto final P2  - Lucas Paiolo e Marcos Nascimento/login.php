<?php  
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email === 'admin@email.com' && $password === 'admin123') {
        $_SESSION['admin'] = true;
        $_SESSION['name'] = 'admin'; 
        header("Location: admin.php"); 
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['users_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['admin'] = false;
        header("Location: index.php"); 
        exit();
    } else {
        $error_message = "E-mail ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        .login-form .register-btn {
            background-color: #007bff;
            margin-top: 10px;
        }

        .login-form .register-btn:hover {
            background-color: #0056b3;
        }

        .login-form .logout {
            background-color: #dc3545;
        }

        .login-form .logout a {
            color: white;
            text-decoration: none;
        }

        .login-form .logout:hover {
            background-color: #c82333;
        }

        .login-form .error {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <form class="login-form" method="post">
        <h1>Login</h1>
        <label for="email">E-mail:</label>
        <input type="email" name="email" required>
        <label for="password">Senha:</label>
        <input type="password" name="password" required>
        <button type="submit" class="btn">Entrar</button>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?> 

        <a href="registro.php">
            <button type="button" class="register-btn">Criar uma conta</button>
        </a>
        <button class="logout"><a href="logout.php">Logout</a></button>

    </form>
</body>
</html>
