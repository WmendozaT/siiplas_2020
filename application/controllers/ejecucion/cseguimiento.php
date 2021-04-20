<?php
class Cseguimiento extends CI_Controller {
  public $rol = array('1' => '3','2' => '4');
  public function __construct (){
        parent::__construct();
        if($this->session->userdata('fun_id')!=null & $this->session->userdata('fun_estado')!=3){
        $this->load->library('pdf2');
        $this->load->model('programacion/model_proyecto');
        $this->load->model('programacion/model_faseetapa');
        $this->load->model('programacion/model_actividad');
        $this->load->model('programacion/model_producto');
        $this->load->model('programacion/model_componente');
        $this->load->model('ejecucion/model_seguimientopoa');
        $this->load->model('ejecucion/model_evaluacion');
        $this->load->model('modificacion/model_modificacion');
        $this->load->model('reporte_eval/model_evalregional');
        $this->load->model('mantenimiento/model_configuracion');
        $this->load->model('menu_modelo');
        $this->load->model('Users_model','',true);
        $this->load->library('security');
        $this->gestion = $this->session->userData('gestion');
        $this->adm = $this->session->userData('adm');
        $this->rol = $this->session->userData('rol_id');
        $this->dist = $this->session->userData('dist');
        $this->dist_tp = $this->session->userData('dist_tp');
        $this->tmes = $this->session->userData('trimestre');
        $this->fun_id = $this->session->userData('fun_id');
        $this->tp_adm = $this->session->userData('tp_adm');
        $this->verif_mes=$this->verif_mes_gestion();
        $this->resolucion=$this->session->userdata('rd_poa');
        }else{
          $this->session->sess_destroy();
          redirect('/','refresh');
        }
    }

    /*------- TIPO DE RESPONSABLE ----------*/
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

    /*----- MIS POAS APROBADOS ------*/
    public function lista_poa(){
      $data['menu']=$this->menu(4); //// genera menu
      $data['resp']=$this->session->userdata('funcionario');
      $data['res_dep']=$this->tp_resp(); 
    
      $data['proyectos']='No disponible';
      $data['gasto_corriente']='No disponible';

      $data['proyectos']=$this->list_pinversion(4);
      $data['gasto_corriente']=$this->list_gasto_corriente(4);
      
      $data['titulo']='SEGUIMIENTO / EVALUACI&Oacute;N POA '.$this->gestion.'';
      $this->load->view('admin/evaluacion/seguimiento_poa/list_poas_aprobados', $data);

    }

    /*---- Lista de Unidades / Establecimientos de Salud (2020) -----*/
    public function list_gasto_corriente($proy_estado){
        $unidades=$this->model_proyecto->list_unidades(4,$proy_estado);
        $tabla='';
        
        $tabla.='
        <table id="dt_basic1" class="table1 table-bordered" style="width:100%;">
          <thead>
            <tr style="height:35px;">
              <th style="width:1%;" bgcolor="#474544">#</th>
              <th style="width:5%;" bgcolor="#474544" title="SELECCIONAR"></th>
              <th style="width:10%;" bgcolor="#474544" title="APERTURA PROGRAM&Aacute;TICA">CATEGORIA PROGRAM&Aacute;TICA '.$this->gestion.'</th>
              <th style="width:20%;" bgcolor="#474544" title="DESCRIPCI&Oacute;N">UNIDAD / ESTABLECIMIENTO DE SALUD</th>
              <th style="width:10%;" bgcolor="#474544" title="NIVEL">ESCALON</th>
              <th style="width:10%;" bgcolor="#474544" title="NIVEL">NIVEL</th>
              <th style="width:10%;" bgcolor="#474544" title="TIPO DE ADMINISTRACIÓN">TIPO DE ADMINISTRACI&Oacute;N</th>
              <th style="width:10%;" bgcolor="#474544" title="UNIDAD ADMINISTRATIVA">UNIDAD ADMINISTRATIVA</th>
              <th style="width:10%;" bgcolor="#474544" title="UNIDAD EJECUTORA">UNIDAD EJECUTORA</th>
            </tr>
          </thead>
          <tbody>';
            $nro=0;
            foreach($unidades as $row){
              $nro++;
                $tabla.='
                <tr style="height:45px;">
                  <td align=center><b>'.$nro.'</b></td>
                  <td align=center>
                    <a href="#" data-toggle="modal" data-target="#modal_nuevo_ff" class="btn btn-primary enlace" name="'.$row['proy_id'].'" name="'.$row['proy_id'].'" id=" '.$row['tipo'].' '.strtoupper($row['proy_nombre']).' - '.$row['abrev'].'">
                    <i class="glyphicon glyphicon-list"></i> MIS SUBACTIVIDADES</a>
                  </td>
                  <td><center>'.$row['aper_programa'].''.$row['aper_proyecto'].''.$row['aper_actividad'].'</center></td>
                  <td>'.$row['tipo'].' '.$row['act_descripcion'].' '.$row['abrev'].'</td>
                  <td>'.$row['escalon'].'</td>
                  <td>'.$row['nivel'].'</td>
                  <td>'.$row['tipo_adm'].'</td>
                  <td>'.strtoupper($row['dep_departamento']).'</td>
                  <td>'.strtoupper($row['dist_distrital']).'</td>
                </tr>';
            }
          $tabla.='
          </tbody>
        </table>';
      return $tabla;
    }

    /*---- Lista de Proyectos de Inversion (2020) -----*/
    public function list_pinversion($proy_estado){
      $proyectos=$this->model_proyecto->list_pinversion(1,$proy_estado);
      $tabla='';
      $tabla.='
        <table id="dt_basic" class="table table-bordered" style="width:100%;">
          <thead>
            <tr>
              <th style="width:1%;" bgcolor="#474544">#</th>
              <th style="width:5%;" bgcolor="#474544" title="MIS COMPONENTES"></th>
              <th style="width:10%;" bgcolor="#474544" title="APERTURA PROGRAM&Aacute;TICA">CATEGORIA PROGRAM&Aacute;TICA '.$this->gestion.'</th>
              <th style="width:25%;" bgcolor="#474544" title="DESCRIPCI&Oacute;N">PROYECTO DE INVERSI&Oacute;N</th>
              <th style="width:10%;" bgcolor="#474544" title="SISIN">C&Oacute;DIGO_SISIN</th>
              <th style="width:10%;" bgcolor="#474544" title="UNIDAD ADMINISTRATIVA">UNIDAD ADMINISTRATIVA</th>
              <th style="width:10%;" bgcolor="#474544" title="UNIDAD EJECUTORA">UNIDAD EJECUTORA</th>
              <th style="width:15%;" bgcolor="#474544" title="FASE - ETAPA DE LA OPERACI&Oacute;N">DESCRIPCI&Oacute;N FASE</th>
            </tr>
          </thead>
          <tbody>';
            $nro=0;
            foreach($proyectos as $row){
              $nro++;
              $tabla.='
                <tr style="height:35px;">
                  <td><center>'.$nro.'</center></td>
                  <td align=center>';
                  if($row['pfec_estado']==1){
                    $tabla.='<a href="#" data-toggle="modal" data-target="#modal_nuevo_ff" class="btn btn-primary enlace" name="'.$row['proy_id'].'" name="'.$row['proy_id'].'" id="'.strtoupper($row['proy_nombre']).'">
                    <i class="glyphicon glyphicon-list"></i> MIS SUBACTIVIDADES</a>';
                  }
                  else{
                    $tabla.='FASE NO ACTIVA';
                  }
                  $tabla.='
                  </td>
                <td><center>'.$row['aper_programa'].' '.$row['proy_sisin'].' '.$row['aper_actividad'].'</center></td>
                <td>'.$row['proy_nombre'].'</td>';
                $tabla.='<td>'.$row['proy_sisin'].'</td>';
                $tabla.='<td>'.$row['dep_cod'].' '.strtoupper($row['dep_departamento']).'</td>';
                $tabla.='<td>'.$row['dist_cod'].' '.strtoupper($row['dist_distrital']).'</td>';
                $tabla.='<td>'.strtoupper($row['pfec_descripcion']).'</td>';
              $tabla.='</tr>';
            }
          $tabla.='
          </tbody>
        </table>';
      
      return $tabla;
    }


