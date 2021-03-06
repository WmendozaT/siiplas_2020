<?php
class crequerimiento extends CI_Controller{
    var $gestion;
    var $rol;
    var $fun_id;

    function __construct(){
        parent::__construct();
        if($this->session->userdata('fun_id')!=null){
        $this->load->library('pdf');
        $this->load->library('pdf2');
        $this->load->model('menu_modelo');
        $this->load->model('programacion/insumos/minsumos'); /// gestion 2019
        $this->load->model('programacion/insumos/model_insumo'); /// gestion 2020
        $this->load->model('programacion/insumos/minsumos_delegado');
        $this->load->model('mantenimiento/model_partidas');
        $this->load->model('mantenimiento/model_entidad_tras');
        $this->load->model('programacion/model_proyecto');
        $this->load->model('programacion/model_faseetapa');
        $this->load->model('programacion/model_componente');
        $this->load->model('programacion/model_producto');
        $this->load->model('programacion/model_actividad');
        $this->load->model('mantenimiento/model_ptto_sigep');
        $this->load->model('mestrategico/model_objetivoregion');
        $this->load->library('security');
        $this->gestion = $this->session->userData('gestion');
        $this->adm = $this->session->userData('adm');
        $this->dist = $this->session->userData('dist');
        $this->rol = $this->session->userData('rol_id');
        $this->dist_tp = $this->session->userData('dist_tp');
        $this->fun_id = $this->session->userdata("fun_id");
        }else{
            $this->session->sess_destroy();
            redirect('/','refresh');
        }
    }

    /*---- LISTA DE COMPONENTES SEGUN EL TIPO DE EJECUCION ----*/
    function list_componente($proy_id){
      $data['proyecto'] = $this->model_proyecto->get_id_proyecto($proy_id); // Proy
      if(count($data['proyecto'])!=0){
          $data['menu']=$this->genera_menu($proy_id);
          
          if($data['proyecto'][0]['tp_id']==1){
              $data['lista_com']=$this->genera_tabla_act_insumo($proy_id);
          }
          else{
              $data['lista_com']=$this->genera_tabla_prod_insumo($proy_id);
          }

          $this->load->view('admin/programacion/requerimiento/list_componentes', $data);
      }
      else{
          redirect('admin/dashboard');
      }
    }


    /*---- LISTA DE COMPONENTES SEGUN EL TIPO DE EJECUCION ----*/
    function list_requerimientos($proy_id,$id){
        $data['proyecto'] = $this->model_proyecto->get_id_proyecto($proy_id);
        if(count($data['proyecto'])!=0){
            $data['menu']=$this->genera_menu($proy_id);
            $data['fase'] = $this->model_faseetapa->get_id_fase($proy_id); // Fase 
            $data['id'] = $id;
            $data['monto_asig']=$this->model_ptto_sigep->suma_ptto_accion($data['proyecto'][0]['aper_id'],1);
            $data['monto_prog']=$this->model_ptto_sigep->suma_ptto_accion($data['proyecto'][0]['aper_id'],2);
            $monto_a=0;$monto_p=0;$monto_saldo=0;
            if(count($data['monto_asig'])!=0){
                $monto_a=$data['monto_asig'][0]['monto'];
            }
            if(count($data['monto_prog'])){
                $monto_p=$data['monto_prog'][0]['monto'];
            }

            $data['monto_a']=$monto_a;
            $data['monto_p']=$monto_p;


            if($data['proyecto'][0]['tp_id']==1){
                //$data['actividad'] = $this->model_actividad->get_actividad_id($id); // Actividad
                $data['producto']=$this->model_producto->get_producto_id($id); // Producto
                $data['componente']=$this->model_componente->get_componente($data['producto'][0]['com_id']); // Componente
                $data['partidas_ope']='';
                
                $titulo[1]='CONSOLIDADO DE PARTIDAS DE LA OPERACI&Oacute;N';
                $titulo[2]='CONSOLIDADO TOTAL DE PARTIDAS DEL PROYECTO';
                $titulo_requerimiento=
                '<h1><small>PROYECTO : </small>'.$data['proyecto'][0]['aper_programa'].''.$data['proyecto'][0]['aper_proyecto'].''.$data['proyecto'][0]['aper_actividad'].' - '.$data['proyecto'][0]['proy_nombre'].'</h1>
                <h1><small>OPERACI&Oacute;N : </small>COD - '.$data['producto'][0]['prod_cod'].'. '.$data['producto'][0]['prod_producto'].'</h1>';
            }
            else{
                $data['proyecto'] = $this->model_proyecto->get_datos_proyecto_unidad($data['fase'][0]['proy_id']);
                $data['producto']=$this->model_producto->get_producto_id($id); // Producto
                $data['componente']=$this->model_componente->get_componente($data['producto'][0]['com_id']); // Componente
                $data['partidas_ope']='';

                $titulo[1]='CONSOLIDADO DE PARTIDAS DE LA OPERACI&Oacute;N';
                $titulo[2]='CONSOLIDADO TOTAL DE PARTIDAS DE LA UNIDAD / ESTABLECIMIENTO';

                 $titulo_requerimiento=
                '<h1 title='.$data['proyecto'][0]['aper_id'].'><small>'.$data['proyecto'][0]['tipo_adm'].' : </small>'.$data['proyecto'][0]['aper_programa'].''.$data['proyecto'][0]['aper_proyecto'].''.$data['proyecto'][0]['aper_actividad'].' - '.$data['proyecto'][0]['tipo'].' '.$data['proyecto'][0]['proy_nombre'].'-'.$data['proyecto'][0]['abrev'].'</h1>
                <h1><small>SUBACTIVIDAD : </small>'.$data['componente'][0]['serv_cod'].'.- '.$data['componente'][0]['serv_descripcion'].'</h1>
                <h1><small>OPERACI&Oacute;N : </small>COD - '.$data['producto'][0]['prod_cod'].'.- '.$data['producto'][0]['prod_producto'].'</h1>';
            }

            $lista_insumos = $this->minsumos->lista_insumos_prod($id);
            $data['part_padres'] = $this->model_partidas->lista_padres();//partidas padres
            $data['part_hijos'] = $this->model_partidas->lista_partidas();//partidas hijos

            $data['requerimientos'] = $this->mis_requerimientos($lista_insumos,$data['componente'],1); /// Lista de requerimientos 2020 
            
            $data['titulos']=$titulo;
            $data['datos']=$titulo_requerimiento;
            //echo "proy_id : ".$data['proyecto'][0]['dep_id']." - aper_id : ".$data['proyecto'][0]['aper_id']." - proy_id : ".$proy_id;
            $this->load->view('admin/programacion/requerimiento/list_requerimientos', $data);
        }
        else{
            redirect('admin/dashboard');
        }
    }

