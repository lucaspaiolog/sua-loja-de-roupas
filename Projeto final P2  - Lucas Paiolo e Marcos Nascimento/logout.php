<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <style>
        /* Estilização geral */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            text-align: center;
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
        }

        .header-title {
            font-size: 40px;
            margin-bottom: 10px;
        }

        /* Botão de Logout */
        .logout-btn {
            background-color: #dc3545;
            padding: 12px 20px;
            font-size: 16px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            margin-top: 30px;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }

        footer {
            background-color: #2C3E50;
            color: white;
            text-align: center;
            padding: 290px;
            margin-top: 50px;
            font-size: 16px;
        }
        
    </style>
</head>
<body>
    <div class="top-bar">COMPRE AS MELHORES ROUPAS ONLINE</div>
    <header>
        <div class="header-title">A SUA LOJA DE ROUPAS</div>
    </header>

    <main>
        <h1>Você foi desconectado!</h1>
        <a href="login.php" class="logout-btn">Voltar para Login</a>
    </main>

    <footer>
        <p>© 2024 por A Sua Loja de Roupas.</p>
    </footer>
</body>
</html>
