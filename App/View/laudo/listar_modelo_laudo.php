<?php
	foreach($this->getMenu() as $key => $value){
		$p[$value['nm_modulo']] = $value['nivel_acesso'];
	}
	$modelos = $this->list['modelos'];
?>


<div class="panel panel-default">
    <div class="panel-heading">Lista de Modelos de Laudo</div>
    <div class="panel-body">
    
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="basic-datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th class="text-center">Nome do modelo</th>
                    <th class="text-center">situação</th>
                    <th style="max-width:150px" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                	if(isset($modelos) && is_array($modelos)){
                		foreach($modelos as $key => $grupo){
                			$id = $grupo['cd_laudo_modelo'];
                			$status = $grupo['ic_status'];
                ?>
                	<tr>
                        <td><?= $id; ?></td>
                		<td class="text-center"><?= $grupo['nm_laudo_modelo']; ?></td>
                		<td class="text-center"><?= $grupo['ic_status']; ?></td>
                		<td style="max-width:150px" class="text-center">
                			<?php if($p['modelo de laudo'] >= 3){ ?>

                                <a  title="Adicionar Item" 
                                    href="<?= PAINEL?>modelo-laudo/item/novo/<?= $id; ?>">
                                    <button class="btn btn-success">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </a>

                                <a  title="Ver Itens" 
                                    href="<?= PAINEL?>modelo-laudo/indice/<?= $id; ?>">
                                    <button class="btn btn-info">
                                        <i class="fa  fa-reorder"></i>
                                    </button>
                                </a>
                				<a  title="Editar Modelo" 
                                    href="<?= PAINEL?>modelo-laudo/editar/<?= $id; ?>">
	                				<button class="btn btn-warning">
	                					<i class="fa fa-edit"></i>
	                				</button>
                				</a>
                            <?php } ?>
                            <?php if($p['modelo de laudo'] == 4){ ?>
                                <button title="Excluir Modelo"  
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
    var url_delete = "<?= PAINEL.'modelo-laudo/excluir';?>";
</script>