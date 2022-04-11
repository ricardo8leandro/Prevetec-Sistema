<?php 
	namespace App\Controller;

	use App\Controller\Controller;

	use App\DAO\EstadoDAO;

	class ControllerEstado extends Controller {

		public function listAll(){
			echo json_encode( EstadoDAO::find() );
		}
	}