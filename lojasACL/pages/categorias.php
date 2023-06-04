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

<!--apresentando o banner promocional -->
<img src="../../admin/fotos/<?= $imagem ?>.jpg" class="img-fluid" alt="<?= $imagem ?>">
<br>

<h1>Categorias</h1>

<!-- puxar todos as categorias -->
<?php
    if(empty($_POST["busca"])){
        //sql caso não seja usada a barra de pesquisa do header
        $sql = "select * from categorias 
                order by categoria";
        $consulta = $pdo->prepare($sql);
        $consulta->execute();
    } else {
        //sql caso seja usada a barra de pesquisa do header
        $busca = "%" . trim($_POST["busca"] ?? NULL) . "%";
        $sql = "select * from categorias
        where categoria like :busca 
        order by categoria";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":busca", $busca);
        $consulta->execute();
    }
?>

<!-- apresentando as categorias na página -->
<div class="container text-center">
    <div class="row row-cols-3">
        <?php
            //while para percorrer o $dados e apresentar todas as categorias pexadas
            while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
        ?>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <!-- passando o id da categoria para ser apresentado apenas os produtos dessa categoria na página categoria.php -->
                    <a href = "pages/categoria/<?=$dados->id?>" title ="id Categoria" class="card-title"><?= $dados->categoria?></a>
                </div>
            </div>
            <br>
        </div>
        <?php
            }//fechando o while
        ?>
    </div>
</div>