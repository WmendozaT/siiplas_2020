<?php

class Mejec_sigep extends CI_Model
{
    var $fun_id;
    var $gestion;

    public function __construct()
    {
        $this->load->database();
        $this->fun_id = $this->session->userData('fun_id');
        $this->gestion = $this->session->userData('gestion');
    }

    //LISTA DE ARCHIVOS SEGIP
    function lista_arc_segip()
    {
        $this->db->SELECT('a.*, f.fun_nombre, f.fun_paterno, f.fun_materno,m.m_descripcion');
        $this->db->FROM('archivos_sigep a');
        $this->db->JOIN('funcionario f', 'a.fun_id = f.fun_id', 'LEFT');
        $this->db->JOIN('mes m', 'a.as_mes = m.m_id', 'LEFT');
        $this->db->WHERE('a.as_gestion', $this->gestion);
        $this->db->WHERE('f.fun_estado IN (1,2)');
        $this->db->WHERE('a.estado IN (1,2)');
        $query = $this->db->get();
        return $query->result_array();
    }

    //SUBIR A LA TABLA TEMPORAL
    function sincronizar($as_id, $ruta, $gestion, $mes)
    {
        $this->db->trans_begin();
        $sql = " SET client_encoding to 'latin1';
                 COPY temporal_sigep(apertura, fte, org, objeto, descripcion, presupuesto_inicial, mod_aprobadas, presupuesto_vig, devengado)
                 FROM '" . getcwd() . "/archivos/ejec_pres_sigep/" . $ruta . "'
                 USING DELIMITERS ';'";
        $this->db->query($sql);
        //actualizar mi campo para saber que el archivo ya fue sincronizado
        $data["as_sincronizar"] = 1;
        $this->db->WHERE('as_id', $as_id);
        $this->db->UPDATE('archivos_sigep', $data);
        $this->limpiar_proy_ejec();//limpiar
        $this->guardar_proy_ejec($as_id, $gestion, $mes);//guar en proyecto ejecucion gasto
        $this->limpiar_temporal();//limpiar tabla temporal
        $file = "archivos/ejec_pres_sigep/" . $ruta;
        unlink($file);//eliminar archivo
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            return $this->db->trans_commit();
        }
    }

    //limpiar proyecto ejecucion gasto
    function limpiar_proy_ejec(){
        $sql = 'DELETE FROM _proyecto_ejecucion_gasto';
        $this->db->query($sql);
    }

    //guardar en proyecto ejecucion gasto
    function guardar_proy_ejec($as_id, $gestion, $mes)
    {
        $lista_temporal = $this->lista_temporal();
        foreach ($lista_temporal AS $row) {
            $codigo_aper = trim($row['apertura']);
            $par_cod = trim($row['objeto']);
            $ff_cod = trim($row['fte']);
            $of_cod = trim($row['org']);
            $aper_id = $this->get_aper_id($codigo_aper, $gestion);
            $data = array(
                'proy_id' => $this->get_proy_id($aper_id),
                'par_id' => $this->get_par_id($par_cod, $gestion),
                'ff_id' => $this->get_ff_id($ff_cod, $gestion),
                'of_id' => $this->get_of_id($of_cod, $gestion),
                'aper_cod_csv' => $codigo_aper,
                'par_cod_csv' => $par_cod,
                'ff_cod_csv' => $ff_cod,
                'of_cod_csv' => $of_cod,
                'ega_ppto_inicial' => $this->get_dec($row['presupuesto_inicial']),
                'ega_modif_aprobadas' => $this->get_dec($row['mod_aprobadas']),
                'ega_ppto_vigente' => $this->get_dec($row['presupuesto_vig']),
                'ega_devengado' => $this->get_dec($row['devengado']),
                'ega_mes' => $mes,
                'ega_gestion' => $gestion,
                'as_id' => $as_id
            );
            $this->db->INSERT('_proyecto_ejecucion_gasto', $data);
        }
    }

    //obtener apertura id
    function get_aper_id($codigo, $gestion)
    {
        $cod = explode("  ", trim($codigo));
        return $this->obtener_aper_id($cod[0], $cod[1], $cod[2], $gestion);
    }

    //OBTENER APER_ID
    function obtener_aper_id($programa, $proyecto, $actividad, $gestion)
    {
        $this->db->SELECT('aper_id');
        $this->db->FROM('aperturaprogramatica');
        $this->db->WHERE('aper_programa', $programa);
        $this->db->WHERE('aper_proyecto', $proyecto);
        $this->db->WHERE('aper_actividad', $actividad);
        $this->db->WHERE('aper_gestion', $gestion);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->aper_id;
        } else {
            return 0;
        }
    }

    //OBETENER EL ID DEL PROYECTO
    function get_proy_id($aper_id)
    {
        //obtener la apertura
        $this->db->SELECT('proy_id');
        $this->db->FROM('aperturaproyectos');
        $this->db->WHERE('aper_id', $aper_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->proy_id;
        } else {
            return 0;
        }
    }

    //obtener id de apertura
    function get_par_id($codigo_partida, $gestion)
    {
        $codigo = trim(str_replace(".", "", $codigo_partida));
        $this->db->SELECT('par_id');
        $this->db->FROM('partidas');
        $this->db->WHERE('par_codigo', $codigo);
        $this->db->WHERE('par_gestion', $gestion);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->par_id;
        } else {
            return 0;
        }
    }

    //lista de la tabla temporal
    function lista_temporal()
    {
        $this->db->SELECT('*');
        $this->db->FROM('temporal_sigep');
        $query = $this->db->get();
        return $query->result_array();
    }

    //obtener el id de fuente financiamiento
    function get_ff_id($codigo, $gestion)
    {
        $this->db->SELECT('ff_id');
        $this->db->FROM('fuentefinanciamiento');
        $this->db->WHERE('ff_codigo', $codigo);
        $this->db->WHERE('ff_gestion', $gestion);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->ff_id;
        } else {
            return 0;
        }
    }

    //obtener el id de organismo financiador
    function get_of_id($codigo, $gestion)
    {
        $this->db->SELECT('of_id');
        $this->db->FROM('organismofinanciador');
        $this->db->WHERE('of_codigo', $codigo);
        $this->db->WHERE('of_gestion', $gestion);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->of_id;
        } else {
            return 0;
        }
    }

    //convertir a decimal
    function get_dec($numero)
    {
        $num = str_replace(".", "", trim($numero));
        $num = str_replace(",", ".", trim($num));
        return $num;
    }

    function limpiar_temporal()
    {
        $sql = 'DELETE FROM temporal_sigep';
        $this->db->query($sql);
    }

    function lista_proy_ejec($gestion, $mes_id)
    {
        $this->db->SELECT("p.proy_id,p.proy_codigo, p.proy_nombre, r.par_codigo, r.par_nombre, f.ff_codigo, f.ff_sigla, f.ff_descripcion,
        o.of_codigo, o.of_sigla, o.of_descripcion, e.ega_id, e.ega_ppto_inicial, e.ega_modif_aprobadas, e.ega_ppto_vigente, e.ega_devengado,
        e.ega_mes, m.m_descripcion, e.aper_cod_csv, e.par_cod_csv, e.ff_cod_csv, e.of_cod_csv, e.ejecucion");
        $this->db->FROM("_proyecto_ejecucion_gasto e");
        $this->db->JOIN("_proyectos p ", "e.proy_id = p.proy_id", "LEFT");
        $this->db->JOIN("partidas r", "e.par_id = r.par_id ", "LEFT");
        $this->db->JOIN("fuentefinanciamiento f", "e.ff_id = f.ff_id", "LEFT");
        $this->db->JOIN("organismofinanciador o", "e.of_id = o.of_id", "LEFT");
        $this->db->JOIN("mes m ", "e.ega_mes = m.m_id", "LEFT");
        $this->db->WHERE("e.ega_mes", $mes_id);
        $this->db->WHERE("e.ega_gestion", $gestion);
        $this->db->WHERE("e.ega_estado IN(1,2)");
        $this->db->ORDER_BY("p.proy_codigo, p.proy_nombre", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    //eliminar archivo
    function eliminar_archivo($as_id, $ruta)
    {
        $file = "archivos/ejec_pres_sigep/" . $ruta;
        unlink($file);
        $this->db->WHERE('as_id', $as_id);
        return $this->db->DELETE('archivos_sigep');
    }

    function guardar_ejecucion($as_id, $mes_id, $gestion)
    {
        $this->db->trans_begin();
        $lista = $this->lista_proyecto_ejec($as_id, $mes_id, $gestion);
        $this->limpiar_proyecto_ejec($mes_id, $gestion);
        foreach ($lista AS $row) {
            $data = array(
                'proy_id' => $row['proy_id'],
                'par_id' => $row['par_id'],
                'ff_id' => $row['ff_id'],
                'of_id' => $row['of_id'],
                'pem_devengado' => $row['ega_devengado'],
                'pem_ppto_inicial' => $row['ega_ppto_inicial'],
                'pem_modif_aprobadas' => $row['ega_modif_aprobadas'],
                'pem_ppto_vigente' => $row['ega_ppto_vigente'],
                'mes_id' => $mes_id,
                'gestion' => $gestion,
                'fun_id' => $this->fun_id
            );
            $this->add_proy_ejec_mes($data);
            $this->update_proy_ejecucion($row['ega_id']);
        }
        //actualizar estado, guardardo de la ejecucion
        $dato["as_guardar_ejecucion"] = 1;
        $this->db->WHERE('as_id', $as_id);
        $this->db->UPDATE('archivos_sigep', $dato);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            return $this->db->trans_commit();
        }
    }

    // actualizar ejecucion
    function update_proy_ejecucion($ega_id)
    {
        $data_peg['ejecucion'] = 1;
        $this->db->WHERE('ega_id', $ega_id);
        $this->db->UPDATE('_proyecto_ejecucion_gasto', $data_peg);
    }

    //limpiar por mes tabla proyecto ejecucion gasto
    function limpiar_proyecto_ejec($mes_id, $gestion)
    {
        $this->db->WHERE('mes_id', $mes_id);
        $this->db->WHERE('gestion', $gestion);
        $this->db->DELETE('proy_ejec_mes');
    }

    //adicionar datos limpios en la tabla proyecto ejecucion mes
    function add_proy_ejec_mes($data)
    {
        $this->db->INSERT('proy_ejec_mes', $data);
    }

    //limpiar archivo sigep
    function limpiar_sigep($mes_id, $gestion){
        $this->db->WHERE('as_mes', $mes_id);
        $this->db->WHERE('as_gestion', $gestion);
        $this->db->DELETE('archivos_sigep');
    }

    //lista del proyecto de ejecucion
    function lista_proyecto_ejec($as_id, $mes_id, $gestion)
    {
        $this->db->SELECT('*');
        $this->db->FROM('_proyecto_ejecucion_gasto');
        $this->db->WHERE('as_id', $as_id);
        $this->db->WHERE('ega_mes', $mes_id);
        $this->db->WHERE('ega_gestion', $gestion);
        $this->db->WHERE('ega_estado IN (1,2)');
        $this->db->WHERE('proy_id <> 0');
        //$this->db->WHERE('par_id <> 0');
        //$this->db->WHERE('ff_id <> 0');
        //$this->db->WHERE('of_id <> 0');
        $this->db->WHERE('ega_ppto_inicial >= 0');
        $this->db->WHERE('ega_ppto_vigente >= 0');
        //$this->db->WHERE('ega_devengado > 0');
        $query = $this->db->get();
        return $query->result_array();
    }

}