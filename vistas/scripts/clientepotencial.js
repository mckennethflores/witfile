var tabla;
//Función que se ejecuta al inicio
function init() {
	mostrarform(false);
	listar();

	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});
	$("#imagenmuestra").hide();

	$('#mClientePotencial').addClass("active");

	$.post("../ajax/empresa.php?op=selectEmpresa", function (r) {
		$("#id_em_cp").html(r);
		$("#id_em_cp").selectpicker("refresh");
	});
	$.post("../ajax/cliente.php?op=selectCliente", function (r) {
		$("#id_cl_cp").html(r);
		$("#id_cl_cp").selectpicker("refresh");
	});
}

//Función limpiar
function limpiar()
{
	$("#id").val("");
	$("#id_em_cp").val("");
	$("#id_cl_cp").val("");
	$("#fec_cp").val("");
	$("#id_em_cp").selectpicker("refresh");
	$("#id_cl_cp").selectpicker("refresh");
}
//Función mostrar formulario
function mostrarform(flag) {
	limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled", false);
	} else {
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform() {
	limpiar();
	mostrarform(false);

}

function listar() {
	tabla = $('#tbllistado').dataTable(
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
			url: '../ajax/clientepotencial.php?op=listar',
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

function mostrar(id) {
	$.post("../ajax/clientepotencial.php?op=mostrar", {
		id: id
	}, function (data, status) {
		data = JSON.parse(data);
		mostrarform(true);

		$("#id").val(data.id);
		$("#id_em_cp").val(data.id_em_cp);
		$("#id_em_cp").selectpicker("refresh");
		$("#id_cl_cp").val(data.id_cl_cp);
		$("#id_cl_cp").selectpicker("refresh");
		$("#fec_cp").val(data.fec_cp);

		
		$("#id_cl_cp").selectpicker("refresh");
	})
}

// Te olvidaste poner el parametro
function guardaryeditar(e) {

	e.preventDefault();
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/clientepotencial.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datos) {
			bootbox.alert(datos);
			mostrarform(false);
			tabla.ajax.reload();
		}
	});
	limpiar();

}
//Función para desactivar registros
/* function desactivar(id) {
	bootbox.confirm("¿Está Seguro de desactivar?", function (result) {
		if (result) {
			$.post("../ajax/clientepotencial.php?op=desactivar", {
				id: id
			}, function (e) {
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}
//Función para activar registros
function activar(id) {
	bootbox.confirm("¿Está Seguro de activar?", function (result) {
		if (result) {
			$.post("../ajax/clientepotencial.php?op=activar", {
				id: id
			}, function (e) {
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
} */

init();