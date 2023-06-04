<?php
    if (!isset($pagina))
        exit;

    require "configs/functions.php";



    if($_POST){
            foreach($_POST as $key => $value){

                $$key = trim($value ?? NULL);

                if(($key != "id") AND (empty($value))
                ){
                    mensagem("Erro!", "Um dado solicitado está em branco");

                }

            }

            //Puxar a senha caso esteja editando um usuário
            if(!empty($id)) {
                $sqlUsuario = "select * from usuarios where login = :login and id = :id limit 1";
                $consultaUsuario = $pdo->prepare($sqlUsuario);
                $consultaUsuario->bindParam(":login", $login);
                $consultaUsuario->bindParam(":id", $id);
                $consultaUsuario->execute();
            //recuperar os dados
            $dadosUsuario = $consultaUsuario->fetch(PDO::FETCH_OBJ);
            }

            $sqlLogin = "select * from usuarios where login = :login and id <> :id limit 1";
            $consultaLogin = $pdo->prepare($sqlLogin);
            $consultaLogin->bindParam(":login", $login);
            $consultaLogin->bindParam(":id", $id);
            $consultaLogin->execute();

            //recuperar os dados
            $dadosLogin = $consultaLogin->fetch(PDO::FETCH_OBJ);
            if(!empty($dadosLogin->id)){
                mensagem("ERRO!", "Esse login ja está em uso");

            } else if ($senha != $csenha){
                mensagem("ERRO!", "As senhas não conferem");

            }


            $senha = encriptador($senha);
            // echo $senha;
        

            //Salvar Usuario
            if(empty($id)){
                
                //Inserir
                $sqlInserir = "insert into usuarios values (NULL, :nome, :login, :senha, :ativo)";
                $consulta = $pdo->prepare($sqlInserir);
                $consulta->bindParam(":nome", $nome);
                $consulta->bindParam(":login", $login);
                $consulta->bindParam(":senha", $senha);
                $consulta->bindParam(":ativo", $ativo);

            } else if (!empty($id) AND !(password_verify($senha,$dadosUsuario->senha))){
                //Update com senha !=
            $sqlUpdateSenha = "update usuarios set nome = :nome, login = :login, senha = :senha, ativo = :ativo where id = :id limit 1";
            $consulta = $pdo->prepare($sqlUpdateSenha);
            $consulta->bindParam(":nome", $nome);
            $consulta->bindParam(":login", $login);
            $consulta->bindParam(":senha", $senha);
            $consulta->bindParam(":ativo", $ativo);
            $consulta->bindParam(":id", $id);

        } else {
            //update / alterar sem mexer na senha.
            $sqlUpdate = "update usuarios set nome = :nome, login = :login, ativo = :ativo where id = :id limit 1";
            $consulta = $pdo->prepare($sqlUpdate);
            $consulta->bindParam(":nome", $nome);
            $consulta->bindParam(":login", $login);
            $consulta->bindParam(":ativo", $ativo);
            $consulta->bindParam(":id", $id);
        }
    }
    //Executar
    if($consulta->execute()){

        mensagem("Sucesso!","Registro Salvo/Atualizado com sucesso!");


    }else{
        mensagem("Erro","Erro ao tentar Salvar/Atualizar registro!");
    }
?>
