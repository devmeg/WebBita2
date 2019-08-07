<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	public function M_guardarHito($mensaje,$lugar,$lat,$lon){

		$data = array(
			        'id_delegacion' => $this->session->userdata('id_delegacion'),
			        'usuario' => $this->session->userdata('usuario'), //nombre de usuario
			        'lugar' => $lugar,
			        'latitud' => $lat,
			        'longitud' => $lon,
			        'mensaje' =>$mensaje,
			        'fecha' =>date("Y-m-d H:i:s")
					);

		$this->db->insert('hitos', $data);
		return $this->db->affected_rows();
	}

	public function M_guardarAsistente($datosAsistentes){
		$this->db->insert('asistentes', $datosAsistentes);
		return $this->db->affected_rows();
	}

	public function M_obtenerHitos($id_delegacion = 0){
		$this->db->order_by('fecha', 'DESC');
		$this->db->join('delegaciones d', 'd.id_delegacion = h.id_delegacion');
		if($id_delegacion != 0){
			$query = $this->db->get_where('hitos h', array('h.id_delegacion' => $id_delegacion));
		}else{
			$query = $this->db->get_where('hitos h', array('h.id_delegacion' => $this->session->userdata('id_delegacion')));
		}

		return $query->result();

	}
	public function M_obtenerHistorialEstado(){
		$this->db->order_by('fecha_modificacion', 'DESC');
		$this->db->join('estados_viaje e', 'e.id_estados_viaje = h.id_estados_viaje');
		$query = $this->db->get_where('historial_estado h', array('id_delegacion' => $this->session->userdata('id_delegacion')));

		return $query->result();

	}
	

	public function M_obtenerCorreosExt(){
		$query = $this->db->get_where('destinatarios_ext', array('id_delegacion' => $this->session->userdata('id_delegacion')));

		return $query->result();

	}

	public function M_obtenerDelegaciones(){
		$this->db->order_by('nombre','ASC');
		$query = $this->db->get('delegaciones');

		return $query->result();
	}

	public function SeriesHito($vuelta = 0){
		$this->db->order_by('id_hito','ASC');
		if ($vuelta == 1) {
			$this->db->where('fecha >=', '2019-12-12');
		}else{
			$this->db->where('fecha <', '2019-12-12');
		}
		
		$query = $this->db->get_where('hitos',array('id_delegacion' =>$this->session->userdata('id_delegacion')));

		return $query->result();

		
	}

	public function M_obtenerInfoViaje(){
		$query = $this->db->get_where('delegaciones', array('id_delegacion' => $this->session->userdata('id_delegacion')));

		return $query->row();
	}

	public function M_obtenerAsistentes(){
		$this->db->order_by('nombre_completo', 'ASC');
		$query = $this->db->get_where('asistentes', array('id_delegacion' => $this->session->userdata('id_delegacion')));

		return $query->result();

	}

	public function M_obtenerEstadosViaje(){
		$query = $this->db->get('estados_viaje');

		return $query->result();
	}

	public function M_obtenerUsuarios($id_user = 0){
		$this->db->order_by('nombre_completo', 'ASC');
		if ($id_user != 0) {
			$this->db->where("id_usuario =",$id_user);
			$query = $this->db->get('usuario');
			return $query->row();
		}
		$query = $this->db->get('usuario');
		return $query->result();
	}

	public function M_borrarAsistente($id_asistente){
		$this->db->delete('asistentes', array('id_asistente' => $id_asistente));
		return $this->db->affected_rows();
	}

	public function M_ActualizarInfoDelegacion($itinerario,$infoExtra){
		

		$this->db->set('itinerario',$itinerario);
		$this->db->set('informacion',$infoExtra);
		$this->db->where('id_delegacion', $this->session->userdata('id_delegacion'));
		$this->db->update('delegaciones');

		return $this->db->affected_rows();

	}

	public function M_marcarMensajesLeidos($para = 0){
		$this->db->set('estado_lectura',1);

		if ($para != 0) {
			$this->db->where('id_usuario_de', $para);
		}else{
			$this->db->where('id_usuario_de', $this->input->post('para'));
		}
		//$this->db->where('id_usuario_de', $this->input->post('para'));
		$this->db->where('id_usuario_para', $this->session->userdata('id_usuario'));
		$this->db->update('mensajes');

		//return $this->db->affected_rows();
	}

	public function M_ActualizarAgregarEstadoViaje($id_estado_viaje){
		$data = array(
			        'id_delegacion' => $this->session->userdata('id_delegacion'),
			        'id_estados_viaje' => $id_estado_viaje, //nombre de usuario
			        'fecha_modificacion' => date("Y-m-d H:i:s")
					);

		$this->db->insert('historial_estado', $data);
		return $this->db->affected_rows();
	}

	public function M_agegarChat($de,$para,$mensaje){
		$data = array(
			        'id_usuario_de' => $de,
			        'id_usuario_para' => $para,
			        'fecha' => date("Y-m-d H:i:s"),
			        'mensaje' =>$mensaje,
			        'estado_lectura'=>0

					);
		$this->db->insert('mensajes', $data);
		return $this->db->affected_rows();
	}


	public function M_obtenerMensajes($id_usuario_para){
		
		//$w1 = array('id_usuario_de' => $this->session->userdata('id_usuario'), 'id_usuario_para' => $id_usuario_para);
		//$w2 = array('id_usuario_para' => $this->session->userdata('id_usuario'), 'id_usuario_de' => $id_usuario_para);

		$this->db->order_by('fecha', 'ASC');
		$this->db->where("(id_usuario_de = ".$this->session->userdata('id_usuario')." AND id_usuario_para = ".$id_usuario_para.") OR (id_usuario_para = ".$this->session->userdata('id_usuario')." AND id_usuario_de = ".$id_usuario_para.") ");
		//$this->db->where($w1);
     	//$this->db->or_where($w2);
     	$query = $this->db->get('mensajes');
     	return $query->result();

	}

	public function M_obtenerNuevosMensajes(){
		
		//$this->db->order_by('m.estado_lectura', 'ASC');
		//$this->db->group_by('d.nombre_completo');
		//$this->db->group_by('p.nombre_completo');
		//$this->db->group_by('m.id_usuario_para');
		//$this->db->group_by('m.id_usuario_de');
		$this->db->order_by('m.fecha', 'DESC');
		$this->db->order_by('m.estado_lectura', 'ASC');
		$this->db->join('usuario p', 'p.id_usuario = m.id_usuario_para');
		$this->db->join('usuario d', 'd.id_usuario = m.id_usuario_de');
		$this->db->select('p.nombre_completo as "UsuarioPara"
						  ,d.nombre_completo as "UsuarioDe"
						  ,m.id_usuario_de as "IdUsuarioDe"
						  ,m.id_usuario_para as "IdUsuarioPara"
						  ,m.mensaje as "Mensaje"
						  ,m.fecha as "Fecha"
						  ,m.estado_lectura as "Estado"');
		$this->db->where('m.id_usuario_para ='.$this->session->userdata('id_usuario'));
		$this->db->or_where('m.id_usuario_de ='.$this->session->userdata('id_usuario'));
		//$query = $this->db->get_where('mensajes m', array('m.id_usuario_para' => $this->session->userdata('id_usuario')),4);
		$query = $this->db->get('mensajes m');

		return $query->result();
	}

	

}

/* End of file Dashboard_model.php */
/* Location: ./application/models/Dashboard_model.php */