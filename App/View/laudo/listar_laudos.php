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
	$laudos = $this->list['laudos'];
    $regioes    = $this->list['regioes'];
    $clientes   = $this->list['clientes'];
    $modelos    = $this->list['modelos'];

    $regiao_ativa   = $this->list['filters']['regiao'];
    $cliente_ativo  = $this->list['filters']['cliente'];
    $status_ativo   = $this->list['filters']['status'];
    $modelo_Ativo   = $this->list['filters']['modelo'];
?>
<div class="panel panel-default">
    <div class="panel-heading">Filtros</div>

    <div class="panel-body">
        <form method="GET">

            <div class="row">
                <div class="col-lg-2">
                    <select class="form-control" name="cd_cliente" id="cliente">
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
                    <select class="form-control" name="cd_laudo_modelo" id="cd_laudo_modelo">
                        <option selected value="">Todos os Modelos</option>
                        <?php 
                            if(is_array($modelos)){
                                foreach ($modelos as $key => $value) {
                                    $selected = "";
                                    if($value['cd_laudo_modelo'] == $modelo_Ativo){
                                        $selected = "selected";
                                    }
                        ?>

                            <option value="<?= $value['cd_laudo_modelo']; ?>" <?= $selected; ?>>
                                <?= $value['nm_laudo_modelo']; ?>
                            </option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                </div>           

                <div class="col-lg-2">
                    <select class="form-control" name="cd_regiao">
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
                    <select class="form-control" name="ic_status" id="ic_status" >
                        <option selected value="">Todas as situações</option>
                        <option value="aberto" <?= is_selected('aberto',$status_ativo); ?> >
                            Aberto 
                        </option>
                        <option value="fechado" <?= is_selected('fechado',$status_ativo); ?> >
                            Fechado
                        </option>
                        <option value="aprovado" <?= is_selected('aprovado',$status_ativo); ?> >
                            Aprovado
                        </option>
                        <option value="recusado" <?= is_selected('recusado',$status_ativo); ?> >
                            Recusado 
                        </option>
                    </select>
                </div>

                <div class="col-sm-2">
                    <button class="btn btn-success btn-block">Filtrar</button>
                </div>

                <div class="col-sm-2">
                    <a href="<?= PAINEL ?>laudo/listar">
                    <button class="btn btn-info btn-block" type="button">Limpar</button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">Lista de Laudos</div>
    <div class="panel-body">
    
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="basic-datatable">
            <thead>
                <tr>
                    <th class="init_desc">#</th>
                    <th class="text-center">Cliente</th>
                    <th class="text-center">Modelo de Laudo</th>
                    <th class="text-center">Região</th>
                    <th class="text-center">Data de criação</th>
                    <th class="text-center">situação</th>
                    <th style="width:180px" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                	if(isset($laudos) && is_array($laudos)){
                		foreach($laudos as $key => $laudo){
                			$id = $laudo['cd_laudo'];
                			$status = $laudo['ic_status'];

                            $dt = date('d/m/Y h:i:s', strtotime($laudo['dt_cadastro']));
                            $url_link ="#";
                            $a_target= "";
                            $download = '';
                ?>
                	<tr>
                        <td><?= $id; ?></td>
                        <td class="text-center"><?= $laudo['nm_cliente']; ?></td>
                		<td class="text-center"><?= $laudo['nm_laudo_modelo']; ?></td>
                        <td class="text-center"><?= $laudo['nm_regiao']; ?></td>
                        <td class="text-center"><?= $dt; ?></td>
                		<td class="text-center"><?= $laudo['ic_status']; ?></td>
                		<td style="width:180px" class="text-center">

                            <?php 
                                $disabled = "disabled";
                                if(!empty($laudo['ds_path_laudo_pdf'])){
                                    $url_link = DIR_LAUDO_PDF.$laudo['ds_path_laudo_pdf'];
                                    $disabled = "";
                                    $a_target = 'target="_blank"';
                                    $download = "download";
                                    $url_link = "href='".$url_link."'";
                                }

                            ?>

                            <a 
                                title="Visualizar Laudo" 
                                <?= $url_link; ?>
                                <?= $disabled; ?>
                                <?= $a_target; ?>
                                >
                                <button class="btn btn-info" <?= $disabled; ?>>
                                    <i class="fa fa-file-text-o"></i>
                                </button>
                            </a>

                            <a  
                                title="Baixar Laudo"
                                <?= $url_link;?>
                                <?= $disabled; ?>
                                <?= $download; ?> >
                                <button class="btn btn-info" <?= $disabled; ?>>
                                    <i class="fa fa-download"></i>
                                </button>
                            </a>

                            

                			<?php if($p['laudo'] >= 3){ ?>
                				<a  title="Editar Laudo" 
                                    href="<?= PAINEL?>laudo/editar/<?= $id; ?>">
	                				<button class="btn btn-info">
	                					<i class="fa fa-edit"></i>
	                				</button>
                				</a>
                            <?php } ?>
                            <?php if($p['laudo'] == 4){ ?>
                                <button title="Excluir Laudo"  
                                    class="btn btn-danger btnDelete" value="<?= $id; ?>" >
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
    var url_delete = "<?= PAINEL.'laudo/excluir';?>";
</script>