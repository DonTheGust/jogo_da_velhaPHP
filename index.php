<?php error_reporting(0); //Função para deixar de exibir todo e qualquer error em tela ?>
<?php

session_start();

$jogada = 0;

if($_GET['jogada'] != NULL){ //Condicional para consulta em qual jogada estamos (caso alguma tenha ocorrido)
    $jogada = $_GET['jogada'];
    echo "<script>console.log($jogada)</script>";
}

if($jogada <= 1){ //Condicional que verifica se o jogo está iniciando
    for($i = 0; $i < 3; $i++){
        for($j = 0; $j < 3; $j++){ //Laço para preenchimento de jogo com células vazias
            $_SESSION['memoria'][$i*3+$j] = ''; //A utilização do $i*3+$j é pra simular os calculos feitos em C para passagem de matrizes por parametro
        }
    }
    $_SESSION['vitoria'] = false; //Linha o status de vitória ao inicio de um novo jogo
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
    * {
        font-family: Roboto, sans-serif;
    }
    html{
        height: 100%;
        width: 100%;
        color: #fff;
        background-color: #292929;
        text-align: center;
    }
    input{
        height: 80px;
        width: 80px;
        font-size: 40px;
        margin: 2px;
    }
    #reset{
        margin-top: 30px;
        height: 40px;
        width: 15%;
        font-size: 20px;
    }
    </style>
</head>
<body>
    <h2>O jogo da velha mais incrível que existe na face da terra!!</h2>

<?php 

    for($i = 0; $i < 3; $i++){ //Iteração para impressão dos campos do jogo
        echo "<table>"; //Um table é estabelecido a cada 3 campos pra garantir que esses fiquem enfileirados
        for($j = 0; $j < 3; $j++){
            if($_SESSION['vitoria'] == false){ //Condicional para verificar se o jogo ainda não foi vencido
                if($_GET['sinal'] != NULL && $_GET['posicao'] == $i*3+$j){ //Caso não, imprimimos nossos campos com action definida
                    $_SESSION['memoria'][$i*3+$j]= $_GET['sinal']; //Se um sinal está retornando de game_functions, o mesmo é armazenado na sua respectiva posição
                    $value = $_SESSION['memoria'][$i*3+$j];
                    $position = $i*3+$j;
                    echo "<form method='GET' action='game_functions.php'>"; //Cada campo é um form com valores de posição espefico e valor puzado da memoria
                    echo "<input type='hidden' name='jogada' value='$jogada'>";
                    echo "<input type='hidden' name='posicao' value='$position'>";
                    echo "<input type='submit' name='campo' id='$position' value='$value'>";
                    echo "</form>";
                }else{ //Se o retorno de game_functuins não seja na posição da atual iteração, imprimimos o que está armazenado na memoria
                    $value = $_SESSION['memoria'][$i*3+$j];
                    $position = $i*3+$j;
                    echo "<form method='GET' action='game_functions.php'>";
                    echo "<input type='hidden' name='jogada' value='$jogada'>";
                    echo "<input type='hidden' name='posicao' value='$position'>";
                    echo "<input type='submit' name='campo' id='$position' value='$value'>";
                    echo "</form>";
                }
            }else{ //Caso o jogo seja vencido, imprimimos nossos campos sem action
                $value = $_SESSION['memoria'][$i*3+$j];
                $position = $i*3+$j;
                echo "<form method='GET' action=''>";
                echo "<input type='hidden' name='jogada' value='$jogada'>";
                echo "<input type='hidden' name='posicao' value='$position'>";
                echo "<input type='submit' name='campo' id='$position' value='$value'>";
                echo "</form>";
            }     
        }
        echo "</table>";
    }

    echo "<form method='GET' action='reset_game.php'>"; //Form apenas para resetar o número de jogadas, resetando assim todas variáveis do inicio da pagina também
    echo "<input type='submit' name='reset' id='reset' value='Reiniciar jogo'>";
    echo "</form><br>";

    //Condicional que verifica se o X venceu
    if (($_SESSION['memoria'][0] == 'X' && $_SESSION['memoria'][1] == 'X' && $_SESSION['memoria'][2] == 'X') ||
        ($_SESSION['memoria'][3] == 'X' && $_SESSION['memoria'][4] == 'X' && $_SESSION['memoria'][5] == 'X') ||
        ($_SESSION['memoria'][6] == 'X' && $_SESSION['memoria'][7] == 'X' && $_SESSION['memoria'][8] == 'X') ||
        ($_SESSION['memoria'][0] == 'X' && $_SESSION['memoria'][3] == 'X' && $_SESSION['memoria'][6] == 'X') ||
        ($_SESSION['memoria'][1] == 'X' && $_SESSION['memoria'][4] == 'X' && $_SESSION['memoria'][7] == 'X') ||
        ($_SESSION['memoria'][2] == 'X' && $_SESSION['memoria'][5] == 'X' && $_SESSION['memoria'][8] == 'X') ||
        ($_SESSION['memoria'][0] == 'X' && $_SESSION['memoria'][4] == 'X' && $_SESSION['memoria'][8] == 'X') ||
        ($_SESSION['memoria'][6] == 'X' && $_SESSION['memoria'][4] == 'X' && $_SESSION['memoria'][2] == 'X'))
    {
        $_SESSION['vitoria'] = true; //Caso tenha vencido, atualiza o status de jogo para ganho e bloqueia cliques em campos vazios
        echo "<h2>Você ganhou, primeiro jogador, parabéns!!!</h2>";
        echo "<img src='parabains.gif'>";
    }

    //Condicional que verifica se o 0 venceu
	if (($_SESSION['memoria'][0] == '0' && $_SESSION['memoria'][1] == '0' && $_SESSION['memoria'][2] == '0') ||
        ($_SESSION['memoria'][3] == '0' && $_SESSION['memoria'][4] == '0' && $_SESSION['memoria'][5] == '0') ||
        ($_SESSION['memoria'][6] == '0' && $_SESSION['memoria'][7] == '0' && $_SESSION['memoria'][8] == '0') ||
        ($_SESSION['memoria'][0] == '0' && $_SESSION['memoria'][3] == '0' && $_SESSION['memoria'][6] == '0') ||
        ($_SESSION['memoria'][1] == '0' && $_SESSION['memoria'][4] == '0' && $_SESSION['memoria'][7] == '0') ||
        ($_SESSION['memoria'][2] == '0' && $_SESSION['memoria'][5] == '0' && $_SESSION['memoria'][8] == '0') ||
        ($_SESSION['memoria'][0] == '0' && $_SESSION['memoria'][4] == '0' && $_SESSION['memoria'][8] == '0') ||
        ($_SESSION['memoria'][6] == '0' && $_SESSION['memoria'][4] == '0' && $_SESSION['memoria'][2] == '0'))
    {
        $_SESSION['vitoria'] = true; //Atualiza o status igual mostrado acima
        echo "<h2>Você ganhou, segundo jogador, parabéns!!!</h2>";
        echo "<img src='parabains.gif'>";
    }

    if ($jogada == 9 && $_SESSION['vitoria'] == false) //Caso o jogo gere empate, mostra mensagem em tela
    {
        echo "<h2>Empate, tente novamente.</h2>";
        echo "<img src='joselito.gif'>";
    }
?>
    
</body>
</html>