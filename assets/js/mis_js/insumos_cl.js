//=============================== LISTA DE consultoria en linea===========
$("#lista_cl").click(function(){
    //limpiar tablas
    $("#tabla_rhp").html("");
    $("#tabla_ser").html("");
    $("#tabla_pas").html("");
    $("#tabla_via").html("");
    $("#tabla_cpp").html("");
    $("#tabla_mat").html("");
    $("#tabla_af").html("");
    $("#tabla_oi").html("");
    //------
    var url_cl = site_url + '/insumos/programacion_insumos/tabla_cl';
    $.ajax({
        type: "post",
        url: url_cl,
        data: {
            act_id: act_id,
        },
        success: function (data) {
            $("#tabla_cl").html(data);
        }
    });
});

