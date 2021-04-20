<?php
class Model_seguimientopoa extends CI_Model{
    public function __construct(){
        $this->load->database();
        $this->gestion = $this->session->userData('gestion');
        $this->fun_id = $this->session->userData('fun_id');
        $this->rol = $this->session->userData('rol_id'); /// rol->1 administrador, rol->3 TUE, rol->4 POA
        $this->adm = $this->session->userData('adm'); /// adm->1 Nacional, adm->2 Regional
        $this->dist = $this->session->userData('dist'); /// dist-> id de la distrital
        $this->dist_tp = $this->session->userData('dist_tp'); /// dist_tp->1 Regional, dist_tp->0 Distritales
        $this->tmes = $this->session->userData('trimestre');
    }
    
    /*-- LISTA DE OPERACIONES (PRODUCTOS) LISTADO POR MES PROGRAMADO --*/
    public function operaciones_programados_x_mes($com_id,$mes_id){
        $sql = 'select *
                from v_seguimiento_operaciones_mensual
                where com_id='.$com_id.' and m_id='.$mes_id.' and g_id='.$this->gestion.'';

        $query = $this->db->query($sql);
        return $query->result_array();
    }


    /*-- GET PROGRAMADO POA MENSUAL --*/
    public function get_programado_poa_mes($prod_id,$mes_id){
        $sql = 'select *
                from prod_programado_mensual
                where prod_id='.$prod_id.' and m_id='.$mes_id.' and g_id='.$this->gestion.'';

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*-- GET SEGUIMIENTO (EJECUTADO) POA MENSUAL (Cumplidas, En proceso) --*/
    public function get_seguimiento_poa_mes($prod_id,$mes_id){
        $sql = 'select *
                from prod_ejecutado_mensual
                where prod_id='.$prod_id.' and m_id='.$mes_id.' and g_id='.$this->gestion.'';

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*-- GET SEGUIMIENTO POA MENSUAL (No cumplido) --*/
    public function get_seguimiento_poa_mes_noejec($prod_id,$mes_id){
        $sql = 'select *
                from prod_no_ejecutado_mensual
                where prod_id='.$prod_id.' and m_id='.$mes_id.' and g_id='.$this->gestion.'
                order by ne_id desc  LIMIT 1';

        $query = $this->db->query($sql);
        return $query->result_array();
    }



    /*-- GET SEGUIMIENTO POA MENSUAL POR SUBACTIVIDAD --*/
    public function get_seguimiento_poa_mes_subactividad($com_id,$mes_id){
        $sql = 'select *
                from _productos p
                Inner Join prod_ejecutado_mensual as pe On pe.prod_id=p.prod_id
                where p.com_id='.$com_id.' and pe.m_id='.$mes_id.' and pe.g_id='.$this->gestion.'';

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*-- GET LISTA DE OPERACIONES MENSUAL POR DISTRITAL --*/
    public function get_seguimiento_poa_mes_distrital($dist_id,$mes_id,$gestion){
        $sql = 'select *
                from lista_seguimiento_operaciones_mensual_ue('.$dist_id.','.$mes_id.','.$gestion.')';

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*-- GET LISTA DE UNIDADES QUE TIENEN PROGRAMADO OPERACIONES EN EL MES --*/
    public function get_lista_unidad_operaciones($dist_id,$mes_id,$gestion){
        $sql = '
                select aper_programa,aper_proyecto,aper_actividad,proy_id,tipo,act_descripcion, abrev, count(m_id) operaciones
                from lista_seguimiento_operaciones_mensual_ue('.$dist_id.','.$mes_id.','.$gestion.')
                where tp_id=\'4\'
                group by aper_programa, aper_proyecto,aper_actividad,proy_id,tipo,act_descripcion, abrev
                order by aper_programa, aper_proyecto,aper_actividad asc';

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*-- GET LISTA DE OPERACIONES PROGRAMADO EN EL MES --*/
    public function get_lista_operaciones_programados($dist_id,$mes_id,$gestion,$proy_id){
        $sql = '
                select *
                from lista_seguimiento_operaciones_mensual_ue('.$dist_id.','.$mes_id.','.$gestion.')
                where proy_id='.$proy_id.'
                order by serv_cod, prod_cod asc';

        $query = $this->db->query($sql);
        return $query->result_array();
    }


    /*-- GET LISTA DE SUBACTIVIDADES QUE TIENEN PROGRAMADO OPERACIONES EN EL MES --*/
    public function get_lista_subactividades_operaciones_programados($dist_id,$mes_id,$gestion,$proy_id){
        $sql = '
                select proy_id,dist_id,com_id,tipo_subactividad,serv_cod,serv_descripcion,m_id,aper_gestion
                from lista_seguimiento_operaciones_mensual_ue('.$dist_id.','.$mes_id.','.$gestion.')
                where proy_id='.$proy_id.'
                group by proy_id,dist_id,com_id,tipo_subactividad,serv_cod,serv_descripcion,m_id,aper_gestion
                order by serv_cod asc';

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*-- GET LISTA DE OPERACIONES PROGRAMADO EN EL MES POR CADA SUBACTIVIDAD--*/
/*    public function get_lista_operaciones_programados_x_subactividad($dist_id,$mes_id,$gestion,$proy_id,$com_id){
        $sql = '
                select proy_id,dist_id,com_id,tipo_subactividad,serv_cod,serv_descripcion
                from lista_seguimiento_operaciones_mensual_ue('.$dist_id.','.$mes_id.','.$gestion.')
                where proy_id='.$proy_id.' and com_id='.$com_id.'
                group by proy_id,dist_id,com_id,tipo_subactividad,serv_cod,serv_descripcion
                order by serv_cod asc';

        $query = $this->db->query($sql);
        return $query->result_array();
    }*/



}
