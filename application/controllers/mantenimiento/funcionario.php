<?php
define("DOMPDF_ENABLE_REMOTE", true);
define("DOMPDF_TEMP_DIR", "/tmp");
class Funcionario extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if($this->session->userdata('fun_id')!=null){
            $this->load->library('encrypt');
            $this->load->model('Users_model','',true);
            $this->load->model('menu_modelo');
            $this->load->model('mantenimiento/model_funcionario');
            $this->load->model('programacion/model_proyecto');
            $this->gestion = $this->session->userData('gestion');
            $this->adm = $this->session->userData('adm');
            $this->dist = $this->session->userData('dist');
            $this->dist_tp = $this->session->userData('dist_tp');
            $this->fun_id = $this->session->userData('fun_id');
        }else{
            redirect('/','refresh');
        }
    }
    
    public function roles_html($id){
        $html_roles_fun = '';
        $lista_rol = $this->model_funcionario->get_rol($id);
        foreach ($lista_rol as $fila) {
            $html_roles_fun .= '
                <li>'.$fila['r_nombre'].'</li>
            ';
        }
        return $html_roles_fun;
    }

    /*----------- Tipo de Responsable -------------*/
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

    /*----- Lista de Responsables ------*/
    public function list_usuarios(){
        if($this->adm==1){
            $data['menu']=$this->menu(9);
            $data['resp']=$this->session->userdata('funcionario');
            $data['res_dep']=$this->tp_resp();
            $data['usuarios']=$this->list_funcionarios();

            $this->load->view('admin/mantenimiento/funcionario/vlist_fun', $data);
        }
        else{
            redirect('admin/dashboard');
        }
    }

    public function new_funcionario(){
        $data['menu']=$this->menu(9);

        $data['list_dep']=$this->model_proyecto->list_departamentos(); /// lista de Departamentos
        $data['uni_org']=$this->model_funcionario->get_uni_o();
        $data['listas_rol'] =$this->model_funcionario->get_add_rol();
        $this->load->view('admin/mantenimiento/funcionario/vnew_fun', $data);
    }

    /*------------- FORMULARIO DE MODIFICACIONES --------------*/
    public function update_funcionario($fun_id){
        $data['menu']=$this->menu(9);
        $data['fun']=$this->model_funcionario->get_funcionario($fun_id); /// Get Usuario
        if(count($data['fun'])!=0){
            $data['list_dep']=$this->model_proyecto->list_departamentos(); /// lista de Departamentos
            $data['uni_org']=$this->model_funcionario->get_uni_o();
            $data['listas_rol'] =$this->model_funcionario->get_add_rol();
            $data['list_dist']=$this->model_proyecto->list_distritales($data['fun'][0]['dep_id']);
            $data['roles']=count($this->model_funcionario->roles_funcionario($fun_id));

            $data['edit_pass'] = $this->encrypt->decode($data['fun'][0]['fun_password']);
            $this->load->view('admin/mantenimiento/funcionario/update_fun', $data);
        }
        else{
            redirect('admin/dashboard');
        }
    }

    /*----------- LISTA DE RESPONSABLES -------------------*/
    public function list_funcionarios(){
        $funcionarios=$this->model_funcionario->get_funcionarios();
        $tabla ='';

        $nro=0;
        foreach($funcionarios  as $row){
            $nro++;
            $rol=$this->model_funcionario->verif_rol($row['id'],1);
            $tabla .='<tr>';
                $tabla .='<td title="'.$row['id'].'">'.$nro.'</td>';
                $tabla .='<td>';
                    $tabla .= '<center><a href="'.site_url("admin").'/funcionario/update_fun/'.$row['id'].'" title="MODIFICAR DATOS DEL RESPONSABLE"><img src="' . base_url() . 'assets/ifinal/modificar.png" WIDTH="30" HEIGHT="30"/></a></center>';
                    if(count($rol)==0){
                        $tabla .= '<center><a href="'.site_url("admin").'/funcionario/delete_fun/'.$row['id'].'" title="ELIMINAR DATOS DEL RESPONSABLE" onclick="return confirmar()"><img src="' . base_url() . 'assets/ifinal/eliminar.png" WIDTH="30" HEIGHT="30"/></a></center>';
                    }
                $tabla .='</td>';
                $tabla .='<td>'.$row['fun_nombre'].' '.$row['fun_paterno'].' '.$row['fun_materno'].'</td>';
                $tabla .='<td>'.$row['uni_unidad'].'</td>';
                $tabla .='<td>'.$row['fun_usuario'].'</td>';
                $tabla .='<td>'.$row['adm'].'</td>';
                $tabla .='<td>'.strtoupper($row['dist_distrital']).'</td>';
                $tabla .='<td>
                        <ul style="text-align:left; padding-left: 1;list-style-type:square; margin:2px;">
                            '.$this->roles_html($row['id']).'
                        </ul></td>';
            $tabla .='</tr>';
        }

        return $tabla;
    }


    /*--- REPORTE FUNCIONARIOS ---*/
    public function reporte_list_usuarios(){
        $funcionarios=$this->model_funcionario->get_funcionarios();
        $tabla='';
        $tabla.='
            <table cellpadding="0" cellspacing="0" class="tabla" border=1 style="width:100%;" align=center>
                <thead>
                 <tr style="font-size: 7px;" bgcolor=#1c7368 align=center>
                    <th style="width:1%;height:15px;" color:#FFF;>#</th>
                    <th style="width:25%;" color:#FFF;>NOMBRE COMPLETO</th> 
                    <th style="width:10%;" color:#FFF;>USUARIO</th> 
                    <th style="width:10%;" color:#FFF;>UNIDAD DEPENDIENTE</th>
                    <th style="width:10%;" color:#FFF;>DISTRITAL</th>   
                </tr>
                </thead>
                <tbody>';
                $nro=0;
                foreach($funcionarios  as $row){
                    if($row['fun_id']!=399){
                        $nro++;
                        $tabla.='
                            <tr>
                                <td>'.$nro.'</td>
                                <td>'.$row['fun_nombre'].' '.$row['fun_paterno'].' '.$row['fun_materno'].'</td>
                                <td>'.$row['fun_usuario'].'</td>
                                <td>'.$row['uni_unidad'].'</td>
                                <td>';
                                if($row['fun_adm']==1){
                                    $tabla.='ADMINISTRADOR NACIONAL';
                                }
                                else{
                                    $tabla.=strtoupper($row['dist_distrital']);   
                                }
                                $tabla.='
                                </td>
                            </tr>';
                    }
                }
            $tabla.='
                </tbody>
            </table>';

        echo $tabla;
        //$this->load->view('admin/mantenimiento/funcionario/vlist_fun', $data);
    }


    /*-------------------------- VALIDA USUARIO ---------------------*/
    public function add_funcionario(){
        if ($this->input->server('REQUEST_METHOD') === 'POST'){
            $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
            $this->form_validation->set_rules('ap', 'Apellido Paterno', 'required|trim');
            $this->form_validation->set_rules('usuario', 'Usuario', 'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required|trim');

            if ($this->form_validation->run()){
                if($this->input->post('adm')==1){
                    $dist=0;
                }
                elseif($this->input->post('adm')==2){
                    $dist=$this->input->post('dist_id');
                }

                $data_to_store = array( 
                    'uni_id' => $this->input->post('uni_id'),
                    'car_id' => 0,
                    'fun_nombre' => strtoupper($this->input->post('nombre')),
                    'fun_paterno' => strtoupper($this->input->post('ap')),
                    'fun_materno' => strtoupper($this->input->post('am')),
                    'fun_cargo' => strtoupper($this->input->post('crgo')),
                    'fun_ci' => $this->input->post('ci'),
                    'fun_domicilio' => strtoupper($this->input->post('domicilio')),
                    'fun_telefono' => $this->input->post('fono'),
                    'fun_usuario' => $this->input->post('usuario'),
                    'fun_password' => $this->encrypt->encode($this->input->post('password')),
                    'fun_adm' => $this->input->post('adm'),
                    'fun_dist' => $dist,
                );
                $this->db->insert('funcionario', $this->security->xss_clean($data_to_store));
                $fun_id=$this->db->insert_id();

              
                  foreach ( array_keys($_POST["id"]) as $como){
                    if($_POST["rol"][$como]!=0){

                        if($_POST["id"][$como]==10){
                            $update_conf = array(   
                                'tp_adm' => 3
                            );
                            $this->db->where('fun_id', $fun_id);
                            $this->db->update('funcionario', $update_conf);
                        }

                        $data_to_store2 = array( 
                            'fun_id' => $fun_id,
                            'r_id' => $_POST["id"][$como],
                        );
                        $this->db->insert('fun_rol', $data_to_store2);
                    }
                  }

                $this->session->set_flashdata('success','LOS DATOS DEL RESPONSABLE SE REGISTRARON CORRECTAMENTE');
                redirect('admin/mnt/list_usu');

            }
            else{
            $this->session->set_flashdata('danger','ERROR AL REGISTRAR DATOS, VERIFIQUE INFORMACION');
            redirect('admin/funcionario/new_fun');
            }
        }
        else{
            $this->session->set_flashdata('danger','ERROR EN EL SERVIDOR, Contactese con el Administrador');
            redirect('admin/funcionario/new_fun');
        }
    }

    /*--------------------- VALIDA UPDATE USUARIO -------------------------*/
    public function add_update_funcionario(){
        if ($this->input->server('REQUEST_METHOD') === 'POST'){
            $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
            $this->form_validation->set_rules('ap', 'Apellido Paterno', 'required|trim');
            $this->form_validation->set_rules('usuario', 'Usuario', 'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required|trim');

            if ($this->form_validation->run()) {
                if($this->input->post('adm')==1){
                    $dist=0;
                }
                elseif($this->input->post('adm')==2){
                    $dist=$this->input->post('dist_id');
                }
                $update_fun = array(
                    'uni_id' => $this->input->post('uni_id'),
                    'car_id' => 0,
                    'fun_nombre' => strtoupper($this->input->post('nombre')),
                    'fun_paterno' => strtoupper($this->input->post('ap')),
                    'fun_materno' => strtoupper($this->input->post('am')),
                    'fun_cargo' => strtoupper($this->input->post('crgo')),
                    'fun_ci' => $this->input->post('ci'),
                    'fun_domicilio' => strtoupper($this->input->post('domicilio')),
                    'fun_telefono' => $this->input->post('fono'),
                    'fun_usuario' => $this->input->post('usuario'),
                    'fun_password' => $this->encrypt->encode($this->input->post('password')),
                    'fun_adm' => $this->input->post('adm'),
                    'fun_dist' => $dist,

                );
                $this->db->where('fun_id', $this->input->post('fun_id'));
                $this->db->update('funcionario', $this->security->xss_clean($update_fun));

                $this->model_funcionario->elimina_roles($this->input->post('fun_id'));
                
                foreach ( array_keys($_POST["id"]) as $como){
                    if($_POST["rol"][$como]!=0){

                        if($_POST["id"][$como]==10){
                            $update_conf = array(   
                                'tp_adm' => 3
                            );
                            $this->db->where('fun_id', $this->input->post('fun_id'));
                            $this->db->update('funcionario', $update_conf);
                        }

                        $data_to_store2 = array( 
                            'fun_id' => $this->input->post('fun_id'),
                            'r_id' => $_POST["id"][$como],
                        );
                        $this->db->insert('fun_rol', $data_to_store2);
                    }
                }


                /*for ($i=1; $i <=count($rol) ; $i++) { 
                  //  echo $this->input->post('rol'.$i.'').'<br>';
                   if($this->input->post('rol'.$i.'')!=''){
                    //echo $this->input->post('rol'.$i.'').'<br>';
                    $data_to_store2 = array( 
                    'fun_id' => $this->input->post('fun_id'),
                    'r_id' => $this->input->post('rol'.$i.''),
                    );
                    $this->db->insert('fun_rol', $this->security->xss_clean($data_to_store2));
                }
               }*/

                $this->session->set_flashdata('success','EL RESPONSABLE SE MODIFICO CORRECTAMENTE');
                redirect('admin/mnt/list_usu');
            }
            else{
            $this->session->set_flashdata('danger','ERROR AL REGISTRAR DATOS, VERIFIQUE INFORMACION');
            redirect('admin/funcionario/new_fun');
            }
        }
        else{
            $this->session->set_flashdata('danger','ERROR EN EL SERVIDOR, Contactese con el Administrador');
            redirect('admin/funcionario/new_fun');
        }
    }

