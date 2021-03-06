<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "user";
$route['404_override'] = '';

$route['admin/logout'] = 'user/logout';
$route['admin/validate'] = 'user/validate_credentials';
$route['admin/dashboard'] = 'user/dashboard_index';
$route['admin/dm/(:any)'] = 'user/dashboard_menu/$1';
$route['cambiar_session'] = 'user/cambiar_gestion';//cambiar contralador
$route['cambiar_session_trimestre'] = 'user/cambiar_trimestre';//cambiar trimestre

/*PROGRAMACION*/
$route['admin/combo_ubicacion'] = 'user/combo_ubicacion';
$route['admin/combo_fase_etapas'] = 'user/combo_fases_etapas';
$route['admin/combo_clasificador'] = 'user/combo_clasificador';


/*-------------------------PROGRAMACION ESTRATEGICA-----------------------------*/
$route['admin/pei/mision'] = 'user/mision';		///// Mision Institucional
$route['admin/pei/mision/accion/(:any)'] = 'user/pei_accion/$1';	//// Pei Accion
$route['admin/pei/vision'] = 'user/vision';		///// Vision Institucional
$route['admin/pei/ayuda/acerca'] = 'user/acerca';	//// Ayuda

/* MARCO ESTRATEGICO */
/*--------------------------------------- Objetivos Estrategicos ----------------------------------------------*/
$route['me/objetivos_estrategicos'] = 'mestrategico/cobjetivos_estrategico/objetivos_estrategicos';	//// Lista Objetivos Estrategicos
$route['me/valida_objetivo_estrategico'] = 'mestrategico/cobjetivos_estrategico/valida_objetivos_estrategicos';	//// Valida Objetivos Estrategicos
$route['me/get_objetivo_estrategico'] = 'mestrategico/cobjetivos_estrategico/get_objetivos_estrategicos';	//// get Objetivos Estrategicos
$route['me/get_resultado_final'] = 'mestrategico/cobjetivos_estrategico/get_resultado_final';	//// get Resultado Final
$route['me/update_objetivo_estrategico'] = 'mestrategico/cobjetivos_estrategico/update_objetivos_estrategicos';	//// Valida Objetivos Estrategicos
$route['me/delete_objetivo_estrategico'] = 'mestrategico/cobjetivos_estrategico/delete_objetivos_estrategicos';	//// Delete Objetivos Estrategicos

$route['me/reporte_objetivos_estrategicos/(:any)'] = 'mestrategico/cobjetivos_estrategico/reporte_objetivos_estrategicos/$1';	//// Reporte Lista Objetivos Estrategicos
$route['me/reporte_obj/(:any)'] = 'mestrategico/cobjetivos_estrategico/reporte_vinculacion/$1';	//// Reporte Vinculacion PEI
$route['me/exportar_alineacion/(:any)'] = 'mestrategico/cobjetivos_estrategico/exportar_alineacion/$1';	//// Excel Vinculacion PEI

/*--------------------------------------- Acciones Estrategicas ----------------------------------------------*/
$route['me/acciones_estrategicas/(:any)'] = 'mestrategico/cacciones_estrategicas/acciones_estrategicas/$1';	//// Lista Acciones Estrategicas
$route['me/valida_acciones_estrategicas'] = 'mestrategico/cacciones_estrategicas/valida_acciones_estrategicas';	//// Valida Acciones Estrategicos
$route['me/get_acciones_estrategicas'] = 'mestrategico/cacciones_estrategicas/get_acciones_estrategicas';	//// get Acciones Estrategicas
$route['me/update_acciones_estrategicas'] = 'mestrategico/cacciones_estrategicas/update_acciones_estrategicas';	//// Valida Update Acciones Estrategicas
$route['me/delete_acciones_estrategicas'] = 'mestrategico/cacciones_estrategicas/delete_acciones_estrategicas';	//// Delete Acciones Estrategicos

/*--------------------------------------- Resultado de Mediano Plazo ----------------------------------------------*/
$route['admin/me/combo_fun_uni'] = 'mestrategico/cresultado_mplazo/combo_funcionario_unidad_organizacional'; ////// Combo Responsable a Unidad Organizacional
$route['me/resultados_mplazo/(:any)'] = 'mestrategico/cresultado_mplazo/list_resultado_mediano_plazo/$1';	//// Lista Resultados de Mediano Plazo
$route['me/get_resultado_intermedio'] = 'mestrategico/cresultado_mplazo/get_resultado_intermedio';	//// get Resultado intermedio
$route['me/new_mplazo/(:any)'] = 'mestrategico/cresultado_mplazo/new_resultado_mediano_plazo/$1';	//// Nuevo Resultado de Mediano Plazo
$route['me/valida_resultado_mplazo'] = 'mestrategico/cresultado_mplazo/valida_resultado_mediano_plazo';	//// Valida Resultado de Mediano Plazo
$route['me/update_mplazo/(:any)'] = 'mestrategico/cresultado_mplazo/update_resultado_mediano_plazo/$1';	//// Editar Resultado de Mediano Plazo
$route['me/valida_update_resultado_mplazo'] = 'mestrategico/cresultado_mplazo/valida_update_resultado_mediano_plazo';	//// Valida Update Resultado de Mediano Plazo
$route['me/rep_rmplazo/(:any)'] = 'mestrategico/cresultado_mplazo/reporte_resultado_mediano_plazo/$1';	//// Reporte Resultado de Mediano Plazo
$route['me/delete_resultado_mplazo'] = 'mestrategico/cresultado_mplazo/delete_resultado_mplazo';	//// Delete Resultado de Mediano Plazo

$route['me/get_indicador'] = 'mestrategico/cresultado_mplazo/get_indicador';	//// get Indicador

/* OBJETIVOS DE GESTION INSTITUCIONAL SEGUN ACCION ESTRATEGICA */
$route['me/objetivos_gestion/(:any)'] = 'mestrategico/cobjetivo_gestion/objetivos_gestion/$1'; //// Lista Objetivos de Gestion segun accion estrategica
$route['me/rep_objetivos_gestion/(:any)'] = 'mestrategico/cobjetivo_gestion/reporte_objetivos_gestion/$1'; //// Reporte Objetivo de Gestion

/* OBJETIVOS DE GESTION INSTITUCIONAL */
$route['me/mis_ogestion'] = 'mestrategico/cobjetivo_gestion/list_objetivos_gestion'; //// Lista Objetivos de Gestion General
$route['me/rep_ogestion'] = 'mestrategico/cobjetivo_gestion/reporte_ogestion'; //// Reporte Objetivo de Gestion General


/* OBJETIVOS REGIONALES */
$route['me/objetivos_regionales/(:any)'] = 'mestrategico/cobjetivo_regional/objetivos_regional/$1'; //// Lista Objetivos regional
$route['me/new_oregional/(:any)'] = 'mestrategico/cobjetivo_regional/form_oregional/$1/$2'; //// Nuevo Objetivo Regional
$route['me/update_oregional/(:any)'] = 'mestrategico/cobjetivo_regional/form_update_oregional/$1'; //// Modificar Objetivo Regional
$route['me/combo_oregional'] = 'mestrategico/cobjetivo_regional/combo_oregional'; ////// Combo Objetivos Regionales

$route['me/rep_oregionales/(:any)'] = 'mestrategico/cobjetivo_regional/reporte_objetivos_regionales/$1'; //// Reporte consolidado de Objetivos Regionales


/* ANALISIS DE SITUACION */
$route['admin/analisis_sit'] = 'analisis_situacion/canalisis_situacion/lista_unidades';	//// Lista Unidades, Establecimientos
$route['as/list_foda/(:any)'] = 'analisis_situacion/canalisis_situacion/lista_foda/$1';	//// Lista de formularios
$route['as/rep_list_foda/(:any)'] = 'analisis_situacion/canalisis_situacion/reporte_lista_foda/$1';	//// Imprimir lisat Foda

/*----------------------------------- Resultados de Corto plazo -----------------------------------------*/
$route['prog/resultado_cplazo/(:any)'] = 'analisis_situacion/cresultado_cplazo/lista_resultados_corto_plazo/$1/$2';//Lista de Resultados de Corto Plazo
$route['prog/reporte_resultado_cp/(:any)'] = 'analisis_situacion/cresultado_cplazo/reporte_resultados_corto_plazo/$1/$2';//Reporte Lista de Resultados de Corto Plazo
$route['prog/temporalidad_cplazo/(:any)'] = 'analisis_situacion/cresultado_cplazo/rcplazo_temporalidad/$1/$2';//// Programar Temporalidad Mensual
$route['prog/valida_temporalidad_cplazo'] = 'analisis_situacion/cresultado_cplazo/valida_rcplazo_temporalidad';//// Valida Temporalidad Mensual

/*----------------------------------- Producto Terminal de Corto plazo -----------------------------------------*/
$route['prog/pterminal_cp/(:any)'] = 'analisis_situacion/cpterminal_cplazo/list_pterminal_cp/$1/$2';//Lista de Productos Terminal de Corto Plazo
$route['prog/reporte_pterminal_cp/(:any)'] = 'analisis_situacion/cpterminal_cplazo/reporte_pterminal_corto_plazo/$1/$2';//Reporte Lista de Resultados de Corto Plazo
$route['prog/temporalidad_pt_cplazo/(:any)'] = 'analisis_situacion/cpterminal_cplazo/ptcplazo_temporalidad/$1/$2';//// Programar Temporalidad Mensual
$route['prog/valida_temporalidad_ptcplazo'] = 'analisis_situacion/cpterminal_cplazo/valida_ptcplazo_temporalidad';//// Valida Temporalidad Mensual


////////////////////////////////////// PROGRAMACION POA ////////////////////////////////////
$route['admin/proy/combo_distrital'] = 'programacion/proyecto/combo_distrital'; ////// Combo distrital
$route['admin/proy/combo_administrativas'] = 'programacion/proyecto/combo_da'; ////// Combo Unidades Administrativas
$route['admin/proy/combo_uejecutoras'] = 'programacion/proyecto/combo_ue'; ////// Combo Unidades Ejecutoras
$route['admin/proy/list_proy'] = 'programacion/proyecto/list_proyectos';  //// lista de proyectos 
$route['proy/add_unidad'] = 'programacion/proyecto/form_poa_unidades'; //// formularios de registro - Unidad/Establecimientos
$route['admin/proy/proyecto'] = 'programacion/proyecto/form_proy_inv'; //// formularios de registro - proyectos de Inversion
$route['admin/proy/proyecto_pi/(:any)'] = 'programacion/proyecto/form_operacion_resumen/$1'; //// Proyecto de Inversion

$route['admin/proy/verif'] = 'programacion/proyecto/verif'; ////// verificando datos para la apertura programatica

$route['admin/proy/delete/(:any)'] = 'programacion/proyecto/delete_proyecto/$1/$2'; ////// eliminar proyectos

$route['proy/update_unidad/(:any)'] = 'programacion/proyecto/form_update_poa_unidades/$1'; //// formularios de registro - Unidad/Establecimientos
$route['admin/proy/edit/(:any)'] = 'programacion/proyecto/edit_operacion/$1'; //// ruta de formularios para el editado
$route['proy/presentacion/(:any)'] = 'programacion/proyecto/presentacion_poa/$1'; //// Presentacion de Unidad, Establecimiento
$route['proy/datos_generales_pi/(:any)'] = 'programacion/proyecto/datos_generales_pi/$1'; //// Datos Generales Proyecto de Inversi??n


$route['admin/combo_unidad'] = 'proyecto/combo_unidad';
$route['admin/proy/list_proy_ok'] = 'programacion/proyecto/list_proyectos_aprobados';  //// lista de proyectos aprobados

$route['prog/update_insumos/(:any)'] = 'programacion/crequerimiento/update_id_requerimientos_pi/$1';//// Actualiza los id de los insumos llevandolos a productos 2020

//// REPORTE PROGRAMACION POA 
/*--------------------------- REPORTES - SUB ACTIVIDADES---------------------------*/
/*$route['rep/rep_sactividad'] = 'reportes_cns/rep_operaciones/list_sub_actividades'; ///// Lista de Sub actividades
$route['rep/reporte_operaciones_totales'] = 'reportes_cns/rep_operaciones/reporte_total_subactividad'; ///// Reporte Lista de Sub actividades
$route['rep/det_sactividad/(:any)'] = 'reportes_cns/rep_operaciones/detalle_sactividad/$1'; ///// Detalle Sub actividades
$route['rep/xls_operaciones_sactividad/(:any)'] = 'reportes_cns/rep_operaciones/xls_detalle_operacion/$1'; ///// Reporte xls Detalle Sub actividades
*/
/*--------------------------- REPORTES - PROGRAMACION CONSOLIDADO POA (2020) ---------------------------*/
/*$route['rep/programacion_poa'] = 'reportes_cns/rep_operaciones/mi_poa';  //// Lista de Operaciones POA Aprobados

$route['rep/ver_programado_regional/(:any)'] = 'reportes_cns/rep_operaciones/ver_programado_regional/$1/$2'; ///// Consolidado Presupuesto por Partidas (Trabajando)
$route['rep/ver_programado_poa_regional']='reportes_cns/rep_operaciones/ver_programado_poa_regional';// Consolidado operaciones regional
$route['rep/ver_poa_apertura/(:any)']='reportes_cns/rep_operaciones/ver_poa_apertura_programatica/$1/$2';// Consolidado operaciones por apertura Programatica por Regional
$route['rep/ver_poa_apertura_consolidado/(:any)']='reportes_cns/rep_operaciones/ver_poa_apertura_programatica_consolidado/$1';// Consolidado operaciones por apertura Programatica por Regional Consolidado
*/


