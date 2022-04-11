<?php
	foreach($this->getMenu() as $key => $value){
		$p[$value['nm_modulo']] = $value['nivel_acesso'];
	}
	$edificios = $this->list['edificios'];
?>


<div class="panel panel-default">
    <div class="panel-heading">Lista de edificios</div>
    <div class="panel-body">
    
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="basic-datatable">
            <thead>
                <tr>
                    <th class="text-center">Titulo do edificio</th>
                    <th class="text-center">Situação do edificio</th>
                    <th style="max-width:100px" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                	if(isset($edificios) && is_array($edificios)){
                		foreach($edificios as $key => $edificio){
                			$id = $edificio['cd_tipo_edificio'];
                            $nome = $edificio['ds_titulo'];
                			$status = 'inativo';
                			if($edificio['cd_situacao'] == 1) $status = 'ativo';
                ?>
                	<tr>
                		<td class="text-center"><?= $nome; ?></td>
                		<td class="text-center"><?= $status; ?></td>
                		<td style="max-width:100px" class="text-center">
                			<?php if($p['tipo de edificio'] >= 3 ){ ?>
                				
                				<a href="<?= PAINEL?>edificio/editar/<?= $id; ?>">
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
    var url_delete = "<?= PAINEL.'edificio/excluir';?>";
</script>