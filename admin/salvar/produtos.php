<?php
    if (!isset($pagina))
        exit; 

    require "configs/functions.php";

    if(!empty($_FILES["imagem"]["name"])){
        //copiar a imagem para o servidor

        if(!copy($_FILES["imagem"]["tmp_name"], "fotos/".$_FILES ["imagem"]["name"])){
            mensagem("Erro!", "Erro ao copiar imagem");
        }

        $imagem = "produto_" . time();

        loadImg("fotos/".$_FILES["imagem"]["name"], $imagem);
    }


    $id = trim($_POST["id"] ?? NULL);
    $produto = trim($_POST["produto"] ?? NULL);
    $valor = trim($_POST["valor"] ?? NULL);
    $categorias_id = trim($_POST["categorias_id"] ?? NULL);
    $descricao = trim($_POST["descricao"] ?? NULL);

    if(empty($produto)){
        mensagem("Erro!","Preencha o Nome do Produto");
    } else if(empty($valor)){
        mensagem("Erro!","Preencha o Valor");
    } else if(empty($categorias_id)){
        mensagem("Erro!","Preencha a Categoria");
    } else if(empty($descricao)){
        mensagem("Erro!","Preencha a Descrição");
    }

        //valor =  5.990,00 -> 5990.90 formata valor
        $valor = formatarValor($valor);

        if(empty($id)){
            //insert
            $sql = "insert into produtos values (NULL, :produto, :categorias_id, :valor, :descricao, :imagem)";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":produto", $produto);
            $consulta->bindParam(":categorias_id", $categorias_id);
            $consulta->bindParam(":valor", $valor);
            $consulta->bindParam(":descricao", $descricao);
            $consulta->bindParam(":imagem", $imagem);

        } else if(empty($imagem)){
            $sql = "update produtos set produto = :produto, categorias_id = :categorias_id, valor = :valor, descricao = :descricao where = :id limit 1";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":produto", $produto);
            $consulta->bindParam(":categorias_id", $categorias_id);
            $consulta->bindParam(":valor", $valor);
            $consulta->bindParam(":descricao", $descricao);
            $consulta->bindParam(":imagem", $imagem);
            $consulta->bindParam(":id", $id);


        } else{
            $sql = "update produtos set produto = :produto, categorias_id = :categorias_id, valor = :valor, descricao = :descricao, imagem = :imagem where = :id limit 1";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":produto", $produto);
            $consulta->bindParam(":categorias_id", $categorias_id);
            $consulta->bindParam(":valor", $valor);
            $consulta->bindParam(":descricao", $descricao);
            $consulta->bindParam(":imagem", $imagem);
            $consulta->bindParam(":id", $id);

            
        }

        //executar o sql
        if($consulta->execute()){
            mensagem("Sucesso", "Registro Salvo/Atualizado com Sucesso");
        }else{
            mensagem("Erro!", "Erro ao Salvar/Atualizar registro");
        }
?>