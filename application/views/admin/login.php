<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>LOGIN SIIPLASdsadadsa </title>
  <script src="<?php echo base_url(); ?>assets/login/js/modernizr.js" type="text/javascript"></script>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/login/css/normalize.min.css">
  <link rel='stylesheet prefetch' href='<?php echo base_url(); ?>assets/login/css/gubja.css'>
  <link rel='stylesheet prefetch' href='<?php echo base_url(); ?>assets/login/css/yaozl.css'>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/login/css/style.css">
</head>
<style>
body {
    font-family: "Segoe UI", sans-serif;
    font-size:100%;
}
.caja {
font-family: sans-serif;
font-size: 28px;
font-weight: 100;
color: #000000;
background: #ced3df;
margin: 0 0 15px;
overflow: hidden;
padding: 3px;
}

.sidebar {
    position: fixed;
    height: 100%;
    width: 0;
    top: 0;
    left: 0;
    z-index: 1;
    background-color: #083e38;
    overflow-x: hidden;
    transition: 0.4s;
    padding: 1rem 0;
    box-sizing:border-box;
}

.sidebar .boton-cerrar {
    position: absolute;
    top: 0.5rem;
    right: 1rem;
    font-size: 2rem;
    display: block;
    padding: 0;
    line-height: 1.5rem;
    margin: 0;
    height: 32px;
    width: 32px;
    text-align: center;
    vertical-align: top;
}

.sidebar ul, .sidebar li{
    margin:0;
    padding:0;
    list-style:none inside;
}

.sidebar ul {
    margin: 4rem auto;
    display: block;
    width: 80%;
    min-width:200px;
}

.sidebar a {
    display: block;
    font-size: 100%;
    color: #eee;
    text-decoration: none;
    
}

.sidebar a:hover{
    color:#fff;
    background-color: #808282;

}

h1 {
    color:#eceff1;
    font-size:120%;
    font-weight:normal;
}
#contenido {
    transition: margin-left .4s;
    padding: 1rem;
}

.abrir-cerrar {
    color: #eceff1;
    font-size:1rem;   
}

#abrir {
    
}
#cerrar {
    display:none;
}
</style>
<body>
<div id="sidebar" class="sidebar">
<a href="#" class="boton-cerrar" onclick="ocultar()">&times;</a>
<center><h1>ARCHIVOS DE MIGRACI&Oacute;N POA 2021</h1></center>
<ul class="menu">
  <li><a href="<?php echo base_url(); ?>assets/video/plantilla_actividades.xlsx" download  title="ARCHIVO DE MIGRACION - ACTIVIDADES">1.- ARCHIVO DE MIGRACI&Oacute;N - ACTIVIDADES</a></li>
  <li><a href="<?php echo base_url(); ?>assets/video/Requerimientos_x_actividad.xlsx" download  title="ARCHIVO DE MIGRACION - REQUERIMIENTOS POR CADA ACTIVIDAD">2.- ARCHIVO DE MIGRACI&Oacute;N - REQUERIMIENTOS POR ACTIVIDAD</a></li>
  <li><a href="<?php echo base_url(); ?>assets/video/Requerimientos_global_actividad.xlsx" download  title="ARCHIVO DE MIGRACION - REQUERIMIENTOS DE MANERA GLOBAL">3.- ARCHIVO DE MIGRACI&Oacute;N - REQUERIMIENTOS (GLOBAL)</a></li>
</ul>
<center><h1>FORMULARIOS EDICI&Oacute;N POA 2021</h1></center>
<ul class="menu">
  <li><a href="<?php echo base_url(); ?>assets/video/SOLICITUD CERTIFICACION POA 04_01_21.xlsx" download  title="FORMULARIO DE CERTIFICACIÓN POA">1.- FORMATO DE SOLICITUD DE CERTIFICACI&Oacute;N POA</a></li>
  <li><a href="<?php echo base_url(); ?>assets/video/FORMULARIO SOLICITUD DE MODIFICACION POA 04_01_21.xlsx" download  title="FORMULARIO DE MODIFICACION POA - ACTIVIDADES Y REQUERIMIENTOS">2.- FORMATO DE SOLICITUD DE MODIFICACI&Oacute;N POA</a></li>
</ul>
</div>



