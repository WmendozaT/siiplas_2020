<?php
ob_start();
?>
<style type="text/css">
    table.page_header {width: 100%; border: none; border-bottom: solid 1mm; padding: 2mm }
    table.page_footer {width: 100%; border: none; background-color: #739e73; border-top: solid 1mm #AAAADD; padding: 2mm}
}
</style>
<style>
    .verde{ width:100%; height:5px; background-color:#1c7368;}
    .blanco{ width:100%; height:5px; background-color:#F1F2F1;}
    .siipp{width:120px;}


    .tabla {
    font-size: 7px;
    width: 100%;
    }

</style>


<?php echo $principal;?>




<?php
$titulo_act='ACTIVIDAD';
$titulo_subact='SUBACT.';
if($proyecto[0]['tp_id']==1){
    $titulo_act='PROY. INV.';
    $titulo_subact='UNI. RESP.';
}
$nro_pag=0;
foreach($subactividades as $rowu){ $nro_pag++; ?>
<page backtop="55mm" backbottom="15mm" backleft="5mm" backright="5mm" pagegroup="new">
    <page_header>
        <br><div class="verde"></div>
        <table class="page_header" border="0">
            <tr>
                <td style="width: 100%; text-align: left">
                    <table border="0" cellpadding="0" cellspacing="0" class="tabla" style="width:100%;">
                        <tr style="width: 100%; border: solid 0px black; text-align: center; font-size: 8pt; font-style: oblique;">
                          <td width=15%; text-align:center;"">
                            <img src="<?php echo base_url().'assets/ifinal/cns_logo.JPG'?>" alt="" style="width:58%;">
                          </td>
                          <td width=70%; align=center>
                            <table border="0" cellpadding="0" cellspacing="0" class="tabla" style="width:100%;" align="center">
                                <tr>
                                    <td style="width:100%; height: 1.2%; font-size: 15pt;" align="left" colspan="2"><b><?php echo $this->session->userdata('entidad');?></b></td>
                                </tr>
                                <tr style="font-size: 8pt;">
                                    <td style="width:12%; height:13px;" align="left"><b>DIR. ADM.</b></td>
                                    <td style="width:89%;" align="left">: <?php echo $proyecto[0]['dep_cod'].' '.strtoupper($proyecto[0]['dep_departamento']);?></td>
                                </tr>
                                <tr style="font-size: 8pt;">
                                    <td style="width:12%; height:13px;" align="left"><b>UNI. EJEC.</b></td>
                                    <td style="width:89%;" align="left">: <?php echo $proyecto[0]['dist_cod'].' '.strtoupper($proyecto[0]['dist_distrital']);?></td>
                                </tr>
                                <tr style="font-size: 8pt;">
                                    <td style="width:12%; height:13px;" align="left"><b>ACTIVIDAD</b></td>
                                    <td style="width:89%;" align="left">: <?php echo $proyecto[0]['aper_programa'].' '.$proyecto[0]['aper_proyecto'].' '.$proyecto[0]['aper_actividad'].' - '.strtoupper($proyecto[0]['act_descripcion']).' '.$proyecto[0]['abrev'];?></td>
                                </tr>
                                <tr style="font-size: 8pt;">
                                    <td style="width:12%; height:13px;" align="left"><b>SUBACT.</b></td>
                                    <td style="width:89%;" align="left">: <?php echo strtoupper($rowu['serv_cod']).' '.strtoupper($rowu['tipo_subactividad']).' '.strtoupper($rowu['serv_descripcion']);?></td>
                                </tr>
                            </table>
                          </td>
                          <td width=15%; text-align:center;>
                          </td>
                        </tr>
                  </table>
                </td>
            </tr>
        </table><br>
        <div style="font-size: 20px;font-family: Arial; height:20px;" align="center"><b>NOTIFICACI&Oacute;N PARA SEGUIMIENTO POA <br> <?php echo $verif_mes[2].' '.$this->session->userdata('gestion');?></b></div><br>
    </page_header>
    <page_footer>
    <hr>
        <table border="0" cellpadding="0" cellspacing="0" class="tabla" style="width:96%;" align="center">
            <tr>
                <td style="width: 33%; text-align: left">
                    POA - <?php echo $this->session->userdata('gestion')?>, Aprobado mediante RD. Nro 116/18 de 05.09.2018
                </td>
                <td style="width: 33%; text-align: center">
                    <?php echo $this->session->userdata('sistema')?>
                </td>
                <td style="width: 33%; text-align: right">
                    <?php echo $mes[ltrim(date("m"), "0")]. " / " . date("Y").', '.$this->session->userdata('funcionario'); ?> - pag. [[page_cu]]/[[page_nb]]
                </td>
            </tr>
            <tr>
                <td colspan="3"><br></td>
            </tr>
        </table>
    </page_footer>
    
    <?php
        $operaciones=$this->model_seguimientopoa->operaciones_programados_x_mes($rowu['com_id'],$verif_mes[1]); /// lISTA DE OPERACIONES
        echo '<br><table cellpadding="0" cellspacing="0" class="tabla" border=0.2 style="width:100%;" align=center>
                <thead>
                  <tr style="font-size: 7px;" bgcolor=#f8f2f2 align=center>
                    <th style="width:1.5%; height:20px;"></th>
                    <th style="width:3%;"><b>COD. OR.</b></th>
                    <th style="width:3%;"><b>COD. OPE.</b></th>
                    <th style="width:25%;">OPERACI&Oacute;N</th>
                    <th style="width:20%;">INDICADOR</th>
                    <th style="width:20%;">MEDIO DE VERIFICACI&Oacute;N</th>
                    <th style="width:5%;">META ANUAL</th>
                    <th style="width:5%;">PROG. MES</th>
                    <th style="width:5%;">EJEC.</th>
                  </tr>
                </thead>
                <tbody>';
                $nro_ope=0;
                foreach ($operaciones as $row) {
                    $ejec=$this->model_producto->verif_ope_evaluado_mes($row['prod_id'],$this->verif_mes[1]);
                    $evaluado=0;
                      if(count($ejec)!=0){
                        $evaluado=$ejec[0]['pejec_fis'];
                      }

                    $nro_ope++;
                    echo '
                        <tr>
                            <td align=center style="height:20px; width:1.5%;">'.$nro_ope.'</td>
                            <td align=center style="font-size: 10px; width:3%;">'.$row['or_codigo'].'</td>
                            <td align=center style="font-size: 10px; width:3%;">'.$row['prod_cod'].'</td>
                            <td style="width:25%;">'.$row['prod_producto'].'</td>
                            <td style="width:20%;">'.$row['prod_indicador'].'</td>
                            <td style="width:20%;">'.$row['prod_fuente_verificacion'].'</td>
                            <td style="width:5%;" align=right>'.round($row['prod_meta'],2).'</td>
                            <td style="width:5%;" align=right>'.round($row['pg_fis'],2).'</td>
                            <td style="width:5%;" align=right>'.round($evaluado,2).'</td>
                        </tr>';
                }
        echo '  </tbody>
            </table>';
    ?>
    
</page>
    <?php
}

$content = ob_get_clean();
//require_once(dirname(__FILE__).'/../html2pdf.class.php');
require_once('assets/html2pdf-4.4.0/html2pdf.class.php');
try{
    $html2pdf = new HTML2PDF('P', 'Letter', 'fr', true, 'UTF-8', 0);
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('Foda.pdf');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