    /*--- VERIFICA LA ALINEACION DE OBJETIVO REGIONAL ---*/
    public function verif_oregional($proy_id){
      $tabla='';

      $list_oregional=$this->model_objetivoregion->list_proyecto_oregional($proy_id);
      $nro=0;
      if(count($list_oregional)!=0){
        foreach($list_oregional as $row){
          $nro++;
          $tabla.='<h1> '.$nro.'.- OBJETIVO REGIONAL : <small> '.$row['or_codigo'].'.- '.$row['or_objetivo'].'</small></h1>';
        }
      }
      else{
        $tabla.='<h1><small><font color=red>NO ALINEADO A NINGUN OBJETIVO REGIONAL</font></small></h1>';
      }

      return $tabla;
    }

    /*--------- VALIDA ADD REQUERIMIENTO ----------*/
     public function valida_insumo(){
      if($this->input->post()) {
        $post = $this->input->post();
        $id = $this->security->xss_clean($post['id']); /// prod/act id
        $proy_id = $this->security->xss_clean($post['proy_id']); /// Proy id
        $detalle = $this->security->xss_clean($post['ins_detalle']); /// detalle
        $cantidad = $this->security->xss_clean($post['ins_cantidad']); /// cantidad
        $costo_unitario = $this->security->xss_clean($post['ins_costo_u']); /// costo unitario
        $costo_total = $this->security->xss_clean($post['costo']); /// costo Total
        $um_id = $this->security->xss_clean($post['um_id']); /// Unidad de medida
        $partida = $this->security->xss_clean($post['partida_id']); /// costo unitario
        $observacion = $this->security->xss_clean($post['ins_observacion']); /// Observacion

        $proyecto = $this->model_proyecto->get_id_proyecto($proy_id); /// DATOS DEL PROYECTO
        $fase = $this->model_faseetapa->get_id_fase($proy_id); //// DATOS DE LA FASE ACTIVA
        
        $umedida=$this->model_insumo->get_unidadmedida($um_id);

          $query=$this->db->query('set datestyle to DMY');
          $data_to_store = array( 
          'ins_codigo' => $this->session->userdata("name").'/REQ/'.$this->gestion, /// Codigo Insumo
          'ins_fecha_requerimiento' => date('d/m/Y'), /// Fecha de Requerimiento
          'ins_detalle' => strtoupper($detalle), /// Insumo Detalle
          'ins_cant_requerida' => round($cantidad,0), /// Cantidad Requerida
          'ins_costo_unitario' => $costo_unitario, /// Costo Unitario
          'ins_costo_total' => $costo_total, /// Costo Total
          'ins_unidad_medida' => $umedida[0]['um_descripcion'], /// Insumo Unidad de Medida
          'ins_gestion' => $this->gestion, /// Insumo gestion
          'par_id' => $partida, /// Partidas
          'ins_tipo' => 1, /// Ins Tipo
          'ins_observacion' => strtoupper($observacion), /// Observacion
          'fun_id' => $this->fun_id, /// Funcionario
          'aper_id' => $proyecto[0]['aper_id'], /// aper id
          'num_ip' => $this->input->ip_address(), 
          'nom_ip' => gethostbyaddr($_SERVER['REMOTE_ADDR']),
          );
          $this->db->insert('insumos', $data_to_store); ///// Guardar en Tabla Insumos 
          $ins_id=$this->db->insert_id();

          /*--------------------------------------------------------*/
            $data_to_store2 = array( ///// Tabla InsumoProducto
                'prod_id' => $id, /// prod id
                'ins_id' => $ins_id, /// ins_id
                'tp_ins' => $proyecto[0]['tp_id'], /// tp id                
              );
              $this->db->insert('_insumoproducto', $data_to_store2);
            /*----------------------------------------------------------*/
          

            /*------------ PARA LA GESTION 2020 ---------*/
            for ($i=1; $i <=12 ; $i++) {
              $pfin=$this->security->xss_clean($post['m'.$i]);
              if($pfin!=0){
                  $data_to_store4 = array( 
                    'ins_id' => $ins_id, /// Id Insumo
                    'mes_id' => $i, /// Mes 
                    'ipm_fis' => $pfin, /// Valor mes
                    'g_id' => $this->gestion, /// Gestion
                    );
                  $this->db->insert('temporalidad_prog_insumo', $data_to_store4);
              }
            }

          $get_ins=$this->minsumos->get_insumo_producto($ins_id);
            if(count($get_ins)==1){
              $this->session->set_flashdata('success','EL REQUERIMIENTO SE REGISTRO CORRECTAMENTE :)');
            }
            else{
              $this->session->set_flashdata('danger','EL REQUERIMIENTO NOSE REGISTRO CORRECTAMENTE, VERIFIQUE DATOS :(');
            }

        redirect(site_url("").'/prog/requerimiento/'.$proy_id.'/'.$id.'');
            
      } else {
          show_404();
      }
    }

