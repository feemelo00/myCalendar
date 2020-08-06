<?php

    // Inicia sessão
    session_start();
    // Puxa arquivo
    require 'config.php';
    // Verifica envio de dados
    if (!isset($_SESSION['user'])) {
        // Redireciona
        header("Location: index.php");
        exit();
    }

    include 'conexao.php';
    include 'calendario.php';
    $info = array(
        'tabela' => 'eventoss',
        'dia' => 'dia',
        'titulo' => 'titulo',
        'horario_inicio' => 'horario_inicio',
        'horario_termino' => 'horario_termino',
        'observacao' => 'observacao'
    );
?>

<!DOCTYPE html>
<html lang="pt_br">
    <head>
        <title>Seu Calendário</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="styles/calendario.css">
        <link rel="stylesheet" href="styles/main.css">
        <link rel="stylesheet" href="styles/mycalendar.css">
        <link rel="stylesheet" href="styles/responsive.css">

        <link rel="shortcut icon" href="icones/calendar.png" />
    </head>

    <body>
        <div id="page-mycalendar">
            
                <header>
                    <h3><img src="icones/mycalendar.png" alt="logomarca" width="182" height="44" alt="logomarca"></h3>
                    <a href="sair.php">
                        <span></span>
                        Sair
                    </a>
                </header>

               <main>
                   <h4>
                        Bem-vindo, <strong><?= $_SESSION['user']['nome']; ?></strong> !<br><br>
                       <strong> Meu</strong> calendário - <strong>2020</strong>
                        <a href="add_evento.php">
                                    <span></span>
                                    Meus eventos
                        </a>
                   </h4>
    
                    <div class="calendario">
                        <?php 
                            $eventos = montaEventos($info);
                            montaCalendario($eventos);
                        ?>
                        <div class="legends">
                            <span class="legenda"><span class="black"></span> Hoje</span>
                            <span class="legenda"><span class="yellow"></span> Eventos</span>
                        </div>
                    </div>
               </main>
        </div>


        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/functions.js"></script>
    </body>
</html>