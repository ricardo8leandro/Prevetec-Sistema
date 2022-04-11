<?php 
	namespace App\Controller;

	use App\Controller\Controller;
	use App\Model\Cidade;
	use App\DAO\CidadeDAO;

	class ControllerCidade extends Controller {

		public function find($post = null){
			
			if(is_array($post)){
				$cidade = new Cidade($post);
			}else if( is_numeric($post) ){
				$cidade = new Cidade();
				$cidade->setEstado($post);
			}
			
			if(isset($cidade)){
				echo json_encode( CidadeDAO::find($cidade) );	
			}
		}


		public function findOptions($post = null){
			
			if(is_array($post)){
				$cidade = new Cidade($post);
			}else if( is_numeric($post) ){
				$cidade = new Cidade();
				$cidade->setEstado($post);
			}
			
			if(isset($cidade)){
				$cidades = CidadeDAO::find($cidade);

				$options = "";
				
				foreach($cidades as $cidade){
					$options .= "<option value='".$cidade['cd_cidade']."'>";
					$options .= $cidade['nm_cidade'];
					$options .= "</option>";
				}

				echo $options;
			}
		}
	}