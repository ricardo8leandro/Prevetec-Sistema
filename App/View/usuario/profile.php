<?php



    if(isset($this->list['editar']) && is_array($this->list['editar'])){

        $status = 0;

        

        $id = $this->list['editar']['cd_usuario'];



        $nm_grupo = $this->list['editar']['nm_grupo'];

        $chefia = $this->list['editar']['nm_chefia'];



        $regiao = $this->list['editar']['nm_regiao'];

        $cargo = $this->list['editar']['nm_cargo'];

        $cidade = $this->list['editar']['nm_cidade'];

        $estado = $this->list['editar']['nm_estado'];

        

        $status = $this->list['editar']['ic_usuario'];

        $nomeU = $this->list['editar']['nm_usuario'];

        $email = $this->list['editar']['nm_email'];

        $login = $this->list['editar']['nm_login'];

        $telefone = $this->list['editar']['ds_telefone'];

        $celular =  $this->list['editar']['ds_celular'];

        

        $cpf = $this->list['editar']['cd_cpf'];

        $cnpj = $this->list['editar']['cd_cnpj'];



        $doc_name = "CNPJ";

        if(!empty($cpf)){

            $doctype = $cpf;

            $doc_name = "CPF";

        }else{

            $doctype = $cnpj;

        }



        $rg = $this->list['editar']['cd_rg'];

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

?>

<div class="panel panel-default">

    <div class="panel-heading"><?= $this->getTitle(); ?></div>



    <div class="panel-body">

    

    	<form class="form-horizontal" method="post" id="formEditProfile">

            

            <!-- GRUPO -->

            <div class="form-group">

                <label class="col-lg-4 control-label" for="nome">Grupo</label>

                <div class="col-lg-5">

                    <input type="text" class="form-control" value="<?= $nm_grupo; ?>" disabled/>

                </div>

            </div>



            <!-- NOME -->

            <hr class="dotted">

            <div class="form-group">

                <label class="col-lg-4 control-label" for="nome">Nome</label>

                <div class="col-lg-5">

                    <input type="text" class="form-control" name="nome" id="nome"  

                        value="<?= $nomeU; ?>" required/>

                </div>

            </div>



            <!-- EMAIL -->

            <hr class="dotted">

            <div class="form-group">

                <label class="col-lg-4 control-label" for="email">Email</label>

                <div class="col-lg-5">

                    <input type="email" class="form-control" value="<?= $email;?>" disabled/>

                </div>

            </div>



            <!-- DOCUMENTO -->

            <hr class="dotted ">

            <div class="form-group ">

                <label class="col-lg-4 control-label" for="doctype"><?= $doc_name; ?></label>

                <div class="col-lg-5">

                    <input type="text" class="form-control" value="<?= $doctype; ?>" disabled/>

                </div>

            </div>



            <!-- TELEFONE -->

            <!-- <hr class="dotted">

            <div class="form-group">

                <label class="col-lg-4 control-label" for="telefone">Telefone</label>

                <div class="col-lg-5">

                    <input type="text" class="form-control" 

                        name="telefone" id="telefone" value="<?= $telefone; ?>" />

                </div>

            </div> -->



            <!-- CELULAR -->

            <!-- <hr class="dotted">

            <div class="form-group">

                <label class="col-lg-4 control-label" for="celular">Celular</label>

                <div class="col-lg-5">

                    <input type="text" class="form-control" 

                            name="celular" id="celular" value="<?= $celular; ?>" />

                </div>

            </div> -->



            <!-- CTPS -->

            <hr class="dotted">

            <div class="form-group">

                <label class="col-lg-4 control-label" for="ctps">CTPS</label>

                <div class="col-lg-5">

                    <input type="text" class="form-control" value="<?= $ctps; ?>" disabled/>

                </div>

            </div>



            <!-- SERIE CTPS -->

            <hr class="dotted">

            <div class="form-group">

                <label class="col-lg-4 control-label" for="serieCtps">Série CTPS</label>

                <div class="col-lg-5">

                    <input type="text" class="form-control" value="<?= $serieCtps; ?>" disabled/>

                </div>

            </div>



            <!-- TITULO DE ELEITOR  -->

            <hr class="dotted">

            <div class="form-group">

                <label class="col-lg-4 control-label" for="tituloEleitor">Titulo de eleitor</label>

                <div class="col-lg-5">

                    <input type="text" class="form-control" value="<?= $tituloEleitor; ?>" disabled/>

                </div>

            </div>



            <!-- ZONA ELEITORAL -->

            <hr class="dotted">

            <div class="form-group">

                <label class="col-lg-4 control-label" for="zonaEleitoral">Zona eleitoral</label>

                <div class="col-lg-5">

                    <input type="text" class="form-control" value="<?= $zonaEleitoral; ?>" disabled />

                </div>

            </div>

            <!-- RG -->

            <hr class="dotted">

            <div class="form-group">

                <label class="col-lg-4 control-label" for="rg">RG</label>

                <div class="col-lg-5">

                    <input type="text" class="form-control" value="<?= $rg; ?>" disabled />

                </div>

            </div>



            <!-- CREA -->

            <hr class="dotted">

            <div class="form-group">

                <label class="col-lg-4 control-label" for="crea">CREA</label>

                <div class="col-lg-5">

                    <input type="text" class="form-control" value="<?= $crea; ?>" disabled />

                </div>

            </div>



            <!-- CARGO -->

            <hr class="dotted">

            <div class="form-group">

                <label class="col-lg-4 control-label" for="crea">Cargo</label>

                <div class="col-lg-5">

                    <input type="text" class="form-control" value="<?= $cargo; ?>" disabled />

                </div>

            </div>



            <!-- CHEFIA -->

            <hr class="dotted">

            <div class="form-group">

                <label class="col-lg-4 control-label" for="chefia">Chefia</label>

                <div class="col-lg-5">

                    <input type="text" class="form-control" value="<?= $chefia; ?>" disabled />

                </div>

            </div>



            <!-- REGIAO -->

            <hr class="dotted">

            <div class="form-group">

                <label class="col-lg-4 control-label" for="chefia">Região</label>

                <div class="col-lg-5">

                    <input type="text" class="form-control" value="<?= $regiao; ?>" disabled />

                </div>

            </div>



            <!-- ESTADO -->

            <hr class="dotted">

            <div class="form-group">

                <label class="col-lg-4 control-label" for="estado">Estado</label>

                <div class="col-lg-5">

                    <input type="text" class="form-control" value="<?= $estado; ?>" disabled/>

                </div>

            </div>



            <!-- CIDADE -->

            <hr class="dotted">

            <div class="form-group">

                <label class="col-lg-4 control-label" for="cidade">Cidade</label>

                <div class="col-lg-5">

                    <input type="text" class="form-control" value="<?= $cidade; ?>" disabled/>

                </div>

            </div>



            <!-- SENHA -->

            <hr class="dotted">

            <div class="form-group">

                <label class="col-lg-4 control-label">Nova senha</label>

                <div class="col-lg-5">

                    <input type="password" class="form-control" id="pw1" name="pw1"/>

                </div>

            </div>



            <hr class="dotted">

            <div class="form-group">

                <label class="col-lg-4 control-label">Confirmar Nova senha</label>

                <div class="col-lg-5">

                    <input type="password" class="form-control" id="pw2" name="pw2"/>

                </div>

            </div>



            <hr class="dotted">

        	<div class="form-group">

            <div class="col-sm-offset-4 col-sm-5">

            <input type="hidden" name="editProfile" value="1">

 

            <button type="submit" class="btn btn-success form-control">Salvar alterações</button>

            </div>

        	</div>

        

    	</form>

    </div>

</div>

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

