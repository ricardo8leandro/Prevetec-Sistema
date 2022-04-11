<?php 
	namespace Src\Traits;

	trait TraitOrderItemTitles {

		private function orderItemTitles($laudoItens = []){

			$titulos 		= [];
			$subtitulos 	= [];
			$subtitulos2	= [];

			if(is_array($laudoItens)){
				
				//busca titulos
				foreach($laudoItens as $i => $item){
					if(isset($item['parent']) && $item['parent'] == 0 || empty($item['parent'])){
						$titulos[] = $item;
					}else{
						$subtitulos[] = $item; 
					}
				}

				//busca subtitulos
				foreach($subtitulos as $i => $subtitulo){
					
					$sub1 = false;

					foreach($titulos as $key => $titulo){
						
						if(isset($titulo['cd_laudo_item']) && $subtitulo['parent'] == $titulo['cd_laudo_item']){
							$titulos[$key]['child'][] = $subtitulo;
							$sub1 = true;
						}
					}

					//se nao for 1 subtitulo1, eh subtitulo2
					if(!$sub1){
						$subtitulos2[] = $subtitulo;
					}
				}

				//busca os subtitulos nivel 2
				foreach($subtitulos2 as $key => $st2){

					//percorre os titulos
					foreach($titulos as $k1 => $t){

						//percorre os subtitulos
						if(isset($t['child'])){
							foreach($t['child'] as $k2 => $st1){
							
								if($st2['parent'] == $st1['cd_laudo_item']){
									$titulos[$k1]['child'][$k2]['child'][] = $st2;
								}
							}	
						}
					}
				}
			}

			return $titulos;
		}
	}

