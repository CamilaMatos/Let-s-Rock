<?php
    if (!isset($pagina))
        exit;

    //puxando banner
    $sql = "select * from banner order by rand() limit 1";
    $consulta = $pdo->prepare($sql);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);
    $imagem = $dados->banner;

    //puxando a categoria - id está sendo passado pela url
    $sqlCategoria = "select * from categorias 
            where id = :id limit 1";
    $consultaCategoria = $pdo->prepare($sqlCategoria);
    $consultaCategoria->bindParam(":id", $id);
    $consultaCategoria->execute();
    $dadosCategoria = $consultaCategoria->fetch(PDO::FETCH_OBJ)
?>

<!--apresentando banner promocional -->
<img src="../../admin/fotos/<?= $imagem ?>.jpg" class="img-fluid" alt="<?= $imagem ?>">
<br>

<!-- apresentando o nome da categoria puxado pelo sqlCategoria -->
<h1><?= $dadosCategoria->categoria ?></h1>

<!-- puxando todos os produtos que pertencem a essa categoria-->
<?php
    if (!empty($_POST["busca"])) {
        //para caso seja a barra de pesquisa do header

        //puxando a string inserida na barra de pesquisa do header
        $busca = "%" . trim($_POST["busca"] ?? NULL) . "%";

        //sql para puxar os produtos dessa categoria que possuem em seu nome o $busca
        $sqlProdutos = "select p.*, c.categoria from produtos p 
            inner join categorias c on (c.id = p.categorias_id)
            where p.produto like :busca AND c.id = :id
            order by p.produto";
        $consultaProduto = $pdo->prepare($sqlProdutos);
        $consultaProduto->bindParam(":busca", $busca);
        $consultaProduto->bindParam(":id", $id);
        $consultaProduto->execute();
    } else {
        //para caso não seja utilizado a barra de pesquisa

        //sql para puxar os produtos
        $sqlProduto = "select p.*, c.categoria from produtos p 
            inner join categorias c on (c.id = p.categorias_id)
            where c.id = :id
            order by p.produto";
        $consultaProduto = $pdo->prepare($sqlProduto);
        $consultaProduto->bindParam(":id", $id);
        $consultaProduto->execute();
    }
?>

<!-- apresentando os produtos na página -->
<div class="container text-center">
    <div class="row row-cols-3">
        <?php
            //while para percorrer o $dados e apresentar todos os produtos puxados no sql
            while ($dados = $consultaProduto->fetch(PDO::FETCH_OBJ)) {
        ?>
        <div class="col">
            <div class="card">
                <img src="../../admin/fotos/<?= $dados->imagem ?>m.jpg" class="card-img-top" alt="<?= $dados->produto ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $dados->produto ?></h5>
                    <p class="card-text"><?= $dados->descricao ?></p>
                    <!-- passando no href o id do produto que deve ser apresentado na página produto.php -->
                    <a href="pages/produto/<?= $dados->id ?>" class="btn btn-primary">Detalhes</a>
                </div>
            </div>
            <br>
        </div>
        <?php
            //fechando o while
            }
        ?>
    </div>
</div>