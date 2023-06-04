<?php
    if (!isset($pagina))
        exit;


    if(!empty($id)){
        $sqlUsuarios = "select * from usuarios where id = :id limit 1";
        $consultaUsuarios = $pdo->prepare($sqlUsuarios);
        $consultaUsuarios->bindParam(":id", $id);
        $consultaUsuarios->execute();

        $dados = $consultaUsuarios->fetch(PDO::FETCH_OBJ);

    }
    
    $id = $dados->id ?? NULL;
    $nome = $dados->nome ?? NULL;
    $login = $dados->login ?? NULL;
    $senha = $dados->senha ?? NULL;
    $ativo = $dados->ativo ?? NULL;

?>

<div class="card">
    <div class="card-header">
        <strong>Cadastro de Usuarios</strong>

        <div class="float-end">
            <a href="cadastrar/usuarios" class="btn btn-success btn-sm" title="Novo registro">
                <i class="fas fa-file"></i> Novo Usuario
            </a>
            <a href="listar/usuarios" class="btn btn-info btn-sm">
                <i class="fas fa-search"></i> Listar Usuarios
            </a>
        </div>
    </div>
    <div class="card-body">
        <form name="formCadastro" method="post" 
            enctype="multipart/form-data" action="salvar/usuarios"
            data-parsley-validate="">
                <label for="id">ID:</label>
                <input type="text" name="id" id="id" class="form-control"
                readonly value="<?=$id?>">
                <br>
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" class="form-control" value="<?=$nome?>" required
                data-parsley-required-message="Preencha o nome">
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
                <label for="ativo">Ativo</label>
                    <select name="ativo" id="ativo" required data-parsley-required-message="Informe se o usuário está ativo" class="form-control">
                        <option value=""></option>
                        <option value="S">Sim</option>
                        <option value="N">Não</option>
                    </select>

            <br>
            <button type = "submit" class = "btn btn-success">
                <i class = "fas fa-check"></i> Salvar / Alterar Dados
            </button>
        </form>
    </div>
</div>
    

