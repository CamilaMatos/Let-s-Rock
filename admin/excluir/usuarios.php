<?php
    if (!isset($pagina))
        exit;

    require "configs/functions.php";

    if (empty($id)) {
        mensagem("Erro","Não foi possível excluir o registro. Tente novamente.");
    }

    //excluir o registro
    $sqlExcluir = "delete from usuarios where id = :id limit 1";
    $consultaExcluir = $pdo->prepare($sqlExcluir);
    $consultaExcluir->bindParam(":id", $id);

    if ( $consultaExcluir->execute() ){
        mensagem("Sucesso","Registro excluído com sucesso");
    } else {
        mensagem("Erro","Erro ao tentar excluir o registro");
    }