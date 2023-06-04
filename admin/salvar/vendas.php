<?php
    if (!isset($pagina))
        exit;

    require "configs/functions.php";

    if($_POST){
        //recuperar as variaveis
        // $id = trim($_POST["id"] ?? NULL);
        // $clientes_id = trim($_POST["clientes_id"] ?? NULL);
        // $formas_id = trim($_POST["formas_id"] ?? NULL);
        // $usuarios_id = trim($_POST["usuarios_id"] ?? NULL);
        // $data = trim($_POST["data"] ?? NULL);
        // $status = trim($_POST["status"] ?? NULL);

        foreach($_POST as $key => $value){
            // echo "<p>{$key} - {$value}</p>";

            $$key = trim($value ?? NULL);

            if(($key != "id") AND (empty($value))){
                mensagem("Erro!", "Um dado solicitado está em branco");
            }
        }
        $data = formatarData($data);


        //Verificar se os campos estão vazios
        if(empty($id)){

            $sql = "insert into vendas values(NULL, :data, :status, :clientes_id, :usuarios_id, :formas_id)";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":data", $data);
            $consulta->bindParam(":status", $status);
            $consulta->bindParam(":clientes_id", $clientes_id);
            $consulta->bindParam(":usuarios_id", $usuarios_id);
            $consulta->bindParam(":formas_id", $formas_id);
        }else{
            $sql = "update vendas set data = :data, status =  :status, clientes_id = :clientes_id, usuarios_id = :usuarios_id, formas_id = :formas_id wherer id = :id LIMIT 1";
            $consulta = $pdo->prepare($slq);
            $consulta->bindParam(":data", $data);
            $consulta->bindParam(":status", $status);
            $consulta->bindParam(":clientes_id", $clientes_id);
            $consulta->bindParam(":usuarios_id", $usuarios_id);
            $consulta->bindParam(":formas_id", $formas_id);
            $consulta->bindParam(":id", $id);
        }

        if($consulta->execute()){
            //pegar o ID do registro
            $id = $pdo->lastInsertId() ?? $id;
            //redirecionar para a pagina de vendas 
            echo "<script>location.href = 'cadastrar/vendas/{$id}'</script>";
        }else{
            mensagem("Erro", "não foi possivel cadastrar");
        }
    }else{
        mensagem("Erro", "Requisição inválida");
    }

?>