/*$route['rep/ver_poa_consolidado_objetivo/(:any)']='reportes_cns/rep_operaciones/ver_poa_total_objetivo_regional/$1';// Consolidado Total Operaciones Objetivo Regional Regional
$route['rep/ver_poa_consolidado_apertura/(:any)']='reportes_cns/rep_operaciones/ver_poa_total_apertura_regional/$1';// Consolidado Total Operaciones Apertura Programatica Regional
$route['rep/ver_poa_consolidado_apertura_nacional']='reportes_cns/rep_operaciones/ver_poa_total_apertura_nacional';// Consolidado Total Operaciones Apertura Programatica Nacional*/


//$route['rep/reporte_operaciones/(:any)'] = 'reportes_cns/rep_operaciones/reporte_operaciones/$1'; ///// reporte de todas las operaciones
$route['rep/list_operaciones_req'] = 'reportes_cns/rep_operaciones/list_regiones'; ///// Menu Lista de Regiones Consolidado POA (2020-2021)
$route['rep/get_uadministrativas'] = 'reportes_cns/rep_operaciones/get_unidades_administrativas'; ////// Combo Unidades Administrativas (CONSOLIDADO REPORTES 2020-2021)
//$route['rep/exportar_operaciones_regional/(:any)'] = 'reportes_cns/exporting_datos/operaciones_regional_nacional/$1/$2'; ///// Exportar Operaciones por regional 
$route['rep/exportar_operaciones_distrital/(:any)'] = 'reportes_cns/exporting_datos/operaciones_distrital/$1/$2'; ///// Exportar Operaciones por distrital 2020-2021
//$route['rep/exportar_operaciones_unidad/(:any)'] = 'reportes_cns/exporting_datos/operaciones_unidad/$1'; ///// Exportar Operaciones por Unidad

//$route['rep/ver_consolidado_operaciones/(:any)'] = 'reportes_cns/exporting_datos/operaciones_nacional/$1'; ///// Exportar Actividades,Operaciones Nacional (Consolidado)

$route['rep/exportar_plantilla_migracion/(:any)'] = 'reportes_cns/exporting_datosmigracion/exportar_planilla_migracion_poa/$1/$2'; ///// Exportar Actividades,Requerimientos hacia plantilla de Migracion 2021



//$route['rep/exportar_requerimientos_regional/(:any)'] = 'reportes_cns/exporting_datos/requerimientos_regional/$1/$2'; ///// Exportar Requerimientos por regional
$route['rep/exportar_requerimientos_distrital/(:any)'] = 'reportes_cns/exporting_datos/requerimientos_distrital/$1/$2'; ///// Exportar Requerimientos por Distrital 2020-2021
//$route['rep/xls_unidades/(:any)'] = 'reportes_cns/exporting_datos/mis_unidades_pinversion/$1'; ///// Lista de Unidades, Establecimientos de la regional
//$route['rep/ver_consolidado_requerimientos/(:any)'] = 'reportes_cns/exporting_datos/requerimientos_consolidado/$1'; ///// Exportar Requerimientos Nacional (Consolidado)

$route['rep/exportar_poa_oregional/(:any)']='reportes_cns/exporting_datos/ver_poa_oregional_distrital/$1/$2';// Consolidado operaciones por Objetivo Regional 2020-2021 (Distrital)

//$route['rep/exportar_requerimientos_unidad/(:any)'] = 'reportes_cns/exporting_datos/requerimientos_unidad/$1'; ///// Exportar Operaciones por Unidad
$route['rep/exportar_requerimientos_servicio/(:any)'] = 'reportes_cns/exporting_datos/requerimientos_servicio/$1'; ///// Exportar Requerimientos por Servicio (Ejecucion Presupuestaria) 2020-2021 (Excel)
$route['rep/rep_requerimientos_ejecucion_servicio/(:any)'] = 'reportes_cns/exporting_datos/rep_ejecucion_requerimientos_servicio/$1'; ///// Imprimir Requerimientos por Servicio (Ejecucion Presupuestaria) 2020-2021

//$route['rep/ver_partida_uni/(:any)'] = 'reportes_cns/exporting_datos/consolidado_partidas_unidad/$1/$2'; ///// Exportar Consolidado de partidas de cada unidad/Establecimiento por REGIONAL
//$route['rep/ver_partida_consolidado_uni/(:any)'] = 'reportes_cns/exporting_datos/consolidado_nacional_partidas_unidad/$1'; ///// Exportar Consolidado Nacional de partidas de cada unidad/Establecimiento por REGIONAL

$route['rep/comparativo_unidad_ppto/(:any)'] = 'reportes_cns/rep_operaciones/comparativo_presupuesto_distrital/$1/$2'; ///// cuadro comparativo pto asig. poa - Partidas por unidad (DISTRITAL) 2020-2021
$route['rep/print_modificaciones_poa/(:any)'] = 'reportes_cns/rep_operaciones/rep_cuadro_modificacion_poa/$1/$2'; ///// cuadro Modificacion poa (DISTRITAL) 2020-2021
$route['rep/comparativo_xsl/(:any)'] = 'reportes_cns/exporting_datos/comparativo_presupuesto_xls/$1/$2'; ///// cuadro comparativo pto asig. poa - Partidas Xcel

$route['rep/print_certificaciones_poa/(:any)'] = 'reportes_cns/rep_operaciones/rep_cuadro_certificaciones_poa/$1/$2'; ///// cuadro Certificaciones poa (DISTRITAL) 2020-2021

///////// PROGRAMACION FISICA FINANCIERA
/*-----------------------------  PROGRAMACION FISICA DEL PROYECTO - COMPONENTES (2020) -------------------------------*/
$route['prog/list_serv/(:any)'] = 'programacion/cservicios/verif_tipo_ope/$1';  //// Listado de Servicios (2020)
$route['admin/prog/subir_archivo_producto'] = 'programacion/cservicios/archivo_productos'; //// Migracion de Operaciones por servicio
$route['prog/delete_operaciones_componente'] = 'programacion/cservicios/elimina_operaciones_componente';	//// Delete servicio y operaciones
$route['prog/des_sactividad'] = 'programacion/cservicios/deshabilitar_sactividad';	//// Deshabilitar servicio


$route['prog/valida_comp'] = 'programacion/cservicios/valida_componente';  //// Valida Componente (PROY INVERSION)
$route['prog/valida_update_comp'] = 'programacion/cservicios/valida_update_componente';  //// Valida update Componente (PROY INVERSION)
$route['prog/delete_operaciones_componente_pi'] = 'programacion/componente/elimina_operaciones_componente_pi';	//// Delete componente y operaciones Actividades PI


/*-------------------  REPORTE DEL POA Programacion - Fisica y Financiera (2020) ------------------*/
$route['prog/presentacion_poa/(:any)'] = 'programacion/creporte/presentacion_poa/$1';  //// Presentacion POA
$route['prog/reporte_datos/(:any)'] = 'programacion/creporte/datos_generales/$1';  //// Identificacion del POA
$route['prog/rep_operaciones/(:any)'] = 'programacion/creporte/programacion_fisica/$1';  //// Programacion Fisica
$route['prog/rep_requerimientos/(:any)'] = 'programacion/creporte/programacion_financiera/$1';  //// Programacion Financiera
$route['proy/orequerimiento_proceso/(:any)'] = 'programacion/creporte/reporte_proyecto_insumo_proceso/$1/$2';  //// Reporte requerimiento por Servicios 2020
$route['proy/ptto_consolidado/(:any)'] = 'programacion/creporte/reporte_presupuesto_consolidado/$1';  //// Reporte requerimiento total Unidad/Establecimiento/Proyecto de Inversion
$route['proy/ptto_consolidado_comparativo/(:any)'] = 'programacion/cppto_comparativo/reporte_presupuesto_consolidado_comparativo/$1';  //// Reporte Comparativo Total de Ppto Unidad/Establecimiento/Proyecto de Inversion




/*-----------------------------  PROGRAMACION DEL PROYECTO - PRODUCTOS  -------------------------------*/
$route['admin/prog/list_prod/(:any)'] = 'programacion/producto/lista_productos/$1';  //// lista de productos (2020)
$route['prog/verif_cod'] = 'programacion/producto/verif_codigo'; ////// verificando codigo Operacion
$route['prog/delete_insumos_servicio/(:any)'] = 'programacion/producto/delete_insumos_servicios/$1';// Eliminar Todas los requerimientos del servicio (2020)
//$route['prog/delete_requerimientos/(:any)'] = 'programacion/producto/delete_requerimientos/$1';// Eliminar Todas los Requerimientos (2020)
$route['admin/prog/valida_upload_prod'] = 'programacion/producto/subir_producto';  //// Subir Archivo Productos txt
$route['admin/prog/plist_prod/(:any)'] = 'programacion/producto/pre_lista_productos/$1/$2/$3/$4/$5';  //// pre lista de Productos
$route['admin/prog/subir_prod/(:any)'] = 'programacion/producto/validar_pre_lista_productos/$1/$2/$3/$4/$5';  //// Validar pre lista de Productos
$route['prog/delete_prod'] = 'programacion/producto/delete_operacion';  //// Eliminar Operaciones - Proyecto Inversion

$route['prog/delete_operaciones'] = 'programacion/producto/delete_operaciones'; //// ELIMINA OPERACIONES SELECCIONADOS
$route['prog/combo_acciones'] = 'programacion/producto/combo_acciones_estrategicos';// COMBO ACCIONES OPERATIVAS
$route['prog/combo_indicadores'] = 'programacion/producto/combo_indicadores_pei';// COMBO ACCIONES INDICADORES DEL PROCESO

$route['admin/prog/new_prod/(:any)'] = 'programacion/producto/new_productos/$1';  //// NUEVA OPERACION
$route['admin/prog/mod_prod/(:any)'] = 'programacion/producto/update_producto/$1';  ////  formulario editado productos 
//$route['admin/prog/delete_prod/(:any)'] = 'programacion/producto/delete_producto/$1/$2/$3/$4/$5'; //// Eliminando el producto
$route['admin/prog/del_prod'] = 'programacion/producto/desactiva_producto';  //// Eliminar Productos - Gasto Operacion
$route['prog/rep_operacion_componente/(:any)'] = 'programacion/producto/reporte_operacion_componente/$1';  //// Reporte Operaciones por componente 2019-2020
$route['prog/exportar_productos/(:any)'] = 'programacion/producto/exportar_productos/$1';  //// Exportar lista de Productos
$route['prog/exportar_productos_req/(:any)'] = 'programacion/producto/exportar_productos_requerimientos/$1';  //// Exportar lista de Productos - Requerimientos

$route['prog/update_codigo/(:any)'] = 'programacion/producto/update_codigo/$1';  //// Actualizar Codigos de Operacion

/*-----------------------------  PROGRAMACION DEL PROYECTO - ACTIVIDADES  -------------------------------*/
$route['prog/list_act/(:any)'] = 'programacion/actividades/lista_actividades/$1';  //// lista de actividades
$route['prog/get_actividad'] = 'programacion/actividades/get_actividad';  //// get actividad
$route['prog/valida_act'] = 'programacion/actividades/valida_actividad';  ///// valida Requerimiento
$route['prog/valida_update_act'] = 'programacion/actividades/valida_update_actividad';  ///// valida update Actividad
$route['prog/delete_act'] = 'programacion/actividades/delete_actividad';	//// Elimina Actividad

$route['prog/reporte_form4/(:any)'] = 'programacion/creporte/reporte_formulario4/$1';  //// Reporte Form 4 / 2021



/*-----------------------------  PROGRAMACION REQUERIMIENTOS (2020) -------------------------------*/
$route['prog/prog_financiera/(:any)'] = 'programacion/crequerimiento/list_componente/$1';  //// Listado de componentes/operacione, segun el tipo de proyecto
$route['prog/requerimiento/(:any)'] = 'programacion/crequerimiento/list_requerimientos/$1/$2';  //// Listado de Requerimientos

$route['prog/combo_partidas'] = 'programacion/crequerimiento/combo_partidas_hijos';// COMBO PARTIDAS HIJOS
$route['prog/combo_umedida'] = 'programacion/crequerimiento/combo_unidad_medida';// COMBO UNIDAD DE MEDIDA

$route['prog/combo_partidas_asig'] = 'programacion/crequerimiento/combo_partidas_hijos_asignados';// COMBO PARTIDAS ASIGNADOS

