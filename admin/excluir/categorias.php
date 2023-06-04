<?php
    if (!isset($pagina))
        exit;

    require "configs/functions.php";

    if (empty($id)) {
        mensagem("Erro","Não foi possível excluir o registro. Tente novamente.");
    }

    //verificar se existe um produto cadastrado com esta categoria
    $sqlProduto = "select id from produtos where categorias_id = :id limit 1";
    $consultaProduto = $pdo->prepare($sqlProduto);
    $consultaProduto->bindParam(":id", $id);
    $consultaProduto->execute();

    $dados = $consultaProduto->fetch(PDO::FETCH_OBJ);

    if (!empty($dados->id)) {
        mensagem("Erro","Esta categoria não pode ser excluída pois existe um produto utilizando o registro");
    }

    //excluir o registro
    $sqlExcluir = "delete from categorias where id = :id limit 1";
    $consultaExcluir = $pdo->prepare($sqlExcluir);
    $consultaExcluir->bindParam(":id", $id);

    if ( $consultaExcluir->execute() ){
        mensagem("Sucesso","Registro excluído com sucesso");
    } else {
        mensagem("Erro","Erro ao tentar excluir o registro");
    }