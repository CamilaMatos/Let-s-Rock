<?php
    if (!isset($pagina))
        exit;

    //puxando o banner
    $sql = "select * from banner order by rand() limit 1";
    $consulta = $pdo->prepare($sql);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);
    $imagem = $dados->banner;
?>

<!--apresentando banner promocional -->
<img src="../../admin/fotos/<?=$imagem?>.jpg" class="img-fluid" alt="<?=$imagem?>">
<br>

<h1>Mais Comprados</h1>

<!-- puxar todos os produtos classificados como mais comprados-->
<?php
    if (empty($_POST["busca"])){
        //sql caso não seja utilizada a barra de pesquisa do header
        $sqlProduto = "select p.*, e.maisComprados from produtos p
        inner join especiais e on (e.id = p.id)
        where e.maisComprados = 'S'
        order by p.produto";
        $consultaProduto = $pdo->prepare($sqlProduto);
        $consultaProduto->execute();

    } else {
        //puxando a string inserida na barra de pesquisa
        $busca = "%".trim($_POST["busca"] ?? NULL)."%";

        //sql caso seja utilizada a barra de pesquisa do header
        $sqlProduto = "select p.*, e.maisComprados from produtos p
        inner join especiais e on (e.id = p.id)
        where e.maisComprados = 'S'
        AND p.produto like :busca
        order by p.produto";
        $consultaProduto = $pdo->prepare($sqlProduto);
        $consultaProduto->bindParam(":busca", $busca);
        $consultaProduto->execute();
    }
    ?>
    
    <div class="container text-center">
        <div class="row row-cols-3">

    <?php
        //while para percorrer o $dados e apresentar na página todos os produtos puxados no sql
        While ($dados = $consultaProduto->fetch (PDO::FETCH_OBJ)){
    ?>
    <div class="col">
        <div class="card">
            <img src="../../admin/fotos/<?=$dados->imagem?>m.jpg" class="card-img-top" alt="<?=$dados->produto?>">

            <div class="card-body">
                <h5 class="card-title"><?=$dados->produto?></h5>
                <p class="card-text"><?=$dados->descricao?></p>
                <!-- passando o id do produto para ser apresentado na página produto.php -->
                <a href="pages/produto/<?=$dados->id?>" class="btn btn-primary">Detalhes</a>
            </div>
        </div>
        <br>
    </div>
    <?php
        }//fechando o while
    ?>
    </div>
    </div>