$route['prog/list_requerimiento/(:any)'] = 'programacion/cajuste_crequerimiento/list_requerimientos_total/$1';  //// Listado de Requerimientos


/* ==================================== MANTENIMIENTO ====================================*/
$route['mnt/prog_p'] = 'mantenimiento/capertura_programatica/main_apertura_programatica_padres';
/*--- Aperturas Programaticas Hijas -----------*/
$route['mnt/aper_prog'] = 'mantenimiento/capertura_programatica/main_apertura_programatica';
$route['mnt/report_aper_prog'] = 'mantenimiento/capertura_programatica/reporte_apertura_programatica'; ///// Reporte
//analisis ver si habra abm de las aperturas
$route['admin/mantenimiento/add_aper'] = 'cmantenimiento/add_aper';
$route['admin/mantenimiento/get_aper'] = 'cmantenimiento/get_aper';
$route['admin/mantenimiento/del_aper'] = 'cmantenimiento/del_aper';
/*-- Carpetas POA --*/
//$route['mnt/poa'] = 'mantenimiento/cpoa';



/*-- Ptto Sipeg (MANTENIMIENTO)--*/
$route['ptto_asig_poa'] = 'mantenimiento/cptto_poa/list_acciones_operativas'; /// Lista de Acciones Operativas
$route['mnt/rep_partidas/(:any)'] = 'mantenimiento/cptto_poa/rep_partida/$1'; /// Reporte Partida
$route['mnt/edit_ptto_asig/(:any)'] = 'mantenimiento/cptto_poa/edit_partidas/$1'; /// Modifica Monto Partida
$route['mnt/delete_partida'] = 'mantenimiento/cptto_poa/delete_partida';	//// Delete Partida
$route['mnt/ver_ptto_asig_final/(:any)'] = 'mantenimiento/cptto_poa/ver_comparativo_partidas/$1'; /// Modifica Monto Partida
$route['mnt/rep_mod_req/(:any)'] = 'mantenimiento/cptto_poa/reporte_comparativo_unidad/$1';///// Reporte Cuadro Comparativo de Partidas Asig-Prog-Final
$route['mnt/xles_partidas/(:any)'] = 'mantenimiento/cptto_poa/exportar_cuadro_comparativo/$1/$2';///// Exportar cuadro Comparativo de Partidas Asig-Prog-Final en Excel

/*-- Control Operativo (MANTENIMIENTO) --*/
$route['control_calidad'] = 'mantenimiento/ccontrol_calidad/control_calidad'; /// Control de Calidad
$route['select_control_calidad/(:any)'] = 'mantenimiento/ccontrol_calidad/select_control_calidad/$1'; /// tipo de Control de Calidad
$route['list_requerimientos'] = 'mantenimiento/ccontrol_calidad/list_requerimientos'; /// Liat de requerimientos
$route['exportar_requerimientos'] = 'mantenimiento/ccontrol_calidad/exportar_requerimientos'; /// Exportar requerimientos - Control de Calidad


//--- DIRECTO - PROGRAMACION DE INSUMOS trabajando/vista

$route['prog/ins/(:any)'] = 'programacion/cprog_insumos/insumos/$1/$2';//--
$route['prog/delete_ins_total/(:any)'] = 'programacion/cprog_insumos/delete_insumo_total/$1';///// Eliminar Insumos total


/// REQUERIMIENTOS A NIVEL DE ACTIVIDADES (2020 - GASTO CORRIENTE)
$route['prog/ins_prod/(:any)'] = 'insumos/cprog_insumo/prog_isumos_prod/$1';//PROGRAMACION DE INSUMOS A NIVEL PRODUCTOS
$route['prog/delete_ins_ope'] = 'insumos/cprog_insumo/delete_get_requerimiento';//// DELETE REQUERIMIENTO 7 ope/act
$route['prog/mod_ins_p/(:any)'] = 'insumos/cprog_insumo/mod_insumo/$1/$2/$3/$4/$5/$6';//MODIFICAR INSUMO A NIVEL PRODUCTO
$route['prog/delete_ins_p/(:any)'] = 'insumos/cprog_insumo/eliminar_insumos/$1/$2';//ELIMINAR INSUMOS DE LA ACTIVIDAD (2020)
//$route['prog/rep_requerimientos_ope/(:any)'] = 'insumos/cprog_insumo/reporte_requerimientos_operacion/$1';//REQUERIMIENTOS DE LA OPERACI&Oacute;N PDF
$route['prog/rep_partidas_ope/(:any)'] = 'insumos/cprog_insumo/reporte_partida/$1';//Consolidado partidas pdf
$route['prog/xcel_partidas_ope/(:any)'] = 'insumos/cprog_insumo/xcel_reporte_partida/$1';//Consolidado partidas Excel
$route['prog/get_requerimiento']='insumos/cprog_insumo/get_requerimiento';// get Requerimiento


//REPORTE - PRESUPUESTO
$route['rep/pres_prog'] = 'reportes/crep_pres_prog';
$route['rep/prog_lproy/(:any)'] = 'reportes/crep_pres_prog/lista_proyectos/$1';
$route['rep/pres_prog_proy/(:any)'] = 'reportes/crep_pres_prog/presupuesto_programado/$1/$2/$3';
$route['rep/pres_ejec'] = 'reportes/crep_pres_ejec';
$route['rep/pres_ejec_lproy/(:any)'] = 'reportes/crep_pres_ejec/lista_proyectos/$1';
$route['rep/pres_ejec_proy/(:any)'] = 'reportes/crep_pres_ejec/presupuesto_ejecutado/$1/$2/$3';
//REPORTE- EVALUACION
$route['rep/eva_institucional'] = 'reportes/crep_eva_institucional';
$route['rep/eva_programacion'] = 'reportes/crep_eva_programacion';
$route['rep/ev_prog/(:any)'] = 'reportes/crep_eva_programacion/evaluacion_programa/$1';

$route['rep/eva_institucional'] = 'reportes/crep_eva_institucional';
$route['rep/eva_programacion'] = 'reportes/crep_eva_programacion';


//ejecucion presupuestaria
$route['rep/ejec_pres'] = 'reportes/cseg_alerta_ejec_pres';//alerta temprana en la ejecucion del presupuesto
$route['rep/ejec_pres/prog'] = 'reportes/cseg_alerta_ejec_pres/nivel_programa';//alerta a nivel programa
$route['rep/ejec_pres/proy/(:any)'] = 'reportes/cseg_alerta_ejec_pres/ejec_pres_proy/$1';//alerta a nivel programa lista de proyectos
$route['rep/ejec_pres/unidad'] = 'reportes/cseg_alerta_ejec_pres/nivel_unidad_ejecutora';//alerta a nivel  UNIDAD EJECUTORA
$route['rep/ejec_pres/uni_proy/(:any)'] = 'reportes/cseg_alerta_ejec_pres/ejec_pres_uni_proy/$1';//alerta a nivel UNIDAD EJECUTORA lista de proyectos
$route['rep/ejec_pres/prov'] = 'reportes/cseg_alerta_ejec_pres/nivel_provincia';//alerta a nivel provincia
$route['rep/ejec_pres/prov/(:any)'] = 'reportes/cseg_alerta_ejec_pres/ejec_pres_nivel_prov_proy/$1';//alerta a nivel provincia lista de proyectos


/*- PONDERACION - COMPONENTES - PRODUCTOS - ACTIVIDADES -*/
$route['proy/update_pcion_comp/(:any)'] = 'programacion/cponderacion/update_ponderacion_proceso/$1';  //// Update Procesos
$route['proy/pcion_comp/(:any)'] = 'programacion/cponderacion/mis_procesos/$1';  //// Mis Procesos
$route['proy/valida_pcion_comp'] = 'programacion/cponderacion/valida_ponderacion_procesos';  //// Valida Ponderacion Componentes
$route['proy/vcion_prod/(:any)'] = 'programacion/cponderacion/exportar_vinculacion_proceso/$1';  //// Excel Vinculacion Estrategica
$route['proy/rep_vcion_prod/(:any)'] = 'programacion/cponderacion/reporte_vinculacion_proceso/$1';  //// Excel Vinculacion Estrategica

$route['proy/pcion_prod/(:any)'] = 'programacion/cponderacion/mis_productos/$1';  //// Ponderar Productos
$route['proy/valida_pcion_prod'] = 'programacion/cponderacion/valida_ponderacion_productos';  //// Valida Ponderacion Productos

$route['proy/pcion_act/(:any)'] = 'programacion/cponderacion/mis_actividades/$1';  //// Ponderar Actividades
$route['proy/valida_pcion_act'] = 'programacion/cponderacion/valida_ponderacion_actividades';  //// Valida Ponderacion Actividades

$route['proy/rep_vinculario_uorganizacional/(:any)'] = 'programacion/cponderacion/reporte_vinculacion_uorganizacional/$1';  //// Valida Ponderacion Actividades

/*- PONDERACION - OPERACIONES -*/
$route['proy/pcion_operacion/(:any)'] = 'programacion/cponderacion/update_ponderacion_operacion/$1';  //// Update Ponderacion Operaciones
$route['prog/pond_prog'] = 'programacion/cponderacion/update_ponderacion_programa';  //// Update Ponderacion Programas


/*--------------------------------- TECNICO DE PLANIFICACION -------------------------------*/
//$route['admin/proy/operacion/(:any)'] = 'programacion/proyecto/get_operacion/$1/$2';  //// lista de la operacion especifica
$route['proy/orequerimiento/(:any)'] = 'programacion/cprog_insumos/reporte_proyecto_insumo/$1';  //// Operacion requerimiento
$route['proy/orequerimiento_total/(:any)'] = 'programacion/cprog_insumos/reporte_proyecto_total/$1/$2';  //// Reporte Operacion requerimiento total
//$route['proy/proceso_productos/(:any)'] = 'programacion/componente/reporte_proceso_producto_actividad/$1/$2';  //// Reporte Procesos-Productos
$route['proy/proceso_productos_consolidado/(:any)'] = 'programacion/componente/reporte_consolidado_operaciones_componentes/$1';  //// Reporte Procesos-Operaciones Consolidado TOTAL

/*---- REGISTRO PROGRAMACION UNIDAD ORGANIZACIONAL (2020) -----*/
$route['prog/unidad'] = 'programacion/cunidad_organizacional/list_unidad'; //// lista Unidad Organizacional
$route['prog/datos_unidad/(:any)'] = 'programacion/cunidad_organizacional/formulario/$1'; //// formulario de datos de la unidad
$route['prog/combo_ubicacion'] = 'programacion/cunidad_organizacional/combo_ubicacion'; ///// Lista de Municipios
$route['prog/rep_datos_unidad/(:any)'] = 'programacion/cunidad_organizacional/reporte_datos_unidad/$1'; //// Reporte Datos Unidad

$route['prog/rep_list_establecimientos/(:any)'] = 'programacion/cunidad_organizacional/rep_list_establecimientos/$1'; //// lista de Establecimientos Habilitados por Regional
$route['prog/rep_consolidado_establecimientos'] = 'programacion/cunidad_organizacional/rep_consolidado_establecimientos'; //// lista Consolidado de Establecimientos PDF
$route['prog/rep_consolidado_establecimientos_xls'] = 'programacion/cunidad_organizacional/rep_consolidado_establecimientos_xls'; //// lista Consolidado de Establecimientos EXCEL

$route['prog/c_servicio'] = 'programacion/cunidad_organizacional/list_scompra'; //// lista Servicio de Compra
$route['prog/rep_list_cservicio/(:any)'] = 'programacion/cunidad_organizacional/rep_list_cservicio/$1'; //// lista de Compra de Servicios
$route['prog/rep_consolidado_cservicio'] = 'programacion/cunidad_organizacional/rep_consolidado_cservicio'; //// lista Consolidado de Establecimientos PDF
$route['prog/rep_consolidado_cservicio_xls'] = 'programacion/cunidad_organizacional/rep_consolidado_cservicio_xls'; //// lista Consolidado de Establecimientos EXCEL

$route['proy/verif_plantillas'] = 'insumos/cprog_insumo/verificar_plantilla'; ////// Verificar plantillas de migraci??n

