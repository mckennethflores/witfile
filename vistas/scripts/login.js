$("#frmAcceso").on('submit', function (e) {
    e.preventDefault();
    usu_us = $("#usu_us").val();
    cla_us = $("#cla_us").val();
    rol_id_us = $("#rol_id_us").val();
    
    $.post("../ajax/usuario.php?op=verificar", {
            "usu_us": usu_us,
            "cla_us": cla_us,
            "rol_id_us": rol_id_us
        },
        function (data) {
            if (data != "null") {
             /*  console.log(data); return; */
                $(location).attr("href", "escritorio.php");
            } else {
                bootbox.alert("Usuario y/o Password incorrectos");
            }
        });

});

function init() {

    $.post("../ajax/login.php?op=selectRol&opselected=selected", function (r) {
        //se cambio el id de login.php
        $("#rol_id_us").html(r);
    });

}
init();