<!-- MODAL LISTAR SERVICOS -->
<div class="modal fade modal-lista-servicos" tabindex="-1" role="dialog" 
	aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  	<div class="modal-dialog modal-xl">
    	<div class="modal-content">
    		<div class="row">
    			<br>
    			<div class="row">
    				<div class="col-sm-12 text-center">
    					<h2>Lista de Serviços</h2>		
    				</div>
    			</div>
    			
    			<br>
    			<div class="col-sm-10 col-sm-offset-1">
    				<select class="form-control select-servicos" multiple style="min-height: 250px">
					</select>		
    			</div>
    			<br>
    			<div class="col-sm-6 col-sm-offset-3">
    				<br>
    				<div class="row">
    					<div class="col-6 col-sm-6">
	    					<button class="btn btn-success btnConfirmaSelectServico">
	    						Confirmar		
	    					</button>
	    				</div>

	    				<div class="col-6 col-sm-6">
	    					<button class="btn btn-danger btnCancelaSelectServico">
	    						Cancelar
	    					</button>
	    				</div>	
    				</div>
    				<br>
    			</div>
    		</div>
      		
    	</div>
  	</div>
</div>

<!-- MODAL EDITAR SERVICO -->
<div class="modal fade modal-edita-servico" tabindex="-1" role="dialog" 
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="row form-horizontal modal-edit-servico-form">
                <br>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h2>Editar Serviço</h2>      
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-10 col-sm-offset-1" for="editServico-titulo">
                        Servico
                    </label>
                    <div class="col-sm-10 col-sm-offset-1">
                        <input class="form-control servicos" id="editServico-titulo" disabled>
                    </div>
                </div>

                
                <div class="form-group">
                    <label class="col-sm-10 col-sm-offset-1" for="editServico-qtd">
                        Quantidade
                    </label>
                    <div class="col-sm-10 col-sm-offset-1">
                        <input type="number" class="form-control" id="editServico-qtd">
                    </div>
                </div>

                
                <div class="form-group">
                    <label class="col-sm-10 col-sm-offset-1" for="editServico-dimensao">
                        Dimensão
                    </label>
                    <div class="col-sm-10 col-sm-offset-1">
                        <input type="text" class="form-control" id="editServico-dimensao">
                    </div>
                </div>

                
                <div class="form-group">
                    <label class="col-sm-10 col-sm-offset-1" for="editServico-obs">
                        Observações
                    </label>
                    <div class="col-sm-10 col-sm-offset-1">
                        <textarea cols="100" class="ckeditor" id="editServico-obs" name="obs" rows="100"></textarea>
                    </div>
                </div>

                
                <div class="col-sm-10 col-sm-offset-1">
                    <br>
                    <div class="row">
                        <div class="col-6 col-sm-6">
                            <button class="btn btn-success btn-block btnConfirmaEditServico">
                                Confirmar       
                            </button>
                        </div>

                        <div class="col-6 col-sm-6">
                            <button class="btn btn-danger btn-block btnCancelaEditServico">
                                Cancelar
                            </button>
                        </div>  
                    </div>
                    <br>
                </div>
            </div>
            
        </div>
    </div>
</div>