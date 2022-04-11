<?php 
	namespace App\DAO;

	use App\DAO\DAO;
	use App\Model\Edificio;

	class EdificioDAO extends DAO {

		static function create(Edificio $e ){

			$cols = "cd_tipo_edificio, ds_titulo, cd_situacao ";

			$vals = "NULL";
			$vals .= ",'".$e->getNome()."' ";
			$vals .= ",'".$e->getStatus()."' ";

			return parent::Insert('tipo_edificio', $cols, $vals);
		}

		static public function find(Edificio $e, $order = false){
			
			$where = " cd_tipo_edificio > 0 ";

			if(!empty($e->getId())){ $where = " cd_tipo_edificio = '{$e->getId()}'"; }
			if(!empty($e->getNome())){ $where .= " AND ds_titulo = '{$e->getNome()}'"; }
			if(!empty($e->getStatus())){ $where .= " AND cd_situacao = '{$e->getStatus()}'"; }

			return parent::Select('tipo_edificio','*',false,$where,$order);
		}

		static public function edit(Edificio $e){

			if(!empty($e->getId())){

				$set = "cd_tipo_edificio = '".$e->getId()."' ";

				if(!empty($e->getNome())){
					$set .= ", ds_titulo = '".$e->getNome()."' ";
				}

				if(is_numeric($e->getStatus())){
					$set .= ", cd_situacao = '".$e->getStatus()."' ";
				}

				$where = "cd_tipo_edificio = '".$e->getId()."' ";

				// echo $set;

				return parent::Update('tipo_edificio',$set,$where);
			}
		}

		static public function remove(Edificio $e){
			
			if(!empty($e->getId())){
				$where = "cd_tipo_edificio = '".$e->getId()."' ";
				return parent::delete('tipo_edificio',$where);	
			}
		}
	}

