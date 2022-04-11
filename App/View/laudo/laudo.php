<?php 
    function status($p1, $p2){
        if($p1 == $p2){ return "selected"; }
        return '';
    }

    $formId     = "formCadastrarLaudo";
    // campos
    $cd_laudo           = "";
    $cd_laudo_modelo    = "";
    $cd_profissional    = "";
    $cd_cliente         = "";
    $cd_regiao          = ""; // filial
    $cd_engenheiro      = "";
    $dt_cadastro        = "";
    $dt_inspecao        = "";
    $ds_path_laudo_pdf  = "";
    $ic_status          = "";
    $cd_estado          = "0";
    $cd_cidade          = "0";
    $cd_tipo_laudo      = "";
    $cd_art             = "";
    
    $inputName  = "novoLaudo";
    $btn        = "Criar";

    if(isset($this->list['editar']) && is_array($this->list['editar'])){
        $inputName = "editLaudo";
        $formId = "formEditarLaudo";
        $laudo = $this->list['editar'];
        
        $cd_laudo           = $laudo["cd_laudo"];
        $cd_tipo_laudo      = $laudo["cd_tipo_laudo"];
        $cd_profissional    = $laudo["cd_profissional"];
        $cd_cliente         = $laudo["cd_cliente"];
        $cd_cidade          = $laudo["cd_cidade"];
        $cd_filial          = $laudo["cd_filial"];
        $cd_tipo_edificio   = $laudo["cd_tipo_edificio"];
        $cd_engenheiro      = $laudo["cd_engenheiro"];
        $dt_cadastro        = $laudo["dt_cadastro"];
        $dt_inspecao        = $laudo["dt_inspecao"];
        $ds_path_laudo_pdf  = $laudo["ds_path_laudo_pdf"];
        $ic_status          = $laudo["ic_status"];
        $cd_estado          = $laudo['cd_estado'];
        $cd_art             = $laudo['cd_art'];

        $btn = "Atualizar";
    }

    // $profissionais  = $this->list['profissionais'];
    $engenheiros    = $this->list['engenheiros'];
    $clientes       = $this->list['clientes'];
    $estados       = $this->list['estados'];
    $regioes       = $this->list['regioes'];
    // $tipoEdificios       = $this->list['tipoEdificios'];

    $modelos = $this->list['modelos'];
