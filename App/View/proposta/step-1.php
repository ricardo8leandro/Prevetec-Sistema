<!-- CLIENTE -->
<hr class="dotted">
<div class="form-group">
    <label class="col-lg-4 control-label" for="cliente">
        Cliente
    </label>
    <div class="col-lg-4">
        <select class="form-control" name="cliente"  id="cliente" >
            <option selected disabled value="">Selecione o cliente</option>
            <?php 
                if(is_array($clientes)){
                    foreach ($clientes as $key => $cliente) {
                        $selected = "";
                        if($cliente['cd_usuario'] == $p_cliente){
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

<!-- TIPO DE SERVICO -->
<hr class="dotted">
<div class="form-group">
    <label class="col-lg-4 control-label" for="tipoServico">
        Tipo de serviço
    </label>
    <div class="col-lg-4">
        <select class="form-control" name="tipoServico"  id="tipoServico" >
            <option selected disabled value="">Selecione tipo de serviço</option>
            <?php 
                if(is_array($tipoServicos)){
                    foreach ($tipoServicos as $key => $ts) {
                        $selected = "";
                        if($ts['cd_tipo_servico'] == $p_tipoServico){
                            $selected = "selected";
                        }
            ?>
                <option value="<?= $ts['cd_tipo_servico']; ?>" <?= $selected; ?>>
                    <?= $ts['ds_titulo']; ?>
                </option>
            <?php
                    }
                }
            ?>
        </select>
    </div>
</div>

<!-- TIPO DE EDIFICIO -->
<hr class="dotted">
<div class="form-group">
    <label class="col-lg-4 control-label" for="tipoEdificio">
        Tipo de edificio
    </label>
    <div class="col-lg-4">
        <select class="form-control" name="tipoEdificio"  id="tipoEdificio" >
            <option selected disabled value="">Selecione tipo de edificio</option>
            <?php 
                if(is_array($tipoEdificios)){
                    foreach ($tipoEdificios as $key => $te) {
                        $selected = "";
                        if($te['cd_tipo_edificio'] == $p_tipoEdificio){
                            $selected = "selected";
                        }
            ?>
                <option value="<?= $te['cd_tipo_edificio']; ?>" <?= $selected; ?>>
                    <?= $te['ds_titulo']; ?>
                </option>
            <?php
                    }
                }
            ?>
        </select>
    </div>
</div>

<!-- CONFIGURAÇÃO DE PDF -->
<hr class="dotted">
<div class="form-group">
    <label class="col-lg-4 control-label" for="ConfigPDF">
        Configuração de PDF
    </label>
    <div class="col-lg-4">
        <select class="form-control" name="ConfigPDF"  id="ConfigPDF" >
            <option selected disabled value="">Selecione a config. de PDF</option>
            <?php 
                if(is_array($configPDFs)){
                    foreach ($configPDFs as $key => $cpdf) {
                        $selected = "";
                        if($cpdf['cd_pdf_config'] == $p_configPDF){
                            $selected = "selected";
                        }
            ?>
                <option value="<?= $cpdf['cd_pdf_config']; ?>" <?= $selected; ?>>
                    <?= $cpdf['ds_titulo']; ?>
                </option>
            <?php
                    }
                }
            ?>
        </select>
    </div>
</div>

<!-- DOCUMENTO -->
<hr class="dotted">
<div class="form-group">
    <label class="col-lg-4 control-label" for="documento">
        Documento
    </label>
    <div class="col-lg-4">
        <select class="form-control" name="documento"  id="documento" >
            <option selected disabled value="">Selecione o documento</option>
            <?php 
                if(is_array($docs)){
                    foreach ($docs as $key => $doc) {
                        $selected = "";
                        if($doc['cd_documento'] == $p_documento){
                            $selected = "selected";
                        }
            ?>
                <option value="<?= $doc['cd_documento']; ?>" <?= $selected; ?>>
                    <?= $doc['ds_titulo']; ?>
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
    <label class="col-lg-4 control-label" for="engResponsavel">
        Eng. Responsavel
    </label>
    <div class="col-lg-4">
        <select class="form-control" name="engResponsavel"  id="engResponsavel" >
            <option selected disabled value="">Selecione o eng. responsavel</option>
            <?php 
                if(is_array($engs)){
                    foreach ($engs as $key => $eng) {
                        $selected = "";
                        if($eng['cd_usuario'] == $p_eng) $selected = "selected";
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

<!-- ENGENHEIRO RESPONSAVEL -->
<hr class="dotted">
<div class="form-group">
    <label class="col-lg-4 control-label" for="regiao">
        Região
    </label>
    <div class="col-lg-4">
        <select class="form-control" name="regiao"  id="regiao" >
            <option selected disabled value="">Selecione a região</option>
            <?php 
                if(is_array($regioes)){
                    foreach ($regioes as $key => $regiao) {
                        $selected = "";
                        if($regiao['cd_regiao'] == $p_regiao) $selected = "selected";
            ?>
                <option value="<?= $regiao['cd_regiao']; ?>" <?= $selected; ?>>
                    <?= $regiao['nm_regiao']; ?>
                </option>
            <?php
                    }
                }
            ?>
        </select>
    </div>
</div>

<!-- SITUAÇÃO -->
<hr class="dotted">     
<div class="form-group">
    <label class="col-lg-4 control-label" for="status">
        Situação
    </label>
    <div class="col-lg-4">
        <select class="form-control" name="status" id="status" required>
            <option selected disabled value="">Selecione uma opção</option>
            <option value="aberta" <?php $this->SlcStatus($p_status,'aberta'); ?> >
             Aberta 
            </option>
            <option value="fechada" <?php $this->SlcStatus($p_status,'fechada'); ?> >
             Fechada 
            </option>
            <option value="cancelada" <?php $this->SlcStatus($p_status,'cancelada'); ?> >
             Cancelada
            </option>
        </select>
    </div>
</div>

<!-- PRAZO PARA INICIO -->
<hr class="dotted">
<div class="form-group">
    <label class="col-lg-4 control-label" for="prazoInicio">
    Prazo para inicio
    </label>
    <div class="col-lg-4">
        <div class="col-sm-12 input-group">
            <input type="number" class="form-control" name="prazoInicio" id="prazoInicio"
            value="<?= $p_prazoInicial; ?>" required/>
            <span class="input-group-addon">
                &nbsp; dia(s) &nbsp;
            </span>
        </div>
    </div>
</div>

<!-- PRAZO PARA EXECUÇÃO -->
<hr class="dotted">
<div class="form-group">
    <label class="col-lg-4 control-label" for="prazoExecucao">
    Prazo para execução
    </label>
    <div class="col-lg-4">
        <div class="col-sm-12 input-group">
            <input type="number" class="form-control" name="prazoExecucao" id="prazoExecucao"
            value="<?= $p_prazoExecucao; ?>" required/>
            <span class="input-group-addon">
                &nbsp; dia(s) &nbsp;
            </span>
        </div>
    </div>
</div>