<?php
    if (!isset($pagina))
        exit;

//A venda pelo id -> caso esteja editando 
if (!empty($id)){
    $sqlVenda = "Select *, date_format(data, '%d%m%Y') data from vendas where id = :id limit 1";
    $consultaVenda = $pdo->prepare($sqlVenda);
    $consultaVenda->bindParam(":id", $id);
    $consultaVenda->execute();

    //recuperar os dados
    $dados = $consultaVenda->fetch(PDO::FETCH_OBJ);

}

$id = $dados->id ?? NULL;
$data = $dados->data ?? date("d/m/Y");
$clientes_id = $dados->clientes_id ?? NULL;
$formas_id = $dados->formas_id ?? NULL;
$status = $dados->status ?? NULL;
$usuarios_id = $dados->usuarios_id ?? NULL;



?>

<div class="card">
    <div class="card-header">
        <strong>Cadastro de Vendas</strong>

        <div class="float-end">
            <a href="cadastrar/vendas" class="btn btn-success btn-sm">
                <i class="fas fa-file"></i> Nova Venda
            </a>
            <a href="listar/vendas" class="btn btn-info btn-sm">
                <i class="fas fa-search"></i> Lista de Vendas
            </a>
        </div>
    </div>
    <div class="card-body">
        <form name = "formVenda" method="post" action = "salvar/vendas" data-parsley-validade>
            <label for = "id">ID:</label>
            <input type = "text" name = "id" id = "id" value="<?=$id?>" class = "form-control" readonly>

            <label for = "clientes_id"> Clientes</label>
            <select name = "clientes_id" id = "clientes_id" class = "form-control" required 
            data-parsley-required-message = "Selecione um Cliente">
                <option value = ""></option>
                        <!-- Procurar no banco os clientes -->
                    <?php
                        $sql = "select * from clientes order by nome";
                        $consulta = $pdo->prepare($sql);
                        $consulta->execute();

                        while ($dados = $consulta->fetch(PDO::FETCH_OBJ)){
                            ?>
                            <option value="<?=$dados->id?>">
                                <?=$dados->nome?>
                            </option>

                            <?php
                        }
                    ?>

            </select>

            <label for = "usuarios_id">Vendedor:</label>
            <select name = "usuarios_id" id = "usuarios_id" required data-parsley-required-message = "Selecione um Vendedor" class = "form-control">
                <option value = "">
                    <?php
                        $sql = "select * from usuarios order by nome";
                        $consulta = $pdo->prepare($sql);
                        $consulta->execute();
                        while ($dados = $consulta->fetch(PDO::FETCH_OBJ)){
                            ?>
                            <option value="<?=$dados->id?>">
                                <?=$dados->nome?>
                            </option>
                            <?php
                        }
                    ?>
                </option>
            </select>
            <label for = "formas_id">Forma de Pagamento</label>
            <select name = "formas_id" id = "formas_id" required data-parsley-required-message = "Selecione uma Forma de Pagamento" class = "form-control">
                <option value = "">
                    <?php
                        $sql = "select * from formas order by forma";
                        $consulta = $pdo->prepare($sql);
                        $consulta->execute();
                        while ($dados = $consulta->fetch(PDO::FETCH_OBJ)){
                            ?>
                            <option value="<?=$dados->id?>">
                                <?=$dados->forma?>
                            </option>
                            <?php
                        }
                    ?>
                </option>
            </select>
            <label for = "status">Status</label>
            <select name = "status" id = "status" required data-parsley-required-message = "Selecione um Status" class = "form-control">
                <option value = ""></option>
                <option value = "A">Aguardando Pagamento</option>
                <option value = "C">Cancelado</option>
                <option value = "P">Pago</option>
            </select>
            <label for = "data">Data da Venda:</label>
            <input type = "text" name = "data" id = "data" required required data-parsley-required-message = "Preencha a Data" class = "form-control" value = "<?=$data?>">
            <br>
            <button type = "submit" class = "btn btn-success">
                <i class = "fas fa-check"></i>Gravar / Alterar Dados
            </button>
            <!-- Button trigger modal -->
            <?php
            if(!empty($id)) {?>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Adicionar Produtos
            </button>
            <?php
            }
            ?>
        </form>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Adicionar Produtos</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
    <form name="formProdutos" method="post" action="produtos.php" data-parsley-validade="" target="produtos">
        <input type="hidden" name="venda_id" value="<?=$id?>">
            <div class="row">
                <div class="col-12 col-md-3">
                    <select name="produtos_id" require class="form-control" data-parsley-required-message="Seleci one um produto" onchange="buscarValor(this.value)">
                        <option value=""></option>
                        <?php
                            $sql= "select id, produto from produtos order by produto";
                            $consulta= $pdo->prepare($sql);
                            $consulta->execute();

                            while ($dados= $consulta->fetch(PDO::FETCH_OBJ)) {
                                ?>
                                <option value="<?=$dados->id?>"><?=$dados->produto?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <input type="number" name="quantidade" id="quantidade" class="form-control" placeholder="Qtde" required data-parsley-required-message="Insira uma quantidade" onblur="calcularTotal(this.value)">
                </div>
                <div class="col-12 col-md-3">
                    <input type="text" name="valor" id="valor" class="form-control" readonly placeholder="Valor">
                </div>
                <div class="col-12 col-md-3">
                    <input type="text" name="total" id="total" class="form-control" readonly placeholder="Total">
                </div>
                <div class="col-12 col-md-1">
                    <button type="submit" class="btn btn-success">OK</button>
                </div>
            </div>
        </form>
        <br>
        <iframe name="produtos" class="card" width="100%" height="300px" src="produtos.php?venda_id=<?=$id?>"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<script>
    //Adicionar mascaras
    VMasker(document.querySelector("#data")).maskPattern("99/99/9999");

    $("#clientes_id").val('<?=$clientes_id?>');
    $("#formas_id").val('<?=$formas_id?>');
    $("#usuarios_id").val('<?=$usuarios_id?>');
    $("#status").val('<?=$status?>');

    function buscarValor(id) {
        if (id == "") {
            Swal.fire({
                title: 'Erro',
                text: 'Produto inválido',
            })
        } else {
            $.post("buscarValor.php",{id:id},function(dados){
                
                if(dados.erro) {
                    Swal.fire({
                        title: 'Erro',
                        text: dados.erro
                    })
                } else {
                    $("#valor").val(dados.valor);
                }
            })
        }
    }
</script>