?>
<div class="panel panel-default">
    <div class="panel-heading"><?= $this->getTitle(); ?></div>

    <div class="panel-body">
    
    	<form method="post" class="form-horizontal" action="" id="<?= $formId; ?>">

            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-4 control-label" for="status">Modelo de Laudo</label>
                <div class="col-lg-4">
                    <select 
                        class="form-control" name="cd_laudo_modelo" 
                        id="cd_laudo_modelo" required>
                        <option selected disabled value="">Selecione o modelo de laudo</option>
                        <?php 
                            if(is_array($modelos)){
                                foreach ($modelos as $key => $modelo) {
                                    $selected = "";
                                    if($modelo['cd_laudo_modelo'] == $cd_tipo_laudo){
                                        $selected = "selected";
                                    }
                        ?>
                            <option value="<?= $modelo['cd_laudo_modelo']; ?>" <?= $selected; ?>>
                                <?= $modelo['nm_laudo_modelo']; ?>
                            </option>
                        <?php
                                }
                            }
                        ?>
                        
                    </select>
                </div>
            </div>
         
            <!-- STATUS -->
            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-4 control-label" for="ic_status">Situação</label>
                <div class="col-lg-4">
                    <select class="form-control" name="ic_status" id="ic_status" required>
                        <option selected disabled>Selecione uma opção</option>
                        <option value="aberto" <?= status('aberto',$ic_status); ?> >
                            Aberto 
                        </option>
                        <option value="fechado" <?php status('fechado',$ic_status); ?> >
                            Fechado
                        </option>
                        <option value="aprovado" <?php status('aprovado',$ic_status); ?> >
                            Aprovado
                        </option>
                        <option value="recusado" <?php status('recusado',$ic_status); ?> >
                            Recusado 
                        </option>
                    </select>
                </div>
            </div>

            <!-- CLIENTE -->
            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-4 control-label" for="cliente">
                    Cliente
                </label>
                <div class="col-lg-4">
                    <select class="form-control" name="cd_cliente"  id="cd_cliente" >
                        <option selected disabled value="">Selecione o cliente</option>
                        <?php 
                            if(is_array($clientes)){
                                foreach ($clientes as $key => $cliente) {
                                    $selected = "";
                                    if($cliente['cd_usuario'] == $cd_cliente){
                                        $selected = "selected";
                                    }
                        ?>
                            <option value="<?= $cliente['cd_usuario']; ?>" <?= $selected; ?>>
                                <?= $cliente['nm_usuario']; ?>
                            </option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>

            <!-- ENGENHEIRO RESPONSAVEL -->
            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-4 control-label" for="cd_engenheiro">
                    Eng. Responsavel
                </label>
                <div class="col-lg-4">
                    <select class="form-control" name="cd_engenheiro"  id="cd_engenheiro" >
                        <option selected disabled value="">Selecione o eng. responsavel</option>
                        <?php 
                            if(is_array($engenheiros)){
                                foreach ($engenheiros as $key => $eng) {
                                    $selected = "";
                                    if($eng['cd_usuario'] == $cd_engenheiro){
                                        $selected = "selected";
                                    }
                        ?>
                            <option value="<?= $eng['cd_usuario']; ?>" <?= $selected; ?>>
                                <?= $eng['nm_usuario']; ?>
                            </option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>

            <!-- ESTADO -->
            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-4 control-label" for="estado">Estado</label>
                <div class="col-lg-4">
                    <select class="form-control " name="estado" id="estado">
                        <option value="" selected disabled>Selecione o estado</option>
                        <?php foreach($estados as $key => $estado){ 
                            $selected = "";
                            if($estado['cd_estado'] == $cd_estado){
                                $selected = "selected";
                            }
                        ?>
                        <option value="<?= $estado['cd_estado']; ?>" <?= $selected; ?>>
                            <?= $estado['nm_estado']; ?>
                        </option>

                        <?php } ?>
                    </select>
                </div>
            </div>

            <!-- CIDADE -->
            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-4 control-label" for="cd_cidade">Cidade</label>
                <div class="col-lg-4">
                    <select class="form-control" name="cd_cidade" id="cidade">
                        <option selected disabled>Selecione uma cidade</option>
                    </select>
                </div>
            </div>

            <!-- FILIAL -->
            <hr class="dotted pro">
            <div class="form-group pro">
                <label class="col-lg-4 control-label" for="cd_regiao">Filial</label>
                <div class="col-lg-4">
                    <select 
                        class="form-control pro-inpt" name="cd_regiao" 
                        id="cd_regiao" required>
                        <option selected disabled>Selecione a filial</option>
                        <?php 
                            if(is_array($regioes)){
                                foreach ($regioes as $key => $value) {
                                    $selected = "";
                                    if($value['cd_regiao'] == $cd_filial){
                                        $selected = "selected";
                                    }
                        ?>

                            <option value="<?= $value['cd_regiao']; ?>" <?= $selected; ?>>
                                <?= $value['nm_regiao']; ?>
                            </option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>

            <!-- NR ART -->
            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-4 control-label" for="cd_art">
                    Nrº ART
                </label>
                <div class="col-lg-4">
                    <input type="text" name="cd_art"
                    class="form-control" value="<?= $cd_art?>" >
                </div>
            </div>

            <!-- DATA INSPEÇÃO -->
            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-4 control-label" for="dt_inspecao">
                    Data de Inspeção
                </label>
                <div class="col-lg-4">
                    <input type="date" name="dt_inspecao" 
                    class="form-control" value="<?= $dt_inspecao; ?>" >
                </div>
            </div>

            <!-- ------------------------------------------------------------------ -->
            <hr class="dotted">
        
        	<div class="form-group">
            <div class="col-sm-offset-4 col-sm-4">
            <input type="hidden" name="<?= $inputName; ?>" value="1">
            <?php if($cd_laudo != ""){ ?>
                <input type="hidden" name="id" value="<?= $cd_laudo; ?>" >
            <?php } ?>
            <button type="submit" class="btn btn-success btn-block btnLaudo">
                <?= $btn; ?>
            </button>
            </div>
        	</div>
        
    	</form>
    </div>
</div>

<script type="text/javascript">
    var cd_estado = <?= $cd_estado; ?>;
    var tem_cidade = <?= isset($cd_cidade) ? $cd_cidade: 0; ?>;
    var url_cad_edit = "laudo/";
</script>