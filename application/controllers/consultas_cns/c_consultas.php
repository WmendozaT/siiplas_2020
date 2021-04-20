<?php
define("DOMPDF_ENABLE_REMOTE", true);
define("DOMPDF_TEMP_DIR", "/tmp");
class C_consultas extends CI_Controller {  
    public $rol = array('1' => '1','2' => '10'); 
    public function __construct (){
        parent::__construct();
        if($this->session->userdata('fun_id')!=null){
            $this->load->model('Users_model','',true);
            if($this->rolfun($this->rol)){ 
            $this->load->library('pdf2');
            $this->load->model('menu_modelo');
            $this->load->model('consultas/model_consultas');
            $this->load->model('programacion/model_proyecto');
            $this->load->model('modificacion/model_modificacion');
            $this->load->model('programacion/model_faseetapa');
            $this->load->model('programacion/model_actividad');
            $this->load->model('programacion/model_producto');
            $this->load->model('programacion/model_componente');
            $this->load->model('reporte_eval/model_evalnacional');
            $this->load->model('reporte_eval/model_evalregional');
            $this->load->model('mantenimiento/mapertura_programatica');
            $this->load->model('mantenimiento/model_ptto_sigep');
            $this->load->model('ejecucion/model_evaluacion');
            $this->load->model('mantenimiento/model_configuracion');

            $this->pcion = $this->session->userData('pcion');
            $this->gestion = $this->session->userData('gestion');
            $this->adm = $this->session->userData('adm');
            $this->rol = $this->session->userData('rol_id');
            $this->dist = $this->session->userData('dist');
            $this->dist_tp = $this->session->userData('dist_tp');
            $this->tmes = $this->session->userData('trimestre');
            $this->fun_id = $this->session->userData('fun_id');
            $this->tr_id = $this->session->userData('tr_id'); /// Trimestre Eficacia
            }else{
                redirect('admin/dashboard');
            }
        }
        else{
            redirect('/','refresh');
        }
    }


    /*---------- TIPO DE RESPONSABLE ----------*/
    public function tp_resp(){
      $ddep = $this->model_proyecto->dep_dist($this->dist);
      if($this->adm==1){
        $titulo='RESPONSABLE NACIONAL';
      }
      elseif($this->adm==2){
        $titulo='RESPONSABLE '.strtoupper($ddep[0]['dist_distrital']);
      }

      return $titulo;
    }


    /*------- Menu Accion Operativa -------*/
    public function mis_operaciones(){
      $data['list_gestion']= $this->list_gestion();
      $data['menu']=$this->menu(10);
      $data['onacional']=$this->region(10);
      $data['lpz']=$this->region(2);
      $data['cba']=$this->region(3);
      $data['ch']=$this->region(1);
      $data['oru']=$this->region(4);
      $data['pts']=$this->region(5);
      $data['tj']=$this->region(6);
      $data['scz']=$this->region(7);
      $data['bn']=$this->region(8);
      $data['pnd']=$this->region(9);
      $this->load->view('admin/consultas_internas/list_regionales', $data);
    }

    /*------------- Gestion ----------------*/
    public function list_gestion(){
      $listar_gestion= $this->model_configuracion->lista_gestion();
      $tabla='';
      $tabla.='<form   method="post" action="'.base_url().'index.php/consulta/cambiar">
              <input class="form-control" type="hidden" name="fun_id" value="'.$this->session->userdata("fun_id").'">
              <select name="gestion_usu" class="form-control" required>
               <option value="2017">seleccionar gestion</option>'; 
          foreach ($listar_gestion as $row) {
                if ($this->gestion==$row['ide']) {
                  $tabla.='<option value="'.$row['ide'].'" selected>'.$row['ide'].'</option>';
                }
                else{
                  $tabla.='<option value="'.$row['ide'].'" >'.$row['ide'].'</option>';
                }
            };
      $tabla.='  </select><br>
                <div align="right">
                    <BUTTON class="btn btn-xs btn-primary">
                      <div class="btn-hover-postion1">
                         CAMBIAR GESTI&Oacute;N
                      </div>
                  </BUTTON>
                </div>  
          </form>';

      return $tabla;
    }

    public function cambiar_gestion(){
        $nueva_gestion = strtoupper($this->input->post('gestion_usu'));
        $this->session->set_userdata('gestion', $nueva_gestion);

        redirect('consulta/mis_operaciones','refresh');
    }

