<?php
    session_start();
    if (!isset($_SESSION["usuarioAdm"])) {
        ?>
        <script>
            top.Swal.fire({
                title: 'Erro',
                text: 'Você precisa fazer o login'
            })
            </script>
            <?php

            exit;
    }

    $vendas_id = trim($_GET["venda_id"] ?? $_POST["venda_id"] ?? NULL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserindo Produtos</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
</head>
<body>
    <?php
    require "configs/conexao.php";
    require "configs/functions.php";

    $op = trim($_GET["op"] ?? NULL);

    if($op == "excluir") {
        $produtos_id = $_GET["produtos_id"] ?? NULL;
        $vendas_id = $_GET["vendas_id"] ?? NULL;

        $sql = "delete from itens where produtos_id = :produtos_id AND vendas_id = :vendas_id limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":vendas_id", $vendas_id);
        $consulta->bindParam(":produtos_id", $produtos_id);

        if($consulta->execute()) {
            echo "<p class='text-center alert alert-success'>Produto excluído!</p>";
        } else {
            echo "<p class='text-center alert alert-danger'>Erro ao excluir o produto!</p>";
        }
    }

    if($_POST){
        //esse if serve para caso for dado o POST mo formulário
        $produtos_id = trim($_POST["produtos_id"] ?? NULL);
        $quantidade = trim($_POST["quantidade"] ?? NULL);
        $valor = trim($_POST["valor"] ?? NULL);
        $valor = formatarValor($valor);

        $sql = "select vendas_id from itens
        where vendas_id = :vendas_id AND 
        produtos_id = :produtos_id limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":vendas_id", $vendas_id);
        $consulta->bindParam(":produtos_id", $produtos_id);
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        if(empty($dados->vendas_id)) {
            //inserir
            $sql= "insert into itens values (:vendas_id, :produtos_id, :valor, :quantidade)";
        } else {
            $sql= "update itens set qtde = :quantidade, valor = :valor 
            where vendas_id = :vendas_id AND produtos_id = :produtos_id limit 1";
        }
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":vendas_id", $vendas_id);
        $consulta->bindParam(":produtos_id", $produtos_id);
        $consulta->bindParam(":quantidade", $quantidade);
        $consulta->bindParam(":valor", $valor);
        
        if($consulta->execute()){
            echo "<p class='text-center alert alert-success'>Produto inserido com sucesso!</p>";
        } else {
            echo "<p class='text-center alert alert-danger'>Erro ao inserir o produto</p>";
        }
    }
    ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td>Nome do Produto</td>
                <td>Valor</td>
                <td>Quantidade</td>
                <td>Total</td>
                <td>Excluir</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "select i.vendas_id, i.produtos_id, i.valor, i.qtde, (i.valor * i.qtde) total, p.produto from itens i inner join produtos p on (p.id = i.produtos_id) where i.vendas_id = :vendas_id order by p.produto";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":vendas_id", $vendas_id);
            $consulta->execute();
            
            while($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                $valor = number_format($dados->valor, 2, ",",".");
                $total = number_format($dados->total, 2, ",",".");
                ?>
                <tr>
                    <td><?=$dados->produto?></td>
                    <td><?=$valor?></td>
                    <td><?=$dados->qtde?></td>
                    <td><?=$total?></td>
                    <td>
                        <a href="produtos.php?op=excluir&vendas_id=<?=$dados->vendas_id?>&produtos_id=<?=$dados->produtos_id?>" class="btn btn-danger"><i class="fas fa-trash" ></i></a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table> 
</body>
</html>