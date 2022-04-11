<?php
	foreach($this->getMenu() as $key => $value){
		$p[$value['nm_modulo']] = $value['nivel_acesso'];
	}

	$pdfs = $this->list['pdfs'];

?>
<div class="panel panel-default">
    <div class="panel-heading">Proposta - PDFs</div>
    <div class="panel-body">
    
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="basic-datatable">
            <thead>
                <tr>
                    <th id="id-tabela">#</th>
                    <th class="text-center">PDF</th>
                    <th class="text-center">Gerado em</th>
                    <th class="text-center">situação</th>
                    <th style="max-width:80px" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                	if(isset($pdfs) && is_array($pdfs)){
                		foreach($pdfs as $key => $pdf){
                			$id = $pdf['cd_proposta_pdf'];
                            $nome = $pdf['ds_path_pdf'];
                            $link_PDF = DIR_PAGE.'public/PDFs/'.$nome."";
                            $registro = $pdf['dt_register'];
                            $status = 'inativo';
                            if($pdf['cd_situacao'] == 1){
                                $status == 'ativo';
                            }
                ?>
                	<tr>
                        <td><?= $id; ?></td>
                		<td class="text-center">
                            <a href="<?= $link_PDF; ?>" target="_blank">
                                <?= $nome; ?>.pdf
                            </a>
                        </td>
                        <td class="text-center"><?= $registro; ?></td>
                        <td class="text-center"><?= $status; ?></td>
                		<td style="max-width:80px" class="text-center">

                			<?php if($p['proposta'] >= 3 ){ ?>
                				
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
    var url_delete = "<?= PAINEL.'proposta/excluir-pdf';?>";
</script>