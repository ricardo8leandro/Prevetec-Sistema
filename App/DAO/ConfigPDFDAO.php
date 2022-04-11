<?php 
	namespace App\DAO;

	use App\DAO\DAO;
	use App\Model\ConfigPDF;

	class ConfigPDFDAO extends DAO {

		static public function create(ConfigPDF $cfgPDF){

			$cols  = "cd_pdf_config, ds_titulo, ds_cabecalho";
			$cols .= ", ds_conteudo, ds_rodape,cd_situacao";


			$vals = "NULL";
			$vals .= ",'".$cfgPDF->getTitulo()."' ";
			$vals .= ",'".$cfgPDF->getCabecalho()."' ";
			$vals .= ",'".$cfgPDF->getConteudo()."' ";
			$vals .= ",'".$cfgPDF->getRodape()."' ";
			$vals .= ",'".$cfgPDF->getStatus()."' ";

			return parent::Insert('pdf_config', $cols, $vals);
		}

		static public function find(ConfigPDF $cfgPDF, $order = false){
			
			$where = " cd_pdf_config > 0 ";

			if(!empty($cfgPDF->getId())){ $where = " cd_pdf_config = '{$cfgPDF->getId()}'"; }
			if(!empty($cfgPDF->getTitulo())){ $where .= " AND ds_titulo = '{$cfgPDF->getTitulo()}'"; }
			if(!empty($cfgPDF->getStatus())){ $where .= " AND cd_situacao = '{$cfgPDF->getStatus()}'"; }

			return parent::Select('pdf_config','*',false,$where,$order);
		}

		static public function edit(ConfigPDF $cfgPDF){

			if(!empty($cfgPDF->getId())){

				$set = "cd_pdf_config = '".$cfgPDF->getId()."' ";

				if(!empty($cfgPDF->getTitulo())){
					$set .= ", ds_titulo = '".$cfgPDF->getTitulo()."' ";
				}

				if(is_numeric($cfgPDF->getStatus())){
					$set .= ", cd_situacao = '".$cfgPDF->getStatus()."' ";
				}

				if(!empty($cfgPDF->getConteudo())){
					$set .= ", ds_conteudo = '".$cfgPDF->getConteudo()."' ";
				}

				if(!empty($cfgPDF->getCabecalho())){
					$set .= ", ds_cabecalho = '".$cfgPDF->getCabecalho()."' ";
				}

				if(!empty($cfgPDF->getRodape())){
					$set .= ", ds_rodape = '".$cfgPDF->getRodape()."' ";
				}

				$where = "cd_pdf_config = '".$cfgPDF->getId()."' ";

				return parent::Update('pdf_config',$set,$where);
			}
		}

		static public function remove(ConfigPDF $cfgPDF){
			
			if(!empty($cfgPDF->getId())){
				$where = "cd_pdf_config = '".$cfgPDF->getId()."' ";
				return parent::delete('pdf_config',$where);	
			}
		}
	}