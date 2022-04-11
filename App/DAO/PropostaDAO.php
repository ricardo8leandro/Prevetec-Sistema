<?php 
	namespace App\DAO;

	use App\DAO\DAO;

	use App\Model\Proposta;
	use App\Model\Usuario;
	use App\Model\TipoServico;
	use App\Model\TipoEdificio;
	use App\Model\ConfigPDF;
	use App\Model\Documento;
	use App\Model\Area;
	use App\Model\Anexo;
	use App\Model\CondicaoDePagamento;
	use App\Model\Cidade;
	use App\Model\PropostaPDF;

	class PropostaDAO extends DAO {

		static public function create(Proposta $p){
			$cols  = "cd_proposta, cd_anexo, cd_regiao, cd_documento, cd_profissional,";
			$cols .= "cd_cliente, cd_tipo_edificio,cd_config_pdf, ic_proposta";
			// $cols .= ",ds_consideracao";
			$cols .= ", ds_forma_pagto,ds_prazo_inicio, ds_prazo_execucao,";
			$cols .= "ds_impostos, dt_registro, vl_proposta, dt_abertura, dt_fechamento,";
			$cols .= "dt_cancelamento, ds_condicao_pagto, ds_path_proposta_pdf";

			$vals  = "NULL";
			$vals .= ",'".$p->getTipoServico()->getId()."' ";
			$vals .= ",'".$p->getRegiao()."' ";
			$vals .= ",'".$p->getDocumento()->getId()."' ";
			$vals .= ",'".$p->getEngenheiro()->getId()."' ";
			$vals .= ",'".$p->getCliente()->getId()."' ";
			$vals .= ",'".$p->getTipoEdificio()->getId()."' ";
			$vals .= ",'".$p->getConfigPDF()->getId()."' ";
			$vals .= ",'".$p->getStatus()."' ";
			// $vals .= ",'".$p->getEngenheiro()->getId()."' ";
			// $vals .= ",'".$p->getConsideracao()."' ";
			$vals .= ",'".$p->getCondicaoPag()."' ";
			$vals .= ",'".$p->getPrazoInicial()."' ";
			$vals .= ",'".$p->getPrazoExecucao()."' ";
			$vals .= ",'' ";//impotos
			$vals .= ",'".$p->getDtRegistro()."' ";
			$vals .= ",'".$p->getValor()."' ";
			$vals .= ",'".$p->getDtAbertura()."' ";
			$vals .= ",'".$p->getDtFechamento()."' ";
			$vals .= ",'".$p->getDtCancelamento()."' ";
			$vals .= ",'".$p->getFormaPag()."' ";
			$vals .= ",'".$p->getPathPDF()."' ";

			return parent::insert('proposta', $cols, $vals);
		}

		static public function find(Proposta $p, $orderBy = null){

			$where = "cd_proposta > 0 ";
			
			if(!empty($p->getId())){
				$where .= " AND cd_proposta = '".$p->getId()."'";
			}

			if(!empty($p->getStatus())){
				$where .= " AND ic_proposta = '".$p->getStatus()."'";
			}

			if(!empty($p->getRegiao())){
				$where .= " AND proposta.cd_regiao = '".$p->getRegiao()."'";
			}

			if(!empty($p->getCliente())){
				$where .= " AND cd_cliente = '".$p->getCliente()->getId()."'";
			}

			$select  = "proposta.*, cli.nm_usuario as nm_cliente, ts.ds_titulo as ts_titulo";
			$select .= ", regiao.nm_regiao";

			$join    = " JOIN usuario as cli ON cli.cd_usuario = proposta.cd_cliente";
			$join   .= " JOIN tipo_servico as ts ON ts.cd_tipo_servico = proposta.cd_anexo";
			$join   .= " LEFT JOIN regiao ON regiao.cd_regiao = proposta.cd_regiao";

			return parent::Select('proposta',$select,$join,$where, $orderBy);
		}

		static public function edit(Proposta $p){

			$set  =  "cd_proposta = '".$p->getId()."'";
			
			if(!empty($p->getTipoServico()))
				$set .= ",cd_anexo = '".$p->getTipoServico()->getId()."' ";

			if(!empty($p->getRegiao()))
				$set .= ",cd_regiao = '".$p->getRegiao()."' ";

			if(!empty($p->getDocumento()))
				$set .= ",cd_documento = '".$p->getDocumento()->getId()."' ";

			if(!empty($p->getEngenheiro()))
				$set .= ",cd_profissional = '".$p->getEngenheiro()->getId()."' ";

			if(!empty($p->getCliente()))
				$set .= ",cd_cliente = '".$p->getCliente()->getId()."' ";

			if(!empty($p->getTipoEdificio()))
				$set .= ",cd_tipo_edificio = '".$p->getTipoEdificio()->getId()."' ";

			if(!empty($p->getConfigPDF()))
				$set .= ",cd_config_pdf = '".$p->getConfigPDF()->getId()."' ";

			if(!empty($p->getStatus()))
				$set .= ",ic_proposta = '".$p->getStatus()."' ";

			if(!empty($p->getEngenheiro()))
				$set .= ",cd_representante = '".$p->getEngenheiro()->getId()."' ";

			if(!empty($p->getConsideracao()))
				$set .= ",ds_consideracao = '".$p->getConsideracao()."' ";

			if(!empty($p->getCondicaoPag()))
				$set .= ",ds_forma_pagto = '".$p->getCondicaoPag()."' ";

			if(!empty($p->getPrazoInicial()))
				$set .= ",ds_prazo_inicio = '".$p->getPrazoInicial()."' ";

			if(!empty($p->getPrazoExecucao()))
				$set .= ",ds_prazo_execucao = '".$p->getPrazoExecucao()."' ";

			if(!empty($p->getDtRegistro()))
				$set .= ",dt_registro = '".$p->getDtRegistro()."' ";

			if(!empty($p->getValor()))
				$set .= ",vl_proposta = '".$p->getValor()."' ";

			if(!empty($p->getDtAbertura()))
				$set .= ",dt_abertura = '".$p->getDtAbertura()."' ";

			if(!empty($p->getDtFechamento()))
				$set .= ",dt_fechamento = '".$p->getDtFechamento()."' ";

			if(!empty($p->getDtCancelamento()))
				$set .= ",dt_cancelamento = '".$p->getDtCancelamento()."' ";

			if(!empty($p->getFormaPag()))
				$set .= ",ds_condicao_pagto = '".$p->getFormaPag()."' ";

			if(!empty($p->getPathPDF()))
				$set .= ",ds_path_proposta_pdf = '".$p->getPathPDF()."' ";

			$where  =  "cd_proposta = '".$p->getId()."'";

			return parent::Update('proposta',$set,$where);
		}

		static public function remove(Proposta $p){
			$where = "cd_proposta = '0' ";
			if(!empty($p->getId())) $where = "cd_proposta = '".$p->getId()."' ";
			return parent::Delete('proposta', $where);
		}

		static public function aprovacao(Proposta $p){
			if(is_numeric($p->getId())){
				$set   = 'ic_proposta_aceita = '. $p->getAprovada();
				$where = 'cd_proposta = '.$p->getId();
				return parent::Update('proposta',$set,$where);	
			}
		}
	}