    /*----- GET LISTA DE SUBACTIVIDADES -----*/
    public function get_subactividades(){
      if($this->input->is_ajax_request() && $this->input->post()){
        $post = $this->input->post();
        $proy_id = $this->security->xss_clean($post['proy_id']);

        $tabla=$this->mis_subactividades($proy_id);
        $result = array(
          'respuesta' => 'correcto',
          'tabla'=>$tabla,
        );
          
        echo json_encode($result);
      }else{
          show_404();
      }
    }

    /*------ GET SUBACTIVIDADES 2021 -----*/
    public function mis_subactividades($proy_id){
      $proyecto = $this->model_proyecto->get_id_proyecto($proy_id); ////// DATOS DEL PROYECTO
      $tabla='';
      $tabla.=' <table class="table table-bordered">
                  <thead>
                  <tr>
                    <th style="width:3%;" bgcolor="#474544"> COD.</th>
                    <th style="width:50%;" bgcolor="#474544"> SUBACTIVIDAD</th>
                    <th style="width:10%;" bgcolor="#474544">PONDERACI&Oacute;N</th>
                    <th style="width:10%;" bgcolor="#474544"></th>';
                    if($this->tp_adm==1){
                      $tabla.='<th style="width:10%;" bgcolor="#474544"></th>';
                    }
                    $tabla.='
                    <th style="width:1%;" bgcolor="#474544"></th>
                  </tr>
                  </thead>
                  <tbody>';
                  $nro_c=0;
                    $componentes=$this->model_componente->lista_subactividad($proy_id);
                    foreach($componentes as $rowc){
                      $verif=$this->model_seguimientopoa->get_seguimiento_poa_mes_subactividad($rowc['com_id'],$this->verif_mes[1]);
                      $nro_c++;
                      $tabla.='
                      <tr>
                        <td><b>'.$rowc['serv_cod'].'</b></td>
                        <td><b>'.$rowc['tipo_subactividad'].' '.$rowc['serv_descripcion'].'</b></td>
                        <td>'.$rowc['com_ponderacion'].'%</td>';
                          if($this->tp_adm==1){
                            $tabla.='
                              <td>
                                <a href="'.site_url("").'/seg/ver_seguimientopoa/'.$rowc['com_id'].'" id="myBtn'.$rowc['com_id'].'" class="btn btn-primary" title="REALIZAR SEGUIMIENTO">
                                   VER SEGUIMIENTO
                                </a>
                              </td>
                              <td>
                                <a href="'.site_url("").'/evalpoa/formulario_evaluacion_poa/'.$rowc['com_id'].'" id="myBtn'.$rowc['com_id'].'" class="btn btn-primary" title="REALIZAR EVALUACION POA">
                                   VER EVALUACION
                                </a>
                              </td>';
                          }
                          else{
                            $tabla.='<td>';
                            if(count($verif)!=0){
                                $tabla.='
                                <a href="'.site_url("").'/seg/ver_seguimientopoa/'.$rowc['com_id'].'" id="myBtn'.$rowc['com_id'].'" class="btn btn-default" title="MODIFICAR SEGUIMIENTO">
                                   MODIFICAR SEGUIMIENTO
                                </a>';
                            }
                            else{
                                $tabla.='
                                <a href="'.site_url("").'/seg/formulario_seguimiento_poa/'.$rowc['com_id'].'" id="myBtn'.$rowc['com_id'].'" class="btn btn-primary" title="REALIZAR SEGUIMIENTO">
                                   REALIZAR SEGUIMIENTO
                                </a>';
                            }
                            $tabla.='</td>';
                          }
                        $tabla.='
                        <td align=center><img id="load'.$rowc['com_id'].'" style="display: none" src="'.base_url().'/assets/img/loading.gif" width="25" height="25" title="ESPERE UN MOMENTO, LA PAGINA SE ESTA CARGANDO.."></td>
                      </tr>';
                      $tabla.=' <script>
                                  document.getElementById("myBtn'.$rowc['com_id'].'").addEventListener("click", function(){
                                  this.disabled = true;
                                  document.getElementById("load'.$rowc['com_id'].'").style.display = "block";
                                  });
                                </script>';

                    }
                  $tabla.='
                  </tbody>
                </table>';

      return $tabla;
    }


  /*------ EVALUAR OPERACION (Gasto Corriente-Proyecto de Inversion) 2021 ------*/
  public function formulario_segpoa($com_id){
      $data['menu']=$this->menu(4); //// genera menu
      $data['componente'] = $this->model_componente->get_componente($com_id); ///// DATOS DEL COMPONENTE
      if(count($data['componente'])!=0){

        $data['datos_mes'] = $this->verif_mes;
        $fase=$this->model_faseetapa->get_fase($data['componente'][0]['pfec_id']);
        $data['proyecto'] = $this->model_proyecto->get_datos_proyecto_unidad($fase[0]['proy_id']);
        $titulo=
        '<h1 title='.$data['proyecto'][0]['aper_id'].'><small>ACTIVIDAD : </small>'.$data['proyecto'][0]['aper_programa'].''.$data['proyecto'][0]['aper_proyecto'].''.$data['proyecto'][0]['aper_actividad'].' - '.$data['proyecto'][0]['tipo'].' '.$data['proyecto'][0]['proy_nombre'].' - '.$data['proyecto'][0]['abrev'].'</h1>
        <h1><small>SUBACTIVIDAD : </small> '.$data['componente'][0]['serv_descripcion'].'</h1>';

        if($data['proyecto'][0]['tp_id']==1){
          $titulo=
          '<h1 title='.$data['proyecto'][0]['aper_id'].'><small>PROYECTO : </small>'.$data['proyecto'][0]['aper_programa'].''.$data['proyecto'][0]['aper_proyecto'].''.$data['proyecto'][0]['aper_actividad'].' - '.$data['proyecto'][0]['tipo'].' '.$data['proyecto'][0]['proy_nombre'].' - '.$data['proyecto'][0]['abrev'].'</h1>
          <h1><small>SUBACTIVIDAD : </small> '.$data['componente'][0]['serv_descripcion'].'</h1>';
        }

        $data['operaciones_programados']=$this->lista_operaciones_programados($com_id,$data['datos_mes'][1]); /// Lista de Operaciones programados en el mes
        $data['seguimiento_operacion']=$this->temporalidad_operacion($com_id); /// temporalidad Programado-Ejecutado

        $data['titulo']=$titulo; /// Titulo de la cabecera
        $this->load->view('admin/evaluacion/seguimiento_poa/formulario_seguimiento', $data);
      }
      else{
        echo "Error !!!";
      }
  }


