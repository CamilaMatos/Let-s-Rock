<?php
    if (!isset($pagina))
        exit;

    //verificar se o id não está vazio
    if (!empty($id)) {
        $sqlCategoria = "select * from categorias where id = :id limit 1";
        $consultaCategoria = $pdo->prepare($sqlCategoria);
        $consultaCategoria->bindParam(":id", $id);
        $consultaCategoria->execute();

        $dados = $consultaCategoria->fetch(PDO::FETCH_OBJ);
    }

    $id = $dados->id ?? NULL;
    $categoria = $dados->categoria ?? NULL;
?>

<div class="card">
    <div class="card-header">
        <strong>Cadastro de Categorias</strong>

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
        <form name="formCadastro" method="post" action="salvar/categorias" data-parsley-validate="">
            <label for="id">ID:</label>
            <input type="text" name="id" id="id" class="form-control" readonly value="<?=$id?>">
            <br>
            <label for="categoria">Digite o nome da Categoria:</label>
            <input type="text" name="categoria" id="categoria" class="form-control"
            required data-parsley-required-message="Por favor, preencha a categoria"
            value="<?=$categoria?>">
            <br>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-check"></i> Salvar Dados
            </button>
        </form>
    </div>
</div>