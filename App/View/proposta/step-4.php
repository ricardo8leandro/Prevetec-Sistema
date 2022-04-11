<div class="form-group ">
    <div class="col-lg-10 col-lg-offset-1">
    	<div class="row c-pdf">
    		<div class="col-sm-6">
    			<a id="visualizarPDF" class="href_pdf" href="" target="_blank">
					<button type="button" class="btn btn-info btn-block" >
						Visualizar PDF
					</button>
				</a>
    		</div>
    		<div class="col-sm-6">
    			<a id="baixarPDF" class="href_pdf" href="" download>
					<button type="button" class="btn btn-success btn-block">
						Baixar PDF
					</button>
				</a>
    		</div>
    	</div>
        <?php if(isset($this->list['pdfs']) && is_array($this->list['pdfs'])){ 
            $proposta_id = $this->list['proposta_id'];
            $url_link = DIR_PAGE.'Painel/proposta/listar-proposta-pdfs/'.$proposta_id;
        ?>
            
        <div class="row">
            <hr>
            <div class="col-sm-4">
                <a href="<?= $url_link; ?>">
                <button type="button" class="btn btn-info btn-block" >
                    Ver histórico de PDFs
                </button>
                </a>
            </div>

            <div class="col-sm-4">
                <button 
                    type="button" 
                    value="<?= $proposta_id; ?>" 
                    class="btn btn-success btn-block btnAprovarProposta" >
                    Proposta aprovada
                </button>
            </div>
            <div class="col-sm-4">
                <button 
                    type="button" 
                    value="<?= $proposta_id; ?>"
                    class="btn btn-danger btn-block btnRecusarProposta">
                    Proposta recusada
                </button>
            </div>
        </div>
        <?php } ?>
    </div>
</div>