<?php
    if (!isset($pagina))
        exit;

    //puxando banner
    $sql = "select * from banner order by rand() limit 1";
    $consulta = $pdo->prepare($sql);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);
    $imagem = $dados->banner;
?>

<!--apresentando o banner promocional -->
<img src="../../admin/fotos/<?=$imagem?>.jpg" class="img-fluid" alt="<?=$imagem?>">
<br>

<h1>Nossa Equipe</h1>
<br>
<h2>Somos alunos de <strong>Tecnologia em Análise e Desenvolvimento de Sistemas</strong>, 5º perído!!!</h2>
<br>
<h3>Esse é um trabalho da disciplina de <strong>Programação Web Avançado</strong> do professor <strong>Anderson Fernandes Burnes</strong>.</h3>
<br>
<h4>Alunos:</h4>

<!-- puxando os dados da equipe -->
<?php
    $sqlEquipe = "select * from equipe order by nome";
    $consultaEquipe = $pdo->prepare($sqlEquipes);
    $consultaEquipe->execute();
    
    ?>
    
    <div class="container text-center">
        <div class="row row-cols-3">

    <?php
        //while para apresentar os membros da equipe na página
        While ($dados = $consultaEquipe->fetch (PDO::FETCH_OBJ)){
    ?>
    <div class="col">
        <div class="card">
            <img src="../../admin/fotos/<?=$dados->imagem?>.jpg" class="card-img-top" alt="<?=$dados->nome?>">

            <div class="card-body">
                <h5 class="card-title"><strong>Nome:</strong><?=$dados->nome?></h5>
                <h3 class="card-title"><strong>Idade:</strong><?=$dados->idade?></h3>
                <h3 class="card-title"><strong>E-mail:</strong><?=$dados->email?></h3>
                <h3 class="card-title"><strong>R.A.:</strong><?=$dados->ra?></h3>
            </div>
        </div>
        <br>
    </div>
    <?php
        }//fechando o while
    ?>
    </div>
    </div>