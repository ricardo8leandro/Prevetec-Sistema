<?php 
	namespace App\DAO;

	use App\DAO\DAO;
	use App\Model\Area;

	class AreaDAO extends DAO {

		static public function create(Area $area){

			$cols = "cd_area, ds_titulo, ds_cabecalho, ds_rodape, cd_situacao, ds_subtitulo";

			$vals = "NULL";
			$vals .= ",'".$area->getTitulo()."' ";
			$vals .= ",'".$area->getSubTitulo()."' ";
			$vals .= ",'".$area->getConteudo()."' ";
			$vals .= ",'' ";
			$vals .= ",'".$area->getStatus()."' ";

			return parent::Insert('area', $cols, $vals);
		}

		static public function find(Area $area, $order = false){
			
			$where = " cd_area > 0 ";

			if(!empty($area->getId())){ $where = " cd_area = '{$area->getId()}'"; }
			if(!empty($area->getTitulo())){ $where .= " AND ds_titulo = '{$area->getTitulo()}'"; }
			if(!empty($area->getStatus())){ $where .= " AND cd_situacao = '{$area->getStatus()}'"; }

			return parent::Select('area','*',false,$where,$order);
		}

		static public function edit(Area $area){

			if(!empty($area->getId())){

				$set = "cd_area = '".$area->getId()."' ";

				if(!empty($area->getTitulo())){
					$set .= ", ds_titulo = '".$area->getTitulo()."' ";
				}

				if(is_numeric($area->getStatus())){
					$set .= ", cd_situacao = '".$area->getStatus()."' ";
				}

				if(!empty($area->getConteudo())){
					$set .= ", ds_cabecalho = '".$area->getConteudo()."' ";
				}

				$where = "cd_area = '".$area->getId()."' ";

				return parent::Update('area',$set,$where);
			}
		}

		static public function remove(Area $area){
			
			if(!empty($area->getId())){
				$where = "cd_area = '".$area->getId()."' ";
				return parent::delete('area',$where);	
			}
		}
	}