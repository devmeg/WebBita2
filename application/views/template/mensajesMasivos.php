
<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 style="color:#ffffff;">Bandeja de entrada</h3> </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <!-- Row -->
            
                <!-- Row -->
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <div class="card card-outline-info">
                            
                            <div class="card-body m-t-15">
                            	<legend>Inbox</legend>
                                <form action="#" class="form-horizontal form-bordered">
                                    <div class="form-body"> 
										<div class="row">

											
											
											<div class="col-md-12">
												<h2>Mensaje Masivo</h2>
												<div class="alert alert-info">
			                                        Este módulo solo envía mensajes masivos, para leer las respuestas se debe revisar cada mensaje de manera independiente <a href="<?php echo base_url('Dashboard/inbox'); ?>" class="alert-link">en este link</a>.
			                                    </div>
												
												<hr>

												
												<div class="form-group row">
	                                            
		                                            <div class="col-md-9">
		                                                <div class="btn-box input-group input-group-rounded">
		                                                	<input type="text" placeholder="Escribe un mensaje" id="textMessage" name="mensaje" class="form-control">
		                                                	<span class="input-group-btn">
		                                                		<button id="sendMsgMasivo" class="btn btn-primary btn-group-right" type="button">
		                                                			<i class="mdi mdi-send font-20" aria-hidden="true"></i>
		                                                		</button>
		                                                	</span>
		                                            	</div>
		                                            </div>
	                                        	</div>
	                                        


											</div>
										</div>
			
                                    </div>
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


              

				
				

			<script src="<?php echo base_url('assets/js/lib/jquery/jquery.min.js');?>"></script>
            <script type="text/javascript">

				$('.btn-box').on('click','#sendMsgMasivo',function(){
                    
					// inicio AJAX
		            $.ajax({
		                url: "<?php echo base_url('index.php/Dashboard/C_agregarChatMasivo/'); ?>",
		                type: "post",
		                data: { de:<?php echo $this->session->userdata('id_usuario'); ?>,
                                mensaje: $("input[name='mensaje']").val()},
		                beforeSend:function(){
		                    $("#cuadroMensaje").html('<div class="row">\
											    <div class="col-lg-1"></div>\
											    <div class="col-lg-10">\
											        <div class="card card-outline-info"><div class="card-body m-t-15">\
											                <center><i class="fa fa-spinner fa-pulse fa-3x fa-fw" aria-hidden="true"></i></center>\
											            </div>\
											        </div>\
											    </div>\
											</div>');
		                    
		                },success:function(data){
		                    $("#cuadroMensaje").html("");
		                    $("#cuadroMensaje").append($(data));
							$("input[name='mensaje']").val("");
		                  }
		             });
		            // fin ajax 
				});

				$('#textMessage').keypress(function(event){
					
					var keycode = (event.keyCode ? event.keyCode : event.which);
					if(keycode == '13'){
						event.preventDefault();
						// inicio AJAX
			            $.ajax({
			                url: "<?php echo base_url('index.php/Dashboard/C_agregarChatMasivo/'); ?>",
			                type: "post",
			                data: { de:<?php echo $this->session->userdata('id_usuario'); ?>,
	                                mensaje: $("input[name='mensaje']").val()},
			                beforeSend:function(){
			                    $("#cuadroMensaje").html('<div class="row">\
												    <div class="col-lg-1"></div>\
												    <div class="col-lg-10">\
												        <div class="card card-outline-info"><div class="card-body m-t-15">\
												                <center><i class="fa fa-spinner fa-pulse fa-3x fa-fw" aria-hidden="true"></i></center>\
												            </div>\
												        </div>\
												    </div>\
												</div>');
			                    
			                },success:function(data){
			                    $("#cuadroMensaje").html("");
			                    $("#cuadroMensaje").append($(data));
			                    $("input[name='mensaje']").val("");
			                  }
			             });
			            // fin ajax 
					}
					event.stopPropagation();
				});

		        // Obtención de coordenadas
		     
				
				
    </script>
       

          