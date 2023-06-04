<?php
    if (!isset($pagina))
        exit;

    require "configs/functions.php";

    if (empty($id)) {
        mensagem("Erro","Não foi possível excluir o registro. Tente novamente.");
    }

    //verificar se existe uma venda cadastrada com esta forma
    $sqlVenda = "select id from vendas where formas_id = :id limit 1";
    $consultaVenda = $pdo->prepare($sqlVenda);
    $consultaVenda->bindParam(":id", $id);
    $consultaVenda->execute();

    $dados = $consultaVenda->fetch(PDO::FETCH_OBJ);

    if (!empty($dados->id)) {
        mensagem("Erro","Esta forma não pode ser excluída pois existe uma venda utilizando o registro");
    }

    //excluir o registro
    $sqlExcluir = "delete from formas where id = :id limit 1";
    $consultaExcluir = $pdo->prepare($sqlExcluir);
    $consultaExcluir->bindParam(":id", $id);

    if ( $consultaExcluir->execute() ){
        mensagem("Sucesso","Registro excluído com sucesso");
    } else {
        mensagem("Erro","Erro ao tentar excluir o registro");
    }