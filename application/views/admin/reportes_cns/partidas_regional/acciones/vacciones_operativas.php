<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->
        <title><?php echo $this->session->userdata('name')?></title>
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <!-- Basic Styles -->
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css">
        <!-- SmartAdmin Styles : Please note (smartadmin-production.css) was created using LESS variables -->
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/css/smartadmin-production.min.css"> 
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/css/smartadmin-skins.min.css">
        <!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/css/demo.min.css">
        <!--estiloh-->
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/css/estilosh.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/themes_alerta/alertify.core.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/themes_alerta/alertify.default.css" id="toggleCSS" />
        <script src="<?php echo base_url(); ?>assets/lib_alerta/alertify.min.js"></script>  
        <meta name="viewport" content="width=device-width">
        <script type="text/javascript">
          function abreVentana(PDF){             
              var direccion;
              direccion = '' + PDF;
              window.open(direccion, "Cuadro Comparativo" , "width=600,height=400,scrollbars=NO") ; 
          }
        </script>
        <style>
            .table1{
              display: inline-block;
              width:100%;
              max-width:1550px;
              overflow-x: scroll;
            }
            table{font-size: 10px;
            width: 100%;
            max-width:1550px;;
            overflow-x: scroll;
            }
            th{
              padding: 1.4px;
              text-align: center;
              font-size: 10px;
              color: #ffffff;
            }
            </style>
    </head>
    <body class="">
        <!-- possible classes: minified, fixed-ribbon, fixed-header, fixed-width-->
        <!-- HEADER -->
        <header id="header">
            <div class="pull-right">
                <div id="hide-menu" class="btn-header pull-right">
                    <span> <a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
                </div>
                <div id="logout" class="btn-header transparent pull-right">
                    <span> <a href="<?php echo base_url(); ?>index.php/admin/logout" title="Sign Out" data-action="userLogout" data-logout-msg="Estas seguro de salir del sistema"><i class="fa fa-sign-out"></i></a> </span>
                </div>
                <div id="search-mobile" class="btn-header transparent pull-right">
                    <span> <a href="javascript:void(0)" title="Search"><i class="fa fa-search"></i></a> </span>
                </div>
                <div id="fullscreen" class="btn-header transparent pull-right">
                    <span> <a href="javascript:void(0);" data-action="launchFullscreen" title="Full Screen"><i class="fa fa-arrows-alt"></i></a> </span>
                </div>
            </div>
        </header>
        <!-- END HEADER -->
        <!-- Left panel : Navigation area -->
        <aside id="left-panel">
            <!-- User info -->
            <div class="login-info">
                <span> <!-- User image size is adjusted inside CSS, it should stay as is --> 
                    <a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
                            <span>
                                <i class="fa fa-user" aria-hidden="true"></i>  <?php echo $this->session->userdata("user_name");?>
                            </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                </span>
            </div>
            <nav>
                <ul>
                    <li class="">
                    <a href="<?php echo site_url("admin") . '/dashboard'; ?>" title="MEN?? PRINCIPAL"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">MEN&Uacute; PRINCIPAL</span></a>
                    </li>
                    <li class="text-center">
                        <a href="#" title="REPORTES"> <span class="menu-item-parent">REPORTES</span></a>
                    </li>
                    <?php echo $menu;?>
                </ul>
            </nav>
            <span class="minifyme" data-action="minifyMenu"> <i class="fa fa-arrow-circle-left hit"></i> </span>
        </aside>

        <!-- MAIN PANEL -->
        <div id="main" role="main">
            <!-- RIBBON -->
            <div id="ribbon">
                <span class="ribbon-button-alignment"> 
                    <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
                        <i class="fa fa-refresh"></i>
                    </span> 
                </span>
                <!-- breadcrumb -->
                <ol class="breadcrumb">
                    <li>Reportes</li><li>Partidas</li><li>Cuadro Comparativo por Partidas a Nivel de Unidades Organizacionales</li>
                </ol>
            </div>
            <!-- MAIN CONTENT -->
            <div id="content">
                <div class="row">
                    <nav role="navigation" class="navbar navbar-default navbar-inverse">
                        <div class="navbar-header">
                            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                 
                        <div id="navbarCollapse" class="collapse navbar-collapse">
                            <ul class="nav navbar-nav">
                                <li><a href="<?php echo site_url("").'/rep/rpartidas/'.$regional[0]['dep_id'].'';?>" title="INSTITUCIONAL REGIONAL"> INSTITUCIONAL REGIONAL</a></li>
                                <li><a href='#' data-toggle="modal" data-target="#exampleModalPrograma" title="PROGRAMAS"> PROGRAMAS</a></li>
                                <li class="active"><a href='#' title="ACCIONES DEL PROGRAMA : <?php echo $programa[0]['aper_programa'].' '.$programa[0]['aper_proyecto'].' '.$programa[0]['aper_actividad']; ?>"><i class="glyphicon glyphicon-ok"></i> UNIDAD ORGANIZACIONAL</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <!-- widget grid -->
                <section id="widget-grid" class="">
                    <div class="row">
                        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                            <section id="widget-grid" class="well">
                                <div class="">
                                    <h1>CUADRO COMPARATIVO POR PARTIDAS A NIVEL DE UNIDADES ORGANIZACIONALES - <?php echo strtoupper($regional[0]['dep_departamento']);?></h1>
                                </div>
                            </section>
                        </article>
                        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                            <section id="widget-grid" class="well">
                              <center>
                                <div class="dropdown">
                                <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true" style="width:100%;">
                                  OPCIONES
                                  <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                  <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url().'index.php/rep/programas/'.$programa[0]['aper_id'] ?>" title="VOLVER AL CUADRO COMPARATIVO DEL PROGRAMA <?php echo $programa[0]['aper_programa'].' '.$programa[0]['aper_proyecto'].' '.$programa[0]['aper_actividad'].' - '.$programa[0]['aper_descripcion']; ?>">VOLVER ATRAS</a></li>
                                </ul>
                              </div>
                              </center>
                            </section>
                        </article>
                    </div>
                    <div class="row">
                        
                        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="well well-sm well-light">
                                <h2 class="alert alert-info"><center><?php echo $programa[0]['aper_programa'].' '.$programa[0]['aper_proyecto'].' '.$programa[0]['aper_actividad'].' - '.$programa[0]['aper_descripcion']; ?></center></h2>
                                <div id="tabs">
                                    <ul>
                                        <li>
                                            <a href="#tabs-c">OPERACI&Oacute;N DE FUNCIONAMIENTO</a>
                                        </li>
                                        <li>
                                            <a href="#tabs-a">PROYECTOS DE INVERSI&Oacute;N PUBLICA</a>
                                        </li>
                                    </ul>
                                    <div id="tabs-a">
                                        <div class="row">
                                            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="jarviswidget jarviswidget-color-darken" >
                                              <header>
                                                  <span class="widget-icon"> <i class="fa fa-arrows-v"></i> </span>
                                                  <h2 class="font-md"><strong>PROYECTOS DE INVERSI&Oacute;N PUBLICA </strong></h2>  
                                              </header>
                                                <div>
                                                    <div class="widget-body no-padding">
                                                        <table id="dt_basic" class="table table-bordered" style="width:100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width:2%;" bgcolor="#474544"></th>
                                                                    <th style="width:2%;" bgcolor="#474544"></th>
                                                                    <th style="width:2%;" bgcolor="#474544"></th>
                                                                    <th style="width:10%;" bgcolor="#474544" title="APERTURA PROGRAM&Aacute;TICA">CATEGORIA PROGRAM&Aacute;TICA <?php echo $this->session->userdata("gestion");?></th>
                                                                    <th style="width:20%;" bgcolor="#474544" title="DESCRIPCI&Oacute;N">DESCRIPCI&Oacute;N</th>
                                                                    <th style="width:15%;" bgcolor="#474544" title="NIVEL">ESCALON</th>
                                                                    <th style="width:15%;" bgcolor="#474544" title="NIVEL">NIVEL</th>
                                                                    <th style="width:15%;" bgcolor="#474544" title="TIPO DE ADMINISTRACI??N">TIPO DE ADMINISTRACI&Oacute;N</th>
                                                                    <th style="width:10%;" bgcolor="#474544" title="UNIDAD ADMINISTRATIVA">UNIDAD ADMINISTRATIVA</th>
                                                                    <th style="width:10%;" bgcolor="#474544" title="UNIDAD EJECUTORA">UNIDAD EJECUTORA</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php echo $proyectos;?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!-- end widget content -->
                                                </div>
                                                <!-- end widget div -->
                                            </div>
                                            <!-- end widget -->
                                            </article>
                                        </div>
                                    </div>

                                    <div id="tabs-c">
                                        <div class="row">
                                            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="jarviswidget jarviswidget-color-darken" >
                                              <header>
                                                  <span class="widget-icon"> <i class="fa fa-arrows-v"></i> </span>
                                                  <h2 class="font-md"><strong>OPERACI&Oacute;N FUNCIONAMIENTO</strong></h2>  
                                              </header>
                                                <div>
                                                    <div class="widget-body no-padding">
                                                        <table id="dt_basic3" class="table1 table-bordered" style="width:100%;">
                                                            <thead>
                                                                <tr height="50">
                                                                    <th style="width:1%;" bgcolor="#474544"></th>
                                                                    <th style="width:1%;" bgcolor="#474544"></th>
                                                                    <th style="width:1%;" bgcolor="#474544"></th>
                                                                    <th style="width:10%;" bgcolor="#474544" title="APERTURA PROGRAM&Aacute;TICA">CATEGORIA PROGRAM&Aacute;TICA <?php echo $this->session->userdata("gestion");?></th>
                                                                    <th style="width:20%;" bgcolor="#474544" title="DESCRIPCI&Oacute;N">DESCRIPCI&Oacute;N</th>
                                                                    <th style="width:10%;" bgcolor="#474544" title="NIVEL">ESCALON</th>
                                                                    <th style="width:10%;" bgcolor="#474544" title="NIVEL">NIVEL</th>
                                                                    <th style="width:15%;" bgcolor="#474544" title="TIPO DE ADMINISTRACI??N">TIPO DE ADMINISTRACI&Oacute;N</th>
                                                                    <th style="width:10%;" bgcolor="#474544" title="UNIDAD ADMINISTRATIVA">UNIDAD ADMINISTRATIVA</th>
                                                                    <th style="width:10%;" bgcolor="#474544" title="UNIDAD EJECUTORA">UNIDAD EJECUTORA</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php echo $operacion;?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!-- end widget content -->
                                                </div>
                                                <!-- end widget div -->
                                            </div>
                                            <!-- end widget -->
                                            </article>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>  
                    </div>
                </section>
            </div>
            <!-- END MAIN CONTENT -->
        </div>
        <!-- END MAIN PANEL -->
    </div>
    <!-- ========================================= -->
        <!-- PAGE FOOTER -->
        <div class="page-footer">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <span class="txt-color-white"><?php echo $this->session->userData('name').' @ '.$this->session->userData('gestion') ?></span>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalPrograma" tabindex="-1" role="dialog" aria-labelledby="exampleModalProgramaTitle" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">PROGRAMAS INSTITUCIONALES</h4>
                </div>
                <div class="modal-body">
                    <p><?php echo $programas; ?></p>
                </div>
            </div>
          </div>
        </div>

        <!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
        <script src="<?php echo base_url();?>/assets/js/libs/jquery-2.0.2.min.js"></script>
        <script>
            if (!window.jQuery.ui) {
                document.write('<script src="<?php echo base_url();?>/assets/js/libs/jquery-ui-1.10.3.min.js"><\/script>');
            }
        </script>
        <!-- IMPORTANT: APP CONFIG -->
        <script src="<?php echo base_url(); ?>assets/js/session_time/jquery-idletimer.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/app.config.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/mis_js/validacion_form.js"></script>
        <!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
        <script src="<?php echo base_url(); ?>assets/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> 
        <!-- BOOTSTRAP JS -->
        <script src="<?php echo base_url(); ?>assets/js/bootstrap/bootstrap.min.js"></script>
        <!-- CUSTOM NOTIFICATION -->
        <script src="<?php echo base_url(); ?>assets/js/notification/SmartNotification.min.js"></script>
        <!-- JARVIS WIDGETS -->
        <script src="<?php echo base_url(); ?>assets/js/smartwidgets/jarvis.widget.min.js"></script>
        <!-- EASY PIE CHARTS -->
        <script src="<?php echo base_url(); ?>assets/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>
        <!-- SPARKLINES -->
        <script src="<?php echo base_url(); ?>assets/js/plugin/sparkline/jquery.sparkline.min.js"></script>
        <!-- JQUERY VALIDATE -->
        <script src="<?php echo base_url(); ?>assets/js/plugin/jquery-validate/jquery.validate.min.js"></script>
        <!-- JQUERY MASKED INPUT -->
        <script src="<?php echo base_url(); ?>assets/js/plugin/masked-input/jquery.maskedinput.min.js"></script>
        <!-- JQUERY SELECT2 INPUT -->
        <script src="<?php echo base_url(); ?>assets/js/plugin/select2/select2.min.js"></script>
        <!-- JQUERY UI + Bootstrap Slider -->
        <script src="<?php echo base_url(); ?>assets/js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script>
        <!-- browser msie issue fix -->
        <script src="<?php echo base_url(); ?>assets/js/plugin/msie-fix/jquery.mb.browser.min.js"></script>
        <!-- FastClick: For mobile devices -->
        <script src="<?php echo base_url(); ?>assets/js/plugin/fastclick/fastclick.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/lib_alerta/alertify.min.js"></script>
        <!-- Demo purpose only -->
        <script src="<?php echo base_url(); ?>assets/js/demo.min.js"></script>
        <!-- MAIN APP JS FILE -->
        <script src="<?php echo base_url(); ?>assets/js/app.min.js"></script>
        <!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->
        <script src="<?php echo base_url(); ?>assets/js/speech/voicecommand.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/lib_alerta/alertify.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/plugin/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/plugin/datatables/dataTables.colVis.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/plugin/datatables/dataTables.tableTools.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
        <script type="text/javascript">
        // DO NOT REMOVE : GLOBAL FUNCTIONS!
        $(document).ready(function() {
            pageSetUp();
            $("#menu").menu();
            $('.ui-dialog :button').blur();
            $('#tabs').tabs();
        })
        </script>
        <script src = "<?php echo base_url(); ?>mis_js/programacion/programacion/tablas.js"></script>
    </body>
</html>
