<?php

    $id = "0";

    $grupo = "";

    $chefia = "";

    $regiao = "";

    $cargo = "";

    $cidade = "0";

    

    $status = "";

    $nomeU = "";

    $email = "";

    $login = "";

    $telefone = "";

    $celular =  "";

    $cpf = "";

    $cnpj = "";

    $dtNascimento = "";

    $endereco = "";

    $bairro = "";

    $cep = "";

    $crea = "";

    $fotoCrea = "";

    $responsavel = "";

    $inscricaoEstadual = "";

    $material = "";

    $ctps = "";

    $serieCtps = "";

    $doctype = "";

    $grupo_ativo ="";

    $estadoAtivo = "";

    

    $tituloEleitor = "";

    $zonaEleitoral = "";

    

    $formId = "formCadastrar";

    $inputName = "novoUsuario";

    $btn = "Criar";

    

    $cpf_checked = 'checked';

    $cnpj_checked = '';



    if(isset($this->list['editar']) && is_array($this->list['editar'])){



        $inputName = "editUsuario";

        $status = 0;

        

        $id = $this->list['editar']['cd_usuario'];

        $grupo_ativo = $this->list['editar']['cd_grupo'];

        $chefia = $this->list['editar']['cd_chefia'];



        $regiao = $this->list['editar']['cd_regiao'];

        $cargo = $this->list['editar']['cd_cargo'];

        $cidade = $this->list['editar']['cd_cidade'];

        $estadoAtivo = $this->list['editar']['cd_estado'];

        

        $status = $this->list['editar']['ic_usuario'];

        $nomeU = $this->list['editar']['nm_usuario'];

        $email = $this->list['editar']['nm_email'];

        $login = $this->list['editar']['nm_login'];

        $telefone = $this->list['editar']['ds_telefone'];

        $celular =  $this->list['editar']['ds_celular'];

        

        $cpf = $this->list['editar']['cd_cpf'];

        $cnpj = $this->list['editar']['cd_cnpj'];



        

        if(!empty($cpf)){

            $doctype = $cpf;

        }else{

            $doctype = $cnpj;

            $cnpj_checked = "checked";

            $cpf_checked = '';

        }



        $dtNascimento = $this->list['editar']['dt_nascimento'];

        $endereco = $this->list['editar']['ds_endereco'];

        $bairro = $this->list['editar']['nm_bairro'];

        $cep = $this->list['editar']['cd_cep'];

        $crea = $this->list['editar']['ds_crea'];

        $fotoCrea = $this->list['editar']['ds_foto_crea'];

        $responsavel = $this->list['editar']['nm_responsavel'];

        $inscricaoEstadual = $this->list['editar']['cd_inscricao_estadual'];

        $material = $this->list['editar']['ds_material'];

        $ctps = $this->list['editar']['cd_ctps'];

        $serieCtps = $this->list['editar']['cd_serie_ctps'];

        

        $tituloEleitor = $this->list['editar']['cd_titulo_eleitor'];

        $zonaEleitoral = $this->list['editar']['ds_zona_eleitoral'];



        $formId = "formEditar";

        $btn = "Atualizar";

    }



    $grupos = $this->list['grupos'];

    $cargos = $this->list['cargos'];

    $chefias = $this->list['chefias'];

    $regioes = $this->list['regioes'];

    $estados = $this->list['estados'];



    $disabled = "";

    $show_pw = false;

    if(isset($this->list['permissao_editar']) && isset($this->list['show_pw'])){

        if(!$this->list['permissao_editar'] && $this->list['show_pw']){
            $disabled = "disabled";
        }

        $show_pw = $this->list['show_pw'];

    }
?>