/*    public function add_update_funcionario(){
        if ($this->input->server('REQUEST_METHOD') === 'POST'){
            $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
            $this->form_validation->set_rules('ap', 'Apellido Paterno', 'required|trim');
            $this->form_validation->set_rules('usuario', 'Usuario', 'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required|trim');

            if ($this->form_validation->run()){
                if($this->input->post('adm')==1){
                    $dist=0;
                }
                elseif($this->input->post('adm')==2){
                    $dist=$this->input->post('dist_id');
                }

                $update_fun = array(
                    'uni_id' => $this->input->post('uni_id'),
                    'car_id' => 0,
                    'fun_nombre' => strtoupper($this->input->post('nombre')),
                    'fun_paterno' => strtoupper($this->input->post('ap')),
                    'fun_materno' => strtoupper($this->input->post('am')),
                    'fun_cargo' => strtoupper($this->input->post('crgo')),
                    'fun_ci' => $this->input->post('ci'),
                    'fun_domicilio' => strtoupper($this->input->post('domicilio')),
                    'fun_telefono' => $this->input->post('fono'),
                    'fun_usuario' => $this->input->post('usuario'),
                    'fun_password' => $this->encrypt->encode($this->input->post('password')),
                    'fun_adm' => $this->input->post('adm'),
                    'fun_dist' => $dist,
                    );
                    $this->db->where('fun_id', $this->input->post('fun_id'));
                    $this->db->update('funcionario', $this->security->xss_clean($update_fun));

                $this->model_funcionario->elimina_roles($this->input->post('fun_id'));
                   
                for ($i=1; $i <=6 ; $i++) { 
                   if($this->input->post('rol'.$i.'')!=''){
                    $data_to_store2 = array( 
                    'fun_id' => $this->input->post('fun_id'),
                    'r_id' => $this->input->post('rol'.$i.''),
                    );
                    $this->db->insert('fun_rol', $this->security->xss_clean($data_to_store2));
                    }
                }

                $data_to_store = array( 
                    'fun_id' => $this->input->post('fun_id'),
                    'r_id' => 10,
                    'r_estado' => 3,
                );
                $this->db->insert('fun_rol', $data_to_store);

                $this->session->set_flashdata('success','EL RESPONSABLE SE MODIFICO CORRECTAMENTE');
                redirect('admin/mnt/list_usu');
            }
            else{
            $this->session->set_flashdata('danger','ERROR AL REGISTRAR DATOS, VERIFIQUE INFORMACION');
            redirect('admin/funcionario/new_fun');
            }
        }
        else{
            $this->session->set_flashdata('danger','ERROR EN EL SERVIDOR, Contactese con el Administrador');
            redirect('admin/funcionario/new_fun');
        }
    }*/
   
    public function verif_usuario(){
        if($this->input->is_ajax_request()){
            $post = $this->input->post();
            $user = $post['user'];
            $usuario=$this->model_funcionario->verificar_fun($user);
             if($usuario == 0){
             echo "true"; ///// no existe un CI registrado
             }
             else{
              echo "false"; //// existe el CI ya registrado
             } 
        }else{
            show_404();
        }
    }

    function verif_ci(){
        if($this->input->is_ajax_request()){
            $post = $this->input->post();
            $ci = $post['ci'];

            $variable= $this->model_funcionario->fun_ci($ci);
             if(count($variable)!=0){
             echo "false"; ///// Ya existe CI
             }
             else{
              echo "true"; //// No existe CI
             } 
        }else{
          show_404();
      }
    }

    function verif_user(){
        if($this->input->is_ajax_request()){
            $post = $this->input->post();
            $user = $post['user'];

            $variable= $this->model_funcionario->fun_usuario($user);
             if(count($variable)!=0){
             echo "false"; ///// Ya existe CI
             }
             else{
              echo "true"; //// No existe CI
             } 
        }else{
          show_404();
      }
    }

    public function add_funcionario2(){
    	   $fun_nombre		=strtoupper ($this->input->post('fun_nombre'));
    	   $fun_paterno		=strtoupper ( $this->input->post('fun_paterno'));
    	   $fun_materno		=strtoupper ( $this->input->post('fun_materno'));
    	   $fun_ci			=strtoupper ( $this->input->post('fun_ci'));
    	   $fun_telefono	=strtoupper ( $this->input->post('fun_telefono'));
    	   $fun_cargo		=strtoupper ( $this->input->post('fun_cargo'));
    	   $fun_domicilio	=strtoupper ( $this->input->post('fun_domicilio'));
    	   $fun_usuario		= strtoupper ($this->input->post('fun_usuario'));
    	   $fun_password	= $this->encrypt->encode($this->input->post('fun_password'));
    	   $uni_id			= strtoupper ($this->input->post('uni_id'));
    	   $car_id			= strtoupper ($this->input->post('car_id'));
    	   $roles		    =strtoupper($this->input->post('rol[]'));
    /*	foreach($_POST['rol'] as $roles){
    		echo $roles."<br>";
		};*/


        $usuario=$this->model_funcionario->verificar_fun($fun_usuario);
       
        if($usuario==0){
            $this->model_funcionario->add_fun($fun_nombre,$fun_paterno, $fun_materno,$fun_ci,$fun_telefono,$fun_cargo,
                                            $fun_domicilio,$fun_usuario,$fun_password,$uni_id,$car_id,$roles);

        }else{ 
            echo "<script>alert('usuario ya existente');
                </script>";
            redirect('admin/mnt/list_usu', 'refresh');
        }
    }


    public function del_fun($fun_id)
    {
        $fun=$this->model_funcionario->del_fun($fun_id);
        $this->session->set_flashdata('success','EL REGISTRO SE ELIMINO CORRECTAMENTE');
        redirect('admin/mnt/list_usu');
    }
    
    function nueva_contra(){
        $this->load->view('admin/mod_contrase');
    }

    function mod_cont()
    {
        $fun_id = $this->input->post('fun_id');
        $apassword = $this->input->post('apassword');
        $password = $this->input->post('password');
        $password = $this->encrypt->encode($password);
        $verifica = (($this->encrypt->decode($this->model_funcionario->verificar_password($fun_id))) == $apassword) ? true : false ;
        if($verifica){
            $this->model_funcionario->mod_password($fun_id,$password);
            echo "
                <script>
                    alert('Se Cambio la Contraseña Correctamente');
                </script>
            ";
            $this->vista();
        }
        else{
            echo "
                <script>
                    alert('La Contraseña Anterior No Coincide');
                </script>
            ";
            $this->nueva_contra();
        }
    }

