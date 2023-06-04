<?php
    //configurar variaveis
    $server = 'localhost';
    $user = 'root';
    $senha = '';
    $banco = 'vendas';

    //tentar conectar no banco de dados
    try {
        //criar uma conexão com PDO
        $pdo = new PDO("mysql:host={$server};dbname={$banco};charset=utf8;",$user,$senha);
        
    } catch (Exception $erro) {
        //mensagem de erro
        echo "<p>Erro ao conectar com o a base de dados: {$erro}</p>";
    }

    $base = "http://localhost/lojasACL/";