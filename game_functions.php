<?php

if($_GET['campo'] == ''){ //Testa se o campo acionado está ou não vazio
    $posicao = $_GET['posicao']; //Caso esteja, le sua posição
    if($_GET['jogada'] % 2 == 0){ //Testa a jogada atual
        $sinal = 'X'; //Determina o valor que irá para a posição
        $jogada = ($_GET['jogada'])+1; //Acresce o valor da jogada para que o próximo jogar tenha a vez

        header("location:index.php?jogada=$jogada&sinal=$sinal&posicao=$posicao"); 
        die();
    }else{
        $sinal = '0';
        $jogada = $_GET['jogada']+1;

        header("location:index.php?jogada=$jogada&sinal=$sinal&posicao=$posicao");
        die();
    }
}else{ //Se o campo já estiver preenchido retorna o sinal atual e não acresce o valor da jogada
    $posicao = $_GET['posicao'];
    if($_GET['jogada'] % 2 == 0){
        $sinal = '0';
        $jogada = $_GET['jogada'];

        header("location:index.php?jogada=$jogada&sinal=$sinal&posicao=$posicao");
        die();
    }else{
        $sinal = 'X';
        $jogada = $_GET['jogada'];

        header("location:index.php?jogada=$jogada&sinal=$sinal&posicao=$posicao");
        die();
    }
}
?>