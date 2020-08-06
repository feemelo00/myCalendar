<?php
    function num($num){
        return ($num < 10) ? '0'.$num : $num;
    }

    function montaEventos($info){
        global $pdo;
        //tabela, dia, titulo
        $tabela = $info['tabela'];
        $dia = $info['dia'];
        $titulo = $info['titulo'];
        $horario_inicio = $info['horario_inicio'];
        $horario_termino = $info['horario_termino'];
        $observacao = $info['observacao'];

        $eventos = $pdo->prepare("SELECT * FROM `".$tabela."` WHERE `".$dia."` >= NOW()");
        $eventos->execute();

        $retorno = array();
        while($row = $eventos->fetchObject()){
            $diaArr = date('Y-m-d', strtotime($row->{$dia}));
            $retorno[$diaArr] = array(
                'titulo' => $row->{$titulo},
                'horario_inicio' => $row->{$horario_inicio},
                'horario_termino' => $row->{$horario_termino},
                'observacao' => $row->{$observacao}
            );
        }
        return $retorno;
    }
    
    function diasMeses(){
        $retorno = array();

        for($i = 1; $i <= 12; $i++){
            $retorno[$i] = cal_days_in_month(CAL_GREGORIAN, $i, date('Y')); // função retorna quantos dias tem cada mês no calendario gregoriano
        }

        return $retorno;
    }

    function montaCalendario($eventos = array()){
        $daysWeek = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
        $diasSemana = array('Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb');

        $arrayMes = array(
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro '
        );

        $diasMeses = diasMeses();
        $arrayRetorno = array();

        for($i =1; $i <= 12; $i++){
            $arrayRetorno[$i] = array();
            for($n=1; $n<= $diasMeses[$i]; $n++){
                $dayMonth = gregoriantojd($i, $n, date('Y')); // função transforma  calendario gregoriano para Julian Day, passando como referência mês, dia  e ano, respectivamente. vai retornar um número p saber que dia da semana será nessa dia
                $weekMonth = substr(jddayofweek($dayMonth, 1),0,3); //irá retornar por extenso, em 3 siglas, o dia da semana
                if($weekMonth == 'Mun') $weekMonth = 'Mon'; // a função acima retorna 'Mun' ao inves de 'Mon', por isso a troca.
                $arrayRetorno[$i][$n] = $weekMonth;
            }
        }
        echo '<a href="#" id="voltar">&laquo;</a><a href="#" id="avancar">&raquo;</a>'; //voltar e avançar nos meses
        echo '<table border="0" width="100%">';
        foreach($arrayMes as $num => $mes){
            echo '<tbody id="mes_'.$num.'" class="mes">';
            echo '<tr class="mes_title"><td colspan="7">'.$mes.'</td></tr>';
            echo '<tr class="dias_title">';
            foreach($diasSemana as $i => $day){
                echo '<td>'.$day.'</td>';
            }
            echo '</tr><tr>';
            $y = 0;//variavel para saber em qual coluna começa o mês
            foreach($arrayRetorno[$num] as $numero => $dia){
                $y++;
                if($numero == 1){
                    $qtd = array_search($dia, $daysWeek);//irá percorrer o array e descobrir quantas casas(dias da semana) tem que pular.
                    for($i=1; $i<=$qtd; $i++){//irá pular os dias da semana
                        echo '<td></td>';
                        $y+=1;
                    }
                }
                if(count($eventos) > 0){
                    $month = num($num);
                    $dayNow = num($numero);
                    $date = date('Y').'-'.$month.'-'.$dayNow;
                    if(in_array($date, array_keys($eventos))){
                        $evento = $eventos[$date];
                        echo '<td class="evento"><a href="#" title="'.$evento['titulo'].'">'.$numero.'</a></td>';
                    }else{
                        echo '<td class="dia_'.$numero.'">'.$numero.'</td>';
                    }
                }else{
                    echo '<td class="dia_'.$numero.'">'.$numero.'</td>';
                }
                if($y == 7){
                    $y=0;
                    echo '</tr><tr>';
                }
            }
            echo '</tr></tbody>';
        }
        echo '</table>';
    }
?>