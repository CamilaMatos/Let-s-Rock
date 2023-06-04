<?php
    if (!isset($pagina))
        exit;
?>

<div class="card">
    <div class="card-header">
        <strong>Listagem de Vendas</strong>

        <div class="float-end">
            <a href="cadastrar/vendas" class="btn btn-success btn-sm">
                <i class="fas fa-file"></i> Nova Venda
            </a>
            <a href="listar/vendas" class="btn btn-info btn-sm">
                <i class="fas fa-search"></i> Listar Vendas
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php
            $sql= "select v.id, date_format(v.data, '%d/%m/%Y') data, c.nome, v.status 
            from vendas v
            inner join clientes c on (c.id = v.clientes_id)
            order by v.data desc";
            $consulta= $pdo->prepare($sql);
            $consulta->execute();
        ?>
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Nome do cliente</td>
                    <td>Data de Venda</td>
                    <td>Status</td>
                    <td>Opções</td>
                </tr>
            </thead>

        <tbody>
            <?php
            while ($dados= $consulta->fetch(PDO::FETCH_OBJ)) {
                    if($dados->status == "A") {
                        $status = "Aguardando Pagamento";
                    } else if($dados->status == "p") {
                        $status = "Paga";
                    } else {
                        $status= "Cancelada";
                    }
                        
                ?>
                    <tr>
                        <td><?=$dados->id?></td>
                        <td><?=$dados->nome?></td>
                        <td><?=$dados->data?></td>
                        <td><?=$status?></td>
                        <td>
                            <a href="cadastrar/vendas/<?=$dados->id?>" class="btn btn-success btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                <?php
            }
            ?>
        </tbody>

    </table>