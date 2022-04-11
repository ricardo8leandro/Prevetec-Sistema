<?php 

    $titulo         = "";

    $descricao      = "";

    $formId         = "formCadastrar";

    $inputName      = "novaProposta";

    $btn            = "Criar";

    $conteudo       = "";

    $cliente_id     = 0;

    $ts_id          = 0;

    $te_id          = 0;

    $status         = "";

    $prazoInicio    = "";

    $pagto_id       = 0;

    $disabled = "disabled";



    $p_proposta_id = null;



    /* step - 1*/

    $p_cliente          = 0;

    $p_regiao           = 0;

    $p_tipoServico      = 0;

    $p_tipoEdificio     = 0;

    $p_configPDF        = 0;

    $p_documento        = 0;

    $p_eng              = 0;

    $p_status           = '';

    $p_prazoInicial     = 1;

    $p_prazoExecucao    = 1;



    /* step -2 */

    $p_propArea = null;

    

    /* step -3 */

    $p_valor            = 0;

    $p_forma_pag        = "";

    $p_cond_pag         = '';

    $propostaAprovada   = '';





    if(isset($this->list['editar']) && is_array($this->list['editar'])){



        $inputName = "editProposta";

        $formId = "formEditar";

        $prop = $this->list['editar'];

        $disabled = '';

        $p_proposta_id      = $prop['cd_proposta'];



        /* step - 1*/

        $p_cliente          = $prop['cd_cliente'];

        $p_regiao           = $prop['cd_regiao'];

        $p_tipoServico      = $prop['cd_anexo'];

        $p_tipoEdificio     = $prop['cd_tipo_edificio'];

        $p_configPDF        = $prop['cd_config_pdf'];

        $p_documento        = $prop['cd_documento'];

        $p_eng              = $prop['cd_profissional'];

        $p_status           = $prop['ic_proposta'];

        $p_prazoInicial     = $prop['ds_prazo_inicio'];

        $p_prazoExecucao    = $prop['ds_prazo_execucao'];



        /* step -3 */

        $p_valor            = $prop['vl_proposta'];

        $p_forma_pag        = $prop['ds_forma_pagto'];

        $p_cond_pag         = $prop['ds_condicao_pagto'];



        // echo '- - - - - - - - - - - - -- ---- - - --- - - '.$p_cond_pag;



        $btn = "Atualizar";



        $p_propArea = $this->list['propostaArea'];



        $propostaAprovada = $prop['ic_proposta_aceita'];

    }



    /* arrays dos selects */

    $clientes       = $this->list['clientes'];

    $regioes        = $this->list['regioes'];

    $tipoServicos   = $this->list['tipoServicos'];

    $tipoEdificios  = $this->list['tipoEdificios'];

    $configPDFs     = $this->list['configPDFs'];

    $docs           = $this->list['docs'];

    $engs           = $this->list['engs'];

    $areas          = $this->list['areas'];

    $anexos         = $this->list['anexos'];

    $condPagto      = $this->list['condPagto'];

?>



<div class="panel panel-default">

    <div class="panel-heading"><?= $this->getTitle(); ?></div>



    <div class="panel-body">

    

    	<form method="post" class="form-horizontal" action="" id="<?= $formId; ?>" >



            <!-- CABECALHO DO FORMULÁRIO -->

            <div class="row">

                <div class="col-sm-10 col-sm-offset-1">

                    <div class="panel panel-info">

                        <div class="panel-heading">Etapas</div>

                        <div class="panel-body">

                            <div class="row">

                                <div class="col-6 col-sm-3 col-md-3 col-lg-3 text-center">

                                    <button type="button" id="step1" onclick="setStep(1);"

                                        class="btn btn-success btn-block btn-step" >

                                        Dados Principais

                                    </button>

                                </div>

                                <div class="col-6 col-sm-3 col-md-3 col-lg-3 text-center">

                                    <button  type="button" onclick="setStep(2);" id="step2"

                                        class="btn btn-info btn-block btn-step" <?=$disabled;?>>

                                        Área/Serviços

                                    </button>        

                                </div>

                                <div class="col-6 col-sm-3 col-md-3 col-lg-3 text-center">

                                    <button type="button" onclick="setStep(3);" id="step3"

                                        class="btn btn-info btn-block btn-step" <?=$disabled;?>>

                                        Condições de Pagamento

                                    </button>        

                                </div>

                                <div class="col-6 col-sm-3 col-md-3 col-lg-3 text-center">

                                    <button type="button" onclick="setStep(4);" id="step4"

                                        class="btn btn-info btn-block btn-step" <?=$disabled;?>>

                                        Concluir

                                    </button>        

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            

            <!-- FIM DO CABECALHO DO FORMULÁRIO -->

            

            <div id="step1-conteudo" class="proposta-conteudo">

                <?php include_once 'step-1.php'; ?>

            </div>



            <div id="step2-conteudo" class="proposta-conteudo" style="display:none" >

                <?php include_once 'step-2.php'; ?>

            </div>



            <div id="step3-conteudo" class="proposta-conteudo" style="display:none">

                <?php include_once 'step-3.php'; ?>

            </div>



            <div id="step4-conteudo" class="proposta-conteudo" style="display:none">

                <?php include_once 'step-4.php'; ?>

            </div>



            <div class="form-group">

                <div class="col-sm-offset-4 col-sm-4">

                    <div class="alert alert-danger alert-dismissible" role="alert"

                        id="alertaCampos" style="display:none">

                        <strong>Atenção: </strong> 

                        Preencha todos os campos!

                    </div>

                </div>

            </div>

            

            <!-- CAMPO AO ATUALIZAR ENVIA O ID -->

            <hr class="dotted">

        	<div class="form-group">

                <div class="col-sm-offset-4 col-sm-4 divProximoStep">

                    <button type="button" id="proximoStep" class="btn btn-success btn-block" >

                        Próximo

                    </button>

                </div>



                <div class="col-sm-offset-4 col-sm-4 divGeraProposta" style="display:none">

                    <input type="hidden" name="<?= $inputName; ?>" value="1">

                    <?php if(isset($id)){ ?>

                        <input type="hidden" name="id" value="<?= $id; ?>" >

                    <?php } ?>

                    <button type="button" id="btnGerarProposta" 

                        class="btn btn-success btn-block" >

                        Gerar proposta(PDF)

                    </button>

                </div>

        	</div>

        

    	</form>

    </div>

</div>

<?php include_once 'modal-servicos.php'; ?>

<script type="text/javascript">

    var propostaAprovada = <?php echo "'".$propostaAprovada."'"; ?>;
    var propostaData = {};
    var areas = {};
    var modelosPagto = <?= json_encode($condPagto); ?>;
    var url_cad_edit = "proposta/";
    var editar = null;

    <?php if(is_numeric($p_proposta_id)){ ?>
        var editar = <?= $p_proposta_id; ?>;
        var areasC = <?= json_encode($p_propArea); ?>;
    <?php } ?>
</script>
<style type="text/css">
    .panel-heading{
        font-size:15px !important;
        padding-top:5px !important;
        padding-bottom:5px !important;
        cursor: pointer;
    }
</style>