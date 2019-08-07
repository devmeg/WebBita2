<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 style="color:#ffffff;">Información del viaje</h3> </div>
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
                            	<legend>Información</legend>
                                <form action="#" class="form-horizontal form-bordered">
                                    <div class="form-body">                                      
                                        
                                        
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Estado del viaje</label>
                                            <div class="col-md-9">
                                                <select name="estado" class="form-control">
                                                    <?php echo $select_estados; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Itinerario</label>
                                            <div class="col-md-9">
                                                <textarea name="itinerario" class="form-control" style="height: auto;" cols="30" rows="6"><?php echo $itinerario; ?></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Información adicional</label>
                                            <div class="col-md-9">
                                                <textarea name="infoExtra" class="form-control" style="height: auto;" cols="30" rows="6"><?php echo $infoExtra; ?></textarea>
                                            </div>
                                        </div>

                                        
                                        
                                        
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="offset-sm-2 col-md-9">
                                                        <button type="button" id="ActualizarInformacion" class="btn btn-primary"> <i class="fa fa-check"></i> Actualizar Información</button>
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


                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <div class="card card-outline-info">
                            
                            <div class="card-body m-t-15">
                            	<legend>Historial de estados</legend>
                                <table class="table table-hover table-borderer table-condensed">
                                	<thead>
                                		<tr>
                                			<th>#</th>
                                			<th>Fecha</th>
                                			<th>Estado</th>
                                		</tr>
                                	</thead>
                                	<tbody id="cuerpo">
                                		<?php echo $tabla_Historial; ?>
                                	</tbody>
                                	
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

				
				

			<script src="<?php echo base_url('assets/js/lib/jquery/jquery.min.js');?>"></script>
            <script type="text/javascript">


				

				$('.form-actions').on('click','#ActualizarInformacion',function(){
                    
					// inicio AJAX
		            $.ajax({
		                url: "<?php echo base_url('index.php/Dashboard/C_actualizarEstado/'); ?>",
		                type: "post",
		                data: { itinerario:$("textarea[name='itinerario']").val(),
                                infoExtra: $("textarea[name='infoExtra']").val(),
                                id_estado: $("select[name='estado']").val()},
		                beforeSend:function(){
		                    $("#cuerpo").html('<div class="row">\
											    <div class="col-lg-1"></div>\
											    <div class="col-lg-10">\
											        <div class="card card-outline-info"><div class="card-body m-t-15">\
											                <center><i class="fa fa-spinner fa-pulse fa-3x fa-fw" aria-hidden="true"></i></center>\
											            </div>\
											        </div>\
											    </div>\
											</div>');
		                    
		                },success:function(data){
		                    $("#cuerpo").html("");
		                    $("#cuerpo").append($(data));

		                  }
		             });
		            // fin ajax 
				});


		      
		        $(document).ready(function(){
		        	
		        });
		        // Obtención de coordenadas
		     
				
				
    </script>
          