<?php
    //abrir e utilizar uma sessao
    session_start();
    //incluir a conexao com banco de dados
    require "configs/conexao.php";

    date_default_timezone_set('America/Sao_Paulo');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lojas ACL</title>

    <base href="<?=$base?>">

    <!----- arquivos css ---->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/datatables.min.css">
    <link rel="stylesheet" href="css/summernote-lite.min.css">
    <link rel="stylesheet" href="css/sweetalert2.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx">
    <!----- arquivos javascript ---->
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/datatables.min.js"></script>
    <script src="js/parsley.min.js"></script>
    <script src="js/summernote-lite.min.js"></script>
    <script src="js/summernote-pt-BR.js"></script>
    <script src="js/sweetalert2.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/vanilla-masker.js"></script>
</head>
<body>
    <?php
        //definir uma variavel $pagina
        $pagina = "home";
        //incluir o header
        require "header.php";

        
        $pagina = "{$pasta}/{$arquivo}.php";
        
        //requisitando a página selecionada
        if (file_exists($pagina)) {
            require $pagina;
        } else {
            require "pages/erro.php";
        }

        //incluir o footer
        require "footer.php";


    ?>
</body>
</html>