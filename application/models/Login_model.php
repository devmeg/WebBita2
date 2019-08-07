<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

	public function validarLogin($u,$p){
		$this->db->join('delegados_comunicaciones dc', 'dc.id_usuario = u.id_usuario');
		$this->db->select('u.id_usuario
						  ,u.id_perfil
						  ,u.nombre_completo
						  ,u.correo
						  ,u.usuario
						  ,dc.id_delegacion
                          ');
		$consulta = $this->db->get_where('usuario u',array('u.usuario'=>$u,
														    'u.password'=>$p
													  ));

		if($consulta->num_rows()>=1){
			return $consulta->row();
		}
		

	}

	

}

/* End of file Login_model.php */
/* Location: ./application/models/Login_model.php */