<?php
class Model_notificacion extends CI_Model{
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
    
    /*------- LISTA DE REQUERIMIENTOS POR MES (servicio) --------*/
    public function list_requerimiento_mes($com_id,$mes_id){
        $sql = 'select *
                from _componentes c
                Inner Join _productos as pr On pr.com_id=c.com_id
                Inner Join _insumoproducto as ip On ip.prod_id=pr.prod_id
                Inner Join insumos as i On i.ins_id=ip.ins_id
                Inner Join partidas as par On i.par_id=par.par_id
                Inner Join temporalidad_prog_insumo as temp On temp.ins_id=i.ins_id
                where c.com_id='.$com_id.' and pr.estado!=\'3\' and temp.mes_id='.$mes_id.' and i.ins_estado!=\'3\' and i.aper_id!=\'0\' and temp.g_id='.$this->gestion.'  and par.par_depende!=\'10000\'
                order by pr.prod_cod,par.par_codigo asc';

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*------- LISTA DE REQUERIMIENTOS POR MES (servicio) --------*/
    public function list_requerimiento_mes_unidad($proy_id,$mes_id){
        $sql = 'select c.*,pr.*,i.*,par.*,temp.*
                from _proyectofaseetapacomponente pfe
                Inner Join _componentes as c On c.pfec_id=pfe.pfec_id
                Inner Join _productos as pr On pr.com_id=c.com_id
                Inner Join _insumoproducto as ip On ip.prod_id=pr.prod_id
                Inner Join insumos as i On i.ins_id=ip.ins_id
                Inner Join partidas as par On i.par_id=par.par_id
                Inner Join temporalidad_prog_insumo as temp On temp.ins_id=i.ins_id
                where proy_id='.$proy_id.' and pfe.pfec_estado=\'1\' and temp.mes_id='.$mes_id.' and pfe.estado!=\'3\' and c.estado!=\'3\' and pr.estado!=\'3\' and i.ins_estado!=\'3\' and i.aper_id!=\'0\' and par.par_depende!=\'10000\'
                order by c.com_id,pr.prod_cod, par.par_codigo asc';

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*---- GET MES -----*/
    function get_mes($mes_id){
        $sql = 'select *
                from mes
                where m_id='.$mes_id.'';
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
