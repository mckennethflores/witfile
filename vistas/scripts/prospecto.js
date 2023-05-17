var tabla;
//Función que se ejecuta al inicio
function init() {
	mostrarform(false);
	listar();

	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});
	$("#imagenmuestra").hide();

/* 	$('#mAlmacen').addClass("treeview active"); */
	$('#mProspectos').addClass("treeview active");
}
$('#tel_pr').on('input', function () {
	this.value = this.value.replace(/[^0-9]/g, '');
});
$('#dni_pr').on('input', function () {
	this.value = this.value.replace(/[^0-9]/g, '');
});
$('#cel_pr').on('input', function () {
	this.value = this.value.replace(/[^0-9]/g, '');
});
//Función limpiar
function limpiar()
{
	$("#id").val("");
	$("#nom_pr").val("");
	$("#ape_pr").val("");
	$("#dni_pr").val("");
	$("#ema_pr").val("");
	$("#tel_pr").val("");
	$("#cel_pr").val("");
	$("#dir_pr").val("");
	$("#fec_pr").val("");
	$("#des_pr").val("");
	$("#img_pr").val("");
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
			url: '../ajax/prospecto.php?op=listar',
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
	$.post("../ajax/prospecto.php?op=mostrar", {
		id: id
	}, function (data, status) {
		data = JSON.parse(data);
		mostrarform(true);

		$("#id").val(data.id);
		$("#nom_pr").val(data.nom_pr);
		$("#ape_pr").val(data.ape_pr);
		$("#dni_pr").val(data.dni_pr);
		$("#ema_pr").val(data.ema_pr);
		$("#tel_pr").val(data.tel_pr);
		$("#cel_pr").val(data.cel_pr);
		$("#dir_pr").val(data.dir_pr);
		$("#fec_pr").val(data.fec_pr);
		$("#des_pr").val(data.des_pr);
		$("#img_pr").val(data.img_pr);
		
/* 		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src", "../files/lineas/" + data.imagen);
		$("#imagenactual").val(data.imagen); */
	})
}

// Te olvidaste poner el parametro
function guardaryeditar(e) {

	e.preventDefault();
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/prospecto.php?op=guardaryeditar",
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
function desactivar(id) {
	bootbox.confirm("¿Está Seguro de desactivar?", function (result) {
		if (result) {
			$.post("../ajax/prospecto.php?op=desactivar", {
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
			$.post("../ajax/prospecto.php?op=activar", {
				id: id
			}, function (e) {
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

init();