<div class="panel panel-default">

    <div class="panel-heading"><?= $this->getTitle(); ?></div>



    <div class="panel-body">

    

    	<form class="form-horizontal" id="<?= $formId; ?>">

            

            <!-- GRUPO -->

            <div class="form-group">

                <label class="col-lg-4 control-label" for="grupo">

                    Selecione o grupo do usuário

                </label>

                <div class="col-lg-5">

                    <select class="form-control" name="grupo"  id="grupo" requiredz  <?= $disabled; ?> >

                        <option selected disabled>Selecione um grupo</option>

                        <?php 

                            if(is_array($grupos)){

                                foreach ($grupos as $key => $value) {

                                    $nome = strtolower($value['nm_grupo']);

                                    

                                    $pro = "sim";

                                    if(preg_match("/cliente/", $nome)){

                                        $pro = "nao";

                                    }else if(preg_match("/fornecedor/", $nome)){

                                        $pro = "nao";

                                    }

                                    

                                    $eng = "nao";

                                    if(preg_match("/engenheiro/", $nome)){

                                        $eng = "sim";

                                    }



                                    $selected = "";

                                    

                                    if($value['cd_grupo'] == $grupo_ativo){

                                        $selected ="selected";

                                    }

                        ?>



                            <option value="<?= $value['cd_grupo']; ?>" engenheiro="<?= $eng; ?>"

                                profissional="<?= $pro; ?>" <?= $selected; ?> >

                                <?= $value['nm_grupo']; ?>

                            </option>

                        <?php

                                }

                            }

                        ?>

                    </select>

                </div>

                <!-- <span class="obrigatorio">*</span> -->

            </div>



            <!-- NOME -->

            <hr class="dotted">

            <div class="form-group">

                <label class="col-lg-4 control-label" for="nome">Nome do usuario</label>

                <div class="col-lg-5">

                    <input type="text" class="form-control" name="nome" id="nome"  

                        value="<?= $nomeU; ?>" requiredz />

                </div>

            </div>



            <!-- RESPONSAVEL -->

            <hr class="dotted cli for">

            <div class="form-group cli for">

                <label class="col-lg-4 control-label" for="responsavel" >

                    Pessoa de contato

                </label>

                <div class="col-lg-5">

                    <input type="text" class="form-control cli-inpt" name="responsavel" 

                        id="responsavel" value="<?= $responsavel; ?>"  <?= $disabled; ?>/>

                </div>

            </div>



            <!-- ENDERECO -->

            <hr class="dotted cli-opt cli for">

            <div class="form-group cli-opt cli for">

                <label class="col-lg-4 control-label" for="endereco">Endereco</label>

                <div class="col-lg-5">

                    <input type="text" class="form-control cli-input for-inpt" name="endereco" 

                        id="endereco" value="<?= $endereco; ?>"  <?= $disabled; ?>/>

                </div>

            </div>



            <!-- BAIRRO -->

            <hr class="dotted cli-opt cli for">

            <div class="form-group cli-opt cli for">

                <label class="col-lg-4 control-label" for="bairro">Bairro</label>

                <div class="col-lg-5">

                    <input type="text" class="form-control cli-input for-inpt" name="bairro" 

                        id="bairro" value="<?= $bairro; ?>" <?= $disabled; ?>/>

                </div>

            </div>



            <!-- CEP -->

            <hr class="dotted cli-opt cli for">

            <div class="form-group cli-opt cli for">

                <label class="col-lg-4 control-label" for="endereco">CEP</label>

                <div class="col-lg-5">

                    <input type="text" class="form-control cli-input for-inpt" name="cep" 

                        id="cep" value="<?= $cep; ?>" <?= $disabled; ?>/>

                </div>

            </div>



            <!-- EMAIL -->

            <hr class="dotted">

            <div class="form-group">

                <label class="col-lg-4 control-label" for="email">Email do usuario</label>

                <div class="col-lg-5">

                    <input type="email" class="form-control" name="email" id="email"  

                        value="<?= $email;?>" requiredz  <?= $disabled; ?>/>

                </div>

                <!-- <span style="">*</span> -->

            </div>



            <!-- DOCUMENTO -->

            <hr class="dotted ">

            <div class="form-group ">

                <label class="col-lg-4 control-label" for="doctype">Documento</label>

                <div class="col-lg-5">



                    <span id="div_cpf">

                        <label for="type_cpf">

                            <input type="radio" class="doctype" 

                                name="doctype" value="cpf" id="type_cpf" <?= $cpf_checked; ?> >

                            CPF

                        </label>    

                    </span>



                    <span id="div_cnpj">

                        <label for="type_cnpj">

                        <input  type="radio" class="doctype"

                            name="doctype" value="cnpj" id="type_cnpj" <?= $cnpj_checked; ?> >

                            CNPJ

                        </label>    

                    </span>

                    



                    <input type="text" class="form-control" name="cpf" id="doctype" 

                        value="<?= $doctype; ?>" requiredz  <?= $disabled; ?>/>

                </div>

            </div>



            <!-- TELEFONE -->

            <hr class="dotted cli for">

            <div class="form-group cli for">

                <label class="col-lg-4 control-label" for="telefone">Telefone</label>

                <div class="col-lg-5">

                    <input type="text" class="form-control cli-inpt for-inpt" 

                        name="telefone" id="telefone" value="<?= $telefone; ?>" <?= $disabled; ?> />

                </div>

            </div>



            <!-- CELULAR -->

            <hr class="dotted cli for">

            <div class="form-group cli for">

                <label class="col-lg-4 control-label" for="celular">Celular</label>

                <div class="col-lg-5">

                    <input type="text" class="form-control cli-inpt" 

                            name="celular" id="celular" value="<?= $celular; ?>" <?= $disabled; ?>/>

                </div>

            </div>            



            <!-- CTPS -->

            <hr class="dotted pro">

            <div class="form-group pro">

                <label class="col-lg-4 control-label" for="ctps">CTPS</label>

                <div class="col-lg-5">

                    <input type="text" class="form-control pro-inpt" name="ctps" id="ctps"  

                        value="<?= $ctps; ?>" <?= $disabled; ?>/>

                </div>

            </div>



            <!-- SERIE CTPS -->

            <hr class="dotted pro">

            <div class="form-group pro">

                <label class="col-lg-4 control-label" for="serieCtps">Série CTPS</label>

                <div class="col-lg-5">

                    <input type="text" class="form-control pro-inpt" name="serieCtps"

                        id="serieCtps" value="<?= $serieCtps; ?>" <?= $disabled; ?> />

                </div>

            </div>



            <!-- TITULO DE ELEITOR  -->

            <hr class="dotted pro">

            <div class="form-group pro">

                <label class="col-lg-4 control-label" for="tituloEleitor">Titulo de eleitor</label>

                <div class="col-lg-5">

                    <input type="text" class="form-control pro-inpt" name="tituloEleitor"

                        id="tituloEleitor"  value="<?= $tituloEleitor; ?>" <?= $disabled; ?>/>

                </div>

            </div>



            <!-- ZONA ELEITORAL -->

            <hr class="dotted pro">

            <div class="form-group pro">

                <label class="col-lg-4 control-label" for="zonaEleitoral">Zona eleitoral</label>

                <div class="col-lg-5">

                    <input type="text" class="form-control pro-inpt" name="zonaEleitoral"

                        id="zonaEleitoral" value="<?= $zonaEleitoral; ?>" <?= $disabled; ?>/>

                </div>

            </div>

            

            <!-- CREA -->

            <hr class="dotted pro">

            <div class="form-group pro">

                <label class="col-lg-4 control-label" for="crea">CREA</label>

                <div class="col-lg-5">

                    <input type="text" class="form-control pro-inpt" name="crea" id="crea"  

                        value="<?= $crea; ?>" <?= $disabled; ?>/>

                </div>

            </div>



            <!-- CARGO -->

            <hr class="dotted cargo pro">

            <div class="form-group cargo pro">

                <label class="col-lg-4 control-label" for="cargo">

                    Selecione o cargo que este usuario possui

                </label>

                <div class="col-lg-5">

                    <select class="form-control pro-inpt" name="cargo"  id="cargo" <?= $disabled; ?>>

                        <option selected >Nenhum cargo</option>

                        <?php 

                            if(is_array($cargos)){

                                foreach ($cargos as $key => $value) {

                                    $selected = "";

                                    if($value['cd_cargo'] == $cargo){

                                        $selected = "selected";

                                    }

                        ?>



                            <option value="<?= $value['cd_cargo']; ?>" <?= $selected; ?>>

                                <?= $value['nm_cargo']; ?>

                            </option>

                        <?php

                                }

                            }

                        ?>

                    </select>

                </div>

            </div>



            <!-- CHEFIA -->

            <hr class="dotted chefia pro">

            <div class="form-group chefia pro">

                <label class="col-lg-4 control-label" for="chefia">Chefia</label>

                <div class="col-lg-5">

                    <select class="form-control pro-inpt" name="chefia" id="chefia" <?= $disabled; ?>>

                        <option selected >Sem chefia</option>

                        <?php 

                            if(is_array($chefias)){

                                foreach ($chefias as $key => $value) {

                                    $selected = "";

                                    if($value['cd_usuario'] == $chefia){

                                        $selected = "selected";

                                    }

                        ?>



                            <option value="<?= $value['cd_usuario']; ?>" <?= $selected?> >

                                <?= $value['nm_usuario']; ?>

                            </option>

                        <?php

                                }

                            }

                        ?>

                    </select>

                </div>

            </div>



            <!-- REGIAO -->

            <hr class="dotted pro">

            <div class="form-group pro">

                <label class="col-lg-4 control-label" for="regiao">Região</label>

                <div class="col-lg-5">

                    <select class="form-control pro-inpt" name="regiao" id="regiao" <?= $disabled; ?>>

                        <option selected>Sem Região</option>

                        <?php 

                            if(is_array($regioes)){

                                foreach ($regioes as $key => $value) {

                                    $selected = "";

                                    if($value['cd_regiao'] == $regiao){

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

            <!-- ESTADO -->

            <hr class="dotted">

            <div class="form-group">

                <label class="col-lg-4 control-label" for="estado">Estado</label>

                <div class="col-lg-5">

                    <select class="form-control " name="estado" id="estado" <?= $disabled; ?>>

                        <?php foreach($estados as $key => $estado){ 

                            $selected = "";

                            if($estado['cd_estado'] == $estadoAtivo){

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

                <label class="col-lg-4 control-label" for="cidade">Cidade</label>

                <div class="col-lg-5">

                    <select class="form-control" name="cidade" id="cidade" <?= $disabled; ?>>

                        <option selected disabled>Selecione uma cidade</option>

                    </select>

                </div>

            </div>



            <!-- SITUACAO -->

            <hr class="dotted">

            <div class="form-group">

                <label class="col-lg-4 control-label" for="status">Situação</label>

                <div class="col-lg-5">

                    <select class="form-control" name="status" id="status" requiredz  <?= $disabled; ?>>

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



            <!-- MATERIAIS -->

            <hr class="dotted for">

            <div class="form-group for">

                <label class="col-lg-4 control-label" for="material" >

                    Material comercializado

                </label>

                <div class="col-lg-5">

                    <textarea class="form-control for-inpt" rows="7" name="material"

                        id="material" <?= $disabled; ?>/><?= $material; ?></textarea>

                </div>

            </div>



            <!-- EDITAR SENHA -->

            <?php if($show_pw){ ?>

            <hr class="dotted">

            <div class="form-group">

                <label class="col-lg-4 control-label">Nova senha</label>

                <div class="col-lg-5">

                    <input type="password" class="form-control" id="pw1" name="pw1" autocomplete="new-password"/>

                </div>

            </div>



            <hr class="dotted">

            <div class="form-group">

                <label class="col-lg-4 control-label">Confirmar Nova senha</label>

                <div class="col-lg-5">

                    <input type="password" class="form-control" id="pw2" name="pw2"/>

                </div>

            </div>

            <?php } ?>

            <!-- FIM EDITAR SENHA -->

            

            <hr class="dotted">

        	<div class="form-group">

            <div class="col-sm-offset-4 col-sm-5">

            <input type="hidden" name="<?= $inputName; ?>" value="1">

            <?php if(isset($id)){ ?>

                <input type="hidden" name="id" value="<?= $id; ?>" >

            <?php } ?>

            <button type="submit" class="btn btn-success form-control"><?= $btn ?></button>

            </div>

        	</div>

        

    	</form>

    </div>

</div>

<script type="text/javascript">

    var tem_cidade = <?= isset($cidade) ? $cidade: 0; ?>;

    var url_cad_edit = 'usuarios/';

</script>

<style type="text/css">

    .chefia,.cargo,.crea{

        display:none;

    }



    .obrigatorio{

        color:red;

        font-size:35px;

        margin-left:-10px;

        margin-top:-35px;

    }

</style>