/*-----------------------------  FASES  DEL PROYECTO -------------------------------*/
$route['admin/proy/fase_etapa/(:any)'] = 'programacion/faseetapa/list_fase_etapa/$1';  //// lista fase etapas  - proy_id
$route['admin/proy/newfase/(:any)'] = 'programacion/faseetapa/nueva_fase/$1';  //// nueva fase
$route['admin/proy/fase_ptto/(:any)'] = 'programacion/faseetapa/fase_presupuesto/$1';  //// nueva fase presupuesto
//$route['admin/proy/add_fe'] = 'programacion/faseetapa/add_fase';  //// valida1 fase/etapa
$route['admin/proy/add_fe2'] = 'programacion/faseetapa/add_fase2';  //// valida2 fase/etapa
$route['admin/proy/update_f/(:any)'] = 'programacion/faseetapa/modificar_fase/$1';  //// opcion Modificar Fase
$route['admin/proy/fase_update'] = 'programacion/faseetapa/update_fase_etapa';  //// Modificar Fase (controlador)
$route['admin/proy/off'] = 'programacion/faseetapa/encender_fase';  //// Encender Fase
$route['admin/proy/verif_fase'] = 'programacion/faseetapa/verif_fase'; //// Verificando las dependencia de la fase
$route['admin/proy/delete_fase'] = 'programacion/faseetapa/delete_fase'; //// Eliminando Fase Etapa
$route['admin/proy/get_fase'] = 'programacion/faseetapa/get_fase_activa';  //// Obitne datos de la fase para los indicadores de desemepenio
$route['admin/proy/add_indi'] = 'programacion/faseetapa/add_indicador';  //// Obitne datos de la fase para los indicadores de desemepenio
$route['admin/proy/asig_ptto/(:any)'] = 'programacion/faseetapa/asignar_presupuesto/$1'; ////// Asigan Presupuesto de la gestion vigente a la fase activa
$route['admin/proy/add_ptto'] = 'programacion/faseetapa/add_techo_presupuesto';  //// valida techo presupuestario
$route['admin/proy/ver_techo_ptto/(:any)'] = 'programacion/faseetapa/ver_techo_ptto/$1/$2';  //// ver techo presupuestario de la fase
$route['admin/proy/get_techo'] = 'programacion/faseetapa/get_techo_ptto';  //// recupera datos del techo presupuesto x

$route['admin/proy/update_techo'] = 'programacion/faseetapa/update_techo_ptto';  //// Update datos del techo presupuesto x

$route['admin/proy/actualiza_techo_ptto'] = 'programacion/faseetapa/valida_techo_ptto';  //// ver techo presupuestario de la fase (Actualizando lo ultimo)
$route['admin/proy/delete_recurso/(:any)'] = 'programacion/faseetapa/delete_recurso/$1/$2/$3/$4';  //// Delete datos del techo presupuesto recurso x (Borrar)

$route['proy/get_faseetapa'] = 'programacion/faseetapa/obtiene_faseetapa'; /// Get Fase Activa Proyecto
$route['proy/valida_ptto'] = 'programacion/faseetapa/valida_presupuesto';  ///// valida presupuesto fase
$route['proy/add_ptto_techo'] = 'programacion/faseetapa/validar_techo_ptto';  //// Validar datos del techo presupuesto
$route['proy/delete_asignacion'] = 'programacion/faseetapa/delete_asignacion';  //// Delete asignacion presupuestaria


/*---------- EVALUACION DE LA OPERACION 2020 (GASTO CORRIENTE) ----------*/
$route['eval/mis_operaciones'] = 'ejecucion/cevaluacion/operaciones_aprobadas';  ///// lista de operaciones aprobadas
$route['eval/eval_productos/(:any)'] = 'ejecucion/cevaluacion/mi_evaluacion/$1';  ///// Evaluar Gasto Corriente-Proyecto de Inversion
$route['eval/eval_gcorriente/(:any)'] = 'ejecucion/cevaluacion/evaluar_gastocorriente/$1';  ///// Evaluar Operaciones - Gasto Corriente

$route['eval/rep_eval_productos/(:any)'] = 'ejecucion/cevaluacion/reporte_evaluar_operaciones/$1';  ///// Reporte Evaluacion Productos 2020
$route['eval/rep_eval_productos_consolidado/(:any)'] = 'ejecucion/cevaluacion/reporte_evaluar_operaciones_consolidado/$1';  ///// Reporte Evaluacion Productos Consolidado 2020
$route['eval/reformular/(:any)'] = 'ejecucion/cevaluacion/reformular_evaluacion/$1';  /// REFORMULAR EVALUACION POA

$route['eval/get_productos'] = 'ejecucion/cevaluacion/get_productos'; ///// Get Producto para la Evaluacion
$route['eval/get_mod_productos'] = 'ejecucion/cevaluacion/get_mod_productos'; ///// Get Producto para la Modificacion Evaluacion
$route['eval/valida_eval_prod'] = 'ejecucion/cevaluacion/valida_evaluacion_producto'; ///// valida evaluacion Producto
$route['eval/valida_meval_prod'] = 'ejecucion/cevaluacion/valida_mod_evaluar_productos';  ///// valida mod Evaluar Productos
$route['eval/update_trimestre'] = 'ejecucion/cevaluacion/valida_update_trimestre';  ///// valida update trimestre

$route['eval/get_actividad'] = 'ejecucion/cevaluacion/get_actividad'; ///// Get Actividad
$route['eval/get_mod_actividad'] = 'ejecucion/cevaluacion/get_mod_actividad'; ///// Get actividad para la Modificacion Evaluacion
$route['eval/valida_eval_act'] = 'ejecucion/cevaluacion/valida_evaluacion_actividad'; ///// valida evaluacion Actividad
$route['eval/valida_meval_act'] = 'ejecucion/cevaluacion/valida_mod_evaluar_actividad';  ///// valida mod Evaluar Actividad

/*---------- EVALUACION DE LA OPERACION 2020 (PROYECTO DE INVERSI??N) ----------*/
$route['eval/eval_pinversion/(:any)'] = 'ejecucion/cevaluacion_pi/evaluar_proyectoinversion/$1';  ///// Evaluar Operaciones - Proyecto de Inversi??n


/*--- SEGUIMIENTO POA (GASTO CORRIENTE-PROYECTO DE INVERSION 2021) ---*/
$route['seg/seguimiento_poa'] = 'ejecucion/cseguimiento/lista_poa'; ///// lista de operaciones aprobadas
$route['seg/tipo_seguimiento/(:any)'] = 'ejecucion/cseguimiento/tipo_seguimiento_poa/$1'; ///// Tipo de seguimiento POA
$route['seg/formulario_seguimiento_poa/(:any)'] = 'ejecucion/cseguimiento/formulario_segpoa/$1'; ///// formulario de seguimiento
$route['seg/ver_seguimientopoa/(:any)'] = 'ejecucion/cseguimiento/ver_evaluacion_poa/$1'; ///// Ver Evaluacion POA
$route['seg/ver_reporte_evaluacionpoa/(:any)'] = 'ejecucion/cseguimiento/ver_reporteevalpoa/$1'; ///// Ver Reporte Evaluacion POA Mensual
$route['seg/ver_reporte_evaluacionpoa_consolidado/(:any)'] = 'ejecucion/cseguimiento/ver_reporteevalpoa_consolidado/$1'; ///// Ver Reporte Evaluacion POA Consolidado de todos los meses

$route['seg/notificacion_operaciones_mensual/(:any)'] = 'ejecucion/cseguimiento/reporte_notificacion_operaciones_mensual/$1'; ///// Reporte Notificacion Seguimiento POA Mensual

/*--- SEGUIMIENTO EVALUACION POA (GASTO CORRIENTE-PROYECTO DE INVERSION 2021) ---*/
$route['evalpoa/formulario_evaluacion_poa/(:any)'] = 'ejecucion/cevaluacion_poa/formulario_evaluacionpoa/$1'; ///// formulario de Evaluacion POA


//====== REPORTE EVALUACION POA 2020
/*---------- EVALUACION DE LA OPERACION INSITUCIONAL - MENU (GASTO CORRIENTE) 2020 ----------*/
$route['menu_eval_poa'] = 'reporte_evaluacion/crep_evalinstitucional/menu_eval_poa';  /// MENU EVALUACION POA 
$route['rep_eval_poa/evaluacion_poa/(:any)'] = 'reporte_evaluacion/crep_evalinstitucional/evaluacion_poa/$1/$2';  /// REPORTES GRAFICOS REGIONAL, DISTRITAL
$route['rep_eval_poa/evaluacion_poa_onacional/(:any)'] = 'reporte_evaluacion/crep_evalofinacional/evaluacion_poa_onacional/$1';  /// REPORTES GRAFICOS OFICINA NACIONAL
$route['rep_eval_poa/rep_eficacia/(:any)'] = 'reporte_evaluacion/crep_evalinstitucional/reporte_eficacia/$1/$2';  /// REPORTE EVALUACION GASTO CORRIENTE

/*---------- EVALUACION DE LA OPERACION - UNIDAD, PROYECTO ----------*/
$route['eval/eval_unidad/(:any)'] = 'reporte_evaluacion/crep_evalunidad/evaluacion_poa_unidad/$1';  /// REDIRECCION EVALUACION POA - UNIDAD, PROY INV.
$route['eval/eval_unidad_gcorriente/(:any)'] = 'reporte_evaluacion/crep_evalunidad/evaluacion_unidad_gcorriente/$1';  /// REPORTES GRAFICOS DE EVALUACION GASTO CORRIENTE
$route['eval/eval_unidad_pinversion/(:any)'] = 'reporte_evaluacion/crep_evalunidadpi/evaluacion_unidad_pinversion/$1';  /// REPORTES GRAFICOS DE EVALUACION PROYECTO DE INVERSI??N




/*---------- EVALUACION DE LA OPERACION INSITUCIONAL - MENU (PROYECTOS DE INVERSION) 2020 ----------*/
$route['menu_eval_pi'] = 'reporte_evaluacion/crep_evalinstitucionalpi/menu_eval_poa';  /// MENU EVALUACION POA PROYECTO DE INVERSION
$route['rep_eval_poa/evaluacion_pi/(:any)'] = 'reporte_evaluacion/crep_evalinstitucionalpi/evaluacion_pi/$1/$2';  /// REPORTES GRAFICOS REGIONAL, DISTRITAL
$route['rep_eval_poa/rep_eficacia_pi/(:any)'] = 'reporte_evaluacion/crep_evalinstitucionalpi/reporte_eficacia_pi/$1/$2';  /// REPORTES EFICACIA-EFICIENCIA REGIONAL, DISTRITAL


/*---------- EVALUACION GASTO CORRIENTE - PROGRAMA ----------*/
$route['menu_eval_prog'] = 'reporte_evaluacion/crep_evalprogramas/menu_eval_programas';  /// MENU EVALUACION PROGRAMA 
$route['rep_eval_prog/evaluacion_programas/(:any)'] = 'reporte_evaluacion/crep_evalprogramas/evaluacion_programas/$1/$2';  /// REPORTES GRAFICOS REGIONAL


//====== REPORTE EVALUACION OBJETIVOS DE GESTION 2020
/*---------- EVALUACION DE OBJETIVOS DE GESTION 2020 ----------*/
$route['menu_eval_objetivos'] = 'reporte_evalobjetivos/crep_evalobjetivos/menu_eval_objetivos';  /// MENU EVALUACION OBJETIVOS 
$route['rep_eval_obj/evaluacion_objetivos/(:any)'] = 'reporte_evalobjetivos/crep_evalobjetivos/evaluacion_objetivos/$1';  /// REPORTES GRAFICOS REGIONAL




/*--------- EJECUCION - CERTIFICACION POA (TUE) 2019 -----------*/
$route['ejec/menu_cpoa'] = 'ejecucion/cert_poa/menu_certificacion_poa'; //// Menu Tecnico de Unidad Ejecutora
$route['ejec/cpoa/(:any)'] = 'ejecucion/cert_poa/list_certificados_poa/$1'; //// Lista de Certificados POA solicitados, aprobados
$route['ejec/generar_cpoa'] = 'ejecucion/cert_poa/cpoa_lista_programas'; //// Lista de Operaciones
$route['ejec/proceso/(:any)'] = 'ejecucion/cert_poa/procesos_operacion/$1/$2'; //// Procesos de la Operacion
$route['ejec/cpoa_requerimiento/(:any)'] = 'ejecucion/cert_poa/cpoa_operacion_requerimiento_prod/$1/$2/$3'; //// Certificados POA Requerimientos a nivel de productos
$route['ejec/valida_cpoa_requerimiento'] = 'ejecucion/cert_poa/valida_cpoa_operacion_requerimiento'; //// Valida Certificacion POA
$route['ejec/mod_certificacion/(:any)'] = 'ejecucion/cert_poa/modificar_certificacion/$1/$2/$3/$4'; //// Modificar Certificacion POA
$route['ejec/valida_update_cpoa_requerimiento'] = 'ejecucion/cert_poa/valida_update_cpoa_operacion_requerimiento'; //// Valida Update Certificacion POA
$route['ejec/ver_certificado_poa/(:any)'] = 'ejecucion/cert_poa/ver_reporte_certificado_poa/$1/$2/$3'; //// Iframe reporte Certificado POA
$route['ejec/certificado_poa/(:any)'] = 'ejecucion/cert_poa/reporte_certificado_poa/$1'; //// reporte Certificado POA
$route['ejec/certificado_poa_antiguo/(:any)'] = 'ejecucion/cert_poa/reporte_certificado_poa_antiguo/$1'; //// reporte Certificado POA Antiguo
$route['ejec/validar_cert'] = 'ejecucion/cert_poa/validar_certificacion';  //// Valida para la certificacion POA
$route['ejec/get_requerimiento'] = 'ejecucion/cert_poa/get_requerimiento';  //// recupera datos del requerimiento

