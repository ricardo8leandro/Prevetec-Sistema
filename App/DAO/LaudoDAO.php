<?php 
	namespace App\DAO;

	use App\DAO\DAO;
	use App\Model\Laudo;
	use App\Model\LaudoModelo;
	use App\Model\LaudoItem;
	use App\Model\LaudoAppInfo;

	class LaudoDAO extends DAO {

		static public function create(Laudo $l){
			$cols  = " cd_laudo,cd_tipo_laudo,cd_cliente,cd_profissional,cd_engenheiro";
			$cols .= ",cd_cidade,cd_filial,cd_tipo_edificio";
			$cols .= ",dt_cadastro, dt_inspecao,ic_status,cd_art";

			$vals  = "NULL";
			$vals .= ",'".$l->getLaudoModelo()."' ";
			$vals .= ",'".$l->getCliente()."' ";
			$vals .= ",'".$l->getProfissional()."' ";
			$vals .= ",'".$l->getEngenheiro()."' ";
			$vals .= ",'".$l->getCidade()."' ";
			$vals .= ",'".$l->getRegiao()."' ";
			$vals .= ",'".$l->getTipoEdificio()."' ";
			$vals .= ",'".$l->getDtCadastro()."' ";
			$vals .= ",'".$l->getDtInspecao()."' ";
			// $vals .= ",'".$l->getEndereco()."' ";
			// $vals .= ",'".$l->getBairro()."' ";
			// $vals .= ",'".$l->getCEP()."' ";
			// $vals .= ",'".$l->getDtCertificado()."' ";
			$vals .= ",'".$l->getStatus()."' ";
			$vals .= ",'".$l->getCdArt()."' ";

			return parent::Insert('laudo', $cols, $vals);
		}

		static public function edit(Laudo $l){

			$set = "cd_laudo = '".$l->getId()."' ";

			if(!empty($l->getLaudoModelo()))
				$set .= ", cd_tipo_laudo ='".$l->getLaudoModelo()."' ";

			if(!empty($l->getCliente()))
				$set .= ", cd_cliente ='".$l->getCliente()."' ";

			if(!empty($l->getProfissional()))
				$set .= ", cd_profissional ='".$l->getProfissional()."' ";

			if(!empty($l->getEngenheiro()))
				$set .= ", cd_engenheiro = '".$l->getEngenheiro()."' ";

			if(!empty($l->getCidade()))
				$set .= ", cd_cidade = '".$l->getCidade()."' ";

			if(!empty($l->getRegiao()))
				$set .= ", cd_filial = '".$l->getRegiao()."' ";

			// if(!empty($l->getTipoEdificio()))
			// 	$set .= ", cd_tipo_edificio = '".$l->getTipoEdificio()."' ";

			if(!empty($l->getDtCadastro()))
				$set .= ", dt_cadastro = '".$l->getDtCadastro()."' ";

			if(!empty($l->getDtInspecao()))
				$set .= ", dt_inspecao = '".$l->getDtInspecao()."' ";

			// if(!empty($l->getEndereco()))
			// 	$set .= ", ds_endereco = '".$l->getEndereco()."' ";

			// if(!empty($l->getBairro()))
			// 	$set .= ", ds_bairro = '".$l->getBairro()."' ";

			// if(!empty($l->getCEP()))
			// 	$set .= ", cd_cep = '".$l->getCEP()."' ";

			// if(!empty($l->getDtCertificado()))
				// $set .= ", dt_certificado = '".$l->getDtCertificado()."' ";

			if(!empty($l->getStatus()))
				$set .= ", ic_status ='".$l->getStatus()."' ";

			if(!empty($l->getPDF())){
				$set .= ", ds_path_laudo_pdf ='".$l->getPDF()."' ";
			}

			if(!empty($l->getCdArt())){
				$set .= ", cd_art ='".$l->getCdArt()."' ";
			}

			$where = "cd_laudo = '".$l->getId()."' ";
			return parent::Update('laudo',$set,$where);
		}

		static public function find(Laudo $l){
			$cols  = "laudo.*, cli.nm_usuario as nm_cliente, lm.nm_laudo_modelo";
			$cols .= ",regiao.nm_regiao";

			$where = "cd_laudo > 0 ";

			if(!empty($l->getId())){ 
				$where .= " AND cd_laudo = '{$l->getId()}'";
			}

			if(!empty($l->getLaudoModelo())){
				$where .= " AND cd_tipo_laudo = '{$l->getLaudoModelo()}'";	
			}

			if(!empty($l->getStatus())){ 
				$where .= " AND laudo.ic_status = '{$l->getStatus()}'"; 
			}

			if(!empty($l->getCliente())){ 
				$where .= " AND laudo.cd_cliente = '{$l->getCliente()}'"; 
			}

			if(!empty($l->getRegiao())){ 
				$where .= " AND laudo.cd_filial = '{$l->getRegiao()}'"; 
			}

			$join = " LEFT JOIN usuario cli ON cli.cd_usuario = laudo.cd_cliente ";
			$join .= " LEFT JOIN laudo_modelo lm ON lm.cd_laudo_modelo = laudo.cd_tipo_laudo ";
			$join .= " LEFT JOIN regiao ON regiao.cd_regiao = laudo.cd_filial ";

			return parent::Select('laudo',$cols,$join,$where);
		}

		static public function create_item(LaudoItem $li){
			$cols  = "cd_laudo_item,id_laudo,ds_titulo,ds_conteudo,";
			$cols .= 'ic_status,ic_editavel,indice,estrutura_modelo,parent';

			$conteudo = str_replace("'",'´',$li->getConteudo());

			$vals = "NULL";
			$vals .= ",'".$li->getLaudo()."' ";
			$vals .= ",'".$li->getTitulo()."' ";
			$vals .= ",'".$conteudo."' ";
			$vals .= ",'".$li->getStatus()."' ";
			$vals .= ",'".$li->getEditavel()."' ";
			$vals .= ",'".$li->getIndice()."' ";
			$vals .= ",'".$li->getEstruturaModelo()."' ";
			$vals .= ",'".$li->getParent()."' ";

			return parent::Insert('laudo_item', $cols, $vals);
		}

		static public function get_laudo_itens(Laudo $laudo){
			$where = "cd_laudo_item > 0 ";

			if(!empty($laudo->getId())){ 
				$where .= " AND id_laudo = '{$laudo->getId()}'";
			}

			return parent::Select('laudo_item','*',false,$where);

		}

		static public function get_laudo_itens_by_indice(Laudo $laudo){
			$where = "cd_laudo_item > 0 ";

			if(!empty($laudo->getId())){ 
				$where .= " AND id_laudo = '{$laudo->getId()}'";
			}

			$where .= " AND estrutura_modelo <> 1 ";

			$order = " indice ASC ";
			return parent::Select('laudo_item','*',false,$where,$order);

		}

		static public function get_estrutura_capa(Laudo $laudo){
			$where = "cd_laudo_item > 0 ";

			if(!empty($laudo->getId())){ 
				$where .= " AND id_laudo = '{$laudo->getId()}'";
			}

			$where .= " AND estrutura_modelo = 1 AND ds_titulo = 'capa' ";

			return parent::Select('laudo_item','*',false,$where)[0];
		}

		static public function get_estrutura_texto(Laudo $laudo){
			$where = "cd_laudo_item > 0 ";

			if(!empty($laudo->getId())){ 
				$where .= " AND id_laudo = '{$laudo->getId()}'";
			}

			$where .= " AND estrutura_modelo = 1 AND ds_titulo = 'texto' ";

			return parent::Select('laudo_item','*',false,$where)[0];
		}

		static public function edit_laudo_item(LaudoItem $li){

			if(!empty($li->getId())){

				$set = "cd_laudo_item = '".$li->getId()."' ";

				if(!empty($li->getLaudoModelo())){
					$set .= ", id_laudo = '".$li->getLaudoModelo()."' ";
				}

				if(!empty($li->getTitulo())){
					$set .= ", ds_titulo = '".$li->getTitulo()."' ";
				}

				if(!empty($li->getConteudo())){
					$conteudo = str_replace("'",'´',$li->getConteudo());
					$set .= ", ds_conteudo = '".$conteudo()."' ";
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

				return parent::Update('laudo_item',$set,$where);
			}
		}

		static public function edit_laudo_item_multiples($query){
			return parent::query($query);
		}

		static public function remove(Laudo $l){

			$laudo = self::find($l)[0];
			// print_r($laudo);
			if(!empty($laudo['ds_path_laudo_pdf'])){
				unlink(REQ_LAUDO_PDF.'/'.$laudo['ds_path_laudo_pdf']);
			}

			if(!empty($l->getId())){
				self::remove_laudo_itens($l);
				$where = "cd_laudo = '".$l->getId()."' ";
				return parent::delete('laudo',$where);
			}
		}

		static public function remove_laudo_itens(Laudo $l){
			$itens = self::get_laudo_itens($l);

			foreach($itens as $key => $item){
				self::remove_laudo_item_anexo_by_item($item['cd_laudo_item']);
			}

			$where = "id_laudo = '".$l->getId()."' ";
			return parent::delete('laudo_item',$where);
		}

		static public function remove_anexos($id_laudo, $type){
			$where 	= "cd_laudo = $id_laudo AND ds_type = '$type' ";
			$anexos = parent::Select('laudo_anexo','*',false,$where);

			if(is_array($anexos)){
				foreach($anexos as $anexo){
					
					$file = DIR_PDFs."laudo_anexos/$id_laudo/".$anexo['nm_anexo']; 
					
					if(file_exists($file)){
						unlink($file);
					}
				}	
			}

			$where = "cd_laudo = $id_laudo AND ds_type = '$type' ";
			return parent::delete('laudo_anexo',$where);
		}

		static public function add_anexo($id_laudo, $file, $type){
			$cols  	= "cd_laudo_anexo, cd_laudo, nm_anexo,ds_type";
			$vals 	= "NULL,$id_laudo,'".$file."','".$type."'";
			return parent::Insert('laudo_anexo', $cols, $vals);
		}

		static public function get_anexos($id_laudo){
			$where = " cd_laudo = $id_laudo ";
			return parent::Select('laudo_anexo','*',false,$where);
		}

		/* anexos do item do laudo*/
		static public function create_laudo_item_anexo($data){
			$cols  = "cd_laudo_item_anexo,cd_laudo_item,ds_cabecalho,nm_anexo,ds_rodape";

			$vals  = "NULL";
			$vals .= ",'".$data['item']."'";
			$vals .= ",'".$data['header']."'";
			$vals .= ",'".$data['file']."'";
			$vals .= ",'".$data['footer']."'";

			return parent::Insert('laudo_item_anexo', $cols, $vals);
		}

		static public function edit_laudo_item_anexo($data){
			
			$set   = "ds_cabecalho = '".$data['header']."'";

			if(isset($data['file'])){
				$set  .= ",nm_anexo = '".$data['file']."'";	
			}
			
			$set  .= ",ds_rodape = '".$data['footer']."'";

			$where = "cd_laudo_item_anexo = ".$data['id'];

			return parent::Update('laudo_item_anexo',$set,$where);
		}

		static public function get_anexos_by_id($id){
			$where = " cd_laudo_item_anexo = $id ";
			return parent::Select('laudo_item_anexo','*',false,$where)[0];
		}

		static public function get_anexos_by_item($item_id){
			$where = " cd_laudo_item = $item_id ";
			return parent::Select('laudo_item_anexo','*',false,$where, ' indice ');
		}

		static public function remove_laudo_item_anexo($id){
			$where = "cd_laudo_item_anexo = ".$id;
			return parent::delete('laudo_item_anexo',$where);
		}

		static public function remove_laudo_item_anexo_by_item($cd_item){
			
			$anexos = self::get_anexos_by_item($cd_item);
			
			$dir = REQ_LAUDO_PDF.'/anexo_items/'.$cd_item;

			if(is_array($anexos)){
				foreach($anexos as $anexo){		
					if(file_exists($dir."/".$anexo['nm_anexo'])){
						unlink($dir."/".$anexo['nm_anexo']);
					}
				}
			}

			if(is_dir($dir)) rmdir($dir);

			$where = "cd_laudo_item = ".$cd_item;
			return parent::delete('laudo_item_anexo',$where);
		}

		static public function set_anexo_item_indice($sql){
			parent::query($sql);
		}


		static public function findinfoapp(Laudo $app = null){
			$where = "id > 0 ";

			return parent::Select('laudo_app_info','*',false,$where);

		}

	}
