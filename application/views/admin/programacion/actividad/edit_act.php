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
    <!-- FAVICONS -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo base_url(); ?>assets/img/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/css/estilosh.css">
    <style type="text/css">
      aside{background: #05678B;}
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
						<a href="<?php echo base_url();?>index.php/cambiar_gestion">Cambiar Gesti�n</a>
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

      <nav>
        <ul>
          <li>
            <a href='<?php echo site_url("admin").'/dashboard'; ?>' title="MENU PRINCIPAL"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">MEN&Uacute; PRINCIPAL</span></a>
          </li>
          	<li class="text-center">
                <a href="<?php echo base_url().'index.php/admin/proy/mis_proyectos/'.$mod ?>" title="PROGRAMACION -> MIS PROYECTOS"> <span class="menu-item-parent">PROGRAMACI&Oacute;N F&Iacute;SICA</span></a>
            </li>
          <?php
          if($nro_fase==1){
              for($i=0;$i<count($enlaces);$i++)
              {
                ?>
                 <li>
                        <a href="#" >
                          <i class="<?php echo $enlaces[$i]['o_image'];?>"></i> <span class="menu-item-parent"><?php echo $enlaces[$i]['o_titulo']; ?></span></a>
                        <ul >
                        <?php
                        $submenu= $this->menu_modelo->get_Modulos_sub($enlaces[$i]['o_child']);
                    foreach($submenu as $row) {
                        ?>
                        <li><a href="<?php echo base_url($row['o_url'])."/".$mod."/".$id_f[0]['id']."/".$id_f[0]['proy_id']; ?>"><?php echo $row['o_titulo']; ?></a></li>
                        <?php } ?>
                        </ul>
                    </li>
                <?php
              }
          }
          ?>
        </ul>
      </nav>
      <span class="minifyme" data-action="minifyMenu"> <i class="fa fa-arrow-circle-left hit"></i> </span>
    </aside>

    <!-- MAIN PANEL -->
    <div id="main" role="main">
      <!-- RIBBON -->
      <div id="ribbon">
        <!-- breadcrumb -->
			<ol class="breadcrumb">
				<?php
				if($mod==1)
				{
					?>
					<li><a href="<?php echo base_url().'index.php/admin/proy/list_proy' ?>" title="VOLVER A MIS PROYECTOS">Mis Operaciones</a></li><li><a href="<?php echo base_url().'index.php/admin/prog/list_prod/'.$mod.'/'.$id_f[0]['id']."/".$id_f[0]['proy_id'].'/'.$componente[0]['com_id']; ?>" title="MIS OBJETIVOS DE PRODUCTOS">Mis Productos</a></li><li><a href="<?php echo base_url().'index.php/admin/prog/list_act/'.$mod.'/'.$id_f[0]['id'].'/'.$id_f[0]['proy_id'].'/'.$id_c.'/'.$producto[0]['prod_id']; ?>" title="OBJETIVO DE ACTIVIDADES">Mis Actividades</a></li><li>Actividades (Modificar)</li>
					<?php
				}
				elseif ($mod==4) 
				{
					?>
					<li><a href="<?php echo base_url().'index.php/admin/sgp/list_proy' ?>" title="VOLVER A MIS PROYECTOS">Gerencias de Proyectos</a></li><li><a href="<?php echo base_url().'index.php/admin/prog/list_prod/'.$mod.'/'.$id_f[0]['id']."/".$id_f[0]['proy_id'].'/'.$componente[0]['com_id']; ?>" title="MIS OBJETIVOS DE PRODUCTOS">Mis Productos</a></li><li><a href="<?php echo base_url().'index.php/admin/prog/list_act/'.$mod.'/'.$id_f[0]['id'].'/'.$id_f[0]['proy_id'].'/'.$id_c.'/'.$producto[0]['prod_id']; ?>" title="OBJETIVO DE ACTIVIDADES">Mis Actividades</a></li><li>Actividades (Modificar)</li>
					<?php 
				}
				?>
			</ol>
      </div>
      <!-- END RIBBON -->
		<?php
			$attributes = array('class' => 'form-horizontal', 'id' => 'formulario','name' =>'formulario','enctype' => 'multipart/form-data');
			echo validation_errors();
			echo form_open('admin/prog/update_act', $attributes);
		?>	
			<!-- MAIN CONTENT -->
			<div id="content">
				<section id="widget-grid" class="">
					<div class="row">
							<article class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
			                  <section id="widget-grid" class="well">
		                          <div class="">
		                            <h1> CATEGORIA PROGRAM&Aacute;TICA : <small><?php echo $proyecto[0]['aper_programa'].''.$proyecto[0]['aper_proyecto'].''.$proyecto[0]['aper_actividad']?></small>
									<h1> <?php echo $titulo_proy;?> : <small><?php echo $proyecto[0]['proy_nombre']?></small></h1>
		                          	<h1> COMPONENTE : <small><?php echo $componente[0]['com_componente']?></small>
          							<h1> PRODUCTO : <small><?php echo $producto[0]['prod_producto']?></small>
		                          </div>
		                      </section>
							</article>
							<article class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
								<div class="row">
									<div class="well">
									<center><b>ACTIVIDAD PRECEDENTE DE : </b></center><br>
										<?php  
										if($act_reg!=1 & $actividad[0]['nro_act']!=1)
										{
											?>
											<select class="form-control" id="act_dep" name="act_dep" >
							                    <option value="">Seleccione Actividad dependiente</option> 
												<option value="0">Ninguna dependencia</option> 
							                        <?php
														$consulta1 = 'SELECT * FROM "public"."_actividades" WHERE prod_id='.$producto[0]['prod_id'].' AND NOT act_id='.$actividad[0]['act_id'].' and estado!=\'3\' ORDER BY act_id asc ';
														$consulta1=$this->db->query($consulta1);
														$lista_act=$consulta1->result_array();
														
														foreach ($lista_act as $lact)
														{ 
															if($lact['nro_act']==$actividad[0]['act_precedente'])
															{
																?>
																<option value="<?php echo $lact['nro_act']?>" selected><?php echo $lact['nro_act'].'  -  '.$lact['act_actividad']?></option> 
																<?php
															}
															else
															{
																?>
																<option value="<?php echo $lact['nro_act']?>"><?php echo $lact['nro_act'].'  -  '.$lact['act_actividad']?></option> 
																<?php
															}
		  												} 
		  											?>  
							        		</select>
											<?php
										}
										else
										{
											?>
											<input class="form-control" type="hidden" name="act_dep" id="act_dep" value="0">
											<?php
										}
										?>
									</div>
								</div>
							</article>
							<article class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
							<div class="jarviswidget jarviswidget-color-darken" id="wid-id-2" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false">
								<header>
									<h2><strong>ACTIVIDADES (Modificar)</strong></h2>		
								</header>
								<div class="row"> 
									<form  name="formulario" id="formulario" method="post">
										<div >
										<input class="form-control" type="hidden" name="id_f" id="id_f" value="<?php echo $id_f[0]['id'];?>">
										<input class="form-control" type="hidden" name="id_p" id="id_p" value="<?php echo $id_f[0]['proy_id'];?>">
										<input class="form-control" type="hidden" name="id_c" id="id_c" value="<?php echo $id_c;?>">
										<input class="form-control" type="hidden" name="id_pr" id="id_pr" value="<?php echo $producto[0]['prod_id'];?>">
										<input class="form-control" type="hidden" name="id_ac" id="id_ac" value="<?php echo $actividad[0]['act_id'];?>">
										<input class="form-control" type="hidden" name="gest" id="gest" value="<?php echo $id_f[0]['pfec_fecha_inicio'] ?>">
										<input class="form-control" type="hidden" name="nro_act" id="nro_act" value="<?php echo $actividad[0]['nro_act'] ?>">			
										<input class="form-control" type="hidden" name="mod" id="mod" value="<?php echo $mod ?>">			
										<input class="form-control" type="hidden" name="act_reg" id="act_reg" value="<?php echo $act_reg;?>">			
										<div class="well">
											<div class="row">
												<div class="col-sm-12">
													<div class="form-group">
														<label><font size="1"><b>ACTIVIDAD</b></font></label>
														<textarea rows="4" class="form-control" style="width:100%;" name="act" id="act" onclick="suma(this.form)"><?php echo $actividad[0]['act_actividad'];?></textarea> 
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-sm-4">
													<div class="form-group">
													<label><font size="1"><b>TIPO DE INDICADOR </b></font></label>
														<select class="form-control" id="tipo_i" name="tipo_i" onclick="suma(this.form)">
	                                                        <?php 
											                    foreach($indi as $row)
											                    {
											                    	if($row['indi_id']==$actividad[0]['indi_id'])
											                    	{
											                    		?>
													                     <option value="<?php echo $row['indi_id']; ?>" selected><?php echo $row['indi_descripcion']; ?></option>
													                    <?php 
											                    	}
											                    	else
											                    	{
											                    		?>
													                     <option value="<?php echo $row['indi_id']; ?>"><?php echo $row['indi_descripcion']; ?></option>
													                    <?php 
											                    	}	
											                    }
											                ?> 
	                                                  	</select>
													</div>
												</div>
											
												<div class="col-sm-8">
													<div class="form-group">
														<label><font size="1"><b>INDICADOR</b></font></label>
														<textarea rows="4" class="form-control" style="width:100%;" name="indicador" id="indicador" onclick="suma(this.form)"><?php echo $actividad[0]['act_indicador'];?></textarea> 
													</div>
												</div>
											</div>

											<div class="row">
											<?php
												if($actividad[0]['indi_id']==2)
												{
													?>
													<div id="rel" >
														<div class="row">
															<div class="col-sm-9">
																<div class="form-group">
																	<label><font size="1"><b>FORMULA</b></font></label>
																	<textarea rows="3" class="form-control" style="width:100%;"  name="formula" id="formula" onclick="suma(this.form)"><?php echo $actividad[0]['act_formula'];?></textarea> 
																</div>
															</div>
															<div class="col-sm-3">
																<div class="form-group">
																	<label><font size="1"><b>DENOMINADOR</b></font></label>
																	<?php 
																		if($actividad[0]['act_denominador']==0)
																		{
																			?>
																			<label class="radio state-success"><input type="radio" name="den" value="0"checked><i></i>Variable</label>
																			<label class="radio state-success"><input type="radio" name="den" value="1"><i></i>Fijo</label>
																			<?php
																		}
																		elseif ($actividad[0]['act_denominador']==1) 
																		{
																			?>
																			<label class="radio state-success"><input type="radio" name="den" value="0"><i></i>Variable</label>
																			<label class="radio state-success"><input type="radio" name="den" value="1"checked><i></i>Fijo</label>
																			<?php
																		}
																	?>
																	
																</div>
															</div>
														</div>
													</div>
													<?php
												}
												else
												{
													?>
													<div id="rel" style="display:none;">
														<div class="row">
															<div class="col-sm-9">
																<div class="form-group">
																	<label><font size="1"><b>FORMULA</b></font></label>
																	<textarea rows="3" class="form-control" style="width:100%;" name="formula" id="formula" onclick="suma(this.form)"><?php echo $actividad[0]['act_formula'];?></textarea> 
																</div>
															</div>
															<div class="col-sm-3">
																<div class="form-group">
																	<label><font size="1"><b>DENOMINADOR</b></font></label>
																	<?php 
																		if($actividad[0]['act_denominador']==0)
																		{
																			?>
																			<label class="radio state-success"><input type="radio" name="den" value="0"checked><i></i>Variable</label>
																			<label class="radio state-success"><input type="radio" name="den" value="1"><i></i>Fijo</label>
																			<?php
																		}
																		elseif ($actividad[0]['act_denominador']==1) 
																		{
																			?>
																			<label class="radio state-success"><input type="radio" name="den" value="0"><i></i>Variable</label>
																			<label class="radio state-success"><input type="radio" name="den" value="1"checked><i></i>Fijo</label>
																			<?php
																		}
																	?>
																	
																</div>
															</div>
														</div>
													</div>
													<?php
												}
											?>
											</div>

											<div class="row">
												<div class="col-sm-4">
													<div class="form-group">
													<label><font size="1"><b>LINEA BASE</b></font></label>
														<input class="form-control" type="text" name="lb" id="lb" value="<?php echo round($actividad[0]['act_linea_base'],3);?>" onkeyup="suma(this.form)" onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }" onpaste="return false">
													</div>
												</div>
											
												<div class="col-sm-4">
													<div class="form-group">
														<label><font size="1"><b>META</b></font></label>
														<input class="form-control" type="text" name="met" id="met" onkeyup="javascript:costo_unitario();" onkeyup="suma(this.form)" value="<?php echo round($actividad[0]['act_meta'],3);?>" onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }" onpaste="return false">
													</div>
												</div>

												<div class="col-sm-4">
													<div class="form-group">
														<label><font size="1"><b>PONDERACI&Oacute;N %</b></font></label>
														<input class="form-control" type="text"  value="<?php echo $actividad[0]['act_ponderacion'];?>" disabled="true">
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group">
														<label><font size="1"><b>COSTO</b></font></label>
														<input class="form-control" type="text" name="costo" id="costo"  onkeyup="javascript:costo_unitario();" placeholder="0" value="<?php echo $actividad[0]['act_presupuesto'];?>" onkeypress="if (this.value.length < 25) { return numerosDecimales(event);}else{return false; }">
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group">
														<label><font size="1"><b>COSTO UNITARIO</b></font></label>
														<input class="form-control" type="text" name="cost_uni" id="cost_uni"  placeholder="0" value="<?php echo $actividad[0]['act_costo_uni'];?>" onkeypress="if (this.value.length < 20) { return numerosDecimales(event);}else{return false; }"  onpaste="return false">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-sm-12">
													<div class="form-group">
													<label><font size="1"><b>FUENTE DE VERIFICACI&Oacute;N</b></font></label>
														<textarea rows="3" class="form-control" style="width:100%;" style="text-transform:uppercase;" onclick="suma(this.form)" onkeyup="javascript:this.value=this.value.toUpperCase();" name="verificacion" id="verificacion"><?php echo $actividad[0]['act_fuente_verificacion'];?></textarea> 
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group">
														<label><font size="1" color="blue"><b>FECHA DE INICIO - dd/mm/aa</b></font></label>
														<div class="input-group">
																<input type="text" name="f_ini" id="f_ini" value="<?php echo date('d/m/Y',strtotime($actividad[0]['act_fecha_inicio'])); ?>" placeholder="Seleccione Fecha inicial" class="form-control datepicker" onKeyUp="this.value=formateafecha(this.value);" data-dateformat="dd/mm/yy" onKeyUp="this.value=formateafecha(this.value);"  title="Seleccione fecha Inicial del Proyecto">
																<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
														</div>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group">
														<label><font size="1" color="blue"><b>FECHA FINAL - dd/mm/aa</b></font></label>
														<div class="input-group">
																<input type="text" name="f_final" id="f_final" value="<?php echo date('d/m/Y',strtotime($actividad[0]['act_fecha_final'])); ?>"placeholder="Seleccione Fecha inicial" class="form-control datepicker" onKeyUp="this.value=formateafecha(this.value);" data-dateformat="dd/mm/yy" onKeyUp="this.value=formateafecha(this.value);"  title="Seleccione fecha Final del Proyecto">
																<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
														</div>
													</div>
												</div>
												
											</div>

											<?php
											if($actividad[0]['indi_id']==2)
											{
												?>
												<div id="rel2">
													<div class="row">
														<div class="col-sm-12">
															<label><font size="1"><b>CARACTERISTICAS</b></font></label>
															<div class="form-group">
																<div class="col-sm-6">
																	<div class="form-group">
																		<label><font size="1"><b>Nombre del Denominador</b></font></label>
																		<textarea rows="3" name="c_a" id="c_a" class="form-control" style="width:100%;" style="text-transform:uppercase;" onclick="suma(this.form)" ><?php echo $actividad[0]['act_total_casos'];?></textarea> 
																	</div>
																</div>
															
																<div class="col-sm-6">
																	<div class="form-group">
																		<label><font size="1"><b>Nombre del Numerador</b></font></label>
																		<textarea rows="3" name="c_b" id="c_b" class="form-control" style="width:100%;" style="text-transform:uppercase;" onclick="suma(this.form)"><?php echo $actividad[0]['act_casos_favorables'];?></textarea> 
																	</div>
																</div>
															
															</div>
														</div>
													</div>
												</div>
												<?php
											}
											else
											{
												?>
												<div id="rel2" style="display:none;">
													<div class="row">
														<div class="col-sm-12">
															<label><font size="1"><b>CARACTERISTICAS</b></font></label>
															<div class="form-group">
																<div class="col-sm-4">
																	<div class="form-group">
																		<label><font size="1"><b>Nombre Denominador</b></font></label>
																		<textarea rows="3" name="c_a" id="c_a" class="form-control" style="width:100%;" onclick="suma(this.form)"><?php echo $actividad[0]['act_total_casos'];?></textarea> 
																	</div>
																</div>
															
																<div class="col-sm-4">
																	<div class="form-group">
																		<label><font size="1"><b>nombre Numerador</b></font></label>
																		<textarea rows="3" name="c_b" id="c_b" class="form-control" style="width:100%;" onclick="suma(this.form)"><?php echo $actividad[0]['act_casos_favorables'];?></textarea> 
																	</div>
																</div>
															
															</div>
														</div>
													</div>
												</div>
												<?php
											}
											?>
											
										<div class="form-actions">
											<a href="<?php echo base_url().'index.php/admin/prog/list_act/'.$mod.'/'.$id_f[0]['id'].'/'.$id_f[0]['proy_id'].'/'.$id_c.'/'.$producto[0]['prod_id']; ?>" class="btn btn-lg btn-default" title="OBJETIVOS DE ACTIVIDADES"> CANCELAR </a>
											<input type="button" value="MODIFICAR ACTIVIDAD" id="btsubmit" class="btn btn-primary btn-lg" onclick="valida_envia()" title="MODIFICAR ACTIVIDAD">
										</div>
									</div>	
									</div>
								</form>
								</div>
								</div>
								</article>

								<article class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
									<div class="row">
										<div class="well">
										<center><b><h4><strong>PROGRAMACI&Oacute;N <?php echo $id_f[0]['pfec_fecha_inicio'] ?> - <?php echo $id_f[0]['pfec_fecha_fin'] ?></strong></h4></b></center><br>
											<div>
												<center><strong>INDICADOR <b id="titulo_indicador"></b></strong></center>		
											</div>		
												<?php 
											$a�os=$id_f[0]['pfec_fecha_fin']-$id_f[0]['pfec_fecha_inicio']+1; 
											for($k=1;$k<=$a�os;$k++)
											{
												$act_gest=$this->model_actividad->act_prog_mensual($actividad[0]['act_id'],$id_f[0]['pfec_fecha_inicio']);
												$nro=0;
												foreach($act_gest as $row)
                                                {
                                                	$nro++;
                                                	$matriz [1][$nro]=$row['m_id'];
                                                    $matriz [2][$nro]=$row['pg_fis'];
                                                }

                                                for($j = 1 ;$j<=12 ;$j++){
                                                          $matriz_r[1][$j]=$j;
                                                          $matriz_r[2][$j]='0';
                                                }

                                                for($i = 1 ;$i<=$nro ;$i++){
                                                    for($j = 1 ;$j<=12 ;$j++)
                                                    {
                                                         if($matriz[1][$i]==$matriz_r[1][$j])
                                                          {
                                                            $matriz_r[2][$j]=round($matriz[2][$i],2);
                                                          }
                                                        }
                                                      }
												?>
												<div class="row">
													<?php
														if($id_f[0]['pfec_fecha_inicio']==$this->session->userdata("gestion")){
														?>
															<div class="alert alert-block alert-success">
																<center><label><b>GESTI&Oacute;N ACTUAL - <?php echo $id_f[0]['pfec_fecha_inicio'] ?></b></label></center>
															</div>
														<?php
														}
														elseif ($id_f[0]['pfec_fecha_inicio']!=$this->session->userdata("gestion")) {
														?>
														<div class="alert alert-block alert-success">
																<center><label>GESTI&Oacute;N  - <?php echo $id_f[0]['pfec_fecha_inicio'] ?></label></center>
														</div>
														<?php
														}
													?>
													<table class="table table-bordered table-hover" style="width:100%;" >
													    <thead>
													        <tr>
													            <th style="width:20%;"><center>ENERO <b id="m1"></b></center></th>
													            <th style="width:20%;"><center>FEBRERO <b id="m2"></b></center></th>
													            <th style="width:20%;"><center>MARZO <b id="m3"></b></center></th>
													            <th style="width:20%;"><center>ABRIL <b id="m4"></b></center></th>
													        </tr>
													    </thead>
													    <tbody>
													        <tr>
													            <td><input  name="m1[]" class="form-control" type="text" onkeyup="suma(this.form)" style="width:100%;" value="<?php echo $matriz_r[2][1]; ?>"  onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }"></td>
													            <td><input  name="m2[]" class="form-control" type="text" onkeyup="suma(this.form)" style="width:100%;" value="<?php echo $matriz_r[2][2]; ?>" onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }"></td>
													            <td><input  name="m3[]" class="form-control" type="text" onkeyup="suma(this.form)" style="width:100%;" value="<?php echo $matriz_r[2][3]; ?>" onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }"></td>
													            <td><input  name="m4[]" class="form-control" type="text" onkeyup="suma(this.form)" style="width:100%;" value="<?php echo $matriz_r[2][4]; ?>" onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }"></td>
													        </tr>
													    </tbody>
													</table>
													<table class="table table-bordered table-hover" style="width:100%;" >
													    <thead>
													        <tr>
													            <th style="width:20%;"><center>MAYO <b id="m5"></b></center></th>
													            <th style="width:20%;"><center>JUNIO <b id="m6"></b></center></th>
													            <th style="width:20%;"><center>JULIO <b id="m7"></b></center></th>
													            <th style="width:20%;"><center>AGOSTO <b id="m8"></b></center></th>
													        </tr>
													    </thead>
													    <tbody>
													        <tr>
													            <td><input  name="m5[]" class="form-control" type="text" onkeyup="suma(this.form)" style="width:100%;" value="<?php echo $matriz_r[2][5]; ?>" onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }"></td>
													            <td><input  name="m6[]" class="form-control" type="text" onkeyup="suma(this.form)" style="width:100%;" value="<?php echo $matriz_r[2][6]; ?>" onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }"></td>
													            <td><input  name="m7[]" class="form-control" type="text" onkeyup="suma(this.form)" style="width:100%;" value="<?php echo $matriz_r[2][7]; ?>" onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }"></td>
													            <td><input  name="m8[]" class="form-control" type="text" onkeyup="suma(this.form)" style="width:100%;" value="<?php echo $matriz_r[2][8]; ?>" onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }"></td>
													        </tr>
													    </tbody>
													</table>
													<table class="table table-bordered table-hover" style="width:100%;" >
													    <thead>
													        <tr>
													            <th style="width:20%;"><center>SEPTIEMBRE <b id="m9"></b></center></th>
													            <th style="width:20%;"><center>OCTUBRE <b id="m10"></b></center></th>
													            <th style="width:20%;"><center>NOVIEMBRE <b id="m11"></b></center></th>
													            <th style="width:20%;"><center>DICIEMBRE <b id="m12"></b></center></th>
													        </tr>
													    </thead>
													    <tbody>
													         <tr>
													            <td><input  name="m9[]" class="form-control" type="text" onkeyup="suma(this.form)" style="width:100%;" value="<?php echo $matriz_r[2][9]; ?>" onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }"></td>
													            <td><input  name="m10[]" class="form-control" type="text" onkeyup="suma(this.form)" style="width:100%;" value="<?php echo $matriz_r[2][10]; ?>" onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }"></td>
													            <td><input  name="m11[]" class="form-control" type="text" onkeyup="suma(this.form)" style="width:100%;" value="<?php echo $matriz_r[2][11]; ?>" onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }"></td>
													            <td><input  name="m12[]" class="form-control" type="text" onkeyup="suma(this.form)" style="width:100%;" value="<?php echo $matriz_r[2][12]; ?>" onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }"></td>
													        </tr>
													    </tbody>
													</table>		
												</div>
												<?php
												$id_f[0]['pfec_fecha_inicio']++;
											}
										?> 
										</div>
										<div class="well">
										<div class="row">
											<div class="col-sm-12">
											<div class="form-group">
											<label><font size="2" color="blue"><b>SUMA TOTAL : PROGRAMADO + LINEA BASE</b></font></label>
											<input class="form-control" type="text" name="total" id="total" disabled="true" value="<?php echo round($programado[0]['suma'],3);?>">
											</div>
										</div>
										</div>
									</div>
								</article>
								
							</div>
						</section>
						<!-- end widget grid -->					
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
		<!-- END PAGE FOOTER -->
        <script src="<?php echo base_url();?>/assets/js/libs/jquery-2.0.2.min.js"></script>
        <script src = "<?php echo base_url(); ?>mis_js/control_session.js"></script>
		<script>
			if (!window.jQuery.ui) {
				document.write('<script src="<?php echo base_url();?>/assets/js/libs/jquery-ui-1.10.3.min.js"><\/script>');
			}
		</script>
  		<!-- IMPORTANT: APP CONFIG -->
  		<script src="<?php echo base_url(); ?>assets/js/session_time/jquery-idletimer.js"></script>
		<script src = "<?php echo base_url(); ?>mis_js/control_session.js"></script>
		<script src="<?php echo base_url();?>/assets/js/app.config.js"></script>

		<script src="<?php echo base_url(); ?>assets/js/mis_js/validacion_form.js"></script>
		<SCRIPT src="<?php echo base_url(); ?>mis_js/programacion/ejecucion/abm_ejecucion.js" type="text/javascript"></SCRIPT>
		<SCRIPT src="<?php echo base_url(); ?>mis_js/programacion/programacion/actividades.js" type="text/javascript"></SCRIPT>
		<!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
		<script src="<?php echo base_url();?>/assets/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> 
		<!-- BOOTSTRAP JS -->
		<script src="<?php echo base_url();?>/assets/js/bootstrap/bootstrap.min.js"></script>
		<!-- CUSTOM NOTIFICATION -->
		<script src="<?php echo base_url();?>/assets/js/notification/SmartNotification.min.js"></script>
		<!-- JARVIS WIDGETS -->
		<script src="<?php echo base_url();?>/assets/js/smartwidgets/jarvis.widget.min.js"></script>
		<!-- EASY PIE CHARTS -->
		<script src="<?php echo base_url();?>/assets/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>
		<!-- SPARKLINES -->
		<script src="<?php echo base_url();?>/assets/js/plugin/sparkline/jquery.sparkline.min.js"></script>
		<!-- JQUERY VALIDATE -->
		<script src="<?php echo base_url();?>/assets/js/plugin/jquery-validate/jquery.validate.min.js"></script>
		<!-- JQUERY MASKED INPUT -->
		<script src="<?php echo base_url();?>/assets/js/plugin/masked-input/jquery.maskedinput.min.js"></script>
		<!-- JQUERY SELECT2 INPUT -->
		<script src="<?php echo base_url();?>/assets/js/plugin/select2/select2.min.js"></script>
		<!-- JQUERY UI + Bootstrap Slider -->
		<script src="<?php echo base_url();?>/assets/js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script>
		<!-- browser msie issue fix -->
		<script src="<?php echo base_url();?>/assets/js/plugin/msie-fix/jquery.mb.browser.min.js"></script>
		<!-- FastClick: For mobile devices -->
		<script src="<?php echo base_url();?>/assets/js/plugin/fastclick/fastclick.min.js"></script>
		<!-- Demo purpose only -->
		<script src="<?php echo base_url();?>/assets/js/demo.min.js"></script>
		<!-- MAIN APP JS FILE -->
		<script src="<?php echo base_url();?>/assets/js/app.min.js"></script>
		<!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->
		<!-- Voice command : plugin -->
		<script type="text/javascript">
		$(document).ready(function() {
			pageSetUp();
		})
		</script>
	</body>
</html>
