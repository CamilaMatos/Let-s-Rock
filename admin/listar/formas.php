<?php
    if (!isset($pagina))
        exit;
?>

<div class="card">
    <div class="card-header">
        <strong>Listagem de Formas de Pagamento</strong>

        <div class="float-end">
            <a href="cadastrar/formas" class="btn btn-success btn-sm">
                <i class="fas fa-file"></i> Novo Cadastro
            </a>
            <a href="listar/formas" class="btn btn-info btn-sm">
                <i class="fas fa-search"></i> Listar Cadastros
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Formas de Pagamento</td>
                    <td width="100px">Opções</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sqlFormas = "select * from formas order by forma";
                    $consultaFormas = $pdo->prepare($sqlFormas);
                    $consultaFormas->execute();

                    while ($dados = $consultaFormas->fetch(PDO::FETCH_OBJ)) {
                        ?>
                        <tr>
                            <td><?=$dados->id?></td>
                            <td><?=$dados->forma?></td>
                            <td class="text-center">
                                <a href="cadastrar/formas/<?=$dados->id?>" title="Editar"
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
                location.href = "excluir/formas/" + id;
            }
        })
    }
</script>