$route['ejec/valida_update_reqnocertificados'] = 'ejecucion/cert_poa/valida_update_req_nocertificados'; //// Valida Update Requerimientos no Certificados

$route['ejec/mis_operaciones'] = 'ejecucion/cert_poa/list_operaciones'; //// Lista de Operaciones
$route['ejec/list_req_cert/(:any)'] = 'ejecucion/cert_poa/list_req_cert/$1'; //// Lista requerimientos Certificados
$route['ejec/rep_cert_partidas/(:any)'] = 'ejecucion/cert_poa/cuadro_partidas_certificados/$1'; //// Lista Certificados Generados

$route['ejec/get_uadministrativas'] = 'ejecucion/cert_poa/get_unidades_administrativas'; ////// Combo Unidades Administrativas

/*-- EVALUACION PEI - OBJETIVOS REGIONALES 2020 ---*/
$route['eval_obj/objetivos_regionales'] = 'ejecucion/cevaluacion_pei/objetivos_regionales';  ///// Objetivos Estrategicos
$route['eval_obj/rep_meta_oregional/(:any)'] = 'ejecucion/cevaluacion_pei/reporte_meta_oregional/$1'; //// Reporte Meta Objetivo Regional
$route['eval_obj/rep_meta_oregional_grafico/(:any)'] = 'ejecucion/cevaluacion_pei/cuadro_evaluacion_grafico/$1'; //// Reporte Meta Objetivo Regional Grafico


/*--FORM. CERT---*/
$route['ejec/valida_cpoa1'] = 'ejecucion/cert_poa/valida_cpoa_operacion_requerimiento_form1'; //// Valida Certificacion POA Form1
$route['ejec/cert_poa_form2/(:any)'] = 'ejecucion/cert_poa/formulario_cpoa2/$1/$2/$3'; //// Formulario 2 - Cert POA
$route['ejec/certifica'] = 'ejecucion/cert_poa/valida_cpoa_operacion_requerimiento_certifica'; //// Valida Certificacion POA Form1
/*--------------*/

/*-- CERTIFICACI??N POA 2020 ---*/
$route['cert/list_poas'] = 'ejecucion/ccertificacion_poa/list_poas_aprobados'; //// Lista POA Aprobados 2020
$route['cert/form_items/(:any)'] = 'ejecucion/ccertificacion_poa/list_items_cert/$1'; //// Lista Items a Certificar 2020
$route['cert/ver_cpoa/(:any)'] = 'ejecucion/ccertificacion_poa/ver_certificacion_poa/$1'; //// Ver Certificacion POA 2020
$route['cert/rep_cert_poa/(:any)'] = 'ejecucion/ccertificacion_poa/reporte_cpoa/$1'; //// reporte Certificado POA 2020
$route['cert/generar_codigo/(:any)'] = 'ejecucion/ccertificacion_poa/generar_codigo/$1'; //// Generar Codigo Cert POA 2020
$route['cert/eliminar_certificacion/(:any)'] = 'ejecucion/cert_poa/eliminar_certificacion/$1'; //// Eliminar Certificacion POA

/*-- EDICION DE CERTIFICACI??N POA 2020 ---*/
$route['cert/edit_certificacion/(:any)'] = 'ejecucion/ccertificacion_poa/modificar_cpoa/$1'; //// Generar Codigo Cert POA 2020
//$route['cert/reporte_cpoa_delete/(:any)'] = 'ejecucion/ccertificacion_poa/reporte_cpoa_delete/$1'; //// reporte Certificado (Eliminados) POA 2020

/*-- NOTIFICACION POA 2020 ---*/
$route['ejec/notificacion_poa'] = 'ejecucion/cnotificacion_poa/list_poas_aprobados'; //// Lista POA Aprobados
$route['ejec/ver_notificacion/(:any)'] = 'ejecucion/cnotificacion_poa/lista_requerimientos_notificados_servicio/$1'; //// Lista Requerimientos Notificados-Servicio
$route['ejec/ver_notificacion_unidad/(:any)'] = 'ejecucion/cnotificacion_poa/lista_requerimientos_notificados_unidad/$1'; //// Lista Requerimientos Notificados-Unidad



/*----------------------------- EJECUCION - CERTIFICACION POA (POA) -------------------------------*/
$route['ejec/menu_vpoa'] = 'ejecucion/cert_poa/menu_certificaciones'; //// Certificaciones poas VPOA
$route['ejec/rechazar_cert'] = 'ejecucion/cert_poa/rechazar_certificacion';  //// Valida para recchazar la certificacion POA
//$route['ejec/delete_cert'] = 'ejecucion/cert_poa/eliminar_certificacion';  //// Eliminar la certificacion POA

$route['ejec/anular_ref/(:any)'] = 'ejecucion/cert_poa/anular_reformulado/$1';  //// Anular Reformulado
$route['ejec/verificar_reformulacion/(:any)'] = 'ejecucion/cert_poa/ver_requerimientos_nocertificados/$1';  //// Verificar Reformulado

$route['ejec/detalle_ediciones'] = 'ejecucion/cert_poa/reporte_ediciones_cpoas'; //// Reporte Consolidado de ediciones al POA

/*------------ MODIFICACIONES DE OPERACIONES (ULTIMO)--------------*/
$route['mod/ope_aprobadas'] = 'modificaciones/cmodificaciones/operaciones_aprobadas';  ///// lista de operaciones aprobadas
$route['mod/derivar_operacion'] = 'modificaciones/cmodificaciones/derivar_operacion';  ///// derivar Operacion a TOP
$route['mod/list_top'] = 'modificaciones/cmodificaciones/list_poas_aprobados';  ///// Lista de POas Aprobados

$route['mod/list_cites/(:any)'] = 'modificaciones/cmodificaciones/lista_cites/$1';  ///// Lista de Modificaciones POA 

//$route['mod/cites_mod/(:any)'] = 'modificaciones/cmodificaciones/cites_modificacion/$1/$2';  ///// Lista de Cites Generados
//$route['mod/cites_mod_ope/(:any)'] = 'modificaciones/cmodificaciones/update_cites_operacion/$1';  ///// Lista de Cites Generados para editar

/*------------- Modificar Requerimientos (2019)------------*/
$route['mod/cite_modificacion'] = 'modificaciones/cmod_requerimientos/valida_cite_modificacion'; //// Valida Cite Modificacion

//$route['mod/procesos/(:any)'] = 'modificaciones/cmod_requerimientos/procesos/$1'; //// Procesos de la operacion Institucional
$route['mod/mod_requerimiento/(:any)'] = 'modificaciones/cmod_requerimientos/requerimientos/$1/$2/$3'; //// Lista de Requerimientos
$route['mod/update_requerimiento/(:any)'] = 'modificaciones/cmod_requerimientos/update_requerimiento/$1/$2/$3/$4'; //// Update Requerimiento
$route['mod/valida_update_requerimiento'] = 'modificaciones/cmod_requerimientos/valida_update_requerimiento'; //// Valida Update Requerimiento
$route['mod/update_temporalizacion/(:any)'] = 'modificaciones/cmod_requerimientos/update_temporalizacion/$1/$2/$3/$4/$5'; //// Update Temporalizacion
$route['mod/valida_update_temporalizacion'] = 'modificaciones/cmod_requerimientos/valida_update_temporalizacion'; //// Valida Update Temporalizacion
$route['mod/temporalizacion/(:any)'] = 'modificaciones/cmod_requerimientos/temporalizacion/$1/$2/$3/$4'; //// Pasar a Temporalizacion

$route['mod/add_requerimiento/(:any)'] = 'modificaciones/cmod_requerimientos/add_requerimiento/$1/$2/$3/$4'; //// Agrega Requerimiento
$route['mod/add_temporalidad/(:any)'] = 'modificaciones/cmod_requerimientos/add_temporalidad/$1/$2/$3/$4'; //// Agrega Temporalidad

$route['mod/delete_requerimiento'] = 'modificaciones/cmod_requerimientos/delete_requerimiento'; //// Elimina Requerimiento
$route['mod/cites_mod_ins/(:any)'] = 'modificaciones/cmodificaciones/update_cites_requerimientos/$1';  ///// Lista de Cites Generados para editar Insumos
$route['mod/quitar_requerimiento'] = 'modificaciones/cmodificaciones/quitar_requerimiento'; //// Quitar Requerimiento del Cite
$route['mod/delete_requerimientos'] = 'modificaciones/cmod_requerimientos/delete_requerimientos'; //// Elimina Requerimientos en conjunto
$route['mod/cuadro_comparativo/(:any)'] = 'modificaciones/cmod_requerimientos/cuadro_comparativo/$1'; //// Cuadro Comparativo por Partidas
$route['mod/get_requerimiento']='modificaciones/cmod_requerimientos/get_requerimiento';// get Requerimiento Modificacion

$route['mod/revertir_mod/(:any)'] = 'modificaciones/cmodificaciones/revertir_ediciones/$1/$2/$3'; ///// Revertir Adicion, Modificacion - eliminacion

$route['mod/get_montop']='modificaciones/cmod_requerimientos/get_monto_partida';// get Monto Partida
$route['mod/del_ins/(:any)'] = 'modificaciones/cmod_requerimientos/elimina_requerimientos_producto_actividad/$1/$2'; //// Elimina Requerimientos por producto-Actividad (2019)

/*------- Modificar Techo - Partidas Asignadas -------*/
$route['mod/cite_techo/(:any)'] = 'modificaciones/cmod_requerimientos/cite_techo/$1'; //// Cite Techo 
$route['mod/techo/(:any)'] = 'modificaciones/cmod_requerimientos/techo/$1'; //// Modificar Techo
$route['mod/rep_mod_req/(:any)'] = 'modificaciones/cmod_requerimientos/reporte_modificacion/$1/$2';  ///// Reporte Modificaciones Requerimientos 2019
$route['mod/rep_mod_techo/(:any)'] = 'modificaciones/cmod_requerimientos/reporte_techo/$1';  ///// Reporte Modificaciones Techo 2019
//$route['mod/techo/(:any)'] = 'modificaciones/cmod_requerimientos/techo/$1'; //// Ver Modificacion de  Techo

/*---- MODIFICACI??N PRESUPUESTARIA 202-2021 -----*/
$route['mod_ppto/list_mod_ppto'] = 'modificaciones/cmod_presupuestario/lista_mod_ppto'; //// Valida Cite Modificacion Presupuestaria
$route['mod_ppto/delete_mod_ppto'] = 'modificaciones/cmod_presupuestario/delete_modificacion_presupuestaria';//// Elimina Modificacion Presupuestaria
$route['mod_ppto/rep_mod_ppto/(:any)'] = 'modificaciones/cmod_presupuestario/reporte_mod_ppto/$1'; //// Reporte Modificacion Presupuestaria
$route['mod_ppto/ver_partidas_mod/(:any)'] = 'modificaciones/cmod_presupuestario/partidas_modificadas/$1'; //// Reporte Modificacion Presupuestaria



/*------------- MODIFICAR REQUERIMIENTOS (2020)------------*/
$route['mod/procesos/(:any)'] = 'modificaciones/cmod_insumo/cite_servicios/$1'; //// Lista cite de Servicios 
$route['mod/list_requerimientos/(:any)'] = 'modificaciones/cmod_insumo/mis_requerimientos/$1'; //// Lista de Requerimientos
$route['mod/del_select_ins/(:any)'] = 'modificaciones/cmod_insumo/elimina_requerimientos_producto_actividad/$1'; //// Elimina Requerimientos Seleccionados (2020)
$route['mod/rep_mod_financiera/(:any)'] = 'modificaciones/cmod_insumo/reporte_modificacion_financiera/$1';  ///// Reporte Modificaciones Financiera 2020
$route['mod/update_cite/(:any)'] = 'modificaciones/cmod_insumo/modificar_cite/$1';  ///// Modificar Cite 
$route['mod/ver_mod_poa/(:any)'] = 'modificaciones/cmod_insumo/ver_modificacion_poa/$1';  ///// Ver Modificacion POA

/*------------- MODIFICAR OPERACIONES (2020-2021)------------*/
$route['mod/list_componentes/(:any)'] = 'modificaciones/cmod_fisica/mis_subactividades/$1'; //// Lista de Subactividades 2020-2021
$route['mod/lista_operaciones/(:any)'] = 'modificaciones/cmod_fisica/list_operaciones/$1'; //// la lista de operaciones 2020
$route['mod/update_ope/(:any)'] = 'modificaciones/cmod_fisica/update_operacion/$1/$2'; //// 
$route['mod/update_codigo/(:any)'] = 'modificaciones/cmod_fisica/update_codigo/$1';  //// Actualizar Codigos de Operacion
$route['mod/reporte_modfis/(:any)'] = 'modificaciones/cmod_fisica/reporte_modificacion_fisica/$1';  ///// Reporte de Modificacion Fisica
$route['mod/ver_mod_poa_fis/(:any)'] = 'modificaciones/cmod_fisica/ver_modificacion_poa/$1';  ///// Ver Modificacion POA (FIS)

