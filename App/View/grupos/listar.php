<?php
	foreach($this->getMenu() as $key => $value){
		$p[$value['nm_modulo']] = $value['nivel_acesso'];
	}
	$grupos = $this->list['grupos'];
?>


<div class="panel panel-default">
    <div class="panel-heading">Lista de Grupos</div>
    <div class="panel-body">
    
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="basic-datatable">
            <thead>
                <tr>
                    <th class="text-center">Nome do grupo</th>
                    <th class="text-center">Descrição do grupo</th>
                    <th class="text-center">Situação do grupo</th>
                    <th style="max-width:100px" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                	if(isset($grupos) && is_array($grupos)){
                		foreach($grupos as $key => $grupo){
                			$id = $grupo['cd_grupo'];
                			$status = 'inativo';
                			if($grupo['status_grupo'] == 1) $status = 'ativo';
                ?>
                	<tr>
                		<td class="text-center"><?= $grupo['nm_grupo']; ?></td>
                		<td class="text-center"><?= $grupo['ds_grupo']; ?></td>
                		<td class="text-center"><?= $status; ?></td>
                		<td style="max-width:100px" class="text-center">
                			<?php if($p['grupos'] == 3 || $p['grupos'] == 4 && $id > 1){ ?>
                				
                				<a href="<?= PAINEL?>grupos/editar/<?= $id; ?>">
	                				<button class="btn btn-info">
	                					<i class="fa fa-edit"></i>
	                				</button>
                				</a>
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
    var url_delete = "<?= PAINEL.'grupos/excluir';?>";
</script>