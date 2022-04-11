<?php 
	namespace App\DAO;

	use App\DAO\DAO;
	use App\Model\Estado;

	class EstadoDAO extends DAO {

		static public function create($cidade, $sigla){
			
		}

		static public function find(Estado $estado = null){
			$where = "cd_estado > 0";
			if(!empty($estado)){
				
				if(!empty($estado->getId())){
					$where = " cd_estado = {$estado->getId()} ";
				}

				if(!empty($estado->getNome())){
					$where .= " AND nm_estado = '".$estado->getNome()."'";
				}

				if(!empty($estado->getSigla())){
					$where .= " AND sg_estado = '".$estado->getSigla()."'";
				}

				if(!empty($estado->getStatus())){
					$where .= " AND ic_estado = '".$estado->getStatus()."'";
				}
			}

			return parent::Select('estado','*',false,$where,'nm_estado');
		}
	}