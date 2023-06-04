<?php
    if (!isset($pagina))
        exit;
?>

<div class="card">
    <div class="card-header">
        <strong>Listagem de Categorias</strong>

        <div class="float-end">
            <a href="cadastrar/categorias" class="btn btn-success btn-sm">
                <i class="fas fa-file"></i> Novo Cadastro
            </a>
            <a href="listar/categorias" class="btn btn-info btn-sm">
                <i class="fas fa-search"></i> Listar Cadastros
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Nome da Categoria</td>
                    <td width="100px">Opções</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sqlCategorias = "select * from categorias order by categoria";
                    $consultaCategorias = $pdo->prepare($sqlCategorias);
                    $consultaCategorias->execute();

                    while ($dados = $consultaCategorias->fetch(PDO::FETCH_OBJ)) {
                        ?>
                        <tr>
                            <td><?=$dados->id?></td>
                            <td><?=$dados->categoria?></td>
                            <td class="text-center">
                                <a href="cadastrar/categorias/<?=$dados->id?>" title="Editar"
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
                location.href = "excluir/categorias/" + id;
            }
        })
    }
</script>