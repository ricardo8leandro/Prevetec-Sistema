<?php 
	namespace App\DAO;

	use App\DAO\DAO;
	use App\Model\Proposta;
	use App\model\PropostaPDF;
	
	/**
	 * @method insert($tabela, $cols, vals)
	 * @method Select($tabela, $cols, $join, $where, $order, $limit)
	 * @method Update($tabela, $set, $where)
	 * @method Delete($tabela, $where)
	 */
	class PropostaPDFDAO extends DAO {

		static public function create(PropostaPDF $p){
			$cols  = "cd_proposta_pdf, cd_proposta, ds_path_pdf,";
			$cols .= "dt_register,cd_situacao";

			$vals = "NULL";
			$vals .=",'".$p->getProposta()->getId()."'";
			$vals .=",'".$p->getPath()."'";
			$vals .=",'".$p->getDtRegistro()."'";
			$vals .=",'".$p->getStatus()."'";

			return parent::Insert('proposta_pdf',$cols,$vals);
		}

		static public function find(PropostaPDF $p){
			$where = "cd_proposta_pdf > 0";

			if(!empty($p->getId()))
				$where .= " AND cd_proposta_pdf = ".$p->getId();

			if(!empty($p->getProposta()))
				$where .= " AND cd_proposta = ".$p->getProposta()->getId();

			if( !empty($p->getStatus()) )
				$where .= " AND cd_situacao ='".$p->getStatus()."' ";
			

			return parent::Select('proposta_pdf','*',false,$where);
		}

		static public function edit(PropostaPDF $p){
			$set = "cd_proposta_pdf = ".$p->getId()." ";

			if( !empty( $p->getProposta()->getId() ) )
				$set .= ", cd_proposta = ". $p->getProposta()->getId();
			
			if( !empty($p->getPath()) )
				$set .= ", ds_path_pdf = '".$p->getPath()."' ";

			if( !empty($p->getDtRegistro()) )
				$set .= ", dt_register = '".$p->getDtRegistro()."' ";

			if( !empty($p->getStatus()) ){
				$set .= ", cd_situacao '".$p->getStatus()."' ";
			}
			$set = "cd_proposta_pdf = ".$p->getId()." ";

			parent::Update('proposta_pdf', $set, $where);
		}

		static public function remove(PropostaPDF $p){
			$where = 'cd_proposta_pdf = "0" ';
			
			if( is_numeric( $p->getId() ) ){
				$where = "cd_proposta_pdf = ".$p->getId();
			}else if(!empty($p->getProposta())){
				$where = "cd_proposta = ".$p->getProposta()->getId();
			}

			return parent::Delete('proposta_pdf', $where);
		}
	}