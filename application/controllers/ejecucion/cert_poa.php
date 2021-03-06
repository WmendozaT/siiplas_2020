<?php
class Cert_poa extends CI_Controller {
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
        $this->load->model('programacion/model_mantenimiento');
        $this->load->model('ejecucion/model_ejecucion');
        $this->load->model('ejecucion/model_certificacion');
        $this->load->model('programacion/insumos/model_insumo'); /// gestion 2020
        $this->load->model('modificacion/model_modrequerimiento'); /// Gestion 2020
        //$this->load->model('programacion/marco_estrategico/mobjetivos');
        $this->load->model('programacion/insumos/minsumos');
        $this->load->model('mestrategico/model_mestrategico');
        $this->load->model('mantenimiento/model_partidas');
        $this->load->model('mantenimiento/model_ptto_sigep');
        $this->load->model('modificacion/model_modificacion');
        $this->load->model('mantenimiento/model_configuracion');
        $this->load->model('mantenimiento/model_estructura_org');
        $this->load->model('menu_modelo');
        $this->load->model('Users_model','',true);
        $this->load->library('security');
        $this->gestion = $this->session->userData('gestion');
        $this->adm = $this->session->userData('adm');
        $this->rol = $this->session->userData('rol_id');
        $this->dist = $this->session->userData('dist');
        $this->dist_tp = $this->session->userData('dist_tp');
        $this->tp_adm = $this->session->userData('tp_adm');
        $this->fun_id = $this->session->userData('fun_id');
        $this->fun_adm = $this->session->userData('adm');
        }
        else{
            $this->session->sess_destroy();
            redirect('/','refresh');
        }
    }

    /*--------------------------- TIPO DE RESPONSABLE ---------------------------*/
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

    /*------ LISTA DE CERTIFICACIONES POA REGISTRADOS -------*/
    public function menu_certificacion_poa(){
      if($this->rolfunn(3)){
        $data['menu']=$this->menu(4);
        $data['resp']=$this->session->userdata('funcionario');
        $data['reg'] = $this->model_proyecto->dep_dist($this->dist);
        $data['res_dep']=$this->tp_resp();
          if($this->fun_adm==1){ /// Administrador Nacional
            $data['list']=$this->menu_cpoa_nacional();
            $this->load->view('admin/ejecucion/certificacion_poa/menu_certpoa_nacional', $data);
          }
          else{ //// Administrador Regional
            $data['list']=$this->list_certpoas();
            $this->load->view('admin/ejecucion/certificacion_poa/list_certificaciones_poa', $data);
          }
      }
      else{
        redirect('admin/dashboard');
      }   

    }


    public function menu_cpoa_nacional(){
    $tabla='';
    $regionales=$this->model_proyecto->list_departamentos();
    $unidades=$this->model_estructura_org->list_unidades_apertura();
      $tabla.='
          <article class="col-sm-12">
            <div class="well">
              <form class="smart-form">
                  <header><b>CERTIFICACIONES POA '.$this->gestion.'</b></header>
                  <fieldset>          
                    <div class="row">
                      <section class="col col-3">
                        <label class="label">DIRECCI??N ADMINISTRATIVA</label>
                        <select class="form-control" id="dep_id" name="dep_id" title="SELECCIONE REGIONAL">
                        <option value="">SELECCIONE REGIONAL</option>';
                        foreach($regionales as $row){
                          if($row['dep_id']!=0){
                            $tabla.='<option value="'.$row['dep_id'].'">'.$row['dep_id'].'.- '.strtoupper($row['dep_departamento']).'</option>';
                          }
                        }
                        $tabla.='
                        </select>
                      </section>

                      <section class="col col-3">
                        <label class="label">UNIDAD EJECUTORA</label>
                        <select class="form-control" id="dist_id" name="dist_id" title="SELECCIONE DISTRITAL">
                        </select>
                      </section>

                      <section class="col col-3">
                        <label class="label">TIPO</label>
                        <select class="form-control" id="tp_id" name="tp_id" title="SELECCIONE TIPO">
                        </select>
                      </section>
                    </div>
                  </fieldset>
              </form>
              </div>
            </article>';
    return $tabla;
  }


    /*--- GET LISTA DE CERTIFICACIONES (2020)---*/
    public function get_lista_cpoas(){
      if($this->input->is_ajax_request() && $this->input->post()){
        $post = $this->input->post();
        $dist_id = $this->security->xss_clean($post['dist_id']);
        $tp_id = $this->security->xss_clean($post['tp_id']);
        
        $lista=$this->lista_certificaciones_poa($dist_id,$tp_id);
        $result = array(
          'respuesta' => 'correcto',
          'lista_certpoa' => $lista,
        );
          
        echo json_encode($result);
      }else{
          show_404();
      }
    }

 /*-- LISTA DE CERTIFICACIONES POAS 2020 (Nacional)--*/
    public function lista_certificaciones_poa($dist_id,$tp_id){
      $tabla='';
          $certificados = $this->model_certificacion->lista_certificaciones_distrital($dist_id,$tp_id,$this->gestion);
          $tabla.='
            <script src = "'.base_url().'mis_js/programacion/programacion/tablas.js"></script>
            <table id="dt_basic" class="table table-bordered" style="width:100%;" border=1>
            <thead>
              <tr style="background-color: #66b2e8">
                  <th style="width:1%;"></th>
                  <th style="width:10%;">C&Oacute;DIGO</th>
                  <th style="width:5%;">FECHA</th>
                  <th style="width:10%;">APERTURA PROGRAM&Aacute;TICA</th>
                  <th style="width:30%;">UNIDAD, ESTABLECIMIENTO, PROYECTO DE INVERSI&Oacute;N</th>
                  <th style="width:10%;">SERVICIO/COMPONENTE</th>
                  <th style="width:5%;">GESTI&Oacute;N</th>
                  <th style="width:7%;" title="EDITAR CERTIFICACI&Oacute;N">MODIFICAR CERTIFICACI??N</th>
                  <th style="width:7%;" title="ELIMINAR CERTIFICACI&Oacute;N">ELIMINAR CERTIFICACI??N</th>
                  <th style="width:5%;">VER CERTIFICADO POA</th>
                  <th style="width:5%;">VER MOD. POA.</th>';
                  if($this->tp_adm==1){
                    $tabla.='
                    <th></th>
                    <th></th>';
                  }
                  $tabla.='
              </tr>
            </thead>
            <tbody id="bdi">';
            $nro=0;
            foreach ($certificados as $row){
              $nro++; $color='';$codigo=$row['cpoa_codigo'];
              if($row['cpoa_estado']==0){
                $color='#fddddd';
                $codigo='<font color=red>SIN C??DIGO</font>';
              }
              elseif($row['cpoa_ref']){
                $color='#dcf7f3';
              }

              $tabla .='<tr bgcolor='.$color.'>';
                $tabla .='<td title='.$row['cpoa_id'].'>'.$nro.'</td>';
                $tabla .='<td>'.$codigo.'</td>';
                $tabla .='<td>'.date('d-m-Y',strtotime($row['cpoa_fecha'])).'</td>';
                $tabla .='<td>'.$row['aper_programa'].' '.$row['aper_proyecto'].' '.$row['aper_actividad'].'</td>';
                $tabla .='<td>';
                  if($row['tp_id']==1){
                    $tabla.=$row['proy_nombre'];
                  }
                  else{
                    $tabla.=$row['tipo'].' '.$row['act_descripcion'].' '.$row['abrev'];
                  }
                $tabla .='</td>';
                $tabla .='<td>'.$row['com_componente'].'</td>';
                $tabla .='<td align=center><b>'.$row['cpoa_gestion'].'</b></td>';
                $tabla .='<td align=center>';

                if($row['cpoa_ref']==0 & $row['cpoa_estado']!=0){
                  $tabla.='<a href="#" data-toggle="modal" data-target="#modal_anular_cert" title="MODIFICAR CERTIFICACI&Oacute;N"  onclick="editar_certpoa('.$row['cpoa_id'].');" class="btn btn-default btn-lg"><img src="'.base_url().'assets/img/neg.jpg" WIDTH="35" HEIGHT="30"/></a>';
                }
                elseif($row['cpoa_ref']==1 and $this->tp_adm==1){
                  $cite_mod_poa=$this->model_certificacion->get_certpoa_vigente_modificado($row['cpoa_id']); /// Datos de editado, modificado poa
                  if(count($cite_mod_poa)!=0){
                    $tabla.='<a href="'.site_url("").'/cert/edit_certificacion/'.$cite_mod_poa[0]['cpoaa_id'].'" title="FORMULARIO DE MODIFICACI??N CERT. POA" class="btn btn-default"><img src="'.base_url().'assets/ifinal/modificar.png" WIDTH="30" HEIGHT="30"/><br>FORM. CPOA</a>';
                  }
                }
                $tabla.='</td>';
                $tabla .='<td align=center>';
                  if($row['cpoa_ref']==0 & $row['cpoa_estado']!=0){
                    $tabla.='<a href="#" data-toggle="modal" data-target="#modal_del_cert" title="ELIMINAR CERTIFICACI&Oacute;N"  onclick="eliminar_certpoa('.$row['cpoa_id'].');" class="btn btn-default btn-lg"><img src="'.base_url().'assets/ifinal/eliminar.png" WIDTH="35" HEIGHT="25"/></a>';
                  }
                $tabla .='</td>';
                $tabla .='<td align=center><a href="javascript:abreVentana(\''. site_url("").'/cert/rep_cert_poa/'.$row['cpoa_id'].'\');" title="CERTIFICADO POA APROBADO"><img src="'.base_url().'assets/ifinal/pdf.png" WIDTH="40" HEIGHT="40"/></a></td>';
                $tabla .='<td align=center>';
                  if($row['cpoa_ref']!=0){
                    $cite_mod_poa=$this->model_certificacion->get_certpoa_vigente_modificado($row['cpoa_id']); /// Datos de editado, modificado poa
                    if(count($cite_mod_poa)!=0){

                      if(count($this->model_modrequerimiento->list_requerimientos_modificados($cite_mod_poa[0]['cite_id']))!=0){
                        $tabla.='<a href="javascript:abreVentana(\''. site_url("").'/mod/rep_mod_financiera/'.$cite_mod_poa[0]['cite_id'].'\');" title="REPORTE MODIFICACI??N POA"><img src="'.base_url().'assets/ifinal/requerimiento.png" WIDTH="30" HEIGHT="30"/><br>MOD. POA</a>';
                      
                      }
                    }
                    else{
                      $tabla.='Sin Reporte';
                    }
                  }
                $tabla .='</td>';

                if($this->tp_adm==1){
                  $tabla.='<td>';
                    if($row['cpoa_estado']==0){ /// CUANDO NO TIENE CODIGO DE CERTIFICACI??N
                      $tabla.='<center><a href="'.site_url("").'/cert/generar_codigo/'.$row['cpoa_id'].'" title="GENERAR C??DIGO DE CERTIFICACI??N" class="btn btn-default">GENERAR C??DIGO</a></center>';
                    }
                  $tabla.='</td>';

                  $tabla.='<td>';
                    if($this->fun_id==399){ /// Eliminar Certificacion POA
                      $tabla.='<center><a href="'.site_url("").'/cert/eliminar_certificacion/'.$row['cpoa_id'].'" title="ELIMINAR CERTIFICACI??N" class="btn btn-default">DELETE CERTIFICACI&Oacute;N</a></center>';
                    }
                  $tabla.='</td>';
                } 

              $tabla .='</tr>';
            }
            
            $tabla.='
            </tbody>
        </table>';

      return $tabla;
    }


    /*-- LISTA DE CERTIFICACIONES POAS 2020 (Regional-Distrital)--*/
    public function list_certpoas(){
      $tabla='';
          $certificados = $this->model_certificacion->list_certificados();
          $tabla.='
          <table id="datatable_fixed_column" class="table table-bordered" width="100%">
            <thead>
              <tr>
                  <th></th>
                  <th class="hasinput">
                      <input type="text" class="form-control" placeholder="C&oacute;digo"/>
                  </th>
                  <th class="hasinput">
                      <input type="text" class="form-control" placeholder="Fecha de Certificaci&oacute;n"/>
                  </th>
                  <th class="hasinput">
                      <input type="text" class="form-control" placeholder="Apertura Program??tica"/>
                  </th>
                  <th class="hasinput">
                      <input type="text" class="form-control" placeholder="Desccripci&oacute;n"/>
                  </th>
                  <th class="hasinput">
                      <input type="text" class="form-control" placeholder="Tipo de Operaci&oacute;n"/>
                  </th>
                  <th class="hasinput">
                      <input type="text" class="form-control" placeholder="Servicio - Componente"/>
                  </th>
                  <th class="hasinput">
                      <input type="text" class="form-control" placeholder="Gesti&oacute;n"/>
                  </th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>';
                  if($this->tp_adm==1){
                    $tabla.='
                    <th></th>
                    <th></th>';
                  }
                  $tabla.='
              </tr>
              <tr style="background-color: #66b2e8">
                  <th style="width:1%;"></th>
                  <th style="width:10%;">C&Oacute;DIGO</th>
                  <th style="width:5%;">FECHA</th>
                  <th style="width:10%;">APERTURA PROGRAM&Aacute;TICA</th>
                  <th style="width:20%;">UNIDAD, ESTABLECIMIENTO, PROYECTO DE INVERSI&Oacute;N</th>
                  <th style="width:7%;">TIPO DE OPERACI&Oacute;N</th>
                  <th style="width:10%;">SERVICIO/COMPONENTE</th>
                  <th style="width:5%;">GESTI&Oacute;N</th>
                  <th style="width:7%;" title="EDITAR CERTIFICACI&Oacute;N">EDICI&Oacute;N PARCIAL</th>
                  <th style="width:7%;" title="ELIMINAR CERTIFICACI&Oacute;N">EDICI&Oacute;N TOTAL</th>
                  <th style="width:5%;">VER CERTIFICADO POA</th>
                  <th style="width:5%;">VER MOD. POA.</th>';
                  if($this->tp_adm==1){
                    $tabla.='
                    <th></th>
                    <th></th>';
                  }
                  $tabla.='
              </tr>
            </thead>
            <tbody id="bdi">';
            $nro=0;
            foreach ($certificados as $row){
              $nro++; $color='';$codigo=$row['cpoa_codigo'];
              if($row['cpoa_estado']==0){
                $color='#fddddd';
                $codigo='<font color=red>SIN C??DIGO</font>';
              }
              elseif($row['cpoa_ref']){
                $color='#dcf7f3';
              }

              $tabla .='<tr bgcolor='.$color.'>';
                $tabla .='<td title='.$row['cpoa_id'].'>'.$nro.'</td>';
                $tabla .='<td>'.$codigo.'</td>';
                $tabla .='<td>'.date('d-m-Y',strtotime($row['cpoa_fecha'])).'</td>';
                $tabla .='<td>'.$row['aper_programa'].' '.$row['aper_proyecto'].' '.$row['aper_actividad'].'</td>';
                $tabla .='<td>';
                  if($row['tp_id']==1){
                    $tabla.=$row['proy_nombre'];
                  }
                  else{
                    $tabla.=$row['tipo'].' '.$row['act_descripcion'].' '.$row['abrev'];
                  }
                $tabla .='</td>';
                $tabla .='<td>'.$row['tp_tipo'].'</td>';
                $tabla .='<td>'.$row['com_componente'].'</td>';
                $tabla .='<td align=center><b>'.$row['cpoa_gestion'].'</b></td>';
                $tabla .='<td align=center>';

                if($row['cpoa_ref']==0 & $row['cpoa_estado']!=0){
                  $tabla.='<a href="#" data-toggle="modal" data-target="#modal_anular_cert" class="btn btn-xs anular_cert" title="EDITAR CERTIFICACI&Oacute;N" name="'.$row['cpoa_id'].'" id="'.$row['proy_id'].'" class="btn btn-default btn-lg">
                            <img src="'.base_url().'assets/img/neg.jpg" WIDTH="35" HEIGHT="35"/><br>EDITAR CERT.</a>';
                }
                elseif($row['cpoa_ref']==1 and $this->tp_adm==1){
                  $cite_mod_poa=$this->model_certificacion->get_certpoa_vigente_modificado($row['cpoa_id']); /// Datos de editado, modificado poa
                  if(count($cite_mod_poa)!=0){
                    $tabla.='<a href="'.site_url("").'/cert/edit_certificacion/'.$cite_mod_poa[0]['cpoaa_id'].'" title="FORMULARIO DE MODIFICACI??N CERT. POA" class="btn btn-default"><img src="'.base_url().'assets/ifinal/modificar.png" WIDTH="30" HEIGHT="30"/><br>FORM. CPOA</a>';
                  }
                }
                $tabla.='</td>';
                $tabla .='<td align=center>';
                  if($row['cpoa_ref']==0 & $row['cpoa_estado']!=0){
                    $tabla.='<a href="#" data-toggle="modal" data-target="#modal_del_cert" class="btn btn-xs del_cert" title="ELIMINAR CERTIFICACI&Oacute;N" name="'.$row['cpoa_id'].'" id="'.$row['proy_id'].'" class="btn btn-default btn-lg">
                            <img src="'.base_url().'assets/ifinal/eliminar.png" WIDTH="35" HEIGHT="35"/><br>ELIMINAR CERT.</a>';
                  }
                $tabla .='</td>';
                $tabla .='<td align=center><a href="javascript:abreVentana(\''. site_url("").'/cert/rep_cert_poa/'.$row['cpoa_id'].'\');" title="CERTIFICADO POA APROBADO"><img src="'.base_url().'assets/ifinal/pdf.png" WIDTH="40" HEIGHT="40"/></a></td>';
                $tabla .='<td align=center>';
                  if($row['cpoa_ref']!=0){
                    $cite_mod_poa=$this->model_certificacion->get_certpoa_vigente_modificado($row['cpoa_id']); /// Datos de editado, modificado poa
                    if(count($cite_mod_poa)!=0){

                      if(count($this->model_modrequerimiento->list_requerimientos_modificados($cite_mod_poa[0]['cite_id']))!=0){
                        $tabla.='<a href="javascript:abreVentana(\''. site_url("").'/mod/rep_mod_financiera/'.$cite_mod_poa[0]['cite_id'].'\');" title="REPORTE MODIFICACI??N POA"><img src="'.base_url().'assets/ifinal/requerimiento.png" WIDTH="30" HEIGHT="30"/><br>MOD. POA</a>';
                      
                      }
                    }
                    else{
                      $tabla.='Sin Reporte';
                    }
                  }
                $tabla .='</td>';

                if($this->tp_adm==1){
                  $tabla.='<td>';
                    if($row['cpoa_estado']==0){ /// CUANDO NO TIENE CODIGO DE CERTIFICACI??N
                      $tabla.='<center><a href="'.site_url("").'/cert/generar_codigo/'.$row['cpoa_id'].'" title="GENERAR C??DIGO DE CERTIFICACI??N" class="btn btn-default">GENERAR C??DIGO</a></center>';
                    }
                  $tabla.='</td>';

                  $tabla.='<td>';
                    if($this->fun_id==399){ /// Eliminar Certificacion POA
                      //$tabla.='<center><a href="'.site_url("").'/cert/eliminar_certificacion/'.$row['cpoa_id'].'" title="ELIMINAR CERTIFICACI??N" class="btn btn-default">DELETE CERTIFICACI&Oacute;N</a></center>';
                    }
                  $tabla.='</td>';
                } 

              $tabla .='</tr>';
            }
            
            $tabla.='
            </tbody>
        </table>';

      return $tabla;
    }


    /*--- VERIFICA SI LA REGIONAL ESTA HABILITADO PARA CERTIFICAR ---*/
    public function verif_regional($dist){
      $sw=false;
      if($dist==0){
        $sw=true;
      }
      else{
        if(count($this->model_configuracion->verif_cert($dist))!=0){
          $sw=true;
        }
      }
      return $sw;
    }

    
    /*-------- VALIDA UPDATE REQUERIMIENTOS NO CERTIFICADOS --------*/
    public function valida_update_req_nocertificados(){   
      $cert = $this->model_ejecucion->get_certificado_poa($this->input->post('cpoa_id'));

      if($this->nro_req()!=0){
        /*---------------------- INSERTA ITEMS CERTIFICADOS ---------------------------*/
        $this->inserta_items_certificados($this->input->post('cpoa_id'));
        /*----------------------------------------------------------------------------*/
        
        $this->session->set_flashdata('success','LA CORRECCI&Oacute;N DE ITEM SE GENERO CORRECTAMENTE');
        redirect('ejec/verificar_reformulacion/'.$this->input->post('cpoa_id').'');
      }
      else{
        $this->session->set_flashdata('danger','SELECCIONE REQUERIMIENTOS A CORREGIR');
        redirect('ejec/verificar_reformulacion/'.$this->input->post('cpoa_id').'');
      }
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
    /*=============================================================================================*/

    /*----------- Obtiene Datos de la Certificacion 2020 ---------*/
    public function get_datos_certificado(){
      if($this->input->is_ajax_request() && $this->input->post()){
          $post = $this->input->post();
          $cert_id = $this->security->xss_clean($post['cert_id']);

          $cert_poa=$this->model_ejecucion->get_certificado_poa($cert_id);

          if(count($cert_poa)!=0){
            $result = array(
              'respuesta' => 'correcto',
              'certificado' => $cert_poa
            );
          }
          else{
            $result = array(
                'respuesta' => 'error'
            );
          }

          echo json_encode($result);
      }else{
          show_404();
      }
    }

    /*----- VALIDA ANULACI??N CPOA 2020 -----*/
    public function valida_anulacion_certpoa(){
      if ($this->input->post()) {
          $post = $this->input->post();
          if( isset($_POST['cert_id']) && isset($_POST['cite'])  && isset($_POST['justificacion'])){
            $cpoa_id = $this->security->xss_clean($post['cert_id']); /// cpoa id
            $cite = $this->security->xss_clean($post['cite']); /// Cite
            $justificacion = $this->security->xss_clean($post['justificacion']); /// Justificacion

            $cpoa=$this->model_certificacion->get_certificacion_poa($cpoa_id); /// Datos Generales de la Certificacion POA
            $items=$this->model_certificacion->lista_items_certificados($cpoa_id); /// Lista de items Certificados

              for ($i=1; $i <=12 ; $i++) { 
                $mprog[$i]='mes'.$i;
              }

              if($cpoa[0]['cpoa_ref']==0){
                $cert_anulado=$this->model_certificacion->certificado_anulado($cpoa_id);
                  if (count($cert_anulado)==0) {
                    /*-------- Certificacion Anulado ------*/
                    $data = array(
                      'cite' => $cite,
                      'justificacion' => $justificacion,
                      'cpoa_id' => $cpoa_id,
                      'cpoa_codigo' => $cpoa[0]['cpoa_codigo'],
                      'cpoa_fecha' => $cpoa[0]['cpoa_fecha'],
                      'fun_id' => $cpoa[0]['fun_id'],
                      'cpoa_recomendacion' => $cpoa[0]['cpoa_recomendacion'],
                      'tp_anulado' => 2, /// 2 : Modificado, 3 : Eliminado
                    );
                    $this->db->insert('certificacionpoa_anulado',$data);
                    $cpoaa_id=$this->db->insert_id();
                  }
                  else{
                    $cpoaa_id=$cert_anulado[0]['cpoaa_id'];
                  }

                
                foreach ($items as $row){
                  /*--------- Insumos Anulados ------*/
                  $data2 = array(
                    'cpoaa_id' => $cpoaa_id,
                    'ins_id' => $row['ins_id'],
                    'ins_detalle' => $row['ins_detalle'],
                    'ins_cant_requerida' => $row['ins_cant_requerida'],
                    'ins_costo_unitario' => $row['ins_costo_unitario'],
                    'ins_costo_total' => $row['ins_costo_total'],
                    'ins_unidad_medida' => $row['ins_unidad_medida'],
                    'par_codigo' => $row['par_codigo'],
                    'monto_certificado' => $row['monto_certificado'],
                    'g_id' => $this->gestion,
                  );
                  $this->db->insert('insumos_certificados_anulado',$data2);
                  $cpoaad_id=$this->db->insert_id();

                  for ($i=1; $i <=12 ; $i++) { 
                    if($row[$mprog[$i]]!=0){
                      $data3 = array(
                        'cpoaad_id' => $cpoaad_id,
                        'mes_id' => $i,
                        'ipma_fis' => $row[$mprog[$i]],
                      );
                      $this->db->insert('cert_prog_mes_anulados',$data3);
                    }
                  }
                }

                /*------ UPDATE CERTIFICACION POA -----*/
                  $update_cpoa = array( 
                    'cpoa_estado' => 2, //// Rechazado
                    'cpoa_codigo' => $cpoa[0]['cpoa_codigo'].'-CE', //// Codigo Certificacion POA
                    'fun_id' => $this->fun_id,
                    'cpoa_ref' => 1, /// 0: A editar, 1: Editado
                  );
                  $this->db->where('cpoa_id', $cpoa_id);
                  $this->db->update('certificacionpoa', $update_cpoa);
                /*-----------------------------------------------*/

                /*----- INSERT CITES MODIFICACIONES INSUMOS ------*/
                  $data_to_store = array(
                    'com_id' => $cpoa[0]['com_id'],
                    'cite_nota' => $cpoa[0]['cpoa_cite'],
                    'cite_fecha' => $cpoa[0]['cite_fecha'],
                    'fun_id' => $this->fun_id,
                    'g_id' => $this->gestion,
                    'cpoaa_id' => $cpoaa_id,

                    'num_ip' => $this->input->ip_address(), 
                    'nom_ip' => gethostbyaddr($_SERVER['REMOTE_ADDR']),
                    );
                  $this->db->insert('cite_mod_requerimientos',$data_to_store);
                  $cite_id=$this->db->insert_id();
                /*------------------------------------------------*/

                  $verificando=$this->model_modrequerimiento->verif_modificaciones_distrital($cpoa[0]['dist_id']);
                  $nro_mod=$verificando[0]['cert_poa_mod']+1;

                  /*----- Update Configuracion mod distrital -----*/
                    $update_conf= array(
                      'cert_poa_mod' => $nro_mod
                    );
                    $this->db->where('mod_id', $verificando[0]['mod_id']);
                    $this->db->update('conf_modificaciones_distrital', $this->security->xss_clean($update_conf));
                  /*----------------------------------------------*/

                redirect('cert/edit_certificacion/'.$cpoaa_id.'');
              }
              else{
                $this->session->set_flashdata('danger','EL CERTIFICADO POA : '.$cpoa[0]['cpoa_codigo'].' YA FUE REFORMULADO');
                redirect('ejec/menu_cpoa');
              }

          }
          else{
            $this->session->set_flashdata('danger','DATOS INCOMPLETOS');
            redirect('ejec/menu_cpoa');
          }

      } else {
          show_404();
      }
    }

    /*----- VALIDA ELIMINACI??N CPOA 2020 -----*/
    public function valida_eliminacion_certpoa(){
      if ($this->input->post()) {
          $post = $this->input->post();
          if( isset($_POST['cpoa_id']) && isset($_POST['cite'])  && isset($_POST['justificacion'])){
              $cpoa_id = $this->security->xss_clean($post['cpoa_id']); /// cpoa id
              $cite = $this->security->xss_clean($post['cite']); /// Cite
              $justificacion = $this->security->xss_clean($post['justificacion']); /// Justificacion

              $cpoa=$this->model_certificacion->get_certificacion_poa($cpoa_id); /// Datos Generales de la Certificacion POA
              $items=$this->model_certificacion->lista_items_certificados($cpoa_id); /// Lista de items Certificados

              for ($i=1; $i <=12 ; $i++) { 
                $mprog[$i]='mes'.$i;
              }

              if($cpoa[0]['cpoa_ref']==0){
                  $cert_anulado=$this->model_certificacion->certificado_anulado($cpoa_id);
                  if (count($cert_anulado)==0) {
                    /*-------- Certificacion Anulado ------*/
                    $data = array(
                      'cite' => $cite,
                      'justificacion' => $justificacion,
                      'cpoa_id' => $cpoa_id,
                      'cpoa_codigo' => $cpoa[0]['cpoa_codigo'],
                      'cpoa_fecha' => $cpoa[0]['cpoa_fecha'],
                      'fun_id' => $cpoa[0]['fun_id'],
                      'cpoa_recomendacion' => $cpoa[0]['cpoa_recomendacion'],
                      'tp_anulado' => 3, /// 2 : Modificado, 3 : Eliminado
                    );
                    $this->db->insert('certificacionpoa_anulado',$data);
                    $cpoaa_id=$this->db->insert_id();
                  }
                  else{
                    $cpoaa_id=$cert_anulado[0]['cpoaa_id'];
                  }


                  foreach ($items as $row){
                  /*--------- Insumos Anulados ------*/
                  $data2 = array(
                    'cpoaa_id' => $cpoaa_id,
                    'ins_id' => $row['ins_id'],
                    'ins_detalle' => $row['ins_detalle'],
                    'ins_cant_requerida' => $row['ins_cant_requerida'],
                    'ins_costo_unitario' => $row['ins_costo_unitario'],
                    'ins_costo_total' => $row['ins_costo_total'],
                    'ins_unidad_medida' => $row['ins_unidad_medida'],
                    'par_codigo' => $row['par_codigo'],
                    'monto_certificado' => $row['monto_certificado'],
                    'g_id' => $this->gestion,
                  );
                  $this->db->insert('insumos_certificados_anulado',$data2);
                  $cpoaad_id=$this->db->insert_id();

                  for ($i=1; $i <=12 ; $i++) { 
                    if($row[$mprog[$i]]!=0){
                      $data3 = array(
                        'cpoaad_id' => $cpoaad_id,
                        'mes_id' => $i,
                        'ipma_fis' => $row[$mprog[$i]],
                      );
                      $this->db->insert('cert_prog_mes_anulados',$data3);
                    }
                  }
                }

                /*------ ELIMINANDO CERTIFICACI??N POA  -----*/
                  $this->delete_certificacion_item($cpoa_id);
                  if(count($this->model_certificacion->requerimientos_modificar_cpoa($cpoa_id))==0){
                      /*------ UPDATE CERTIFICACION POA -----*/
                        $update_cpoa = array( 
                          'cpoa_estado' => 3, 
                          'cpoa_ref' => 1, /// 0: A editar, 1: Editado
                        );
                        $this->db->where('cpoa_id', $cpoa_id);
                        $this->db->update('certificacionpoa', $update_cpoa);
                      /*-----------------------------------------------*/

                      $verificando=$this->model_modrequerimiento->verif_modificaciones_distrital($cpoa[0]['dist_id']);
                      $nro_mod=$verificando[0]['cert_poa_delete']+1;

                      /*----- Update Configuracion mod distrital -----*/
                        $update_conf= array(
                          'cert_poa_delete' => $nro_mod
                        );
                        $this->db->where('mod_id', $verificando[0]['mod_id']);
                        $this->db->update('conf_modificaciones_distrital', $this->security->xss_clean($update_conf));
                      /*----------------------------------------------*/

                      /// Redireccionando a un reporte de eliminaci??n
                      redirect('cert/rep_cert_poa/'.$cpoa_id);
                  }
                  else{
                    $this->session->set_flashdata('danger','NOSE PUEDO ELIMINAR !!!');
                    redirect('ejec/menu_cpoa');
                  }
                /*------------------------------------------*/

              }
              else{
                $this->session->set_flashdata('danger','EL CERTIFICADO POA : '.$cpoa[0]['cpoa_codigo'].' YA FUE REFORMULADO');
                redirect('ejec/menu_cpoa');
              }
          }
          else{
            $this->session->set_flashdata('danger','ERROR AL ELIMINAR CERTIFICACION POA');
            redirect('ejec/menu_cpoa');
          }

      } else {
          show_404();
      }
    }


    /*----- GET REQUERIMIENTO certificado a modificar 2020 -----*/
    public function get_requerimiento_cert(){
      if($this->input->is_ajax_request() && $this->input->post()){
        $post = $this->input->post();
        $ins_id = $this->security->xss_clean($post['ins_id']);
        $cpoaa_id = $this->security->xss_clean($post['cpoaa_id']);
        $cert_editado=$this->model_certificacion->get_cert_poa_editado($cpoaa_id); /// Datos de la Certificacion Anulado
        $cpoa=$this->model_certificacion->get_certificacion_poa($cert_editado[0]['cpoa_id']); /// Datos de la Certificacion POA

        $insumo= $this->minsumos->get_requerimiento($ins_id); /// Datos requerimientos 

        $ptto_asig=$this->model_ptto_sigep->get_partida_asignado_sigep($cpoa[0]['aper_id'],$insumo[0]['par_id']); /// Ptto Asignado
        if($cpoa[0]['tp_id']==1){
          $ptto_prog=$this->model_ptto_sigep->get_partida_programado_pi($cpoa[0]['proy_id'],$insumo[0]['par_id']); /// Ptto Programado pi
        }
        else{
          $ptto_prog=$this->model_ptto_sigep->get_partida_accion($cpoa[0]['aper_id'],$insumo[0]['par_id']); /// Ptto Programado Gasto Corriente
        }

                  /// -------------------------
          $monto_prog=0;
          if(count($ptto_prog)!=0){
            $monto_prog=$ptto_prog[0]['monto'];
          }

          $monto_asig=0;
          if(count($ptto_asig)!=0){
            $monto_asig=$ptto_asig[0]['monto'];
          }
          $saldo=$monto_asig-$monto_prog;

          $prog=$this->model_insumo->list_temporalidad_insumo($insumo[0]['ins_id']); /// Temporalidad Requerimiento 2020

          if(count($prog)==0){
            $prog = array('programado_total' => '0','mes1' => '0','mes2' => '0','mes3' => '0','mes4' => '0','mes5' => '0','mes6' => '0','mes7' => '0','mes8' => '0','mes9' => '0','mes10' => '0','mes11' => '0','mes12' => '0');
          }

          /*------ Montos Certificados -----*/
          $monto_total_certificado=0;
            $m_certificado=$this->model_certificacion->get_insumo_monto_certificado($insumo[0]['ins_id']); /// monto Total Certificado por insumo
            if (count($m_certificado)!=0) {
              $monto_total_certificado=$m_certificado[0]['certificado'];
            }

          $monto_cpoa_total_certificado=0;
            $mcpoa_certificado=$this->model_certificacion->get_insumo_monto_cpoa_certificado($ins_id,$cpoa[0]['cpoa_id']); /// monto insumo por cpoa certificado
            if (count($mcpoa_certificado)!=0) {
              $monto_cpoa_total_certificado=$mcpoa_certificado[0]['monto'];
            }
          /*------------------------------*/

          $verf = array('verf_mes1' => '0','verf_mes2' => '0','verf_mes3' => '0','verf_mes4' => '0','verf_mes5' => '0','verf_mes6' => '0','verf_mes7' => '0','verf_mes8' => '0','verf_mes9' => '0','verf_mes10' => '0','verf_mes11' => '0','verf_mes12' => '0');
          for ($i=1; $i <=12 ; $i++) { 
              $mes_cert=$this->model_certificacion->get_insumo_programado_certificado_mes($insumo[0]['ins_id'],$i);
              if(count($mes_cert)!=0){
                if(count($this->model_certificacion->get_mes_certificado_cpoa($cpoa[0]['cpoa_id'],$mes_cert[0]['tins_id']))!=0){
                  $verf['verf_mes'.$i]=2;
                }
                else{
                  $verf['verf_mes'.$i]=1;
                }
              }
            }

            $verif_cert=0;
            if(count($this->model_certificacion->verif_insumo_certificado($ins_id))>1){
              $verif_cert=1;
            }

            /// Verif_cert 0: se puede modificar detalle,unidad de medida
            /// Verif_cert 1: no se pueden modificar

          if(count($insumo)!=0){
            $result = array(
              'respuesta' => 'correcto',
              'insumo' => $insumo,
              'monto_saldo' => $saldo+$insumo[0]['ins_costo_total'],
              'saldo_dif' => $saldo,
              'prog' => $prog,
              'verif_mes' => $verf,
              'monto_certificado'=>($monto_total_certificado-$monto_cpoa_total_certificado),
              'verif_cert'=>$verif_cert,
              'monto_certificado_item'=>$monto_cpoa_total_certificado,
            );
          }
          else{
            $result = array(
              'respuesta' => 'error',
            );
          }
          
        echo json_encode($result);
      }else{
          show_404();
      }
    }


  /*--- ELIMINA ITEMS CERTIFICADOS (Formulacion) ---*/
  public function delete_certificacion_item($cpoa_id){
    $list_cpoas_anterior=$this->model_certificacion->requerimientos_modificar_cpoa($cpoa_id);

    foreach ($list_cpoas_anterior as $row){
      $this->db->where('cpoad_id',$row['cpoad_id']);
      $this->db->delete('cert_temporalidad_prog_insumo');

      $this->db->where('cpoad_id',$row['cpoad_id']);
      $this->db->delete('certificacionpoadetalle');
    }
  }


  /*------ ELIMINAR CERTIFICACION POA (2020)-----*/
  public function eliminar_certificacion($cpoa_id){
    $this->delete_certificacion_item($cpoa_id);
    
      $update_cpoa = array( 
        'cpoa_estado' => 3, //// Eliminado
        'fun_id' => $this->fun_id,
      );
      $this->db->where('cpoa_id', $cpoa_id);
      $this->db->update('certificacionpoa', $update_cpoa);

    if(count($this->model_certificacion->get_lista_detalle_cert_poa($cpoa_id))==1){
      redirect('ejec/menu_cpoa');
    }
    else{
      echo "Error de eliminacion";
    }
  }


    /*---------  UNIDAD DISTRITALES ---------*/
    public function get_unidades_administrativas($accion=''){ 
      $salida="";
      $accion=$_POST["accion"];
      switch ($accion) {
        case 'distrital':
        $salida="";
          $dep_id=$_POST["elegido"];
          
          $combog = pg_query('SELECT *
          from _distritales 
          where  dep_id='.$dep_id.' and dist_estado!=0
          order by dist_id asc');

          $salida.= "<option value='0'>SELECCIONE UNIDAD ADMINISTRATIVA</option>";
          while($sql_p = pg_fetch_row($combog)){
            $salida.= "<option value='".$sql_p[0]."'>".$sql_p[5]." - ".strtoupper ($sql_p[2])."</option>";
          }

        echo $salida; 
        //return $salida;
        break;

        case 'tipo':
        $salida="";
          $dep_id=$_POST["elegido"];
          $salida.= "<option value='0'>SELECCIONE TIPO</option>";
          $salida.= "<option value='4'>GASTO CORRIENTE</option>";
          $salida.= "<option value='1'>PROYECTO DE INVERSI??N</option>";

        echo $salida; 
        //return $salida;
        break;
      }

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

    /*---------- get mes ----------*/
    public function get_mes($mes_id){
      $mes[1]='ENERO';
      $mes[2]='FEBRERO';
      $mes[3]='MARZO';
      $mes[4]='ABRIL';
      $mes[5]='MAYO';
      $mes[6]='JUNIO';
      $mes[7]='JULIO';
      $mes[8]='AGOSTO';
      $mes[9]='SEPTIEMBRE';
      $mes[10]='OCTUBRE';
      $mes[11]='NOVIEMBRE';
      $mes[12]='DICIEMBRE';

      $dias[1]='31';
      $dias[2]='28';
      $dias[3]='31';
      $dias[4]='30';
      $dias[5]='31';
      $dias[6]='30';
      $dias[7]='31';
      $dias[8]='31';
      $dias[9]='30';
      $dias[10]='31';
      $dias[11]='30';
      $dias[12]='31';

      $valor[1]=$mes[$mes_id];
      $valor[2]=$dias[$mes_id];

      return $valor;
    }

    /*--------- rol funcionario ----------*/
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

    function rolfunn($tp_rol){
      $valor=false;
      $data = $this->Users_model->get_datos_usuario_roles($this->session->userdata('fun_id'),$tp_rol);
      if(count($data)!=0){
        $valor=true;
      }
      return $valor;
    }

}