    /*--- VALIDA UPDATE REQUERIMIENTO A NIVEL DE OPERACIONES ---*/
     public function valida_update_insumo(){
      if($this->input->post()) {
        $post = $this->input->post();
        $id = $this->security->xss_clean($post['id']); /// prod/act id
        $ins_id = $this->security->xss_clean($post['ins_id']); /// Ins id
        $proy_id = $this->security->xss_clean($post['proy_id']); /// Proy id
        $detalle = $this->security->xss_clean($post['detalle']); /// detalle
        $cantidad = $this->security->xss_clean($post['cantidad']); /// cantidad
        $costo_unitario = $this->security->xss_clean($post['costou']); /// costo unitario
        $costo_total = $this->security->xss_clean($post['costot']); /// costo Total
        $um_id = $this->security->xss_clean($post['mum_id']); /// Unidad de medida
        $partida = $this->security->xss_clean($post['par_hijo']); /// costo unitario
        $observacion = $this->security->xss_clean($post['observacion']); /// Observacion

        $fase = $this->model_faseetapa->get_id_fase($proy_id); /// FASE ACTIVA
        //$umedida=$this->model_insumo->get_unidadmedida($um_id);
      
        /*------------ UPDATE REQUERIMIENTO -------*/
          $update_ins= array(
            'ins_cant_requerida' => $cantidad,
            'ins_costo_unitario' => $costo_unitario,
            'ins_costo_total' => $costo_total,
            'ins_detalle' => $detalle,
            'par_id' => $partida, /// Partidas
            //'ins_unidad_medida' => $umedida[0]['um_descripcion'],
            'ins_unidad_medida' => $this->security->xss_clean($post['iumedida']),
            'ins_observacion' => $observacion,
            'fun_id' => $this->fun_id,
            'ins_estado' => 2,
            'num_ip' => $this->input->ip_address(), 
            'nom_ip' => gethostbyaddr($_SERVER['REMOTE_ADDR'])
          );
          $this->db->where('ins_id', $ins_id);
          $this->db->update('insumos', $this->security->xss_clean($update_ins));
        /*-----------------------------------------*/

        /*-------- DELETE INSUMO PROGRAMADO --------*/  
          $this->db->where('ins_id', $ins_id);
          $this->db->delete('temporalidad_prog_insumo');
          /*------------------------------------------*/ 

          for ($i=1; $i <=12 ; $i++) {
            $pfin=$this->security->xss_clean($post['mm'.$i]);
            if($pfin!=0){
                $data_to_store4 = array( 
                  'ins_id' => $ins_id, /// Id Insumo
                  'mes_id' => $i, /// Mes 
                  'ipm_fis' => $pfin, /// Valor mes
                  'g_id' => $this->gestion, /// Gestion
                  );
                $this->db->insert('temporalidad_prog_insumo', $data_to_store4);
            }
          }

        $this->session->set_flashdata('success','EL REQUERIMIENTO SE MODIFICO CORRECTAMENTE :)');
        redirect(site_url("").'/prog/requerimiento/'.$proy_id.'/'.$id.'');

      } else {
          show_404();
      }
    }

    /*----------- LISTA DE REQUERIMIENTOS (2020) --------------*/
    public function mis_requerimientos($lista_insumos,$componente,$tp){
      $fase=$this->model_faseetapa->get_fase($componente[0]['pfec_id']);
      $proyecto = $this->model_proyecto->get_id_proyecto($fase[0]['proy_id']); 

      $tabla='';
      if($tp==1){
        $col1=7;$col2=15;
        $tab='id="dt_basic" class="table table table-bordered" width="100%"'; 
      }
      elseif($tp==2){
        $col1=6;$col2=14;
        $tab='border="0" cellpadding="0" cellspacing="0" class="tabla" align="center"';
      }
      $total=0;
      $tabla.='<table '.$tab.'>
                <thead>
                  <tr class="modo1">
                    <th></th>
                    <th>PARTIDA</th>
                    <th>DETALLE REQUERIMIENTO</th>
                    <th>UNIDAD</th>
                    <th>CANTIDAD</th>
                    <th>UNITARIO</th>
                    <th>TOTAL</th>
                    <th>TOTAL PROG.</th>
                    <th style="background-color: #0AA699;color: #FFFFFF">ENE.</th>
                    <th style="background-color: #0AA699;color: #FFFFFF">FEB.</th>
                    <th style="background-color: #0AA699;color: #FFFFFF">MAR.</th>
                    <th style="background-color: #0AA699;color: #FFFFFF">ABR.</th>
                    <th style="background-color: #0AA699;color: #FFFFFF">MAY.</th>
                    <th style="background-color: #0AA699;color: #FFFFFF">JUN.</th>
                    <th style="background-color: #0AA699;color: #FFFFFF">JUL.</th>
                    <th style="background-color: #0AA699;color: #FFFFFF">AGO.</th>
                    <th style="background-color: #0AA699;color: #FFFFFF">SEPT.</th>
                    <th style="background-color: #0AA699;color: #FFFFFF">OCT.</th>
                    <th style="background-color: #0AA699;color: #FFFFFF">NOV.</th>
                    <th style="background-color: #0AA699;color: #FFFFFF">DIC.</th>
                    <th>OBSERVACIONES</th>';
                    if($tp==1){
                      $tabla.='<th>ELIMINAR</th>';

                      $tabla.='<th>COD. OPE.</th>';
                    }
                    $tabla.='
                  </tr>
                </thead>
                <tbody>';
                $cont = 0;
                foreach ($lista_insumos as $row) {
                  $color='';
                  $prog = $this->model_insumo->list_temporalidad_insumo($row['ins_id']);
                  if(count($prog)!=0){
                    if(($row['ins_costo_total'])!=$prog[0]['programado_total']){
                      $color='#f5bfb6';
                    }
                  }      
                  $cont++;
                  $tabla .= '<tr class="modo1" bgcolor="'.$color.'" title='.$row['ins_id'].'>';
                    $tabla .= '<td align="center">';
                    if($tp==1){
                      $tabla.='
                        <a href="#" data-toggle="modal" data-target="#modal_mod_ff" class="btn-default mod_ff" name="'.$row['ins_id'].'" title="MODIFICAR REQUERIMIENTO" ><img src="'.base_url().'assets/ifinal/modificar.png" WIDTH="35" HEIGHT="35"/></a><br>
                        <a href="#" data-toggle="modal" data-target="#modal_del_ff" class="btn-default del_ff" title="ELIMINAR REQUERIMIENTO"  name="'.$row['ins_id'].'"><img src="'.base_url().'assets/ifinal/eliminar.png" WIDTH="35" HEIGHT="35"/></a>';
                    }
                    else{
                      $tabla.=''.$cont.'';
                    }
                    $tabla .='</td>';
                    $tabla .='<td>'.$row['par_codigo'].'</td>'; /// partida
                    $tabla .= '<td>'.$row['ins_detalle'].'</td>'; /// detalle requerimiento
                    $tabla .= '<td>'.$row['ins_unidad_medida'].'</td>'; /// Unidad
                    $tabla .= '<td>'.$row['ins_cant_requerida'].'</td>'; /// cantidad
                    $tabla .= '<td>'.number_format($row['ins_costo_unitario'], 2, ',', '.').'</td>';
                    $tabla .= '<td>'.number_format($row['ins_costo_total'], 2, ',', '.').'</td>';
                    if(count($prog)!=0){
                      $tabla.='
                      <td>'.number_format($prog[0]['programado_total'], 2, ',', '.').'</td> 
                      <td bgcolor="#dcfbf8">'.number_format($prog[0]['mes1'], 2, ',', '.').'</td>
                      <td bgcolor="#dcfbf8">'.number_format($prog[0]['mes2'], 2, ',', '.').'</td>
                      <td bgcolor="#dcfbf8">'.number_format($prog[0]['mes3'], 2, ',', '.').'</td>
                      <td bgcolor="#dcfbf8">'.number_format($prog[0]['mes4'], 2, ',', '.').'</td>
                      <td bgcolor="#dcfbf8">'.number_format($prog[0]['mes5'], 2, ',', '.').'</td>
                      <td bgcolor="#dcfbf8">'.number_format($prog[0]['mes6'], 2, ',', '.').'</td>
                      <td bgcolor="#dcfbf8">'.number_format($prog[0]['mes7'], 2, ',', '.').'</td>
                      <td bgcolor="#dcfbf8">'.number_format($prog[0]['mes8'], 2, ',', '.').'</td>
                      <td bgcolor="#dcfbf8">'.number_format($prog[0]['mes9'], 2, ',', '.').'</td>
                      <td bgcolor="#dcfbf8">'.number_format($prog[0]['mes10'], 2, ',', '.').'</td>
                      <td bgcolor="#dcfbf8">'.number_format($prog[0]['mes11'], 2, ',', '.').'</td>
                      <td bgcolor="#dcfbf8">'.number_format($prog[0]['mes12'], 2, ',', '.').'</td>';
                    }
                    else{
                      $tabla.='
                      <td>0</td>
                      <td bgcolor="#f9d4ce">0</td>
                      <td bgcolor="#f9d4ce">0</td>
                      <td bgcolor="#f9d4ce">0</td>
                      <td bgcolor="#f9d4ce">0</td>
                      <td bgcolor="#f9d4ce">0</td>
                      <td bgcolor="#f9d4ce">0</td>
                      <td bgcolor="#f9d4ce">0</td>
                      <td bgcolor="#f9d4ce">0</td>
                      <td bgcolor="#f9d4ce">0</td>
                      <td bgcolor="#f9d4ce">0</td>
                      <td bgcolor="#f9d4ce">0</td>
                      <td bgcolor="#f9d4ce">0</td>';
                    }
                    $tabla .= '<td>'.$row['ins_observacion'].'</td>';

                    if($tp==1){
                      $tabla .= '
                      <td>
                        <center>
                          <input type="checkbox" name="ins[]" value="'.$row['ins_id'].'" onclick="scheck'.$cont.'(this.checked);"/>
                        </center>
                      </td>
                      <td>';
                        if($proyecto[0]['tp_id']==4){
                          $productos = $this->model_producto->list_producto_programado($componente[0]['com_id'],$this->gestion); // Lista de productos
                          $tabla .='<select class="form-control" onchange="doSelectAlert(event,this.value,'.$row['ins_id'].');">';
                            foreach($productos as $pr){
                              if($pr['prod_ppto']==1){
                                if($pr['prod_id']==$row['prod_id']){
                                  $tabla .="<option value=".$pr['prod_id']." selected>".$pr['prod_cod']."</option>";
                                }
                                else{
                                  $tabla .="<option value=".$pr['prod_id'].">".$pr['prod_cod']."</option>"; 
                                } 
                              }
                            }
                          $tabla.='</select>';
                        }
                      $tabla.='  
                      </td>';
                    }
                  $tabla .= '</tr>';
                  $total=$total+$row['ins_costo_total'];
                }
                $tabla.='
                </tbody>
                  <tr class="modo1">
                    <td colspan="'.$col1.'"> TOTAL </td>
                    <td><font color="blue" size=1>'.number_format($total, 2, ',', '.') .'</font></td>
                    <td colspan="'.$col2.'"></td>
                  </tr>
              </table>';

      return $tabla;
    }

