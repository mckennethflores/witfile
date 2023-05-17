var tablaReunion;
var tablaActividad;
//Función que se ejecuta al inicio
function init() {
	mostrarform(false);
	$('#mDetalleCliente').addClass("active");
	$("#imagenmuestra").hide();
	
	listarReuniones();

/* 	$.post("../ajax/empresa.php?op=selectEmpresa", function (r) {
		$("#emp_id_re").html(r);
		$("#emp_id_re").selectpicker("refresh");
	}); */
	$.post("../ajax/clientes.php?op=selectClientes", function (r) {
		$("#emp_id_re").html(r);
		$("#emp_id_re").selectpicker("refresh");
	});
	$.post("../ajax/auxiliar.php?op=selectAuxiliar", function (r) {
		$("#id_eta_re").html(r);
		$("#id_eta_re").selectpicker("refresh");
	});
	
	//Actividades

	$("#formularioActividad").on("submit", function (e) {
		guardaryeditarActividades(e);
	});

	let mostrarReunionId = document.getElementById('mostrarReunionId'); // MUESTRA LA REUNIÓN EN CASO DE QUE LA HAYA
	if (mostrarReunionId != undefined) {
		mostrarReuniones(mostrarReunionId.value);
	}

	// Ventana Modal
	/* $("#modalEmergenteAlerta").modal(); */
	 
}

//Función limpiar
function limpiar()
{
	$("#id").val("");
	$("#asunto_actreu").val("");
	$("#fecini_actreu").val("");
	$("#fecfin_actreu").val("");
	$("#dec_actreu").val("");
	$("#recordatorio").val("");

}
//Función mostrar formulario
function mostrarform(flag) {
	limpiar();
	if (flag) {
		$("#listadoreuniones").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled", false);
		$("#acordeonContainerActividades").show();
		/* $("#adjuntos").show(); */
	} else {
		$("#listadoreuniones").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
		$("#acordeonContainerActividades").hide();
		$("#btnActividades").show();
		$("#adjuntos").hide();
	}
}

//Función cancelarform
function cancelarform() {
	limpiar();
	mostrarform(false);
}
function listarReuniones() {
	tablaReunion = $('#tbllistadoReuniones').dataTable(
		{
			"lengthMenu": [ 10, 50, 100, 200, 300],//mostramos el menú de registros a revisar
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
			buttons: [ 
				'copyHtml5',
				'excelHtml5',
				'csvHtml5',
				'pdf'
			],
		"ajax": {
			url: '../ajax/detalleCliente.php?op=listarReuniones',
			type: "get",
			dataType: "json",
			error: function (e) {
				console.log(e.responseText);
			}

		},
		"language": {
			"lengthMenu": "Mostrar : _MENU_ registros",
			"buttons": {
				"copyTitle": "Tabla Copiada",
				"copySuccess": {
					_: '%d Registros copiad(a)s',
					1: '1 Registros copiad(a)'
				}
			}
		},
		"bDestroy": true,
		"iDisplayLenght": 10,
		"order": [
			[0, "desc"]
		]

	}).DataTable();
}
function mostrarReuniones(id) {
	$.post("../ajax/detalleCliente.php?op=mostrarReuniones", {
		id: id
	}, function (data, status) {
		data = JSON.parse(data);
		mostrarform(true);
		$("#adjuntos").hide();
		listarActividades(data.idreunion);
		$("#idActividadReunion").val(data.idreunion);

		$("#idReunion").val(data.idreunion);
		$("#nom_re").val(data.nom_re);
		$("#cos_re").val(data.cos_re);
		$("#des_re").val(data.des_re);
		$("#fec_re").val(data.fec_re);

        $("#emp_id_re").val(data.nom_pr+ ' '+data.ape_pr);
		$("#emp_id_re").selectpicker("refresh");
		$("#id_eta_re").val(data.idetapa);
		$("#id_eta_re").selectpicker("refresh");
	});
	
}

