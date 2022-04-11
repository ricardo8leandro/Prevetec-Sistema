<?php 

	namespace App\DAO;



	use App\DAO\DAO;



	use App\Model\PropostaAreaServico;

	use App\Model\PropostaArea;

	use App\Model\Servico;



	class PropostaAreaServicoDAO extends DAO {



		static public function create(PropostaAreaServico $pas){



			$cols  = "cdpropostaareaservico, cdservico, cdpropostaarea, nrqtde,";

			$cols .= "dsdimensao, dsobservacao, cdindice";



			$vals  = "NULL";

			$vals .= ",'".$pas->getServico()->getId()."'";

			$vals .= ",'".$pas->getPropostaArea()->getId()."'";

			$vals .= ",'".$pas->getQtd()."'";

			$vals .= ",'".$pas->getDimensao()."'";

			$vals .= ",'".$pas->getObs()."'";

			$vals .= ",'".$pas->getIndice()."'";



			return parent::insert('tpropostaareaservico', $cols, $vals);

		}



		static public function find(PropostaAreaServico $pas, $orderBy = false){

			$where = "cdpropostaareaservico > 0";



			if(!empty($pas->getId()))

				$where .= " AND cdpropostaareaservico = '".$pas->getId()."' ";



			if(!empty($pas->getServico()))

				$where .= " AND cdservico = '".$pas->getServico()->getId()."' ";



			if(!empty($pas->getPropostaArea()))

				$where .= " AND cdpropostaarea = '".$pas->getPropostaArea()->getId()."' ";



			$select = "tpropostaareaservico.*, servico.ds_titulo, servico.ds_descricao";

			$join = "JOIN servico ON servico.cd_servico = tpropostaareaservico.cdservico";



			return parent::Select('tpropostaareaservico',$select,$join,$where, $orderBy);

		}



		static public function find_or($where, $orderBy = false){



			$select = "tpropostaareaservico.*, servico.ds_titulo";

			$join = "JOIN servico ON servico.cd_servico = tpropostaareaservico.cdservico";



			return parent::Select('tpropostaareaservico',$select,$join,$where, $orderBy);

		}



		static public function edit(PropostaAreaServico $pas){



			$set = " cdpropostaareaservico = ".$pas->getId();



			if(!empty($pas->getQtd())){

				$set .= ", nrqtde = '".$pas->getQtd()."' ";

			}



			if(!empty($pas->getDimensao())){

				$set .= ", dsdimensao = '".$pas->getDimensao()."' ";

			}



			if(!empty($pas->getObs())){

				$set .= ", dsobservacao = '".$pas->getObs()."' ";

			}



			if(is_numeric($pas->getIndice())){

				$set .= ", cdindice = '".$pas->getIndice()."' ";

			}



			/*condições para update */

			$where = " cdpropostaareaservico = ".$pas->getId();



			if(!empty($pas->getServico())){

				$where .= " AND cdservico = '".$pas->getServico()->getId()."' ";

			}



			if(!empty($pas->getPropostaArea())){

				$proparea_id = $pas->getPropostaArea()->getId();

				$where .= " AND cdpropostaarea = '".$proparea_id."' ";				

			}



			return parent::Update('tpropostaareaservico',$set,$where);

		}



		static public function remove(PropostaAreaServico $pas){

			$where = "cdpropostaareaservico = '0' ";

			

			if(!empty($pas->getId())){

				$where = "cdpropostaareaservico = '".$pas->getId()."' ";

			}else if(!empty($pas->getPropostaArea())){

				$where = "cdpropostaarea = '".$pas->getPropostaArea()->getId()."' ";

			}



			if(!empty($pas->getServico())){

				$where .= " AND cdservico = '".$pas->getServico()->getId()."' ";	

			}



			return parent::Delete('tpropostaareaservico', $where);

		}



		static public function remove_by_area($where){

			return parent::Delete('tpropostaareaservico', $where);

		}

	}