    /*------------- Region Id ----------------*/
    public function region($dep_id){
      $acc_ope=$this->model_consultas->operaciones_regionales($dep_id);
      $tabla='';
      $nro=0;
      $tabla.='<tbody>'; 
      foreach($acc_ope as $row){
        $nombre=$row['tipo'].' '.$row['act_descripcion'].' '.$row['abrev'];
        $bgcolor='';
        if($row['tp_id']==1){
          $nombre=$row['proy_nombre'];
          $bgcolor='#e4f1fd';
        }

        $nro++;
        $tabla.='<tr class="modo1" style="height:40px;" bgcolor='.$bgcolor.'>';
            $tabla.='<td>'.$nro.'</td>';
            $tabla.='<td align=center>';
            if($row['tp_id']==1){
              $tabla.='<a href="javascript:abreVentana(\''.site_url("").'/proy/datos_generales_pi/'.$row['proy_id'].'\');" title="DATOS GENERALES" class="btn btn-default"><img src="'.base_url().'assets/ifinal/faseetapa.png" WIDTH="30" HEIGHT="30"/></a>';
            }
            else{
              $tabla.='<a href="javascript:abreVentana(\''.site_url("").'/prog/rep_datos_unidad/'.$row['act_id'].'\');" title="INFORMACIÓN BASICA" class="btn btn-default"><img src="'.base_url().'assets/ifinal/faseetapa.png" WIDTH="30" HEIGHT="30"/></a>';
            }
            $tabla.='
            </td>';
            if($this->gestion==2019){
              $tabla .='<td><center><a href="#" data-toggle="modal" data-target="#modal_nuevo_ff" class="btn btn-success enlace" name="'.$row['proy_id'].'" id="'.strtoupper($row['proy_nombre']).'">VER REPORTE POA</a></center></td>';
            }
            else{
              $tabla .='<td><center><a href="#" data-toggle="modal" data-target="#modal_nuevo_ff" class="btn btn-success enlace" name="'.$row['proy_id'].'" id="'.strtoupper($row['tipo']).' '.strtoupper($row['proy_nombre']).' - '.strtoupper($row['abrev']).'">VER REPORTE POA</a></center></td>';
            }
            $tabla.='<td align=center><a href="javascript:abreVentana(\''.site_url("").'/ejec/ver_notificacion_unidad/'.$row['proy_id'].'\');" title="NOTIFICACIÓN POA" class="btn btn-default"><img src="'.base_url().'assets/ifinal/requerimiento.png" WIDTH="25" HEIGHT="25"/></a></td>';
            $tabla.='<td>'.$row['aper_programa'].''.$row['aper_proyecto'].''.$row['aper_actividad'].'</td>';
            $tabla.='<td>'.$nombre.'</td>';
            $tabla.='<td>'.$row['escalon'].'</td>';
            $tabla.='<td>'.$row['nivel'].'</td>';
            $tabla.='<td>'.$row['tipo_adm'].'</td>';
            $tabla.='<td>'.strtoupper($row['dep_departamento']).'</td>';
            $tabla.='<td>'.strtoupper($row['dist_distrital']).'</td>';
            $tabla.='<td>'.$row['proy_sisin'].'</td>';
        $tabla.='</tr>';
      }
      $tabla.='</tbody>'; 

      return $tabla;
    }

    /*============= GENERAR MENU ===============*/
    function menu($mod){
      $enlaces=$this->menu_modelo->get_Modulos($mod);
      for($i=0;$i<count($enlaces);$i++) {
        $subenlaces[$enlaces[$i]['o_child']]=$this->menu_modelo->get_Enlaces($enlaces[$i]['o_child'], $this->session->userdata('user_name'));
      }

      $tabla ='';
      for($i=0;$i<count($enlaces);$i++){
          if(count($subenlaces[$enlaces[$i]['o_child']])>0){
              $tabla .='<li>';
                  $tabla .='<a href="#">';
                      $tabla .='<i class="'.$enlaces[$i]['o_image'].'"></i> <span class="menu-item-parent">'.$enlaces[$i]['o_titulo'].'</span></a>';    
                      $tabla .='<ul>';    
                          foreach ($subenlaces[$enlaces[$i]['o_child']] as $item) {
                          $tabla .='<li><a href="'.base_url($item['o_url']).'">'.$item['o_titulo'].'</a></li>';
                      }
                      $tabla .='</ul>';
              $tabla .='</li>';
          }
      }
      return $tabla;
    }
    /*----------------------------------------*/
    function rolfun($rol){
      $valor=false;
      for ($i=1; $i <=count($rol) ; $i++) { 
        $data = $this->Users_model->get_datos_usuario_roles($this->session->userdata('fun_id'),$rol[$i]);
        if(count($data)!=0){
          $valor=true;
          break;
        }
      }
      return $valor;
    }
    /*==========================================*/
    function estilo_vertical(){
        $estilo_vertical = '<style>
        body{
            font-family: sans-serif;
            }
        table{
            font-size: 7px;
            width: 100%;
            background-color:#fff;
        }
        .mv{font-size:10px;}
        .verde{ width:100%; height:5px; background-color:#1c7368;}
        .blanco{ width:100%; height:5px; background-color:#F1F2F1;}
        .siipp{width:120px;}

        .titulo_pdf {
            text-align: left;
            font-size: 8px;
        }
        .tabla {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 7px;
        width: 100%;

        }
        .tabla th {
        padding: 2px;
        font-size: 6px;
        background-color: #1c7368;
        background-repeat: repeat-x;
        color: #FFFFFF;
        border-right-width: 1px;
        border-bottom-width: 1px;
        border-right-style: solid;
        border-bottom-style: solid;
        border-right-color: #558FA6;
        border-bottom-color: #558FA6;
        text-transform: uppercase;
        }
        .tabla .modo1 {
        font-size: 6px;
        font-weight:bold;
       
        background-image: url(fondo_tr01.png);
        background-repeat: repeat-x;
        color: #34484E;
       
        }
        .tabla .modo1 td {
        padding: 1px;
        border-right-width: 1px;
        border-bottom-width: 1px;
        border-right-style: solid;
        border-bottom-style: solid;
        border-right-color: #A4C4D0;
        border-bottom-color: #A4C4D0;
        }
    </style>';
        return $estilo_vertical;
    }
}