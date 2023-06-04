<?php
  if (!isset($pagina))
    exit;

  //puxando banner
  $sql = "select * from banner order by rand() limit 1";
  $consulta = $pdo->prepare($sql);
  $consulta->execute();
  $dados = $consulta->fetch(PDO::FETCH_OBJ);
  $imagem = $dados->banner;

  //sql para puxar 3 produtos aleatórios que serão apresentados no "Recomendados"
  $sqlProduto = "select p.*, c.categoria from produtos p 
      inner join categorias c on (c.id = p.categorias_id)
      order by rand() limit 3";
  $consultaProduto = $pdo->prepare($sqlProduto);
  $consultaProduto->execute();
  $dadosProduto = $consultaProduto->fetch(PDO::FETCH_OBJ);
?>

<!--apresentando banner promocional -->
<img src="../../admin/fotos/<?= $imagem ?>.jpg" class="img-fluid" alt="<?= $imagem ?>">
<br>

<h1>Home</h1>

<!-- Carrosel de produtos Recomendados-->
<h2>Recomendados</h2>
<div id="produtos" class="carousel carousel-dark slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#produtos" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#produtos" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#produtos" data-bs-slide-to="2" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#produtos" data-bs-slide-to="3" aria-label="Slide 4"></button>
  </div>
  <div class="carousel-inner">
    <?php
      //while para percorrer o $dadosProduto e apresentar os produtos puxados no sql
      while ($dadosProduto = $consultaProduto->fetch(PDO::FETCH_OBJ)) {
    ?>
  <div class="carousel-item active">
    <!-- passando o id do produto para esse produto ser apresentado na página produto.php quando clicar na imagem  -->
    <a href="pages/produto/<?= $dadosProduto->id ?>"><img src="../../admin/fotos/<?= $dadosProduto->imagem ?>m.jpg" class="d-block w-100" alt="<?= $dadosProduto->produto ?>"></a>
    <div class="carousel-caption d-none d-md-block">
      <h5><?= $dadosProduto->produto ?></h5>
      <p><?= $dadosProduto->descricao ?></p>
    </div>
  </div>
    <?php
      }//fechando o while
    ?>
  <div class="carousel-item">
    <!-- Colocar uma imagem de mais produtos -->
    <a href="pages/produtos"><img src="../../admin/images/icone.png" class="d-block w-100" alt="Mais produtos"></a>
    <div class="carousel-caption d-none d-md-block">
      <h5>Mais Produtos</h5>
    </div>
  </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#produtos" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#produtos" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<br>

<!-- Carrosel de produtos de uma categoria aleatória-->
<?php
  //puxando uma categoria aleatória
  $sqlCategorias = "select * from categorias order by rand() limit 1";
  $consultaCategorias = $pdo->prepare($sqlCategorias);
  $consultaCategorias->execute();
  $dadosCategorias = $consultaCategorias->fetch(PDO::FETCH_OBJ);

  //puxando os produtos da categoria sorteada
  $sqlProduto2 = "select p.*, c.categoria from produtos p 
  inner join categorias c on (c.id = p.categorias_id)
  where c.id = :categoria
  order by rand() limit 3";
  $consultaProduto2 = $pdo->prepare($sqlProduto2);
  $consultaProduto2->bindParam(":categoria", $dadosCategorias->id);
  $consultaProduto2->execute();
?>
<!-- apresentando o nome da categoria sorteada -->
<h2><?= $dadosCategorias->categoria ?></h2>
<div id="produtosCategoria" class="carousel carousel-dark slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#produtosCategoria" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#produtosCategoria" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#produtosCategoria" data-bs-slide-to="2" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#produtosCategoria" data-bs-slide-to="3" aria-label="Slide 4"></button>
  </div>
  <div class="carousel-inner">
    <?php
      //while para percorrer o $dadosProduto2 e apresentar os produtos puxados no sql 
      while ($dadosProduto2 = $consultaProduto2->fetch(PDO::FETCH_OBJ)) {
    ?>
      <div class="carousel-item active">
        <!-- passando o id do produto para esse produto ser apresentado na página produto.php quando clicar na imagem  -->
        <a href="pages/produto/<?= $dadosProduto2->id ?>"><img src="../../admin/fotos/<?= $dadosProduto2->imagem ?>m.jpg" class="d-block w-100" alt="<?= $dadosProduto2->produto ?>"></a>
        <div class="carousel-caption d-none d-md-block">
          <h5><?= $dadosProduto2->produto ?></h5>
          <p><?= $dadosProduto2->descricao ?></p>
        </div>
      </div>
    <?php
      }//fechando while
    ?>
    <div class="carousel-item">
      <!-- Colocar uma imagem de mais produtos -->
      <!-- passando o id da categoria para ser apresentado na página categoria.php os produtos dessa categoria quando clicar na imagem  -->
      <a href="pages/categoria/<?= $dadosCategorias->id ?>"><img src="../../admin/images/icone.png" class="d-block w-100" alt="Mais produtos"></a>
      <div class="carousel-caption d-none d-md-block">
        <h5>Mais Produtos dessa Categoria</h5>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#produtosCategoria" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#produtosCategoria" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<br>

<!-- Carrosel de produtos mais comprados-->
<?php
  //puxando 3 produtos aleátorios classificados como mais comprados
  $sqlProduto3 = "select p.*, e.maisComprados from produtos p
  inner join especiais e on (e.id = p.id)
  where e.maisComprados = 'S'
  order by rand() limit 3";
  $consultaProduto3 = $pdo->prepare($sqlProduto3);
  $consultaProduto3->execute();
?>
<h2>Mais Comprados</h2>
<div id="produtosMaisComprados" class="carousel carousel-dark slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#produtosMaisComprados" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#produtosMaisComprados" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#produtosMaisComprados" data-bs-slide-to="2" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#produtosMaisComprados" data-bs-slide-to="3" aria-label="Slide 4"></button>
  </div>
  <div class="carousel-inner">
    <?php
      //while para percorrer o $dadosProduto3 e apresentar os produtos puxados no sql 
      while ($dadosProduto3 = $consultaProduto3->fetch(PDO::FETCH_OBJ)) {
    ?>
      <div class="carousel-item active">
        <!-- passando o id do produto para esse produto ser apresentado na página produto.php quando clicar na imagem  -->
        <a href="pages/produto/<?= $dadosProduto3->id ?>"><img src="../../admin/fotos/<?= $dadosProduto3->imagem ?>m.jpg" class="d-block w-100" alt="<?= $dadosProduto3->produto ?>"></a>
        <div class="carousel-caption d-none d-md-block">
          <h5><?= $dadosProduto3->produto ?></h5>
          <p><?= $dadosProduto3->descricao ?></p>
        </div>
      </div>
    <?php
      }//fechando o while
    ?>
    <div class="carousel-item">
      <!-- Colocar uma imagem de mais produtos -->
      <a href="pages/maisComprados"><img src="../../admin/images/icone.png" class="d-block w-100" alt="Mais produtos"></a>
      <div class="carousel-caption d-none d-md-block">
        <h5>Mais Produtos</h5>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#produtosMaisComprados" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#produtosMaisComprados" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>