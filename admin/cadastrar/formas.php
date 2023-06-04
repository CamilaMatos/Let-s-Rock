<?php
    if (!isset($pagina))
        exit;

    //verificar se o id não está vazio
    if (!empty($id)) {
        $sqlFormas = "select * from formas where id = :id limit 1";
        $consultaFormas = $pdo->prepare($sqlFormas);
        $consultaFormas->bindParam(":id", $id);
        $consultaFormas->execute();

        $dados = $consultaFormas->fetch(PDO::FETCH_OBJ);
    }

    $id = $dados->id ?? NULL;
    $forma = $dados->forma ?? NULL;
?>

<div class="card">
    <div class="card-header">
        <strong>Cadastro de Formas de Pagamento</strong>

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
        <form name="formCadastro" method="post" action="salvar/formas" data-parsley-validate="">
            <label for="id">ID:</label>
            <input type="text" name="id" id="id" class="form-control" readonly value="<?=$id?>">
            <br>
            <label for="forma">Digite o nome da Forma de Pagamento:</label>
            <input type="text" name="forma" id="forma" class="form-control"
            required data-parsley-required-message="Por favor, preencha a forma de pagamento"
            value="<?=$forma?>">
            <br>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-check"></i> Salvar Dados
            </button>
        </form>
    </div>
</div>