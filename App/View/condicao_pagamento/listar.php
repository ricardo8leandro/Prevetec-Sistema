<?php
	foreach($this->getMenu() as $key => $value){
		$p[$value['nm_modulo']] = $value['nivel_acesso'];
	}
	$condicoes = $this->list['condicoes'];
?>


<div class="panel panel-default">
    <div class="panel-heading">Lista de condições de pagamento</div>
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
                	if(isset($condicoes) && is_array($condicoes)){
                		foreach($condicoes as $key => $condicao){
                			$id = $condicao['cd_condicao_pagto'];
                            $nome = $condicao['ds_titulo'];
                			$status = 'inativo';
                			if($condicao['cd_situacao'] == 1) $status = 'ativo';
                ?>
                	<tr>
                		<td class="text-center"><?= $nome; ?></td>
                		<td class="text-center"><?= $status; ?></td>
                		<td style="max-width:100px" class="text-center">
                			<?php if($p['condicao de pagamento'] >= 3 ){ ?>
                				
                				<a href="<?= PAINEL?>condicao-de-pagamento/editar/<?= $id; ?>">
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
    var url_delete = "<?= PAINEL.'condicao-de-pagamento/excluir';?>";
</script>