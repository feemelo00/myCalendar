<?php
    session_start();
    require 'config.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/responsive.css">
    <link rel="shortcut icon" href="icones/calendar.png" />
    <link rel="stylesheet" href="styles/login.css">
</head>
<body>
<body>
        <div id="page-login">
            
                <header>
                    <h3><img src="icones/mycalendar.png" alt="logomarca" width="182" height="44"></h3>
                    <a href="index.html">
                        <span></span>
                        Voltar para home
                    </a>
                </header>

                <form method="POST">
                    <h1>Entrar</h1>

                    <fieldset>
                        <div class="field">
                            <label for="name">Email</label>
                            <input type="email" name="email" maxlength="30" required>
                        </div>
                        <div class="field">
                            <label for="name">Senha</label>
                            <input type="password" name="senha" maxlength="30" required>
                        </div>

                    </fieldset>

                    <input id="botao" type="submit" value="Entrar">
                    <br> <br>
                    <a href="register.php">Ainda não é inscrito?<strong> Cadastre-se</strong></a>
                </form>
         </div>
         <?php
            // Verifica envio de dados
            if (!empty($_POST['email']) && !empty($_POST['senha'])) {
                // Recebe dados
                $email = htmlspecialchars(($_POST['email']));
                $senha = md5(htmlspecialchars(($_POST['senha'])));
                // Seleciona usuário no banco de dados
                $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = ? AND senha = ?");
                $sql->execute([$email, $senha]);
                // Verifica retorno do banco
                if ($sql->rowCount() > 0) {
                    // Cria sessão
                    $_SESSION['user'] = $sql->fetch();
                    // Redireciona
                    header("Location: mycalendar.php");
                    exit();
                }
                else{?>
                    <div class="msg-erro">Email e/ou senha inválidos!</div>
                    <?php
                }
            }
         ?>
</body>

</html>