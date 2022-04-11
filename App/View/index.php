<div class="container">
  <div class="row">
    <div class="col-lg-4 col-lg-offset-4">
        <h3 class="text-center">PREVETEC</h3>
          <p class="text-center">Sistema de Gestão</p>
          <hr class="clean">
        <form role="form" id="formLogin">
            <div class="form-group input-group">
              <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
              <input type="email" name="email" class="form-control"  placeholder="Email">
            </div>
            <div class="form-group input-group">
              <span class="input-group-addon"><i class="fa fa-key"></i></span>
              <input type="password" name="senha" class="form-control"  placeholder="Senha">
            </div>
            <div class="form-group">
              <label class="cr-styled">
                  <input type="checkbox" ng-model="todo.done">
                  <i class="fa"></i> 
              </label>
              Lembrar
              <a href="<?= DIR_PAGE ?>Home/recuperar-senha" style="float:right">
                Esqueci minha senha
              </a>
            </div>
            
          <button type="submit" class="btn btn-warning btn-block">Acessar</button>
          </form>
      </div>
    </div>
  </div>
</div>