    /*---------- LISTA DE REQUERIMIENTOS (2019) -----------*/
    public function mis_requerimientos_2019($lista_insumos,$tp){

      $tabla='';
      if($tp==1){
        $tab='id="dt_basic" class="table table table-bordered" width="100%"'; 
      }
      elseif($tp==2){
        $tab='border="0" cellpadding="0" cellspacing="0" class="tabla" align="center"';
      }
      $total=0;
      $tabla.='<table '.$tab.'>
                <thead>
                  <tr class="modo1">
                    <th></th>
                    <th>PARTIDA</th>
                    <th>DETALLE REQUERIMIENTO</th>
                    <th>UNIDAD</th>
                    <th>CANTIDAD</th>
                    <th>UNITARIO</th>
                    <th>TOTAL</th>
                    <th>TOTAL PROG.</th>
                    <th style="background-color: #0AA699;color: #FFFFFF">ENE.</th>
                    <th style="background-color: #0AA699;color: #FFFFFF">FEB.</th>
                    <th style="background-color: #0AA699;color: #FFFFFF">MAR.</th>
                    <th style="background-color: #0AA699;color: #FFFFFF">ABR.</th>
                    <th style="background-color: #0AA699;color: #FFFFFF">MAY.</th>
                    <th style="background-color: #0AA699;color: #FFFFFF">JUN.</th>
                    <th style="background-color: #0AA699;color: #FFFFFF">JUL.</th>
                    <th style="background-color: #0AA699;color: #FFFFFF">AGO.</th>
                    <th style="background-color: #0AA699;color: #FFFFFF">SEPT.</th>
                    <th style="background-color: #0AA699;color: #FFFFFF">OCT.</th>
                    <th style="background-color: #0AA699;color: #FFFFFF">NOV.</th>
                    <th style="background-color: #0AA699;color: #FFFFFF">DIC.</th>
                    <th>OBSERVACIONES</th>
                  </tr>
                </thead>
                <tbody>';
                $cont = 0;
                foreach ($lista_insumos as $row) {
                  $prog=$this->minsumos->get_temporalidad_2019($row['ins_id']);
                  $color='';
                  if(count($prog)!=0){
                    if(($row['ins_costo_total'])!=$prog[0]['programado_total']){
                      $color='#f5bfb6';
                    }
                  }
         
                  $cont++;
                  $tabla .= '<tr class="modo1" bgcolor="'.$color.'" title='.$row['ins_id'].'>';
                    $tabla .= '<td align="center">';
                    if($tp==1){
                      $tabla.='
                          <a href="#" data-toggle="modal" data-target="#modal_mod_ff" class="btn-default mod_ff" name="'.$row['ins_id'].'" title="MODIFICAR REQUERIMIENTO" ><img src="'.base_url().'assets/ifinal/modificar.png" WIDTH="35" HEIGHT="35"/></a><br>
                          <a href="#" data-toggle="modal" data-target="#modal_del_ff" class="btn-default del_ff" title="ELIMINAR REQUERIMIENTO"  name="'.$row['ins_id'].'"><img src="'.base_url().'assets/ifinal/eliminar.png" WIDTH="35" HEIGHT="35"/></a>';
                    }
                    else{
                      $tabla.=''.$cont.'';
                    }

                    $tabla .='</td>';
                    $tabla .='<td>'.$row['par_codigo'].'</td>'; /// partida
                    $tabla .= '<td>'.$row['ins_detalle'].'</td>'; /// detalle requerimiento
                    $tabla .= '<td>'.$row['ins_unidad_medida'].'</td>'; /// Unidad
                    $tabla .= '<td>'.$row['ins_cant_requerida'].'</td>'; /// cantidad
                    $tabla .= '<td>'.number_format($row['ins_costo_unitario'], 2, ',', '.').'</td>';
                    $tabla .= '<td>'.number_format($row['ins_costo_total'], 2, ',', '.').'</td>';

                    if(count($prog)!=0){
                      $tabla.='
                      <td>'.number_format($prog[0]['programado_total'], 2, ',', '.').'</td> 
                      <td bgcolor="#dcfbf8">'.number_format($prog[0]['mes1'], 2, ',', '.').'</td>
                      <td bgcolor="#dcfbf8">'.number_format($prog[0]['mes2'], 2, ',', '.').'</td>
                      <td bgcolor="#dcfbf8">'.number_format($prog[0]['mes3'], 2, ',', '.').'</td>
                      <td bgcolor="#dcfbf8">'.number_format($prog[0]['mes4'], 2, ',', '.').'</td>
                      <td bgcolor="#dcfbf8">'.number_format($prog[0]['mes5'], 2, ',', '.').'</td>
                      <td bgcolor="#dcfbf8">'.number_format($prog[0]['mes6'], 2, ',', '.').'</td>
                      <td bgcolor="#dcfbf8">'.number_format($prog[0]['mes7'], 2, ',', '.').'</td>
                      <td bgcolor="#dcfbf8">'.number_format($prog[0]['mes8'], 2, ',', '.').'</td>
                      <td bgcolor="#dcfbf8">'.number_format($prog[0]['mes9'], 2, ',', '.').'</td>
                      <td bgcolor="#dcfbf8">'.number_format($prog[0]['mes10'], 2, ',', '.').'</td>
                      <td bgcolor="#dcfbf8">'.number_format($prog[0]['mes11'], 2, ',', '.').'</td>
                      <td bgcolor="#dcfbf8">'.number_format($prog[0]['mes12'], 2, ',', '.').'</td>';
                    }
                    else{
                      $tabla.='
                      <td>0</td>
                      <td bgcolor="#f9d4ce">0</td>
                      <td bgcolor="#f9d4ce">0</td>
                      <td bgcolor="#f9d4ce">0</td>
                      <td bgcolor="#f9d4ce">0</td>
                      <td bgcolor="#f9d4ce">0</td>
                      <td bgcolor="#f9d4ce">0</td>
                      <td bgcolor="#f9d4ce">0</td>
                      <td bgcolor="#f9d4ce">0</td>
                      <td bgcolor="#f9d4ce">0</td>
                      <td bgcolor="#f9d4ce">0</td>
                      <td bgcolor="#f9d4ce">0</td>
                      <td bgcolor="#f9d4ce">0</td>';
                    }
                    
                    $tabla .= '<td>'.$row['ins_observacion'].'</td>';
                  $tabla .= '</tr>';
                  $total=$total+$row['ins_costo_total'];
                }
                $tabla.='
                </tbody>
                  <tr class="modo1">
                    <td colspan="6"> TOTAL </td>
                    <td><font color="blue" size=1>'.number_format($total, 2, ',', '.') .'</font></td>
                    <td colspan="14"></td>
                  </tr>
              </table>';

      return $tabla;
    }

