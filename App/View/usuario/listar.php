<?php

    function is_selected($vl1, $vl2){

        if($vl1 == $vl2) return "selected"; return "";

    }



	foreach($this->getMenu() as $key => $value){

		$p[$value['nm_modulo']] = $value['nivel_acesso'];

	}



    $cidade_ativa = 0;



	$usuarios   = $this->list['usuarios'];

    $grupos     = $this->list['grupos'];

    $cargos     = $this->list['cargos'];

    $estados        = $this->list['estados'];

    $regioes        = $this->list['regioes'];



    $grupo_ativo    = $this->list['filters']['grupo'];

    $cargo_ativo    = $this->list['filters']['cargo'];

    $status_ativo   = $this->list['filters']['status'];

    $nome_digitado  = $this->list['filters']['name'];

    $regiao_ativa   = $this->list['filters']['regiao'];

    $estado_ativo   = $this->list['filters']['estado'];

    $cidade_ativa   = $this->list['filters']['cidade'];

?>

<div class="panel panel-default">

    <div class="panel-heading">Filtros</div>

    <div class="panel-body">

        <form method="GET">

            <div class="row">

                <div class="col-sm-3">

                    <select class="form-control" name="grupo"  id="grupo">

                        <option selected value="">Todos grupos</option>

                        <?php 

                            if(is_array($grupos)){

                                foreach ($grupos as $key => $value) {

                                    $selected = "";

                                    

                                    if($value['cd_grupo'] == $grupo_ativo){

                                        $selected ="selected";

                                    }

                        ?>



                            <option value="<?= $value['cd_grupo']; ?>" <?= $selected; ?> >

                                <?= $value['nm_grupo']; ?>

                            </option>

                        <?php

                                }

                            }

                        ?>

                    </select>

                </div>



                <div class="col-lg-3">



                    <select class="form-control" name="regiao">

                        <option selected value="">Todas as regĩões</option>

                        <option value="0" <?= is_selected($cargo_ativo,'sem cargo'); ?> >

                            Sem cargo

                        </option>

                        <?php 

                            if(is_array($cargos)){

                                foreach ($cargos as $key => $value) {

                                    $selected = "";

                                    if($value['cd_cargo'] == $cargo_ativo){

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



                <div class="col-sm-3">

                    <select class="form-control" name="status"  id="status">

                        <option selected value="">Todos os status</option>

                        <option value="1" <?= is_selected($status_ativo,'1'); ?> >Ativos</option>

                        <option value="0" <?= is_selected($status_ativo,'0'); ?> >Inativos</option>

                    </select>

                </div>



                <div class="col-sm-3">

                    <input 

                        type="text" 

                        placeholder="Digite o nome do usuário" 

                        name="name" 

                        id="name" 

                        class="form-control"

                        value="<?= $nome_digitado; ?>" >

                </div>

            </div>

            <br>

            <div class="row">

                <div class="col-lg-3">



                    <select class="form-control" name="regiao">

                        <option selected value="">Todas as regĩões</option>

                        <?php 

                            if(is_array($regioes)){

                                foreach ($regioes as $key => $regiao) {

                                    $selected = "";

                                    if($regiao['cd_regiao'] == $regiao_ativa){

                                        $selected = "selected";

                                    }

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



                <div class="col-lg-3">

                    <select class="form-control" name="estado" id="estado">

                        <option selected value="">Todos os estados</option>

                        <?php 

                            if(is_array($estados)){

                                foreach ($estados as $key => $value) {

                                    $selected = "";

                                    if($value['cd_estado'] == $estado_ativo){

                                        $selected = "selected";

                                    }

                        ?>



                            <option value="<?= $value['cd_estado']; ?>" <?= $selected; ?>>

                                <?= $value['nm_estado']; ?>

                            </option>

                        <?php

                                }

                            }

                        ?>

                    </select>

                </div>



                <div class="col-lg-2">

                    <select class="form-control" name="cidade" id="cidade">

                        <option selected disabled>Todas as Cidades</option>

                    </select>

                </div>

                



                <div class="col-sm-2">

                    <button class="btn btn-success btn-block">Filtrar</button>

                </div>



                <div class="col-sm-2">

                    <a href="<?= PAINEL ?>usuarios/listar">

                    <button class="btn btn-info btn-block" type="button">Limpar</button>

                    </a>

                </div>

            </div>

        </form>

    </div>

</div>



<div class="panel panel-default">

    <div class="panel-heading">Lista de Usuários</div>

    <div class="panel-body">

    

        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="basic-datatable">

            <thead>

                <tr>

                    <th class="text-center">Nome do usuário</th>
                    <th class="text-center">Email</th>

                    <th class="text-center">Grupo</th>

                    <th class="text-center">Cargo</th>

                    <th class="text-center">Estado</th>

                    <th class="text-center">Cidade</th>

                    <th class="text-center">Região</th>

                    <th class="text-center">Situação </th>

                    <th style="width:100px" class="text-center">Ações</th>

                </tr>

            </thead>

            <tbody>

                <?php 

                	if(isset($usuarios) && is_array($usuarios)){

                		foreach($usuarios as $key => $usuario){

                			$id      = $usuario['cd_usuario'];

                            $nome    = $usuario['nm_usuario'];

                            $email   = $usuario['nm_email'];

                            $grupo   = $usuario['nm_grupo'];

                            $cargo   = "sem cargo";

                            $estado  = $usuario['sg_estado'];

                            $cidade  = $usuario['nm_cidade'];

                            $regiao  = $usuario['nm_regiao'];



                			$status = 'inativo';

                			if($usuario['ic_usuario'] == 1) $status = 'ativo';

                			if(!empty($usuario['nm_cargo'])){

                				$cargo = $usuario['nm_cargo'];

                			}

                ?>

                	<tr>

                		<td class="text-center"><?= $nome; ?></td>

                        <td class="text-center"><?= $email; ?></td>

                		<td class="text-center"><?= $grupo; ?></td>

                		<td class="text-center"><?= $cargo; ?></td>

                        <td class="text-center"><?= $estado; ?></td>

                        <td class="text-center"><?= $cidade; ?></td>

                        <td class="text-center"><?= $regiao; ?></td>

                		<td class="text-center"><?= $status; ?></td>

                		<td style="width:100px" class="text-center">

                			<?php if($p['usuarios'] >= 3 ){ ?>

                				

                				<a href="<?= PAINEL?>usuarios/editar/<?= $id; ?>">

	                				<button class="btn btn-info">

	                					<i class="fa fa-edit"></i>

	                				</button>

                				</a>

                				<button class="btn btn-danger btnDelete" value="<?= $id; ?>" >

                                    <i class="fa fa-trash"></i>

                                </button>

                			<?php } ?>

                		</td>

                	</tr>

                <?php

                		}

                	}

                ?>

            </tbody>

        </table>



    </div>

</div>

<script type="text/javascript">

    var url_delete = "<?= PAINEL.'usuarios/excluir';?>";

    var tem_cidade = <?= "'".$cidade_ativa."'"; ?>;

</script>