/*------------- Modificar Productos (2019) -----------------*/
/*$route['admin/mod/modificar'] = 'modificaciones/cmodificaciones/modificar'; //// modificar Operacion 

$route['admin/mod/cite_operacion/(:any)'] = 'modificaciones/cmodificaciones/cite_operacion/$1'; //// Cite Operacion
$route['mod/cite_modificacion_ope'] = 'modificaciones/cmodificaciones/valida_cite_operacion'; //// Cite Valida Operacion 2018
$route['mod/cite_ope_modificacion'] = 'modificaciones/cmodificaciones/valida_operacion_cite'; //// Cite Valida Operacion 2019
$route['admin/mod/proyecto_mod/(:any)'] = 'modificaciones/cmodificaciones/redireccionar_modicacion/$1/$2'; //// redireccionar al tipo de formulario 2018

$route['admin/mod/add_producto/(:any)'] = 'modificaciones/cmodificaciones/add_producto/$1/$2/$3'; //// Agregar producto 
$route['admin/mod/valida_add'] = 'modificaciones/cmodificaciones/valida_add_producto'; //// valida Add producto
$route['admin/mod/producto/(:any)'] = 'modificaciones/cmodificaciones/modificar_producto/$1/$2/$3'; //// modificar producto 
$route['admin/mod/valida_mp'] = 'modificaciones/cmodificaciones/valida_producto'; //// valida modificacion producto
$route['mod/delete_producto'] = 'modificaciones/cmodificaciones/delete_producto'; //// Elimina Producto
$route['mod/quitar_producto'] = 'modificaciones/cmodificaciones/quitar_producto'; //// Quitar Producto del Cite

//$route['mod/list_componentes/(:any)'] = 'modificaciones/cmodificaciones/mis_componentes/$1'; //// Lista de Operaciones 2019
$route['mod/list_operaciones/(:any)'] = 'modificaciones/cmodificaciones/redireccionar_operaciones/$1/$2'; //// redireccionar la lista de operaciones 2019
$route['mod/new_prod/(:any)'] = 'modificaciones/cmodificaciones/new_producto/$1/$2'; //// Nuevo Registro Productos 2019
$route['mod/mod_prod/(:any)'] = 'modificaciones/cmodificaciones/update_producto/$1/$2'; //// Modificar Productos 2019

$route['mod/list_act/(:any)'] = 'modificaciones/cmodificaciones/mis_actividades/$1/$2';  //// lista de actividades 2019


$route['mod/mod_techo'] = 'modificaciones/cmodificaciones/modificar_techo'; //// Modificar Techo Presupuetario

$route['admin/mod/add_actividad/(:any)'] = 'modificaciones/cmodificaciones/add_actividad/$1/$2/$3/$4'; //// Agregar Actividad
$route['admin/mod/actividad/(:any)'] = 'modificaciones/cmodificaciones/modificar_actividad/$1/$2/$3'; //// modificar producto 
$route['admin/mod/valida_ma'] = 'modificaciones/cmodificaciones/valida_actividad'; //// valida modificacion actividad
$route['mod/delete_actividad'] = 'modificaciones/cmodificaciones/delete_actividad'; //// Elimina Actividad
$route['mod/quitar_actividad'] = 'modificaciones/cmodificaciones/quitar_actividad'; //// Quitar Actividad

$route['admin/mod/valida_plazo'] = 'modificaciones/cmodificaciones/valida_plazo'; //// valida modificacion plazo de ejecucion
$route['admin/mod/valida_pr'] = 'modificaciones/cmodificaciones/valida_presupuesto'; //// valida modificacion presupuesto*/


$route['mod/modificaciones'] = 'modificaciones/crep_modificaciones/menu_modificaciones'; //// Menu Reporte Modificaciones
$route['mod/valida_busqueda_nacional'] = 'modificaciones/crep_modificaciones/valida_busqueda_nacional'; //// Valida Busqueda Nacional
$route['mod/rep_modificaciones_onacional/(:any)'] = 'modificaciones/crep_modificaciones/reportes_modificaciones_onacional/$1/$2/$3';  ///// Reporte Lista de Modificaciones Of. Nacional
$route['mod/valida_busqueda'] = 'modificaciones/crep_modificaciones/valida_busqueda_regional'; //// Valida Busqueda Regional
$route['mod/rep_modificaciones/(:any)'] = 'modificaciones/crep_modificaciones/reportes_modificaciones_regionales/$1/$2/$3';  ///// Reporte Lista de Modificaciones

$route['mod/rep_consolidado'] = 'modificaciones/crep_modificaciones/reporte_consolidado';  ///// Reporte Consolidado de Modificaciones al POA

/*------------- Consolidado Modificaciones en Excel (2021) -----------------*/
$route['mod/consolidado_mod_requerimiento/(:any)'] = 'modificaciones/crep_modificaciones/consolidado_xls_requerimientos/$1'; //// Consolidado XLS Requerimientos





//========================    REPORTES    ==================================



//============================  SEGUIMIENTO OBJETIVO DE GESTION
/*$route['admin/seg/mo'] = 'reportes/seguimiento/seg_menu_ogestion';
$route['admin/seg/og/(:any)'] = 'reportes/seguimiento/seg_por_prog/$1';//seguimiento por programas
$route['admin/seg/obje_gestion/(:any)'] = 'reportes/seguimiento/seg_por_ogestion/$1'; //seguimiento por objetivo de gestion
$route['admin/seg/inst'] = 'reportes/seguimiento/seg_pe_institucion'; //seguimiento por institucion
//============================  SEGUIMIENTO PRODUCTO TERMINAL
$route['admin/seg/mpt'] = 'reportes/seguimiento/seg_menu_pt';
$route['admin/seg/pe_pt'] = 'reportes/seguimiento/seg_pe_pt';
$route['admin/seg/o_pt/(:any)'] = 'reportes/seguimiento/seg_ogestion_productot/$1';
$route['admin/seg/pt/(:any)'] = 'reportes/seguimiento/seg_por_pt/$1/$2'; //seguimiento por producto terminal
$route['admin/seg/n_o/(:any)'] = 'reportes/seguimiento/nivel_ogestion/$1';//seguimiento a nivel objetivo de gestion
$route['admin/seg/gopt/(:any)'] = 'reportes/seguimiento/grafico_por_gestionpt/$1/$2';//grafico nivel de objetivo de gestion producto terminal
$route['admin/seg/prog_pt/(:any)'] = 'reportes/seguimiento/nivel_programa_pt/$1';//seguimiento a nivel programas
$route['admin/seg/inst_pt'] = 'reportes/seguimiento/nivel_institucion_pt';//seguimiento a nivel institucion
//=========================== SEGUIMIENTO PRODUCTO DE LA OPERACION
$route['admin/seg/mop'] = 'reportes/seguimiento/menu_producto_operacion';//MENU de seguimiento producto de la opracion
$route['admin/seg/mop1'] = 'reportes/seguimiento/seg_menu_operacion';//seguimiento producto de la opracion por prog y ejec
$route['admin/seg/mop2'] = 'reportes/seguimiento/seg_menu_op_fisico';//seguimiento producto de la opracion
//$route['admin/seg/o_op/(:any)'] = 'reportes/seguimiento/lista_ogestion_ope/$1';//lista de objetivo de gestion para los productos de la opracion
$route['admin/seg/o_op/(:any)'] = 'reportes/seguimiento/lista_proyectos/$1';//lista de proyectos para los productos de la opracion
$route['admin/seg/pt_ope/(:any)'] = 'reportes/seguimiento/lista_pt_ope/$1';//lista de productos terminales para los productos de la opracion
$route['admin/seg/pe_po/(:any)'] = 'reportes/seguimiento/prog_ejec_ope/$1/$2/$3';//programacion y ejecucion de las operaciones
$route['admin/seg/graf_prod'] = 'reportes/seguimiento/grafico_prod_mes';//grafico de producto de la operacion por mes
$route['admin/seg/proy_po/(:any)'] = 'reportes/seguimiento/nivel_proyecto_po/$1';//seguimiento a nivel proyecto
$route['admin/seg/gproy/(:any)'] = 'reportes/seguimiento/grafico_por_proyecto_op/$1/$2/$3';//grafico nivel de proyecto de producto de la operacion
$route['admin/seg/prog_po/(:any)'] = 'reportes/seguimiento/nivel_programa_po/$1';//seguimiento a nivel programas
$route['admin/seg/inst_po'] = 'reportes/seguimiento/nivel_institucion_po';//seguimiento a nivel institucion producto de la operacion
//producto de la operacion fisico
$route['admin/seg/proy_pof/(:any)'] = 'reportes/seguimiento/nivel_proyecto_pof/$1';//seguimiento a nivel de proyecto
$route['admin/seg/graf_proyf'] = 'reportes/seguimiento/grafico_proy_fisico';//seguimiento a nivel de proyecto
$route['admin/seg/prog_pof/(:any)'] = 'reportes/seguimiento/nivel_programa_pof/$1';//seguimiento a nivel programas FISICO
$route['admin/seg/inst_pof'] = 'reportes/seguimiento/nivel_institucion_pof';//seguimiento a nivel institucion producto de la operacion FISICO
//REPORTES GERENCIALES
$route['admin/rg/seg'] = 'reportes/reportes_gerenciales/menu_reporte_gerencial';//reportes gerenciales*/

/*========================================= CONTROL SOCIAL ======================================*/
$route['admin/validate_invitado'] = 'user/validate_invitado';// validar al control social
$route['admin/control_social'] = 'reportes/control_social/mis_acciones';// Mis Acciones

//=========================  PRESUPUESTO ===============================
$route['admin/fp/pg'] = 'reportes/presupuesto/presupuesto_gasto';// presupuesto de gasto
$route['admin/fp/lp/(:any)'] = 'reportes/presupuesto/lista_proyectos/$1';// lista de proyectos
$route['admin/fp/lpar/(:any)'] = 'reportes/presupuesto/lista_partidas/$1/$2/$3';// lista de proyectos
$route['admin/pr/lproy/(:any)'] = 'reportes/presupuesto/lista_proy_por_mes/$1/';// lista de presupuesto de proyectos por mes
$route['admin/pr/lpar_mes/(:any)'] = 'reportes/presupuesto/lista_par_por_mes/$1/$2/$3';// lista de presupuesto de proyectos por mes
$route['admin/pr/inst'] = 'reportes/presupuesto/pres_por_institucion';//PRESUPUESTO POR INSTITUCION
$route['admin/pr/graf_proy'] = 'reportes/presupuesto/grafico_proyecto_mes';//GRAFICOS PROYECTO
$route['admin/pr/graf_prog'] = 'reportes/presupuesto/grafico_programa_mes';//GRAFICOS PROGRAMA



/////////////////////////////////////pdf//////////////////////////////////////////////
$route['admin/mantenimiento/hardy'] = 'a_pdf/b_pdf';
//////////////////////////////////////////////////////
/*$route['admin/pdf/obj_pdf/(:any)'] = 'a_pdf/obj_pdf/$1/$2';
$route['admin/pdf/objs_pdf/(:any)'] = 'a_pdf/obj_dompdf/$1/$2';*/
///////////////////////////////////////REPORTES////////////////////////////////
/*$route['admin/reportes/objes'] = 'reportes/reporte/ficha_tecnica';
$route['admin/reportes/objgest'] = 'reportes/reporte/ficha_obge';
$route['admin/reportes/prter'] = 'reportes/reporte/ficha_proter';
$route['admin/reportes/productot'] = 'reportes/reporte/ficha_productot';
$route['admin/reportes/productots'] = 'reportes/reporte/repor_protot';
$route['admin/reportes/report_ges/(:any)'] = 'reportes/reporte/reporte_gestion/$1/$2';*/
//////////////////////////////////////////////////////////////////////////////
/*$route['admin/reportes/objgest_f'] = 'reportes/reporte/rep_estra';
$route['admin/reportes/lista_g'] = 'reportes/reporte/rep_gest';
$route['admin/reportes/lista_t'] = 'reportes/reporte/rep_productot';
$route['admin/reportes/lista_pordtot/(:any)'] = 'reportes/reporte/ficha_pdfpt/$1/$2/$3';*/
////titulos///
/*$route['admin/reportes/objgest_titulo'] = 'reportes/reporte/titulo_estra';
$route['admin/reportes/gest_titulo'] = 'reportes/reporte/titulo_gestion';
$route['admin/reportes/term_titulo'] = 'reportes/reporte/titulo_terminal';*/
//////////reporte gestion
/*$route['admin/reportes/reptn_gestionn/(:any)'] = 'reportes/reporte/report_gestion/$1/$2';
$route['admin/reportes/reptn_terminal/(:any)'] = 'reportes/reporte/report_pord_terminal/$1';
$route['admin/reportes/rep_terminal/(:any)'] = 'reportes/reporte/ficha_productoterminal/$1';*/
//////////////////////////////conotrol social/////////////////////////////////
$route['admin/controls'] = 'controlsocial/vista';
////////////////////////////login session/////////////////////////////////////
$route['admin/logins'] = 'user/login_exit';
//////////////////////////elimnar insumos/////////////////
$route['admin/del_insumos'] = 'insumos/programacion_insumos/del_insumos';



