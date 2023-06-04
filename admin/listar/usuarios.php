<?php
    if (!isset($pagina))
    exit;
?>

<div class="card">
    <div class="card-header">
        <strong>Listar Usuarios</strong>

        <div class="float-end">
            <a href="cadastrar/usuarios" class="btn btn-success btn-sm" title="Novo registro">
                <i class="fas fa-file"></i> Novo Usuario
            </a>
            <a href="listar/usuarios" class="btn btn-info btn-sm">
                <i class="fas fa-search"></i> Listar Usuario
            </a>
        </div>
    </div>
    <div class="card-body">
    <table class = "table table-houver table-bordered table-striped">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Nome</td>
                    <td>Login</td>
                    <td>Senha</td>
                    <td>Ativo</td>
                    <td>Opções</td>
                </tr>
            </thead>
        <tbody>
            <?php
                $sqlUsuarios = "select * from usuarios order by nome";
                $consultaUsuario = $pdo->prepare($sqlUsuarios);
                $consultaUsuario->execute();

                while ($d = $consultaUsuario->fetch(PDO::FETCH_OBJ)){
                    ?>
                        <tr>
                            <td><?=$d->id?></td>
                            <td><?=$d->nome?></td>
                            <td><?=$d->login?></td>
                            <td><?=$d->senha?></td>
                            <td><?=$d->ativo?></td>
                            <td class = text-center>
                                <!-- Icone Editar  -->
                                <a href = "cadastrar/usuarios/<?=$d->id?>" title = "Editar" class = "btn btn-success btn-sm">
                                    <i class = "fas fa-edit"></i>
                                </a>

                                <!-- Icone Excluir -->
                                <a href = "javascript:excluir(<?=$d->id?>)" title = "Excluir" class = "btn btn-danger btn-sm">
                                    <i class = "fas fa-trash"></i>
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
                location.href = "excluir/usuarios/" + id;
            }
        })
    }
</script>
    