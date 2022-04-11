<?php 
	namespace Src\Traits;

	use App\DAO\SolutionDAO;

	trait TraitGetGruposECargos {

		public function get_grupos_e_cargos_e_regioes(){

			$res = SolutionDAO::find_grupos_cargos_regioes();

			$arrGrupo 	= [];
			$arrCargo 	= [];
			$arrRegiao 	= [];

			foreach($res as $key => $value){
				
				if(!empty($value['cd_grupo'])){
					$arrGrupo[] = $value;
					continue;
				}

				if(!empty($value['cd_cargo'])){
					$arrCargo[] = $value;
					continue;
				}

				if(!empty($value['cd_regiao'])){
					$arrRegiao[] = $value;
					continue;
				}
			}

			$arr = [
				'grupos' 	=> $arrGrupo,
				'cargos' 	=> $arrCargo,
				'regioes'	=> $arrRegiao
			];

			return $arr;
		}
	}