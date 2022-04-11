<?php 
	namespace App\DAO;

	use App\DAO\DAO;
	use App\Model\Documento;

	class DocumentoDAO extends DAO {

		static public function create(Documento $doc){

			$cols = "cd_documento, ds_titulo, ds_descricao,cd_situacao";

			$vals = "NULL";
			$vals .= ",'".$doc->getTitulo()."' ";
			$vals .= ",'".$doc->getConteudo()."' ";
			$vals .= ",'".$doc->getStatus()."' ";

			return parent::Insert('documento', $cols, $vals);
		}

		static public function find(Documento $doc, $order = false){
			
			$where = " cd_documento > 0 ";

			if(!empty($doc->getId())){ $where = " cd_documento = '{$doc->getId()}'"; }
			if(!empty($doc->getTitulo())){ $where .= " AND ds_titulo = '{$doc->getTitulo()}'"; }
			if(!empty($doc->getStatus())){ $where .= " AND cd_situacao = '{$doc->getStatus()}'"; }

			return parent::Select('documento','*',false,$where, $order);
		}

		static public function edit(Documento $doc){

			if(!empty($doc->getId())){

				$set = "cd_documento = '".$doc->getId()."' ";

				if(!empty($doc->getTitulo())){
					$set .= ", ds_titulo = '".$doc->getTitulo()."' ";
				}

				if(is_numeric($doc->getStatus())){
					$set .= ", cd_situacao = '".$doc->getStatus()."' ";
				}

				if(!empty($doc->getConteudo())){
					$set .= ", ds_descricao = '".$doc->getConteudo()."' ";
				}

				$where = "cd_documento = '".$doc->getId()."' ";

				return parent::Update('documento',$set,$where);
			}
		}

		static public function remove(Documento $doc){
			
			if(!empty($doc->getId())){
				$where = "cd_documento = '".$doc->getId()."' ";
				return parent::delete('documento',$where);	
			}
		}
	}