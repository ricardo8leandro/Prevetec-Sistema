<?php
	foreach($this->getMenu() as $key => $value){
		$p[$value['nm_modulo']] = $value['nivel_acesso'];
	}
	$regiao = $this->list['regioes'];
?>


<div class="panel panel-default">
    <div class="panel-heading">Lista de regiões</div>
    <div class="panel-body">
    
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="basic-datatable">
            <thead>
                <tr>
                    <th class="text-center">Nome da região</th>
                    <th class="text-center">Situação da região</th>
                    <th style="max-width:100px" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                	if(isset($regiao) && is_array($regiao)){
                		foreach($regiao as $key => $cargo){
                			$id = $cargo['cd_regiao'];
                            $nome = $cargo['nm_regiao'];
                			$status = 'inativo';
                			if($cargo['ic_regiao'] == 1) $status = 'ativo';
                ?>
                	<tr>
                		<td class="text-center"><?= $nome; ?></td>
                		<td class="text-center"><?= $status; ?></td>
                		<td style="max-width:100px" class="text-center">
                			<?php if($p['regiao'] >= 3 ){ ?>
                				
                				<a href="<?= PAINEL?>regiao/editar/<?= $id; ?>">
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
    var url_delete = "<?= PAINEL.'regiao/excluir';?>";
</script>