<?php 
    if (!isset($pagina)) { 
        header("Location: index.php"); 
    } 

    //define como padrão a página home caso não seja enviada nenhuma
    $pasta = "pages";
    $arquivo = "home";

    //verificando se foi passado a página
    if (isset($_GET["param"])) {
        if (($_GET["param"]) != "home") {
        //recuperar o parametro
        // cadastros/categorias/1
        $param = explode("/", $_GET["param"]);//transdorma em array para extrair as informações

        $pasta = $param[0] ?? NULL;
        $arquivo = $param[1] ?? NULL;
        $id = $param[2] ?? NULL;
        }
    }
    
?>
<nav class="navbar bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="home">
        <!-- Criar um logo para loja e substituir aqui -->
        <!-- clicar no logo redireciona para págima home -->
        <img src="images/icone.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
      Lojas ACL
    </a>
    <!-- form para buscar itens específicos nas páginas - ação na página que está aberta quando realiza a pesquisa -->
    <form name="form" method="post" action="<?=$pasta?>/<?=$arquivo?>/<?=$id?>" class="d-flex">
        <input type="text" name="busca" id="busca" class="form-control me-2" placeholder="Busca">
        <button type="submit" class="btn btn-outline-success">
            <i class="fas fa-check"></i> Buscar
        </button>
        </form>
    <a>
        <!-- Colocar aqui um icone de usuário para quando estiver sem foto -->
        <img src="images/icone.png" alt="Usuário" width="30" height="24" class="d-inline-block align-text-top">
    </a>
    <li class="nav-item dropdown">
          <!-- abre as opções de conta - não estão conficguradas -->
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Conta
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="login">Login</a></li>
            <li><a class="dropdown-item" href="cadatrar">Cadastrar</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="sair">Sair</a></li>
          </ul>
    </li>
    <!-- abre um modal que apresenta os produtos adicionados no carrinho - não está configurando -->
    <a class="navbar-brand" href="favoritos">
      <img src="images/icone.png" alt="Favoritos" width="30" height="24" class="d-inline-block align-text-top">
    </a>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#carrinho">
        Carrinho
    </button>
    <div class="modal fade" id="carrinho" tabindex="-1" aria-labelledby="carrinho" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Carrinho</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe name="produtos" class="card" width="100%" height="300px" src="pages/carrinho.php"></iframe>
                </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <li class="nav-item">
          <a class="nav-link" href="comprar">Finalizar Compra</a>
        </li>
      </div>
    </div>
  </div>
</div>
  </div>
</nav>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="pages/categorias">Categorias</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="pages/produtos">Produtos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="pages/maisComprados">Mais Comprados</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="pages/promocoes">Promoções</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="pages/sobre">Sobre nós</a>
        </li>
      </ul>
      <a class="navbar-brand" href="http://localhost/admin/">Sistema Adm</a> 
      <!-- redireciona para o site Admin -->
    </div>
  </div>
  
</nav>