/*    function mod_funs()
    {
        $fun_id=$this->input->post('fun_id');
        $dato_fun=$this->model_funcionario->get_funcionario($fun_id);
        $roles_actuales = $this->model_funcionario->get_rol($fun_id);
        $rol = array();
        foreach ($roles_actuales as $fila) {
            array_push($rol,$fila['r_id']);
        }
        $edit_pass = $this->encrypt->decode($dato_fun[0]['fun_password']);
        $result = array(
            'fun_id' => $dato_fun[0]['fun_id'],
            'uni_id' => $dato_fun[0]['uni_id'],
            'car_id' => $dato_fun[0]['car_id'],
            "fun_nombre" =>$dato_fun[0]['fun_nombre'],
            "fun_paterno" =>$dato_fun[0]['fun_paterno'],
            "fun_materno" =>$dato_fun[0]['fun_materno'],
            "fun_telefono"=>$dato_fun[0]['fun_telefono'],
            "fun_cargo"=>$dato_fun[0]['fun_cargo'],
            "fun_domicilio"=>$dato_fun[0]['fun_domicilio'],
            "fun_dni"=>$dato_fun[0]['fun_ci'],
            "fun_usuario"=>$dato_fun[0]['fun_usuario'],
            "fun_password"=>$edit_pass,
            "fun_roles" => $rol
            );
        echo json_encode($result);
    }
        function mod_funcionario()
        {
             $fun_nombre=$this->input->post('modfun_nombre');
             $fun_paterno=$this->input->post('modfun_paterno');
             $fun_materno=$this->input->post('modfun_materno');
             $fun_cargo=$this->input->post('modfun_cargo');
             $fun_ci=$this->input->post('modfun_dni');
             $fun_telefono=$this->input->post('modfun_telefono');
             $fun_domicilio=$this->input->post('modfun_domicilio');
             $fun_usuario=$this->input->post('modfun_usuario');
             $fun_password = $this->encrypt->encode($this->input->post('modfun_password'));
             $uni_id=$this->input->post('moduni_id');
             $car_id=$this->input->post('modcar_id');
             $fun_id=$this->input->post('modfun_id');
             $roles = $this->input->post('modrol');
            $this->model_funcionario->mod_funcionario($fun_nombre,$fun_paterno,$fun_materno,$fun_cargo,$fun_ci,$fun_telefono,$fun_domicilio,$fun_usuario,$uni_id,$car_id,$fun_id,$roles,$fun_password);
        }*/

        /*------------------------------------- MENU -----------------------------------*/
        function menu($mod){
            $enlaces=$this->menu_modelo->get_Modulos($mod);
            for($i=0;$i<count($enlaces);$i++)
            {
              $subenlaces[$enlaces[$i]['o_child']]=$this->menu_modelo->get_Enlaces($enlaces[$i]['o_child'], $this->session->userdata('user_name'));
            }

            $tabla ='';
            for($i=0;$i<count($enlaces);$i++)
            {
                if(count($subenlaces[$enlaces[$i]['o_child']])>0)
                {
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