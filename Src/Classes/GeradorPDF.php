<?php
	namespace Src\Classes;

	class GeradorPDF {
		
		public  $cabecalho;
		private $pdf; 

		public function __construct(){
			$this->pdf = new \Mpdf\Mpdf();
		}

		public function Header(){
			$this->pdf->WriteHTML($this->cabecalho);
		}

		public function Content($conteudo, $footer){
			$pags = explode('{{QUEBRA-PAGINA}}',$conteudo);

			$primeira = 0;

			foreach($pags as $key => $cont){
				if($primeira == 1){
					$this->Footer($footer);
				}

				$this->Header();
				$this->pdf->WriteHTML($cont);
				$this->pdf->AddPage();
				$primeira++;
			}
			
		}

		public function Footer($conteudo){
			$this->pdf->SetHTMLFooter($conteudo);
		}

		public function gerar($nome){
			if(!is_dir(DIR_REQ.'public/PDFs')){
				mkdir(DIR_REQ.'public/PDFs',777);
			}

			if(file_exists(DIR_PDFs.$nome.'.pdf')){
				unlink(DIR_PDFs.$nome.'.pdf');
			}
			
			$this->pdf->Output(DIR_PDFs.$nome.'.pdf','F');
			return DIR_PAGE.'public/PDFs/'.$nome.'.pdf';
		}

	}