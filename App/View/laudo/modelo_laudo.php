<?php
    $nome       = "";
    $descricao  = "";
    $formId     = "formCadastrar";
    $inputName  = "novoLaudoModelo";
    $btn        = "Criar";
    $capa       = "";
    $texto      = "";
    $cabecalho  = "";
    $rodape     = "";

    $titulo     = "{{TITULO}}";
    $subtitulo1 = "{{SUBTITULO}}";
    $subtitulo2 = "{{SUBTITULO}}";

    if(isset($this->list['editar']) && is_array($this->list['editar'])){
      $inputName = "editLaudoModelo";
      $status = 0;
      $formId = "formEditar";
      $id = $this->list['editar']['cd_laudo_modelo'];
      $nome = $this->list['editar']['nm_laudo_modelo'];
      $status = $this->list['editar']['ic_status'];
      $capa = $this->list['editar']['capa'];
      $texto = $this->list['editar']['texto'];
      $cabecalho = $this->list['editar']['laudo_modelo_cabecalho'];
      $rodape = $this->list['editar']['laudo_modelo_rodape'];

      $titulo = $this->list['editar']['laudo_modelo_titulo'];
      $subtitulo1 = $this->list['editar']['laudo_modelo_subtitulo1'];
      $subtitulo2 = $this->list['editar']['laudo_modelo_subtitulo2'];

      $btn = "Atualizar";
    }

?>
<div class="panel panel-default">
    <div class="panel-heading"><?= $this->getTitle(); ?></div>

    <div class="panel-body">
    	<form method="post" class="form-horizontal" action="" id="<?= $formId; ?>">
            <div class="form-group">
                <label class="col-lg-3 control-label" for="nome">Titulo</label>
                <div class="col-lg-6">
                    <input type="text" class="form-control" name="nome" id="nome"  
                        value="<?= $nome; ?>" required/>
                </div>
            </div>
            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-3 control-label" for="status">Situação</label>
                <div class="col-lg-6">
                    <select class="form-control" name="status" id="status" required>
                        <option selected disabled>Selecione uma opção</option>
                        <option value="ativo" <?php if(isset($status) && $status == 'ativo') echo "selected"; ?>>
                         Ativo 
                        </option>
                        <option value="inativo" <?php if(isset($status) && $status == 'inativo') echo "selected"; ?>>
                         Inativo 
                        </option>
                    </select>
                </div>
            </div>

            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-1" for="">Capa</label>
                <div class="col-lg-12">
                    <textarea id='capa' name="capa"><?= $capa; ?></textarea>
                    <?php load_editor(WYSIWYG_NAME,'capa'); ?>
                </div>
            </div>

            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-12" for="">Prefacio</label>
                <div class="col-lg-12">
                    <textarea style="height:500px" id='texto' name="texto"><?= $texto; ?></textarea>
                    <?php load_editor(WYSIWYG_NAME,'texto'); ?>
                </div>
            </div>

            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-1" for="">Cabecalho</label>
                <div class="col-lg-12">
                    <textarea style="height:500px" id='cabecalho' name="cabecalho"><?= $cabecalho; ?></textarea>
                    <?php load_editor(WYSIWYG_NAME,'cabecalho'); ?>
                </div>
            </div>

            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-12" for="">Rodapé</label>
                <div class="col-lg-12">
                    <textarea style="height:500px" id='rodape' name="rodape"><?= $rodape; ?></textarea>
                    <?php load_editor(WYSIWYG_NAME,'rodape'); ?>
                </div>
            </div>

            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-12" for="">Formatação do titulo ( 1. )</label>
                <div class="col-lg-12">
                    <textarea style="height:500px" id='titulo' name="titulo"><?= $titulo; ?></textarea>
                    <?php load_editor(WYSIWYG_NAME,'titulo'); ?>
                </div>
            </div>
            <p>Use a váriavel {{TITULO}} para a formatar o titulo!</p>

            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-12" for="">Formatação do sub-titulo nivel 1 ( 1.1. )</label>
                <div class="col-lg-12">
                    <textarea style="height:500px" id='subtitulo1' name="subtitulo1"><?= $subtitulo1; ?></textarea>
                    <?php load_editor(WYSIWYG_NAME,'subtitulo1'); ?>
                </div>
            </div>
            <p>Use a váriavel {{SUBTITULO}} para a formatar o titulo!</p>

            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-12" for="">Formatação do sub-titulo nivel 2 ( 1.1.1. )</label>
                <div class="col-lg-12">
                    <textarea style="height:500px" id='subtitulo2' name="subtitulo2"><?= $subtitulo2; ?></textarea>
                    <?php load_editor(WYSIWYG_NAME,'subtitulo2'); ?>
                </div>
            </div>
            <p>Use a váriavel {{SUBTITULO}} para a formatar o titulo!</p>

            <hr class="dotted">

        	<div class="form-group">
            <div class="col-sm-offset-4 col-sm-5">
            <input type="hidden" name="<?= $inputName; ?>" value="1">
                <?php if(isset($id)){ ?>
                    <input type="hidden" name="id" value="<?= $id; ?>" >
                <?php } ?>
                <button type="submit" class="btn btn-success form-control btnSubmit">
                  <?= $btn; ?>
                </button>
            </div>
        	</div>

    	</form>

    </div>
</div>

<script type="text/javascript">
  var url_cad_edit = "modelo-laudo/";
</script><style type="text/css">
    .cke_contents{
      min-height:350px !important;
    }
</style>