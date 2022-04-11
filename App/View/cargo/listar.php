<?php
	foreach($this->getMenu() as $key => $value){
		$p[$value['nm_modulo']] = $value['nivel_acesso'];
	}
	$cargos = $this->list['cargos'];
?>


<div class="panel panel-default">
    <div class="panel-heading">Lista de Cargos</div>
    <div class="panel-body">
    
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="basic-datatable">
            <thead>
                <tr>
                    <th class="text-center">Nome do Cargo</th>
                    <th class="text-center">Situação do Cargo</th>
                    <th style="max-width:100px" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                	if(isset($cargos) && is_array($cargos)){
                		foreach($cargos as $key => $cargo){
                			$id = $cargo['cd_cargo'];
                            $nome = $cargo['nm_cargo'];
                			$status = 'inativo';
                			if($cargo['ic_cargo'] == 1) $status = 'ativo';
                ?>
                	<tr>
                		<td class="text-center"><?= $nome; ?></td>
                		<td class="text-center"><?= $status; ?></td>
                		<td style="max-width:100px" class="text-center">
                			<?php if($p['Cargos'] >= 3 ){ ?>
                				
                				<a href="<?= PAINEL?>cargos/editar/<?= $id; ?>">
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
    var url_delete = "<?= PAINEL.'cargos/excluir';?>";
</script>