    /*------------ TABLA PRODUCTO-REQUERIMIENTOS -----------*/
    function genera_tabla_prod_insumo($proy_id){
        $proyecto = $this->model_proyecto->get_id_proyecto($proy_id); //// DATOS DEL PROYECTO
        $fase = $this->model_faseetapa->get_id_fase($proy_id); //// recupera datos de la tabla fase activa
        $componentes=$this->model_componente->componentes_id($fase[0]['id'],$proyecto[0]['tp_id']);

        $tabla = '';
        $cont_acordion = 0;
        foreach ($componentes as $row) {
            $requerimientos = $this->minsumos->list_requerimientos_operacion_procesos($row['com_id']);
            $cont_acordion++;
            $tabla .= '<div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse' . $cont_acordion . '">
                                        <i class="fa fa-lg fa-angle-down pull-right"></i> <i class="fa fa-lg fa-angle-up pull-right"></i>';
                                            if($proyecto[0]['tp_id']==1){
                                                $tabla.=''.$row['com_componente'].'';
                                            }
                                            else{
                                                $tabla.=''.$row['serv_cod'].' - ' . $row['com_componente'] .'';
                                            }
                                        $tabla.='
                                    </a>
                                </h4>
                            </div>';
            $tabla .= '<div id="collapse' . $cont_acordion . '" class="panel-collapse collapse">
                            <div class="panel-body no-padding table-responsive">
                                <table class="table table-bordered table-condensed">';
            $tabla .= '            <tbody>
                                      <tr>
                                          <td></td>
                                          <td><b>ASIGNAR</b></td>
                                          <td><b>OPERACI&Oacute;N</b></td>
                                          <td><b>RESULTADO</b></td>
                                          <td><b>MONTO PROGRAMADO</b></td>
                                      </tr>';
            $lista_productos = $this->model_producto->list_prod($row['com_id']);
            $cont = 1;
            foreach ($lista_productos as $row_p) {
                $monto=$this->model_producto->monto_insumoproducto($row_p['prod_id']);
                $tabla .= '<tr>';
                $tabla .= '<td>'.$row_p['prod_cod'].'</td>';
                $tabla .= '<td>';
                  if($row_p['prod_ppto']==1){
                    $tabla.='<a href="' . site_url("").'/prog/requerimiento/'.$proy_id.'/'.$row_p['prod_id'].'" target="_blank" title="REQUERIMIENTOS DE LA OPERACI&Oacute;N" >
                                  <center>
                                      <img src="' . base_url() . 'assets/ifinal/money.png" width="30" height="30"
                                      class="img-responsive "title="ASIGNAR REQUERIMIENTOS A LA OPERACI&Oacute;N">
                                  </center>
                              </a>';
                  }
                $tabla.=' </td>';
                $tabla .= '<td>'.$row_p['prod_producto'].'</td>';
                $tabla .= '<td>'.$row_p['prod_resultado'].'</td>';
                $tabla .= '<td>';
                            if(count($monto)!=0){
                            $tabla.=''.number_format($monto[0]['total'], 2, ',', '.').' Bs.';
                            }
                            else{
                                $tabla.='0.00 Bs.';
                            }
                $tabla .= '</td>';
                $tabla .= '</tr>';
                $cont++;
            }
            $tabla .= '             </tbody>
                                </table>
                           </div>
                      </div>
                 </div>';
        }
        return $tabla;
    }

