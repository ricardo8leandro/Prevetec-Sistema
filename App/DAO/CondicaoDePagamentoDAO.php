<?php 
	namespace App\DAO;

	use App\DAO\DAO;
	use App\Model\CondicaoDePagamento;

	class CondicaoDePagamentoDAO extends DAO {

		static public function create(CondicaoDePagamento $cp){

			$cols = "cd_condicao_pagto, ds_titulo, ds_descricao,cd_situacao";

			$vals = "NULL";
			$vals .= ",'".$cp->getTitulo()."' ";
			$vals .= ",'".$cp->getConteudo()."' ";
			$vals .= ",'".$cp->getStatus()."' ";

			return parent::Insert('condicao_pagto', $cols, $vals);
		}

		static public function find(CondicaoDePagamento $cp, $order = false){
			
			$where = " cd_condicao_pagto > 0 ";

			if(!empty($cp->getId())){ $where = " cd_condicao_pagto = '{$cp->getId()}'"; }
			if(!empty($cp->getTitulo())){ $where .= " AND ds_titulo = '{$cp->getTitulo()}'"; }
			if(!empty($cp->getStatus())){ $where .= " AND cd_situacao = '{$cp->getStatus()}'"; }

			return parent::Select('condicao_pagto','*',false,$where, $order);
		}

		static public function edit(CondicaoDePagamento $cp){

			if(!empty($cp->getId())){

				$set = "cd_condicao_pagto = '".$cp->getId()."' ";

				if(!empty($cp->getTitulo())){
					$set .= ", ds_titulo = '".$cp->getTitulo()."' ";
				}

				if(is_numeric($cp->getStatus())){
					$set .= ", cd_situacao = '".$cp->getStatus()."' ";
				}

				if(!empty($cp->getConteudo())){
					$set .= ", ds_descricao = '".$cp->getConteudo()."' ";
				}

				$where = "cd_condicao_pagto = '".$cp->getId()."' ";

				return parent::Update('condicao_pagto',$set,$where);
			}
		}

		static public function remove(CondicaoDePagamento $cp){
			
			if(!empty($cp->getId())){
				$where = "cd_condicao_pagto = '".$cp->getId()."' ";
				return parent::delete('condicao_pagto',$where);	
			}
		}
	}