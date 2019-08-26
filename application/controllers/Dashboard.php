<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once(APPPATH.'libraries/validators/RutDv.php');
include_once(APPPATH.'libraries/validators/Telefono.php');

class Dashboard extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Dashboard_model');

    // Correo
    $this->load->library('email');
   
    $config = array();
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'mail.domain.com';
    $config['smtp_user'] = 'a@a.cl';
    $config['smtp_pass'] = 'passMail';
    $config['smtp_port'] = 26;
    $config['mailtype']  = 'html';
    $this->email->initialize($config);
   
    $this->email->set_newline("\r\n");
  }

  public function checkMensajesNuevos()
  {
    // Consultar si existen mensajes nuevos y traer los últimos 4
    $mensajesNuevos = $this->Dashboard_model->M_obtenerNuevosMensajes();
    $contadorMensajes = 0;
    $cuadroMensaje = "";
    $arrayRemitentes = array();
    foreach ($mensajesNuevos as $fila) {
      if ($fila->IdUsuarioDe != $this->session->userdata('id_usuario')) {
        $usuario = $fila->UsuarioDe;
        $remitente = $fila->IdUsuarioDe;
      } else {
        $usuario = $fila->UsuarioPara;
        $remitente = $fila->IdUsuarioPara;
      }
    


      //$usuario = $fila->UsuarioDe;
      if ($fila->Estado == 0 && $fila->IdUsuarioPara == $this->session->userdata('id_usuario')) {
        $contadorMensajes++;
        $usuario = "<b>".$usuario."</b>";
      }
      if (!in_array($remitente, $arrayRemitentes)) {
        $cuadroMensaje .='<a href="'.base_url("Dashboard/inbox/".$remitente).'">
                                <div class="mail-contnet">
                                    <h5>'.$usuario.'</h5> <span class="mail-desc">'.$fila->Mensaje.'</span> <span class="time">'.date("H:i", strtotime($fila->Fecha)).'</span>
                                </div>
                              </a>';
      }
      $arrayRemitentes[] = $remitente;
    }

    return array($cuadroMensaje,$contadorMensajes);
  }

  public function index()
  {
    $data["mensajes"] = $this->checkMensajesNuevos()[0];
    $data["mensajesNuevos"] = $this->checkMensajesNuevos()[1];

    // Obtener Nombres de delegaciones
    $delegaciones = $this->Dashboard_model->M_obtenerDelegaciones();
    $data['selectDelegaciones'] = "";
    foreach ($delegaciones as $fila) {
      $data['selectDelegaciones'] .= "<option value=".$fila->id_delegacion.">".$fila->nombre."</option>";
    }


    $this->load->view('template/header', $data);
    $this->load->view('template/Dashboard');
    $this->load->view('template/footer');
  }
  public function hitos_pordelegaciones()
  {
    $data["mensajes"] = $this->checkMensajesNuevos()[0];
    $data["mensajesNuevos"] = $this->checkMensajesNuevos()[1];
    $this->load->view('template/header', $data);
    $this->load->view('template/HitosPorDelegaciones');
    $this->load->view('template/footer');
  }

  public function rutaViaje()
  {
    $data["mensajes"] = $this->checkMensajesNuevos()[0];
    $data["mensajesNuevos"] = $this->checkMensajesNuevos()[1];

    // Obtener Serialización de hitos
    $s_hitos = $this->Dashboard_model->SeriesHito();
    $data['s_hitos'] = "";
    $data['rutas'] = "";
    $puntos = array();
    foreach ($s_hitos as $fila) {
      if ($fila->latitud != "" && $fila->longitud !="") {
        $data['s_hitos'] .= "{
                    lugar: '".$fila->lugar."',
                    mensaje: '".$fila->mensaje."' ,
                      id: '".$fila->id_hito."',
                      lat: ".$fila->latitud.",
                      lon: ".$fila->longitud."
                      },";
        $puntos[] = $fila->id_hito;
      }
    }
    $data['s_hitos'] = substr($data['s_hitos'], 0, -1);

    for ($i=0; $i <count($puntos)-1 ; $i++) {
      $data['rutas'] .= "{
                  id: '".$puntos[$i]."-".$puntos[$i+1]."',
                  path: pointsToPath(chart.get('".$puntos[$i]."'), chart.get('".$puntos[$i+1]."'))
                },";
    }
    $data['rutas'].= "{
                id: '".$puntos[count($puntos)-1]." - V Campori',
                path: pointsToPath(chart.get('".$puntos[count($puntos)-1]."'), chart.get('V Campori'), true)
              }";

    // Obtener Serielaización de hitos VUELTA
    $s_hitosVuelta = $this->Dashboard_model->SeriesHito(1);
    $data['s_hitosVuelta'] = ",";
    $data['rutasVuelta'] = "";
    $puntosVuelta = array();
    foreach ($s_hitosVuelta as $fila) {
      if ($fila->latitud != "" && $fila->longitud !="") {
        $data['s_hitosVuelta'] .= "{
                    lugar: '".$fila->lugar."',
                    mensaje: '".$fila->mensaje."' ,
                      id: '".$fila->id_hito."',
                      lat: ".$fila->latitud.",
                      lon: ".$fila->longitud."
                      },";
        $puntosVuelta[] = $fila->id_hito;
      }
    }
    $data['s_hitosVuelta'] = substr($data['s_hitosVuelta'], 0, -1);

    for ($i=0; $i <count($puntosVuelta) ; $i++) {
      if ($i==0) {
        $data['rutasVuelta'] .= "{
                  id: 'V Campori - ".$puntosVuelta[$i]."',
                  path: pointsToPath(chart.get('V Campori'), chart.get('".$puntosVuelta[$i]."'))
                },";
      } else {
        $data['rutasVuelta'] .= "{
                  id: '".$puntosVuelta[$i-1]." - ".$puntosVuelta[$i]."',
                  path: pointsToPath(chart.get('".$puntosVuelta[$i-1]."'), chart.get('".$puntosVuelta[$i]."'))
                },";
      }
    }

    $data['rutasVuelta'] = substr($data['rutasVuelta'], 0, -1);
  




    $this->load->view('template/header', $data);
    $this->load->view('template/rutaViaje');
    $this->load->view('template/footer');
  }
  public function listaAsistentes()
  {
    $data["mensajes"] = $this->checkMensajesNuevos()[0];
    $data["mensajesNuevos"] = $this->checkMensajesNuevos()[1];
    $data["tabla_Asistentes"] = $this->C_obtenerAsistentes();
    $this->load->view('template/header', $data);
    $this->load->view('template/listaAsistentes', $data);
    $this->load->view('template/footer');
  }


  public function inbox($id_usuario_para = 0)
  {
    $data["mensajes"] = $this->checkMensajesNuevos()[0];
    $data["mensajesNuevos"] = $this->checkMensajesNuevos()[1];
    // Marcar mensajes como leídos
    $this->Dashboard_model->M_marcarMensajesLeidos($id_usuario_para);

    // obener todos los usuario excepto el mio
    $lista_usuarios = $this->Dashboard_model->M_obtenerUsuarios();
    $data["selectUsers"] ="";
    $opc = "";
    foreach ($lista_usuarios as $fila) {
      if ($this->session->userdata('id_usuario') !=$fila->id_usuario) {
        if ($id_usuario_para !=0 && $fila->id_usuario == $id_usuario_para) {
          $opc = "selected";
        } else {
          $opc = "";
        }

        $data["selectUsers"] .= "<option ".$opc." value='".$fila->id_usuario."'>".$fila->nombre_completo."</option>";
      }
    }


    $data["msgBox"] ="";
    $data["para"] = 0;
    $data["showInput"] =0;
    $data["Destinatario"] ="";
    if ($id_usuario_para != 0) {
      //Obtener Nombre del usuario a mensajear
      $NombreUsuario = $this->Dashboard_model->M_obtenerUsuarios($id_usuario_para);
      $data["Destinatario"] = "Mensajes con ".$NombreUsuario->nombre_completo;


      $data["showInput"] =1;
      // Obtener todos los mensajes enviados por mi y/o recibido por id_usuario_para
      $mensajes = $this->Dashboard_model->M_obtenerMensajes($id_usuario_para);
      $data["para"] = $id_usuario_para;
      foreach ($mensajes as $fila) {
        if ($this->session->userdata('id_usuario') == $fila->id_usuario_de) {
          $data["msgBox"] .="<div class='box3 sb13'>".$fila->mensaje."</div>";
        } else {
          $data["msgBox"] .="<div class='box4 sb14'><p>".$fila->mensaje."</p></div>";
        }
      }
    }

  
    $this->load->view('template/header', $data);
    $this->load->view('template/mensajes', $data);
    $this->load->view('template/footer');
  }

  public function inboxMasivo()
  {
    $data["mensajes"] = $this->checkMensajesNuevos()[0];
    $data["mensajesNuevos"] = $this->checkMensajesNuevos()[1];

    $this->load->view('template/header', $data);
    $this->load->view('template/mensajesMasivos', $data);
    $this->load->view('template/footer');
  }

  public function C_obtenerChat($output)
  {
    //Marcar mensajes como leido
    $this->Dashboard_model->M_marcarMensajesLeidos();
    $msgBox ="";
    // Obtener todos los mensajes enviados por mi y/o recibido por id_usuario_para
    $mensajes = $this->Dashboard_model->M_obtenerMensajes($this->input->post("para"));
    $data["para"] = $this->input->post("para");

    foreach ($mensajes as $fila) {
      if ($this->session->userdata('id_usuario') == $fila->id_usuario_de) {
        $msgBox .="<div class='box3 sb13'>".$fila->mensaje."</div>";
      } else {
        $msgBox .="<div class='box4 sb14'><p>".$fila->mensaje."</p></div>";
      }
    }

    if ($output == 1) {
      echo $msgBox;
    } else {
      return $msgBox;
    }
  }

  public function C_agregarChat()
  {
    $de = $this->input->post("de");
    $para = $this->input->post("para");
    $mensaje = $this->input->post("mensaje");

    $this->Dashboard_model->M_agegarChat($de, $para, $mensaje);

    $this->C_obtenerChat(1);
  }

  public function C_agregarChatMasivo()
  {
    $de = $this->input->post("de");
    $mensaje = $this->input->post("mensaje");
    // obtener todos los usaurios
    $lista_usuarios = $this->Dashboard_model->M_obtenerUsuarios();
    foreach ($lista_usuarios as $fila) {
      if ($fila->id_usuario != $de) {
        $para = $fila->id_usuario;
        $this->Dashboard_model->M_agegarChat($de, $para, $mensaje);
      }
    }
  }

  public function logOut()
  {
    session_destroy();
    redirect(base_url(), 'refresh');
  }

  public function infoViaje()
  {
    $data["mensajes"] = $this->checkMensajesNuevos()[0];
    $data["mensajesNuevos"] = $this->checkMensajesNuevos()[1];

    $data["select_estados"] = $this->C_obtenerEstadosViaje();
    $r_estados = $this->Dashboard_model->M_obtenerHistorialEstado();

    $data["tabla_Historial"] = "";
    $cont = 1;
    foreach ($r_estados as $fila) {
      $data["tabla_Historial"] .= "<tr>
                      <td>".($cont++)."</td>
                      <td>".$fila->fecha_modificacion."</td>
                      <td>".$fila->nombre."</td>
                    </tr>";
    }

    // Obtener itinerario e información extra
    $datosViaje = $this->Dashboard_model->M_obtenerInfoViaje();
    $data["itinerario"] = $datosViaje->itinerario;
    $data["infoExtra"] = $datosViaje->informacion;



    $this->load->view('template/header', $data);
    $this->load->view('template/infoViaje', $data);
    $this->load->view('template/footer');
  }

  public function C_guardarAsistente()
  {
    $resp = 0;
    $data = [];
    
    $this->load->library("form_validation");

    $this->form_validation->set_rules('nombreCompleto', 'Nombre Completo', 'required|min_length[3]|max_length[100]|alpha|trim');
    //$this->form_validation->set_rules('fecha_nacimiento', 'Fecha de Nacimiento', 'required|regex_match[(0[1-9]|1[0-9]|2[0-9]|3(0|1))-(0[1-9]|1[0-2])-\d{4}]|trim');
    $this->form_validation->set_rules('club', 'Club', 'required|min_length[3]|max_length[45]|alpha|trim');
    
    //Mensajes
    // %s es el nombre del campo que ha fallado
    $this->form_validation->set_message('required','El campo %s es obligatorio');
    $this->form_validation->set_message('alpha','El campo %s debe estar compuesto solo por letras');
    $this->form_validation->set_message('min_length','El campo {field} debe tener mas de {param} caracteres');
    $this->form_validation->set_message('max_length','El campo {field} debe tener menos de {param} caracteres');
    //$this->form_validation->set_message('max_length[100]','El campo %s debe tener menos de 101 caracteres');
    //$this->form_validation->set_message('regex_match[(0[1-9]|1[0-9]|2[0-9]|3(0|1))-(0[1-9]|1[0-2])-\d{4}]','El campo %s debe tener formato dd-mm-aaaa');

    //continua con el ingreso a la BD ya que las validaciones de la interfaz estan ok
    $this->load->library('validators/RutDv');
    $this->rutdv->setValue($this->input->post('rut'));
    $this->load->library('validators/Telefono');
    $this->telefono->setValue($this->input->post('telefono'));

    if ($this->rutdv->validate() && $this->telefono->validate() && $this->form_validation->run()) {
      $datosAsistentes = ['id_delegacion'=>$this->session->userdata('id_delegacion')
      ,'nombre_completo'=> $this->input->post('nombre')
      ,'rut'=>$this->rutdv->getValue()
      ,'fecha_nacimiento'=> date(
        'Y-m-d',
        strtotime($this->input->post('fecha_nacimiento'))
      )
      ,'club'=>$this->input->post('club')
      ,'telefono'=>$this->telefono->getValue()
      ];

      $resp = $this->Dashboard_model->M_guardarAsistente($datosAsistentes);
      if ($resp != 0){
        $data['success'] = '<div class="alert alert-success">Se ha agregado al asistente con exito</div>';
      } else {
        $data['critical'] = '<div class="alert alert-danger">ERROR: ocurrio un error, no se ha ingresado el asistente</div>';
      }
    }
    else {
      $data['error'] = true;
      $data['nombreCompleto_error'] = form_error('nombreCompleto');
      $data['rut_error'] = $this->rutdv->validate() ? '' : 'El Rut es invalido'; 
      $data['fecha_nacimiento_error'] = form_error('fecha_nacimiento');
      $data['club_error'] = form_error('club');
      $data['fono_error'] = $this->telefono->validate() ? '' : 'El telefono es invalido';
    }
    //$data['lista'] = $this->C_obtenerAsistentes();
    //log_message('error',json_encode($data));
    echo json_encode($data);
  }

  public function C_obtenerEstadosViaje()
  {
    $resp = $this->Dashboard_model->M_obtenerEstadosViaje();
    $select_estados = "";
    foreach ($resp as $fila) {
      $select_estados .="<option value='".$fila->id_estados_viaje."'>".$fila->nombre."</option>";
    }
    return $select_estados;
  }

  public function C_actualizarEstado()
  {
    // Itinerario e información se van a la tabla DELEGACIONES
    $itinerario = $this->input->post("itinerario");
    $infoExtra = $this->input->post("infoExtra");
    $resp_delaciones = $this->Dashboard_model->M_ActualizarInfoDelegacion($itinerario, $infoExtra);

    if ($resp_delaciones == 0) {
      //echo "Hubo un problema con la actualizacion de informacion";
    }

    // id_estado se va a la tabla HISTORIAL_ESTADO
    $id_estado_viaje = $this->input->post("id_estado");
    $resp_estado = $this->Dashboard_model->M_ActualizarAgregarEstadoViaje($id_estado_viaje);
    if ($resp_estado == 0) {
      //echo "Hubo un problema con la actualizacion de estado";
    }

    $this->C_obtenerHistorialEstados(1);
  }

  public function send_mail($mensaje, $lat, $long)
  {
    // Obtener correos de externos
    $correosExt = $this->Dashboard_model->M_obtenerCorreosExt();
    $mailDefault = "";
    foreach ($correosExt as $fila) {
      $mailDefault .= $fila->email.",";
    }

    $mailDefault.="a@a.cl";

    // Ubicación
    if ($lat != "" && $long != "") {
      $MapAPI = '<a href="https://www.google.com/maps/search/?api=1&query='.$lat.','.$long.'" target="_blank">Ver ubicación</a><br><br>';
    } else {
      $MapAPI ="";
    }
    // en caso de no tener destinatarios externos

    $from_email = "a@a.cl";
    $to_email = $mailDefault;

    $this->email->from($from_email, 'Bitácora de '.str_replace(".", " ", $this->session->userdata('usuario')));
    $this->email->to($to_email);
    $this->email->subject('['.str_replace(".", " ", $this->session->userdata('usuario')).'] Nuevo Hito');
    $this->email->message("Hola! <br>Se ha registrado un nuevo hito de viaje.<br><br>Club: ".str_replace(".", " ", $this->session->userdata('usuario'))."<br><br>=== Inicio del mensaje === <br><br>".$mensaje."<br><br>".$MapAPI." === fin del mensaje ===<br><br>Atentamente,<br>Administración");
    //Send mail
    if ($this->email->send()) {
      $this->session->set_flashdata("email_sent", "Congragulation Email Send Successfully.");
    } else {
      $this->session->set_flashdata("email_sent", "You have encountered an error");
    }
  }

  public function C_obtenerHistorialEstados($output = 0)
  {
    $r_estados = $this->Dashboard_model->M_obtenerHistorialEstado();

    $tabla_Historial = "";
    $cont = 1;
    foreach ($r_estados as $fila) {
      $tabla_Historial .= "<tr>
                      <td>".($cont++)."</td>
                      <td>".$fila->fecha_modificacion."</td>
                      <td>".$fila->nombre."</td>
                    </tr>";
    }
    if ($output == 1) {
      echo $tabla_Historial;
    } else {
      return $tabla_Historial;
    }
  }

  public function C_obtenerAsistentes($output = 0)
  {
    $resp = $this->Dashboard_model->M_obtenerAsistentes();
    $tabla_Asistentes = "";
    $contador= 1;
    foreach ($resp as $fila) {
      $rut = RutDv::format($fila->rut);
      $telefono = Telefono::format($fila->telefono); 
      $tabla_Asistentes .= "<tr>
                    <td>".$contador++."</td>
                    <td>".$fila->nombre_completo."</td>
                    <td>".$rut."</td>
                    <td>".$fila->edad."</td>
                    <td>".$fila->club."</td>
                    <td>".$telefono."</td>
                    <td>
            
                      <!-- <button type='button' class='btn btn-warning btn-flat btn-addon b_editar'><i class='ti-user'></i>Editar</button> -->
                    </td>
                    <td>
                      
                      <button type='button' value='".$fila->id_asistente."' class='btn btn-danger btn-flat btn-addon b_borrar'><i class='fa fa-times' aria-hidden='true'></i>Borrar</button>
                    </td>
                  </tr>";
    }
    if ($output == 1) {
      echo $tabla_Asistentes;
    } else {
      return $tabla_Asistentes;
    }
  }

  public function C_guardarHito()
  {
    $mensaje = $this->input->post("mensaje");
    $lugar = $this->input->post("lugar");
    $lat = $this->input->post("latitud");
    $lon = $this->input->post("longitud");

    $resp = $this->Dashboard_model->M_guardarHito($mensaje, $lugar, $lat, $lon);

    if ($resp == 0) {
      echo "ERROR";
    } else {
      $this->send_mail($mensaje, $lat, $lon);
      echo $this->C_obtenerHitos();
    }
  }

  public function C_obtenerHitos($output=0, $idDelegacion = 0)
  {
    // https://www.google.com/maps/search/?api=1&query=36.26577,-92.54324
    $resp = $this->Dashboard_model->M_obtenerHitos($idDelegacion);
    $hitos = "";
    foreach ($resp as $fila) {
      $mapaAPI = "";
      if ($fila->latitud!="" && $fila->longitud!="") {
        $mapaAPI = '<a href="https://www.google.com/maps/search/?api=1&query='.$fila->latitud.','.$fila->longitud.'" target="_blank">Ver ubicación</a>';
      }
      $hitos .= '<div class="row">
              <div class="col-lg-1"></div>
              <div class="col-lg-10">
                <div class="card card-outline-info">
                  <div class="card-title">
                    <h4>'.$fila->nombre.'</h4>
                    <small>'.$fila->fecha.'  - '.$fila->lugar.' '.$mapaAPI.'</small>
                  </div>
                  <div class="card-body m-t-15">
                      '.$fila->mensaje.'
                  </div>
                </div>
              </div>
            </div>';
    }
    if ($output = 1) {
      echo $hitos;
    } else {
      return $hitos;
    }
  }

  public function C_borrarAsistente()
  {
    $resp = $this->Dashboard_model->M_borrarAsistente($this->input->post("id_asistente"));
    if ($resp == 0) {
      echo "ERROR";
    } else {
      echo $this->C_obtenerAsistentes(1);
    }
  }
}

/* End of file Dashboard_controller.php */
/* Location: ./application/controllers/Dashboard_controller.php */