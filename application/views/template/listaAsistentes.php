<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 style="color:#ffffff;">Lista de asistentes</h3> </div>
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
                                <legend>Asistentes</legend>

                                <span id="success_message"></span>
                                <span id="critical_message"></span>
                                <form action="#" class="form-horizontal form-bordered">
                                    <div class="form-body">                                      
                                        
                                        
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Nombre Completo</label>
                                            <div class="col-md-9">
                                                <input type="text" name="nombreCompleto" class="form-control" placeholder="Nombre completo" required>
                                                <span id="nombreCompleto_error" class="text-danger"></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="control-label col-md-3">RUT</label>
                                            <div class="col-md-9">
                                                <input type="text" name="rut" class="form-control" placeholder="11111111-1" required>
                                                <span id="rut_error" class="text-danger"></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Fecha de Nacimiento</label>
                                            <div class="col-md-9">
                                                <input type="text" name="fecha_nacimiento" class="form-control" placeholder="31-12-1990" required>
                                                <span id="fecha_nacimiento" class="text-danger"></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Club</label>
                                            <div class="col-md-9">
                                                <input type="text" name="club" class="form-control" placeholder="Nombre del club" required>
                                                <span id="club_error" class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Teléfono</label>
                                            <div class="col-md-9">
                                                <input type="text" id="i-fono" name="fono" class="form-control" placeholder="9 1234 5678" maxlength="9" required>
                                                <span id="fono_error" class="text-danger"></span>
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="offset-sm-2 col-md-9">
                                                        <button type="button" id="registrarAsistente" class="btn btn-primary"> <i class="fa fa-check"></i> Registrar Asistente</button>
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
                            	<legend>Lista de Asistentes</legend>
                                <div class="table-responsive">
                                    <table class="table table-hover table-borderer table-condensed">
                                    	<thead>
                                    		<tr>
                                    			<th>#</th>
                                    			<th>Nombre completo</th>
                                    			<th>Rut</th>
                                    			<th>Edad</th>
                                                <th>Club</th>
                                    			<th>Teléfono</th>
                                    			<th colspan="2">Opciones</th>
                                    		</tr>
                                    	</thead>
                                    	<tbody id="cuerpo">
                                    		<?php 
                                    		if(isset($tabla_Asistentes)){
                                    			echo $tabla_Asistentes;
                                    		}?>
                                    	</tbody>
                                    	
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

				
				

			<script src="<?php echo base_url('assets/js/lib/jquery/jquery.min.js');?>"></script>
            <script type="text/javascript">


				$('#registrarAsistente').on('click',function(){

					var Nombre   = $("input[name='nombreCompleto']").val();
					var Rut      = $("input[name='rut']").val();
					var Fecha = $("input[name='fecha_nacimiento']").val();
					var Club     = $("input[name='club']").val();
					var Telefono = $("input[name='fono']").val();


					// inicio AJAX
		            $.ajax({
		                url: "<?php echo base_url('index.php/Dashboard/C_guardarAsistente/'); ?>",
		                type: "post",
		                data: { nombre:Nombre
		                	   ,rut:Rut
		                	   ,fecha_nacimiento:Fecha
		                	   ,club:Club
		                	   ,telefono:Telefono},
		                beforeSend:function(){
                            $('#registrarAsistente').attr('disabled', 'disabled');
		                    $("#cuerpo").html('<div class="row">\
											    <div class="col-lg-1"></div>\
											    <div class="col-lg-10">\
											        <div class="card card-outline-info"><div class="card-body m-t-15">\
											                <center><i class="fa fa-spinner fa-pulse fa-3x fa-fw" aria-hidden="true"></i></center>\
											            </div>\
											        </div>\
											    </div>\
											</div>');
		                    
                        },
                        success:function(data){
                            console.log(data);
                            console.log(data.nombreCompleto_error);
                            if (data.success) {
                                $('#success_message').html(data.success);
                                $("input[name='nombreCompleto']").val("");
                                $("input[name='rut']").val("");
                                $("input[name='fecha_nacimiento']").val("");
                                $("input[name='club']").val("");
                                $("input[name='fono']").val("");
                            }
                            if (data.error) {
                                if(data.nombreCompleto_error != '') {
                                    $('#nombreCompleto_error').html(data.nombreCompleto_error);
                                } else {
                                    $('#nombreCompleto_error').html('');
                                }
                                if(data.rut_error != '') {
                                    $('#rut_error').html(data.rut_error);
                                } else {
                                    $('#rut_error').html('');
                                }
                                if(data.fecha_nacimiento_error != '') {
                                    $('#fecha_nacimiento_error').html(data.fecha_nacimiento_error);
                                } else {
                                    $('#fecha_nacimiento_error').html('');
                                }
                                if(data.club_error != '') {
                                    $('#club_error').html(data.club_error);
                                } else {
                                    $('#club_error').html('');
                                }
                                if(data.fono_error != '') {
                                    $('#fono_error').html(data.fono_error);
                                } else {
                                    $('#fono_error').html('');
                                }
                            }
                            if (data.critical) {
                                $('#critical_message').html(data.critical);
                            }
                            if (data.lista) {
                                $("#cuerpo").html(data.lista);
                            } else {
                                $("#cuerpo").html("");
                            }

                            $('#registrarAsistente').attr('disabled', false);
		                  }
		             });
		            // fin ajax 
					
					
				});

				$('#cuerpo').on('click','.b_borrar',function(){
					// inicio AJAX
		            $.ajax({
		                url: "<?php echo base_url('index.php/Dashboard/C_borrarAsistente/'); ?>",
		                type: "post",
		                data: { id_asistente:$(this).val()},
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
		        $(document).ready(function () {
                    (function ($) {
                        $.fn.inputFilter = function (inputFilter) {
                        return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function () {
                            if (inputFilter(this.value)) {
                            this.oldValue = this.value;
                            this.oldSelectionStart = this.selectionStart;
                            this.oldSelectionEnd = this.selectionEnd;
                            } else if (this.hasOwnProperty("oldValue")) {
                            this.value = this.oldValue;
                            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                            }
                        });
                        };
                    })(jQuery);

                    // Restrict input to digits by using a regular expression filter.
                    $("#i-fono").inputFilter(function (value) {
                        return /^\d*$/.test(value);
                    });
                });		
    </script>
