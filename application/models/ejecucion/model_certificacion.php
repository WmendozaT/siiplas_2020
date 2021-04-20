<?php
class Model_certificacion extends CI_Model{
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
    
    /*--------- DEPARTAMENTO - DISTRITAL ------*/
    public function dep_dist($dist_id){
        $sql = 'select *
                from _distritales ds
                Inner Join _departamentos as d On d.dep_id=ds.dep_id
                where ds.dist_id='.$dist_id.'';

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*--------- VERIFICA SALDO PRESUPUESTO (PROGRAMADO-ASIGNADO) ------*/
    public function saldo_presupuesto_unidad($proy_id){
        $sql = 'select *
                from v_saldo_presupuesto_unidad
                where proy_id='.$proy_id.' and g_id='.$this->gestion.'';

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*------- LISTA DE REQUERIMIENTOS POR MES (notificacion) 2020 --------*/
    public function list_productos_unidad($proy_id){
        $sql = 'select c.com_id,c.com_componente,pr.prod_id,pr.prod_cod,pr.prod_producto,pr.prod_indicador,pr.prod_fuente_verificacion,pr.prod_resultado,SUM(i.ins_costo_total) monto
                from  _proyectofaseetapacomponente pfe
                Inner Join _componentes as c On c.pfec_id=pfe.pfec_id

                Inner Join _productos as pr On pr.com_id=c.com_id
                Inner Join _insumoproducto as ip On ip.prod_id=pr.prod_id
                Inner Join insumos as i On i.ins_id=ip.ins_id

                where pfe.pfec_estado=\'1\' and pfe.estado!=\'3\' and c.estado!=\'3\' and pr.estado!=\'3\' and pfe.proy_id='.$proy_id.'

                group by c.com_id,c.com_componente,pr.prod_id,pr.prod_cod,pr.prod_producto,pr.prod_indicador,pr.prod_fuente_verificacion,pr.prod_resultado
                order by c.com_id, pr.prod_cod asc';

        $query = $this->db->query($sql);
        return $query->result_array();
    }


    /*------- LISTA OPERACIONES POR SUBACTIVIDAD CON SU PRESUPUESTO (2021) --------*/
    public function list_operaciones_x_subactividad_ppto($proy_id){
        $sql = '
            select *
            from vista_operaciones_por_subactividad_ppto
            where proy_id='.$proy_id.' and aper_gestion='.$this->gestion.'';

        $query = $this->db->query($sql);
        return $query->result_array();
    }



    /*------- DATOS UNIDAD,ESTABLECIMIENTO, ATRAVES DE SU PRODUCTO ID (GASTO CORRIENTE)--------*/
    public function get_datos_unidad_prod($prod_id){
        $sql = 'select pr.*,ore.*,og.*,ae.*,dist.*,dep.*,oe.*,c.*,p.*,apg.*,ua.*,te.*,sa.*,tpsa.*
                from _productos pr
        
                Inner Join objetivos_regionales as ore On ore.or_id=pr.or_id
                Inner Join objetivo_programado_mensual as opm On ore.pog_id=opm.pog_id
                Inner Join objetivo_gestion as og On og.og_id=opm.og_id
                Inner Join _acciones_estrategicas as ae On ae.acc_id=og.acc_id
                Inner Join _objetivos_estrategicos as oe On oe.obj_id=ae.obj_id

                Inner Join _componentes as c On c.com_id=pr.com_id
                Inner Join servicios_actividad as sa On sa.serv_id=c.serv_id
                Inner Join tipo_subactividad as tpsa On tpsa.tp_sact=c.tp_sact
                Inner Join _proyectofaseetapacomponente as pfe On pfe.pfec_id=c.pfec_id
                Inner Join _proyectos as p On p.proy_id=pfe.proy_id
                Inner Join _distritales as dist On dist.dist_id=p.dist_id
                Inner Join _departamentos as dep On dep.dep_id=p.dep_id
                Inner Join aperturaproyectos as ap On ap.proy_id=p.proy_id
                Inner Join aperturaprogramatica as apg On apg.aper_id=ap.aper_id
                Inner Join unidad_actividad as ua On ua.act_id=p.act_id
                Inner Join v_tp_establecimiento as te On te.te_id=ua.te_id
                where pr.estado!=\'3\' and c.estado!=\'3\' and pfe.pfec_estado=\'1\' and pfe.estado!=\'3\' and pr.prod_id='.$prod_id.' and apg.aper_estado!=\'3\' and apg.aper_gestion='.$this->gestion.'';

        $query = $this->db->query($sql);
        return $query->result_array();
    }

        /*------- DATOS PROYECTO DE INVERSION, ATRAVES DE SU PRODUCTO ID--------*/
    public function get_datos_pi_prod($prod_id){
        $sql = 'select pr.*,ore.*,og.*,ae.*,dist.*,dep.*,oe.*,c.*,p.*,apg.*
                from _productos pr
        
                Inner Join objetivos_regionales as ore On ore.or_id=pr.or_id
                Inner Join objetivo_programado_mensual as opm On ore.pog_id=opm.pog_id
                Inner Join objetivo_gestion as og On og.og_id=opm.og_id
                Inner Join _acciones_estrategicas as ae On ae.acc_id=og.acc_id
                Inner Join _objetivos_estrategicos as oe On oe.obj_id=ae.obj_id

                Inner Join _componentes as c On c.com_id=pr.com_id
                Inner Join _proyectofaseetapacomponente as pfe On pfe.pfec_id=c.pfec_id
                Inner Join _proyectos as p On p.proy_id=pfe.proy_id
                Inner Join _distritales as dist On dist.dist_id=p.dist_id
                Inner Join _departamentos as dep On dep.dep_id=p.dep_id
                Inner Join aperturaproyectos as ap On ap.proy_id=p.proy_id
                Inner Join aperturaprogramatica as apg On apg.aper_id=ap.aper_id
                where pr.estado!=\'3\' and c.estado!=\'3\' and pfe.pfec_estado=\'1\' and pfe.estado!=\'3\' and pr.prod_id='.$prod_id.' and apg.aper_estado!=\'3\' and apg.aper_gestion='.$this->gestion.'';

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*------- LISTA DE REQUERIMIENTOS POR PRODUCTOS--------*/
    public function requerimientos_operacion($prod_id){
        $sql = 'select *
                from _insumoproducto ip
                Inner Join insumos as i On i.ins_id=ip.ins_id
                Inner Join partidas as par On par.par_id=i.par_id
                where ip.prod_id='.$prod_id.' and i.ins_estado!=\'3\' and i.aper_id!=\'0\' and i.ins_gestion='.$this->gestion.'
                order by par.par_codigo,i.ins_id asc';
            $query = $this->db->query($sql);
        
        return $query->result_array();
    }


    /*--- LISTA DE REQUERIMIENTOS A MODIFICAR -CERT POA ---*/
    public function requerimientos_modificar_cpoa($cpoa_id){
        $sql = 'select *
                from  certificacionpoadetalle cdet
                Inner Join insumos as i On i.ins_id=cdet.ins_id
                Inner Join partidas as par On par.par_id=i.par_id
                where cdet.cpoa_id='.$cpoa_id.' and i.ins_estado!=\'3\' and i.aper_id!=\'0\'
                order by par.par_codigo,i.ins_id asc';
            $query = $this->db->query($sql);
        
        return $query->result_array();
    }

    /*------- OBTIENE DATOS PROG. FIN POR MES ----*/
    public function get_insumo_programado_mes($ins_id,$mes_id){
        $sql = 'select *
                from temporalidad_prog_insumo
                where ins_id='.$ins_id.' and mes_id='.$mes_id.'';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*------- GET CODIGO CERTIFICACIÓN POA  ----*/
    public function get_codigo_certpoa($codigo){
        $sql = 'select *
                from certificacionpoa
                where cpoa_codigo like \''.$codigo.'\' and cpoa_gestion='.$this->gestion.'';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*------- OBTIENE DATOS PROG. y CERT  POR MES ----*/
    public function get_insumo_programado_certificado_mes($ins_id,$mes_id){
        $sql = ' select *
                from cert_temporalidad_prog_insumo cti
                Inner Join temporalidad_prog_insumo as ti on ti.tins_id = cti.tins_id
                where ti.ins_id='.$ins_id.' and ti.mes_id='.$mes_id.' and ti.g_id='.$this->gestion.'';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*----- OBTIENE NUMERO DE TEMPORALIDAD ----*/
    public function get_insumo_programado($ins_id){
        $sql = 'select *
                from temporalidad_prog_insumo
                where ins_id='.$ins_id.'';
        $query = $this->db->query($sql);

        return $query->num_rows();
    }

    /*----- GET NUMERO DE TEMP. CERTIFICADO  ----*/
    public function get_lista_detalle_cert_poa($cpoa_id){
        $sql = 'select *
                from vrequerimiento_certificado
                where cpoa_id='.$cpoa_id.'
                order by cpoad_id';
        $query = $this->db->query($sql);

        return $query->num_rows();
    }

    /*----- LISTA DE ITEMS CERTIFICADOS PARA REPORTE FINAL  ----*/
    public function lista_items_certificados($cpoa_id){
        $sql = 'select *
                from vrequerimiento_certificado
                where cpoa_id='.$cpoa_id.'
                order by cpoad_id, par_codigo';
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    /*----- LISTA DE ITEMS CERTIFICADOS PARA REPORTE FINAL (ELIMINADOS) ----*/
    public function lista_items_certificados_anulados($cpoa_id){
        $sql = 'select *
                from vcertificado_insumo_anulado
                where cpoa_id='.$cpoa_id.'
                order by cpoaad_id, par_codigo';
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    /*----- VERIFICA SI UN REQUERIMIENTO ESTA CERTIFICADO ----*/
    public function verif_insumo_certificado($ins_id){
        $sql = ' select *
                 from certificacionpoadetalle
                 where ins_id='.$ins_id.'';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*----- GET DATOS CERTIFICACION POA 2020 ----*/
    public function get_certificacion_poa($cpoa_id){
        $sql = 'select cpoa.*,c.*,f.*,p.*,dist.*,dep.*,ua.act_id,ua.act_cod,ua.act_descripcion,te.*
                from certificacionpoa cpoa
                Inner Join _componentes as c On c.com_id=cpoa.com_id
                Inner Join funcionario as f On f.fun_id=cpoa.fun_id
                Inner Join _proyectos as p On p.proy_id=cpoa.proy_id
                Inner Join _distritales as dist On dist.dist_id=p.dist_id
                Inner Join _departamentos as dep On dep.dep_id=p.dep_id
                Inner Join unidad_actividad as ua On ua.act_id=p.act_id
                Inner Join v_tp_establecimiento as te On te.te_id=ua.te_id
                where cpoa.cpoa_id='.$cpoa_id.' and cpoa.cpoa_gestion='.$this->gestion.'';
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    /*-------- GET CERTIFICADO POA DETALLE ----------*/
    public function get_certificado_poa_detalle($cpoa_id,$ins_id){
        $sql = 'select *
                from certificacionpoadetalle
                where ins_id='.$ins_id.' and cpoa_id='.$cpoa_id.'';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*----- GET RANGO COMPLEMENTARIO CERT POA ----*/
    public function datos_complementarios_cpoa($cpoa_id){
        $sql = 'select *
                from vdatos_totales_certificacion_poa
                where cpoa_id='.$cpoa_id.'';
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    /*----- GET MONTO INSUMO CERTIFICADO (TOTAL POR ITEM) ----*/
    public function get_insumo_monto_certificado($ins_id){
        $sql = 'select *
                from vmonto_certificado_insumo
                where ins_id='.$ins_id.'';
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    /*----- GET MONTO INSUMO POR CERTIFICADO POA ----*/
    public function get_insumo_monto_cpoa_certificado($ins_id,$cpoa_id){
        $sql = 'select cdet.cpoa_id,cdet.ins_id,SUM(pmes.ipm_fis) as monto
                from cert_temporalidad_prog_insumo cmes
                Inner Join temporalidad_prog_insumo as pmes On pmes.tins_id=cmes.tins_id
                Inner Join certificacionpoadetalle as cdet On cdet.cpoad_id=cmes.cpoad_id
                where cdet.cpoa_id='.$cpoa_id.' and cdet.ins_id='.$ins_id.'
                group by cdet.cpoa_id,cdet.ins_id';
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    /*----- GET MES CERTIFICADO (REQUERIMIENTO) ----*/
    public function get_mes_certificado($tins_id){
        $sql = 'select *
                from cert_temporalidad_prog_insumo
                where tins_id='.$tins_id.'';
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    /*----- GET MES CERTIFICADO (REQUERIMIENTO) SEGUN CERTIFICADO POA ----*/
    public function get_mes_certificado_cpoa($cpoa_id,$tins_id){
        $sql = 'select *
                from cert_temporalidad_prog_insumo cmes
                Inner Join certificacionpoadetalle as cdet On cdet.cpoad_id=cmes.cpoad_id
                where cdet.cpoa_id='.$cpoa_id.' and cmes.tins_id='.$tins_id.'';
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    /*----- GET NRO DE MESES CERTIFICADOS POR CERTIFICADO POA ----*/
    public function get_nro_mes_certificado_cpoa($cpoa_id){
        $sql = 'select *
                from cert_temporalidad_prog_insumo cmes
                Inner Join certificacionpoadetalle as cdet On cdet.cpoad_id=cmes.cpoad_id
                where cdet.cpoa_id='.$cpoa_id.'';
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    /*----- LISTA DE CERTIFICACIONES POA 2020 ----*/
    public function list_certificados(){
        $dep=$this->dep_dist($this->dist);
        /// Administrador Nacional
        if($this->adm==1){
            $sql = 'select *
                    from certificacionpoa cp
                    Inner Join _proyectos as p On p.proy_id=cp.proy_id
                    Inner Join _tipoproyecto as tp On p.tp_id=tp.tp_id
                    Inner Join _componentes as c On c.com_id=cp.com_id
                    Inner Join aperturaproyectos as ap On ap.proy_id=p.proy_id
                    Inner Join aperturaprogramatica as apg On apg.aper_id=ap.aper_id
                    Inner Join _departamentos as d On d.dep_id=p.dep_id
                    Inner Join _distritales as ds On ds.dist_id=p.dist_id
                    Inner Join unidad_actividad as ua On ua.act_id=p.act_id
                    Inner Join v_tp_establecimiento as te On te.te_id=ua.te_id
                    where cpoa_gestion='.$this->gestion.' and cp.cpoa_estado!=\'3\' and apg.aper_estado!=\'3\' and apg.aper_gestion='.$this->gestion.'
                    order by cpoa_id asc';
        }
        /// Administrador Regional/Distrital
        else{
            if($this->dist_tp==1){ /// Regional
                $sql = 'select *
                        from certificacionpoa cp
                        Inner Join _proyectos as p On p.proy_id=cp.proy_id
                        Inner Join _tipoproyecto as tp On p.tp_id=tp.tp_id
                        Inner Join _componentes as c On c.com_id=cp.com_id
                        Inner Join aperturaproyectos as ap On ap.proy_id=p.proy_id
                        Inner Join aperturaprogramatica as apg On apg.aper_id=ap.aper_id
                        Inner Join _departamentos as d On d.dep_id=p.dep_id
                        Inner Join _distritales as ds On ds.dist_id=p.dist_id
                        Inner Join unidad_actividad as ua On ua.act_id=p.act_id
                        Inner Join v_tp_establecimiento as te On te.te_id=ua.te_id
                        where p.dep_id='.$dep[0]['dep_id'].' and cpoa_gestion='.$this->gestion.' and cp.cpoa_estado!=\'3\' and apg.aper_estado!=\'3\'  and apg.aper_gestion='.$this->gestion.'
                        order by cpoa_id asc';
            }
            else{ /// Distrital
                $sql = 'select *
                        from certificacionpoa cp
                        Inner Join _proyectos as p On p.proy_id=cp.proy_id
                        Inner Join _tipoproyecto as tp On p.tp_id=tp.tp_id
                        Inner Join _componentes as c On c.com_id=cp.com_id
                        Inner Join aperturaproyectos as ap On ap.proy_id=p.proy_id
                        Inner Join aperturaprogramatica as apg On apg.aper_id=ap.aper_id
                        Inner Join _departamentos as d On d.dep_id=p.dep_id
                        Inner Join _distritales as ds On ds.dist_id=p.dist_id
                        Inner Join unidad_actividad as ua On ua.act_id=p.act_id
                        Inner Join v_tp_establecimiento as te On te.te_id=ua.te_id
                        where p.dep_id='.$dep[0]['dep_id'].' and p.dist_id='.$this->dist.'and cpoa_gestion='.$this->gestion.' and cp.cpoa_estado!=\'3\' and apg.aper_estado!=\'3\'  and apg.aper_gestion='.$this->gestion.'
                        order by cpoa_id asc';
            }
        }

        $query = $this->db->query($sql);
        return $query->result_array();
    }


    /*================= EDICION PARCIAL Y TOTAL DE LA CERTIFICACIÓN POA ================*/
    
    /*========= CERTIFICACION ANULADO =========*/
    public function certificado_anulado($cpoa_id){
        $sql = 'select ca.*, cp.proy_id,cp.aper_id,cp.com_id,f.*
                from certificacionpoa_anulado ca
                Inner Join certificacionpoa as cp On cp.cpoa_id=ca.cpoa_id
                Inner Join funcionario as f On f.fun_id=ca.fun_id
                where ca.cpoa_id='.$cpoa_id.'';

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*----- GET DATOS CERTIFICADO A EDITAR CON ID ANULADO ----*/
    public function get_cert_poa_editado($cpoaa_id){
        $sql = 'select ca.cpoaa_id,ca.cite as cite_cert_mod, ca.justificacion,ca.cpoa_id,ca.tp_anulado,cp.proy_id,cp.cpoa_codigo,cp.cpoa_gestion,cp.cpoa_estado,cp.aper_id,cp.com_id,cp.cpoa_cite,cp.cite_fecha,cp.prod_id,mod.cite_id
                from certificacionpoa_anulado ca
                Inner Join certificacionpoa as cp On cp.cpoa_id=ca.cpoa_id
                Inner Join cite_mod_requerimientos as mod On mod.cpoaa_id=ca.cpoaa_id
                where ca.cpoaa_id='.$cpoaa_id.'';
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    /*----- GET DATOS CERTIFICADO A EDITAR CON ID DE LA CERTIFICACION POA  ----*/
    public function get_certpoa_vigente_modificado($cpoa_id){
        $sql = 'select ca.cpoaa_id,ca.cite as cite_cert_mod, ca.justificacion,ca.cpoa_id,ca.tp_anulado,cp.proy_id,cp.cpoa_codigo,cp.cpoa_gestion,cp.cpoa_estado,cp.aper_id,cp.com_id,cp.cpoa_cite,cp.cite_fecha,cp.prod_id,mod.cite_id
                from certificacionpoa_anulado ca
                Inner Join certificacionpoa as cp On cp.cpoa_id=ca.cpoa_id
                Inner Join cite_mod_requerimientos as mod On mod.cpoaa_id=ca.cpoaa_id
                where ca.cpoa_id='.$cpoa_id.'';
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    /*----- VERIFICANDO SI EL REQUERIMIENTO FUE MODIFICADO (CERTIFICACION-MODIFICACION)  ----*/
    public function get_verif_modreq_certpoa($cpoa_id,$ins_id){
        $sql = 'select *
                from insumo_update imod
                Inner Join cite_mod_requerimientos as mod On mod.cite_id=imod.cite_id
                Inner Join certificacionpoa_anulado as canulado On canulado.cpoaa_id=mod.cpoaa_id
                where canulado.cpoa_id='.$cpoa_id.' and imod.ins_id='.$ins_id.'';
        $query = $this->db->query($sql);

        return $query->result_array();
    }


    /*----- MODULO EVALUACION POA 2020 - UNIDAD ----*/
    /*----- Suma grupo de Partida por defecto - Gasto Corriente ----*/
    public function suma_grupo_partida_programado($aper_id,$grupo_partida){
        $trimestre=0;
        if($this->tmes==1){
            $trimestre=3;
        }
        elseif ($this->tmes==2) {
            $trimestre=6;
        }
        elseif($this->tmes==3){
            $trimestre=9;
        }
        else{   
            $trimestre=12;
        }

        $sql = 'select i.aper_id, SUM(t.ipm_fis) suma_partida
                from insumos i
                Inner Join partidas as p On p.par_id=i.par_id
                Inner Join temporalidad_prog_insumo as t On t.ins_id=i.ins_id
                where i.aper_id='.$aper_id.' and (t.mes_id>\'0\' and t.mes_id<='.$trimestre.') and t.g_id='.$this->gestion.' and p.par_depende=\''.$grupo_partida.'\' and i.ins_estado!=\'3\' and i.aper_id!=\'0\'
                group by i.aper_id';
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    /*----- Suma monto certificado por unidad al trimestre vigente - Gasto Corriente ----*/
    public function suma_monto_certificado_unidad($proy_id){
        $trimestre=0;
        if($this->tmes==1){
            $trimestre=3;
        }
        elseif ($this->tmes==2) {
            $trimestre=6;
        }
        elseif($this->tmes==3){
            $trimestre=9;
        }
        else{   
            $trimestre=12;
        }

        $sql = 'select cpoa.proy_id,SUM(t.ipm_fis) ppto_certificado
                from certificacionpoa cpoa
                Inner Join certificacionpoadetalle as cpoad On cpoad.cpoa_id=cpoa.cpoa_id
                Inner Join insumos as i On i.ins_id=cpoad.ins_id
                Inner Join partidas as par On par.par_id=i.par_id

                Inner Join cert_temporalidad_prog_insumo as ct On ct.cpoad_id=cpoad.cpoad_id
                Inner Join temporalidad_prog_insumo as t On t.tins_id=ct.tins_id


                where cpoa.proy_id='.$proy_id.' and (t.mes_id>\'0\' and t.mes_id<='.$trimestre.') and t.g_id='.$this->gestion.' and cpoa.cpoa_estado!=\'3\' and  par.par_depende!=\'10000\' and i.ins_estado!=\'3\' and i.aper_id!=\'0\'
                group by cpoa.proy_id';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*----- Presupuesto total asignado por trimestre por unidad----*/
    public function monto_total_programado_trimestre($aper_id){
        $trimestre=0;
        if($this->tmes==1){
            $trimestre=3;
        }
        elseif ($this->tmes==2) {
            $trimestre=6;
        }
        elseif($this->tmes==3){
            $trimestre=9;
        }
        else{   
            $trimestre=12;
        }

        $sql = 'select i.aper_id, SUM(t.ipm_fis) ppto_programado
                from insumos i
                Inner Join temporalidad_prog_insumo as t On t.ins_id=i.ins_id
                where i.aper_id='.$aper_id.' and (t.mes_id>\'0\' and t.mes_id<='.$trimestre.') and t.g_id='.$this->gestion.' and i.ins_estado!=\'3\' and i.aper_id!=\'0\'
                group by i.aper_id';
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    /*----- MODULO EVALUACION POA 2020 - NACIONAL ----*/
    /*----- Suma grupo de Partida - Gasto Corriente,Proyecto de Inversion ----*/
    public function suma_grupo_partida_programado_institucional($tp_id,$grupo_partida){
        $trimestre=0;
        if($this->tmes==1){
            $trimestre=3;
        }
        elseif ($this->tmes==2) {
            $trimestre=6;
        }
        elseif($this->tmes==3){
            $trimestre=9;
        }
        elseif($this->tmes==4){  
            $trimestre=12;
        }

        if($tp_id==1){
            $sql = '
                select SUM(i.ins_costo_total) suma_partida
                from insumos i
                Inner Join partidas as par On par.par_id=i.par_id

                Inner Join aperturaproyectos as ap On ap.aper_id=i.aper_id
                Inner Join aperturaprogramatica as apg On apg.aper_id=ap.aper_id
                Inner Join _proyectos as p On ap.proy_id=p.proy_id

                where p.tp_id=\'1\' and i.ins_estado!=\'3\' and i.aper_id!=\'0\' and par.par_depende=\''.$grupo_partida.'\' and apg.aper_gestion='.$this->gestion.'';
        }
        else{
            $sql = '
                select SUM(t.ipm_fis) suma_partida
                from insumos i
                Inner Join partidas as par On par.par_id=i.par_id

                Inner Join aperturaproyectos as ap On ap.aper_id=i.aper_id
                Inner Join aperturaprogramatica as apg On apg.aper_id=ap.aper_id
                Inner Join _proyectos as p On ap.proy_id=p.proy_id
                Inner Join unidad_actividad as ua On ua.act_id=p.act_id
                Inner Join uni_gestion as ug On ua.act_id=ug.act_id
                Inner Join temporalidad_prog_insumo as t On t.ins_id=i.ins_id                

                where i.ins_estado!=\'3\' and i.aper_id!=\'0\' and (t.mes_id>\'0\' and t.mes_id<='.$trimestre.') and t.g_id='.$this->gestion.' and par.par_depende=\''.$grupo_partida.'\' and apg.aper_gestion='.$this->gestion.' and ua.act_estado!=\'3\' and ug.g_id='.$this->gestion.'';
        }
        
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    /*----- MODULO EVALUACION POA 2020 - REGIONAL ----*/
    /*----- Suma grupo de Partida - Gasto Corriente,Proyecto de Inversion ----*/
    public function suma_grupo_partida_programado_por_regional($tp_id,$dep_id,$grupo_partida){
        $trimestre=0;
        if($this->tmes==1){
            $trimestre=3;
        }
        elseif ($this->tmes==2) {
            $trimestre=6;
        }
        elseif($this->tmes==3){
            $trimestre=9;
        }
        elseif($this->tmes==4){  
            $trimestre=12;
        }

        if($tp_id==1){
            $sql = '
                select p.dep_id, SUM(t.ipm_fis) suma_partida
                from insumos i
                Inner Join partidas as par On par.par_id=i.par_id

                Inner Join aperturaproyectos as ap On ap.aper_id=i.aper_id
                Inner Join aperturaprogramatica as apg On apg.aper_id=ap.aper_id
                Inner Join _proyectos as p On ap.proy_id=p.proy_id
                Inner Join temporalidad_prog_insumo as t On t.ins_id=i.ins_id                

                where p.dep_id='.$dep_id.' and i.ins_estado!=\'3\' and i.aper_id!=\'0\' and (t.mes_id>\'0\' and t.mes_id<='.$trimestre.') and t.g_id='.$this->gestion.' and par.par_depende=\''.$grupo_partida.'\' and apg.aper_gestion='.$this->gestion.' and p.tp_id=\'1\'
                group by p.dep_id';
        }
        else{
            $sql = '
                select p.dep_id, SUM(t.ipm_fis) suma_partida
                from insumos i
                Inner Join partidas as par On par.par_id=i.par_id

                Inner Join aperturaproyectos as ap On ap.aper_id=i.aper_id
                Inner Join aperturaprogramatica as apg On apg.aper_id=ap.aper_id
                Inner Join _proyectos as p On ap.proy_id=p.proy_id
                Inner Join unidad_actividad as ua On ua.act_id=p.act_id
                Inner Join uni_gestion as ug On ua.act_id=ug.act_id
                Inner Join temporalidad_prog_insumo as t On t.ins_id=i.ins_id                

                where p.dep_id='.$dep_id.' and i.ins_estado!=\'3\' and i.aper_id!=\'0\' and (t.mes_id>\'0\' and t.mes_id<='.$trimestre.') and t.g_id='.$this->gestion.' and par.par_depende=\''.$grupo_partida.'\' and apg.aper_gestion='.$this->gestion.' and ua.act_estado!=\'3\' and ug.g_id='.$this->gestion.'
                group by p.dep_id';
        }
        
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    /*----- MODULO EVALUACION POA 2020 - DISTRITAL, al trimestre ----*/
    /*----- Suma grupo de Partida - Gasto Corriente,Proyecto de Inversion ----*/
    public function suma_grupo_partida_programado_por_distrital($tp_id,$dist_id,$grupo_partida){
        $trimestre=0;
        if($this->tmes==1){
            $trimestre=3;
        }
        elseif ($this->tmes==2) {
            $trimestre=6;
        }
        elseif($this->tmes==3){
            $trimestre=9;
        }
        elseif($this->tmes==4){  
            $trimestre=12;
        }

        if($tp_id==1){ //// Proyecto de Inversion
            $sql = '
                select p.dist_id, SUM(t.ipm_fis) suma_partida
                from insumos i
                Inner Join partidas as par On par.par_id=i.par_id

                Inner Join aperturaproyectos as ap On ap.aper_id=i.aper_id
                Inner Join aperturaprogramatica as apg On apg.aper_id=ap.aper_id
                Inner Join _proyectos as p On ap.proy_id=p.proy_id
                Inner Join temporalidad_prog_insumo as t On t.ins_id=i.ins_id                

                where p.dist_id='.$dist_id.' and i.ins_estado!=\'3\' and i.aper_id!=\'0\' and (t.mes_id>\'0\' and t.mes_id<='.$trimestre.') and t.g_id='.$this->gestion.' and par.par_depende=\''.$grupo_partida.'\' and apg.aper_gestion='.$this->gestion.' and p.tp_id=\'1\'
                group by p.dist_id';
        }
        else{ //// Gasto Corriente
            $sql = '
                select p.dist_id, SUM(t.ipm_fis) suma_partida
                from insumos i
                Inner Join partidas as par On par.par_id=i.par_id

                Inner Join aperturaproyectos as ap On ap.aper_id=i.aper_id
                Inner Join aperturaprogramatica as apg On apg.aper_id=ap.aper_id
                Inner Join _proyectos as p On ap.proy_id=p.proy_id
                Inner Join unidad_actividad as ua On ua.act_id=p.act_id
                Inner Join uni_gestion as ug On ua.act_id=ug.act_id
                Inner Join temporalidad_prog_insumo as t On t.ins_id=i.ins_id                

                where p.dist_id='.$dist_id.' and i.ins_estado!=\'3\' and i.aper_id!=\'0\' and (t.mes_id>\'0\' and t.mes_id<='.$trimestre.') and t.g_id='.$this->gestion.' and par.par_depende=\''.$grupo_partida.'\' and apg.aper_gestion='.$this->gestion.' and ua.act_estado!=\'3\' and ug.g_id='.$this->gestion.' and p.tp_id=\'1\'
                group by p.dist_id';
        }
    
        $query = $this->db->query($sql);

        return $query->result_array();
    }


    ///// MONTO CERTIFICADO INSITUTCIONAL, REGIONAL, DISTRITAL, UNIDAD
    /*----- Suma monto certificado por unidad - Gasto Corriente ----*/
    public function suma_monto_certificado_institucional($tp_id){
        $trimestre=0;
        if($this->tmes==1){
            $trimestre=3;
        }
        elseif ($this->tmes==2) {
            $trimestre=6;
        }
        elseif($this->tmes==3){
            $trimestre=9;
        }
        elseif($this->tmes==4){  
            $trimestre=12;
        }

        if($tp_id==1){
            $sql = '
            select SUM(t.ipm_fis) ppto_certificado
            from certificacionpoa cpoa

            Inner Join _proyectos as p On cpoa.proy_id=p.proy_id
            Inner Join aperturaproyectos as ap On ap.proy_id=p.proy_id
            Inner Join aperturaprogramatica as apg On apg.aper_id=ap.aper_id
                        
            Inner Join certificacionpoadetalle as cpoad On cpoad.cpoa_id=cpoa.cpoa_id
            Inner Join insumos as i On i.ins_id=cpoad.ins_id
            Inner Join partidas as par On par.par_id=i.par_id

            Inner Join cert_temporalidad_prog_insumo as ct On ct.cpoad_id=cpoad.cpoad_id
            Inner Join temporalidad_prog_insumo as t On t.tins_id=ct.tins_id

            where (t.mes_id>\'0\' and t.mes_id<='.$trimestre.') and t.g_id='.$this->gestion.' and cpoa.cpoa_estado!=\'3\' and  par.par_depende!=\'10000\'
            and i.ins_estado!=\'3\' and i.aper_id!=\'0\' and apg.aper_gestion='.$this->gestion.' and apg.aper_estado!=\'3\' and p.tp_id=\'1\' ';
        }
        else{
            $sql = '
            select SUM(t.ipm_fis) ppto_certificado
            from certificacionpoa cpoa

            Inner Join _proyectos as p On cpoa.proy_id=p.proy_id
            Inner Join aperturaproyectos as ap On ap.proy_id=p.proy_id
            Inner Join aperturaprogramatica as apg On apg.aper_id=ap.aper_id
            
            Inner Join unidad_actividad as ua On ua.act_id=p.act_id
            Inner Join uni_gestion as ug On ua.act_id=ug.act_id
                        
            Inner Join certificacionpoadetalle as cpoad On cpoad.cpoa_id=cpoa.cpoa_id
            Inner Join insumos as i On i.ins_id=cpoad.ins_id
            Inner Join partidas as par On par.par_id=i.par_id

            Inner Join cert_temporalidad_prog_insumo as ct On ct.cpoad_id=cpoad.cpoad_id
            Inner Join temporalidad_prog_insumo as t On t.tins_id=ct.tins_id

            where (t.mes_id>\'0\' and t.mes_id<='.$trimestre.') and t.g_id='.$this->gestion.' and cpoa.cpoa_estado!=\'3\' and  par.par_depende!=\'10000\' and ua.act_estado!=\'3\'
            and ug.g_id='.$this->gestion.' and i.ins_estado!=\'3\' and i.aper_id!=\'0\' and apg.aper_gestion='.$this->gestion.' and apg.aper_estado!=\'3\' and p.tp_id=\'4\'';
        }
        
        $query = $this->db->query($sql);

        return $query->result_array();
    }


    /*----- Suma monto certificado por unidad - Gasto Corriente al trimestre ----*/
    public function suma_monto_certificado_por_regional($tp_id,$dep_id){
        $trimestre=0;
        if($this->tmes==1){
            $trimestre=3;
        }
        elseif ($this->tmes==2) {
            $trimestre=6;
        }
        elseif($this->tmes==3){
            $trimestre=9;
        }
        else{   
            $trimestre=12;
        }

        if($tp_id==1){
            $sql = '
            select p.dep_id,SUM(t.ipm_fis) ppto_certificado
            from certificacionpoa cpoa

            Inner Join _proyectos as p On cpoa.proy_id=p.proy_id
            Inner Join aperturaproyectos as ap On ap.proy_id=p.proy_id
            Inner Join aperturaprogramatica as apg On apg.aper_id=ap.aper_id
                        
            Inner Join certificacionpoadetalle as cpoad On cpoad.cpoa_id=cpoa.cpoa_id
            Inner Join insumos as i On i.ins_id=cpoad.ins_id
            Inner Join partidas as par On par.par_id=i.par_id

            Inner Join cert_temporalidad_prog_insumo as ct On ct.cpoad_id=cpoad.cpoad_id
            Inner Join temporalidad_prog_insumo as t On t.tins_id=ct.tins_id

            where p.dep_id='.$dep_id.' and (t.mes_id>\'0\' and t.mes_id<='.$trimestre.') and apg.aper_gestion='.$this->gestion.' and apg.aper_estado!=\'3\' and  t.g_id='.$this->gestion.' and cpoa.cpoa_estado!=\'3\' and  par.par_depende!=\'10000\' and i.ins_estado!=\'3\' and i.aper_id!=\'0\' and p.tp_id=\'1\'
            group by p.dep_id';
        }
        else{
            $sql = '
            select p.dep_id,SUM(t.ipm_fis) ppto_certificado
            from certificacionpoa cpoa

            Inner Join _proyectos as p On cpoa.proy_id=p.proy_id
            Inner Join unidad_actividad as ua On ua.act_id=p.act_id
            Inner Join uni_gestion as ug On ua.act_id=ug.act_id
                        
            Inner Join certificacionpoadetalle as cpoad On cpoad.cpoa_id=cpoa.cpoa_id
            Inner Join insumos as i On i.ins_id=cpoad.ins_id
            Inner Join partidas as par On par.par_id=i.par_id

            Inner Join cert_temporalidad_prog_insumo as ct On ct.cpoad_id=cpoad.cpoad_id
            Inner Join temporalidad_prog_insumo as t On t.tins_id=ct.tins_id

            where p.dep_id='.$dep_id.' and (t.mes_id>\'0\' and t.mes_id<='.$trimestre.') and t.g_id='.$this->gestion.' and cpoa.cpoa_estado!=\'3\' and  par.par_depende!=\'10000\' and ua.act_estado!=\'3\' and ug.g_id='.$this->gestion.' and i.ins_estado!=\'3\' and i.aper_id!=\'0\' and p.tp_id=\'4\'
            group by p.dep_id';
        }
        
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    /*----- Suma monto certificado por unidad - Gasto Corriente, al trimestre vigente ----*/
    public function suma_monto_certificado_por_distrital($tp_id,$dist_id){
        $trimestre=0;
        if($this->tmes==1){
            $trimestre=3;
        }
        elseif ($this->tmes==2) {
            $trimestre=6;
        }
        elseif($this->tmes==3){
            $trimestre=9;
        }
        else{   
            $trimestre=12;
        }

        if($tp_id==1){ //// Proyecto de Inversion
            $sql = '
            select p.dist_id,SUM(t.ipm_fis) ppto_certificado
            from certificacionpoa cpoa

            Inner Join _proyectos as p On cpoa.proy_id=p.proy_id
            Inner Join aperturaproyectos as ap On ap.proy_id=p.proy_id
            Inner Join aperturaprogramatica as apg On apg.aper_id=ap.aper_id
                        
            Inner Join certificacionpoadetalle as cpoad On cpoad.cpoa_id=cpoa.cpoa_id
            Inner Join insumos as i On i.ins_id=cpoad.ins_id
            Inner Join partidas as par On par.par_id=i.par_id

            Inner Join cert_temporalidad_prog_insumo as ct On ct.cpoad_id=cpoad.cpoad_id
            Inner Join temporalidad_prog_insumo as t On t.tins_id=ct.tins_id

            where p.dist_id='.$dist_id.' and (t.mes_id>\'0\' and t.mes_id<='.$trimestre.') and apg.aper_gestion='.$this->gestion.' and apg.aper_estado!=\'3\' and  t.g_id='.$this->gestion.' and cpoa.cpoa_estado!=\'3\' and  par.par_depende!=\'10000\' and i.ins_estado!=\'3\' and i.aper_id!=\'0\' and p.tp_id=\'1\'
            group by p.dist_id';
        }
        else{ //// Gasto Corriente
            $sql = '
            select p.dist_id,SUM(t.ipm_fis) ppto_certificado
            from certificacionpoa cpoa

            Inner Join _proyectos as p On cpoa.proy_id=p.proy_id
            Inner Join unidad_actividad as ua On ua.act_id=p.act_id
            Inner Join uni_gestion as ug On ua.act_id=ug.act_id
                        
            Inner Join certificacionpoadetalle as cpoad On cpoad.cpoa_id=cpoa.cpoa_id
            Inner Join insumos as i On i.ins_id=cpoad.ins_id
            Inner Join partidas as par On par.par_id=i.par_id

            Inner Join cert_temporalidad_prog_insumo as ct On ct.cpoad_id=cpoad.cpoad_id
            Inner Join temporalidad_prog_insumo as t On t.tins_id=ct.tins_id

            where p.dist_id='.$dist_id.' and (t.mes_id>\'0\' and t.mes_id<='.$trimestre.') and t.g_id='.$this->gestion.' and cpoa.cpoa_estado!=\'3\' and  par.par_depende!=\'10000\' and ua.act_estado!=\'3\' and ug.g_id='.$this->gestion.' and i.ins_estado!=\'3\' and i.aper_id!=\'0\' and p.tp_id=\'4\'
            group by p.dist_id';
        }
        
        $query = $this->db->query($sql);

        return $query->result_array();
    }



////=========================== PARA PODER CORREGIR
    /*----- LISTA DE REQUERIMIENTOS ----*/
    public function list_requerimientos($dep_id){
        $sql = '
            select p.*,i.*
            from insumos i

            Inner Join aperturaprogramatica as apg On apg.aper_id=i.aper_id
            Inner Join aperturaproyectos as ap On ap.aper_id=i.aper_id
            Inner Join _proyectos as p On p.proy_id=ap.proy_id
            where p.dep_id='.$dep_id.' and apg.aper_gestion='.$this->gestion.' and apg.aper_estado!=\'3\' and i.ins_estado!=\'3\' and i.aper_id!=\'0\'';        
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    /*----- VERIFICA SI UN REQUERIMIENTO ESTA CERTIFICADO ----*/
    public function verif_insumo_certificados($ins_id){
        $sql = ' select cpoa.*,cpoad.*
                 from certificacionpoadetalle cpoad
                 Inner Join certificacionpoa as cpoa On cpoad.cpoa_id=cpoa.cpoa_id
                 where cpoad.ins_id='.$ins_id.' ';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*----- VERIFICA SI UN REQUERIMIENTO ESTA CERTIFICADO ----*/
    public function verif_temporalidad_certificado($ins_id){
        $sql = ' select *
                from temporalidad_prog_insumo tp
                Inner Join cert_temporalidad_prog_insumo as ctp On ctp.tins_id=tp.tins_id
                where tp.ins_id='.$ins_id.'';
        $query = $this->db->query($sql);
        return $query->result_array();
    }


    //// ======== LISTA DE CERTIFICACIONES POR FUNCIONES SQL

    /*----- LISTA DE CERTIFICACIONES POR REGIONAL ----*/
    public function lista_certificaciones_regional($dep_id,$tp_id,$gestion){
        $sql = 'select * from lista_certificaciones_regional($dep_id,$tp_id,$gestion)';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*----- LISTA DE CERTIFICACIONES POR DISTRITAL ----*/
    public function lista_certificaciones_distrital($dist_id,$tp_id,$gestion){
        $sql = 'select * from lista_certificaciones_distrital('.$dist_id.','.$tp_id.','.$gestion.')';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*----- LISTA DE CERTIFICACIONES POR DISTRITAL POR MES ----*/
    public function lista_certificaciones_distrital_mensual($dist_id,$tp_id,$gestion,$mes){
        $sql = 'select * from lista_certificaciones_distrital('.$dist_id.','.$tp_id.','.$gestion.')
                where extract(month from (cpoa_fecha))='.$mes.'';
        $query = $this->db->query($sql);
        return $query->result_array();
    }


    /*----- LISTA DE INSUMOS POR APERTURA ----*/
    public function list_requerimientos_apertura(){
        $sql = 'select *
                from insumos i
                where i.ins_gestion='.$this->gestion.'';
        $query = $this->db->query($sql);
        return $query->result_array();
    }


}
