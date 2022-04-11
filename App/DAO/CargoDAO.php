<?php 
	namespace App\DAO;

	use App\DAO\DAO;
	use App\Model\Cargo;

	class CargoDAO extends DAO {

		static public function create(Cargo $cargo){

			$cols = "cd_cargo, nm_cargo, ic_cargo";

			$values  = "null";
			$values .= ",'".$cargo->getNome()."'";
			$values .= ",'".$cargo->getStatus()."'";

			return parent::Insert('cargo',$cols,$values);
		}

		static public function find(Cargo $cargo, $order = false){
			$join = false;
			$where = "cd_cargo > 0 ";
			
			if(!empty($cargo->getId())){
				$where .= " AND cd_cargo = '".$cargo->getId()."' ";
			}

			if(!empty($cargo->getNome())){
				$where .= " AND nm_cargo = '".$cargo->getNome()."' ";
			}

			if(!empty($cargo->getStatus())){
				$where .= " AND ic_cargo = '".$cargo->getStatus()."' ";
			}

			return parent::Select('cargo','*',$join,$where,$order);
		}

		static public function edit(Cargo $cargo){

			if(!empty($cargo->getId())){

				$set = "cd_cargo = '".$cargo->getId()."' ";

				if(!empty($cargo->getNome())){
					$set .= ", nm_cargo = '".$cargo->getNome()."' ";
				}

				if(is_numeric($cargo->getStatus())){
					$set .= ", ic_cargo = '".$cargo->getStatus()."' ";
				}

				$where = "cd_cargo = '".$cargo->getId()."' ";

				// echo $set;

				return parent::Update('cargo',$set,$where);
			}
		}

		static public function remove(Cargo $cargo){
			
			if(!empty($cargo->getId())){
				$where = "cd_cargo = '".$cargo->getId()."' ";
				return parent::delete('cargo',$where);	
			}
		}
	}