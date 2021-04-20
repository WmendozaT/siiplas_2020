<?php

class Mejec_ogestion_pterminal extends CI_Model
{
    var $fun_id;
    var $gestion;

    public function __construct()
    {
        $this->load->database();
        $this->fun_id = $this->session->userData('fun_id');
        $this->gestion = $this->session->userData('gestion');
        $this->mes = $this->session->userData('mes');
        $this->fun_id = $this->session->userData('fun_id');
    }

    //LISTA DE PROGRAMAS RELACIONADO CON PROGRAMA EJECUTADO
    function lista_prog()
    {
        $sql = 'select v.*,COALESCE(p.reg_id,0) as ejecutado
        from vista_poa v
        LEFT JOIN programa_ejecucion p
        ON v.aper_id = p.aper_id  AND p.reg_mes = ' . $this->mes . ' AND p.reg_gestion = ' . $this->gestion . ' AND p.reg_estado IN (1,2)
        WHERE v.poa_gestion = ' . $this->gestion . '
        ORDER BY v.aper_programa, v.aper_proyecto, v.aper_actividad ASC';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    //lista de objetivo de gestion filtrado por carpeta poa
    function lista_ogestion($poa_id)
    {
        $sql = "SELECT o.*,CASE WHEN o.indi_id = 1 THEN 'Abs.' WHEN o.indi_id = 2 THEN 'Rel.' ELSE 'OTRO' END AS nombre_indi, f.*
                FROM vista_poa v
                INNER JOIN poaobjetivosestrategicos po ON v.poa_id = po.poa_id
                INNER JOIN objetivosgestion o ON o.obje_id  = po.obje_id
                INNER JOIN funcionario f  ON f.fun_id  = o.fun_id
                WHERE v.poa_id = " . $poa_id . " AND o.o_gestion = " . $this->gestion . " AND o.aper_id = v.aper_id
                ORDER BY o_id ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    //OBTENER PROGRAMACION MENSUAL DEL OBJETIVO DE GESTION
    function get_prog_ogestion($mes, $o_id)
    {
        $this->db->SELECT('*');
        $this->db->FROM('ogestion_prog_mes');
        $this->db->WHERE('o_id', $o_id);
        $this->db->WHERE('mes_id', $mes);
        $query = $this->db->get();
        return $query->row();
    }

    //OBTENER EJECUCION DE TIPO ABSOLUTO DEL OBJETIVO DE GESTION
    function get_eje_oabsoluto($mes, $o_id)
    {
        $this->db->SELECT('*');
        $this->db->FROM('ogestion_ejec_mes');
        $this->db->WHERE('o_id', $o_id);
        $this->db->WHERE('mes_id', $mes);
        $query = $this->db->get();
        return $query->row();
    }

    //OBTENER EJECUCION DE TIPO RELATIVO
    function get_eje_orelativo($mes, $o_id)
    {
        $this->db->SELECT('*');
        $this->db->FROM('ogestion_ejec_relativo');
        $this->db->WHERE('o_id', $o_id);
        $this->db->WHERE('mes_id', $mes);
        $query = $this->db->get();
        return $query->row();
    }

    //lista de producto terminal filtrado por id del objetivo de gestion
    function lista_pterminal($o_id)
    {
        $sql = "SELECT *,CASE WHEN indi_id = 1 THEN 'Abs.' WHEN indi_id = 2 THEN 'Rel.' ELSE 'OTRO' END AS nombre_indi
                FROM _productoterminal
                WHERE o_id = " . $o_id . " AND pt_gestion = " . $this->gestion . " AND pt_estado IN (1,2)
                ORDER BY pt_id ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    //programacion mensual del producto terminal
    function get_prog_pterminal($mes_id, $pt_id)
    {
        $this->db->SELECT('*');
        $this->db->FROM('pt_prog_mes');
        $this->db->WHERE('pt_id', $pt_id);
        $this->db->WHERE('mes_id', $mes_id);
        $query = $this->db->get();
        return $query->row();
    }

    //OBTENER EJECUCION DE TIPO ABSOLUTO DEL PRODUCTO TERMINAL
    function get_eje_ptabsoluto($mes_id, $pt_id)
    {
        $this->db->SELECT('*');
        $this->db->FROM('pt_ejec_mes');
        $this->db->WHERE('pt_id', $pt_id);
        $this->db->WHERE('mes_id', $mes_id);
        $query = $this->db->get();
        return $query->row();
    }

    //OBTENER EJECUCION DE TIPO RELATIVO DEL PRODUCTO TERMINAL
    function get_eje_ptrelativo($mes_id, $pt_id)
    {
        $this->db->SELECT('*');
        $this->db->FROM('pt_ejec_relativo');
        $this->db->WHERE('pt_id', $pt_id);
        $this->db->WHERE('mes_id', $mes_id);
        $query = $this->db->get();
        return $query->row();
    }

    //GUARDAR EJECUCION,OBJETIVO DE GESTION, PRODUCTO TERMINAL
    function guardar_ejec_op($post, $mes_id)
    {
        $poa_id = $post['poa_id'];
        $lista_ogestion = $this->lista_ogestion($poa_id);
        $this->db->trans_begin();
        if (isset($post['modificar'])) {
            $this->modificar_programa_ejec($post, $mes_id); //modificar ejcucion del programa
        } else {
            $reg_id = $this->guardar_programa_ejec($post, $mes_id); //guardar ejcucion del programa
        }
        foreach ($lista_ogestion AS $row) {
            $o_id = $row['o_id'];
            $this->add_ejec_ogestion_abs($o_id, $mes_id, $post);
            $this->add_ejec_ogestion_rel($o_id, $mes_id, $post);
            //CASO PRODUCTO TERMINAL
            $this->add_ejec_pterminal($o_id, $mes_id, $post);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            if (isset($reg_id)) {
                return $reg_id;
            } else {
                return $this->db->trans_commit();
            }

        }
    }

    //guardar programacion de ejecucion por mes
    function guardar_programa_ejec($post, $mes_id)
    {
        $data = array(
            'reg_validar' => $post['validar'],//validar = 2
            'reg_problemas' => $post['reg_problemas'],
            'reg_causas' => $post['reg_causas'],
            'reg_soluciones' => $post['reg_soluciones'],
            'reg_mes' => $mes_id,
            'reg_gestion' => $this->gestion,
            'aper_id' => $post['aper_id'],
            'fun_id' => $this->fun_id,
        );
        $this->db->INSERT('programa_ejecucion', $data);
        $reg_id = $this->db->insert_id();
        return $reg_id;
    }

    //function modificar la ejecucion del programa
    function modificar_programa_ejec($post, $mes_id)
    {
        $data = array(
            'reg_validar' => $post['validar'],//validar = 2
            'reg_problemas' => $post['reg_problemas'],
            'reg_causas' => $post['reg_causas'],
            'reg_soluciones' => $post['reg_soluciones'],
            'fun_id' => $this->fun_id
        );
        $this->db->WHERE('aper_id', $post['aper_id']);
        $this->db->WHERE('reg_mes', $mes_id);
        $this->db->WHERE('reg_estado IN(1,2)');
        $this->db->WHERE('reg_gestion', $this->gestion);
        $this->db->UPDATE('programa_ejecucion', $data);
    }

    //ADD ejecucion del objetivo de gestion de forma absoluta
    function add_ejec_ogestion_abs($o_id, $mes_id, $post)
    {
        $cod_e = 'o_id-' . $o_id . '-1';//generar mi codigo de ejecucion
        $this->del_ejec_ogestion($o_id, $mes_id);//limpiar
        if (isset($post[$cod_e])) {
            $monto_e = $post[$cod_e];//ejecucion absoluta
            if ($monto_e != 0) {
                $this->guardar_ejec_ogestion_abs($o_id, $monto_e, $mes_id);
            }
        }
    }

    //guardar ejecucion del objetivo de gestion de forma absoluta
    function guardar_ejec_ogestion_abs($o_id, $dato_fis, $mes)
    {
        $data['o_id'] = $o_id;
        $data['oem_fis'] = $dato_fis;
        $data['mes_id'] = $mes;
        $this->db->INSERT('ogestion_ejec_mes', $data);
    }

    //limpiar la tabla de ejecucion absoluta del objetivo de gestion
    function del_ejec_ogestion($o_id, $mes)
    {
        $this->db->WHERE('o_id', $o_id);
        $this->db->WHERE('mes_id', $mes);
        $this->db->DELETE('ogestion_ejec_mes');
    }

    //ADD ejecucion del objetivo de gestion de forma relativa
    function add_ejec_ogestion_rel($o_id, $mes_id, $post)
    {
        $cod_ef = 'o_id-' . $o_id . '-2';//generar mi codigo de ejecucion favorable
        $cod_ed = 'o_id-' . $o_id . '-3';//generar mi codigo de ejecucion desfavorable
        $this->del_ejec_ogestion_rel($o_id, $mes_id);//limpiar
        if (isset($post[$cod_ef]) && isset($post[$cod_ed])) {
            $monto_ef = $post[$cod_ef];//monto ejec favorable
            $monto_ed = $post[$cod_ed];//monto ejec favorable
            if (($monto_ef != 0) || ($monto_ed != 0)) {
                $this->guardar_ejec_ogestion_rel($o_id, $monto_ef, $monto_ed, $mes_id);
            }
        }
    }

    //limpiar la tabla de ejecucion relativo del objetivo de gestion
    function del_ejec_ogestion_rel($o_id, $mes)
    {
        $this->db->WHERE('o_id', $o_id);
        $this->db->WHERE('mes_id', $mes);
        $this->db->DELETE('ogestion_ejec_relativo');
    }

    //GUARDAR EJECUCION OBJETIVO DE GESTION RELATIVO
    function guardar_ejec_ogestion_rel($o_id, $monto_ef, $monto_ed, $mes_id)
    {
        $data['o_id'] = $o_id;
        $data['mes_id'] = $mes_id;
        $data['oer_favorable'] = $monto_ef;
        $data['oer_desfavorable'] = $monto_ed;
        $this->db->INSERT('ogestion_ejec_relativo', $data);
    }

    //guardar ejecucion absoluta del producto terminal
    function add_ejec_pterminal($o_id, $mes, $post)
    {
        $lista_pterminal = $this->lista_pterminal($o_id);
        $this->db->trans_begin();
        foreach ($lista_pterminal AS $row) {
            $pt_id = $row['pt_id'];
            $this->add_ejec_pterminal_abs($pt_id, $mes, $post);
            $this->add_ejec_pterminal_rel($pt_id, $mes, $post);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

        } else {
            return $this->db->trans_commit();
        }
    }

    //caso ejecucion absoluto del producto terminal
    function add_ejec_pterminal_abs($pt_id, $mes, $post)
    {
        $cod_e = 'pt_id-' . $pt_id . '-1';//generar mi codigo de ejecucion
        $this->del_ejec_pterminal_abs($pt_id, $mes);//limpiar
        if (isset($post[$cod_e])) {
            $monto_e = $post[$cod_e];//ejecucion absoluta
            if ($monto_e != 0) {
                $this->guardar_ejec_pterminal_abs($pt_id, $monto_e, $mes);
            }
        }
    }

    //limpiar la tabla de ejecucion absoluta del producto terminal
    function del_ejec_pterminal_abs($pt_id, $mes)
    {
        $this->db->WHERE('pt_id', $pt_id);
        $this->db->WHERE('mes_id', $mes);
        $this->db->DELETE('pt_ejec_mes');
    }

    //guardar ejecucion absoluto del producto terminal
    function guardar_ejec_pterminal_abs($pt_id, $monto_e, $mes)
    {
        $data['pt_id'] = $pt_id;
        $data['pem_fis'] = $monto_e;
        $data['mes_id'] = $mes;
        $this->db->INSERT('pt_ejec_mes', $data);
    }

    //caso ejecucion relativo del producto terminal
    function add_ejec_pterminal_rel($pt_id, $mes, $post)
    {
        $cod_ef = 'pt_id-' . $pt_id . '-2';//generar mi codigo de ejecucion favorable
        $cod_ed = 'pt_id-' . $pt_id . '-3';//generar mi codigo de ejecucion desfavorable
        $this->del_ejec_pterminal_rel($pt_id, $mes);//limpiar
        if (isset($post[$cod_ef]) && isset($post[$cod_ed])) {
            $monto_ef = $post[$cod_ef];//monto ejec favorable
            $monto_ed = $post[$cod_ed];//monto ejec favorable
            if (($monto_ef != 0) || ($monto_ed != 0)) {
                $this->guardar_ejec_oterminal_rel($pt_id, $monto_ef, $monto_ed, $mes);
            }
        }
    }

    //limpiar ejecucion relativa del producto terminal
    function del_ejec_pterminal_rel($pt_id, $mes)
    {
        $this->db->WHERE('pt_id', $pt_id);
        $this->db->WHERE('mes_id', $mes);
        $this->db->DELETE('pt_ejec_relativo');
    }

    //guardar ejecucion relativo del producto terminal
    function guardar_ejec_oterminal_rel($pt_id, $monto_ef, $monto_ed, $mes)
    {
        $data['pt_id'] = $pt_id;
        $data['mes_id'] = $mes;
        $data['per_favorable'] = $monto_ef;
        $data['per_desfavorable'] = $monto_ed;
        $this->db->INSERT('pt_ejec_relativo', $data);
    }

    //OBTENER DATOS DE LA EJECUCION DEL PROGRAMA
    function dato_ejec_prog($aper_id, $mes_id, $gestion)
    {
        $this->db->SELECT('*');
        $this->db->FROM('programa_ejecucion');
        $this->db->WHERE('aper_id', $aper_id);
        $this->db->WHERE('reg_mes', $mes_id);
        $this->db->WHERE('reg_gestion', $gestion);
        $this->db->WHERE('reg_estado IN (1,2)');
        $query = $this->db->get();
        return $query->row();
    }

    //lista de ejecucion por mes del programa
    function lista_mes_ejec($aper_id, $gestion)
    {
        $sql = "SELECT p.*, CASE WHEN p.reg_validar = 1 THEN 'GUARDADO' WHEN p.reg_validar = 2 THEN 'VALIDADO' ELSE '--' END AS estado,
            m.m_descripcion, f.fun_nombre, f.fun_paterno, f.fun_materno
            FROM programa_ejecucion p
            INNER JOIN mes m ON m.m_id = p.reg_mes
            INNER JOIN funcionario f ON f.fun_id = p.fun_id
            WHERE p.aper_id = " . $aper_id . " AND p.reg_gestion =" . $gestion . " AND p.reg_estado IN (1,2)
            ORDER BY m.m_id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    //revertir programa
    function revertir_programa($poa_id, $reg_id, $mes_id)
    {
        $this->db->trans_begin();
        $this->revertir($reg_id);
        $this->limpiar_ogestion_pterminal($poa_id, $mes_id);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            return $this->db->trans_commit();
        }
    }

    //revertir tabla programa_ejecucion
    function revertir($reg_id)
    {
        $prog_ejec = $this->get_prog_ejec($reg_id);
        $data = array(
            'fun_id' => $this->fun_id,
            'reg_problemas' => $prog_ejec->reg_problemas,
            'reg_causas' => $prog_ejec->reg_causas,
            'reg_soluciones' => $prog_ejec->reg_soluciones,
            'reg_mes' => $prog_ejec->reg_mes,
            'reg_gestion' => $prog_ejec->reg_gestion,
            'aper_id' => $prog_ejec->aper_id,
            'reg_estado' => 3
        );
        $this->db->INSERT('programa_ejecucion', $data);
        //modificar programa de ejecucion
        $data = array(
            'reg_problemas' => '',
            'reg_causas' => '',
            'reg_soluciones' => '',
        );
        $this->db->WHERE('reg_id', $reg_id);
        $this->db->UPDATE('programa_ejecucion', $data);
    }

    //limpiar ejecucion de objetivo de gestion y producto terminal
    function limpiar_ogestion_pterminal($poa_id, $mes_id)
    {
        $lista_objgestion = $this->lista_ogestion($poa_id);
        foreach ($lista_objgestion as $row) {
            $o_id = $row['o_id'];
            $this->del_ejec_ogestion($o_id, $mes_id);
            $this->del_ejec_ogestion_rel($o_id, $mes_id);
            $lista_pterminal = $this->lista_pterminal($o_id, $mes_id);
            foreach ($lista_pterminal as $row_p) {
                $this->del_ejec_pterminal_abs($row_p['pt_id'], $mes_id);
                $this->del_ejec_pterminal_rel($row_p['pt_id'], $mes_id);
            }

        }
    }

    //dato del programa de ejecucion filtrado por id
    function get_prog_ejec($reg_id)
    {
        $this->db->SELECT('*');
        $this->db->FROM('programa_ejecucion');
        $this->db->WHERE('reg_id', $reg_id);
        $this->db->ORDER_BY('reg_mes', 'ASC');
        $query = $this->db->get();
        return $query->row();
    }

    //Lista de archivos
    function lista_archivos($reg_id){
        $this->db->SELECT('*');
        $this->db->FROM('programa_mes_adjuntos');
        $this->db->WHERE('reg_id',$reg_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    //Lista de archivos por ejecucion de program
    function lista_arch_prog_arch($pa_id){
        $this->db->SELECT('*');
        $this->db->FROM('programa_mes_adjuntos');
        $this->db->WHERE('pa_id',$pa_id);
        $query = $this->db->get();
        return $query->row();
    }

}