    /*------- LISTA DE  OPERACIONES 2021 ------*/
    function lista_operaciones_programados($com_id,$mes_id){
      $operaciones=$this->model_producto->list_operaciones_subactividad($com_id); /// lISTA DE OPERACIONES
      $datos_mes = $this->verif_mes;
      $tabla='';

      $tabla.=' <div class="table-responsive">
                <form class="smart-form" method="post">
                  <fieldset>
                    <table class="table table-bordered"width="100%">
                        <thead>
                          <tr>
                            <th colspan=8>DATOS POA (OPERACIONES)</th>
                            <th colspan=4>DATOS SEGUIMIENTO</th>
                          </tr>                  
                          <tr>
                            <th style="width:1%;"></th>
                            <th style="width:1%;"><b>COD. OR.</b></th>
                            <th style="width:1%;"><b>COD. OPE.</b></th>
                            <th style="width:15%;">OPERACI&Oacute;N</th>
                            <th style="width:10%;">INDICADOR</th>
                            <th style="width:3%;">META</th>
                            <th style="width:5%;">NO EJECUTADO</th>
                            <th style="width:5%;">PROG. '.$datos_mes[2].'</th>
                            <th style="width:5%;">SEG. '.$datos_mes[2].'</th>
                            <th style="width:10%;">MEDIO DE VERIFICACI&Oacute;N</th>
                            <th style="width:10%;">OBSERVACI&Oacute;N</th>
                            <th style="width:2%;"></th>
                          </tr>
                        </thead>
                        <tbody>';
                        $nro=0;
                        foreach($operaciones as $row){
                          $indi_id='';
                          if($row['indi_id']==2 & $row['mt_id']==1){
                            $indi_id='%';
                          }
                          $diferencia=$this->verif_valor_no_ejecutado($row['prod_id'],$mes_id);
                          if($diferencia[1]!=0 || $diferencia[2]!=0){
                            $ejec=$this->model_seguimientopoa->get_seguimiento_poa_mes($row['prod_id'],$mes_id);
                            $nro++;
                            $tabla.='
                            <tr>
                              <td align=center bgcolor="#f6fbf4">
                                '.$nro.'
                              </td>
                              <td style="width:1%;" align=center bgcolor="#f6fbf4"><b>'.$row['or_codigo'].'</b></td>
                              <td style="width:1%;" align=center bgcolor="#f6fbf4" title="'.$row['prod_id'].'"><b>'.$row['prod_cod'].'</b></td>
                              <td bgcolor="#f6fbf4">'.$row['prod_producto'].'</td>
                              <td bgcolor="#f6fbf4">'.$row['prod_indicador'].'</td>
                              <td align=right bgcolor="#f6fbf4"><b>'.round($row['prod_meta'],2).''.$indi_id.'</b></td>
                              <td align=center bgcolor="#f7e1e2">'.$diferencia[1].'</td>
                              <td align=center bgcolor="#f6fbf4">'.$diferencia[2].''.$indi_id.' <input type="hidden" name="pg_fis[]" value="'.($diferencia[1]+$diferencia[2]).'"></td>';
                              if(count($ejec)!=0){
                                $tabla.='
                                <td>
                                  <label class="input">
                                    <i class="icon-append fa fa-tag"></i>
                                    <input type="text" id=ejec'.$nro.' value="'.round($ejec[0]['pejec_fis'],2).'" onkeyup="verif_valor('.($diferencia[1]+$diferencia[2]).',this.value,'.$nro.');" title="'.($diferencia[1]+$diferencia[2]).'" onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }" onpaste="return false">
                                  </label>
                                </td>
                                <td>
                                  <label class="textarea">
                                    <i class="icon-append fa fa-tag"></i>
                                    <textarea rows="3" id=mv'.$nro.' title="MEDIO DE VERIFICACIÓN">'.$ejec[0]['medio_verificacion'].'</textarea>
                                  </label>
                                </td>
                                <td>
                                  <label class="textarea">
                                    <i class="icon-append fa fa-tag"></i>
                                    <textarea rows="3" id=obs'.$nro.' title="OBSERVACIÓN">'.$ejec[0]['observacion'].'</textarea>
                                  </label>
                                </td>';
                              }
                              else{
                                $tabla.='
                                <td>
                                  <label class="input">
                                    <i class="icon-append fa fa-tag"></i>
                                    <input type="text" id=ejec'.$nro.' value="0" onkeyup="verif_valor('.($diferencia[1]+$diferencia[2]).',this.value,'.$nro.');" title="'.($diferencia[1]+$diferencia[2]).'"  onkeypress="if (this.value.length < 10) { return numerosDecimales(event);}else{return false; }" onpaste="return false">
                                  </label>
                                </td>';
                                $no_ejec=$this->model_seguimientopoa->get_seguimiento_poa_mes_noejec($row['prod_id'],$mes_id);
                                if(count($no_ejec)!=0){
                                  $tabla.='
                                    <td>
                                      <label class="textarea">
                                        <i class="icon-append fa fa-tag"></i>
                                        <textarea rows="3" id=mv'.$nro.' title="MEDIO DE VERIFICACIÓN">'.$no_ejec[0]['medio_verificacion'].'</textarea>
                                      </label>
                                    </td>
                                    <td>
                                      <label class="textarea">
                                        <i class="icon-append fa fa-tag"></i>
                                        <textarea rows="3" id=obs'.$nro.' title="OBSERVACIÓN">'.$no_ejec[0]['observacion'].'</textarea>
                                      </label>
                                    </td>';
                                }
                                else{
                                  $tabla.='
                                  <td>
                                    <label class="textarea">
                                      <i class="icon-append fa fa-tag"></i>
                                      <textarea rows="3" id=mv'.$nro.' title="MEDIO DE VERIFICACIÓN"></textarea>
                                    </label>
                                  </td>
                                  <td>
                                    <label class="textarea">
                                      <i class="icon-append fa fa-tag"></i>
                                      <textarea rows="3" id=obs'.$nro.' title="OBSERVACIÓN"></textarea>
                                    </label>
                                  </td>';
                                }
                                
                              }
                              $tabla.='
                              <td align=center title="GUARDAR SEGUIMIENTO POA">
                                <div id="but'.$nro.'" style="display:none;"><button type="button" name="'.$row['prod_id'].'" id="'.$nro.'" onclick="guardar('.$row['prod_id'].','.$nro.');"  class="btn btn-default"><img src="'.base_url().'assets/Iconos/disk.png" WIDTH="37" HEIGHT="37"/></button></div>
                              </td>
                            </tr>';
                          }
                        }
                        $tabla.='
                        </tbody>
                    </table>
                  </fieldset>   
                  </form>
              </div>';

