<?php
	namespace Src\Classes;

	class GeradorLAUDOPDF {
		
		public  $cabecalho;
		private $pdf; 

		public function __construct(){

			$this->pdf = new \Mpdf\Mpdf();
			$this->pdf->setAutoTopMargin = 'stretch';
			$this->pdf->setAutoBottomMargin = 'stretch';
		}

		public function Capa($conteudo){
			$this->pdf->WriteHTML($conteudo);
			$this->pdf->AddPage();
		}

		public function Texto($conteudo){
			$this->pdf->WriteHTML($conteudo);
			$this->pdf->AddPage();
		}

		public function Sumario($conteudo){
			$this->pdf->WriteHTML($conteudo);
			$this->pdf->AddPage();
		}

		public function AddPage(){
			$this->pdf->AddPage();
		}

		public function add_laudo_item($titulo,$conteudo){
			
			$conteudos = explode("{{QUEBRA-PAGINA}}",$conteudo);
			$this->pdf->WriteHTML($titulo);

			if(is_array($conteudos)){
				
				foreach($conteudos as $k => $c){
					$this->pdf->WriteHTML($c);
					if($k < count($conteudos) -1 ) $this->pdf->AddPage();
				}

			}else{
				$this->pdf->WriteHTML($conteudo);
			}
		}

		public function Content($titulo,$conteudo,$novaPage, $type,$header = '', $footer = ''){

			if($type == 'proposta'){
				$pags = explode('{{QUEBRA-PAGINA}}',$conteudo);

				$primeira = 0;
				$header_adicionado = false;

				$this->Header($header);
				$this->Footer($footer); 

				foreach($pags as $key => $cont){

					$this->pdf->WriteHTML($cont);
					$primeira++;

					if($primeira < count($pags)) $this->pdf->AddPage();
				}
			}
		}

		public function Header($conteudo = ''){
			$this->pdf->SetHTMLHeader($conteudo);
		}

		public function Footer($conteudo = ''){
			$this->pdf->SetHTMLFooter($conteudo);
		}

		public function gerar($nome, $base_dir){

			if(!is_dir($base_dir)) mkdir($base_dir,0777);
			if(file_exists($base_dir.'/'.$nome)) unlink($base_dir.'/'.$nome);

			$this->pdf->Output($base_dir.'/'.$nome,'F');
			
			return $nome;
		}

		public function addAnexo($anexo){

			try{
				
				$this->Header('');
				$this->Footer('');

				$this->pdf->AddPage();

				$pagecount = $this->pdf->SetSourceFile($anexo);

				// Import the last page of the source PDF file
				for($i = 1; $i <= $pagecount; $i++){

					$tplId = $this->pdf->ImportPage($i);
					$this->pdf->UseTemplate($tplId);
					
					if($i < $pagecount)$this->pdf->AddPage();
				}

				return true;

			} catch (\Exception $e) {
				return false;
			}
			
		}

		public function addImage($file,$type){
			$this->pdf->AddPage();
			$this->pdf->Image($file, 0, 0, 210, 297,$type, '', true, false);
		}

		public function Output(){
			$this->pdf->Output();
		}
	}