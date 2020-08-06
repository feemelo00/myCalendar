<?php
    require_once 'classes/usuarios.php';
    $u = new Usuario;
?>

<!DOCTYPE html>
<html lang="pt_br">
    <head>
        <title>Inscrever-se</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="styles/main.css">
        <link rel="stylesheet" href="styles/register.css">
        <link rel="stylesheet" href="styles/responsive.css">
        <link rel="shortcut icon" href="icones/calendar.png" />
    </head>

    <body>
        <div id="page-register">
            
                <header>
                    <h3><img src="icones/mycalendar.png" alt="logomarca" width="182" height="44"></h3>
                    <a href="index.html">
                        <span></span>
                        Voltar para home
                    </a>
                </header>

                <form method="POST">
                    <h1>Criar sua conta</h1>

                    <fieldset>
                        <div class="field">
                            <label for="name">Nome</label>
                            <input type="text" name="nome" maxlength="30" required>
                        </div>

                        <div class="field-group">
                            <div class="field">
                                <label for="email">E-mail</label>
                                <input type="email" name="email" maxlength="40" required>
                            </div>
                            <div class="field">
                                <label for="senha">Senha</label>
                                <input type="password" name="senha" maxlength="15" required>
                            </div>
                        </div>

                        <div class="field-group">
                            <div class="field">
                                <label for="state">Estado</label>
                                <select name="uf" required> 
                                    <option value="">Selecione o Estado</option>
                                </select>

                                <input type="hidden" name="state">
                            </div>
                            <div class="field">
                                <label for="city">Cidade</label>
                                <select name="city" disabled required>
                                    <option value="">Selecione a Cidade</option>
                                </select>
                            </div>
                            
                        </div>
                    </fieldset>

                    <button type="submit" action="login.php">Cadastrar</button>
                </form>
         </div>

        <?php
            if(isset($_POST['nome'])){
                $nome = addslashes($_POST['nome']);
                $email = addslashes($_POST['email']);
                $senha = addslashes($_POST['senha']);

                $u->conectar("projeto_login","localhost","root","");
                if($u->msgErro == ""){//nao deu nenhum erro
                    if($u->cadastrar($nome,$email,$senha)){
                        ?>
                        <div id="msg-sucesso">
                            Cadastrado com sucesso! Acesse para entrar.
                        </div>
                        <?php
                        header("location: login.php");

                    }
                    else{
                        ?>
                        <div class="msg-erro">
                            "Email ja cadastrado!"
                        </div>
                        <?php
                    }
                }
                else{//deu erro
                    ?>
                    <div class="msg-erro">
                        <?php echo "Erro: ".$u->msgErro; ?>
                    </div>
                    <?php
                }
            }
        ?>

         <script src="js/register.js"></script>
        
    </body>
</html>