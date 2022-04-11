<li data-id="{{id}}" id="area_{{id}}" class="panel panel-info">
  	<div class="panel-heading">
	  	Área - <span class="area-name">{{AREA.NOME}}</span>
	  	<span class="fa fa-trash moveIcon removeArea"></span>
	  	<span class="fa fa-pencil moveIcon editArea" value="area_{{id}}"></span>
	  	<span class="fa fa-arrow-down moveIcon moveAreaDown"></span>
	  	<span class="fa fa-arrow-up moveIcon moveAreaUp"></span>
	  	<a class="btn-servico" href='javascript:modalListaServicos({{id}})'>
	  		<span class="fa fa-plus"></span>
	  		Adicionar Serviço
	  	</a>
	</div>
  	<div class="panel-body">
		<ul class="group_items sort-list list-servico">
	      <!-- A ESTRUTURA DO SERVICO VEM AQUI -->
	    </ul>
  	</div>
</li>