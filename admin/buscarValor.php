<?php
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Origin: *");
    session_start();

    $dados= array("erro"=>"Requisição inválida");

    if ($_SESSION["usuarioAdm"]["id"]) {
        require "configs/conexao.php";

        $id = trim($_POST["id"] ?? NULL);

        if(empty($id)) {
            $dados = array("erro"=>"Produto inválido");
        } else {
            $sql= "select valor from produtos where id= :id limit 1";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":id", $id);
            $consulta->execute();

            $dados = $consulta->fetch(PDO::FETCH_OBJ);

            $valor = number_format($dados->valor,2,",",".");

            $dados = array("valor"=>$valor);
        }

    } else {
        $dados= array("erro"=>"Você não está logado");
    }
    echo json_encode($dados);