function mostrarActividad(id) {

	$.post("../ajax/detalleCliente.php?op=mostrarActividad", {
		id: id
	}, function (data, status) {
		data = JSON.parse(data);
		mostrarform(true);
		
		
		$("#modalProgramarReunion").modal();
		$("#idActividadReunion").val(data.idReunion);

		$("#id").val(data.id);
		$("#asunto_actreu").val(data.asunto_actreu);
		$("#fecini_actreu").val(data.fecini_actreu);
		$("#fecfin_actreu").val(data.fecfin_actreu);
		$("#dec_actreu").val(data.dec_actreu);
		$("#recordatorio").val(data.recordatorio);
	});
	
}
function listarActividades(idReunion) {
	tablaActividad = $('#tbllistadoActividades').dataTable(
		{
			"lengthMenu": [ 10, 50, 100, 200, 300],//mostramos el menú de registros a revisar
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
			buttons: [
					],
		"ajax": {
			url: '../ajax/detalleCliente.php?op=listarActividades' + '&idReunion=' + idReunion,
			type: "get",
			dataType: "json",
			error: function (e) {
				console.log(e.responseText);
			}

		},
		"bDestroy": true,
		"iDisplayLenght": 10,
		"order": [
			[0, "desc"]
		]

	}).DataTable();
}

// Te olvidaste poner el parametro
function guardaryeditarActividades(e) {

	e.preventDefault();
	$("#btnGuardar").prop("disabled", true);
	var formDataActividad = new FormData($("#formularioActividad")[0]);

	$.ajax({
		url: "../ajax/detalleCliente.php?op=guardaryeditaractividades",
		type: "POST",
		data: formDataActividad,
		contentType: false,
		processData: false,

		success: function (datos) {
			bootbox.alert(datos);
		/* 	mostrarform(false); */
		$("#modalProgramarReunion").modal("hide");
		tablaActividad.ajax.reload();
		}
	});
	limpiar();

}

function listarFechasVencidas(fechaFin) {
	tablaActividad = $('#tbllistadoActividades').dataTable(
		{
			"lengthMenu": [ 10, 50, 100, 200, 300],//mostramos el menú de registros a revisar
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
			buttons: [
					],
		"ajax": {
			url: '../ajax/detalleCliente.php?op=listarActividades' + '&idReunion=' + idReunion,
			type: "get",
			dataType: "json",
			error: function (e) {
				console.log(e.responseText);
			}

		},
		"bDestroy": true,
		"iDisplayLenght": 10,
		"order": [
			[0, "desc"]
		]

	}).DataTable();
}
 
var usuarios = [];
	fetch('../ajax/detalleCliente.php?op=listarFechasVencidas')
	.then(data => data.json())
	.then(data => {
		usuarios = data;
		console.log(usuarios);
	})
 

/* 	function listado(mensajes) {
		var count = 0;
		mensajes.forEach((item, index) => {
		  var post2 = `<div>
				  <div class="asunto"><strong>${item.asunto}</strong></div>
				  <div class="fecha_inicio">${item.fecha_inicio}</div>
				  <div class="fecha_fin">Fecha de vencimiento:</strong>${item.fecha_fin}</div>
				  </div>`;
		  setTimeout(function () {
			$("#containerMensaje").append(post2);
		  }, 500);
	  
		  count++;
		});
		console.log("Hay " + count + " mensaje");
	  } */

/* var dialog = bootbox.dialog({
    title: 'A custom dialog with buttons and callbacks',
    message: "<p>This dialog has buttons. Each button has it's own callback function.</p>",
    size: 'large',
    buttons: {
        cancel: {
            label: "I'm a cancel button!",
            className: 'btn-danger',
            callback: function(){
                console.log('Custom cancel clicked');
            }
        },
        noclose: {
            label: "I don't close the modal!",
            className: 'btn-warning',
            callback: function(){
                console.log('Custom button clicked');
                return false;
            }
        },
        ok: {
            label: "I'm an OK button!",
            className: 'btn-info',
            callback: function(){
                console.log('Custom OK clicked');
            }
        }
    }
}); */

init();