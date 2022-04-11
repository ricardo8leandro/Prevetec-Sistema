<?php 
    $titulo = "";
    $descricao = "";
    $formId = "formCadastrar";
    $inputName = "novoServico";
    $btn = "Criar";
    $conteudo = "";
    $configPDF = '';

    if(isset($this->list['editar']) && is_array($this->list['editar'])){
        $inputName = "editServico";
        $status = 0;
        $formId = "formEditar";
        $id = $this->list['editar']['cd_servico'];
        $titulo = $this->list['editar']['ds_titulo'];
        $status = $this->list['editar']['cd_situacao'];
        $conteudo = $this->list['editar']['ds_descricao'];
        $telhadoM = $this->list['editar']['lg_telhado_metalico'];
        $estruturaM = $this->list['editar']['lg_estrutura_metalica'];
        $usaCTA = $this->list['editar']['lg_terminal_aereo'];
        $btn = "Atualizar";

        // print_r($this->list['editar']);
    }
?>

<div class="panel panel-default">
    <div class="panel-heading"><?= $this->getTitle(); ?></div>

    <div class="panel-body">
    
    	<form method="post" class="form-horizontal" action="" id="<?= $formId; ?>" >
         
            <div class="form-group">
                <label class="col-lg-1" for="titulo">Titulo</label>
                <div class="col-lg-12">
                    <input type="text" class="form-control" name="titulo" id="titulo" value="<?= $titulo; ?>" required/>
                </div>
            </div>

            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-12 " for="telhadoM">Telhado metalico</label>
                <div class="col-lg-12">
                    <select class="form-control" name="telhadoM" id="telhadoM" required>
                        <option selected value="0">Indiferente</option>
                        <option value="1" <?php if(isset($telhadoM) && $telhadoM == 1) echo "selected"; ?>>
                         Não 
                        </option>
                        <option value="2" <?php if(isset($telhadoM) && $telhadoM == 2) echo "selected"; ?>>
                         Sim
                        </option>
                    </select>
                </div>
            </div>

            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-12 " for="estruturaM">Estrutura metalica</label>
                <div class="col-lg-12">
                    <select class="form-control" name="estruturaM" id="estruturaM" required>
                        <option selected value="0">Indiferente</option>
                        <option value="1" <?php if(isset($estruturaM) && $estruturaM == 1) echo "selected"; ?>>
                         Não 
                        </option>
                        <option value="2" <?php if(isset($estruturaM) && $estruturaM == 2) echo "selected"; ?>>
                         Sim
                        </option>
                    </select>
                </div>
            </div>

            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-12" for="usaCTA">Usa capacitor de terminal aereo</label>
                <div class="col-lg-12">
                    <select class="form-control" name="usaCTA" id="usaCTA" required>
                        <option selected value="0">Indiferente</option>
                        <option value="1" <?php if(isset($usaCTA) && $usaCTA == 1) echo "selected"; ?>>
                         Não 
                        </option>
                        <option value="2" <?php if(isset($usaCTA) && $usaCTA == 2) echo "selected"; ?>>
                         Sim
                        </option>
                    </select>
                </div>
            </div>

            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-1 " for="status">Situação</label>
                <div class="col-lg-12">
                    <select class="form-control" name="status" id="status" required>
                        <option selected disabled>Selecione uma opção</option>
                        <option value="1" <?php if(isset($status) && $status == 1) echo "selected"; ?>>
                         Ativo 
                        </option>
                        <option value="0" <?php if(isset($status) && $status == 0) echo "selected"; ?>>
                         Inativo 
                        </option>
                    </select>
                </div>
            </div>

            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-1" for="">Conteudo</label>
                <div class="col-lg-12">
                    <textarea id='conteudo' name="conteudo"><?= $conteudo; ?></textarea>
                    <?php load_editor(WYSIWYG_NAME,'conteudo'); ?>
                </div>
            </div>

            <hr class="dotted">
        	<div class="form-group">
                <div class="col-sm-offset-4 col-sm-5">
                    <input type="hidden" name="<?= $inputName; ?>" value="1">
                    <?php if(isset($id)){ ?>
                        <input type="hidden" name="id" value="<?= $id; ?>" >
                    <?php } ?>
                    <button type="submit" class="btn btn-success form-control"><?= $btn; ?></button>
                </div>
        	</div>
    	</form>
    </div>
</div>
<script type="text/javascript">
    var url_cad_edit = "servico/";
</script>