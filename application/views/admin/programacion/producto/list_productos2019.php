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
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/css/estilosh.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/themes_alerta/alertify.core.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/themes_alerta/alertify.default.css" id="toggleCSS"/>
    <script src="<?php echo base_url(); ?>assets/lib_alerta/alertify.min.js"></script>
    <style type="text/css">
      aside{background: #05678B;}
      #mdialTamanio{
          width: 70% !important;
      }
      #mdialTamanio2{
          width: 45% !important;
      }
      table{font-size: 10px;
            width: 100%;
            max-width:1550px;;
            overflow-x: scroll;
            }
      input[type="checkbox"] {
          display:inline-block;
          width:28px;
          height:28px;
          margin:-1px 4px 0 0;
          vertical-align:middle;
          cursor:pointer;
      }
    th {font-size: 10px;     font-weight: normal;     padding: 8px;     background: #b3b0b0;
        border-top: 2px solid #b3b0b0;    border-bottom: 1px solid #fff; color: #404040; }

    td {    padding: 8px;     background: #f3f0f0;     border-bottom: 1px solid #fff;
        color: #404040;    border-top: 1px solid transparent; }

    tr:hover td { background: #d6d6d6; color: #339; }
            input[type="checkbox"] {
                display:inline-block;
                width:25px;
                height:25px;
                margin:-1px 4px 0 0;
                vertical-align:middle;
                cursor:pointer;
            }
    </style>
  </head>
  <body class="">
    <!-- possible classes: minified, fixed-ribbon, fixed-header, fixed-width-->
    <!-- HEADER -->
    <header id="header">
      <div id="logo-group">
        <!-- <span id="logo"> <img src="<?php echo base_url(); ?>assets/img/logo.png" alt="SmartAdmin"> </span> -->
      </div>
      <div class="col-md-4 " style="font-size:18px;margin-top:10px;margin-bottom:-10px;">
        <span>
          &nbsp;&nbsp;&nbsp; 
          <div class="badge bg-color-blue">
            <span style="font-size:15px;"><b>Fecha Sesi&oacute;n: <?php echo $this->session->userdata('desc_mes').' / '.$this->session->userdata('gestion');?></b></span>
          </div>
        </span>
        <div class="project-context hidden-xs">
          <span class="project-selector dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="font-size:19px;">
            <i class="fa fa-lg fa-fw fa-calendar txt-color-blue"></i>
          </span>
          <ul class="dropdown-menu">
            <li>
              <a href="<?php echo base_url();?>index.php/cambiar_gestion">Cambiar Gesti??n</a>
            </li>
          </ul>
        </div>
      </div>
      <!-- pulled right: nav area -->
      <div class="pull-right">
        <!-- collapse menu button -->
        <div id="hide-menu" class="btn-header pull-right">
          <span> <a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
        </div>
        <!-- end collapse menu -->
        <!-- logout button -->
        <div id="logout" class="btn-header transparent pull-right">
          <span> <a href="<?php echo base_url(); ?>index.php/admin/logout" title="Sign Out" data-action="userLogout" data-logout-msg="Estas seguro de salir del sistema"><i class="fa fa-sign-out"></i></a> </span>
        </div>
        <!-- end logout button -->
        <!-- search mobile button (this is hidden till mobile view port) -->
        <div id="search-mobile" class="btn-header transparent pull-right">
          <span> <a href="javascript:void(0)" title="Search"><i class="fa fa-search"></i></a> </span>
        </div>
        <!-- end search mobile button -->
        <!-- fullscreen button -->
        <div id="fullscreen" class="btn-header transparent pull-right">
          <span> <a href="javascript:void(0);" data-action="launchFullscreen" title="Full Screen"><i class="fa fa-arrows-alt"></i></a> </span>
        </div>
        <!-- end fullscreen button -->
      </div>
      <!-- end pulled right: nav area -->

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
          </a> 
        </span>
      </div>

      <?php echo $menu;?>
      <span class="minifyme" data-action="minifyMenu"> <i class="fa fa-arrow-circle-left hit"></i> </span>
    </aside>

    <!-- MAIN PANEL -->
    <div id="main" role="main">
      <!-- RIBBON -->
      <div id="ribbon">
        <!-- breadcrumb -->
          <ol class="breadcrumb">                         
               <li><a href="<?php echo base_url().'index.php/admin/proy/list_proy';?>" title="VOLVER A MI POA">Programaci&oacute;n POA</a></li><li>...</li><li>Mis Servicios</li><li>Mis Operaciones</li> 
          </ol>
      </div>
      <!-- END RIBBON -->
        <!-- MAIN CONTENT -->
        <div id="content">
          <div class="row">
            <article class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
              <section id="widget-grid" class="well">
                <ul class="nav nav-pills">
                  <li><a href="<?php echo base_url().'index.php/prog/list_serv/'.$fase[0]['proy_id'].'';?>">MIS SERVICIOS</a></li>
                  <li class="active"><a href="#">MIS OPERACIONES</a></li>
                </ul>
              </section>
            </article>
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
              <section id="widget-grid" class="well">
              <center>
                <div class="dropdown">
                  <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu1" style="width:80%;" data-toggle="dropdown" aria-expanded="true" style="width:100%;">
                    OPCIONES
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url().'index.php/admin/dashboard' ?>">SALIR A MENU PRINCIPAL</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url().'index.php/admin/proy/list_proy' ?>">MIS POAS</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href='<?php echo site_url("").'/prog/exportar_productos_req/'.$componente[0]['com_id']; ?>' title="EXPORTAR EN EXCEL LAS OPERACIONES QUE TIENEN REQUERIMIENTOS">EXPORTAR OPERACIONES-REQUERIMIENTOS</a></li>
                    <?php
                      if($saldo>50){ ?>
                        <li role="presentation" align="Left"><a role="menuitem" tabindex="-1" href="#" data-toggle="modal" data-target="#modal_nuevo_ff" class="btn btn-success" title="IMPORTAR ARCHIVO DE REQUERIMIENTOS">IMPORTAR REQUERIMIENTOS</a></li>
                      <?php
                      }
                    ?>
                  </ul>
                </div>
              </center>
              </section>
            </article>
          </div>

          <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <section id="widget-grid" class="well">
                <div class="">
                  <h1> <?php echo $proyecto[0]['establecimiento'];?> : <small><?php echo $proyecto[0]['aper_programa'].''.$proyecto[0]['aper_proyecto'].''.$proyecto[0]['aper_actividad'].' - '.$proyecto[0]['tipo'].' '.$proyecto[0]['act_descripcion'].' - '.$proyecto[0]['abrev']?></small></h1>
                  <?php echo $oregional;?>
                  <h1> SERVICIO : <small><?php echo $componente[0]['com_componente']; ?></small></h1>
                </div>
            </section>
          </article>
          
            <section id="widget-grid" class="">
            <div class="row">
              <!-- NEW WIDGET START -->
              <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php 
                  if($this->session->flashdata('success')){ ?>
                    <div class="alert alert-success">
                      <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php 
                  }
                  elseif($this->session->flashdata('danger')){ ?>
                    <div class="alert alert-danger">
                      <?php echo $this->session->flashdata('danger'); ?>
                    </div>
                    <?php
                  }

                  $attributes = array('id' => 'del_req','name' =>'del_req','enctype' => 'multipart/form-data');
                                echo validation_errors();
                                echo form_open('prog/delete_operaciones', $attributes);
                ?>
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget jarviswidget-color-darken" >
                  <header>
                      <span class="widget-icon"> <i class="fa fa-arrows-v"></i> </span>
                      <h2 class="font-md"><strong><?php echo count($productos);?> OPERACIONES REGISTRADOS</strong></h2>  
                  </header>
                  <div>
                    <div class="col-sm-1"><a href="#" data-toggle="modal" data-target="#modal_nuevo_form" class="btn btn-success nuevo_form" title="NUEVO REGISTRO" class="btn btn-success" style="width:100%;">NUEVO REGISTRO</a></div>
                    <b>BUSCAR OPERACI&Oacute;N : </b><input type="text" class="form-control" id="kwd_search" value="" style="width:50%;"/><br>
                    <div class="widget-body no-padding">
                      <form id="del_req" name="del_req" novalidate="novalidate" method="post">
                      <input type="hidden" name="proy_id" id="proy_id" value="<?php echo $fase[0]['proy_id']; ?>">
                      <input type="hidden" name="pfec_id" id="pfec_id" value="<?php echo $fase[0]['pfec_id']; ?>">
                      <input type="hidden" name="com_id" id="com_id" value="<?php echo $componente[0]['com_id']; ?>">
                      <div class="table-responsive">
                        <table id="table" class="table table-bordered" style="border-collapse:collapse" style="width:100%;">
                          <?php echo $prod; ?>
                        </table>
                      </div>
                      <input type="hidden" name="tot" id="tot" value="0">
                      <div class="alert alert-danger" align=right><input type="button" class="btn btn-danger btn-xs" value="ELIMINAR OPERACIONES" id="btsubmit" onclick="valida_eliminar()" title="ELIMINAR OPERACIONES"></div>
                      </form>
                    </div>
                    <!-- end widget content -->
                  </div>
                  <!-- end widget div -->
                </div>
                <!-- end widget -->
              </article>
              <!-- WIDGET END -->
            </div>
          </section>      
        <!--///////////fin de tabla///////-->
    </div>
    <!-- END MAIN CONTENT -->
</div>
<!-- END MAIN PANEL -->
<!-- PAGE FOOTER -->
<div class="page-footer">
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <span class="txt-color-white"><?php echo $this->session->userData('name').' @ '.$this->session->userData('gestion') ?></span>
        </div>
    </div>
</div>

  <!---------- MODAL NUEVO REGISTRO DE OPERACIONES ----------------->
  <div class="modal fade" id="modal_nuevo_form" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" id="mdialTamanio">
      <div class="modal-content">
          <div class="modal-header">
            <button class="close" data-dismiss="modal" id="amcl" title="SALIR"><span aria-hidden="true">&times; <b>Salir Formulario</b></span></button>
          </div>
          <div class="modal-body">
            <h2 class="alert alert-info"><center>NUEVA OPERACI&Oacute;N</center></h2>
              <form action="<?php echo site_url().'/programacion/producto/valida_producto'?>" id="form_nuevo" name="form_nuevo" class="smart-form" method="post">
                  <input type="hidden" name="com_id" id="com_id" value="<?php echo $componente[0]['com_id'];?>"> 
                  <input type="hidden" name="proy_id" id="proy_id" value="<?php echo $proyecto[0]['proy_id'];?>">
                  <header><b>DATOS GENERALES DE LA OPERACI&Oacute;N</b></header>
                  <fieldset>          
                    <div class="row">
                      <section class="col col-1">
                        <label class="label">C&Oacute;DIGO</label>
                        <label class="input">
                          <i class="icon-append fa fa-tag"></i>
                          <input type="text" name="cod" id="cod" value="0" title="CODIGO OPERACI&Oacute;N" onkeyup="verif_codigo()">
                        </label>
                      </section>
                      <section class="col col-5">
                        <label class="label">OPERACI&Oacute;N</label>
                        <label class="textarea">
                          <i class="icon-append fa fa-tag"></i>
                          <textarea rows="2" name="prod" id="prod" title="REGISTRAR OPERACI??N"></textarea>
                        </label>
                      </section>
                      <section class="col col-4">
                        <label class="label">RESULTADO</label>
                        <label class="textarea">
                          <i class="icon-append fa fa-tag"></i>
                          <textarea rows="2" name="resultado" id="resultado" title="REGISTRAR RESULTADO"></textarea>
                        </label>
                      </section>
                      <section class="col col-2">
                        <label class="label">TIPO DE INDICADOR</label>
                        <select class="form-control" id="tipo_i" name="tipo_i" title="SELECCIONE TIPO DE INDICADOR">
                            <option value="">Seleccione Tipo de Indicador</option>
                            <?php 
                              foreach($indi as $row){ ?>
                              <option value="<?php echo $row['indi_id'];?>"><?php echo $row['indi_descripcion'];?></option>
                            <?php } ?>        
                        </select>
                      </section>
                    </div>

                    <div class="row">
                      <section class="col col-6">
                        <label class="label">INDICADOR</label>
                        <label class="textarea">
                          <i class="icon-append fa fa-tag"></i>
                          <textarea rows="2" name="indicador" id="indicador" title="REGISTRE DESCRIPCI??N INDICADOR"></textarea>
                        </label>
                      </section>
                      <section class="col col-6">
                        <label class="label">MEDIO DE VERIFICACI&Oacute;N</label>
                        <label class="textarea">
                          <i class="icon-append fa fa-tag"></i>
                          <textarea rows="2" name="verificacion" id="verificacion" title="REGISTRE MEDIO DE VERIFICACI??N"></textarea>
                        </label>
                      </section>
                    </div>

                    <div class="row">
                      <section class="col col-3">
                        <label class="label">LINEA BASE</label>
                        <label class="input">
                          <i class="icon-append fa fa-tag"></i>
                          <input type="text" name="lbase" id="lbase" value="0" title="REGISTRE LINEA BASE" onkeyup="suma_programado()">
                        </label>
                      </section>
                      <section class="col col-3">
                        <label class="label">META</label>
                        <label class="input">
                          <i class="icon-append fa fa-tag"></i>
                          <input type="text" name="meta" id="meta" value="0" title="REGISTRE META">
                        </label>
                      </section>
                      <section class="col col-3">
                        <label class="label">PONDERACI&Oacute;N</label>
                        <label class="input">
                          <i class="icon-append fa fa-tag"></i>
                          <input type="text" name="pn_cion" id="pn_cion" value="0" value="0" title="REGISTRE PONDERACI&Oacute;N">
                        </label>
                      </section>
                    </div>
                    <header><b>ALINEACI&Oacute;N POA - PEI</b></header><br>
                    <div class="row">
                      <section class="col col-3">
                        <label class="label">OBJETIVO ESTRATEGICO</label>
                        <select class="form-control" id="obj_id" name="obj_id" title="SELECCIONE OBJETIVO ESTRATEGICO">
                          <option value="">Seleccione Objetivo Estrategico</option>
                            <?php 
                              foreach($oestrategicos as $row){ ?>
                                <option value="<?php echo $row['obj_id']; ?>"><?php echo $row['obj_codigo'].'.- '.$row['obj_descripcion']; ?></option>
                                <?php   
                              }
                            ?>
                        </select>
                      </section>
                      <section class="col col-3">
                        <label class="label">ACCI&Oacute;N ESTRATEGICA</label>
                        <select class="form-control" id="acc_id" name="acc_id" title="SELECCIONE ACCI??N ESTRATEGICA"></select>
                      </section>
                      <section class="col col-3">
                        <label class="label">INDICADOR PEI</label>
                        <select class="form-control" id="indi_pei" name="indi_pei" title="SELECCIONE INDICADOR PEI"></select>
                      </section>

                      <div id="trep" style="display:none;" >
                        <section class="col col-3">
                          <label class="label">TIPO DE META</label>
                            <select class="form-control" id="tp_met" name="tp_met" title="SELECCIONE TIPO DE META">
                              <option value="">Seleccione Tipo de Meta</option>
                                <?php 
                                  foreach($metas as $row){ 
                                    if($row['mt_id']==3){ ?>
                                      <option value="<?php echo $row['mt_id']; ?>" selected><?php echo $row['mt_tipo']; ?></option>
                                      <?php
                                    }
                                    else{ ?>
                                      <option value="<?php echo $row['mt_id']; ?>"><?php echo $row['mt_tipo']; ?></option>
                                      <?php
                                    }
                                  }
                                ?>
                          </select>
                        </section><br>  
                      </div>
                    </div>

                    <div id="atit"></div>
                    <header><b>TEMPORALIDAD PROGRAMACI&Oacute;N F??SICA : <?php echo $this->session->userdata('gestion')?></b><br>
                    <label class="label"><div id="ff"></div></label>
                    </header>
                    <br>
                    <div class="row">
                      <section class="col col-2">
                        <label class="label">PROGRAMADO TOTAL</label>
                        <label class="input">
                          <i class="icon-append fa fa-money"></i>
                          <input type="text" name="total" id="total" value="0" disabled="true">
                        </label>
                      </section>
                    </div>
                    <div class="row">
                      <section class="col col-2">
                        <label class="label">ENERO</label>
                        <label class="input">
                          <i class="icon-append fa fa-money"></i>
                          <input type="text" name="m1" id="m1" value="0" onkeyup="suma_programado()" onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }" onpaste="return false" required="true" title="PROGRAMACION FINANCIERA MES DE ENERO - <?php echo $this->session->userdata('gestion')?>">
                        </label>
                      </section>
                      <section class="col col-2">
                        <label class="label">FEBRERO</label>
                        <label class="input">
                          <i class="icon-append fa fa-money"></i>
                          <input type="text" name="m2" id="m2" value="0" onkeyup="suma_programado()" onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }" onpaste="return false" required="true" title="PROGRAMACION FINANCIERA MES DE FEBRERO - <?php echo $this->session->userdata('gestion')?>">
                        </label>
                      </section>
                      <section class="col col-2">
                        <label class="label">MARZO</label>
                        <label class="input">
                          <i class="icon-append fa fa-money"></i>
                          <input type="text" name="m3" id="m3" value="0" onkeyup="suma_programado()"onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }" onpaste="return false" required="true" title="PROGRAMACION FINANCIERA MES DE MARZO - <?php echo $this->session->userdata('gestion')?>">
                        </label>
                      </section>
                      <section class="col col-2">
                        <label class="label">ABRIL</label>
                        <label class="input">
                          <i class="icon-append fa fa-money"></i>
                          <input type="text" name="m4" id="m4" value="0" onkeyup="suma_programado()"onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }" onpaste="return false" required="true" title="PROGRAMACION FINANCIERA MES DE ABRIL - <?php echo $this->session->userdata('gestion')?>">
                        </label>
                      </section>
                      <section class="col col-2">
                        <label class="label">MAYO</label>
                        <label class="input">
                          <i class="icon-append fa fa-money"></i>
                          <input type="text" name="m5" id="m5" value="0" onkeyup="suma_programado()" onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }" onpaste="return false" required="true" title="PROGRAMACION FINANCIERA MES DE MAYO - <?php echo $this->session->userdata('gestion')?>">
                        </label>
                      </section>
                      <section class="col col-2">
                        <label class="label">JUNIO</label>
                        <label class="input">
                          <i class="icon-append fa fa-money"></i>
                          <input type="text" name="m6" id="m6" value="0" onkeyup="suma_programado()" onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }" onpaste="return false" required="true" title="PROGRAMACION FINANCIERA MES DE JUNIO - <?php echo $this->session->userdata('gestion')?>">
                        </label>
                      </section>
                    </div>
                    <div class="row">
                      <section class="col col-2">
                        <label class="label">JULIO</label>
                        <label class="input">
                          <i class="icon-append fa fa-money"></i>
                          <input type="text" name="m7" id="m7" value="0" onkeyup="suma_programado()" onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }" onpaste="return false" required="true" title="PROGRAMACION FINANCIERA MES DE JULIO - <?php echo $this->session->userdata('gestion')?>">
                        </label>
                      </section>
                      <section class="col col-2">
                        <label class="label">AGOSTO</label>
                        <label class="input">
                          <i class="icon-append fa fa-money"></i>
                          <input type="text" name="m8" id="m8" value="0" onkeyup="suma_programado()"onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }" onpaste="return false" required="true" title="PROGRAMACION FINANCIERA MES DE AGOSTO - <?php echo $this->session->userdata('gestion')?>">
                        </label>
                      </section>
                      <section class="col col-2">
                        <label class="label">SEPTIEMBRE</label>
                        <label class="input">
                          <i class="icon-append fa fa-money"></i>
                          <input type="text" name="m9" id="m9" value="0" onkeyup="suma_programado()" onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }" onpaste="return false" required="true" title="PROGRAMACION FINANCIERA MES DE SEPTIEMBRE - <?php echo $this->session->userdata('gestion')?>">
                        </label>
                      </section>
                      <section class="col col-2">
                        <label class="label">OCTUBRE</label>
                        <label class="input">
                          <i class="icon-append fa fa-money"></i>
                          <input type="text" name="m10" id="m10" value="0" onkeyup="suma_programado()"onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }" onpaste="return false" required="true" title="PROGRAMACION FINANCIERA MES DE OCTUBRE - <?php echo $this->session->userdata('gestion')?>">
                        </label>
                      </section>
                      <section class="col col-2">
                        <label class="label">NOVIEMBRE</label>
                        <label class="input">
                          <i class="icon-append fa fa-money"></i>
                          <input type="text" name="m11" id="m11" value="0" onkeyup="suma_programado()" onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }" onpaste="return false" required="true" title="PROGRAMACION FINANCIERA MES DE NOVIEMBRE - <?php echo $this->session->userdata('gestion')?>">
                        </label>
                      </section>
                      <section class="col col-2">
                        <label class="label">DICIEMBRE</label>
                        <label class="input">
                          <i class="icon-append fa fa-money"></i>
                          <input type="text" name="m12" id="m12" value="0" onkeyup="suma_programado()" onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }" onpaste="return false" required="true" title="PROGRAMACION FINANCIERA MES DE DICIEMBRE - <?php echo $this->session->userdata('gestion')?>">
                        </label>
                      </section>
                    </div>

                  </fieldset>
        
                  <div id="but" style="display:none;">
                    <footer>
                      <button type="button" name="subir_ope" id="subir_ope" class="btn btn-info" >GUARDAR OPERACI&Oacute;N</button>
                      <button class="btn btn-default" data-dismiss="modal" id="amcl" title="CANCELAR">CANCELAR</button>
                    </footer>
                    <div id="loadp" style="display: none" align="center">
                      <br><img  src="<?php echo base_url() ?>/assets/img_v1.1/preloader.gif" width="100"><br><b>GUARDANDO OPERACI&Oacute;N</b>
                    </div>
                  </div>
              </form>
              </div>
          </div>
      </div>
  </div>
  <!--  =====================================================  -->
  <!-- ================== MODAL SUBIR ARCHIVO ========================== -->
  <div class="modal animated fadeInDown" id="modal_nuevo_ff" tabindex="-1" role="dialog">
    <link href="<?php echo base_url(); ?>assets/file/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url(); ?>assets/file/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/file/js/fileinput.min.js" type="text/javascript"></script> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body no-padding">
                <div class="row">
                   <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row">
                        <h2 class="row-seperator-header"><i class="glyphicon glyphicon-import"></i> IMPORTAR REQUERIMIENTOS (.CSV) </h2>
                        <div class="col-sm-12">
                          <!-- well -->
                          <div class="well">
                            SALDO POR PROGRAMAR : <?php echo $saldo;?> Bs.
                            <!-- row -->
                            <div class="row">
                              <!-- col -->
                              <div class="col-sm-12">
                                <p class="alert alert-info">
                                  <i class="fa fa-info"></i> Por favor guardar el archivo (Excel.xls) a extension (.csv) delimitado por (; "Punto y comas"). verificar el archivo .csv para su correcta importaci&oacute;n
                                </p>
                                <!-- row -->
                                <div class="row">
                                  <form action="<?php echo site_url() . '/programacion/producto/importar_requerimientos_operaciones'?>" enctype="multipart/form-data" id="form_subir_sigep" name="form_subir_sigep" method="post">
                                      <input class="form-control" type="hidden" name="pfec_id" value="<?php echo $id_f[0]['id'];?>"> 
                                      <input class="form-control" type="hidden" name="proy_id" value="<?php echo $proyecto[0]['proy_id'];?>">
                                      <input class="form-control" type="hidden" name="com_id" value="<?php echo $componente[0]['com_id'];?>">
                                      <fieldset>
                                        <section class="form-group">
                                          <label class="label"><b>SUBIR ARCHIVO .CSV </b></label>
                                          <label class="input input-file">
                                                <span class="button">
                                                    <input id="archivo" accept=".csv" name="archivo" type="file" class="file">
                                                    <input name="MAX_FILE_SIZE" type="hidden" value="20000" />
                                              <b class="tooltip tooltip-top-left">
                                                  <i class="fa fa-warning txt-color-teal"></i> EL ARCHIVO A SUBIR, DEBE SER EXTENSION .CSV
                                              </b>
                                          </label>
                                        </section>
                                      </fieldset>
                                      <div >
                                        <button type="button" name="subir_archivo" id="subir_archivo" class="btn btn-success" style="width:100%;">SUBIR REQUERIMIENTOS .CSV</button>
                                        <center><img id="load" style="display: none" src="<?php echo base_url() ?>/assets/img/loading.gif" width="50" height="50"></center>
                                      </div>
                                  </form> 
                                </div>
                                <!-- end row -->
                              </div>
                              <!-- end col -->
                            </div>
                            <!-- end row -->
                          </div>
                          <!-- end well -->
                        </div>
                      </div>
                    </article>
                </div>   
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    <!--================================================== -->
<!-- END PAGE FOOTER -->
<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
<script data-pace-options='{ "restartOnRequestAfter": true }' src="<?php echo base_url(); ?>assets/js/plugin/pace/pace.min.js"></script>
<script>
    if (!window.jQuery) {
        document.write('<script src="<?php echo base_url(); ?>assets/js/libs/jquery-2.0.2.min.js"><\/script>');
    }
