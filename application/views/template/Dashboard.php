<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 style="color:#ffffff;">Bitácora de mi viaje</h3> </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <!-- Row -->
            
            	<?php if($this->session->userdata('id_usuario')!=1){ ?>
                <!-- Row -->
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <div class="card card-outline-info">
                            
                            <div class="card-body m-t-15">
                            	<div class="alert alert-info">
                                        Recuerda actualizar el estado de tu viaje en cada parada que realicen <a href="<?php echo base_url('Dashboard/infoViaje'); ?>" class="alert-link">en este link</a>.
                                    </div>
                                <form action="#" class="form-horizontal form-bordered">
                                    <div class="form-body">                                      
                                        
                                        
                                        <div class="form-group row">
                                            <label class="control-label col-md-2">Lugar</label>
                                            <div class="col-md-10">
                                                <input type="text" name="lugar" class="form-control" placeholder="¿Dónde estás?" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-2">Mensaje</label>
                                            <div class="col-md-10">
                                                <textarea name="mensaje" style="height: auto;"class="form-control" rows="6" placeholder="Escribe tu mensaje..." required></textarea>
                                            </div>
                                        </div>
                                        <input type="hidden" name="latitud" value="">
                                        <input type="hidden" name="longitud" value="">
                                        
                                        
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="offset-sm-2 col-md-9">
                                                        <button type="button" id="enviarMensaje" class="btn btn-primary"> <i class="fa fa-check"></i> Enviar Mensaje</button>
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
            <?php } 
            else{ ?>
            	<!-- ZONA ADMINISTRADOR -->
            	<div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <div class="card card-outline-info">
                            
                            <div class="card-body m-t-15">
                                <form action="#" class="form-horizontal form-bordered">
                                    <div class="form-body">                                      
                                        
                                        
                                        <div class="form-group row">
                                            <label class="control-label col-md-2">Delegación</label>
                                            <div class="col-md-10">
                                                <select id="S_Delegaciones" class="form-control">
                                                	<option value="0">-- Seleccionar Delegación --</option>
                                                	<?php if(isset($selectDelegaciones)){echo $selectDelegaciones;} ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            	<!-- FIN ZONA ADMINISTRADOR -->
            	
            <?php } ?>

				<div id="Hitos"></div>

			<script src="<?php echo base_url('assets/js/lib/jquery/jquery.min.js');?>"></script>
            <script type="text/javascript">

            	// Funciones ADMINISTRADOR
            	
            	$("#S_Delegaciones").on("change",function(){
            		var id_delegacion = $("#S_Delegaciones").val();
            		


		        	// inicio AJAX
		            $.ajax({
		                url: "<?php echo base_url('index.php/Dashboard/C_obtenerHitos/1/'); ?>"+id_delegacion,
		                type: "post",

		                beforeSend:function(){
		                    $("#Hitos").html('<div class="row">\
											    <div class="col-lg-1"></div>\
											    <div class="col-lg-10">\
											        <div class="card card-outline-info"><div class="card-body m-t-15">\
											                <center><i class="fa fa-spinner fa-pulse fa-3x fa-fw" aria-hidden="true"></i></center>\
											            </div>\
											        </div>\
											    </div>\
											</div>');

		                    
		                },success:function(data){
		                     $("#Hitos").html(data); 

		                  }
		             });
		            // fin ajax 




            	});
            	// Fin funciones ADMINISTRADOR


				$('#enviarMensaje').on('click',function(){
					var lugar = $("input[name='lugar']").val();
					var mensaje = $("textarea[name='mensaje']").val();
					
					actualizarHitos(lugar,mensaje);
				});

		        function actualizarHitos(lugar,mensaje){

		            $("#Hitos").html(""); 
		            navigator.geolocation.getCurrentPosition(showPosition,showError);
		            var lat = $("input[name='latitud']").val();
				  	var lon = $("input[name='longitud']").val();
		           
		            // inicio AJAX
		            $.ajax({
		                url: "<?php echo base_url('index.php/Dashboard/C_guardarHito/'); ?>",
		                type: "post",
		                data: { lugar:lugar,mensaje:mensaje,latitud:lat,longitud:lon},
		                beforeSend:function(){
		                    $("#Hitos").html('<div class="row">\
											    <div class="col-lg-1"></div>\
											    <div class="col-lg-10">\
											        <div class="card card-outline-info"><div class="card-body m-t-15">\
											                <center><i class="fa fa-spinner fa-pulse fa-3x fa-fw" aria-hidden="true"></i></center>\
											            </div>\
											        </div>\
											    </div>\
											</div>');
		                    
		                },success:function(data){
		                     $("input[name='lugar']").val("");
		                     $("textarea[name='mensaje']").val("");

		                     $("#Hitos").html(data); 

		                  }
		             });
		            // fin ajax  
		        }

		        function recargarHitos(){
		        	// inicio AJAX
		            $.ajax({
		                url: "<?php echo base_url('index.php/Dashboard/C_obtenerHitos/1'); ?>",
		                type: "post",

		                beforeSend:function(){
		                    $("#Hitos").html('<div class="row">\
											    <div class="col-lg-1"></div>\
											    <div class="col-lg-10">\
											        <div class="card card-outline-info"><div class="card-body m-t-15">\
											                <center><i class="fa fa-spinner fa-pulse fa-3x fa-fw" aria-hidden="true"></i></center>\
											            </div>\
											        </div>\
											    </div>\
											</div>');

		                    
		                },success:function(data){
		                     $("#Hitos").html(data); 

		                  }
		             });
		            // fin ajax 

		        }
		        $(document).ready(function(){
		        	// Obtener GeoPosición
		            if (navigator.geolocation){
					   console.log("Tu dispositivo soporta la geolocalización.");
					   navigator.geolocation.getCurrentPosition(showPosition,showError);
					}
					else {
					   console.log("Lo sentimos, tu dispositivo no admite la geolocaización.");
					}
		        	recargarHitos();
		        });
		        // Obtención de coordenadas
		     
				function showPosition(position){
				  latitud=position.coords.latitude;
				  longitud=position.coords.longitude;
				  $("input[name='latitud']").val(latitud);
				  $("input[name='longitud']").val(longitud);
				}
				function showError(error){
				  switch(error.code) {
				    case error.PERMISSION_DENIED:
				      console.log("El usuario ha denegado el permiso a la localización.");
				      break;
				    case error.POSITION_UNAVAILABLE:
				      console.log("La información de la localización no está disponible.");
				      break;
				    case error.TIMEOUT:
				      console.log("El tiempo de espera para buscar la localización ha expirado.");
				      break;
				    case error.UNKNOWN_ERROR:
				      console.log("Ha ocurrido un error desconocido.");
				      break;
				    }
				  }
    </script>
          