    /*------------ TABLA ACTIVIDADES-REQUERIMIENTOS -----------*/
    function genera_tabla_act_insumo($proy_id){
        $lista_productos = $this->minsumos->lista_productos($proy_id, $this->gestion);
        $tabla = '';
        $cont_acordion = 0;
        foreach ($lista_productos as $row) {
            $cont_acordion++;
            $tabla .= '<div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse' . $cont_acordion . '">
                                        <i class="fa fa-lg fa-angle-down pull-right"></i> <i class="fa fa-lg fa-angle-up pull-right"></i>' .
                $cont_acordion . ' - ' . $row['prod_producto'] . '
                                    </a>
                                </h4>
                            </div>';
            $tabla .= '<div id="collapse' . $cont_acordion . '" class="panel-collapse collapse">
                            <div class="panel-body no-padding table-responsive">
                                <table class="table table-bordered table-condensed">';
            $tabla .= '            <tbody>
                                      <tr>
                                          <td><b>NRO.</b></td>
                                          <td><b>ASIGNAR</b></td>
                                          <td><b>DETALLE ACTIVIDAD</b></td>
                                          <td><b>MEDIO DE VERIFICACI&Oacute;N</b></td>
                                          <td><b>META</b></td>
                                          <td><b>PRESUPUESTO</b></td>
                                      </tr>';
            $lista_actividad = $this->minsumos->lista_actividades($row['prod_id'], $this->gestion);
            $cont = 1;
            foreach ($lista_actividad as $row_a) {
                $monto=$this->model_actividad->monto_insumoactividad($row_a['act_id']);
                $tabla .= '<tr>';
                $tabla .= '<td>'.$cont_acordion.'-'.$cont.'</td>';
                $tabla .= '<td>
                                <a href="' . site_url("").'/prog/requerimiento/'.$proy_id.'/'.$row_a['act_id'].'" target="_blank" title="REQUERIMIENTOS DE LA ACTIVIDAD">
                                    <center>
                                        <img src="'.base_url().'assets/ifinal/money.png" width="30" height="30"
                                        class="img-responsive "title="ASIGNAR INSUMOS">
                                    </center>
                               </a>
                          </td>';
                $tabla .= '<td>'.$row_a['act_actividad'].'</td>';
                $tabla .= '<td>'.$row_a['act_fuente_verificacion'].'</td>';
                $tabla .= '<td>'.$row_a['act_meta'].'</td>';
                $tabla .= '<td>';
                            if(count($monto)!=0){
                                $tabla.=''.number_format($monto[0]['total'], 2, ',', '.').' Bs.';
                            }
                            else{
                                $tabla.='0.00 Bs.';
                            }
                $tabla .= '</td>';
                $tabla .= '</tr>';
                $cont++;
            }
            $tabla .= '             </tbody>
                                </table>
                           </div>
                      </div>
                 </div>';
        }
        return $tabla;
    }


    /*----- TABLA - CONSOLIDADO OPERACION (OPERACIONES) -----*/
    public function consolidado_partidas_operacion($id,$tp,$tp_id){
      $tabla='';
      if($tp_id==1){
        $partidas = $this->minsumos->consolidado_partidas_directo($id);
      }
      else{
        $partidas = $this->minsumos->consolidado_partidas_operacion($id);
      }

      if($tp==1){
        $tab='class="table table-bordered" style="width:70%;"';
      }
      elseif($tp==2){
        $tabla ='<style>
                    table{font-size: 9px;
                          width: 100%;
                          max-width:1550px;
                          overflow-x: scroll;
                          }
                          th{
                            padding: 1.4px;
                            text-align: center;
                            font-size: 9px;
                          }
                    </style>';
        $tab='border="0" cellpadding="0" cellspacing="0" class="tabla" style="width:70%;" align="center"';
      }
      
      $nro=0;
      $tabla.='<center>
      <table '.$tab.'>
        <thead>
          <tr class="modo1">
            <th scope="col" bgcolor="#1c7368"><font color="#ffffff">#</font></th>
            <th scope="col" bgcolor="#1c7368"><font color="#ffffff">C&Oacute;DIGO PARTIDA</font></th>
            <th scope="col" bgcolor="#1c7368"><font color="#ffffff">DESCRIPCI&Oacute;N PARTIDA</font></th>
            <th scope="col" bgcolor="#1c7368"><font color="#ffffff">MONTO PROGRAMADO</font></th>
          </tr>
        </thead>
        <tbody>';
        $monto_total=0;
      foreach ($partidas as $row) {
        $monto_total=$monto_total+$row['total'];
        $nro++;
        $tabla.='<tr class="modo1">';

          $tabla.='<td>'.$nro.'</td>';
          $tabla.='<td>'.$row['par_codigo'].'</td>';
          
          if($tp==1){
            $tabla.='<td>'.$row['par_nombre'].'</td>';
            $tabla.='<td>' . number_format($row['total'], 2, ',', '.') . '</td>';
          }
          else{
            $tabla.='<td>'.mb_convert_encoding(''.$row['par_nombre'], 'cp1252', 'UTF-8').'</td>';
            $tabla.='<td>'.$row['total'].'</td>';
          }
        $tabla.='</tr>';
      }
      $tabla.='<tr>';
          $tabla.='<td></td>';
          $tabla.='<td colspan="2">TOTAL</td>';
          if($tp==1){
            $tabla.='<td>'.number_format($monto_total, 2, ',', '.').'</td>';
          }
          else{
            $tabla.='<td>'.$monto_total.'</td>';
          }
          
        $tabla.='</tr>';
      $tabla.='</tbody>
      </table></center>';

      return $tabla;
    }




