<div id="formAdicionarArea" style="display:none">
	<hr class="dotted">
	<div class="form-group">
	    <label class="col-lg-4 control-label" for="area">
	        Área
	    </label>
	    <div class="col-lg-4">
	        <select class="form-control" name="area"  id="area" >
	            <option selected disabled value="0">Selecione a área</option>
	            <?php 
	                if(is_array($areas)){
	                    foreach ($areas as $key => $area) {
	                    	$id = $area['cd_area'];
	            ?>
	                <option value="<?= $id; ?>" id="opt_area_<?= $id; ?>">
	                    <?= $area['ds_titulo']; ?>
	                </option>
	            <?php
	                    }
	                }
	            ?>
	        </select>
	    </div>
	</div>

	<!-- TELHADO METALICO -->
	<hr class="dotted">
	<div class="form-group">
	    <label class="col-lg-4 control-label" for="telhadoM">
	        Telhado Metalico
	    </label>
	    <div class="col-lg-4">
	        <select class="form-control" name="telhadoM"  id="telhadoM" >
	           <option value="1" selected>SIM</option>
	           <option value="0">NÃO</option>
	        </select>
	    </div>
	</div>
	
	<!-- ESTRUTURA METALICA -->
	<hr class="dotted">
	<div class="form-group">
	    <label class="col-lg-4 control-label" for="estruturaM">
	        Estrutura Metalica
	    </label>
	    <div class="col-lg-4">
	        <select class="form-control" name="estruturaM"  id="estruturaM" >
	           <option value="1" selected>SIM</option>
	           <option value="0">NÃO</option>
	        </select>
	    </div>
	</div>

	<!-- USA CAPACITOR DE TERMINAL AEREO -->
	<hr class="dotted">
	<div class="form-group">
	    <label class="col-lg-4 control-label" for="usaCTA">
	        Usa Capacitor de Terminal Aéreo
	    </label>
	    <div class="col-lg-4">
	        <select class="form-control" name="usaCTA"  id="usaCTA" >
	           <option value="1" selected>SIM</option>
	           <option value="0">NÃO</option>
	        </select>
	    </div>
	</div>

	<!-- NIVEL/ANEXO -->
	<hr class="dotted">
	<div class="form-group">
	    <label class="col-lg-4 control-label" for="anexo">
	        Nivel
	    </label>
	    <div class="col-lg-4">
	        <select class="form-control" name="anexo"  id="anexo" >
	            <option selected disabled value="0">Selecione o nivel</option>
	            <?php 
	                if(is_array($anexos)){
	                    foreach ($anexos as $key => $anexo) {
	                        $selected = "";
	                        if($anexo['cd_anexo'] == $te_id){
	                            $selected = "selected";
	                        }
	            ?>
	                <option value="<?= $anexo['cd_anexo']; ?>" <?= $selected; ?>>
	                    <?= $anexo['ds_titulo']; ?>
	                </option>
	            <?php
	                    }
	                }
	            ?>
	        </select>
	    </div>
	</div>

	<!-- AÇÕES [confirmar / cancelar ] -->
	<hr class="dotted">
	<div class="form-group">
	    <div class="col-lg-4 col-lg-offset-4">
	    	<div class="row">
	    		<div class="col-6 col-sm-6">
	    			<button type="button" class="btn btn-success btn-block" 
	    				id="btnConfirmarAddArea">
	    				Confirmar
	    			</button>
	    		</div>

	    		<div class="col-6 col-sm-6">
	    			<button type="button" class="btn btn-danger btn-block" 
	    				id="btnCancelarAddArea">
	    				Cancelar
	    			</button>
	    		</div>
	    	</div>
	    </div>
	</div>

</div>