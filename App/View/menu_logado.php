<?php 
	foreach($this->getMenu() as $key => $value){
    if($value['nivel_acesso'] > 0){
      $p[$value['nm_modulo']] = $value['nivel_acesso'];  
    }
	}
?>
<aside class="left-panel">
    
    <div class="user text-center">
          <h4 class="user-name"><?= $_SESSION['prev_user_nome']; ?></h4>
    </div>
    
    <nav class="navigation">
        <ul class="list-unstyled">
        	
            <li class="active">
            	<a href="<?= PAINEL; ?>">
            		<i class="fa fa-bookmark-o"></i><span class="nav-label">Dashboard</span>
            	</a>
            </li>
            
            <!-- valida usuarios e grupos de usuarios  -->
            <?php if(array_key_exists('usuarios',$p)){ ?>
              <!-- usuarios -->
              <li class="has-submenu">
              	<a href="#">
              		<i class="fa fa-users"></i> <span class="nav-label">Usuários</span>
              	</a>
              	<ul class="list-unstyled">
              		<li>&nbsp; Usuários</li>
                  <?php } ?>

                  <?php if(isset($p['usuarios']) && $p['usuarios'] >= 1){ ?>
                    <li><a href="<?= PAINEL; ?>usuarios/listar">Listar usuários</a></li>
                  <?php } ?>

              		<?php if(isset($p['usuarios']) && $p['usuarios'] >= 2){ ?>
              		  <li><a href="<?= PAINEL; ?>usuarios/novo">Novo usuário</a></li>
                  <?php } ?>

                    <?php if(array_key_exists('grupos',$p)){ ?>
                    <li>&nbsp; Grupos</li>

                    <?php if($p['grupos'] >= 1){ ?>
                    <li><a href="<?= PAINEL; ?>grupos/listar">Listar Grupos</a></li>
                    <?php } ?>
              	</ul>
              </li>
          	<?php } ?>

            <!-- valida Cargos -->
            <?php if(array_key_exists('Cargos',$p)){ ?>
              <li class="has-submenu">
                <a href="#">
                  <i class="fa fa-certificate"></i> 
                  <span class="nav-label">Cargos</span>
                </a>
                <ul class="list-unstyled">
                  
                  <?php if($p['Cargos'] >= 1){ ?>
                    <li><a href="<?= PAINEL; ?>cargos/listar">Listar Cargos</a></li>
                  <?php } ?>

                  <?php if($p['Cargos'] >= 2){ ?>
                    <li><a href="<?= PAINEL; ?>cargos/novo">Novo cargo</a></li>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>

            <!-- valida acesso a regioes -->
            <?php if(array_key_exists('regiao',$p)){ ?>
              <li class="has-submenu">
                <a href="#">
                  <i class="fa fa-map-marker"></i> 
                  <span class="nav-label">Regiões</span>
                </a>
                <ul class="list-unstyled">
                  
                  <?php if($p['regiao'] >= 1){ ?>
                    <li><a href="<?= PAINEL; ?>regiao/listar">Listar regiões</a></li>
                  <?php } ?>

                  <?php if($p['regiao'] >= 2){ ?>
                    <li><a href="<?= PAINEL; ?>regiao/novo">Nova região</a></li>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>

            <!-- ACESSO AO MODELO DE LAUDO -->
            <?php if(array_key_exists('modelo de laudo',$p)){ ?>
              <li class="has-submenu">
                <a href="#">
                  <i class="fa fa-file-text-o"></i> 
                  <span class="nav-label">Modelo de laudo</span>
                </a>
                <ul class="list-unstyled">
                  <li>&nbsp; Modelos</li>
                  
                  <?php if($p['modelo de laudo'] >= 1){ ?>
                    <li>
                      <a href="<?= PAINEL; ?>modelo-laudo/listar">
                        Listar modelos de laudo
                      </a>
                    </li>
                  <?php } ?>
                  <?php if($p['modelo de laudo'] >= 2){ ?>
                    <li>
                      <a href="<?= PAINEL; ?>modelo-laudo/novo">
                        Novo modelo de laudo
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>
            
            <!-- valida acesso aos laudos -->
            <?php if(array_key_exists('laudo',$p)){ ?>
              <li class="has-submenu">
                <a href="#">
                  <i class="fa fa-file-text-o"></i> 
                  <span class="nav-label">Laudos</span>
                </a>
                <ul class="list-unstyled">

                  <?php if($p['laudo'] >= 1){ ?>
                    <li><a href="<?= PAINEL; ?>laudo/infoapp">Informações App Laudo</a></li>
                  <?php } ?>
                  
                  <?php if($p['laudo'] >= 1){ ?>
                    <li><a href="<?= PAINEL; ?>laudo/listar">Listar laudos</a></li>
                  <?php } ?>

                  <?php if($p['laudo'] >= 2){ ?>
                    <li><a href="<?= PAINEL; ?>laudo/novo">Novo laudo</a></li>
                  <?php } ?>

                  <?php if($p['laudo'] >= 2){ ?>
                    <li><a href="<?= PAINEL; ?>laudo/cert">Certificado</a></li>
                  <?php } ?>
                  
                  <?php if($p['laudo'] >= 1){ ?>
                    <li><a href="<?= PAINEL; ?>laudo/formatar-pdf">Re-formatar PDF</a></li>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>

            <!-- valida acesso a proposta -->
            <?php if(array_key_exists('proposta',$p)){ ?>
              <li class="has-submenu">
                <a href="#">
                  <i class="fa fa-file-text"></i> 
                  <span class="nav-label">Propostas</span>
                </a>
                <ul class="list-unstyled">
                  
                  <?php if($p['proposta'] >= 1){ ?>
                    <li><a href="<?= PAINEL; ?>proposta/listar">Listar propostas</a></li>
                  <?php } ?>

                  <?php if($p['proposta'] >= 2){ ?>
                    <li><a href="<?= PAINEL; ?>proposta/novo">Nova proposta</a></li>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>

            <!-- valida acesso aos serviços -->
            <?php if(array_key_exists('serviço',$p)){ ?>
              <li class="has-submenu">
                <a href="#">
                  <i class="fa fa-wrench"></i> 
                  <span class="nav-label">Serviços</span>
                </a>
                <ul class="list-unstyled">
                  
                  <?php if($p['serviço'] >= 1){ ?>
                    <li><a href="<?= PAINEL; ?>servico/listar">Listar serviços</a></li>
                  <?php } ?>

                  <?php if($p['serviço'] >= 2){ ?>
                    <li><a href="<?= PAINEL; ?>servico/novo">Novo serviço</a></li>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>

            <!-- valida acesso aos tipos de serviços -->
            <?php if(array_key_exists('tipo de serviço',$p)){ ?>
              <li class="has-submenu">
                <a href="#">
                  <i class="fa fa-briefcase"></i> 
                  <span class="nav-label">Tipos de serviços</span>
                </a>
                <ul class="list-unstyled">
                  
                  <?php if($p['tipo de serviço'] >= 1){ ?>
                    <li><a href="<?= PAINEL; ?>tipo-servico/listar">Listar tipos de serviços</a></li>
                  <?php } ?>

                  <?php if($p['tipo de serviço'] >= 2){ ?>
                    <li><a href="<?= PAINEL; ?>tipo-servico/novo">Novo tipo de serviço</a></li>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>

            <!-- valida acesso aos tipos de edificios -->
            <?php if(array_key_exists('tipo de edificio',$p)){ ?>
              <li class="has-submenu">
                <a href="#">
                  <i class="fa fa-building"></i> 
                  <span class="nav-label">Tipos de edificios</span>
                </a>
                <ul class="list-unstyled">
                  
                  <?php if($p['tipo de edificio'] >= 1){ ?>
                    <li><a href="<?= PAINEL; ?>edificio/listar">Listar tipos de edificios</a></li>
                  <?php } ?>

                  <?php if($p['tipo de edificio'] >= 2){ ?>
                    <li><a href="<?= PAINEL; ?>edificio/novo">Novo tipo de edificio</a></li>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>

            <!-- valida acesso a condicao de pagamento -->
            <?php if(array_key_exists('condicao de pagamento',$p)){ ?>
              <li class="has-submenu">
                <a href="#">
                  <i class="fa fa-money"></i> 
                  <span class="nav-label">Condições de pagamento</span>
                </a>
                <ul class="list-unstyled">
                  
                  <?php if($p['condicao de pagamento'] >= 1){ ?>
                    <li>
                      <a href="<?= PAINEL; ?>condicao-de-pagamento/listar">
                        Listar condições de pagamento
                      </a>
                    </li>
                  <?php } ?>

                  <?php if($p['condicao de pagamento'] >= 2){ ?>
                    <li>
                      <a href="<?= PAINEL; ?>condicao-de-pagamento/novo">
                        Nova condição de pagamento
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>

            <!-- valida acesso aos anexos -->
            <?php if(array_key_exists('anexo',$p)){ ?>
              <li class="has-submenu">
                <a href="#">
                  <i class="fa fa-paperclip"></i> 
                  <span class="nav-label">Anexos</span>
                </a>
                <ul class="list-unstyled">
                  
                  <?php if($p['anexo'] >= 1){ ?>
                    <li>
                      <a href="<?= PAINEL; ?>anexo/listar">
                        Listar Anexos
                      </a>
                    </li>
                  <?php } ?>

                  <?php if($p['anexo'] >= 2){ ?>
                    <li>
                      <a href="<?= PAINEL; ?>anexo/novo">
                        Novo Anexo
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>

            <!-- valida acesso a area -->
            <?php if(array_key_exists('area',$p)){ ?>
              <li class="has-submenu">
                <a href="#">
                  <i class="fa fa-th-large"></i> 
                  <span class="nav-label">Areas</span>
                </a>
                <ul class="list-unstyled">
                  
                  <?php if($p['area'] >= 1){ ?>
                    <li>
                      <a href="<?= PAINEL; ?>area/listar">
                        Listar Areas
                      </a>
                    </li>
                  <?php } ?>

                  <?php if($p['area'] >= 2){ ?>
                    <li>
                      <a href="<?= PAINEL; ?>area/novo">
                        Nova area
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>

            <!-- valida acesso a documento -->
            <?php if(array_key_exists('documento',$p)){ ?>
              <li class="has-submenu">
                <a href="#">
                  <i class="fa fa-file-text"></i> 
                  <span class="nav-label">Documentos</span>
                </a>
                <ul class="list-unstyled">
                  
                  <?php if($p['documento'] >= 1){ ?>
                    <li>
                      <a href="<?= PAINEL; ?>documento/listar">
                        Listar documentos
                      </a>
                    </li>
                  <?php } ?>

                  <?php if($p['documento'] >= 2){ ?>
                    <li>
                      <a href="<?= PAINEL; ?>documento/novo">
                        Novo documento
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>

            <!-- valida acesso a documento -->
            <?php if(array_key_exists('pdf config',$p)){ ?>
              <li class="has-submenu">
                <a href="#">
                  <i class="fa fa-file-text-o"></i> 
                  <span class="nav-label">Config. de PDF</span>
                </a>
                <ul class="list-unstyled">
                  
                  <?php if($p['pdf config'] >= 1){ ?>
                    <li>
                      <a href="<?= PAINEL; ?>configuracao-de-pdf/listar">
                        Listar Config. de PDFs
                      </a>
                    </li>
                  <?php } ?>

                  <?php if($p['pdf config'] >= 2){ ?>
                    <li>
                      <a href="<?= PAINEL; ?>configuracao-de-pdf/novo">
                        Nova Config. de PDF
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>

        </ul>
    </nav>
    
</aside>

<!-- header -->
<section class="content">
<header class="top-head container-fluid">
  <button type="button" class="navbar-toggle pull-left">
    	<span class="sr-only">Toggle navigation</span>
    	<span class="icon-bar"></span>
    	<span class="icon-bar"></span>
    	<span class="icon-bar"></span>
  </button>
  <ul class="nav-toolbar">

    <li class="dropdown">
      <a href="<?= PAINEL ?>vars">
        <i class="fa fa-list-alt"></i>
      </a>
    </li>

    <li class="dropdown">
      <a href="<?= PAINEL ?>usuarios/perfil">
        <i class="fa fa-cog"></i>
      </a>
    </li>

    <li class="dropdown">
    	<a href="<?= AUTH; ?>logout"><i class="fa fa-sign-out"></i></a>
    </li>
  </ul>
</header>