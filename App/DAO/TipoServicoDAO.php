<?php 
	namespace App\DAO;

	use App\DAO\DAO;
	use App\Model\TipoServico;
	use App\Model\ConfigPDF;

	class TipoServicoDAO extends DAO {

		static public function create(TipoServico $ts){

			$cols = "cd_tipo_servico, cd_pdf_config, ds_titulo, ds_descricao, cd_situacao";

			$vals = "NULL";
			$vals .= ",'".$ts->getConfigPDF()->getId()."' ";
			$vals .= ",'".$ts->getTitulo()."' ";
			$vals .= ",'".$ts->getConteudo()."' ";
			$vals .= ",'".$ts->getStatus()."' ";

			return parent::Insert('tipo_servico', $cols, $vals);
		}

		static public function find(TipoServico $ts,$order = false){
			
			$where = " cd_tipo_servico > 0 ";

			$pdf = $ts->getConfigPDF();

			if(!empty($ts->getId())){ $where = " cd_tipo_servico = '{$ts->getId()}'"; }
			if(!empty($pdf)){ $where .= " AND cd_pdf_config = '{$pdf->getId()}'"; }
			if(!empty($ts->getTitulo())){ $where .= " AND ds_titulo = '{$ts->getTitulo()}'"; }
			if(!empty($ts->getStatus())){ $where .= " AND cd_situacao = '{$ts->getStatus()}'"; }

			return parent::Select('tipo_servico','*',false,$where,$order);
		}

		static public function edit(TipoServico $ts){

			if(!empty($ts->getId())){

				$set = "cd_tipo_servico = '".$ts->getId()."' ";

				if(!empty($ts->getTitulo())){
					$set .= ", ds_titulo = '".$ts->getTitulo()."' ";
				}

				if(!empty($ts->getConfigPDF())){
					$set .= ", cd_pdf_config = '".$ts->getConfigPDF()->getId()."' "; 
				}

				if(is_numeric($ts->getStatus())){
					$set .= ", cd_situacao = '".$ts->getStatus()."' ";
				}

				if(!empty($ts->getConteudo())){
					$set .= ", ds_descricao = '".$ts->getConteudo()."' ";
				}

				$where = "cd_tipo_servico = '".$ts->getId()."' ";

				return parent::Update('tipo_servico',$set,$where);
			}
		}

		static public function remove(TipoServico $ts){
			
			if(!empty($ts->getId())){
				$where = "cd_tipo_servico = '".$ts->getId()."' ";
				return parent::delete('tipo_servico',$where);	
			}
		}
	}