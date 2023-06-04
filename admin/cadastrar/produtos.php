<?php
    if (!isset($pagina))
        exit;

    if(!empty($id)) {
        $sqlProduto = "select * from produtos where id = :id LIMIT 1";
        $consultaProduto = $pdo->prepare($sqlProduto);
        $consultaProduto->bindParam(":id", $id);
        $consultaProduto->execute();

        //recuperar dados do sql
        $dados = $consultaProduto->fetch(PDO::FETCH_OBJ);
    }

    $id = $dados->id ?? NULL;
    $produto = $dados->produto ?? NULL;
    $valor = $dados->valor ?? NULL;
    $categorias_id = $dados->categoria_id ?? NULL;
    $descricao = $dados->descrição ?? NULL;
    $imagem = $dados->imagem ?? NULL;

?>
<div class="card">
    <div class="card-header">
        <strong>Cadastro de Produtos</strong>

        <div class="float-end">
            <a href="cadastrar/produtos" class="btn btn-success btn-sm">
                <i class="fas fa-file"></i> Novo Produto
            </a>
            <a href="listar/produtos" class="btn btn-info btn-sm">
                <i class="fas fa-search"></i> Lista de Produto
            </a>
        </div>
    </div>
    <div class="card-body">
        <form name = "formCadastro" method="post" enctype= "multipart/form-data" action = "salvar/produtos" data-parsley-validate = "">
            <label for = "id" >ID: </label>
            <input type = "text" name = "id" class = "form-control" readonly value = "<?=$id?>">
            <br>
            <label for = "produto">Nome do Produto: </label>
            <input type = "text" name = "produto" id = "produto" class = "form-control" required value = "<?=$produto?>" data-parsley-required-message = "Preencha o Produto">
            <br>
            <label for = "categorias_id">Categorias de Produto</label>
            <select name = "categorias_id" id = "categorias_id" class = "form-control" required data-parsley-required-message = "Selecione uma categoria">
                <option value = "">Selecione</option>
                <?php
                    $sqlCategoria = "Select * from categorias order by categoria";
                    $consultaCategoria = $pdo->prepare($sqlCategoria);
                    $consultaCategoria->execute();

                    while ($dadosCategoria = $consultaCategoria->fetch(PDO::FETCH_OBJ)){
                        ?>
                            <option value = "<?=$dadosCategoria->id?>">
                                <?=$dadosCategoria->categoria?>
                            </option>

                        <?php
                    }
                ?>
            </select>
            <br>
            <label for = "valor">Valor do Produto: </label>
            <input type="number" name = "valor" id = "valor" class = "form-control" value = "<?=$valor?>" required data-parsley-required-message="Preencha o Valor" inputmode="numeric">
            <br>
            <label for = "descricao">Descrição do Produto: </label>
            <textarea name = "descricao" id = "descricao" class = "form-control" required data-parsley-required-message="Preecha a descrição" rows = "5"><?=$descricao?></textarea>
            <br>
            <label for = "imagem">Selecione uma Imagem (JPG)</label>
            <input type = "file" name = "imagem" id = "imagem" class = "form-control" accept=".jpg">
            <br>
            <button type = "submit" class = "btn btn-success">
                <i class = "fas fa-check"></i> Salvar/Alterar Dados
            </button>


        </form>

    </div> <!--- fim do card body -->
</div> <!--fim do card --> 

<script>
    // Botar mascara na parada 
    
    VMasker(document.querySelector("#valor")).maskMoney({
        precision: 2,
        separator: ',',
        delimiter: '.',
        zeroCents: false
    });

$("#descricao").summernote({
    heigth: 200,
    lang: "pt-br"
});

</script>