/*------------------------------------ FUNCIONARIOS --------------------------------------*/
$route['admin/mnt/list_usu'] = 'mantenimiento/funcionario/list_usuarios';  //// lista de usuarios
$route['mnt/rep_list_usu'] = 'mantenimiento/funcionario/reporte_list_usuarios';  //// lista de usuarios

$route['admin/funcionario/new_fun'] = 'mantenimiento/funcionario/new_funcionario'; // new funcionario
$route['funcionario/verif_usuario'] = 'mantenimiento/funcionario/verif_usuario'; // verifica usuario
$route['admin/funcionario/add_fun'] = 'mantenimiento/funcionario/add_funcionario'; // valida funcionario
$route['admin/funcionario/update_fun/(:any)'] = 'mantenimiento/funcionario/update_funcionario/$1'; // Update Funcionario
$route['admin/funcionario/add_update_fun'] = 'mantenimiento/funcionario/add_update_funcionario'; // valida Update funcionario
$route['admin/funcionario/delete_fun/(:any)'] = 'mantenimiento/funcionario/del_fun/$1';//eliminar funcionario
$route['admin/mantenimiento/get_fun'] = 'mantenimiento/funcionario/mod_funs';//modificar funcionario

$route['admin/funcionario/verif_ci'] = 'mantenimiento/funcionario/verif_ci';//verif ci
$route['admin/funcionario/verif_usuario'] = 'mantenimiento/funcionario/verif_user';//verif user

$route['admin/mod_contra'] = 'mantenimiento/funcionario/nueva_contra';//cambiar sontrase???a funcionario
$route['admin/mods_contras'] = 'mantenimiento/funcionario/mod_cont';//cambiar contrase???a funcionario
//====================roles==================//


$route['rol'] = 'mantenimiento/roles/roles_menu';//menu roloes
$route['rol_op'] = 'mantenimiento/roles/opciones';//menu roles
$route['mod_opc']='mantenimiento/roles/mod_rol';//modificaciones y adiciones eliminar roles

//----------------------------- CONFIGURACION -------------------------------//
$route['Configuracion']='mantenimiento/cconfiguracion/main_configuracion';// main configuracion
$route['Configuracion_mod']='mantenimiento/configuracion/mod_conf';// configuracion modificar a???o
$route['Configuracion_mod_mes']='mantenimiento/configuracion/mod_conf_mes';// configuracion modificar mes

//--------------------------- MANTENIMIENTO (PRESENTACION POA) ----------------------//
$route['mnt/presentacion_poa']='mantenimiento/cconfiguracion/presentacion_poa';// Presentacion POA - Regionales
$route['mnt/caratula_poa/(:any)']='mantenimiento/cconfiguracion/ver_caratula_poa/$1';// Caratula Gasto Corriente POA
$route['mnt/caratula_pi/(:any)']='mantenimiento/cconfiguracion/ver_caratula_pi/$1';// Caratula Proyecto de Inversion POA

//--------------- ESTRUCTURA ORGANIZACIONAL ---------------//
$route['estructura_org']='mantenimiento/cestructura_organizacional/list_estructura';// Lista de Unidades - Actividades
$route['mnt/verif']='mantenimiento/cestructura_organizacional/verif_actividad_apertura';// Verif Actividad-Apertura
$route['mnt/verif_cod']='mantenimiento/cestructura_organizacional/verif_codigo_actividad';// Verif Codigo Actividad Institucional
$route['mnt/verif_cod_sact']='mantenimiento/cestructura_organizacional/verif_codigo_sub_actividad';// Verif Codigo Sub Actividad
$route['mnt/valida_actividad']='mantenimiento/cestructura_organizacional/valida_actividad';// Valida Actividad
$route['mnt/get_actividad']='mantenimiento/cestructura_organizacional/get_actividad';// get Actividad UO
$route['mnt/get_sub_actividad']='mantenimiento/cestructura_organizacional/get_sub_actividad';// get Sub Actividad UO
$route['mnt/valida_update_actividad']='mantenimiento/cestructura_organizacional/valida_update_actividad';// Valida Update Actividad
$route['mnt/valida_update_sub_actividad']='mantenimiento/cestructura_organizacional/valida_update_sub_actividad';// Valida Update Sub Actividad
$route['mnt/delete_actividad'] = 'mantenimiento/cestructura_organizacional/delete_actividad';	//// Delete Actividad
$route['mnt/rep_estructura/(:any)'] = 'mantenimiento/cestructura_organizacional/reporte_estructura/$1';	//// reporte Estructura Organica

$route['admin/proy/combo_act'] = 'mantenimiento/cestructura_organizacional/combo_act'; ////// Combo Unidades/ Establecimientos

//---------- ALINEAR TIPO DE ESTABLECIMIENTO CON SERVICIO ------------//
$route['tp_establecimientos']='mantenimiento/cestructura_organizacional/list_establecimiento';// Lista de Establecimiento
$route['rep_tp_establecimientos']='mantenimiento/cestructura_organizacional/reporte_list_establecimiento';// Reporte Lista de Establecimiento
$route['servicios/(:any)']='mantenimiento/cestructura_organizacional/list_servicios/$1';// Lista de Servicios

//---------- LISTA DE POAS SCANNEADOS ----------//
$route['mis_poas_scanneados']='mantenimiento/cpoas_scanneados/list_poa_scanneados';// Lista de POAS Escaneados

//===================partidas==========================//
$route['partidas']='mantenimiento/partidas/lista_partidas';// vista partidas
$route['imprime_partida']='mantenimiento/partidas/imprime_partidas';// Imprimir lista de partidas
$route['umedidas/(:any)']='mantenimiento/partidas/umedidas/$1';// Lista de Unidades de medida
$route['admin/verificar_par']='mantenimiento/partidas/verificar_cod_par';// vista partidas verificar codigo partida
$route['admin/partidas_add']='mantenimiento/partidas/add_par';// vista partidas adicionar partidas
$route['admin/partidas_mod']='mantenimiento/partidas/get_par';// vista partidas modificar partidas
$route['admin/partidas_del']='mantenimiento/partidas/del_par';// vista partidas eliminar partidas

//--------------------------- CONF. PROYECTOS DE INVERSI??N ----------------------//
$route['proy_inversion']='mantenimiento/cconf_pinversion/list_proyectos';// Lista Proyectos de Inversion
$route['mnt/activar_fase']='mantenimiento/cconf_pinversion/activar_fase';// Lista Proyectos de Inversion

$route['ver_consolidado/(:any)']='mantenimiento/cconf_pinversion/consolidado_temporalidad/$1/$2';// Consolidado de Temporalidad - Programado,Ejecutado (EVALUACION)

//--------------------------- MANTENIMIENTO EDICIONES ----------------------//
$route['ediciones']='mantenimiento/cediciones/menu_ediciones';// Menu de Ediciones- Certificaciones-Modificaciones
$route['rep_ediciones/(:any)']='mantenimiento/cediciones/rep_ediciones/$1';// Exportar PDF


///////////////////////////programacion//////////////////////
//========================mision y vision=========================//
$route['mision'] = 'programacion/mision/vista_mision';
$route['vision'] = 'programacion/vision/vista_vision';
//======================cambiar gestion=================//
$route['cambiar_gestion'] = 'mantenimiento/cambiar_gestion/listar_c_gestion';//vista de cambiar gestion
$route['cambiar'] = 'nueva_session/cambiar_gestion';//cambiar contralador

$route['trabajando'] = 'trabajando/vista';
$route['error'] = 'trabajando/error';

/*===================================== MODULO DE REPORTES ==============================*/

/*--- REPORTES PAC EXCEL ----*/
/*$route['rep/list_operaciones/(:any)'] = 'reportes_cns/exporting_datos/mis_unidades/$1'; ///// Lista Operaciones por regiones
$route['rep/exportar_requerimientos/(:any)'] = 'reportes_cns/exporting_datos/requerimientos/$1/$2'; ///// Exportar Requerimientos
$route['rep/exportar_requerimientos_proceso/(:any)'] = 'reportes_cns/exporting_datos/exporting_requerimientos/$1/$2/$3'; ///// Exportar Requerimientos por Procesos

$route['rep/exportar_requerimientos_distrital/(:any)'] = 'reportes_cns/exporting_datos/requerimientos_distrital/$1'; ///// Exportar Requerimientos por distrital

$route['rep/exportar_requerimientos_certificados/(:any)'] = 'reportes_cns/exporting_datos/requerimientos_certificados_regional/$1'; ///// Exportar Requerimientos Certificados

$route['rep/exportar_consolidado_unidad/(:any)'] = 'reportes_cns/exporting_datos/exportar_consolidado_unidad/$1'; /// Exportar consolidado de requerimientos Excel
$route['rep/exportar_consolidado_partidas/(:any)'] = 'reportes_cns/exporting_datos/exportar_consolidado_partidas/$1'; /// Exportar consolidado por partidas Excel

$route['rep/exportar_rep_req/(:any)'] = 'reportes_cns/exporting_datos/exportar_requerimientos_certificados/$1'; ///// Exportar Requerimientos Certificados Regional*/

//$route['rep/exportar_rep_req/(:any)'] = 'reportes_cns/exporting_datos/exportar_requerimientos_certificados/$1'; /// Exportar Requerimientos Certificados Generados total

/*--------------------------- REPORTES - MARCO ESTRATEGICO INSTITUCIONAL ---------------------------*/
$route['rep/ogestion/(:any)'] = 'reportes_cns/crep_ogestion/mis_ogestion/$1'; ///// Lista de Objetivos de Gestion - FORMULARIO SPO 01

$route['rep/regional_ogestion/(:any)'] = 'reportes_cns/crep_ogestion/list_regionales_ogestion/$1'; ///// Lista de Regionales - FORMULARIO SPO 02
$route['rep/ver_ogestion/(:any)'] = 'reportes_cns/crep_ogestion/ver_relacion_ogestion/$1'; ///// ver datos de la regional alineado al objetivo de Gestion



/*--------------------------- REPORTES - ALINEACION POA - PEI ---------------------------*/
$route['rep/alin_regionales_poa_pei'] = 'reportes_cns/crep_poai/list_regionales'; ///// Regionales CNS
$route['rep/rep_detalle_institucional'] = 'reportes_cns/crep_poai/reporte_detalle_alineacion_operaciones_institucional'; //// Reporte detalle alineacion operaciones - Intitucional
$route['rep/rep_detalle_regional_operaciones/(:any)'] = 'reportes_cns/crep_poai/reporte_detalle_alineacion_operaciones_acciones/$1'; //// Reporte detalle alineacion operaciones - acciones por actividad
$route['rep/rep_detalle_regional/(:any)'] = 'reportes_cns/crep_poai/reporte_total_alineacion_operaciones_acciones/$1'; //// Reporte Total alineacion operaciones - acciones por regional
$route['rep/rep_detalle_oe_regional/(:any)'] = 'reportes_cns/crep_poai/reporte_total_alineacion_operaciones_oe/$1'; //// Reporte Total alineacion operaciones - Obj. Est. por regional

$route['rep/rep_detalle_oestrategicos'] = 'reportes_cns/crep_poai/reporte_detalle_alineacion_operaciones_evaluacion_oestrategicos'; //// Reporte detalle alineacion operaciones - Evaluacion - Objetivos Estrategicos
$route['pei_poa'] = 'reportes_cns/crep_poai/institucional_pei_poa'; //// Reporte Institucional PEI-POA
$route['print_pei_poa/(:any)'] = 'reportes_cns/crep_poai/reporte_institucional_pei_poa/$1'; //// Reporte Institucional PEI-POA


/*--------------------------- REPORTES - EVALUACION NACIONAL (2018) a revision ---------------------------*/
$route['rep/eval_nacional'] = 'reportes_cns/crep_evalnacional/nacional_institucional'; ///// Insitutcional Nacional Global
/*-- Programas --*/
$route['rep/eval_nprogramas'] = 'reportes_cns/crep_evalnacional/nivel_programas'; ///// A nivel de Programas
$route['rep/print_eval_nprogramas'] = 'reportes_cns/crep_evalnacional/print_nivel_programas'; ///// A nivel de Programas para imprimir
$route['rep/rep_eval_nprogramas'] = 'reportes_cns/crep_evalnacional/reporte_nivel_programas'; ///// Reporte nivel de Programas
$route['rep/get_nprograma/(:any)'] = 'reportes_cns/crep_evalnacional/get_programa/$1'; ///// get Programa

/*-- Proyecto --*/
$route['rep/eval_nproyecto/(:any)'] = 'reportes_cns/crep_evalnacional/nivel_proyecto/$1'; ///// A nivel de Proyecto
$route['rep/print_eval_nproyecto/(:any)'] = 'reportes_cns/crep_evalnacional/print_nivel_proyecto/$1'; ///// A nivel de Proyecto para imprimir
$route['rep/get_nproyecto/(:any)'] = 'reportes_cns/crep_evalnacional/get_proyecto/$1/$2'; ///// get Proyecto

