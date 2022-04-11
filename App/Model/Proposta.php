<?php 
	namespace App\Model;

	use App\Model\Model;

	use App\Model\Usuario;
	use App\Model\TipoServico;
	use App\Model\Edificio;
	use App\Model\ConfigPDF;
	use App\Model\Documento;
	use App\Model\Area;
	use App\Model\Anexo;
	use App\Model\CondicaoDePagamento;
	use App\Model\Cidade;
	use App\Model\PropostaPDF;

	class Proposta extends Model {

		/**
		 * @var Usuario $cliente:
		 * guarda um objeto Usuario
		 */
		private $cliente;

		/**
		 * @var TipoServico $tipoServico:
		 * guarda um objeto TipoServiço
		 */
		private $tipoServico;

		/**
		 * @var TipoEdificio $tipoEdificio:
		 * guarda um objeto TipoEdificio
		 */
		private $tipoEdificio;

		/**
		 * @var ConfigPDF $configPDF:
		 * guarda um objeto ConfigPDF
		 */
		private $configPDF;

		/**
		 * @var Documento $documento:
		 * guarda um objeto Documento
		 */
		private $documento;

		/**
		 * @var Usuario $engenheiro:
		 * guarda um objeto Usuario
		 */
		private $engenheiro;

		/**
		 * @var string $status:
		 * guarda a situação que a proposta se encontra (aberto, fechado...)
		 */
		private $status;

		/**
		 * @var int $prazoInicial:
		 * guarda o prazo inicial da proposta
		 */
		private $prazoInicial;

		/**
		 * @var int $prazoExecucao:
		 * guarda o prazo para execução da proposta 
		 */
		private $prazoExecucao;

		/**
		 * @var string $dtAbertura:
		 * guarda a data de abertura da proposta
		 */
		private $dtAbertura;

		/**
		 * @var string $dtCancelamento:
		 * guarda a data de cancelamento da proposta
		 */
		private $dtCancelamento;

		/**
		 * @var string $dtFechamento:
		 * guarda a data de fechamento da proposta
		 */
		private $dtFechamento;

		/**
		 * @var Area[] $area:
		 * guarda um array de objetos do tipo Area
		 */
		private $area;

		/**
		 * @var Anexo[] $anexo:
		 * guarda um array de objetos do tipo Anexo
		 */
		private $anexo;

		/**
		 * @var CondicaoDePagamento $condicaoPag:
		 * guarda a condição de pagamento da proposta
		 */
		private $condicaoPag;

		/**
		 * @var double $valor:
		 * guarda o valor da proposta
		 */
		private $valor;

		/**
		 * @var Cidade $cidade:
		 * guarda um objeto do tipo Cidade
		 */
		private $cidade;
		private $regiao;

		/**
		 * @var string $consideracao:
		 * guarda consideração da proposta
		 */
		private $consideracao;

		/**
		 * @var string $pathPDF:
		 * guarda o caminho ate os arquivos .pdf
		 */
		private $pathPDF;

		/**
		 * @var PropostaPDF $propostaPDF:
		 * guarda um objeto do tipo PropostaPDF
		 */
		private $propostaPDF;

		private $dtRegistro;
		private $formaPag;
		private $aprovada;

		/**
		 * @method __construct:
		 * ao instanciar a classe, caso houver parametros sendo enviados
		 * o construtor irá chamar os metodos SETTERS para definir o valor
		 * de cada atributo.
		 */
		public function __construct($data = null){

			if(is_array($data)){
				$this->setId( isset($data['id']) ? $data['id'] : 0 );

				if(isset($data['cliente']) && is_numeric($data['cliente'])){
					$cliente = new Usuario(['id' => $data['cliente'] ]);
					$this->setCliente($cliente);
				}

				if(isset($data['tipoServico'])){
					$ts = new TipoServico(['id' => $data['tipoServico'] ]);
					$this->setTipoServico($ts);
				}
				
				if(isset($data['tipoEdificio'])){
					$te = new Edificio(['id' => $data['tipoEdificio'] ]);
					$this->setTipoEdificio($te);
				}

				if(isset($data['ConfigPDF'])){
					$cpdf = new ConfigPDF(['id' => $data['ConfigPDF'] ]);
					$this->setConfigPDF($cpdf);
				}

				if(isset($data['documento']))
					$this->setDocumento(new Documento(['id' => $data['documento'] ]));

				if(isset($data['engResponsavel'])){
					$eng = new Usuario(['id' => $data['engResponsavel'] ]);
					$this->setEngenheiro($eng);
				}

				if(isset($data['status']))
					$this->setStatus($data['status']);

				if(isset($data['prazoInicio']))
					$this->setPrazoInicial($data['prazoInicio']);

				if(isset($data['prazoExecucao']))
					$this->setPrazoExecucao($data['prazoExecucao']);

				if(isset($data['dtAbertura']))
					$this->setDtAbertura($data['dtAbertura']);

				if(isset($data['dtFechamento']))
					$this->setDtFechamento($data['dtFechamento']);

				if(isset($data['dtCancelamento']))
					$this->setDtCancelamento($data['dtCancelamento']);

				if(isset($data['area'])){
					$this->setArea($data['area']);
				}

				if(isset($data['anexo'])){
					$this->setAnexo($data['anexo']);
				}

				if(isset($data['pagamento']['conteudo'])){
					$this->setCondicaoPag($data['pagamento']['conteudo']);
				}

				if(isset($data['pagamento']['condicaoPag'])){
					$this->setFormaPag($data['pagamento']['condicaoPag']);
				}

				if(isset($data['pagamento']['valor']))
					$this->setValor($data['pagamento']['valor']);

				if(isset($data['cidade']))
					$this->setCidade($data['cidade']);

				if(isset($data['regiao']))
					$this->setRegiao($data['regiao']);

				if(isset($data['pathPDF']))
					$this->setPathPDF($data['pathPDF']);

				if(isset($data['propostaPDF']))
					$this->setPropostaPDF($data['propostaPDF']);

				if(isset($data['aprovada']))
					$this->setAprovada($data['aprovada']);					
			}
		}

		public function getCliente(){ return $this->cliente; }
		public function setCliente(Usuario $cli){ $this->cliente = $cli; }

		public function getTipoServico(){ return $this->tipoServico; }
		public function setTipoServico(TipoServico $ts){ $this->tipoServico = $ts; }

		public function getTipoEdificio(){ return $this->tipoEdificio; }
		public function setTipoEdificio(Edificio $te){ $this->tipoEdificio = $te; }

		public function getConfigPDF(){ return $this->configPDF; }
		public function setConfigPDF(ConfigPDF $cPDF){ $this->configPDF = $cPDF; }

		public function getDocumento(){ return $this->documento; }
		public function setDocumento(Documento $doc){ $this->documento = $doc; }

		public function getEngenheiro(){ return $this->engenheiro; }
		public function setEngenheiro(Usuario $eng){ $this->engenheiro = $eng; }

		public function getStatus(){ return $this->status; }
		public function setStatus($status){ $this->status = $status;}

		public function getPrazoInicial(){ return $this->prazoInicial; }
		public function setPrazoInicial($pi){ $this->prazoInicial = $pi; }

		public function getPrazoExecucao(){ return $this->prazoExecucao; }
		public function setPrazoExecucao($pe){ $this->prazoExecucao = $pe; }

		public function getDtAbertura(){ return $this->dtAbertura; }
		public function setDtAbertura($da){ $this->dtAbertura = $da; }

		public function getDtCancelamento(){ return $this->dtCancelamento; }
		public function setDtCancelamento($dc){ $this->dtCancelamento = $dc; }

		public function getDtFechamento(){ return $this->dtFechamento; }
		public function setDtFechamento($df){ $this->dtFechamento = $df; }

		public function getArea(int $i = null){
			if(is_numeric($i)) return $this->area[$i];
			else return $this->area[$i];
		}
		public function setArea(Area $area ){ $this->area[] = $area; }

		public function getAnexo(int $i = null){
			if(is_numeric($i)) return $this->anexo[$i];
			else return $this->anexo;
		}
		public function setAnexo(Anexo $a){ $this->anexo[] = $a; }

		public function getCondicaoPag(){ return $this->condicaoPag; }
		public function setCondicaoPag($cpag){
			$this->condicaoPag = $cpag;
		}

		public function getValor(){ return $this->valor; }
		public function setValor($vl){ 
			$this->valor = str_replace(',','.',str_replace('.','',$vl));
		}

		public function getCidade(){ return $this->cidade; }
		public function setCidade(Cidade $ci){ $this->cidade = $ci; }

		public function getRegiao(){ return $this->regiao; }
		public function setRegiao($regiao){ $this->regiao = $regiao; }

		public function getConsideracao(){ return $this->consideracao; }
		public function setConsideracao($c){ $this->consideracao = $c; }

		public function getPathPDF(){ return $this->pathPDF; }
		public function setPathPDF($pathPDF){ $this->pathPDF = $pathPDF; }

		public function getPropostaPDF(){ return $this->propostaPDF; }
		public function setPropostaPDF(PropostaPDF $p){ $this->propostaPDF[] = $p; }

		public function getDtRegistro(){ return $this->dtRegistro; }
		public function setDtRegistro($dt){ $this->dtRegistro = $dt; }

		public function getFormaPag(){ return $this->formaPag; }
		public function setFormaPag($pag){ $this->formaPag = $pag; }

		public function getAprovada(){ return $this->aprovada; }
		public function setAprovada($ap){ $this->aprovada = $ap; }
	}