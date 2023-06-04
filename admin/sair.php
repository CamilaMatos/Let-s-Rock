<?php
    //iniciar sessao
    session_start();
    //destruir aquela sessao
    unset($_SESSION["usuarioAdm"]);
    //redirecionar
    header("Location: index.php");