<div id="contenido">
<a id="abrir" class="abrir-cerrar" href="javascript:void(0)" onclick="mostrar()"><b>ABRIR LISTA ARCHIVOS POA 2020</b></a><a id="cerrar" class="abrir-cerrar" onclick="ocultar()">CERRAR LISTA</a>
  <div class="container">
<div id="login" class="signin-card">
  <div class="logo-image">
  <img src="<?php echo base_url(); ?>assets/login/img/caja.png" alt="Logo" title="Logo" style="width:30%; height:30%;">
  </div>
  <h1 class="display1">SIIPLAS V2.0</h1>

    <?php
    if($this->session->flashdata('danger')){ ?>
        <p style="background-color:#ef8181; color: white"><b><?php echo $this->session->flashdata('danger');?></b></p>
    <?php 
      }
      elseif($this->session->flashdata('warning')){ ?>
        <p style="background-color:#e2ba77; color: white"><b><?php echo $this->session->flashdata('danger');?></b></p>
        <?php
      }
    ?>

    <!-- <center><font color="blue"><b>(POA 2020 - VERI&Oacute;N BETA)</b></font></center> -->
  <p class="subhead"><b>SISTEMA DE PLANIFICACI&Oacute;N DE SALUD POR RESULTADO</b></p>
    <form role="form" action="<?php echo base_url(); ?>index.php/admin/validate" method="post" class="login-form">
      <div id="form-login-username" class="form-group">
        <input id="username" class="form-control" name="user_name" id="usu" type="text" size="18" alt="login" required />
        <span class="form-highlight"></span>
        <span class="form-bar"></span>
        <label for="username" class="float-label">Usuario : </label>
      </div>
      <div id="form-login-password" class="form-group">
        <input id="passwd" class="form-control" id="password" name="password" type="password" size="18" alt="password" required>
        <span class="form-highlight"></span>
        <span class="form-bar"></span>
        <label for="password" class="float-label">Password : </label>
      </div>
      <div id="form-login" class="form-group">
        <input class="form-control" id="dat_captcha" name="dat_captcha" type="text" size="4" required autocomplete="off">
        <span class="form-highlight"></span>
        <span class="form-bar"></span>
        <label class="float-label">C&oacute;digo de Seguridad : </label>
      </div>

      <p class="caja" id="refreshs"><b><?php echo $cod_captcha;?></b></p>

      <input type="hidden" name="captcha" id="captcha" value="<?php echo $captcha;?>">
      
      <div id="form-login-remember" class="form-group">
        <div class="checkbox checkbox-default">       
            <input id="remember" type="checkbox" value="yes" alt="Remember me" class="" name="remember">
            <label for="remember">Mantener el Acceso</label>      
        </div>
      </div>
      <div>
        <button class="btn btn-lg btn-success" type="submit" name="Submit" id="ingr" alt="sign in" style="width:100%;">Ingresar</button>  
      </div>
      </div>
    </form>
  </div>
</div>
</div>
  <script src='<?php echo base_url(); ?>assets/login/js/jquery.min.js'></script>
  <script src='<?php echo base_url(); ?>assets/login/js/gubja.js'></script>
  <script src='<?php echo base_url(); ?>assets/login/js/yaozl.js'></script>
  <script  src="<?php echo base_url(); ?>assets/login/js/index.js"></script>
  <script>
  function mostrar() {
      document.getElementById("sidebar").style.width = "300px";
      document.getElementById("contenido").style.marginLeft = "300px";
      document.getElementById("abrir").style.display = "none";
      document.getElementById("cerrar").style.display = "inline";
  }

  function ocultar() {
      document.getElementById("sidebar").style.width = "0";
      document.getElementById("contenido").style.marginLeft = "0";
      document.getElementById("abrir").style.display = "inline";
      document.getElementById("cerrar").style.display = "none";
  }
  </script>
      <script type="text/javascript">
        $(document).ready(function(e) {
          $('#refreshs').click(function(){
              
              var url = "<?php echo site_url("")?>/user/get_captcha";
              var request;
              if (request) {
                  request.abort();
              }
              request = $.ajax({
                url: url,
                type: "POST",
                dataType: 'json', 
              });

              request.done(function (response, textStatus, jqXHR) {
                if (response.respuesta == 'correcto') {
                  $("#refreshs").html(response.cod_captcha);
                  document.getElementById("captcha").value = response.captcha;
                }
              }); 

          });
            
        });
       </script>

</body>
</html>
