<?php 
    if (!isset($pagina)) { 
        header("Location: index.php"); 
    } 
?>
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="home">
        <img src="images/login_branco.png" alt="Sistema Administrativo" height="70px">
    </a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">

    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i> Olá <?= $_SESSION["usuarioAdm"]["nome"]; ?></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="senha.php">Mudar Senha</a></li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item" href="sair.php">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Home</div>
                    <a class="nav-link" href="home">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <div class="sb-sidenav-menu-heading">Sistema</div>
                    
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCadastros" aria-expanded="false" aria-controls="collapseCadastros">
                        <div class="sb-nav-link-icon"><i class="fas fa-file"></i></div>
                        Cadastros
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseCadastros" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="cadastrar/categorias">Categorias</a>
                            <a class="nav-link" href="cadastrar/produtos">Produtos</a>
                            <a class="nav-link" href="cadastrar/clientes">Clientes</a>
                            <a class="nav-link" href="cadastrar/formas">Formas de Pagamento</a>
                            <a class="nav-link" href="cadastrar/vendas">Vendas</a>
                            <a class="nav-link" href="cadastrar/usuarios">Usuários</a>
                        </nav>
                    </div>
                    
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseRelatorios" aria-expanded="false" aria-controls="collapseRelatorios">
                        <div class="sb-nav-link-icon"><i class="fas fa-search"></i></div>
                        Relatórios
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseRelatorios" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="relatorios/produtos">Produtos</a>
                            <a class="nav-link" href="relatorios/clientes">Clientes</a>
                            <a class="nav-link" href="relatorios/vendas">Vendas</a>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                <?=$_SESSION["usuarioAdm"]["nome"]?>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
                <main class="m-3">