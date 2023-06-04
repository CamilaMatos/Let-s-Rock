<?php
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Origin: *");

    require "../configs/conexao.php";

    if(isset($_GET["param"])){
        $param = trim($_GET["param"]);
        $param = explode("/", $param);

    }

    //categoria, categorias, produto, produtos
    $opcao = $param[0] ?? NULL;
    //id
    $id = $param[1] ?? NULL;

    $resposta = array("Erro!"=>"Requisição Invalida");

    if($opcao == "produtos"){
        //mostrar todos os produtos cadastrados
        $sql = "select p.*, c.categoria 
                from produtos p
                inner join categorias c on (c.id = p.categorias_id) 
                order by p.produto";
        
        $consulta = $pdo->prepare($sql);
        $consulta->execute();
        $resposta = $consulta->fetchAll(PDO::FETCH_OBJ);
    } else if($opcao == "categorias"){
        $sql = "select * from categorias order by categoria";
        $consulta = $pdo->prepare($sql);
        $consulta->execute();
        $resposta = $consulta->fetchAll(PDO::FETCH_OBJ);
    } else if ((!empty($id) AND ($opcao == "produto"))){
        //mostrar todos os produtos cadastrados
        $sql = "select p.*, c.categoria 
                from produtos p
                inner join categorias c on (c.id = p.categorias_id)
                wherer p.id = :id limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->execute();
        $resposta = $consulta->fetch(PDO::FETCH_OBJ);

    } else if ((!empty($id) AND ($opcao == "categoria"))){
        //mostrar todos os produtos cadastrados
        $sql = "select * from categorias
                wherer p.id = :id limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->execute();
        $resposta = $consulta->fetch(PDO::FETCH_OBJ);
    }

    echo json_encode($resposta)

?>