</script>
<script>
    if (!window.jQuery.ui) {
        document.write('<script src="<?php echo base_url(); ?>assets/js/libs/jquery-ui-1.10.3.min.js"><\/script>');
    }
</script>
<!-- IMPORTANT: APP CONFIG -->
<script src="<?php echo base_url(); ?>assets/js/app.config.js"></script>
<script src="<?php echo base_url(); ?>assets/js/session_time/jquery-idletimer.js"></script>
<!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
<script src="<?php echo base_url(); ?>assets/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script>
<!--tablas-->
<script src="<?php echo base_url(); ?>assets/js/tabla/jquery.dataTables.min.js"></script>
<!-- FastClick: For mobile devices -->
<script src="<?php echo base_url(); ?>assets/js/tabla/jquery-1.12.3.js"></script>
<!--fin tablas-->
<!-- BOOTSTRAP JS -->
<script src="<?php echo base_url(); ?>assets/js/bootstrap/bootstrap.min.js"></script>
<!-- CUSTOM NOTIFICATION -->
<script src="<?php echo base_url(); ?>assets/js/notification/SmartNotification.min.js"></script>
<!--  JARVIS WIDGETS -->
<script src="<?php echo base_url(); ?>assets/js/smartwidgets/jarvis.widget.min.js"></script>
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
<!-- Demo purpose only -->
<script src="<?php echo base_url(); ?>assets/js/demo.min.js"></script>
<!-- MAIN APP JS FILE -->
<script src="<?php echo base_url(); ?>assets/js/app.min.js"></script>
<!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->
<!-- Voice command : plugin -->
<script src="<?php echo base_url(); ?>assets/js/speech/voicecommand.min.js"></script>
<!-- ///// mis validaciones js ///// -->
<SCRIPT src="<?php echo base_url(); ?>assets/js/mis_js/validacion_form.js" type="text/javascript"></SCRIPT>
<!--alertas -->
<script src="<?php echo base_url(); ?>assets/lib_alerta/alertify.min.js"></script>
<!-- PAGE RELATED PLUGIN(S) -->
<script src="<?php echo base_url(); ?>assets/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
<script src = "<?php echo base_url(); ?>mis_js/programacion/programacion/tablas.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#tipo_i").change(function () {            
          var tp_id = $(this).val();
            if(tp_id==2){
              $('#trep').slideDown();
            }
            else{
              $('#trep').slideUp();
              for (var i = 1; i <= 12; i++) {
                  $('[name="m'+i+'"]').val((0).toFixed(0));
                  $("#m"+i).html('');
                  $('[name="m'+i+'"]').prop('disabled', false);
              }
              $('[name="total"]').val((0).toFixed(0));
              $('[name="tp_met"]').val((3).toFixed(0));
            }
          });
      });

      $(document).ready(function () {
        $("#tp_met").change(function () {            
          var tp_met = $(this).val();
            if(tp_met==1){
              meta = parseFloat($('[name="meta"]').val());
              for (var i = 1; i <= 12; i++) {
                $('[name="m'+i+'"]').val((meta).toFixed(0));
                $("#m"+i).html('%');
                $('[name="m'+i+'"]').prop('disabled', true);
              }
              $('[name="total"]').val((meta).toFixed(0));
            }
            else{
              for (var i = 1; i <= 12; i++) {
                $('[name="m'+i+'"]').val((0).toFixed(0));
                $("#m"+i).html('');
                $('[name="m'+i+'"]').prop('disabled', false);
              }
              $('[name="total"]').val((0).toFixed(0));
            }
          });
      });

      $(document).ready(function() {
        pageSetUp();
        $("#obj_id").change(function () {
            $("#obj_id option:selected").each(function () {
            elegido=$(this).val();
            $.post("<?php echo base_url(); ?>index.php/prog/combo_acciones", { elegido: elegido }, function(data){ 
              $("#acc_id").html(data);
              });     
          });
        });  
      })
      $("#acc_id").change(function () {
        $("#acc_id option:selected").each(function () {
          elegido=$(this).val();
            $.post("<?php echo base_url(); ?>index.php/prog/combo_indicadores", { elegido: elegido}, function(data){
              $("#indi_pei").html(data);
            });     
          });
      });
    </script>
    <script>
      function reset() {
        $("#toggleCSS").attr("href", "<?php echo base_url(); ?>assets/themes_alerta/alertify.default.css");
        alertify.set({
          labels: {
              ok: "ACEPTAR",
              cancel: "CANCELAR"
          },
          delay: 5000,
          buttonReverse: false,
          buttonFocus: "ok"
        });
    }
    </script>
    <script type="text/javascript">
    $(function () {
        $("#subir_ope").on("click", function () {
            var $validator = $("#form_nuevo").validate({
                rules: {
                  com_id: {
                    required: true,
                  },
                  cod: {
                      required: true,
                  },
                  prod: {
                      required: true,
                  },
                  resultado: {
                      required: true,
                  },
                  tipo_i: {
                      required: true,
                  },
                  indicador: {
                      required: true,
                  },
                  lbase: {
                      required: true,
                  },
                  meta: {
                      required: true,
                  },
                  obj_id: {
                      required: true,
                  },
                  acc_id: {
                      required: true,
                  },
                  indi_pei: {
                      required: true,
                  }
                },
                messages: {
                  cod: {required: "<font color=red size=1>REGISTRE C&Oacute;DIGO OPERACI&Oacute;N</font>"},
                  prod: {required: "<font color=red size=1>REGISTRE OPERACI&Oacute;N - PRODUCTO</font>"},
                  resultado: {required: "<font color=red size=1>REGISTRE RESULTADO</font>"},
                  tipo_i: {required: "<font color=red size=1>SELECCIONE UNIDAD EJECUTORA</font>"},
                  indicador: {required: "<font color=red size=1>REGISTRE INDICADOR</font>"},
                  lbase: {required: "<font color=red size=1>REGISTRE LINEA BASE</font>"},
                  meta: {required: "<font color=red size=1>REGISTRE META DE LA OPERACI&Oacute;N</font>"},
                  obj_id: {required: "<font color=red size=1>SELECCIONE OBJETIVO ESTRATEGICO</font>"},
                  acc_id: {required: "<font color=red size=1>SELECCIONE ACCI&Oacute;N DE MEDIANO PLAZO</font>"},
                  indi_pei: {required: "<font color=red size=1>SELECCIONE INDICADOR DE PROCESO</font>"}                    
                },
                highlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                },
                errorElement: 'span',
                errorClass: 'help-block',
                errorPlacement: function (error, element) {
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            var $valid = $("#form_nuevo").valid();
            if (!$valid) {
                $validator.focusInvalid();
            } else {
              if(document.form_nuevo.tipo_i.value==1){
                meta = parseFloat($('[name="meta"]').val());
                total = parseFloat($('[name="total"]').val());
                if(parseFloat(meta)!=parseFloat(total)){
                  alertify.error("LA SUMA DE MESES PROGRAMADOS NO ES IGUAL A LA META DE LA OPERACI&Oacute;N") 
                    document.form_nuevo.meta.focus() 
                    return 0; 
                }
              } 
              else{
                if(document.form_nuevo.tp_met.value==0){
                  alertify.error("SELECCIONE TIPO DE META") 
                    document.form_nuevo.resultado.focus() 
                    return 0; 
                }
                if(document.form_nuevo.tipo_i.value==2){
                  if(document.form_nuevo.tp_met.value==3){
                    meta = parseFloat($('[name="meta"]').val());
                    total = parseFloat($('[name="total"]').val());
                    if(parseFloat(meta)!=parseFloat(total)){
                      alertify.error("LA SUMA DE MESES PROGRAMADOS NO ES IGUAL A LA META DE LA OPERACI&Oacute;N") 
                        document.form_nuevo.meta.focus() 
                        return 0; 
                    }
                  }
                }
              }

              if(document.form_nuevo.cod.value==0 || document.form_nuevo.cod.value==''){
                alertify.error("REGISTRE C??DIGO DE OPERACI??N") 
                  document.form_nuevo.cod.focus() 
                  return 0;
              }

              alertify.confirm("GUARDAR DATOS DE LA OPERACI&Oacute;N ?", function (a) {
                if (a) {
                    document.getElementById("loadp").style.display = 'block';
                    document.forms['form_nuevo'].submit();
                    document.getElementById("subir_ope").style.display = 'none';
                } else {
                    alertify.error("OPCI\u00D3N CANCELADA");
                }
              });
            }
        });
    });
    </script>
    <script type="text/javascript">
      function verif_codigo(){ 
        codigo = parseFloat($('[name="cod"]').val()); //// codigo
        com_id=<?php echo $componente[0]['com_id']; ?>;
        if(!isNaN(codigo) & codigo!=0){
          var url = "<?php echo site_url("")?>/prog/verif_cod";
          $.ajax({
            type:"post",
            url:url,
            data:{codigo:codigo,com_id:com_id},
            success:function(datos){
              if(datos.trim() =='true'){
                $('#atit').html('<center><div class="alert alert-danger alert-block">C&Oacute;DIGO DE OPERACI&Oacute;N '+codigo+' YA EXISTE</div></center>');
                $('[name="cod"]').val((0).toFixed(0));
                $('#but').slideUp();
              }else{
                $('#atit').html('');
                $('#but').slideDown();
              }
          }});
        }
        else{
          alertify.error("REGISTRE C??DIGO DE OPERACI??N");
          $('#but').slideUp();
        }
        
      }

      function suma_programado(){ 
        sum=0;
        linea = parseFloat($('[name="lbase"]').val()); //// linea base
        codigo = parseFloat($('[name="cod"]').val()); //// codigo
        for (var i = 1; i<=12; i++) {
          sum=parseFloat(sum)+parseFloat($('[name="m'+i+'"]').val());
        }

        $('[name="total"]').val((sum+linea).toFixed(2));
        programado = parseFloat($('[name="total"]').val()); //// programado total
        meta = parseFloat($('[name="meta"]').val()); //// Meta

        if(programado!=meta){
          $('#atit').html('<center><div class="alert alert-danger alert-block">LA SUMA PROGRAMADA NO COINCIDE CON LA META DE LA ACTIVIDAD</div></center>');
          $('#but').slideUp();
        }
        else{

          if(codigo==0){
            $('#but').slideUp();
          }
          else{
            $('#atit').html('');
            $ ('#but').slideDown();
          }
        }
      }
    </script>
    <script type="text/javascript">
      $(function () {
        //SUBIR ARCHIVO
        $("#subir_archivo").on("click", function () {
          var $valid = $("#form_subir_sigep").valid();
          if (!$valid) {
              $validator.focusInvalid();
          } else {
            if(document.getElementById('archivo').value==''){
              alertify.alert('PORFAVOR SELECCIONE ARCHIVO .CSV');
              return false;
            }

            alertify.confirm("REALMENTE DESEA SUBIR ESTE ARCHIVO?", function (a) {
              if (a) {
                  document.getElementById("load").style.display = 'block';
                  document.getElementById('subir_archivo').disabled = true;
                  document.forms['form_subir_sigep'].submit();
              } else {
                  alertify.error("OPCI\u00D3N CANCELADA");
              }
            });
          }
        });
      });
    </script>
    <script type="text/javascript">
    function valida_eliminar(){
        if (document.del_req.tot.value=="" || document.del_req.tot.value==0){
          alertify.error("SELECCIONE OPERACIONES A ELIMINAR");
        }
        else{
          alertify.confirm("DESEA ELIMINAR "+document.del_req.tot.value+" OPERACIONES ?", function (a) {
            if (a) {
                document.getElementById("btsubmit").value = "ELIMINANDO REQUERIMIENTOS...";
                document.getElementById("btsubmit").disabled = true;
                document.del_req.submit();
                return true;
            } else {
                alertify.error("OPCI\u00D3N CANCELADA");
            }
          });
        }
      }

      $(function () {
          function reset() {
            $("#toggleCSS").attr("href", "<?php echo base_url(); ?>assets/themes_alerta/alertify.default.css");
            alertify.set({
                labels: {
                    ok: "ACEPTAR",
                    cancel: "CANCELAR"
                },
                delay: 5000,
                buttonReverse: false,
                buttonFocus: "ok"
            });
          }

          // =====================================================================
          $(".del_ff").on("click", function (e) {
              reset();
              var name = $(this).attr('name');
              var id = $(this).attr('id');
              var request;
              // confirm dialog
              alertify.confirm("DESEA ELIMINAR OPERACI&Oacute;N ?", function (a) {
                if (a) { 
                    url = "<?php echo site_url("admin")?>/prog/del_prod";
                    if (request) {
                      request.abort();
                    }
                    request = $.ajax({
                      url: url,
                      type: "POST",
                      dataType: "json",
                      data: "prod_id="+name+"&proy_id="+id
                    });

                    request.done(function (response, textStatus, jqXHR) { 
                      reset();
                    //  alert(response.verif)
                      if (response.respuesta == 'correcto') {
                        alertify.alert("LA OPERACI&Oacute;N SE ELIMINO CORRECTAMENTE ", function (e) {
                          if (e) {
                            window.location.reload(true);
                          }
                        });
                      } else {
                        alertify.alert("ERROR AL ELIMINAR LA OPERACI&Oacute;N !!!", function (e) {
                          if (e) {
                            window.location.reload(true);
                          }
                        });
                      }
                  });
                    request.fail(function (jqXHR, textStatus, thrown) {
                      console.log("ERROR: " + textStatus);
                    });
                    request.always(function () {
                        //console.log("termino la ejecuicion de ajax");
                    });

                    e.preventDefault();

                } else {
                    // user clicked "cancel"
                    alertify.error("OPCI&Oacute;N CANCELADA");
                }
              });
            return false;
          });
      });
    </script>
    <script type="text/javascript">
    $(document).ready(function(){
      $("#kwd_search").keyup(function(){
        if( $(this).val() != ""){
          // Show only matching TR, hide rest of them
          $("#table tbody>tr").hide();
          $("#table td:contains-ci('" + $(this).val() + "')").parent("tr").show();
        }
        else{
          $("#table tbody>tr").show();
        }
      });
    });
    $.extend($.expr[":"], 
    {
        "contains-ci": function(elem, i, match, array){
        return (elem.textContent || elem.innerText || $(elem).text() || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
      }
    });
    </script>
    <script src = "<?php echo base_url(); ?>mis_js/programacion/programacion/tablas.js"></script>
</body>
</html>