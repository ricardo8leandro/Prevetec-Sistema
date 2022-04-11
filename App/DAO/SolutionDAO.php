<?php 
	namespace App\DAO;

	use App\DAO\DAO;

	class SolutionDAO extends DAO {

		static public function find_grupos_cargos_regioes($ativo = false){
			
			$join = " JOIN cargo JOIN regiao";
			$where = " status_grupo = '1' OR ic_cargo = 1 OR ic_regiao = 1";
			
			return parent::Select('grupo','*',$join,$where);
		}
	}