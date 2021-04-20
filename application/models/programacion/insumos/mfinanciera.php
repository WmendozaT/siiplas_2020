<?php

class Mfinanciera extends CI_Model
{
    var $gestion;
    var $fun_id;

    public function __construct()
    {
        $this->load->database();
        $this->gestion = $this->session->userData('gestion');
        $this->fun_id = $this->session->userData('fun_id');
    }


    public function get_partida_programado($pr_id,$gestion)
    {
       $sql = 'select pr.*,part2.par_codigo as codigo1,part2.par_nombre as partida1,part.par_codigo as codigo2,part.par_nombre as partida2
                 from proyecto_programado_partidas pr
                 Inner Join partidas as part On part.par_id=pr.par_id
                 Inner Join partidas as part2 On part.par_depende=part2.par_codigo
                 where pr_id='.$pr_id.' and gestion='.$gestion.'';

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*------------ LISTA FUNCION PARTIDAS POR PROYECTOS PROGRAMADO --------*/
    public function vlista_partidas_proy_programado($proy_id, $gestion,$pfec_ejecucion)
    {
       $sql = 'select * from fnsuma_partidas_proyectos('.$proy_id.','.$gestion.','.$pfec_ejecucion.')';

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*------------ LISTA FUNCION PARTIDAS TOTAL POR PROYECTOS PROGRAMADO --------*/
    public function vlista_partidas_total_proy_programado($proy_id, $gestion,$pfec_ejecucion)
    {
       $sql = 'select * from fnsuma_total_partidas_proyectos('.$proy_id.','.$gestion.','.$pfec_ejecucion.')';

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*------------ TABLA PARTIDAS POR PROYECTOS PROGRAMADO --------*/
    public function lista_partidas_proy_programado($proy_id, $gestion)
    {
       $sql = 'select *
              from proyecto_programado_partidas
              where proy_id='.$proy_id.' and gestion='.$gestion.'';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*------------ LISTA VISTA PARTIDAS POR PROYECTOS EJECUTADO SIGEP --------*/
    public function vlista_partidas_proy_ejecutado($proy_id, $gestion)
    {
       $sql = ' select *
                 from v_presupuesto_ejecutado_por_fin
                 where proy_id='.$proy_id.' and gestion='.$gestion.'';

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*------------ LISTA FUNCION  PARTIDAS TOTAL DEL PROYECTOS EJECUTADO SIGEP --------*/
    public function vlista_partidas_total_sigep_proy_programado($proy_id, $gestion)
    {
       $sql = ' select * from fnsuma_total_partidas_sigep_proy('.$proy_id.','.$gestion.')';

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    /*------------  GET PARTIDAS POR PROYECTOS EJECUTADO SIGEP --------*/
    public function get_partida_proy_ejecutado($pr_id, $gestion)
    {
       $sql = ' select *
                 from proyecto_ejecutado_partidas
                 where pr_id='.$pr_id.' and gestion='.$gestion.'';

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    

    function storage_partidas($proy_id,$gestion,$part_id,$part_codigo,$ff_id,$of_id,$et_id,$total,$m1,$m2,$m3,$m4,$m5,$m6,$m7,$m8,$m9,$m10,$m11,$m12){
        $query=$this->db->query('set datestyle to DMY');
          $data_to_store = array( ///// Tabla Programado por Partidas 
          'proy_id' => $proy_id, /// proy id
          'gestion' => $gestion, /// Gestion
          'par_id' => $part_id, /// Partida Id
          'par_codigo' => $part_codigo, /// Partida codigo
          'ff_id' => $ff_id, /// Organismo Financiamiento
          'of_id' => $of_id, /// Fuente Financiador
          'et_id' => $et_id, /// Entidad de Transferencia
          'total' => $total, /// Monto Total
          'enero' => $m1, /// Enero
          'febrero' => $m2, /// Febrero
          'marzo' => $m3, /// Marzo
          'abril' => $m4, /// Abril
          'mayo' => $m5, /// Mayo
          'junio' => $m6, /// Junio
          'julio' => $m7, /// Julio
          'agosto' => $m8, /// Agosto
          'septiembre' => $m9, /// Septiembre
          'octubre' => $m10, /// Octubre
          'noviembre' => $m11, /// Noviembre
          'diciembre' => $m12, /// Diciembre
          );
          $this->db->insert('proyecto_programado_partidas', $data_to_store); ///// Guardar en Tabla Insumo Financiamiento
        return $this->db->insert_id();
    }

    function storage_partidas_ejec($pr_id,$gestion,$part_id,$ff_id,$of_id,$m1,$m2,$m3,$m4,$m5,$m6,$m7,$m8,$m9,$m10,$m11,$m12){
        $query=$this->db->query('set datestyle to DMY');
          $data_to_store = array( ///// Tabla Programado por Partidas 
          'pr_id' => $pr_id, /// proy id
          'gestion' => $gestion, /// Gestion
          'par_id' => $part_id, /// Partida Id
          'ff_id' => $ff_id, /// Organismo Financiamiento
          'of_id' => $of_id, /// Fuente Financiador
          'enero' => $m1, /// Enero
          'febrero' => $m2, /// Febrero
          'marzo' => $m3, /// Marzo
          'abril' => $m4, /// Abril
          'mayo' => $m5, /// Mayo
          'junio' => $m6, /// Junio
          'julio' => $m7, /// Julio
          'agosto' => $m8, /// Agosto
          'septiembre' => $m9, /// Septiembre
          'octubre' => $m10, /// Octubre
          'noviembre' => $m11, /// Noviembre
          'diciembre' => $m12, /// Diciembre
          );
          $this->db->insert('proyecto_ejecutado_partidas', $data_to_store); ///// Guardar en Tabla Insumo Financiamiento
        return $this->db->insert_id();
    }

    /*------------ GET FUENTE  --------*/
    public function get_ff($ff_id)
    {
       $sql = 'select * from fnget_ff('.$ff_id.')';
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    /*------------ GET ORGANISMO  --------*/
    public function get_of($of_id)
    {
       $sql = 'select * from fnget_of('.$of_id.')';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*------------ GET ENTIDAD  --------*/
    public function get_et($et_id)
    {
       $sql = 'select * from fnget_et('.$et_id.')';
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
?>