
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

											
											<div class="col-md-4">
												
												<select id="selectUser"class="form-control">
													<option value="0">--- Club ---</option>
													<?php echo $selectUsers; ?>
												</select>
											</div>
											<div class="col-md-7">
												<h2><?php echo $Destinatario; ?></h2>
												<div id="cuadroMensaje" style="max-height: 300px; overflow-y: scroll;">
													<?php echo $msgBox; ?>
												</div>
												
												<hr>

												<?php if($showInput==1){ ?>
												<div class="form-group row">
	                                            
		                                            <div class="col-md-9">
		                                                <div class="btn-box input-group input-group-rounded">
		                                                	<input type="text" placeholder="Escribe un mensaje" id="textMessage" name="mensaje" class="form-control">
		                                                	<span class="input-group-btn">
		                                                		<button id="sendMsg" class="btn btn-primary btn-group-right" type="button">
		                                                			<i class="mdi mdi-send font-20" aria-hidden="true"></i>
		                                                		</button>
		                                                	</span>
		                                            	</div>
		                                            </div>
	                                        	</div>
	                                        <?php } ?>


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


				
				$("#selectUser").on('change',function(){
					var baseURL = "<?php echo base_url("index.php/Dashboard/inbox/"); ?>";
					window.location.replace(baseURL+$("#selectUser").val());
					//alert(baseURL+$("#selectUser").val());
				});

				$('.btn-box').on('click','#sendMsg',function(){
                    
					// inicio AJAX
		            $.ajax({
		                url: "<?php echo base_url('index.php/Dashboard/C_agregarChat/'); ?>",
		                type: "post",
		                data: { de:<?php echo $this->session->userdata('id_usuario'); ?>,
                                para: <?php echo $para; ?>,
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
		                    
		                    
							$('#cuadroMensaje').animate({
        						scrollTop: $('#cuadroMensaje')[0].scrollHeight},0);
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
			                url: "<?php echo base_url('index.php/Dashboard/C_agregarChat/'); ?>",
			                type: "post",
			                data: { de:<?php echo $this->session->userdata('id_usuario'); ?>,
	                                para: <?php echo $para; ?>,
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
			                    
			                    
								$('#cuadroMensaje').animate({
	        						scrollTop: $('#cuadroMensaje')[0].scrollHeight},0);
								$("input[name='mensaje']").val("");
			                  }
			             });
			            // fin ajax 
					}
					event.stopPropagation();
				});


				setInterval(function() {
				  $.ajax({
		                url: "<?php echo base_url('index.php/Dashboard/C_obtenerChat/1'); ?>",
		                type: "post",
		                data: { de:<?php echo $this->session->userdata('id_usuario'); ?>,
                                para: <?php echo $para; ?>
                                },
		                beforeSend:function(){
		                    
		                    
		                },success:function(data){
		                    $("#cuadroMensaje").html("");
		                    $("#cuadroMensaje").append($(data));
		                  }
		             });
				}, 1000);

		      
		        $(document).ready(function(){
		        	$('#cuadroMensaje').animate({
        				scrollTop: $('#cuadroMensaje')[0].scrollHeight}, 2000);
		        });
		        // Obtención de coordenadas
		     
				
				
    </script>
       

          