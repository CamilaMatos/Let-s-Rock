<?php
    if (!isset($pagina))
        exit;

    require "configs/functions.php";
    
    if (!$_POST) 
        mensagem("Erro", "Requisiçã inválida");

    //recuperar os dados digitados no formulário
    //print_r($_POST);
    $id = trim($_POST["id"] ?? NULL);
    $categoria = trim($_POST["categoria"] ?? NULL);

    //verificar se esses campos estão em branco
    if (empty($categoria))
        mensagem("Erro","Preencha a Categoria");
    
    $sqlCategoria = "select id from categorias where categoria = :categoria 
        AND id <> :id limit 1";
    $consultaCategoria = $pdo->prepare($sqlCategoria);
    $consultaCategoria->bindParam(":id", $id);
    $consultaCategoria->bindParam(":categoria", $categoria);
    $consultaCategoria->execute();

    $dados = $consultaCategoria->fetch(PDO::FETCH_OBJ);

    if (!empty($dados->id))
        mensagem("Erro","Já existe um registro com esta categoria cadastrada no sistema");
    
    //verificar se vamos dar um insert ou um update
    if (empty($id)) {
        //insert
        $sql = "insert into categorias values (NULL, :categoria)";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":categoria", $categoria);
    } else {
        //update
        $sql = "update categorias set categoria = :categoria where id = :id limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":categoria", $categoria);
        $consulta->bindParam(":id", $id);
    }

    if ( $consulta->execute() ){
        mensagem("Sucesso","Registro salvo/alterado com sucesso");
    } else {
        mensagem("Erro","Não foi possível salvar ou alterar o registro");
    }