    /*---- COMPARATIVO DE PARTIDAS A NIVEL DE UNIDAD / ESTABLECIMIENTO (2019)---*/
    public function comparativo_partidas_acciones($dep_id,$aper_id){ 
      $tabla ='';
      $partidas_asig=$this->model_ptto_sigep->partidas_accion_region($dep_id,$aper_id,1); // Asig
      $partidas_prog=$this->model_ptto_sigep->partidas_accion_region($dep_id,$aper_id,2); // Prog

      $nro=0;
      $monto_asig=0;
      $monto_prog=0;
      $tabla .='<table id="dt_basic1" class="table table-bordered">
                  <thead>
                    <tr>
                      <th bgcolor="#1c7368" style="width:1%;"><font color=#fff>NRO.</font></th>
                      <th bgcolor="#1c7368" style="width:5%;"><font color=#fff>C&Oacute;DIGO PARTIDA</font></th>
                      <th bgcolor="#1c7368" style="width:15%;"><font color=#fff>DETALLE PARTIDA</font></th>
                      <th bgcolor="#1c7368" style="width:10%;"><font color=#fff>PRESUPUESTO ASIGNADO</font></th>
                      <th bgcolor="#1c7368" style="width:10%;"><font color=#fff>PRESUPUESTO PROGRAMADO</font></th>
                      <th bgcolor="#1c7368" style="width:10%;"><font color=#fff>MONTO DIFERENCIA</font></th>
                    </tr>
                  </thead>
                  <tbody>';
      if(count($partidas_asig)>count($partidas_prog)){
        foreach($partidas_asig  as $row){
          $part=$this->model_ptto_sigep->get_partida_accion_regional($dep_id,$aper_id,$row['par_id']);
            $prog=0;
            if(count($part)!=0){
              $prog=$part[0]['monto'];
            }
            $dif=($row['monto']-$prog);
            $color='#f1f1f1';
            if($dif<0){
              $color='#f9cdcd';
            }

            $nro++;
            $tabla .='<tr class="modo1" bgcolor='.$color.'>
                        <td align=center>'.$nro.'</td>
                        <td align=center>'.$row['codigo'].'</td>
                        <td align=left>'.$row['nombre'].'</td>
                        <td align=right>'.number_format($row['monto'], 2, ',', '.').'</td>
                        <td align=right>'.number_format($prog, 2, ',', '.').'</td>
                        <td align=right>'.number_format($dif, 2, ',', '.').'</td>
                      </tr>';
            $monto_asig=$monto_asig+$row['monto'];
            $monto_prog=$monto_prog+$prog;
        }

        foreach($partidas_prog  as $row){
          $nro++;
          $part=$this->model_ptto_sigep->get_partida_asig_accion($dep_id,$aper_id,$row['par_id']);
          if(count($part)==0){
            $asig=0;
            if(count($part)!=0){
              $asig=$part[0]['monto'];
            }
            $dif=($asig-$row['monto']);
            $color='#f1f1f1';
            if($dif<0){
              $color='#f9cdcd';
            }
            $tabla .='<tr class="modo1" bgcolor='.$color.'>
                        <td align=center>'.$nro.'</td>
                        <td align=center>'.$row['codigo'].'</td>
                        <td align=left>'.$row['nombre'].'</td>
                        <td align=right>'.number_format($asig, 2, ',', '.').'</td>
                        <td align=right>'.number_format($row['monto'], 2, ',', '.').'</td>
                        <td align=right>'.number_format($dif, 2, ',', '.').'</td>
                      </tr>';
                      $monto_asig=$monto_asig+$asig;
                      $monto_prog=$monto_prog+$row['monto'];
          }
        }
      }
      else{
        foreach($partidas_prog  as $row){
          $part=$this->model_ptto_sigep->get_partida_asig_accion($dep_id,$aper_id,$row['par_id']);
            $asig=0;
            if(count($part)!=0){
              $asig=$part[0]['monto'];
            }
            $dif=($asig-$row['monto']);
            $color='#f1f1f1';
            if($dif<0){
              $color='#f9cdcd';
            }

          $nro++;
          $tabla .='<tr class="modo1" bgcolor='.$color.'>
                      <td align=center>'.$nro.'</td>
                      <td align=center>'.$row['codigo'].'</td>
                      <td align=left>'.$row['nombre'].'</td>
                      <td align=right>'.number_format($asig, 2, ',', '.').'</td>
                      <td align=right>'.number_format($row['monto'], 2, ',', '.').'</td>
                      <td align=right>'.number_format($dif, 2, ',', '.').'</td>
                    </tr>';
          $monto_asig=$monto_asig+$asig;
          $monto_prog=$monto_prog+$row['monto'];
        }

        foreach($partidas_asig  as $row){
            $part=$this->model_ptto_sigep->get_partida_accion_regional($dep_id,$aper_id,$row['par_id']);

            if(count($part)==0){
                $prog=0;
                if(count($part)!=0){
                  $prog=$part[0]['monto'];
                }
                $dif=($row['monto']-$prog);
                $color='#f1f1f1';
                if($dif<0){
                  $color='#f9cdcd';
                }

                $nro++;
                $tabla .='<tr class="modo1" bgcolor='.$color.'>
                            <td align=center>'.$nro.'</td>
                            <td align=center>'.$row['codigo'].'</td>
                            <td align=left>'.$row['nombre'].'</td>
                            <td align=right>'.number_format($row['monto'], 2, ',', '.').'</td>
                            <td align=right>'.number_format($prog, 2, ',', '.').'</td>
                            <td align=right>'.number_format($dif, 2, ',', '.').'</td>
                          </tr>';
                $monto_asig=$monto_asig+$row['monto'];
                $monto_prog=$monto_prog+$prog;
            }
              
          }
        
      }
      $tabla .='</tbody>
                  <tr class="modo1">
                      <td colspan=3><strong>TOTAL</strong></td>
                      <td align=right>'.number_format($monto_asig, 2, ',', '.').'</td>
                      <td align=right>'.number_format($monto_prog, 2, ',', '.').'</td>
                      <td align=right>'.number_format(($monto_asig-$monto_prog), 2, ',', '.').'</td>
                    </tr>
                </table>';

      return $tabla;
    }


