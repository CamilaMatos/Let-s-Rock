<?php
    if (!isset($pagina))
        exit;

    //print_r($_POST);
    //print_r($_FILES);
    require "configs/functions.php";

    if (!empty($_FILES["foto"]["name"])) {

        //verificar se a imagem é jpg
        if ($_FILES["foto"]["type"] != "image/jpeg") {
            mensagem("Erro","Selecione uma imagem JPG");
        } else if (!copy($_FILES["foto"]["tmp_name"],"fotos/".$_FILES["foto"]["name"])) {
            mensagem("Erro","Não foi possível copiar a foto");
        }

        $foto = "clientes_".time();

        loadImg("fotos/".$_FILES["foto"]["name"], $foto);

    } 

    $id = trim($_POST["id"] ?? NULL);
    $nome = trim($_POST["nome"] ?? NULL);
    $email = trim($_POST["email"] ?? NULL);
    $telefone = trim($_POST["telefone"] ?? NULL);
    $cpf = trim($_POST["cpf"] ?? NULL);

    //verificar se os campos estão em branco
    if (empty($nome)) {
        mensagem("Erro","Preencha o nome");
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        mensagem("Erro","Digite um e-mail válido");
    }

    //validar o cpf
    validaCPF($cpf);

    //verificar se já existe o CPF no banco
    $sqlCPF = "select id from clientes where cpf = :cpf AND id <> :id limit 1";
    $consultaCPF = $pdo->prepare($sqlCPF);
    $consultaCPF->bindParam(":cpf", $cpf);
    $consultaCPF->bindParam(":id", $id);
    $consultaCPF->execute();

    //recuperar os dados
    $dadosCPF = $consultaCPF->fetch(PDO::FETCH_OBJ);
    if (!empty($dadosCPF->id)) {
        mensagem("Erro","Já existe alguém com este CPF no sistema");
    }



    //salvar o cliente
    if (empty($id)) {
        //inserir
        $sql = "insert into clientes values (NULL, :nome, :email, :cpf, :telefone, :foto)";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":nome", $nome);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":cpf", $cpf);
        $consulta->bindParam(":telefone", $telefone);
        $consulta->bindParam(":foto", $foto);
        
    } else if (empty($_FILES["foto"]["name"])) {
        //update menos na foto
        $sql = "update clientes set nome = :nome, email = :email, cpf = :cpf, telefone = :telefone where id = :id LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":nome", $nome);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":cpf", $cpf);
        $consulta->bindParam(":telefone", $telefone);
        $consulta->bindParam(":id", $id);
    } else {
        //update com foto
        $sql = "update clientes set nome = :nome, email = :email, cpf = :cpf, foto = :foto, telefone = :telefone where id = :id LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":nome", $nome);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":cpf", $cpf);
        $consulta->bindParam(":telefone", $telefone);
        $consulta->bindParam(":foto", $foto);
        $consulta->bindParam(":id", $id);
    }

    //executar
    if ($consulta->execute()) {
        mensagem("Sucesso!","Registro Salvo/Atualizado com sucesso!");
    } else {
        mensagem("Erro","Erro ao tentar Salvar/Atualizar registro!");
    }

?>