      return $tabla;
    }


    /*---VERIFICANDO VALORES NO EJECUTADOS EN MESES ANTERIORES --*/
    function verif_valor_no_ejecutado($prod_id,$mes){
      $producto=$this->model_producto->get_producto_id($prod_id);
      $diferencia[1]=0;$diferencia[2]=0;$diferencia[3]=0;
      $sum_prog=0;
      $sum_ejec=0;
      for ($i=1; $i <=$mes-1; $i++) { 
        $prog=$this->model_seguimientopoa->get_programado_poa_mes($prod_id,$i);
        if(count($prog)!=0){
          $sum_prog=$sum_prog+$prog[0]['pg_fis'];
        }

        $ejec=$this->model_seguimientopoa->get_seguimiento_poa_mes($prod_id,$i);
        if(count($ejec)!=0){
          $sum_ejec=$sum_ejec+$ejec[0]['pejec_fis'];
        }
      }


      $prog=$this->model_seguimientopoa->get_programado_poa_mes($prod_id,$mes);
      $diferencia[2]=0;
      if(count($prog)!=0){
        $diferencia[2]=round($prog[0]['pg_fis'],2);
      }

      $ejec=$this->model_seguimientopoa->get_seguimiento_poa_mes($prod_id,$mes);
      $diferencia[3]=0;
      if(count($ejec)!=0){
        $diferencia[3]=round($ejec[0]['pejec_fis'],2);
      }

      $diferencia[1]=($sum_prog-$sum_ejec); /// no ejecutado en el mes anterior
      if($producto[0]['indi_id']==2 & $producto[0]['mt_id']==1){
        $diferencia[1]=0;
      }
      
      return $diferencia;
    }


    /*---- VALIDA ADD SEGUIMIENTO POA ----*/
    public function guardar_seguimiento(){
      if($this->input->is_ajax_request() && $this->input->post()){
        $post = $this->input->post();
        $prod_id = $this->security->xss_clean($post['prod_id']);
        $ejec = $this->security->xss_clean($post['ejec']);
        $mv = $this->security->xss_clean($post['mv']);
        $obs = $this->security->xss_clean($post['obs']);
        
        /// ----- Eliminando Registro --------
          $this->db->where('prod_id', $prod_id);
          $this->db->where('m_id', $this->verif_mes[1]);
          $this->db->where('g_id', $this->gestion);
          $this->db->delete('prod_ejecutado_mensual');
        /// -----------------------------------

          if($ejec!=0){
            $this->model_producto->add_prod_ejec_gest($prod_id,$this->gestion,$this->verif_mes[1],$ejec,$mv,$obs);
          }
          else{
            $no_ejec=$this->model_seguimientopoa->get_seguimiento_poa_mes_noejec($prod_id,$this->verif_mes[1]);
            if(count($no_ejec)!=0){
              if(($no_ejec[0]['medio_verificacion']!=$mv) || ($no_ejec[0]['observacion']!=$obs)){
                $this->model_producto->add_no_ejec_prod($prod_id,$this->verif_mes[1],$mv,$obs); 
              }
            }
            else{
              $this->model_producto->add_no_ejec_prod($prod_id,$this->verif_mes[1],$mv,$obs);  
            }
            
          }

        $result = array(
          'respuesta' => 'correcto',
        );
  
        echo json_encode($result);
      }else{
          show_404();
      }
    }


  /*------ VER EVALUACION POA (Gasto Corriente-Proyecto de Inversion)2020 ------*/
  public function ver_evaluacion_poa($com_id){
      $data['menu']=$this->menu(4); //// genera menu
      $data['componente'] = $this->model_componente->get_componente($com_id); ///// DATOS DEL COMPONENTE
      if(count($data['componente'])!=0){

        $data['datos_mes'] = $this->verif_mes;
        $fase=$this->model_faseetapa->get_fase($data['componente'][0]['pfec_id']);
        $data['proyecto'] = $this->model_proyecto->get_datos_proyecto_unidad($fase[0]['proy_id']);
        $titulo=
        '<h1 title='.$data['proyecto'][0]['aper_id'].'><small>ACTIVIDAD : </small>'.$data['proyecto'][0]['aper_programa'].''.$data['proyecto'][0]['aper_proyecto'].''.$data['proyecto'][0]['aper_actividad'].' - '.$data['proyecto'][0]['tipo'].' '.$data['proyecto'][0]['proy_nombre'].' - '.$data['proyecto'][0]['abrev'].'</h1>
        <h1><small>SUBACTIVIDAD : </small> '.$data['componente'][0]['serv_descripcion'].'</h1>';

        if($data['proyecto'][0]['tp_id']==1){
          $titulo=
          '<h1 title='.$data['proyecto'][0]['aper_id'].'><small>PROYECTO : </small>'.$data['proyecto'][0]['aper_programa'].''.$data['proyecto'][0]['aper_proyecto'].''.$data['proyecto'][0]['aper_actividad'].' - '.$data['proyecto'][0]['tipo'].' '.$data['proyecto'][0]['proy_nombre'].' - '.$data['proyecto'][0]['abrev'].'</h1>
          <h1><small>SUBACTIVIDAD : </small> '.$data['componente'][0]['serv_descripcion'].'</h1>';
        }

        $data['seguimiento_operacion']=$this->temporalidad_operacion($com_id); /// temporalidad Programado-Ejecutado
        $data['titulo']=$titulo; /// Titulo de la cabecera
        $this->load->view('admin/evaluacion/seguimiento_poa/ver_seguimientopoa', $data);
      }
      else{
        echo "Error !!!";
      }
  }


    /*----- REPORTE SEGUIMIENTO POA PDF 2021 MENSUAL -------*/
    public function ver_reporteevalpoa($com_id){
      $data['componente'] = $this->model_componente->get_componente($com_id); ///// DATOS DEL COMPONENTE
      if(count($data['componente'])!=0){
        $data['mes'] = $this->mes_nombre();
        $data['fase']=$this->model_faseetapa->get_fase($data['componente'][0]['pfec_id']); /// DATOS FASE
        $data['proyecto'] = $this->model_proyecto->get_id_proyecto($data['fase'][0]['proy_id']); //// DATOS PROYECTO
        if($data['proyecto'][0]['tp_id']==4){
          $data['proyecto'] = $this->model_proyecto->get_datos_proyecto_unidad($data['fase'][0]['proy_id']); /// PROYECTO
        }
        $data['cabecera']=$this->cabecera($data['componente'],$data['proyecto']); /// Cabecera
        $data['datos_mes'] = $this->verif_mes;

        /// ----------------------------------------------------
        $operaciones=$this->model_producto->list_operaciones_subactividad($com_id); /// lISTA DE OPERACIONES
        $tabla='';
        $tabla.='<table cellpadding="0" cellspacing="0" class="tabla" border=0.2 style="width:100%;" align=center>
                <thead>
                  <tr bgcolor=#f8f2f2 align=center>
                    <th style="font-size: 7px; height:17px;" colspan=9>DATOS POA (OPERACIONES)</th>
                    <th colspan=3>DATOS SEGUIMIENTO</th>
                  </tr>   
                  <tr style="font-size: 7px; height:17px;" bgcolor=#f8f2f2 align=center>
                    <th style="width:1%;"></th>
                    <th style="width:3%;"><b>COD. OR.</b></th>
                    <th style="width:3%;"><b>COD. OPE.</b></th>
                    <th style="width:20%;">OPERACI&Oacute;N</th>
                    <th style="width:13%;">INDICADOR</th>
                    <th style="width:3%;">META</th>
                    <th style="width:3%;">PROG.</th>
                    <th style="width:3%;">EJEC.</th>
                    <th style="width:3%;">%EFI.</th>
                    <th style="width:18%;">MEDIO DE VERIFICACIÓN</th> 
                    <th style="width:18%;">OBSERVACI&Oacute;N</th> 
                  </tr>
                </thead>
                <tbody>';
                $nro=0;
                foreach($operaciones as $row){
                  $indi_id='';
                  if($row['indi_id']==2 & $row['mt_id']==1){
                    $indi_id='%';
                  }
                  $diferencia=$this->verif_valor_no_ejecutado($row['prod_id'],$this->verif_mes[1]);
                  
                  if($diferencia[1]!=0 || $diferencia[2]!=0){
                    $ejec=$this->model_seguimientopoa->get_seguimiento_poa_mes($row['prod_id'],$this->verif_mes[1]);
                    $color='';
                    $nro++;
                    $tabla.=
                    '<tr style="height:15px; font-size: 6.5px;" bgcolor="'.$color.'">
                        <td style="height:15px;  width: 1%; text-align: center;" >'.$nro.'</td>
                        <td style="width: 3%; text-align: center; font-size: 9px;"><b>'.$row['or_codigo'].'</b></td>
                        <td style="width: 3%; text-align: center; font-size: 9px;"><b>'.$row['prod_cod'].'</b></td>
                        <td style="width: 20%;">'.$row['prod_producto'].'</td>
                        <td style="width: 13%;">'.$row['prod_indicador'].'</td>
                        <td align=right>'.round($row['prod_meta'],2).'</td>
                        <td style="width: 3%; text-align: right;">'.$diferencia[1].'</td>';
                        if(count($ejec)!=0){
                            $tabla.='
                            <td style="width: 3%; text-align: right;">'.$diferencia[2].'</td>
                            <td style="width: 3%; text-align: right;"></td>
                            <td style="width: 15%;">'.$ejec[0]['medio_verificacion'].'</td>
                            <td style="width: 15%;">'.$ejec[0]['observacion'].'</td>';
                          }
                        else{
                          $tabla.='<td style="width: 3%; text-align: right;">0</td>';
                          $no_ejec=$this->model_seguimientopoa->get_seguimiento_poa_mes_noejec($row['prod_id'],$data['datos_mes'][1]);
                          if(count($no_ejec)!=0){
                            $tabla.='
                            <td style="width: 3%; text-align: right;"></td>
                            <td style="width: 15%;">'.$no_ejec[0]['medio_verificacion'].'</td>
                            <td style="width: 15%;">'.$no_ejec[0]['observacion'].'</td>';
                          }
                          else{
                            $tabla.='
                            <td style="width: 3%; text-align: right;"></td>
                            <td style="width: 15%;"></td>
                            <td style="width: 15%;"></td>';
                          }
                        }
                        $tabla.='
                    </tr>';
                  }

                }
                $tabla.='
                </tbody>
              </table>';
        /// -----------------------------------------------------

        $data['operaciones']=$tabla; /// Reporte Gasto Corriente, Proyecto de Inversion 2020
        $this->load->view('admin/evaluacion/seguimiento_poa/reporte_seguimiento_poa', $data);
      }
      else{
        echo "Error !!!";
      }
    }


    /*----- REPORTE SEGUIMIENTO POA PDF 2021 CONSOLIDADO DE TODOS LOS MESES -------*/
    public function ver_reporteevalpoa_consolidado($com_id){
      $data['componente'] = $this->model_componente->get_componente($com_id); ///// DATOS DEL COMPONENTE
      if(count($data['componente'])!=0){
        $data['mes'] = $this->mes_nombre();
        $data['fase']=$this->model_faseetapa->get_fase($data['componente'][0]['pfec_id']); /// DATOS FASE
        $data['proyecto'] = $this->model_proyecto->get_id_proyecto($data['fase'][0]['proy_id']); //// DATOS PROYECTO
        if($data['proyecto'][0]['tp_id']==4){
          $data['proyecto'] = $this->model_proyecto->get_datos_proyecto_unidad($data['fase'][0]['proy_id']); /// PROYECTO
        }
        $data['cabecera']=$this->cabecera($data['componente'],$data['proyecto']); /// Cabecera
        $data['datos_mes'] = $this->verif_mes;

        /// ----------------------------------------------------
        $operaciones=$this->model_producto->list_operaciones_subactividad($com_id); /// lISTA DE OPERACIONES
        $tabla='';
        $tabla.=' <table cellpadding="0" cellspacing="0" class="tabla" border=0.2 style="width:100%;" align=center>
                <thead>
                 <tr style="font-size: 7px;" bgcolor=#1c7368 align=center>
                    <th style="width:1%;height:15px;color:#FFF;">#</th>
                    <th style="width:2%;color:#FFF;">COD.<br>OR.</th>
                    <th style="width:2%;color:#FFF;">COD.<br>OPE.</th> 
                    <th style="width:10%;color:#FFF;">OPERACI&Oacute;N</th>
                    <th style="width:10%;color:#FFF;">RESULTADO</th>
                    <th style="width:10%;color:#FFF;">INDICADOR</th>
                    <th style="width:3%;color:#FFF;">L.B.</th>
                    <th style="width:3%;color:#FFF;">META</th>
                    <th style="width:3.5%;color:#FFF;">PROG.</th>
                    <th style="width:3.5%;color:#FFF;">EJEC.</th>
                    <th style="width:3.5%;color:#FFF;">%EFI</th>
                    <th style="width:5%;color:#FFF;"></th>

                    
                    <th style="width:3%;color:#FFF;">ENE.</th>
                    <th style="width:3%;color:#FFF;">FEB.</th>
                    <th style="width:3%;color:#FFF;">MAR.</th>
                    <th style="width:3%;color:#FFF;">ABR.</th>
                    <th style="width:3%;color:#FFF;">MAY.</th>
                    <th style="width:3%;color:#FFF;">JUN.</th>
                    <th style="width:3%;color:#FFF;">JUL.</th>
                    <th style="width:3%;color:#FFF;">AGO.</th>
                    <th style="width:3%;color:#FFF;">SEPT.</th>
                    <th style="width:3%;color:#FFF;">OCT.</th>
                    <th style="width:3%;color:#FFF;">NOV.</th>
                    <th style="width:3%;color:#FFF;">DIC.</th>
                </tr>
                </thead>
                <tbody>';
                  $nro=0;
                  foreach($operaciones as $rowp){
                    $programado=$this->model_producto->meta_prod_gest($rowp['prod_id']);
                    $ejecutado=$this->model_producto->suma_total_evaluado($rowp['prod_id']);
                    $prog=0;
                    if(count($programado)!=0){
                      $prog=$programado[0]['meta_gest'];
                    }

                    $ejec=0;
                    if(count($ejecutado)!=0){
                      $ejec=$ejecutado[0]['suma_total'];
                    }

                    $tit='<p style="color:red"><b>NO CUMPLIDO</b></p>';
                    if($ejec==$prog){
                      $tit='<p style="color:green"><b>CUMPLIDO</b></p>';
                    }
                    elseif ($ejec<$prog & $ejec!=0) {
                      $tit='<p style="color:orange"><b>EN PROCESO</b></p>';
                    }

                      $nro++;
                      $tabla .='
                      <tr >
                        <td style="width: 1%; text-align: center; height:50px; font-size: 3px;" title='.$rowp['prod_id'].'>'.$nro.'</td>
                        <td style="width: 2%; text-align: center;">'.$rowp['or_codigo'].'</td>
                        <td style="width: 2%; text-align: center; font-size: 8px;" bgcolor="#eceaea"><b>'.$rowp['prod_cod'].'</b></td>
                        <td style="width: 7%; text-align: left;">'.$rowp['prod_producto'].'</td>
                        <td style="width: 7%; text-align: left;">'.$rowp['prod_resultado'].'</td>
                        <td style="width: 7%; text-align: left;">'.$rowp['prod_indicador'].'</td>
                        <td style="width: 2%; text-align: right;">'.round($rowp['prod_linea_base'],2).'</td>
                        <td style="width: 2%; text-align: right;">'.round($rowp['prod_meta'],2).'</td>
                        <td style="width: 2.5%; text-align: center; font-size: 9px;" bgcolor="#eceaea"><b>'.round($prog,2).'</b></td>
                        <td style="width: 2.5%; text-align: center; font-size: 9px;" bgcolor="#eceaea"><b>'.round($ejec,2).'</b></td>
                        <td style="width: 2.5%; text-align: center; font-size: 9px;" bgcolor="#e9f7e9"><b>'.round((($ejec/$prog)*100),2).'%</b></td>
                        <td style="width: 7%; text-align: left;">'.$tit.'</td>';
                        $temp=$this->temporalizacion_productos($rowp['prod_id']);

                        for ($i=1; $i <=12 ; $i++) { 
                          $tabla.='
                          <td style="width: 3%; text-align: center;font-size: 7px;">
                            <table cellpadding="0" cellspacing="0" class="tabla" border=0.2 style="width:90%;" align=center>
                              <tr><td style="width:50%;"><b>P:</b></td><td style="width:50%;">'.round($temp[1][$i],2).'</td></tr>
                              <tr><td style="width:50%;"><b>E:</b></td><td style="width:50%;">'.round($temp[4][$i],2).'</td></tr>
                            </table>
                          </td>';
                        }
                        $tabla.='
                      </tr>';
                  }
                $tabla.='
                </tbody>
              </table>';

        $data['operaciones']=$tabla; /// Reporte Gasto Corriente, Proyecto de Inversion 2020
        $this->load->view('admin/evaluacion/seguimiento_poa/reporte_seguimiento_poa_consolidado', $data);
      }
      else{
        echo "Error !!!";
      }
    }

    /*----- TITULO DEL REPORTE tp:1 (pdf), 2:(Excel) 2021 -----*/
    public function cabecera($componente,$proyecto){
      $tabla='';
      $tabla.=' <table border="0" cellpadding="0" cellspacing="0" class="tabla" style="width:100%;" align="center">
                    <tr>
                      <td colspan="2" style="width:100%; height: 1.2%; font-size: 14pt;"><b>'.$this->session->userdata('entidad').'</b></td>
                    </tr>
                    <tr style="font-size: 8pt;">
                      <td style="width:10%; height: 1.2%;"><b>DIR. ADM.</b></td>
                      <td style="width:90%;">: '.$proyecto[0]['dep_cod'].' '.strtoupper($proyecto[0]['dep_departamento']).'</td>
                    </tr>
                    <tr style="font-size: 8pt;">
                      <td style="width:10%; height: 1.2%;"><b>UNI. EJEC.</b></td>
                      <td style="width:90%;">: '.$proyecto[0]['dist_cod'].' '.strtoupper($proyecto[0]['dist_distrital']).'</td>
                    </tr>
                    <tr style="font-size: 8pt;">';
                        if($proyecto[0]['tp_id']==1){ /// Proyecto de Inversion
                            $tabla.='
                            <td style="width:10%;"><b>PROY. INV.</b></td>
                            <td style="width:90%;">: '.$proyecto[0]['aper_programa'].' '.$proyecto[0]['proy_sisin'].' 000 - '.$proyecto[0]['proy_nombre'].'</td>';
                        }
                        else{ /// Gasto Corriente
                            $tabla.='
                            <td style="width:10%;"><b>ACTIVIDAD</b></td>
                            <td style="width:90%;">: '.$proyecto[0]['aper_programa'].' '.$proyecto[0]['aper_proyecto'].' '.$proyecto[0]['aper_actividad'].' - '.strtoupper($proyecto[0]['act_descripcion']).' '.$proyecto[0]['abrev'].'</td>';
                        }

                    $tabla.='
                    </tr>
                    <tr style="font-size: 8pt;">
                        <td style="height: 1.2%; width:10%;"><b>';
                          if($proyecto[0]['tp_id']==1){
                            $tabla.='UNI. RESP. ';
                          }
                          else{
                            $tabla.='SUBACT. ';
                          }
                        $tabla.='</b></td>
                        <td style="width:90%;">: '.strtoupper($componente[0]['serv_cod']).' '.strtoupper($componente[0]['tipo_subactividad']).' '.strtoupper($componente[0]['serv_descripcion']).'</td>
                    </tr>
                </table>';
      return $tabla;
    }


  /*--- Ver Tabla de Temporalidad Programado/Ejecutado ---*/
  public function temporalidad_operacion($com_id){
    $tabla='';
    $operaciones=$this->model_producto->list_operaciones_subactividad($com_id);

    $tabla.=' <hr><table class="table table-bordered" width="100%" align=center>
                <thead>
                 <tr style="font-size: 7px;" align=center>
                    <th style="width:1%;height:15px;">#</th>
                    <th style="width:2%;">COD.<br>OR.</th>
                    <th style="width:2%;">COD.<br>OPE.</th> 
                    <th style="width:7%;">OPERACI&Oacute;N</th>
                    <th style="width:7%;">RESULTADO</th>
                    <th style="width:7%;">INDICADOR</th>
                    <th style="width:2%;">L.B.</th> 
                    <th style="width:2%;">META</th>
                    <th style="width:3%;">ENE.</th>
                    <th style="width:3%;">FEB.</th>
                    <th style="width:3%;">MAR.</th>
                    <th style="width:3%;">ABR.</th>
                    <th style="width:3%;">MAY.</th>
                    <th style="width:3%;">JUN.</th>
                    <th style="width:3%;">JUL.</th>
                    <th style="width:3%;">AGO.</th>
                    <th style="width:3%;">SEPT.</th>
                    <th style="width:3%;">OCT.</th>
                    <th style="width:3%;">NOV.</th>
                    <th style="width:3%;">DIC.</th>

                </tr>
                </thead>
                <tbody>';
                  $nro=0;
                  foreach($operaciones as $rowp){
                    $temp=$this->temporalizacion_productos($rowp['prod_id']);
                    $nro++;
                    $tabla .='
                    <tr >
                      <td style="width: 1%; text-align: center; height:50px;" title='.$rowp['prod_id'].'>'.$nro.'</td>
                      <td style="width: 3%; text-align: center;"><b>'.$rowp['or_codigo'].'</b></td>
                      <td style="width: 3%; text-align: center;"><b>'.$rowp['prod_cod'].'</b></td>
                      <td style="width: 7%; text-align: left;">'.$rowp['prod_producto'].'</td>
                      <td style="width: 7%; text-align: left;">'.$rowp['prod_resultado'].'</td>
                      <td style="width: 7%; text-align: left;">'.$rowp['prod_indicador'].'</td>
                      <td style="width: 2%; text-align: right;">'.round($rowp['prod_linea_base'],2).'</td>
                      <td style="width: 2%; text-align: right;">'.round($rowp['prod_meta'],2).'</td>';
                      
                      for ($i=1; $i <=12 ; $i++) { 
                        $color='';
                        if($this->verif_mes[1]==$i){
                          $color='#e9f5e3';
                        }

                        $tabla.='
                        <td style="width: 3%; text-align: center;font-size: 7px;" bgcolor='.$color.'>
                          <table class="table table-bordered" align=center>
                            <tr><td style="width:50%;"><b>P:</b></td><td style="width:50%;">'.round($temp[1][$i],2).'</td></tr>
                            <tr><td style="width:50%;"><b>E:</b></td><td style="width:50%;">'.round($temp[4][$i],2).'</td></tr>
                          </table>
                        </td>';
                      }
                      $tabla.='
                    </tr>';
                  }
                $tabla.='
                </tbody>
              </table>';

    return $tabla;
  }


    /*--- GET LISTA DE OPERACIONES MES (SEGUIMIENTO) ----*/
    public function get_operaciones_mes(){
      if($this->input->is_ajax_request() && $this->input->post()){
        $post = $this->input->post();
        $dist_id = $this->security->xss_clean($post['dist_id']);

        $tabla=$this->seguimiento_operaciones_mes($dist_id);
        $result = array(
          'respuesta' => 'correcto',
          'tabla'=>$tabla,
        );
          
        echo json_encode($result);
      }else{
          show_404();
      }
    }

    /*--- LISTA DE OPERACIONES A EJECUTAR EN EL MES ----*/
    public function seguimiento_operaciones_mes($dist_id){
      $unidades=$this->model_seguimientopoa->get_lista_unidad_operaciones($dist_id,$this->verif_mes[1],$this->gestion);
      //$operaciones=$this->model_seguimientopoa->get_seguimiento_poa_mes_distrital($dist_id,$this->verif_mes[1],$this->gestion);
      $tabla='';
      $tabla.='
        <article>
          <div class="jarviswidget well transparent" id="wid-id-9" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
            <header>
              <span class="widget-icon"> <i class="fa fa-comments"></i> </span>
              <h2>OPERACIONES PROGRAMADAS MES '.$this->verif_mes[2].' - '.$this->gestion.'</h2>
            </header>
            <div>
              <div class="jarviswidget-editbox">
              </div>
              <div class="widget-body">
                <div class="panel-group smart-accordion-default" id="accordion">';
                $nro=0;
                  foreach ($unidades as $rowp) {
                  $operaciones=$this->model_seguimientopoa->get_lista_operaciones_programados($dist_id,$this->verif_mes[1],$this->gestion,$rowp['proy_id']);
                  $nro++;
                  $tabla.='
                  <div class="panel panel-default">
                    <div class="panel-heading" align=left>
                      <h4 class="panel-title" title='.$rowp['proy_id'].'><a data-toggle="collapse" data-parent="#accordion" href="#collapseOne'.$nro.'"> 
                        <img src="'.base_url().'assets/Iconos/arrow_down.png" WIDTH="25" HEIGHT="15"/>'.$rowp['tipo'].' '.$rowp['act_descripcion'].' '.$rowp['abrev'].'</a> ('.$rowp['operaciones'].') 
                        <a href="'.site_url("").'/seg/notificacion_operaciones_mensual/'.$rowp['proy_id'].'" target=_blank ><img src="'.base_url().'assets/ifinal/requerimiento.png" WIDTH="16" HEIGHT="16"/></a>
                      </h4>
                    </div>
                    <div id="collapseOne'.$nro.'" class="panel-collapse collapse">
                      <div class="panel-body">';
                        $tabla.='
                          <section class="col col-6" align=left>
                            <input id="searchTerm'.$nro.'" type="text" onkeyup="doSearch('.$nro.')" class="form-control" placeholder="BUSCADOR...." style="width:45%;"/><br>
                          </section>
                          <table class="table table-bordered" border=1 style="width:100%;" id="datos'.$nro.'">
                                <thead>
                                  <tr align=center>
                                    <th style="width:1%;">#</th>
                                    <th style="width:10%;" align=center>ACTIVIDAD</th>
                                    <th style="width:10%;" align=center>SUBACTIVIDAD</th>
                                    <th style="width:25%;" align=center>OPERACI&Oacute;N</th>
                                    <th style="width:3%;" align=center>PROGRAMADO</th>
                                    <th style="width:3%;" align=center>EJECUTADO</th>
                                    <th style="width:1%;"></th>
                                  </tr>
                                </thead>
                                <tbody>';
                                $nro_ope=0;
                                foreach ($operaciones as $row) {
                                  $ejec=$this->model_producto->verif_ope_evaluado_mes($row['prod_id'],$this->verif_mes[1]);
                                  $evaluado=0;
                                  if(count($ejec)!=0){
                                    $evaluado=$ejec[0]['pejec_fis'];
                                  }
                                  $nro_ope++;
                                  $tabla.='
                                  <tr>
                                    <td align=center>'.$nro_ope.'</td>
                                    <td><b>'.$row['aper_actividad'].' '.$row['tipo'].' '.$row['act_descripcion'].'</b></td>
                                    <td>'.$row['serv_cod'].' '.$row['tipo_subactividad'].' '.$row['serv_descripcion'].'</td>
                                    <td bgcolor="#ddf8f5">'.$row['prod_cod'].' .- '.$row['prod_producto'].'</td>
                                    <td bgcolor="#ddf8f5">'.round($row['pg_fis'],2).'</td>
                                    <td bgcolor="#ddf8f5">'.round($evaluado,2).'</td>
                                    <td bgcolor="#ddf8f5">
                                      <a href="'.site_url("").'/seg/formulario_seguimiento_poa/'.$row['com_id'].'"  target="_blank" title="REALIZAR SEGUIMIENTO">
                                        <img src="'.base_url().'assets/Iconos/application_go.png" WIDTH="20" HEIGHT="20"/></b>
                                      </a>
                                    </td>
                                  </tr>';
                                }
                            $tabla.=
                                '</tbody>
                              </table>';
                      $tabla.='
                      </div>
                    </div>
                  </div>';
                  }
                $tabla.='
                </div>
              </div>
            </div>
          </div>
        </article>';
      return $tabla;
    }



    /*----- REPORTE NOTIFICACION POA MENSUAL POR GASTO CORRIENTE 2021 -----*/
    public function reporte_notificacion_operaciones_mensual($proy_id){
      $data['proyecto'] = $this->model_proyecto->get_datos_proyecto_unidad($proy_id); /// PROYECTO
      if(count($data['proyecto'])!=0){
        $data['mes'] = $this->mes_nombre();
        $data['subactividades']=$this->model_seguimientopoa->get_lista_subactividades_operaciones_programados($data['proyecto'][0]['dist_id'],$this->verif_mes[1],$this->gestion,$proy_id);
        $data['verif_mes']=$this->verif_mes;
        $data['principal']=$this->cuerpo_nota_notificacion($proy_id);
        $this->load->view('admin/evaluacion/seguimiento_poa/reporte_notificacion_seguimiento', $data); 
      }
      else{
        echo "Error !!!";
      }

    }


    public function cuerpo_nota_notificacion($proy_id){
      $proyecto = $this->model_proyecto->get_datos_proyecto_unidad($proy_id); /// PROYECTO
      $tabla='';
      $tabla.='
      <page backtop="42mm" backbottom="35.5mm" backleft="5mm" backright="5mm" pagegroup="new">
      <page_header>
          <br><div class="verde"></div>
          <table class="page_header" border="0" style="width:100%;">
              <tr>
                <td style="width:15%; text-align:center;">
                  <img src="'.base_url().'assets/ifinal/cns_logo.JPG" alt="" style="width:50%;">
                </td>
                  <td style="width: 70%; text-align: left">
                    <table border="0" cellpadding="0" cellspacing="0" class="tabla" style="width:100%;">
                      <tr>
                        <td style="width:100%; font-size:30px;" align=center>
                          <b>'.$this->session->userdata('entidad').'</b>
                        </td>
                      </tr>
                      <tr>
                        <td style="width:100%; font-size:15px;" align=center>
                          DEPARTAMENTO NACIONAL DE PLANIFICACI&Oacute;N
                        </td>
                      </tr>
                    </table>
                  </td>
                <td style="width:15%;font-size: 8px;" align=center>
                </td>
              </tr>
          </table><br>
          <div align="center"><b>SEGUIMIENTO POA</b></div><br>
      </page_header>
      
      <page_footer>
          <hr>
          <table border="0" cellpadding="0" cellspacing="0" class="tabla" style="width:96%;" align="center">
              <tr>
                  <td colspan="3"><br><br></td>
              </tr>
              <tr>
                  <td style="width: 33%; text-align: left">
                    POA - '.$this->gestion.' '.$this->resolucion.'
                  </td>
                  <td style="width: 33%; text-align: center">
                  jdsalñjdsald
                  </td>
                  <td style="width: 33%; text-align: right">
                      
                  </td>
              </tr>
              <tr>
                  <td colspan="3"><br><br></td>
              </tr>
          </table>
      </page_footer>



      Director : CIMFA <br>
      Presente.- <br><br>

      <table border="1" style="width:100%;">
        <tr>
          <td style="height:50px;">
          El Departamento Nacional de Planificaci&oacute;n en el marco de sus competencias viene fortaleciendo las tareas de monitoreo y supervisi&oacute;n 
          a traves del Sistema de Planificaci&oacute;n SIIPLAS, en este sentido recordamos a usted efectuar el seguimiento al cumplimiento del POA '.$this->verif_mes[2].' '.$this->gestion.', 
          del '.$proyecto[0]['tipo_adm'].' a su cargo, haciendo enfasis en laprogramaci&oacute;n mensual y periodo de ejecuci&oacute;n de cada operaci&oacute;n.
          </td>
        </tr>
      </table>

  </page>';

      return $tabla;
    }




    /// ===================================================================
    /*--- TEMPORALIZACION DE PRODUCTOS (nose esta tomando encuenta lb) ---*/
    public function temporalizacion_productos($prod_id){
      $producto = $this->model_producto->get_producto_id($prod_id);
      $prod_prog= $this->model_producto->producto_programado($prod_id,$this->gestion);//// Temporalidad Programado
      $prod_ejec= $this->model_producto->producto_ejecutado($prod_id,$this->gestion); //// Temporalidad ejecutado

      $mp[1]='enero';
      $mp[2]='febrero';
      $mp[3]='marzo';
      $mp[4]='abril';
      $mp[5]='mayo';
      $mp[6]='junio';
      $mp[7]='julio';
      $mp[8]='agosto';
      $mp[9]='septiembre';
      $mp[10]='octubre';
      $mp[11]='noviembre';
      $mp[12]='diciembre';

      for ($i=1; $i <=12 ; $i++) { 
        $matriz[1][$i]=0; /// Programado
        $matriz[2][$i]=0; /// Programado Acumulado
        $matriz[3][$i]=0; /// Programado Acumulado %
        $matriz[4][$i]=0; /// Ejecutado
        $matriz[5][$i]=0; /// Ejecutado Acumulado
        $matriz[6][$i]=0; /// Ejecutado Acumulado %
        $matriz[7][$i]=0; /// Eficacia
      }
      
      $pa=0; $ea=0;
      if(count($prod_prog)!=0){
        for ($i=1; $i <=12 ; $i++) { 
          $matriz[1][$i]=$prod_prog[0][$mp[$i]];
          $pa=$pa+$prod_prog[0][$mp[$i]];

          if($producto[0]['mt_id']==3){
            $matriz[2][$i]=$pa;
          }
          else{
            $matriz[2][$i]=$matriz[1][$i];
          }

          
          if($producto[0]['prod_meta']!=0){
            if($producto[0]['tp_id']==1){
              $matriz[3][$i]=round(((($matriz[2][$i]+$producto[0]['prod_linea_base'])/$producto[0]['prod_meta'])*100),2);
            }
            else{
              $matriz[3][$i]=round((($matriz[2][$i]/$producto[0]['prod_meta'])*100),2);
            }
            
          }
        }
      }

      if(count($prod_ejec)!=0){
        for ($i=1; $i <=12 ; $i++) { 
          $matriz[4][$i]=$prod_ejec[0][$mp[$i]];

          if($producto[0]['mt_id']==3){
            $ea=$ea+$prod_ejec[0][$mp[$i]];
          }
          else{
            $ea=$matriz[4][$i];
          }

          $matriz[5][$i]=$ea;
          if($producto[0]['prod_meta']!=0){
            if($producto[0]['tp_id']==1){
              $matriz[6][$i]=round(((($matriz[5][$i]+$producto[0]['prod_linea_base'])/$producto[0]['prod_meta'])*100),2);
            }
            else{
              $matriz[6][$i]=round((($matriz[5][$i]/$producto[0]['prod_meta'])*100),2);
            }
            
          }

          if($matriz[2][$i]!=0){
            $matriz[7][$i]=round((($matriz[5][$i]/$matriz[2][$i])*100),2);  
          }
          
        }
      }
      
      return $matriz;
    }

    /*------------------------------------- MENU -----------------------------------*/
    function menu($mod){
        $enlaces=$this->menu_modelo->get_Modulos($mod);
        for($i=0;$i<count($enlaces);$i++){
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
    /*============================================================================*/
    /*--- verifica datos del mes y año ---*/
    public function verif_mes_gestion(){

      $valor=ltrim(date("m"), "0"); // numero mes
      $mes=$this->mes_nombre_completo($valor);

      $datos[1]=$valor; // numero del mes
      $datos[2]=$mes[$valor]; // mes
      $datos[3]=$this->gestion; // Gestion

      return $datos;
    }

    /*------ NOMBRE MES -------*/
    function mes_nombre_completo(){
        $mes[1] = 'ENERO';
        $mes[2] = 'FEBRERO';
        $mes[3] = 'MARZO';
        $mes[4] = 'ABRIL';
        $mes[5] = 'MAYO';
        $mes[6] = 'JUNIO';
        $mes[7] = 'JULIO';
        $mes[8] = 'AGOSTO';
        $mes[9] = 'SEPTIEMBRE';
        $mes[10] = 'OCTUBRE';
        $mes[11] = 'NOVIEMBRE';
        $mes[12] = 'DICIEMBRE';

      return $mes;
    }

    /*------ NOMBRE MES -------*/
    function mes_nombre(){
      $mes[1] = 'ENE.';
      $mes[2] = 'FEB.';
      $mes[3] = 'MAR.';
      $mes[4] = 'ABR.';
      $mes[5] = 'MAY.';
      $mes[6] = 'JUN.';
      $mes[7] = 'JUL.';
      $mes[8] = 'AGOS.';
      $mes[9] = 'SEPT.';
      $mes[10] = 'OCT.';
      $mes[11] = 'NOV.';
      $mes[12] = 'DIC.';

      return $mes;
    }
}