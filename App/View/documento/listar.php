<?php
	foreach($this->getMenu() as $key => $value){
		$p[$value['nm_modulo']] = $value['nivel_acesso'];
	}
	$documentos = $this->list['documentos'];
?>


<div class="panel panel-default">
    <div class="panel-heading">Lista de documentos</div>
    <div class="panel-body">
    
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="basic-datatable">
            <thead>
                <tr>
                    <th class="text-center">Titulo</th>
                    <th class="text-center">Situação</th>
                    <th style="max-width:100px" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                	if(isset($documentos) && is_array($documentos)){
                		foreach($documentos as $key => $doc){
                			$id = $doc['cd_documento'];
                            $nome = $doc['ds_titulo'];
                			$status = 'inativo';
                			if($doc['cd_situacao'] == 1) $status = 'ativo';
                ?>
                	<tr>
                		<td class="text-center"><?= $nome; ?></td>
                		<td class="text-center"><?= $status; ?></td>
                		<td style="max-width:100px" class="text-center">
                			<?php if($p['documento'] >= 3 ){ ?>
                				
                				<a href="<?= PAINEL?>documento/editar/<?= $id; ?>">
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
    var url_delete = "<?= PAINEL.'documento/excluir';?>";
</script>