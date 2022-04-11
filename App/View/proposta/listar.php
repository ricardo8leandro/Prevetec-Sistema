<?php
    function is_selected($vl1, $vl2){
        if($vl1 == $vl2){
            return 'selected';
        }
        return '';
    }

	foreach($this->getMenu() as $key => $value){
		$p[$value['nm_modulo']] = $value['nivel_acesso'];
	}

	$propostas  = $this->list['propostas'];
    $regioes    = $this->list['regioes'];
    $clientes   = $this->list['clientes'];
    $ts         = $this->list['tipoServico'];

    $regiao_ativa   = $this->list['filters']['regiao'];
    $cliente_ativo  = $this->list['filters']['cliente'];
    $status_ativo   = $this->list['filters']['status'];
    $tipoServico_ativo = $this->list['filters']['tipoServico'];
?>
<div class="panel panel-default">
    <div class="panel-heading">Filtros</div>

    <div class="panel-body">
        <form method="GET">

            <div class="row">
                <div class="col-lg-2">
                    <select class="form-control" name="cliente" id="cliente">
                        <option selected value="">Todos os clientes</option>
                        <?php 
                            if(is_array($clientes)){
                                foreach ($clientes as $key => $value) {
                                    $selected = "";
                                    if($value['cd_usuario'] == $cliente_ativo){
                                        $selected = "selected";
                                    }
                        ?>

                            <option value="<?= $value['cd_usuario']; ?>" <?= $selected; ?>>
                                <?= $value['nm_usuario']; ?>
                            </option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                </div>

                <div class="col-lg-2">
                    <select class="form-control" name="tipoServico" id="tipoServico">
                        <option selected value="">Todos os tipos de serviço</option>
                        <?php 
                            if(is_array($ts)){
                                foreach ($ts as $key => $value) {
                                    $selected = "";
                                    if($value['cd_tipo_servico'] == $tipoServico_ativo){
                                        $selected = "selected";
                                    }
                        ?>

                            <option value="<?= $value['cd_tipo_servico']; ?>" <?= $selected; ?>>
                                <?= $value['ds_titulo']; ?>
                            </option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                </div>           

                <div class="col-lg-2">
                    <select class="form-control" name="regiao">
                        <option selected value="">Todas as regiões</option>
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

                <div class="col-lg-2">
                    <select class="form-control" name="status" id="status" >
                        <option selected value="">Todas as situações</option>
                        <option value="aberta" <?= is_selected($status_ativo,'aberta'); ?> >
                         Aberta 
                        </option>
                        <option value="fechada" <?= is_selected($status_ativo,'fechada'); ?> >
                         Fechada 
                        </option>
                        <option value="cancelada" <?= is_selected($status_ativo,'cancelada'); ?> >
                         Cancelada
                        </option>
                    </select>
                </div>

                <div class="col-sm-2">
                    <button class="btn btn-success btn-block">Filtrar</button>
                </div>

                <div class="col-sm-2">
                    <a href="<?= PAINEL ?>proposta/listar">
                    <button class="btn btn-info btn-block" type="button">Limpar</button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">Lista de Propostas</div>
    <div class="panel-body">
    
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="basic-datatable">
            <thead>
                <tr>
                    <th id="id-tabela">#</th>
                    <th class="text-center">Cliente</th>
                    <th class="text-center">Tipo de Serviço</th>
                    <th class="text-center">Registro</th>
                    <th class="text-center">Prazo Execução</th>
                    <th class="text-center">Região</th>
                    <th class="text-center">Situação</th>
                    <th style="width:180px" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                	if(isset($propostas) && is_array($propostas)){
                		foreach($propostas as $key => $proposta){
                			$id = $proposta['cd_proposta'];
                            $cliente = $proposta['nm_cliente'];
                            $tipoServico = $proposta['ts_titulo'];
                            $regiao = $proposta['nm_regiao'];
                            $status = $proposta['ic_proposta'];

                            $dt1 = $proposta['dt_registro'];
                            $dtRegistro = date('d/m/Y h:i:s',strtotime($dt1));
                            
                            $prazoExecucao = $proposta['ds_prazo_execucao'];
                            $link_PDF = "javascript:void()";
                            $link_disabled = "disabled";
                            
                            if(!empty($proposta['ds_path_proposta_pdf'])){
                                $link_PDF = $proposta['ds_path_proposta_pdf'];
                                $link_PDF = DIR_PAGE.'public/PDFs/'.$link_PDF."";
                                $link_disabled = "";
                            }
                ?>
                	<tr>
                        <td><?= $id; ?></td>
                		<td class="text-center"><?= $cliente; ?></td>
                		<td class="text-center"><?= $tipoServico; ?></td>
                        <td class="text-center"><?= $dtRegistro; ?></td>
                        <td class="text-center"><?= $prazoExecucao; ?> dia(s)</td>
                        <td class="text-center"><?= $regiao; ?></td>
                        <td class="text-center"><?= $status; ?></td>
                		<td style="width:180px" class="text-center">
                            <button class="btn btn-success btnLink" <?= $link_disabled; ?> 
                                href="<?= $link_PDF; ?>">
                                <i class="fa fa-file-pdf-o"></i>
                            </button>
                            
                            <button value="<?= $id; ?>" class="btn btn-warning btnPDFs" 
                                <?= $link_disabled; ?>>
                                <i class="fa fa-file-pdf-o"></i>
                            </button>
                            
                			<?php if($p['proposta'] >= 3 ){ ?>
                				
                				<a href="<?= PAINEL?>proposta/editar/<?= $id; ?>">
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
    var url_delete          = "<?= PAINEL.'proposta/excluir';?>";
    var propostaAprovada    = "";
</script>