/*-- Componente --*/
$route['rep/eval_nproceso/(:any)'] = 'reportes_cns/crep_evalnacional/nivel_proceso/$1/$2'; ///// A nivel de Proceso
$route['rep/print_eval_nproceso/(:any)'] = 'reportes_cns/crep_evalnacional/print_nivel_proceso/$1/$2'; ///// A nivel de Proceso para imprimir
$route['rep/get_nproceso/(:any)'] = 'reportes_cns/crep_evalnacional/get_proceso/$1/$2'; ///// get Proceso

/*-- Producto --*/
$route['rep/eval_nproducto/(:any)'] = 'reportes_cns/crep_evalnacional/nivel_producto/$1/$2'; ///// A nivel de Producto
$route['rep/print_eval_nproducto/(:any)'] = 'reportes_cns/crep_evalnacional/print_nivel_producto/$1/$2'; ///// A nivel de Producto para imprimir
$route['rep/get_nproducto/(:any)'] = 'reportes_cns/crep_evalnacional/get_producto/$1/$2'; ///// get Producto

/*-- Actividad --*/
$route['rep/eval_nactividad/(:any)'] = 'reportes_cns/crep_evalnacional/nivel_actividad/$1/$2'; ///// A nivel de Actividad
$route['rep/print_eval_nactividad/(:any)'] = 'reportes_cns/crep_evalnacional/print_nivel_actividad/$1/$2'; ///// A nivel de Actividad para imprimir
$route['rep/get_nactividad/(:any)'] = 'reportes_cns/crep_evalnacional/get_actividad/$1/$2'; ///// get Actividad


/*--------------------------- REPORTES - EVALUACION NACIONAL OPERACION DE FUNCIONAMIENTO (2018) a revision ---------------------------*/
$route['rep/eval_nacional_tp/(:any)'] = 'reportes_cns/crep_evalnacional_tp/nacional_institucional_tp/$1'; ///// Insitutcional Nacional Global - Operacion de Funcionamiento
/*-- Programas --*/
$route['rep/eval_nprogramas_tp/(:any)'] = 'reportes_cns/crep_evalnacional_tp/nivel_programas/$1'; ///// A nivel de Programas
$route['rep/print_eval_nprogramas_tp/(:any)'] = 'reportes_cns/crep_evalnacional_tp/print_nivel_programas/$1'; ///// A nivel de Programas para imprimir
$route['rep/rep_eval_nprogramas_tp/(:any)'] = 'reportes_cns/crep_evalnacional_tp/reporte_nivel_programas/$1'; ///// Reporte nivel de Programas
$route['rep/get_nprograma_tp/(:any)'] = 'reportes_cns/crep_evalnacional_tp/get_programa/$1/$2'; ///// get Programa

/*-- Proyecto --*/
$route['rep/eval_nproyecto_tp/(:any)'] = 'reportes_cns/crep_evalnacional_tp/nivel_proyecto/$1/$2'; ///// A nivel de Proyecto
$route['rep/print_eval_nproyecto_tp/(:any)'] = 'reportes_cns/crep_evalnacional_tp/print_nivel_proyecto/$1/$2'; ///// A nivel de Proyecto para imprimir
$route['rep/get_nproyecto_tp/(:any)'] = 'reportes_cns/crep_evalnacional_tp/get_proyecto/$1/$2/$3'; ///// get Proyecto

/*-- Componente --*/
$route['rep/eval_nproceso_tp/(:any)'] = 'reportes_cns/crep_evalnacional_tp/nivel_proceso/$1/$2'; ///// A nivel de Proceso
$route['rep/print_eval_nproceso_tp/(:any)'] = 'reportes_cns/crep_evalnacional_tp/print_nivel_proceso/$1/$2'; ///// A nivel de Proceso para imprimir
$route['rep/get_nproceso_tp/(:any)'] = 'reportes_cns/crep_evalnacional_tp/get_proceso/$1/$2'; ///// get Proceso

/*-- Producto --*/
$route['rep/eval_nproducto_tp/(:any)'] = 'reportes_cns/crep_evalnacional_tp/nivel_producto/$1/$2'; ///// A nivel de Producto
$route['rep/print_eval_nproducto_tp/(:any)'] = 'reportes_cns/crep_evalnacional_tp/print_nivel_producto/$1/$2'; ///// A nivel de Producto para imprimir
$route['rep/get_nproducto_tp/(:any)'] = 'reportes_cns/crep_evalnacional_tp/get_producto/$1/$2'; ///// get Producto

/*-- Actividad --*/
$route['rep/eval_nactividad_tp/(:any)'] = 'reportes_cns/crep_evalnacional_tp/nivel_actividad/$1/$2'; ///// A nivel de Actividad
$route['rep/print_eval_nactividad_tp/(:any)'] = 'reportes_cns/crep_evalnacional_tp/print_nivel_actividad/$1/$2'; ///// A nivel de Actividad para imprimir
$route['rep/get_nactividad_tp/(:any)'] = 'reportes_cns/crep_evalnacional_tp/get_actividad/$1/$2'; ///// get Actividad

/*--------------------------- REPORTES EVALUACION POA - INSTITUCIONAL ---------------------------*/
$route['institucional'] = 'reportes_cns/crep_evalinstitucional/nacional_institucional'; ///// Institucional
$route['print_rep_prog_inst'] = 'reportes_cns/crep_evalinstitucional/reporte_programas_institucional'; ///// Reporte Evaluacion Institucional por programas
$route['print_rep_reg_inst'] = 'reportes_cns/crep_evalinstitucional/reporte_eval_regional'; ///// Reporte Evaluacion Institucional por programas

/*--------------------------- REPORTES EVALUACION POA - REGIONALES 2019 ---------------------------*/
$route['regionales'] = 'reportes_cns/crep_evalregional/menu_regionales'; ///// Menu Regionales
$route['get_regional/(:any)'] = 'reportes_cns/crep_evalregional/get_regional/$1'; ///// get Regional
$route['rep_cregional/(:any)'] = 'reportes_cns/crep_evalregional/consolidado_regional/$1'; ///// Consolidado Regional - poa
$route['efi_trimestre_regional/(:any)'] = 'reportes_cns/crep_evalrtrimestre/consolidado_regional_trimestre/$1'; ///// get Regional - operaciones priorizados

$route['rep_tpcregional/(:any)'] = 'reportes_cns/crep_tpevalregional/consolidado_tpregional/$1/$2'; ///// Consolidado Regional - por Tipo de Operacion : proy inv,Gasto Corriente

$route['print_eval_regional/(:any)'] = 'reportes_cns/crep_evalregional/reporte_evaluacion_regional/$1'; ///// print Evaluacion de operaciones por regional
$route['rep_cregional_pr/(:any)'] = 'reportes_cns/crep_evalregionalpr/consolidado_regional_priorizados/$1'; ///// get Regional - operaciones priorizados

$route['rep_cregional_pei/(:any)'] = 'reportes_cns/crep_evalregionalpei/consolidado_regional_pei/$1'; ///// get Regional - Consolidado por Objetivo Estrategico
$route['rep_eval_pei/dep_operaciones/(:any)'] = 'reportes_cns/crep_evalregionalpei/list_consolidado_acc/$1/$2'; ///// get Regional - Consolidado por Objetivo Estrategico

/*--------------------------- REPORTES - DISTRITALES ---------------------------*/
$route['rep_distrital/(:any)'] = 'reportes_cns/crep_evaldistrital/menu_distrital/$1'; ///// Menu Distrital
$route['print_rep_distrital/(:any)'] = 'reportes_cns/crep_evaldistrital/reporte_eficacia/$1'; ///// print eficacia por acciones operativas

/*--------------------------- REPORTES - ACCION OPERATIVA ---------------------------*/
$route['eval_dproyecto/(:any)'] = 'reportes_cns/crep_evalaccion/menu_accion/$1'; ///// Menu Accion
$route['print_eval_componentes/(:any)'] = 'reportes_cns/crep_evalaccion/reporte_evaluacion_componente/$1'; ///// print Evaluacion de operaciones por componentes

/*--------------------------- REPORTES - PARTIDAS INSTITUCIONAL ---------------------------*/
$route['rep/partidas'] = 'reportes_cns/crep_partidas/partidas_institucional'; ///// Partidas A nivel Nacional
$route['rep/rep_partidas'] = 'reportes_cns/crep_partidas/reporte_partidas_institucional'; ///// Reporte Partidas A nivel Nacional
$route['rep/xls_pnacional'] = 'reportes_cns/crep_partidas/reporte_excel_partidas_institucional'; ///// Reporte Excel Partidas A nivel Nacional

$route['rep/programas/(:any)'] = 'reportes_cns/crep_partidas/partidas_programas/$1'; ///// Partidas A nivel Programas
$route['rep/rep_programa/(:any)'] = 'reportes_cns/crep_partidas/reporte_partidas_programa/$1'; ///// Reporte Partidas A nivel Nacional
$route['rep/xls_pprogramas/(:any)'] = 'reportes_cns/crep_partidas/reporte_excel_partidas_programa/$1'; ///// Reporte Excel Partidas A nivel Nacional
$route['rep/xls_partida_ue/(:any)'] = 'reportes_cns/crep_partidas/reporte_excel_partidas_ue/$1'; ///// Ver Reporte Excel Partidas A nivel Nacional

$route['rep/acciones_operativas/(:any)'] = 'reportes_cns/crep_partidas/list_acciones_operativas/$1'; ///// Lista de Acciones
$route['rep/accion/(:any)'] = 'reportes_cns/crep_partidas/partida_accion_operativa/$1/$2'; ///// Accion Operativa
$route['rep/rep_accion/(:any)'] = 'reportes_cns/crep_partidas/reporte_partidas_accion/$1/$2'; ///// Reporte Partidas A nivel Accion Operativa
$route['rep/xls_paccion/(:any)'] = 'reportes_cns/crep_partidas/reporte_excel_partidas_accion/$1/$2'; ///// Reporte Excel Partidas A nivel Accion Operativa


/*--------------------------- REPORTES - PARTIDAS REGIONAL ---------------------------*/
$route['rep/rpartidas/(:any)'] = 'reportes_cns/crep_rpartidas/partidas_regional/$1'; ///// Partidas A nivel regional
$route['rep/rep_rpartidas/(:any)'] = 'reportes_cns/crep_rpartidas/reporte_partidas_regional/$1'; ///// Reporte Partidas A nivel Regional
$route['rep/xls_pregional/(:any)'] = 'reportes_cns/crep_rpartidas/reporte_excel_partidas_regional/$1'; ///// Reporte Excel Partidas A nivel Regional



$route['rep/rprogramas/(:any)'] = 'reportes_cns/crep_rpartidas/partidas_programas/$1/$2'; ///// Partidas A nivel Programas
$route['rep/rep_rprograma/(:any)'] = 'reportes_cns/crep_rpartidas/reporte_partidas_programa/$1/$2'; ///// Reporte Partidas A nivel Regional
$route['rep/xls_rpprogramas/(:any)'] = 'reportes_cns/crep_rpartidas/reporte_excel_partidas_programa/$1/$2'; ///// Reporte Excel Partidas A nivel Regional
$route['rep/xls_rpartida_ue/(:any)'] = 'reportes_cns/crep_rpartidas/reporte_excel_partidas_ue/$1/$2'; ///// Ver Reporte Excel Partidas A nivel Regional

$route['rep/racciones_operativas/(:any)'] = 'reportes_cns/crep_rpartidas/list_acciones_operativas/$1/$2'; ///// Lista de Acciones
$route['rep/raccion/(:any)'] = 'reportes_cns/crep_rpartidas/partida_accion_operativa/$1/$2'; ///// Accion Operativa
$route['rep/rep_raccion/(:any)'] = 'reportes_cns/crep_rpartidas/reporte_partidas_accion/$1/$2'; ///// Reporte Partidas A nivel Accion Operativa
$route['rep/xls_rpaccion/(:any)'] = 'reportes_cns/crep_rpartidas/reporte_excel_partidas_accion/$1/$2'; ///// Reporte Excel Partidas A nivel Accion Operativa


/*--------------------------- REPORTES - CONSULTAS INTERNAS ---------------------------*/
$route['consulta/mis_operaciones'] = 'consultas_cns/c_consultas/mis_operaciones'; ///// Mis operaciones
$route['consulta/cambiar'] = 'consultas_cns/c_consultas/cambiar_gestion';//cambiar contralador


///////// REPORTE RESUMEN DE ALINEACION ACTIVIDAD A CATEGORIA PROGRAMATICA 2021
$route['rep/resumen_act_programa'] = 'reporte_resumen_alineacion_poa/crep_actprog/regional';  //// Menu Regional act-prog (2020-2021)
$route['rep/rep_alineacion_poa/(:any)'] = 'reporte_resumen_alineacion_poa/crep_actprog/reporte_alineacion_poa/$1';  //// Reporte Alineacion POA (2020-2021)