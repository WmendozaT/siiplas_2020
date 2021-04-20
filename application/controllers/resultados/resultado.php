<?php
define("DOMPDF_ENABLE_REMOTE", true);
define("DOMPDF_TEMP_DIR", "/tmp");
class resultado extends CI_Controller {  
  public function __construct ()
  {
        parent::__construct();
        if($this->session->userdata('fun_id')!=null){
        $this->load->library('pdf');
        $this->load->library('pdf2');
        $this->load->model('resultados/model_resultado');
        $this->load->model('programacion/model_proyecto');
        $this->load->model('menu_modelo');
        $this->load->model('Users_model','',true);
        }else{
            redirect('/','refresh');
        }
    }
    /*============================ COMBO FUNCIONARIO A UNIDAD RESPONSABLE =====================*/
    public function combo_funcionario_unidad_organizacional($accion='') 
    { 
      $salida="";
      $accion=$_POST["accion"];
      switch ($accion) {
        case 'unidad':
        $salida="";
          $id_pais=$_POST["elegido"];
          
          $combog = pg_query('SELECT u.*
          from funcionario f
          Inner Join unidadorganizacional as u On u."uni_id"=f."uni_id"
          where  f."fun_id"='.$id_pais.'');
          while($sql_p = pg_fetch_row($combog))
          {$salida.= "<option value='".$sql_p[0]."'>".$sql_p[2]."</option>";}

        echo $salida; 
        //return $salida;
        break;
      }
    }

    /*================================ LISTA DE RESULTADOS ==================================*/
    public function resultados()
    {
        $enlaces=$this->menu_modelo->get_Modulos(1);
        $data['enlaces'] = $enlaces;
        for($i=0;$i<count($enlaces);$i++){
          $subenlaces[$enlaces[$i]['o_child']]=$this->menu_modelo->get_Enlaces($enlaces[$i]['o_child'], $this->session->userdata('user_name'));
        }
        $data['subenlaces'] = $subenlaces;
        $conf=$this->model_resultado->configuracion();
        $data['resultados']=$this->model_resultado->list_resultados($conf[0]['conf_gestion_desde'],$conf[0]['conf_gestion_hasta']);


        $this->load->view('admin/resultados/list_resultados', $data);
    }

    /*================================ AGREGAR RESULTADOS FORMULARIO 1==================================*/
    public function form1_resultados()
    {
        $enlaces=$this->menu_modelo->get_Modulos(1);
        $data['enlaces'] = $enlaces;
        for($i=0;$i<count($enlaces);$i++) 
        {
          $subenlaces[$enlaces[$i]['o_child']]=$this->menu_modelo->get_Enlaces($enlaces[$i]['o_child'], $this->session->userdata('user_name'));
        }
        $data['subenlaces'] = $subenlaces;
        $meses=$this->get_mes($this->session->userdata("mes"));
        $mes = $meses[1];
        $dias = $meses[2];

        $data['id_mes'] = $this->session->userdata("mes");
        $data['mes'] = $mes;

        $data['responsables'] = $this->model_resultado->responsables();//lista de responsables
        $this->load->view('admin/resultados/add1_resultado', $data);
    }
    /*========================================= VALIDAR FORMULARIO 1 ===========================================================*/
    function add_resultado1()
    { 
       if($this->input->server('REQUEST_METHOD') === 'POST'){
          $this->form_validation->set_rules('fun_id', 'Id del responsable ', 'required|trim');
          $this->form_validation->set_rules('uni_id', 'Unidad Responsable', 'required|trim');
          $this->form_validation->set_rules('pedes4', 'Etapa', 'required|trim');

          $conf=$this->model_resultado->configuracion();
          $nro_obj=$conf[0]['conf_obj_estrategico']+1;
          $gestion_inicio=$conf[0]['conf_gestion_desde'];
          $gestion_final=$conf[0]['conf_gestion_hasta'];

          if($this->input->post('pedes4')==""){
            $id_pdes = $this->model_proyecto->get_id_pdes($this->input->post('pedes3'));  // devuelve id pedes    
          }
          elseif ($this->input->post('pedes4')!=""){
            $id_pdes = $this->model_proyecto->get_id_pdes($this->input->post('pedes4'));  // devuelve id pedes  
          }

          if ($this->form_validation->run()){
                $query=$this->db->query('set datestyle to DMY');
                $data_to_store = array( 
                  'r_resultado' => strtoupper($this->input->post('resultado')),
                  'pdes_id' => $id_pdes[0]['pdes_id'],
                  'ptdi_id' => 0,
                  'resp_id' => $this->input->post('fun_id'),
                  'uni_id' => $this->input->post('uni_id'),
                  'nro_ind' => $this->input->post('nro'),
                  'r_ponderacion' => $this->input->post('pn_cion'),
                  'r_codigo' => 'RMP-'.$nro_obj,
                  'gestion_desde' => $gestion_inicio,
                  'gestion_hasta' => $gestion_final,
                  'fun_id' => $this->session->userdata("fun_id"),
              );
              $this->db->insert('resultado_mediano_plazo', $data_to_store); ///// inserta a resultados 
              $id_res = $this->db->insert_id();

              $update_conf = array('conf_obj_estrategico' => $nro_obj);
              $this->db->where('ide', $this->session->userdata("gestion"));
              $this->db->update('configuracion', $update_conf);

              redirect('admin/me/form2/'.$id_res.'/1');
              
          }
          else{  
            redirect('admin/me/form1');
          }
      }
    }
  /*=========================================================================================================================*/
  /*================================ AGREGAR RESULTADOS FORMULARIO 2 ==================================*/
    public function form2_resultados($r_id,$nro)
    {
        $enlaces=$this->menu_modelo->get_Modulos(1);
        $data['enlaces'] = $enlaces;
        for($i=0;$i<count($enlaces);$i++){
          $subenlaces[$enlaces[$i]['o_child']]=$this->menu_modelo->get_Enlaces($enlaces[$i]['o_child'], $this->session->userdata('user_name'));
        }
        $data['subenlaces'] = $subenlaces;
        $meses=$this->get_mes($this->session->userdata("mes"));
        $mes = $meses[1];
        $dias = $meses[2];

        $data['id_mes'] = $this->session->userdata("mes");
        $data['mes'] = $mes;
        $data['indi']= $this->model_proyecto->indicador(); /// indicador

        $data['resultado'] = $this->model_resultado->get_resultado($r_id);// get resultado
        $data['nro'] = $nro;
        $this->load->view('admin/resultados/add2_resultado', $data);
    }
    /*========================================= VALIDAR FORMULARIO 2 (INDICADORES) ===========================================================*/
    function add_resultado2()
    { 
       if($this->input->server('REQUEST_METHOD') === 'POST') 
        {
          $this->form_validation->set_rules('r_id', 'Id resultado ', 'required|trim');
          $this->form_validation->set_rules('nro', 'nro de indicador', 'required|trim');
          $this->form_validation->set_rules('tipo_i', 'Indicador', 'required|trim');

          if ($this->form_validation->run()){
            $r[1]='g1';
            $r[2]='g2';
            $r[3]='g3';
            $r[4]='g4';
            $r[5]='g5';

            if($this->input->post('tp_medida')==1){
              $linea_base=$this->input->post('lb');
              $meta=$this->input->post('met');
            }
            else{
              $linea_base=$this->input->post('lb2');
              $meta=$this->input->post('met2');
            }

            $query=$this->db->query('set datestyle to DMY');
            $data_to_store = array( 
              'r_id' => $this->input->post('r_id'),
              'indi_id' => $this->input->post('tipo_i'),
              'in_indicador' => strtoupper($this->input->post('indicador')),
              'in_formula' => strtoupper($this->input->post('formula')),
              'in_linea_base' => $linea_base,
              'in_meta' => $meta,
              'in_denominador' => $this->input->post('den'),
              'in_fuente' => strtoupper($this->input->post('verificacion')),
              'in_ponderacion' => $this->input->post('pn_cion'),
              'in_supuestos' => strtoupper($this->input->post('supuestos')),
              'in_total_casos' => strtoupper($this->input->post('c_a')),
              'in_casos_fav' => strtoupper($this->input->post('c_b')),
              'tp_med' => $this->input->post('tp_medida'),
              'valor_ind' => $this->input->post('valor_i'),
              'fun_id' => $this->session->userdata("fun_id"),
              );
              $this->db->insert('indi_resultados', $data_to_store); ///// inserta a indicador del resultado 
              $id_ir = $this->db->insert_id();

              $conf=$this->model_resultado->configuracion();
              $g1=$conf[0]['conf_gestion_desde'];

              if($this->input->post('tp_medida')==1){
                for($i=1;$i<=5;$i++){
                  if($this->input->post($r[$i])!=0){
                    $data_to_store2 = array( 
                    'in_id' => $id_ir,
                    'g_id' => $g1,
                    'in_prog' => $this->input->post($r[$i]),
                    );
                    $this->db->insert('resultados_prog', $data_to_store2);
                  }
                  $g1++;
                }
              }
              else{
                for($i=1;$i<=5;$i++){
                    $data_to_store2 = array( 
                    'in_id' => $id_ir,
                    'g_id' => $g1,
                    'in_prog' => $meta,
                    );
                    $this->db->insert('resultados_prog', $data_to_store2);
                  $g1++;
                }
              }

              if($this->input->post('nro')==$this->input->post('nro_ind')){
                $this->session->set_flashdata('success','SE GUARDO CORRECTAMENTE LA ACCIÓN DE MEDIANO PLAZO');
                redirect('admin/me/resultados'); 
              }
              else{
                $nro=$this->input->post('nro')+1;
                redirect('admin/me/form2/'.$this->input->post('r_id').'/'.$nro.'');
              }
          }
          else{
            $this->session->set_flashdata('danger','ERROR AL GUARDAR');  
            redirect('admin/me/form2/'.$this->input->post('r_id').'/'.$this->input->post('nro').'/false');
          }
      }
    }
    /*================================ EDITAR RESULTADO ==================================*/
    public function update_resultado($r_id)
    {
        $enlaces=$this->menu_modelo->get_Modulos(1);
        $data['enlaces'] = $enlaces;
        for($i=0;$i<count($enlaces);$i++) 
        {
          $subenlaces[$enlaces[$i]['o_child']]=$this->menu_modelo->get_Enlaces($enlaces[$i]['o_child'], $this->session->userdata('user_name'));
        }
        $data['subenlaces'] = $subenlaces;
        $meses=$this->get_mes($this->session->userdata("mes"));
        $mes = $meses[1];
        $dias = $meses[2];

        $data['id_mes'] = $this->session->userdata("mes");
        $data['mes'] = $mes;
        $data['indi']= $this->model_proyecto->indicador(); /// indicador

        $data['resultado'] = $this->model_resultado->get_resultado($r_id);// get resultado
        $data['pdes'] = $this->model_proyecto->datos_pedes($data['resultado'][0]['pdes_id']);
       // $data['lista_ptdi']=$this->model_proyecto->lista_ptdi();
       // $data['ptdi'] = $this->model_proyecto->datos_ptdi($data['resultado'][0]['ptdi_id']);
        $data['responsables'] = $this->model_resultado->responsables();//lista de responsables
        $data['unidad'] = $this->model_proyecto->get_unidad($data['resultado'][0]['uni_id']);//get unidad

        $this->load->view('admin/resultados/update_resultado', $data);
    }
    /*==================================== VALIDAR UPDATE RESULTADO ==================================================*/
    function valida_update_resultado()
    { 
       if($this->input->server('REQUEST_METHOD') === 'POST'){
          $this->form_validation->set_rules('r_id', 'Id del Resultado ', 'required|trim');
          $this->form_validation->set_rules('fun_id', 'Id del responsable ', 'required|trim');
          $this->form_validation->set_rules('uni_id', 'Unidad Responsable', 'required|trim');
          $this->form_validation->set_rules('pedes4', 'Etapa', 'required|trim');

          if($this->input->post('pedes4')==""){
            $id_pdes = $this->model_proyecto->get_id_pdes($this->input->post('pedes3'));  // devuelve id pedes    
          }
          elseif ($this->input->post('pedes4')!="") {
            $id_pdes = $this->model_proyecto->get_id_pdes($this->input->post('pedes4'));  // devuelve id pedes  
          }

          if ($this->form_validation->run()){
              $query=$this->db->query('set datestyle to DMY');
              $update_ind = array( 
                    'r_resultado' => strtoupper($this->input->post('resultado')),
                    'pdes_id' => $id_pdes[0]['pdes_id'],
                    //'ptdi_id' => $id_ptdi[0]['ptdi_id'],
                    'resp_id' => $this->input->post('fun_id'),
                    'r_ponderacion' => $this->input->post('pn_cion'),
                    'uni_id' => $this->input->post('uni_id'),
                    'r_estado' => 2,
                    'fun_id' => $this->session->userdata("fun_id")
                    );

              $this->db->where('r_id', $this->input->post('r_id'));
              $this->db->update('resultado_mediano_plazo', $update_ind);

              $this->session->set_flashdata('success','SE MODIFICO CORRECTAMENTE LA ACCIÓN DE MEDIANO PLAZO');
              redirect('admin/me/resultados');
          }
          else
          {  
            redirect('admin/me/update_res/'.$this->input->post('r_id').'/false');
          }
      }
    }

    /*========================= AGREGAR NUEVO INDICADOR ==================================*/
    public function agregar_indicador($r_id,$nro)
    {
      $enlaces=$this->menu_modelo->get_Modulos(1);
      $data['enlaces'] = $enlaces;
      for($i=0;$i<count($enlaces);$i++) 
      {
        $subenlaces[$enlaces[$i]['o_child']]=$this->menu_modelo->get_Enlaces($enlaces[$i]['o_child'], $this->session->userdata('user_name'));
      }
      $data['subenlaces'] = $subenlaces;
      $meses=$this->get_mes($this->session->userdata("mes"));
      $mes = $meses[1];
      $dias = $meses[2];

      $data['id_mes'] = $this->session->userdata("mes");
      $data['mes'] = $mes;
      $data['indi']= $this->model_proyecto->indicador(); /// indicador

      $data['resultado'] = $this->model_resultado->get_resultado($r_id);// get resultado
      $data['nro'] = $nro;
      $this->load->view('admin/resultados/new_indicador', $data);
    }
    /*========================================= VALIDAR INDICADOR  NUEVO ===========================================================*/
    function valida_add_indicador(){ 
       if($this->input->server('REQUEST_METHOD') === 'POST'){
          $this->form_validation->set_rules('r_id', 'Id resultado ', 'required|trim');
          $this->form_validation->set_rules('nro', 'nro de indicador', 'required|trim');
          $this->form_validation->set_rules('tipo_i', 'Indicador', 'required|trim');

          if ($this->form_validation->run()){
              $query=$this->db->query('set datestyle to DMY');
              $update_res = array( 
                            'nro_ind' => $this->input->post('nro'),
                            'fun_id' => $this->session->userdata("fun_id"),
                            'r_estado' => 2
                            );

              $this->db->where('r_id', $this->input->post('r_id'));
              $this->db->update('resultado_mediano_plazo', $update_res);

              $r[1]='g1';
              $r[2]='g2';
              $r[3]='g3';
              $r[4]='g4';
              $r[5]='g5';

              if($this->input->post('tp_medida')==1){
                $linea_base=$this->input->post('lb');
                $meta=$this->input->post('met');
              }
              else{
                $linea_base=$this->input->post('lb2');
                $meta=$this->input->post('met2');
              }

                $query=$this->db->query('set datestyle to DMY');
                $data_to_store = array( 
                  'r_id' => $this->input->post('r_id'),
                  'indi_id' => $this->input->post('tipo_i'),
                  'in_indicador' => strtoupper($this->input->post('indicador')),
                  'in_formula' => strtoupper($this->input->post('formula')),
                  'in_linea_base' => $linea_base,
                  'in_meta' => $meta,
                  'in_denominador' => $this->input->post('den'),
                  'tp_med' => $this->input->post('tp_medida'),
                  'in_ponderacion' => $this->input->post('pn_cion'),
                  'in_fuente' => strtoupper($this->input->post('verificacion')),
                  'in_supuestos' => strtoupper($this->input->post('supuestos')),
                  'in_total_casos' => strtoupper($this->input->post('c_a')),
                  'in_casos_fav' => strtoupper($this->input->post('c_b')),
                  'valor_ind' => $this->input->post('valor_i'),
                  'fun_id' => $this->session->userdata("fun_id"),
              );
              $this->db->insert('indi_resultados', $data_to_store); ///// inserta a indicador del resultado 
              $id_ir = $this->db->insert_id();

              $conf=$this->model_resultado->configuracion();
              $g1=$conf[0]['conf_gestion_desde'];

              if($this->input->post('tp_medida')==1){
                for($i=1;$i<=5;$i++){
                  if($this->input->post($r[$i])!=0){
                    $data_to_store2 = array( 
                    'in_id' => $id_ir,
                    'g_id' => $g1,
                    'in_prog' => $this->input->post($r[$i]),
                    );
                    $this->db->insert('resultados_prog', $data_to_store2);
                  }
                  $g1++;
                }
              }
              else{
                for($i=1;$i<=5;$i++){
                    $data_to_store2 = array( 
                    'in_id' => $id_ir,
                    'g_id' => $g1,
                    'in_prog' => $meta,
                    );
                    $this->db->insert('resultados_prog', $data_to_store2);
                  $g1++;
                }
              }

              $this->session->set_flashdata('success','SE REGISTRO CORRECTAMENTE EL INDICADOR');
              redirect('admin/me/resultados');
          }
          else{  
            $this->session->set_flashdata('danger','ERROR !!!!');
            redirect('admin/me/new_indicador/'.$this->input->post('r_id').'/'.$this->input->post('nro').'/false');
          }
      }
    }
    /*================================ EDITAR INDICADOR ==================================*/
    public function update_indicador($r_id,$in_id,$nro)
    {
        $enlaces=$this->menu_modelo->get_Modulos(1);
        $data['enlaces'] = $enlaces;
        for($i=0;$i<count($enlaces);$i++) 
        {
          $subenlaces[$enlaces[$i]['o_child']]=$this->menu_modelo->get_Enlaces($enlaces[$i]['o_child'], $this->session->userdata('user_name'));
        }
        $data['subenlaces'] = $subenlaces;
        $meses=$this->get_mes($this->session->userdata("mes"));
        $mes = $meses[1];
        $dias = $meses[2];

        $data['id_mes'] = $this->session->userdata("mes");
        $data['mes'] = $mes;
        $data['indi']= $this->model_proyecto->indicador(); /// indicador

        $data['resultado'] = $this->model_resultado->get_resultado($r_id);// get resultado
        $data['indicador'] = $this->model_resultado->get_indicador($in_id);// get Indicador
        $data['indi']= $this->model_proyecto->indicador(); /// indicador
        $data['nro_indicador'] = $nro;
        $this->load->view('admin/resultados/update_indicador', $data);
    }
    /*========================================= VALIDAR EDITADO INIDCADOR ===========================================================*/
    function valida_update_indicador()
    { 
           if($this->input->server('REQUEST_METHOD') === 'POST') 
            {
              $this->form_validation->set_rules('r_id', 'Id resultado ', 'required|trim');
              $this->form_validation->set_rules('in_id', 'Id indicador', 'required|trim');
              $this->form_validation->set_rules('tipo_i', 'Indicador', 'required|trim');


              if ($this->form_validation->run())
              {
                $r[1]='g1';
                $r[2]='g2';
                $r[3]='g3';
                $r[4]='g4';
                $r[5]='g5';

                if($this->input->post('tp_medida')==1)
                {
                  $linea_base=$this->input->post('lb');
                  $meta=$this->input->post('met');
                }
                else
                {
                  $linea_base=$this->input->post('lb2');
                  $meta=$this->input->post('met2');
                }

                $query=$this->db->query('set datestyle to DMY');
                $update_ind = array( 
                                'indi_id' => $this->input->post('tipo_i'),
                                'in_indicador' => strtoupper($this->input->post('indicador')),
                                'in_formula' => strtoupper($this->input->post('formula')),
                                'in_linea_base' => $linea_base,
                                'in_meta' => $meta,
                                'in_denominador' => $this->input->post('den'),
                                'in_ponderacion' => $this->input->post('pn_cion'),
                                'tp_med' => $this->input->post('tp_medida'),
                                'in_fuente' => strtoupper($this->input->post('verificacion')),
                                'in_supuestos' => strtoupper($this->input->post('supuestos')),
                                'in_total_casos' => strtoupper($this->input->post('c_a')),
                                'in_casos_fav' => strtoupper($this->input->post('c_b')),
                                'valor_ind' => $this->input->post('valor_i'),
                                'fun_id' => $this->session->userdata("fun_id"),
                                'in_estado' => 2
                                );

                  $this->db->where('in_id', $this->input->post('in_id'));
                  $this->db->update('indi_resultados', $update_ind);


                  $this->model_resultado->delete_prog_res($this->input->post('in_id')); //// Eliminando Programado
                  $conf=$this->model_resultado->configuracion();
                  $g1=$conf[0]['conf_gestion_desde'];

                  if($this->input->post('tp_medida')==1)
                  {
                    for($i=1;$i<=5;$i++)
                    {
                      if($this->input->post($r[$i])!=0)
                      {
                        $data_to_store2 = array( 
                        'in_id' => $this->input->post('in_id'),
                        'g_id' => $g1,
                        'in_prog' => $this->input->post($r[$i]),
                        );
                        $this->db->insert('resultados_prog', $data_to_store2);
                      }
                      $g1++;
                    }
                  }
                  else
                  {
                    for($i=1;$i<=5;$i++)
                    {
                        $data_to_store2 = array( 
                        'in_id' => $this->input->post('in_id'),
                        'g_id' => $g1,
                        'in_prog' => $meta,
                        );
                        $this->db->insert('resultados_prog', $data_to_store2);
                      $g1++;
                    }
                  }
           
                 redirect('admin/me/resultados');
              }
              else
              { 
                redirect('admin/me/update_indicador/'.$this->input->post('r_id').'/'.$this->input->post('in_id').'/'.$this->input->post('nro').'/false');
              }
          }
    }

    /*=================================== ELIMINA RESULTADO ==================================================*/
    public function delete_resultado(){
        if($this->input->is_ajax_request() && $this->input->post()){
            $post = $this->input->post();

            $r_id = $post['r_id'];

            $conf=$this->model_resultado->configuracion();
            $nro_obj=$conf[0]['conf_obj_estrategico']-1;

            $update_conf = array('conf_obj_estrategico' => $nro_obj);
            $this->db->where('ide', $this->session->userdata("gestion"));
            $this->db->update('configuracion', $update_conf);

           /*-------------------------------------------------------------*/
            $update_res = array(
                    'r_estado' => '3',
                    'fun_id' => $this->session->userdata("fun_id"),
                    );
            $this->db->where('r_id', $r_id);
            $this->db->update('resultado_mediano_plazo', $update_res);
            /*-------------------------------------------------------------*/

            $sql = $this->db->get();
           
            if($this->db->query($sql)){
                echo $r_id;
            }else{
                echo false;
            }
        }else{
            show_404();
        }
    }
    /*=================================== ELIMINA INDICADOR ==================================================*/
    public function delete_indicador(){
        if($this->input->is_ajax_request() && $this->input->post()){
            $post = $this->input->post();
            $in_id = $post['in_id'];
            $r_id = $post['r_id'];

            $resultado = $this->model_resultado->get_resultado($r_id);// get resultado
            $nro=$resultado[0]['nro_ind']-1;

           /*-------------------------------------------------------------*/
            $update_res = array(
                    'r_estado' => '2',
                    'nro_ind' => $nro,
                    'fun_id' => $this->session->userdata("fun_id"),
                    );
            $this->db->where('r_id', $r_id);
            $this->db->update('resultado_mediano_plazo', $update_res);
            /*-------------------------------------------------------------*/

            /*------------ ELIMINAR  PROGRAMADO INDICADOR --------------*/
            $this->db->where('in_id', $in_id);
            $this->db->delete('resultados_prog');

            /*------------------ ELIMINAR INDICADOR -----------------*/
            $this->db->where('in_id', $in_id);
            $this->db->delete('indi_resultados');
            /*-------------------------------------------------------------*/

            $sql = $this->db->get();
           
            if($this->db->query($sql)){
                echo $in_id;
            }else{
                echo false;
            }
        }else{
            show_404();
        }
    }
    /*=========================================================================================================*/



    /*----------- TEMPORALIZACION PROGRAMADO RESULTADO ----------------*/
    public function temporalizacion($in_id,$gestion_inicio)
    {
      
      $ind=$this->model_resultado->get_indicador($in_id); /// get indicador
      $programado=$this->model_resultado->resultado_programado($in_id); /// programado
      
      $nro=0;
      $tr_return = '';
      foreach($programado as $row)
      {
        $nro++;
        $matriz [1][$nro]=$row['g_id'];
        $matriz [2][$nro]=$row['in_prog'];
      }
      /*---------------- llenando la matriz vacia --------------*/
      $g=$gestion_inicio;
      for($j = 1; $j<=5; $j++)
      {
        $matriz_r[1][$j]=$g;
        $matriz_r[2][$j]='0';  //// P
        $matriz_r[3][$j]='0';  //// PA
        $matriz_r[4][$j]='0';  //// %PA
        $g++;
      }
      /*--------------------------------------------------------*/
      /*------- asignando en la matriz P, PA, %PA ----------*/
      for($i = 1 ;$i<=$nro ;$i++)
      {
        for($j = 1 ;$j<=5 ;$j++)
        {
          if($matriz[1][$i]==$matriz_r[1][$j])
          {
              $matriz_r[2][$j]=round($matriz[2][$i],2);
          }
        }
      }

      $pa=0;
      for($j = 1 ;$j<=5 ;$j++){
        $pa=$pa+$matriz_r[2][$j];
        $matriz_r[3][$j]=$pa+$ind[0]['in_linea_base'];
        if($ind[0]['in_meta']!=0)
        {
          $matriz_r[4][$j]=round(((($pa+$ind[0]['in_linea_base'])/$ind[0]['in_meta'])*100),2);
        }
        
      } 
      /*------------------------------------------------------------*/

          $tr_return .= '<table border="0" cellpadding="0" cellspacing="0" class="tabla">
                          <tr bgcolor="#474544" class="modo1">
                          <th></th>';
                          for($i = 1 ;$i<=5 ;$i++)
                          {
                            $tr_return .= '<th>'.$matriz_r[1][$i].'</th>';
                          }
                          $tr_return .= '
                          </tr>
                          <tr bgcolor="#F5F5F5" class="modo1">
                          <td>PROGRAMADO</td>';
                          for($i = 1 ;$i<=5 ;$i++)
                          {
                            $tr_return .= '<td>'.$matriz_r[2][$i].'</td>';
                          }
                          $tr_return .= '
                          </tr>
                          <tr bgcolor="#F5F5F5" class="modo1">
                          <td>PROGRAMADO ACUMULADO</td>';
                          for($i = 1 ;$i<=5 ;$i++)
                          {
                            $tr_return .= '<td>'.$matriz_r[3][$i].'</td>';
                          }
                          $tr_return .= '
                          </tr>
                          <tr bgcolor="#F5F5F5" class="modo1">
                          <td>% PROGRAMADO ACUMULADO</td>';
                          for($i = 1 ;$i<=5 ;$i++)
                          {
                            $tr_return .= '<td>'.$matriz_r[4][$i].' %</td>';
                          }
                          $tr_return .= '
                          </tr>
                        </table>';
                  
      return $tr_return;
    }

    /*-------------------------------- REPORTE ACCIONES DE MEDIANO PLAZO -----------------------------*/
    public function reporte_resultados(){
        $html = $this->list_acciones_mediano_plazo();// Lista de Acciones de Mediano Plazo

        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->set_paper('letter', 'landscape');
        ini_set('memory_limit','700M');
        ini_set('max_execution_time', 900000);
        $dompdf->render();
        $dompdf->stream("ACCIONES DE MEDIANO PLAZO.pdf", array("Attachment" => false));
    }

    function list_acciones_mediano_plazo(){
        $gestion = $this->session->userdata('gestion');
        $html = '
        <html>
          <head>' . $this->estilo_vertical() . '
           <style>
             @page { margin: 130px 20px; }
             #header { position: fixed; left: 0px; top: -110px; right: 0px; height: 20px; background-color: #fff; text-align: center; }
             #footer { position: fixed; left: 0px; bottom: -125px; right: 0px; height: 110px;}
             #footer .page:after { content: counter(page, upper-roman); }
           </style>
          <body>
           <div id="header">
                <div class="verde"></div>
                <div class="blanco"></div>
                <table width="100%">
                    <tr>
                        <td width=20%; text-align:center;"">
                            <center><img src="'.base_url().'assets/ifinal/cns_logo.JPG" alt="" width="70px"></center>
                        </td>
                        <td width=60%; class="titulo_pdf">
                            <FONT FACE="courier new" size="1">
                            <b>ENTIDAD : </b>'.$this->session->userdata('entidad').'<br>
                            <b>PLAN OPERATIVO ANUAL POA : </b> ' . $gestion . '<br>
                            <b>REPORTE : </b>ACCIONES DE MEDIANO PLAZO<br>
                            </FONT>
                        </td>
                        <td width=20%; text-align:center;"">
                        </td>
                    </tr>
                </table>
           </div>
           <div id="footer">
             <table border="0" cellpadding="0" cellspacing="0" class="tabla">
                <tr class="modo1" bgcolor=#DDDEDE>
                    <td width=33%;>Jefatura de Unidad o Area / Direcci&oacute;n de Establecimiento / Responsable de Area Regionales / Administraci&oacute;n Central</td>
                    <td width=33%;>Jefaturas de Departamento / Servicios Generales Regional / Medica Regional</td>
                    <td width=33%;>Gerencia General / Gerencias de Area /Administraci&oacute;n Regional</td>
                </tr>
                <tr class="modo1">
                    <td><br><br><br><br><br><br><br></td>
                    <td><br><br><br><br><br><br><br></td>
                    <td><br><br><br><br><br><br><br></td>
                </tr>
                <tr>
                    <td colspan=2><p class="izq">'.$this->session->userdata('sistema_pie').'</p></td>
                    <td><p class="page">Pagina </p></td>
                </tr>
            </table>
           </div>
           <div id="content">
             <p><div>'.$this->acciones_mplazo().'</div></p>
           </div>
         </body>
         </html>';
        return $html;
    }

    public function acciones_mplazo(){
      $conf=$this->model_resultado->configuracion(); /// Configuracion
      $resultados=$this->model_resultado->list_resultados($conf[0]['conf_gestion_desde'],$conf[0]['conf_gestion_hasta']);
      $tabla = '';
        $tabla .= '
          <div class="mv" style="text-align:justify">
              <b>MISI&Oacute;N INSTITUCIONAL: </b>'.$conf[0]['conf_mision'].'
          </div><br>
          <div class="mv" style="text-align:justify">
              <b>VISI&Oacute;N INSTITUCIONAL: </b>'.$conf[0]['conf_vision'].'
          </div><br>';

          if(count($resultados)!=0){
            $tabla .='<table border="0" cellpadding="0" cellspacing="0" class="tabla">';
                $tabla.='<thead>';
                $tabla.='<tr class="modo1">';
                  $tabla.='<th style="width:2%;">Nro</th>';
                  $tabla.='<th style="width:18%;">ACCI&Oacute;N DE MEDIANO PLAZO</th>';
                  $tabla.='<th style="width:10%;">VINCULACI&Oacute;N AL PDES</th>';
                  $tabla.='<th style="width:5%;">PONDERACI&Oacute;N</th>';
                  $tabla.='<th style="width:7%;">RESPONSABLE</th>';
                  $tabla.='<th style="width:57%;">INDICADORES DE LA ACCI&Oacute;N DE MEDIANO PLAZO</th>';
                $tabla.='</tr>';
                $tabla.='</thead>';
                $tabla.='<tbody>';
                $nro_r=0;
                foreach($resultados as $row){
                $pdes=$this->model_proyecto->datos_pedes($row['pdes_id']);
                $nro_r++;
                $tabla.='<tr class="modo1">';
                  $tabla.='<td>'.$nro_r.'</td>';
                  $tabla.='<td>'.$row['r_resultado'].'</td>';
                  $tabla.='<td>';
                    $tabla.=' <b>PILAR :</b> '.$pdes[0]['pilar'].'<br>
                              <b>META :</b> '.$pdes[0]['meta'].'<br>
                              <b>RESULTADO :</b> '.$pdes[0]['resultado'].'<br>
                              <b>ACCI&Oacute;N :</b> '.$pdes[0]['accion'].'<br>';
                  $tabla.='</td>';
                  $tabla.='<td>'.$row['r_ponderacion'].'%</td>';
                  $tabla.='<td>'.$row['fun_nombre'].' '.$row['fun_paterno'].' '.$row['fun_materno'].'</td>';
                  $tabla.='<td>'.$this->indicadores_resultados($row['r_id'],$row['gestion_desde']).'</td>';
                $tabla.='</tr>';
                }
                $tabla.='</tbody>';
            $tabla.='</table>';
          }
      return $tabla;
    }
   
    /*--------------------------- INDICADORES --------------------------------------*/
    public function indicadores_resultados($r_id,$gestion_desde)
    {
      $indicadores = $this->model_resultado->list_indicadores($r_id);// lista de indicadores
      $ind ='';
      if(count($indicadores)!=0)
      {
        $ind .= '
        <table>
          <tr class="modo1" align=center bgcolor="#e4e1e1">
              <td>Nro.</td>
              <td>INDICADOR</td>
              <td>TIPO INDICADOR</td>
              <td>LINEA BASE</td>
              <td>META</td>
              <td>TEMPORALIZACI&Oacute;N</td>
          </tr>';

          $nro_i=1;
          foreach ($indicadores as $rowi) 
          {
            $ind .= '
              <tr class="modo1">
                <td>'.$nro_i.'</td>
                <td>'.$rowi['in_indicador'].'</td>
                <td>'.$rowi['indi_descripcion'].'</td>
                <td>'.$rowi['in_linea_base'].'</td>
                <td>'.$rowi['in_meta'].'</td>
                <td>'.$this->temporalizacion($rowi['in_id'],$gestion_desde).'</td>
              </tr>
            ';
            $nro_i++;
          }
          $ind .='
        </table>';
      }
      else
      {
        $ind .=
        'SIN INDICADORES REGISTRADOS';
      }
      
      
      return $ind;
    }

    function estilo_vertical()
    {
        $estilo_vertical = '<style>
        body{
            font-family: sans-serif;
            }
        table{
            font-size: 8px;
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
        font-size: 8px;
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

    public function get_mes($mes_id)
    {
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
}