<?php

class Minsumos_delegado extends CI_Model
{
    var $gestion;
    var $fun_id;

    public function __construct()
    {
        $this->load->database();
        $this->gestion = $this->session->userData('gestion');
        $this->fun_id = $this->session->userData('fun_id');
    }

    /*========== LISTA DE INSUMOS COMPONENTES ==========*/
    public function insumo_componente($proy_id)
    {
        $sql = 'select *
                from vrelacion_proy_com_ins
                where proy_id='.$proy_id.'';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function lista_componentes($proy_id)
    {
        $this->db->SELECT('*');
        $this->db->FROM('vlista_componentes_prog_mensual_fin');
        $this->db->WHERE('proy_id', $proy_id);
       // $this->db->WHERE('g_id', $this->gestion);
        //$this->db->WHERE('(g_id = '.$this->gestion.' OR g_id = 0)');
        $this->db->ORDER_BY('com_id', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    //PRESUPUESTO ASIGNADO
    public function presupuesto_asignado($proy_id)
    {
        $sql = 'SELECT * FROM fnpresupuesto_asignado_proy(' . $proy_id . ',' . $this->gestion . ')';
        $query = $this->db->query($sql);
        return $query;
    }

    //GUARDAR INSUMO
    function guardar_insumo($data_insumo, $post, $cant_fin, $com_id)
    {
        $this->db->trans_begin();
        $ins_id = $this->guardar_tabla_insumo($data_insumo);// GUARDAR EN MI TABLA INSUMO
        $this->guardar_prog_ins($post, $ins_id, $cant_fin);//guardar la programacion mensual de insumo
        $this->add_insumo_componente($com_id, $ins_id);//guardar relacion en la tabla insumos componente
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            return $this->db->trans_commit();
        }
    }

    //GUARDAR EN TABLA INSUMOS
    function  guardar_tabla_insumo($data_insumo)
    {
        $data = $this->genera_codigo(($data_insumo['ins_tipo']));
        $data_insumo['ins_codigo'] = $data['codigo'];//guardar codigo
        $data_insumo['ins_gestion'] = $this->gestion;
        $data_insumo['fun_id'] = $this->fun_id;
        $this->db->insert('insumos', $data_insumo);
        $ins_id = $this->db->insert_id();
        $this->actualizar_conf_ins($data['cont']); //actualizar mi contador de codigo de insumos
        return $ins_id;
    }

    //GENERAR CODIGO DEL INSUMO
    function genera_codigo($tipo)
    {
        $cont = $this->get_cont($tipo);
        $cont++;
        $codigo = 'SIIP/INS/AF/' . $this->gestion . '/0' . $cont;
        $data['cont'] = $cont;
        $data['codigo'] = $codigo;
        return $data;
    }

    //OBTENER CONTADOR DE ID POR EL TIPO DE INSUMO
    function get_cont()
    {
        $this->db->SELECT('conf_activos');
        $this->db->FROM('configuracion');
        $this->db->WHERE('ide', $this->gestion);
        $query = $this->db->get();
        return $query->row()->conf_activos;
    }

    //ACTUALIZA EL CONTADOR DE MI CODIGO DE INSUMOS
    function actualizar_conf_ins($cont)
    {
        $data = array(
            'conf_activos' => $cont,
        );
        $this->db->WHERE('ide', $this->gestion);
        $this->db->UPDATE('configuracion ', $data);
    }

    //GUARDAR PROGRAMACION MENSUAL DE INSUMO
    function guardar_prog_ins($post, $ins_id, $cant_fin)
    {
        for ($i = 1; $i <= $cant_fin; $i++) {
            $monto_asignado = $post[('ins_monto' . $i)];
            if ($monto_asignado != 0) {
                $data = array(//GUARDAR EN INSUMOFINANCIAMIENTO
                    'ins_id' => $ins_id,
                    'ff_id' => $post[('ff' . $i)],
                    'of_id' => $post[('of' . $i)],
                    'et_id' => $post[('ins_et' . $i)],
                    'ifin_monto' => $monto_asignado,
                    'ifin_gestion' => $this->gestion
                );
                $this->db->INSERT('insumofinanciamiento', $data);
                $ifin_id = $this->db->insert_id();
                for ($j = 1; $j <= 12; $j++) {
                    $mes = $post[('mes' . $i . $j)];
                    if ($mes != 0) {
                        $data = array(
                            'ifin_id' => $ifin_id,
                            'mes_id' => $j,
                            'ipm_fis' => $mes
                        );
                        $this->db->INSERT('ifin_prog_mes', $data);
                    }
                }
            }

        }
    }

    //tabla relacion de componentes insumos
    function add_insumo_componente($com_id, $ins_id){
        $data = array('com_id' => $com_id, 'ins_id' => $ins_id);
        $this->db->INSERT('insumocomponente', $data);
    }

    //OBTENER PRESUPUESTO DEL PROYECTO DELEGADO
    public function tabla_presupuesto($proy_id, $gestion){
        $sql = 'SELECT * FROM fnfinanciamiento_proy_delegado(' . $proy_id . ',' . $gestion . ')';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    //SALDO TOTAL DE FINANCIAMIENTO
    function saldo_total_fin($proy_id, $gestion)
    {
        $sql = 'SELECT * FROM fnsaldo_total_fin_delegado(' . $proy_id . ',' . $gestion . ')';
        $query = $this->db->query($sql);
        return $query->row();
    }

    //SUMA  DEL COSTO TOTAL DE INSUMOS
    function get_suma_costo_total($com_id)
    {
        $this->db->FROM("fnsuma_costo_total_ins_delegado(" . $com_id . ")");
        $query = $this->db->get();
        return $query->row();
    }

    //LISTA DE INSUMOS ACTIVOS FIJOS
    function lista_activos_fijos($com_id)
    {
        $this->db->SELECT('*');
        $this->db->FROM('vrelacion_proy_com_ins');
        $this->db->WHERE('com_id', $com_id);
        $this->db->WHERE('ins_tipo', 8);
       // $this->db->WHERE('ins_gestion', $this->gestion);
        $this->db->ORDER_BY('ins_id', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    //SUMA DE LA PROGRAMACION MENSUAL DE LAS ACTIVIDADES
    function sum_prog_mensual_actividades($proy_id, $gestion, $com_id)
    {
        $this->db->SELECT('proy_id, g_id, SUM(enero) AS enero, SUM(febrero) AS febrero, SUM(marzo) AS marzo, SUM(abril) AS abril, SUM(mayo) AS mayo,
         SUM(junio) AS junio, SUM(julio) AS julio,SUM(agosto) AS agosto, SUM(septiembre) AS septiembre, SUM(octubre) AS octubre,
         SUM(noviembre) AS noviembre, SUM(diciembre) AS diciembre');
        $this->db->FROM('vlista_componentes_prog_mensual_fin');
        $this->db->WHERE('proy_id', $proy_id);
        $this->db->WHERE('com_id', $com_id);
        $this->db->WHERE('g_id', $gestion);
        $this->db->GROUP_BY('proy_id,g_id');
        $query = $this->db->get();
        return $query->row();
    }

    /*------------------------- SUMA PROGRAMACION MENSUAL ACTIVIDADES (Wilmer)---------------------------*/
    function sum_prog_mensual_actividades2($proy_id, $gestion, $com_id)
    {
        $sql = 'select proy_id, g_id, SUM(enero) AS enero, SUM(febrero) AS febrero, SUM(marzo) AS marzo, SUM(abril) AS abril, SUM(mayo) AS mayo,
        SUM(junio) AS junio, SUM(julio) AS julio,SUM(agosto) AS agosto, SUM(septiembre) AS septiembre, SUM(octubre) AS octubre,
        SUM(noviembre) AS noviembre, SUM(diciembre) AS diciembre
        from vlista_componentes_prog_mensual_fin
        where proy_id='.$proy_id.' and com_id='.$com_id.' and g_id='.$gestion.'
        group by proy_id,g_id';

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    //DATO DEL COMPONENTE
    function get_componente($com_id)
    {
        $this->db->SELECT('*');
        $this->db->FROM('_componentes');
        $this->db->WHERE('com_id', $com_id);
        $query = $this->db->get();
        return $query->row();
    }

    //
    function eliminar_insumo($ins_id)
    {
        $this->db->trans_begin();
        $this->del_prog_ins($ins_id);
        $this->del_insumos($ins_id);
        $this->del_ins_comp($ins_id);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            return $this->db->trans_commit();
        }
    }

    //eliminar tabla insumos
    function del_insumos($ins_id)
    {
        $dato['ins_estado'] = 3;
        $this->db->WHERE('ins_id', $ins_id);
        $this->db->UPDATE('insumos', $dato);
    }

    //eliminar promacion del insumo
    function del_prog_ins($ins_id)
    {
        $lista_ifin = $this->lista_ins_fin($ins_id);
        foreach ($lista_ifin as $row) {
            $this->del_ifin($row['ifin_id']);//eliminar la programacion del insumo
        }
        $this->ifin_eliminar($ins_id);//eliminar insumo financiamiento

    }

    function lista_ins_fin($ins_id)
    {
        $this->db->SELECT('*');
        $this->db->FROM('insumofinanciamiento');
        $this->db->WHERE('ins_id', $ins_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    //eliminar programacion mes
    function del_ifin($ifin_id)
    {
        $this->db->WHERE('ifin_id', $ifin_id);
        $this->db->DELETE('ifin_prog_mes');
    }

    //cambiar a estado de eliminacion
    function ifin_eliminar($ins_id)
    {
        $dato['ifin_estado'] = 3;
        $this->db->WHERE('ins_id', $ins_id);
        $this->db->UPDATE('insumofinanciamiento', $dato);
    }

    //eliminar relacion insumo componente
    function del_ins_comp($ins_id)
    {
        $this->db->WHERE('ins_id',$ins_id);
        $this->db->DELETE('insumocomponente');
    }

}

?>
