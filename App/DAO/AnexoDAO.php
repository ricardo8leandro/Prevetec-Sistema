<?php 
	namespace App\DAO;

	use App\DAO\DAO;
	use App\Model\Anexo;

	class AnexoDAO extends DAO {

		static public function create(Anexo $anx){

			$cols = "cd_anexo, ds_titulo, ds_descricao,cd_situacao";

			$vals = "NULL";
			$vals .= ",'".$anx->getTitulo()."' ";
			$vals .= ",'".$anx->getConteudo()."' ";
			$vals .= ",'".$anx->getStatus()."' ";

			return parent::Insert('anexo', $cols, $vals);
		}

		static public function find(Anexo $anx, $order = false){
			
			$where = " cd_anexo > 0 ";

			if(!empty($anx->getId())){ $where = " cd_anexo = '{$anx->getId()}'"; }
			if(!empty($anx->getTitulo())){ $where .= " AND ds_titulo = '{$anx->getTitulo()}'"; }
			if(!empty($anx->getStatus())){ $where .= " AND cd_situacao = '{$anx->getStatus()}'"; }

			return parent::Select('anexo','*',false,$where, $order);
		}

		static public function edit(Anexo $anx){

			if(!empty($anx->getId())){

				$set = "cd_anexo = '".$anx->getId()."' ";

				if(!empty($anx->getTitulo())){
					$set .= ", ds_titulo = '".$anx->getTitulo()."' ";
				}

				if(is_numeric($anx->getStatus())){
					$set .= ", cd_situacao = '".$anx->getStatus()."' ";
				}

				if(!empty($anx->getConteudo())){
					$set .= ", ds_descricao = '".$anx->getConteudo()."' ";
				}

				$where = "cd_anexo = '".$anx->getId()."' ";

				return parent::Update('anexo',$set,$where);
			}
		}

		static public function remove(Anexo $anx){
			
			if(!empty($anx->getId())){
				$where = "cd_anexo = '".$anx->getId()."' ";
				return parent::delete('anexo',$where);	
			}
		}
	}