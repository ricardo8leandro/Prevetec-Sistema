<?php 
	namespace App\DAO;

	use App\DAO\DAO;
	use App\Model\LaudoModelo;
	use App\Model\LaudoItem;

	class LaudoModeloDAO extends DAO {

		static public function create(LaudoModelo $lm){

			$cols  = "cd_laudo_modelo,nm_laudo_modelo,capa,texto,ic_status,";
			$cols .= 'laudo_modelo_cabecalho,laudo_modelo_rodape,';
			$cols .= 'laudo_modelo_titulo,laudo_modelo_subtitulo1, laudo_modelo_subtitulo2';

			$capa  = str_replace("'",'´',$lm->getCapa());
			$texto = str_replace("'",'´',$lm->getTexto());
			$cabecalho = str_replace("'",'´',$lm->getCabecalho()); 
			$rodape = str_replace("'",'´',$lm->getRodape());

			$vals = "NULL";
			$vals .= ",'".$lm->getNome()."' ";
			$vals .= ",'".$capa."' ";
			$vals .= ",'".$texto."' ";
			$vals .= ",'".$lm->getStatus()."' ";
			$vals .= ",'".$cabecalho."' ";
			$vals .= ",'".$rodape."' ";

			$vals .= ",'".$lm->getTitulo()."' ";
			$vals .= ",'".$lm->getSubtitulo1()."' ";
			$vals .= ",'".$lm->getSubtitulo2()."' ";

			return parent::Insert('laudo_modelo', $cols, $vals);
		}

		static public function find(LaudoModelo $lm, $order = false){
			
			$where = " cd_laudo_modelo > 0 ";

			if(!empty($lm->getId())){ 
				$where = " cd_laudo_modelo = '{$lm->getId()}'";
			}
			
			if(!empty($lm->getNome())){ 
				$where .= " AND nm_laudo_modelo = '{$lm->getNome()}'";
			}

			if(!empty($lm->getStatus())){ 
				$where .= " AND ic_status = '{$lm->getStatus()}'"; 
			}

			return parent::Select('laudo_modelo','*',false,$where, $order);
		}

		static public function edit(LaudoModelo $lm){

			if(!empty($lm->getId())){

				$set = "cd_laudo_modelo = '".$lm->getId()."' ";

				if(!empty($lm->getNome())){
					$set .= ", nm_laudo_modelo = '".$lm->getNome()."' ";
				}

				if(!empty($lm->getCapa())){
					$capa = str_replace("'",'´',$lm->getCapa());
					$set .= ", capa = '".$capa."' ";
				}

				if(!empty($lm->getTexto())){
					$texto = str_replace("'",'´',$lm->getTexto());
					$set .= ", texto = '".$texto."' ";
				}

				if(!empty($lm->getStatus())){
					$set .= ", ic_status = '".$lm->getStatus()."' ";
				}

				if(!empty($lm->getCabecalho())){
					$cabecalho = str_replace("'",'´',$lm->getCabecalho());
					$set .= ", laudo_modelo_cabecalho = '".$cabecalho."' ";
				}

				if(!empty($lm->getRodape())){
					$rodape = str_replace("'",'´',$lm->getRodape());
					$set .= ", laudo_modelo_rodape = '".$rodape."' ";
				}

				if(!empty($lm->getTitulo())){
					$conteudo = str_replace("'",'´',$lm->getTitulo());
					$set .= ", laudo_modelo_titulo = '".$conteudo."' ";
				}

				if(!empty($lm->getSubtitulo1())){
					$conteudo = str_replace("'",'´',$lm->getSubtitulo1());
					$set .= ", laudo_modelo_subtitulo1 = '".$conteudo."' ";
				}

				if(!empty($lm->getSubtitulo2())){
					$conteudo = str_replace("'",'´',$lm->getSubtitulo2());
					$set .= ", laudo_modelo_subtitulo2 = '".$conteudo."' ";
				}

				$where = "cd_laudo_modelo = '".$lm->getId()."' ";

				return parent::Update('laudo_modelo',$set,$where);
			}
		}

		static public function remove(LaudoModelo $lm){
			
			if(!empty($lm->getId())){
				$where = "id_laudo_modelo = '".$lm->getId()."' ";

				if(parent::delete('laudo_modelo_item',$where)){
					$where = "cd_laudo_modelo = '".$lm->getId()."' ";
					return parent::delete('laudo_modelo',$where);	
				}
			}
		}

		static public function new_item(LaudoItem $li){
			$cols  = "cd_laudo_item,id_laudo_modelo,ds_titulo,";
			$cols .= 'ds_conteudo,ic_status,ic_editavel,indice,parent';

			$conteudo = str_replace("'",'´',$li->getConteudo());

			$vals = "NULL";
			$vals .= ",'".$li->getLaudoModelo()."' ";
			$vals .= ",'".$li->getTitulo()."' ";
			$vals .= ",'".$conteudo."' ";
			$vals .= ",'".$li->getStatus()."' ";
			$vals .= ",'".$li->getEditavel()."' ";
			$vals .= ",'".$li->getIndice()."' ";
			$vals .= ",'".$li->getParent()."' ";

			return parent::Insert('laudo_modelo_item', $cols, $vals);
		}

		static public function find_itens(LaudoItem $li){
			
			$where = "cd_laudo_item > 0 ";

			if(!empty($li->getId())){ 
				$where = "cd_laudo_item = '{$li->getId()}'";
			}

			if(!empty($li->getLaudoModelo())){ 
				$where .= " AND id_laudo_modelo = '{$li->getLaudoModelo()}'";
			}
			
			if(!empty($li->getTitulo())){ 
				$where .= " AND laudo_modelo_item.ds_titulo = '{$li->getTitulo()}'";
			}

			if(!empty($li->getStatus())){ 
				$where .= " AND laudo_modelo_item.ic_status = '{$li->getStatus()}'"; 
			}

			if(!empty($li->getParent())){ 
				$where .= " AND laudo_modelo_item.parent = '{$li->getParent()}'"; 
			}

			$join  = " JOIN laudo_modelo ";
			$join .= " ON laudo_modelo.cd_laudo_modelo = laudo_modelo_item.id_laudo_modelo ";

			$cols  = "laudo_modelo_item.*,";
			$cols .= "laudo_modelo.nm_laudo_modelo";

			return parent::Select('laudo_modelo_item',$cols,$join,$where);
		}

		static public function find_itens_by_indice(LaudoItem $li){
			
			$where = "cd_laudo_item > 0 ";

			if(!empty($li->getId())){ 
				$where = "cd_laudo_item = '{$li->getId()}'";
			}

			if(!empty($li->getLaudoModelo())){ 
				$where = "id_laudo_modelo = '{$li->getLaudoModelo()}'";
			}
			
			if(!empty($li->getTitulo())){ 
				$where .= " AND laudo_modelo_item.ds_titulo = '{$li->getTitulo()}'";
			}

			if(!empty($li->getStatus())){ 
				$where .= " AND laudo_modelo_item.ic_status = '{$li->getStatus()}'"; 
			}
			$join  = " JOIN laudo_modelo ";
			$join .= " ON laudo_modelo.cd_laudo_modelo = laudo_modelo_item.id_laudo_modelo ";

			$cols  = "laudo_modelo_item.*,";
			$cols .= "laudo_modelo.nm_laudo_modelo";

			$order = 'laudo_modelo_item.indice ASC ';
			return parent::Select('laudo_modelo_item',$cols,$join,$where,$order);
		}

		static public function edit_item(LaudoItem $li){

			if(!empty($li->getId())){

				$set = "cd_laudo_item = '".$li->getId()."' ";

				if(!empty($li->getLaudoModelo())){
					$set .= ", id_laudo_modelo = '".$li->getLaudoModelo()."' ";
				}

				if(!empty($li->getTitulo())){
					$set .= ", ds_titulo = '".$li->getTitulo()."' ";
				}

				if(!empty($li->getConteudo())){
					$conteudo = str_replace("'",'´',$li->getConteudo());
					$set .= ", ds_conteudo = '".$conteudo."' ";
				}

				if(!empty($li->getStatus())){
					$set .= ", ic_status = '".$li->getStatus()."' ";
				}

				if(!empty($li->getEditavel())){
					$set .= ", ic_editavel = '".$li->getEditavel()."' ";
				}

				if(!empty($li->getIndice())){
					$set .= ", indice = '".$li->getIndice()."' ";
				}

				$where = "cd_laudo_item = '".$li->getId()."' ";

				return parent::Update('laudo_modelo_item',$set,$where);
			}
		}

		static public function remove_item(LaudoItem $li){
			if(!empty($li->getId())){
				$where = "cd_laudo_item = '".$li->getId()."' ";
				return parent::delete('laudo_modelo_item',$where);
			}
		}

		static public function update_item_indice($sql){

			return parent::query($sql);

			// if(!empty($li->getId())){

			// 	if( is_numeric($li->getIndice()) ){
			// 		$set = " indice = '".$li->getIndice()."' ";

			// 		$where  = " cd_laudo_item = '".$li->getId()."' ";
			// 		$where .= " AND id_laudo_modelo = '".$li->getLaudoModelo()."' "; 

			// 		return parent::Update('laudo_modelo_item',$set,$where);
			// 	}
			// }
		}
	}