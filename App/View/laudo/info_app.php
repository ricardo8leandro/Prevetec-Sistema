<?php


	foreach($this->getMenu() as $key => $value){
		$p[$value['nm_modulo']] = $value['nivel_acesso'];
	}


    $infoapp = $this->list['infoapp'];


?>

<div class="panel panel-default">
    <div class="panel-heading">Informações de Campo para Laudos</div>
    <div class="panel-body">
    
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="basic-datatable">
            <thead>
                <tr>
                <th class="init_desc">#</th>
                    <th class="init_desc">N. Laudo</th>
                    <th style="width:180px" class="text-center">ART</th>
                    <th class="text-center">Aterramento</th>
                    <th class="text-center">Conformidade</th>
                    <th class="text-center">Tipo de Laudo</th>
                    <th class="text-center">Descida</th>
                    <th class="text-center">Imagem</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php 
                                
                	if(isset($infoapp) && is_array($infoapp)){

                		foreach($infoapp as $key => $infoapps){
                			$id = $infoapps['id'];
                			

                            
                            $url_link ="#";
                            $a_target= "";
                            $download = '';
                ?>
                	<tr>
                        <td><?= $id; ?></td>
                        <td class="text-center"><?= $infoapps['id_laudo']; ?></td>
                		<td class="text-center"><?= $infoapps['cd_art']; ?></td>
                        <td class="text-center"><?= $infoapps['conformidade']; ?></td>
                        <td class="text-center"><?= $infoapps['tipo_laudo']; ?></td>
                		<td class="text-center"><?= $infoapps['descida']; ?></td>
                		<td style="width:180px" class="text-center">

                            <?php 
                                $disabled = "disabled";
                                if(!empty($laudo['ds_path_laudo_pdf'])){
                                    $url_link = DIR_LAUDO_PDF.$laudo['ds_path_laudo_pdf'];
                                    $disabled = "";
                                    $a_target = 'target="_blank"';
                                    $download = "download";
                                    $url_link = "href='".$url_link."'";
                                }

                            ?>
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
