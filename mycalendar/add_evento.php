<?php
    require_once 'classes/eventos.php';
    $u = new Evento("projeto_login","localhost","root","");
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
        <link rel="stylesheet" href="styles/add_evento.css">
        <link rel="stylesheet" href="styles/responsive.css">
        <link rel="shortcut icon" href="icones/calendar.png" />
    </head>

    <body>
        <div id="page-register">
            
                <header>
                    <h3><img src="icones/mycalendar.png" alt="logomarca" width="182" height="44"></h3>
                    <a href="mycalendar.php">
                        <span></span>
                        Voltar MyCalendar
                    </a>
                </header>
                <?php
                    if(isset($_GET['id_up'])){ //clicou em editar
                        $id_update = addslashes($_GET['id_up']);
                        $res = $u->buscarDadosEvento($id_update);
                    }
                ?>
                <div id="superior">
                <h1>Meus Eventos</h1>
                <table>
                    <tr id="titulo">
                        <td>TÍTULO</td>
                        <td>DATA</td>
                        <td>HORÁRIO DE INÍCIO</td>
                        <td>HORÁRIO DE TÉRMINO</td>
                        <td >OBSERVAÇÃO</td>
                        <td >OPÇÕES</td>
                    </tr>
                    <?php
                        $dados = $u->buscarDados();
                        if(count($dados) > 0){
                            for($i=0; $i<count($dados); $i++){
                                echo "<tr >";
                                foreach($dados[$i] as $k => $v){
                                    if($k != "id"){//para nao entrar o id na tabela
                                        echo "<td >".$v."</td>";
                                    }
                                }
                                ?>
                                <td>
                                    <a href="add_evento.php?id_up=<?php echo $dados[$i]['id'];?>">Editar</a><a href="add_evento.php?id=<?php echo $dados[$i]['id'];?>">Excluir</a>
                                </td>
                                <?php
                                echo "</tr>";
                            }
                        }
                        else{
                            echo "Não há eventos cadastrados!";
                        }
                    ?>
                                 
                    </tr>
                </table>
                </div>
                
                <?php
                    if(isset($_POST['titulo'])){//clicou cadastrar ou editar
                        //editar
                        if(isset($_GET['id_up']) && !empty($_GET['id_up'])){
                            $id_upd = addslashes($_GET['id_up']);
                            $titulo = addslashes($_POST['titulo']);
                            $dia = addslashes($_POST['dia']);
                            $horario_inicio = addslashes($_POST['horario_inicio']);
                            $horario_termino = addslashes($_POST['horario_termino']);
                            $observacao = addslashes($_POST['observacao']);

                            $u->atualizarDados($id_upd,$titulo,$dia,$horario_inicio,$horario_termino,$observacao);
                            header("location: add_evento.php");
                        }
                        //cadastrar
                        else{
                            $titulo = addslashes($_POST['titulo']);
                            $dia = addslashes($_POST['dia']);
                            $horario_inicio = addslashes($_POST['horario_inicio']);
                            $horario_termino = addslashes($_POST['horario_termino']);
                            $observacao = addslashes($_POST['observacao']);

                            $u->cadastrar($titulo,$dia,$horario_inicio,$horario_termino,$observacao);
                            header("location: add_evento.php");
                        }
                    }
                ?>
                <form method="POST">
                    <h1>Adicionar Evento</h1>
                    <fieldset>
                        <div class="field">
                            <label for="name">Titulo</label>
                            <input type="text" name="titulo" value="<?php if(isset($res)){echo $res['titulo'];}?>" required>
                        </div>

                        <div class="field">
                            <label for="name">Dia</label>
                            <input type="date" name="dia" value="<?php if(isset($res)){echo $res['dia'];}?>" required>
                        </div>

                        <div class="field-group">
                            <div class="field">
                                <label for="number">Horário de Início</label>
                                <input type="time" name="horario_inicio" value="<?php if(isset($res)){echo $res['horario_inicio'];}?>">
                            </div>
                            <div class="field">
                                <label for="number">Horário de término</label>
                                <input type="time" name="horario_termino" value="<?php if(isset($res)){echo $res['horario_termino'];}?>">
                            </div>
                        </div>

                        <div class="field">
                            <label for="name">Observação</label>
                            <input type="text" name="observacao" value="<?php if(isset($res)){echo $res['observacao'];}?>">
                        </div>

                        <input id="butao" type="submit" value="<?php if(isset($res)){echo "Atualizar";}else{echo "Cadastrar";}?>">
        
                    </fieldset>
                </form>
         </div>

         <script src="js/register.js"></script>
        
    </body>
</html>

<?php
    if(isset($_GET['id'])){
        $id_evento = addslashes($_GET['id']);
        $u->excluir($id_evento);
        header("location: add_evento.php");
    }
?>