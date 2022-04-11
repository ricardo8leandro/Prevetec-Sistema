<?php
	namespace App\DAO;

	use App\DAO\DAO;

	use App\Model\PropostaArea;
	use App\Model\Proposta;
	use App\Model\Area;
	use App\Model\Anexo;

	class PropostaAreaDAO extends DAO {

		static public function create(PropostaArea $pa){

			$cols  = "cd_proposta_area, cd_area, cd_proposta, cd_anexo,";
			$cols .= "cd_indice, cd_telhado_metalico, cd_estrutura_metalica, usa_cta";

			$vals  = "NULL";
			$vals .= ",'".$pa->getArea()->getId()."'";
			$vals .= ",'".$pa->getProposta()->getId()."'";
			$vals .= ",'".$pa->getAnexo()->getId()."'";
			$vals .= ",'".$pa->getIndice()."'";
			$vals .= ",'".$pa->getTelhado()."'";
			$vals .= ",'".$pa->getEstrutura()."'";
			$vals .= ",'".$pa->getUsaCTA()."' ";

			return parent::insert('proposta_area', $cols, $vals);
		}

		static public function find(PropostaArea $pa, $orderBy = false){
			$where = "cd_proposta_area > 0";

			if(!empty($pa->getId()))
				$where .= " AND proposta_area.cd_proposta_area = '".$pa->getId()."' ";

			if(!empty($pa->getArea()))
				$where .= " AND proposta_area.cd_area = '".$pa->getArea()->getId()."' ";

			if(!empty($pa->getProposta()))
				$where .= " AND proposta_area.cd_proposta = '".$pa->getProposta()->getId()."' ";

			$select = "proposta_area.*, area.ds_titulo";
			$join = " JOIN area on area.cd_area = proposta_area.cd_area ";

			return parent::Select('proposta_area',$select,$join,$where, $orderBy);
		}

		static public function find_or($where){
			
			$select = "proposta_area.*, area.ds_titulo";
			$join = " JOIN area on area.cd_area = proposta_area.cd_area ";

			return parent::Select('proposta_area',$select,$join,$where);
		}

		static public function edit(PropostaArea $pa){


			// print_r($pa);

			$set = "cd_proposta_area = ".$pa->getId();

			if(!empty($pa->getAnexo())){
				$set .= ",cd_anexo = '".$pa->getAnexo()->getId()."' ";
			}

			if(is_numeric($pa->getIndice())){
				$set .= ",cd_indice = '".$pa->getIndice()."'";	
			}

			if(!empty($pa->getTelhado())){
				$set .= ",cd_telhado_metalico= '".$pa->getTelhado()."'";	
			}

			if(!empty($pa->getEstrutura())){
				$set .= ",cd_estrutura_metalica = '".$pa->getEstrutura()."'";	
			}

			if(!empty($pa->getUsaCTA())){
				$set .= ",usa_cta = '".$pa->getUsaCTA()."'";	
			}

			$where  = "cd_proposta_area = '".$pa->getId()."' ";
			
			if(!empty($pa->getArea())){
				$where .= " AND cd_area = '".$pa->getArea()->getId()."' ";
			}

			if(!empty($pa->getProposta())){
				$where .= " AND cd_proposta = '".$pa->getProposta()->getId()."' ";
			}

			// echo $set." WHERE ".$where;
			// echo "<br>";

			return parent::Update('proposta_area',$set,$where);
		}

		static public function remove(PropostaArea $pa){
			$where = "cd_proposta_area = '0' ";
			
			if(!empty($pa->getId())){
				$where = "cd_proposta_area = '".$pa->getId()."' ";
			}else if(!empty($pa->getArea()) && !empty($pa->getProposta() )){
				$where  = "cd_area = '".$pa->getArea()->getId()."' ";
				$where .= " AND cd_proposta = '".$pa->getProposta()->getId()."' ";
			}

			return parent::Delete('proposta_area', $where);
		}

		static public function remove_by_proposta($cd_proposta){
			$where = " cd_proposta = '".$cd_proposta."' ";
			return parent::Delete('proposta_area', $where);
		}
	}