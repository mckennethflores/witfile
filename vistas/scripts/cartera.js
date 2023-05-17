var tabla;
//Función que se ejecuta al inicio
function init() {
	mostrarform(false);
	listar();

	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});
	$("#imagenmuestra").hide();

	$('#mCartera').addClass("active");

	/* $.post("../ajax/empresa.php?op=selectEmpresa", function (r) {
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
}
$('#cos_re').on('input', function () {
	this.value = this.value.replace(/[^0-9]/g, '');
});
//Función limpiar
function limpiar()
{
	$("#id").val("");
	$("#nom_re").val("");
	$("#cos_re").val("");
	$("#emp_id_re").val("");
	$("#des_re").val("");
	$("#fec_re").val("");
	$("#eta_re").val("");
	$("#emp_id_re").selectpicker("refresh");
	$("#eta_re").selectpicker("refresh");

	$("#eta_re").val("");
	$("#imagenmuestra").attr("src","");
	$("#imagenactual").val("");
}
//Función mostrar formulario
function mostrarform(flag) {
	limpiar();
	$("#listadoHistoricoShow").hide();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled", false);
		$("#actividades").show();
		$("#adjuntos").show();
	} else {
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
		$("#actividades").hide();
		$("#btnActividades").show();
		$("#adjuntos").hide();
	}
}

//Función cancelarform
function cancelarform() {
	limpiar();
	mostrarform(false);

}

function mostrarHistorico(theId) {
	tabla = $('#listadoHistorico').dataTable(
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
			url: '../ajax/cartera.php?op=listar_historico&id='+theId,
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
	$("#listadoHistoricoShow").show();
	$("#listadoregistros").hide();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
		$("#actividades").hide();
		$("#btnActividades").hide();
		$("#adjuntos").hide();
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
			url: '../ajax/cartera.php?op=listar',
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
	$.post("../ajax/cartera.php?op=mostrar", {
		id: id
	}, function (data, status) {
		data = JSON.parse(data);
		mostrarform(true);

		if(data.archivo_pdf_word == null){
			$("#imagenmuestra").hide();
			$("#imagenmuestra").attr("src","../files/word.png");
		}else{
			$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/word.png");
		}

		$("#id").val(data.idreunion);
		$("#nom_re").val(data.nom_re);
		$("#cos_re").val(data.cos_re);
		$("#des_re").val(data.des_re);
		$("#fec_re").val(data.fec_re);

        $("#emp_id_re").val(data.idempresa);
		$("#emp_id_re").selectpicker("refresh");
		$("#id_eta_re").val(data.idetapa);
		$("#id_eta_re").selectpicker("refresh");
/* 		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src", "../files/lineas/" + data.imagen);
		$("#imagenactual").val(data.imagen); */
		 
	 
	/* 	$("#imagenactual").val(data.archivo_pdf_word); */
	})
}
function showWhitoutEdit(id) {
	$.post("../ajax/cartera.php?op=mostrar", {
		id: id
	}, function (data, status) {
		data = JSON.parse(data);
		mostrarform(true);

		if(data.archivo_pdf_word == null){
			$("#imagenmuestra").hide();
			$("#imagenmuestra").attr("src","../files/word.png");
		}else{
			$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/word.png");
		}

		$("#id").val(data.idreunion);
		$("#nom_re").val(data.nom_re);
		$("#cos_re").val(data.cos_re);
		$("#des_re").val(data.des_re);
		$("#fec_re").val(data.fec_re);

        $("#emp_id_re").val(data.idempresa);
		$("#emp_id_re").selectpicker("refresh");
		$("#id_eta_re").val(data.idetapa);
		$("#id_eta_re").selectpicker("refresh");
/* 		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src", "../files/lineas/" + data.imagen);
		$("#imagenactual").val(data.imagen); */
		 
	 
	/* 	$("#imagenactual").val(data.archivo_pdf_word); */
	})
}
function validarCampos(){
	var nom_re = $("#nom_re").val();
	if(nom_re == ""){
		bootbox.alert("Ingresa titulo de la reunión");
	}
}
// Te olvidaste poner el parametro
function guardaryeditar(e) {

	e.preventDefault();
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/cartera.php?op=guardaryeditar",
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
// Eliminar
function eliminar(id){
	bootbox.confirm("¿Está Seguro que desea eliminar el registro seleccionado?", function (result) {
		if (result) {
			$.post("../ajax/cartera.php?op=eliminar", {
				id: id
			}, function (e) {
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})	
}
//Función para desactivar registros
function desactivar(id) {
	bootbox.confirm("¿Está Seguro de desactivar?", function (result) {
		if (result) {
			$.post("../ajax/cartera.php?op=desactivar", {
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
			$.post("../ajax/cartera.php?op=activar", {
				id: id
			}, function (e) {
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}



init();