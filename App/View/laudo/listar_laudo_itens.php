<?php
	foreach($this->getMenu() as $key => $value){
		$p[$value['nm_modulo']] = $value['nivel_acesso'];
	}

	$modelos = $this->list['itens'];
?>


<div class="panel panel-default">
    <div class="panel-heading">Lista de Modelos de Laudo</div>
    <div class="panel-body">
    
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="basic-datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th class="text-center">Titulo do item</th>
                    <th class="text-center">Nome do modelo</th>
                    <th class="text-center">situação</th>
                    <th style="max-width:100px" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                	if(isset($modelos) && is_array($modelos)){
                		foreach($modelos as $key => $grupo){
                			$id = $grupo['cd_laudo_item'];
                			$status = $grupo['ic_status'];
                ?>
                	<tr>
                        <td><?= $id; ?></td>
                        <td class="text-center"><?= $grupo['ds_titulo']; ?></td>
                		<td class="text-center"><?= $grupo['nm_laudo_modelo']; ?></td>
                		<td class="text-center"><?= $grupo['ic_status']; ?></td>
                		<td style="max-width:100px" class="text-center">
                			<?php if($p['modelo de laudo'] >= 3){ ?>
                				<a href="<?= PAINEL; ?>modelo-laudo/item/editar/<?= $id; ?>">
	                				<button class="btn btn-info">
	                					<i class="fa fa-edit"></i>
	                				</button>
                				</a>
                            <?php } ?>
                            <?php if($p['modelo de laudo'] == 4){ ?>
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
    var url_delete = "<?= PAINEL.'modelo-laudo/item/excluir';?>";
</script>