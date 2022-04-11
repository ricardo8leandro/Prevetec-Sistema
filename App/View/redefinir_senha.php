<div class="container">
	<div class="row">
    	<div class="col-lg-4 col-lg-offset-4">
        	<h3 class="text-center">PREVETEC</h3>
            <p class="text-center">Sistema de Gestão</p>
            <hr class="clean">
        	<form role="form" id="formRedefinirSenha">
              <div class="form-group input-group">
              	<span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="password" class="form-control" name="senha1" id="senha1"
                  placeholder="Digite sua nova senha">
              </div>
              <div class="form-group input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="password" class="form-control" name="senha2" id="senha2"
                  placeholder="Confirmar senha">
                  <input type="hidden" name="code" value="<?= $this->list['code'];?>">
              </div>
        	  <button type="submit" class="btn btn-warning btn-block">Redefinir senha</button>
            </form>
            <a href="<?= DIR_PAGE; ?>" style="float:right">voltar ao inicio</a>
        </div>
    </div>
</div>