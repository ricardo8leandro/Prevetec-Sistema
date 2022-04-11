<!-- VALOR -->
<hr class="dotted">
<div class="form-group">
    <div class="col-lg-10 col-lg-offset-1">
        <label for="pag_valor">
            Valor:
        </label>
        <?php $p_valor = str_replace('.',',',$p_valor); ?>
        <input type="text" class="form-control" name="pag_valor" 
            value="<?= $p_valor; ?>" id="pag_valor" > 
    </div>
</div>

<!-- MODELO DE PAGAMENTO -->
<hr class="dotted">
<div class="form-group">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="row">
            <div class="col-md-10">
                <label class="" for="condPagto">
                    Modelos de condição de pagamento:
                </label>
                <select class="form-control" name="condPagto"  id="condPagto" >
                    <option selected disabled value="-1">Selecione o modelo</option>
                    <?php 
                        if(is_array($condPagto)){
                            $i = 0;
                            foreach ($condPagto as $key => $pagto) {
                                $modelo = $pagto['cd_condicao_pagto'];
                                $selected = "";
                                if($pagto['cd_condicao_pagto'] == $p_cond_pag){
                                    $selected = "selected";
                                }
                    ?>
                        <option 
                            value="<?= $i; ?>" 
                            id="pag_opt_<?= $i; ?>" 
                            modelo="<?= $modelo; ?>" 
                            <?= $selected; ?>>
                            <?= $pagto['ds_titulo']; ?>
                        </option>
                    <?php
                        $i++;
                            }
                        }
                    ?>
                </select>
            </div>
            <label class="" for="condPagto">&nbsp;</label>
            <div class="col-md-2">
                <button type="button" class="btn btn-success" id="btnAplicarModelo">
                    Aplicar Modelo
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODELO DE PAGAMENTO -->
<hr class="dotted">
<div class="form-group">
    <div class="col-lg-10 col-lg-offset-1">
        <label for="pagtoConteudo">
            Conteudo financeiro: 
        </label>
        <textarea 
            id='pagtoConteudo' 
            name="pagtoConteudo"><?= $p_forma_pag; ?></textarea>
            <?php load_editor(WYSIWYG_NAME,'pagtoConteudo'); ?>
    </div>
</div>