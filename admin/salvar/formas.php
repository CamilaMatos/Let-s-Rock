<?php
    if (!isset($pagina))
        exit;

    require "configs/functions.php";
    
    if (!$_POST) 
        mensagem("Erro", "Requisiçã inválida");

    //recuperar os dados digitados no formulário
    //print_r($_POST);
    $id = trim($_POST["id"] ?? NULL);
    $forma = trim($_POST["forma"] ?? NULL);

    //verificar se esses campos estão em branco
    if (empty($forma))
        mensagem("Erro","Preencha a Forma");
    
    $sqlForma = "select id from formas where forma = :forma 
        AND id <> :id limit 1";
    $consultaForma = $pdo->prepare($sqlForma);
    $consultaForma->bindParam(":id", $id);
    $consultaForma->bindParam(":forma", $forma);
    $consultaForma->execute();

    $dados = $consultaForma->fetch(PDO::FETCH_OBJ);

    if (!empty($dados->id))
        mensagem("Erro","Já existe um registro com esta forma cadastrada no sistema");
    
    //verificar se vamos dar um insert ou um update
    if (empty($id)) {
        //insert
        $sql = "insert into formas values (NULL, :forma)";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":forma", $forma);
    } else {
        //update
        $sql = "update formas set forma = :forma where id = :id limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":forma", $forma);
        $consulta->bindParam(":id", $id);
    }

    if ( $consulta->execute() ){
        mensagem("Sucesso","Registro salvo/alterado com sucesso");
    } else {
        mensagem("Erro","Não foi possível salvar ou alterar o registro");
    }