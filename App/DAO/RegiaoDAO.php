<?php 
	namespace App\DAO;

	use App\DAO\DAO;
	use App\Model\Regiao;

	class RegiaoDAO extends DAO {

		static public function create(Regiao $regiao){

			$cols = "cd_regiao, nm_regiao, ic_regiao";

			$values  = "null";
			$values .= ",'".$regiao->getNome()."'";
			$values .= ",'".$regiao->getStatus()."'";

			return parent::Insert('regiao',$cols,$values);
		}

		static public function find(Regiao $regiao, $order = false){
			$join = false;
			$where = "cd_regiao > 0 ";
			
			if(!empty($regiao->getId())){
				$where .= " AND cd_regiao = '".$regiao->getId()."' ";
			}

			if(!empty($regiao->getNome())){
				$where .= " AND nm_regiao = '".$regiao->getNome()."' ";
			}

			if(!empty($regiao->getStatus())){
				$where .= " AND ic_regiao = '".$regiao->getStatus()."' ";
			}

			return parent::Select('regiao','*',$join,$where,$order);
		}

		static public function edit(Regiao $regiao){

			if(!empty($regiao->getId())){

				$set = "cd_regiao = '".$regiao->getId()."' ";

				if(!empty($regiao->getNome())){
					$set .= ", nm_regiao = '".$regiao->getNome()."' ";
				}

				if(is_numeric($regiao->getStatus())){
					$set .= ", ic_regiao = '".$regiao->getStatus()."' ";
				}

				$where = "cd_regiao = '".$regiao->getId()."' ";

				// echo $set;

				return parent::Update('regiao',$set,$where);
			}
		}

		static public function remove(Regiao $regiao){
			
			if(!empty($regiao->getId())){
				$where = "cd_regiao = '".$regiao->getId()."' ";
				return parent::delete('regiao',$where);	
			}
		}
	}