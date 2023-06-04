<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-6">
            <div class="card">
                <div class="card-header text-center">
                    <img src="images/login.png" alt="Sistema Admin"
                    class="img-fluid">
                </div>
                <div class="card-body">
                    <form name="formLogin" method="post" action="verificar.php"
                    data-parsley-validate="">
                        <label for="login">Digite seu login:</label>
                        <input type="text" name="login" id="login" 
                        class="form-control form-control-lg" required
                        data-parsley-required-message="Preencha o login por favor">
                        <br>
                        <label for="senha">Digite sua senha:</label>
                        <input type="password" name="senha" id="senha"
                        class="form-control form-control-lg" required
                        data-parsley-required-message="Preencha a senha por favor">
                        <br>
                        <button type="submit" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-check"></i> Efetuar Login
                        </button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p>Desenvolvido por Camila Matos de Souza</p>
                </div>
            </div>
        </div>
    </div>
</div>