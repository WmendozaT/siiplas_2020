<?php
class Model_funcionario extends CI_Model {
  
    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }

    public function password_decod($pass)
    {
        $this->load->library('encrypt');
        $password = $this->encrypt->decode($pass);
        return $password;
    }

    public function verificar_password($fun_id)
    {
        $query = "SELECT *
        FROM funcionario WHERE fun_id = $fun_id";
        $query = $this->db->query($query);
        $query = $query->row();
        $pass = $query->fun_password;
        return $pass;
    }
    public function verificar_loggin($user_name, $password)
    {
        //$password='n3E6H~rQyJU3mMguO3pf7p2FqvYgUOUErcuv3Ive5uCkVLV8owJbMpvzvLwrPm7hJxFDGzOvu44JehptfUS9hg--';
        $query = "SELECT *
        FROM funcionario
        WHERE fun_usuario = '".$user_name."' and fun_estado = 1";
        $query = $this->db->query($query);
        $query = $query->result_array();
        $data = array(
            'bool' => false,
            'fun_id' => null  
        );
        foreach ($query as $fila) {
            $var = $fila['fun_password'];//$this->password_decod($fila['fun_password']);
            if($var == $password){
                $data['bool'] = true;
                $data['fun_id'] = $fila['fun_id'];
            }
        }
		return $data;
    }

    public function get_funcionarios()
    {
        $this->db->select(" f.fun_id,
                            f.fun_nombre,
                           f.fun_paterno,
                            f.fun_materno,
                            f.fun_ci,
                            f.fun_domicilio,
                            f.fun_telefono,
                            f.fun_usuario,
                            f.fun_password,
                            c.car_cargo,
                            uo.uni_unidad");
        $this->db->from('funcionario f');
        $this->db->join('unidadorganizacional uo', 'uo.uni_id=f.uni_id', 'left');
        $this->db->join('cargo c', 'c.car_id=f.car_id');
        $this->db->where('(f.fun_estado=1 OR fun_estado=2)');
        $this->db->ORDER_BY('f.fun_id');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    public function get_rol($fun_id)
    {
        $this->db->select("r.r_nombre, r.r_id");
        $this->db->from('rol r');
        $this->db->join('fun_rol fr', 'fr.r_id=r.r_id');
        $this->db->where('fr.fun_id',$fun_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_add_rol()
    {
        $this->db->select('r_nombre, r_id');
        $this->db->from('rol');
        $query = $this->db->get();
        return $query->result_array();
    }
	public function get_uni_o()
    {
        $this->db->select('uni_unidad,uni_id'); 
        $this->db->from('unidadorganizacional');
        $this->db->ORDER_BY('uni_id'); 
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_cargo()
    {
        $this->db->select('car_id,car_cargo');
        $this->db->from('cargo');
        $this->db->ORDER_BY('car_id'); 
        $query = $this->db->get();
        return $query->result_array();
    }

public function add_fun($fun_nombre,$fun_paterno, $fun_materno,$fun_ci,$fun_telefono,$fun_cargo,$fun_domicilio,$fun_usuario,$fun_password,$uni_id,$car_id,$roles)
{
    ///////adicionar funcionario////////
    $data=array(
        'fun_nombre'=>$fun_nombre,
        'fun_paterno'=>$fun_paterno,
        'fun_materno'=>$fun_materno,
        'fun_ci'=>$fun_ci,
        'fun_telefono'=>$fun_telefono,
        'fun_cargo'=>$fun_cargo,
        'fun_domicilio'=>$fun_domicilio,
        'fun_usuario'=>$fun_usuario,
        'fun_password'=>$fun_password,
        'uni_id'=>$uni_id,
        'car_id'=>$car_id
        );

    $this->db->INSERT('funcionario',$data);
///////roles funcionario///////
   $id= $this->db->insert_id();

        foreach($_POST['rol'] as $roles){
            $datos=array(
                'fun_id'=>$id,
                'r_id'=>$roles
                );
            $this->db->INSERT('fun_rol',$datos);
        };
/////////botones funcionario////
        $btn=1;
        $datos=array('fun_id'=>$id,
                'b_id'=>$btn);
        $this->db->INSERT('fun_btn',$datos);
////////////redireccionar///////
        redirect('admin/mnt/list_usu');
}
public function del_fun($fun_id)
{
    $estado=3;
    $data=array('fun_estado'=>$estado);
    $this->db->where('fun_id',$fun_id);
    $query = $this->db->update('funcionario',$data);
    redirect('admin/mnt/list_usu');
}

function mod_password($fun_id,$password)
{
    $data = array(
        'fun_password' => $password
    );
    $this->db->where('fun_id', $fun_id);
    $this->db->update('funcionario', $data);
    // $query = $this->db->query("UPDATE funcionario SET  fun_password = $password WHERE fun_id = $fun_id");
    // $this->session->sess_destroy();
    // redirect('admin/dashboard');
}

function mod_funcio($fun_id)
{
    $this->db->select('     f.fun_id,
                            f.fun_nombre,
                            f.fun_paterno,
                            f.fun_materno,
                            f.fun_cargo,
                            f.fun_ci,
                            f.fun_domicilio,
                            f.fun_telefono,
                            f.fun_usuario,
                            c.car_cargo,
                            u.uni_unidad');
    $this->db->from('funcionario f');
    $this->db->join('cargo c','c.car_id=f.car_id');
    $this->db->join('unidadorganizacional u','u.uni_id=f.uni_id');
    $this->db->where('f.fun_id',$fun_id);
    $query = $this->db->get();    
    return $query->result_array();

}
function get_funcionario ($fun_id){
        $this->db->SELECT('*');
        $this->db->FROM('funcionario');
        $this->db->where('fun_id', $fun_id);
        $query = $this->db->get();
        return $query->result_array();
    }
function  verificar_fun($fun_usuario)
{
    $query = "SELECT count(*) n
from funcionario
where fun_usuario = '$fun_usuario'";
    $query = $this->db->query($query);
   $query = $query->row();
    $n = $query->n;
    return $n;
}
function mod_funcionario($fun_nombre,$fun_paterno,$fun_materno,$fun_cargo,$fun_ci,$fun_telefono,$fun_domicilio,$fun_usuario,$uni_id,$car_id,$fun_id,$roles,$fun_password)
{
    $this->elimina_roles($fun_id);
    $count = count($roles);
    for ($i=0; $i < $count; $i++) {
        $nuevo_rol = array(
            'fun_id' => $fun_id,
            'r_id' => $roles[$i]
            );
        $this->db->INSERT('fun_rol',$nuevo_rol);
    }
    $datos=array(
            'uni_id'=>intval($uni_id),
            'car_id'=>intval($car_id),
            'fun_nombre'=>$fun_nombre,
            'fun_ci'=>$fun_ci,
            'fun_domicilio'=>$fun_domicilio,
            'fun_telefono'=>$fun_telefono,
            'fun_usuario'=>$fun_usuario,
            'fun_password'=>$fun_password,
            'fun_paterno'=>$fun_paterno,
            'fun_materno'=>$fun_materno,
            'fun_cargo'=>$fun_cargo,
            );
    $this->db->where('fun_id',intval($fun_id));
    $this->db->update('funcionario',$datos);
    redirect('admin/mnt/list_usu');
}
    public function elimina_roles($fun_id)
    {
        $this->db->where('fun_id', $fun_id);
        $this->db->delete('fun_rol');
    }


}
?>  
