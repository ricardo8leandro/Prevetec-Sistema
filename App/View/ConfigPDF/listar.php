<?php
	foreach($this->getMenu() as $key => $value){
		$p[$value['nm_modulo']] = $value['nivel_acesso'];
	}
	$ConfigPDFs = $this->list['ConfigPDFs'];
?>


<div class="panel panel-default">
    <div class="panel-heading">Lista de Anexos</div>
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
                	if(isset($ConfigPDFs) && is_array($ConfigPDFs)){
                		foreach($ConfigPDFs as $key => $config){
                			$id = $config['cd_pdf_config'];
                            $nome = $config['ds_titulo'];
                			$status = 'inativo';
                			if($config['cd_situacao'] == 1) $status = 'ativo';
                ?>
                	<tr>
                		<td class="text-center"><?= $nome; ?></td>
                		<td class="text-center"><?= $status; ?></td>
                		<td style="max-width:100px" class="text-center">
                			<?php if($p['anexo'] >= 3 ){ ?>
                				
                				<a href="<?= PAINEL?>configuracao-de-pdf/editar/<?= $id; ?>">
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
    var url_delete = "<?= PAINEL.'configuracao-de-pdf/excluir';?>";
</script>