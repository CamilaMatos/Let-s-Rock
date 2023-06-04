<?php
    if (!isset($pagina))
        exit;
?>

<div class="card">
    <div class="card-header">
        <strong>Listagem de Produtos</strong>

        <div class="float-end">
            <a href="cadastrar/categorias" class="btn btn-success btn-sm">
                <i class="fas fa-file"></i> Novo Produto
            </a>
            <a href="listar/categorias" class="btn btn-info btn-sm">
                <i class="fas fa-search"></i> Listar Produtos
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Nome do Produto</td>
                    <td>Categoria</td>
                    <td>Valor</td>
                    <td>Descrição</td>
                    <td>Imagem</td>
                    <td width="100px">Opções</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sqlProdutos = "select p.*, categoria from produtos p 
                                    inner join categorias c on (c.id = p.categorias_id)
                                    order by p.produto";
                    $consultaProduto = $pdo->prepare($sqlProdutos);
                    $consultaProduto->execute();

                    While ($dados = $consultaProduto->fetch (PDO::FETCH_OBJ)){
                        ?>
                         <tr>
                            <td><?=$dados->id?></td>
                            <td><?=$dados->produto?></td>
                            <td><?=$dados->categoria?></td>
                            <td><?=$dados->valor?></td>
                            <td><?=$dados->descricao?></td>
                            <td><img src = "fotos/<?=$dados->imagem?>p.jpg" alt = "<?=$dados->produto?>" width="100px"> </td>
                            <td class="text-center">
                                <a href="cadastrar/produtos/<?=$dados->id?>" title="Editar"
                                class="btn btn-success btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="javascript:excluir(<?=$dados->id?>)" title="Excluir"
                                class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>

                        <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    //iniciar o dataTables
    $(document).ready(function(){
        $(".table").DataTable({
            language: {
                lengthMenu: 'Mostrar _MENU_ registros por página',
                zeroRecords: 'Sem resultados encontrados',
                info: 'Mostrando página _PAGE_ de _PAGES_',
                infoEmpty: 'Nenhum resultado',
                infoFiltered: '(Filtrando de _MAX_ resultados)',
                search: 'Busca',
            },
        });
    })

    function excluir(id) {
        Swal.fire({
            icon: "warning",
            title: "Você deseja mesmo excluir este registro?",
            showCancelButton: true,
            confirmButtonText: "Excluir",
            cancelButtonText: "Cancelar",
        }).then((result)=>{
            if (result.isConfirmed) {
                location.href = "excluir/produtos/" + id;
            }
        })
    }
</script>