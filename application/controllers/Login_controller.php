<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_controller extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Login_model');
	}

	public function validarLogin(){
		$P_usuario = $this->input->post("user", true);
		$P_clave = sha1($this->input->post("pass", true));

		$resp = $this->Login_model->validarLogin($P_usuario,$P_clave);

		if (!isset($resp)){
			//Error de login
			echo "Error de login";
			session_destroy();
		}else{
			$DatosLogin = array('id_usuario'=>$resp->id_usuario,
								'id_perfil'=>$resp->id_perfil,
								'nombre_completo'=>$resp->nombre_completo,
							    'correo'=>$resp->correo,
								'usuario'=>$resp->usuario,
								'id_delegacion' => $resp->id_delegacion);
			$this->session->set_userdata($DatosLogin);
			redirect('index.php/Dashboard','refresh');
		}

		
		
	}

}

/* End of file login_controller.php */
/* Location: ./application/controllers/login_controller.php */