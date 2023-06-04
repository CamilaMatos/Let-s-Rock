<?php
  if (!isset($pagina))
    exit;
    require "configs/functions.php";

  //puxando banner
  $sql = "select * from banner order by rand() limit 1";
  $consulta = $pdo->prepare($sql);
  $consulta->execute();
  $dados = $consulta->fetch(PDO::FETCH_OBJ);
  $imagem = $dados->banner;

  //puxando o produto 
  $sqlProduto = "select p.*, c.categoria from produtos p 
      inner join categorias c on (c.id = p.categorias_id)
      where p.id = :id limit 1";
  $consultaProduto = $pdo->prepare($sqlProduto);
  $consultaProduto->bindParam(":id", $id);
  $consultaProduto->execute();
  $dadosProduto = $consultaProduto->fetch(PDO::FETCH_OBJ);
  $valor = $dadosProduto->valor;
  $valor = number_format($valor,2,",",".");
?>

<!--apresentando banner promocional -->
<img src="../../admin/fotos/<?= $imagem ?>.jpg" class="img-fluid" alt="<?= $imagem ?>">
<br>


<h1>Detalhes do Produto</h1>

<div class="row">
  <div class="col-sm-6 mb-3 mb-sm-0">
    <div class="card">
      <div class="card-body">
        <img src="../../admin/fotos/<?=$dadosProduto->imagem?>g.jpg" class="card-img-top" alt="<?=$dadosProduto->produto?>">
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title"><?=$dadosProduto->produto?></h5>
        <p class="card-text"><strong>Categoria: </strong><?=$dadosProduto->categoria?></p>
        <p class="card-text"><strong>Descrição: </strong><?=$dadosProduto->descricao?></p>
        <p class="card-text"><strong>Valor: </strong>R$ <?=$valor?></p>
        <!-- passando o id da categoria para serem apresentados apenas os produtos dessa categoria na página categoria.php -->
        <a href="pages/categoria/<?=$dadosProduto->categorias_id?>" class="btn btn-primary">Mais Produtos da mesma Categoria</a>
      </div>
    </div>
  </div>
</div>
<div class="card-body">
  <!-- form para carcular frete e valor do produto parcelado -->
  <form name="form" method="post" action="pages/produto/<?=$id?>">
    <label for="qtde">Quantidade:</label>
    <!-- input tipo number para impedir que insira o cep com "-" -->
    <input type="number" name="qtde" id="qtde" class="form-control">
    <label for="frete">Para calcular o frete, informe o seu CEP (sem o "-"):</label>
    <input type="number" name="frete" id="frete" class="form-control">
    <label for="parcelas">Você também pode comprar esse produto em até 6X sem juros!!! Confira o valor das abaixo.</label>
    <select name="parcelas" id="parcelas" class="form-control">
      <option value="1">1X</option>
      <option value="2">2X</option>
      <option value="3">3X</option>
      <option value="4">4X</option>
      <option value="5">5X</option>
      <option value="6">6X<X/option>
    </select>
    <button type="submit" class="btn btn-success">
        <i class="fas fa-check"></i> Calcular
    </button>
  </form>
</div>

<?php
//operações abaixo só serão realizadas se a página estiver recebendo as informações inseridas no form
if(!empty($_POST["parcelas"])) {
  $parcelas = $_POST["parcelas"] ?? NULL;//puxando o número de parcelas escolhido

  //veridicando se foi inserido a quantidade de produto e definindo 1 como padrão se não foi
  if(empty($_POST["qtde"])){
    $qtde = 1;
  } else {
    $qtde = $_POST["qtde"] ?? NULL;
  }

  //o valor da parcela é o valor do produto puxado no sql vezes a quantidade e dividido pelo numero de parcelas escolhido
  $valorParcelas = ($dadosProduto->valor*$qtde)/$parcelas;
  $valorParcelas = number_format($valorParcelas,2,",",".");//formatando valor
  ?>

  <!-- apresentando na página resultado do cáculo -->
  <p>Quantidade: <?=$qtde?></p>
  <p><?=$parcelas?>X de R$ <?=$valorParcelas?></p>

  <?php

  //caso seja preenchido o cep para calculo do frete
  if(!empty($_POST["frete"])) {
    $cep= trim($_POST["frete"] ?? NULL);//puxando o frete inserido
    
    //consultando o valor na api do correio - valores de peso e demais são aleatórios só de exemplo
    $link = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem=87280000&sCepDestino=".$cep."&nVlPeso=1&nCdFormato=1&nVlComprimento=30&nVlAltura=30&nVlLargura=30&sCdMaoPropria=n&nVlValorDeclarado=0&sCdAvisoRecebimento=n&nCdServico=40010&nVlDiametro=0&StrRetorno=xml&nIndicaCalculo=3";

    //tratando o xml retornado pela consulta
    if (($response_xml_data = file_get_contents($link))===false){
        echo "Error fetching XML\n";
    } else {
        libxml_use_internal_errors(true);
        $data = simplexml_load_string($response_xml_data);
        if (!$data) {
            echo "Error loading XML\n";
            foreach(libxml_get_errors() as $error) {
                echo "\t", $error->message;
            }
        } else {
          // print_r($data);
        }
    }

    $json = json_encode($data);//convertendo o xml em json
    $array = json_decode($json,TRUE);//convertendo o json em array
    $rastreio = $array["cServico"];//o $array é um array com outro array dentro - extraindo o array "cServico" de dentro do $array
    //carrega o arquivo XML e retornando um Array
    
    $valor = $rastreio["Valor"];//valor do frete trazido no $rastreio
    $entrega = $rastreio["PrazoEntrega"];//prazo de entrega em dias trazido no $rastreio
    $valorFinal = ($dadosProduto->valor*$qtde) + formatarValor($valor);//valor do produto puxado no sql vezes a quantidade de produtos escolhido mais o valor do frete
    $parcelasFrete = $valorFinal/$parcelas;//valor final dividido pelo número de parcelas escolhido
    $valorFinalF = number_format($valorFinal,2,",",".");//valor final formatado
    $parcelasFreteF = number_format($parcelasFrete,2,",",".");//valor das parcelas formatado

    ?>

    <!-- apresentando resultados dos calculos -->
    <p>Frete: R$ <?=$valor?></p>
    <p>Prazo de entrega: <?=$entrega?> dias</p>
    <br><br>
    <p>Valor final a vista: R$ <?=$valorFinalF?></p>
    <p>Valor parcelado com frete: <?=$parcelasFreteF?></p>

    <?php
  }
}