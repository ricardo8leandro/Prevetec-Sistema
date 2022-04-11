<?php 
	namespace App\DAO;

	use App\DAO\DAO;
	use App\Model\Chat;

	class ChatDAO extends DAO {

		static public function create(Area $area){

			$cols = "cd_area, ds_titulo, ds_cabecalho, ds_rodape, cd_situacao";

			$vals = "NULL";
			$vals .= ",'".$area->getTitulo()."' ";
			$vals .= ",'".$area->getConteudo()."' ";
			$vals .= ",'' ";
			$vals .= ",'".$area->getStatus()."' ";

			return parent::Insert('area', $cols, $vals);
		}

		static public function find(Chat $chat){
			
			$where = " cd_chat > 0 ";

			if(!empty($chat->getId())){
				$where = " cd_chat = '{$chat->getId()}'";
			}
			
			if(!empty($chat->getCliente())){
				$where .= " AND cd_cliente = '{$chat->getCliente()}'";
			}
			
			if(!empty($chat->getAtendimento())){
				$where .= " AND cd_situacao = '{$chat->getAtendimento()}'";
			}

			return parent::Select('chat','*',false,$where);
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