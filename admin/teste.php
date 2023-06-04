<?php
    /*
    session_start();

    if (!isset($_SESSION["nome"]))
        header("Location: index.php");

    echo $_SESSION["nome"];
    echo "<br>";
    echo $_SESSION["admin"]["login"];
    */

    $senha = 1234;
    echo password_hash($senha,PASSWORD_DEFAULT);
    
    // $2y$10$PtIVqfKtvyJ.E1D1r0OuXuNDYgqWwy2dISNIUCKJpX/RdyXu97H1C


//     Campos: Senha e confirmar senha
// no update: alterar o usuario sem senha

