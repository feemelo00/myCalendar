$(function(){
    var data = new Date();
    var mesAtual = data.getMonth()+1;
    var diaAtual = data.getDate();

    $('#mes_'+mesAtual).show().find('.dia_'+diaAtual).addClass('atual');

    function hideShow(){
        if(mesAtual > 12) mesAtual = 1;
        else if(mesAtual < 1) mesAtual = 12;
        $('.mes').hide();
        $('#mes_'+mesAtual).show();
    }

    $('#avancar').on('click', function(e){
        e.preventDefault();
        mesAtual++;
        hideShow();

        return false;
    });

    $('#voltar').on('click', function(e){
        e.preventDefault();
        mesAtual--;
        hideShow();

        return false;
    });

});