    /*---- CAMBIA EL ID DEL INSUMO Y LO LLEVA A INSUMOPRODUCTO ----*/
    function update_id_requerimientos_pi($proy_id){
      $productos=$this->model_producto->list_productos_proyecto($proy_id);
      foreach($productos as $rowp){
        //echo "prod_id : ".$rowp['prod_id']." - DESC. ".$rowp['prod_producto']."<br>";
          $lista_insumos=$this->model_producto->lista_insumos_por_producto($rowp['prod_id']);
          if(count($lista_insumos)!=0){
            foreach($lista_insumos as $rowi){
              //echo "ins_id : ".$rowi['ins_id']." - ".$rowi['ins_detalle']."<br>";
              //----- Inserrta el id insumo a insumoproducto
              $data_to_store = array( 
                'prod_id' => $rowp['prod_id'],
                'ins_id' => $rowi['ins_id'],
                'tp_ins' => 1,
              );
              $this->db->insert('_insumoproducto', $data_to_store);
              //--------------------------------------------

              //----- Elimina la relacion Insumoactividad
              $this->db->where('ins_id', $rowi['ins_id']);
              $this->db->where('act_id', $rowi['act_id']);
              $this->db->delete('_insumoactividad');
              //--------------------------------------------
            }
          }
          else{
            redirect('admin/proy/list_proy#tabs-a'); ///// Lista de Proyectos de Inversion
          }
      }

      redirect('admin/proy/list_proy#tabs-a'); ///// Lista de Proyectos de Inversion
    }






    /*------ CAMBIA CODIGO DE ACTIVIDAD ---------*/
    function cambia_actividad(){
      if($this->input->is_ajax_request() && $this->input->post()){
          $this->form_validation->set_rules('prod_id', 'id producto', 'required|trim');
          $this->form_validation->set_message('required', 'El campo es es obligatorio');
        
          $post = $this->input->post();
          $prod_id= $this->security->xss_clean($post['prod_id']);
          $ins_id= $this->security->xss_clean($post['ins_id']);
           
          $update_proy = array(
            'prod_id' => $prod_id,
          );
          $this->db->where('ins_id', $ins_id);
          $this->db->update('_insumoproducto', $update_proy);
              
      }else{
          show_404();
      }
    }


    /*--------- Lista Partidas Hijos -----------*/
    public function combo_partidas_hijos(){
      //echo "urbanizaciones";
      $salida = "";
      $id_pais = $_POST["elegido"];
      // construimos el combo de ciudades deacuerdo al pais seleccionado
      $combog = pg_query("SELECT * FROM partidas WHERE par_depende=$id_pais");
      $salida .= "<option value=''>" . mb_convert_encoding('SELECCIONE PARTIDA', 'cp1252', 'UTF-8') . "</option>";
      while ($sql_p = pg_fetch_row($combog)) {
          $salida .= "<option value='" . $sql_p[0] . "'>" .$sql_p[4]." - ".$sql_p[1] . "</option>";
      }
      echo $salida;
    }

    /*--------- Lista Unidades de Medida -----------*/
    public function combo_unidad_medida(){
      //echo "urbanizaciones";
      $salida = "";
      $par_id = $_POST["elegido"];
      // construimos el combo de ciudades deacuerdo al pais seleccionado
      $combog = pg_query('select *
              from par_umedida pum
              Inner Join insumo_unidadmedida as ium on ium.um_id = pum.um_id
              where pum.par_id='.$par_id.'
              order by ium.um_id asc');
      $salida .= "<option value=''>" . mb_convert_encoding('SELECCIONE UNIDAD DE MEDIDA', 'cp1252', 'UTF-8') . "</option>";
      while ($sql_p = pg_fetch_row($combog)) {
          $salida .= "<option value='" . $sql_p[3] . "'>" .$sql_p[4]. "</option>";
      }
      echo $salida;
    }

    /*--------- Lista Partidas Hijos Asignados-----------*/
    public function combo_partidas_hijos_asignados(){
        $salida = "";
        $id_pais = $_POST["elegido"]; /// codigo Partida
        $aper_id = $_POST["aper"]; /// aper id

        $combog = pg_query('
            select pg.par_id,pg.partida as par_codigo,p.par_nombre,p.par_depende,pg.importe
            from ptto_partidas_sigep pg
            Inner Join partidas as p On p.par_id=pg.par_id
            where pg.aper_id='.$aper_id.' and pg.estado!=\'3\' and pg.g_id='.$this->gestion.' and p.par_depende='.$id_pais.'
            order by pg.partida asc
        ');
        $salida .= "<option value=''>" . mb_convert_encoding('SELECCIONE PARTIDA', 'cp1252', 'UTF-8') . "</option>";
        while ($sql_p = pg_fetch_row($combog)) {
            $salida .= "<option value='" . $sql_p[0] . "'>" .$sql_p[1]." - ".$sql_p[2] . "</option>";
        }
        echo $salida;
    }

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

    /*--------------- GENERA MENU -------------*/
    public function genera_menu($proy_id){
      $id_f = $this->model_faseetapa->get_id_fase($proy_id);
      $enlaces=$this->menu_modelo->get_Modulos_programacion(2);
      $tabla='';
      $tabla.='<nav>
              <ul>
                  <li>
                      <a href='.site_url("admin").'/dashboard'.' title="MENU PRINCIPAL"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">MEN&Uacute; PRINCIPAL</span></a>
                  </li>
                  <li class="text-center">
                      <a href='.base_url().'index.php/admin/proy/mis_proyectos/1'.' title="PROGRAMACI&Oacute;N POA"> <span class="menu-item-parent">PROGRAMACI&Oacute;N POA</span></a>
                  </li>';
                  if(count($id_f)!=0){
                      for($i=0;$i<count($enlaces);$i++){ 
                          $tabla.='
                          <li>
                              <a href="#" >
                                  <i class="'.$enlaces[$i]['o_image'].'"></i> <span class="menu-item-parent">'.$enlaces[$i]['o_titulo'].'</span></a>
                              <ul >';
                              $submenu= $this->menu_modelo->get_Modulos_sub($enlaces[$i]['o_child']);
                              foreach($submenu as $row) {
                                 $tabla.='<li><a href='.base_url($row['o_url'])."/".$id_f[0]['proy_id'].'>'.$row['o_titulo'].'</a></li>';
                              }
                          $tabla.='</ul>
                          </li>';
                      }
                  }
              $tabla.='
              </ul>
          </nav>';

      return $tabla;
    }

}