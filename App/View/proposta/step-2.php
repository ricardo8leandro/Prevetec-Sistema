<div class="form-group">
    <div class="col-lg-10 col-lg-offset-1">
    	<p class="p-h2">
			Para ordenar a sequencia das áreas e serviços,arraste-os para as posições desejadas
			ou clique nas setas Mandar item para <span class="fa fa-arrow-up"></span>(acima)
			e Mandar item para <span class="fa fa-arrow-down"></span>(abaixo). 
		</p>
    </div>
</div>

<div class="form-group">
    <div class="col-lg-4 col-lg-offset-4">
    	<button type="button" class="btn btn-info btn-block" id="btnAdicionarArea">
    		Adicionar Área
    	</button>
    </div>
</div>
<?php include 'form-adicionar-area.php'; ?>

<hr class="dotted">
<div class="form-group">
    <div class="col-lg-10 col-lg-offset-1">
    	<!--
    		O PRIMEIRO UL LISTA AS AREAS
    		OS UL DE SEGUNDO NIVEL LISTAM OS SERVIÇOS DAS AREAS 
    	 -->
    	<ul class="sortable subcategory_item sort-list list-area ">
    		<!-- A ESTRUTURA DA AREA VEM AQUI -->
		</ul>
    </div>
</div>