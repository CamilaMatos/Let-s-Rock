<?php
    if (!isset($pagina))
        exit;

    if (!empty($id)) {
        $sqlCliente = "select * from clientes where id = :id limit 1";
        $consultaCliente = $pdo->prepare($sqlCliente);
        $consultaCliente->bindParam(":id", $id);
        $consultaCliente->execute();

        $dados = $consultaCliente->fetch(PDO::FETCH_OBJ);

    }

    $id = $dados->id ?? NULL;
    $nome = $dados->nome ?? NULL;
    $email = $dados->email ?? NULL;
    $telefone = $dados->telefone ?? NULL;
    $cpf = $dados->cpf ?? NULL;
    $login = $dados->login ?? NULL;
    $foto = $dados->foto ?? NULL;
?>
<div class="card">
    <div class="card-header">
        <strong>Cadastro de Clientes</strong>

        <div class="float-end">
            <a href="cadastrar/clientes" class="btn btn-success btn-sm" title="Novo registro">
                <i class="fas fa-file"></i> Novo Cadastro
            </a>
            <a href="listar/clientes" class="btn btn-info btn-sm">
                <i class="fas fa-search"></i> Listar Cadastros
            </a>
        </div>
    </div>
    <div class="card-body">
        <form name="formCadastro" method="post" 
        enctype="multipart/form-data" action="salvar/clientes"
        data-parsley-validate="">
            <label for="id">ID:</label>
            <input type="text" name="id" id="id" class="form-control"
            readonly value="<?=$id?>">
            <br>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" class="form-control" value="<?=$nome?>" required
            data-parsley-required-message="Preencha o nome">
            <br>
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email"
            class="form-control" value="<?=$email?>" required
            data-parsley-required-message="Digite um e-mail"
            data-parsley-type-message="Digite um e-mail válido">
            <br>
            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf"
            class="form-control" value="<?=$cpf?>" required
            data-parsley-required-message="Preencha o CPF"
            inputmode="numeric">
            <br>
            <label for="telefone">Telefone:</label>
            <input type="text" name="telefone" id="telefone"
            class="form-control" value="<?=$telefone?>" required
            data-parsley-required-message="Preencha o telefone"
            inputmode="numeric">
            <br>
            <label for="login">Login:</label>
                <input type="text" name="login" id="login" class="form-control" value="<?=$login?>" required
                data-parsley-required-message="Preencha o Login">
                <br>
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" class="form-control"
                data-parsley-required-message="Preencha a Senha">
                <br>
                <label for="csenha">Confirmar Senha:</label>
                <input type="password" name="csenha" id="csenha" class="form-control"
                data-parsley-required-message="Preencha a Senha">
                <br>                
            <label for="foto">Foto (JPG):</label>
            <input type="file" name="foto" id="foto"
            class="form-control" value="<?=$foto?>"
            accept=".jpg">
            <?php
                //verificar se existe foto
                if(!empty($foto)){
                    ?>
                        <img src = "fotos/<?=$foto?>p.jpg" alt = "<?=$nome?>" width= "100px">

                    <?php

                }
            ?>
            <br>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-check"></i> Salvar/Alterar Dados
            </button>
        </form>
    </div>
</div>

<script>
    //adicionar as máscaras aos campos
    VMasker(document.querySelector("#telefone")).maskPattern("(99) 99999-9999");
    VMasker(document.querySelector("#cpf")).maskPattern("999.999.999-99");
</script>