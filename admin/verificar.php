<?php
    //iniciar a sessao
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Admin</title>

    <!----- arquivos css ---->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/sweetalert2.min.css">
    <link rel="stylesheet" href="css/style.css">
    <!----- arquivos javascript ---->
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/sweetalert2.js"></script>
</head>
<body>
    <?php

        require "configs/functions.php";
        //verificar se envido post
        if (!$_POST) {
            mensagem("Erro","Requisição inválida");
        }

        //incluir o arquivo do banco
        require "configs/conexao.php";
        //recuperar as duas variaveis - campos
        //print_r($_POST);
        $login = trim($_POST["login"] ?? NULL);
        $senha = trim($_POST["senha"] ?? NULL);

        //verificar se as variaveis estao em branco ou nulas
        if (empty($login)) {
            mensagem("Erro","Preencha o campo login");
        } else if (empty($senha)) {
            mensagem("Erro","Preencha o campo senha");
        }

        $sqlUsuario = "select * from usuarios where login = :login AND ativo = 'S' limit 1";
        //preparar o sql para execução
        $consultaUsuario = $pdo->prepare($sqlUsuario);
        //passar o parametro :login
        $consultaUsuario->bindParam(":login", $login);
        //executar o sql
        $consultaUsuario->execute();

        //pegar os resultados
        $dadosUsuario = $consultaUsuario->fetch(PDO::FETCH_OBJ);

        if (empty($dadosUsuario->id)) {
            mensagem("Erro","O usuário ou senha incorreto!");
        } else if (!password_verify($senha,$dadosUsuario->senha)) {
            mensagem("Erro","O usuário ou senha incorreto.");
        }

        $id = $dadosUsuario->id;
        $nome = $dadosUsuario->nome;
        $login = $dadosUsuario->login;

        //configurar a variavel usuarioAdm na sessao
        $_SESSION["usuarioAdm"] = array("id"=>$id, "nome"=>$nome, "login"=>$login);
        //redirecionar para a tela home
        echo "<script>location.href='home'</script>";


    ?>
</body>
</html>