<?php 

if (!$this->session->userdata('usuario')) {
    redirect(base_url(),'refresh');
}

 ?>
<!DOCTYPE html>
<html lang="es-ES">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('assets/images/favicon.png');?>">
    <title>Hitos por delegaciones</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url('assets/css/lib/bootstrap/bootstrap.min.css');?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url('assets/css/helper.css');?>" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url('assets/css/style.css');?>" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
    <!--[if lt IE 9]>
    <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
   
</head>

<body class="fix-header fix-sidebar">
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- Main wrapper  -->
    <div id="main-wrapper">
        <!-- header header  -->
        <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- Logo -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?php echo base_url('index.php/'); ?>">
                        <!-- Logo icon -->
                        <b>Viajes UNAB</b>
                        <img src="<?php echo base_url('assets/images/logo-campori.png');?>" alt="">
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span></span>
                    </a>
                </div>
                <!-- End Logo -->
                <div class="navbar-collapse">
                    <!-- toggle and nav items -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <h4></h4>
                        
                       
                    </ul>
                    <!-- User profile and search -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- Messages -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted  " href="#" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-envelope"></i>
								<?php 
                                    if ($mensajesNuevos>0) {
                                 ?>
                                <div class="notify"> 
                                    <span class="heartbit"></span> <span class="point"></span>
                                </div>
                            <?php } ?>
							</a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated zoomIn" aria-labelledby="2">
                                <ul>
                                    <li>
                                        <div class="drop-title">Tienes <?php echo $mensajesNuevos; ?> mensajes nuevos</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <?php 
                                                if ($mensajes != "") {
                                                    echo $mensajes;
                                                }
                                             ?>
                                            
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="<?php echo base_url('index.php/Dashboard/inbox'); ?>"> <strong>Ver todos los mensajes</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- End Messages -->
                   
                        <!-- Profile -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bars" aria-hidden="true"></i></a>
                            <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                <ul class="dropdown-user">
                                    <li><a href="<?php echo base_url('index.php/Dashboard'); ?>"><i class="fa fa-plus"></i> Registrar Hito</a></li>
                                    <li><a href="<?php echo base_url('index.php/Dashboard/rutaViaje'); ?>"><i class="fa fa-map-marker"></i> Ruta de viaje</a></li>
                                    <!-- <li><a href="#"><i class="ti-user"></i> Perfil</a></li> -->
                                    <li><a href="<?php echo base_url('index.php/Dashboard/listaAsistentes'); ?>"><i class="fa fa-users"></i> Asistentes</a></li>
                                    <li><a href="<?php echo base_url('index.php/Dashboard/infoViaje'); ?>"><i class="ti-wallet"></i> Itinerario</a></li>
                                    <li><a href="<?php echo base_url('index.php/Dashboard/inbox'); ?>"><i class="ti-email"></i> Mensajes</a></li>
                                    <?php if($this->session->userdata('id_usuario')==1){ ?>
                                    <li><a href="<?php echo base_url('index.php/Dashboard/inboxMasivo'); ?>"><i class="ti-email"></i> Mensajes Masivos</a></li>
                                    <?php } ?>  
                                    <li><a href="<?php echo base_url('index.php/Dashboard/logOut'); ?>"><i class="fa fa-power-off"></i> Salir</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- End header header -->
        <!-- Left Sidebar  -->
        
        <!-- End Left Sidebar  -->