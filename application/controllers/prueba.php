<?php

class Prueba extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model', '', true);
        $this->load->model('registro_ejec/mejec_sigep');

    }

    public function index()
    {
        $gestion = $this->session->userdata('gestion');
        $mes_id = $this->session->userdata('mes');
        $lista_proy = $this->mejec_sigep->lista_proy_ejec($gestion, $mes_id);
        $tabla = '';
        $cont = 1;
        $tabla .= '<table border="1" id="tabla">';
        foreach ($lista_proy AS $row) {
            $tabla .= '<tr>';
            $tabla .= '<td>' . $cont . '</td>';
            $tabla .= '<td>' . $row['aper_cod_csv'] . '</td>';
            $tabla .= '<td>' . $row['proy_codigo'] . '</td>';
            $tabla .= '<td>' . $row['proy_nombre'] . '</td>';
            $tabla .= '<td>' . $row['par_cod_csv'] . '</td>';
            $tabla .= '<td>' . $row['par_codigo'] . '</td>';
            $tabla .= '<td>' . $row['ff_cod_csv'] . '</td>';
            $tabla .= '<td>' . $row['ff_codigo'] . '</td>';
            $tabla .= '<td>' . $row['of_cod_csv'] . '</td>';
            $tabla .= '<td>' . $row['of_codigo'] . '</td>';
            $tabla .= '<td>' . $row['ega_ppto_inicial'] . '</td>';
            $tabla .= '<td>' . $row['ega_modif_aprobadas'] . '</td>';
            $tabla .= '<td>' . $row['ega_ppto_vigente'] . '</td>';
            $tabla .= '<td>' . $row['ega_devengado'] . '</td>';
            $tabla .= '<td>' . $row['m_descripcion'] . '</td>';
            $tabla .= '</tr>';
            $cont++;
        }
        $tabla .= '</table>';

        $tabla .= "<script>
                   var tabla = document.getElementById('tabla');
                   var numFilas = tabla.rows.length;
                   alert(numFilas)
                   </script>";

        echo $tabla;
    }


}