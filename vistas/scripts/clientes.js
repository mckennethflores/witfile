var tabla;
//Función que se ejecuta al inicio
function init() {
	mostrarform(false);
	listar();

	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});
	$("#imagenmuestra").hide();

	$('#mClientes').addClass("active");

	$.post("../ajax/empresa.php?op=selectEmpresa", function (r) {
		$("#id_em_cl").html(r);
		$("#id_em_cl").selectpicker("refresh");
	});
	$.post("../ajax/prospecto.php?op=selectProspecto", function (r) {
		$("#id_prospecto_cl").html(r);
		$("#id_prospecto_cl").selectpicker("refresh");
	});
}
$('#dni_pr').on('input', function () {
	this.value = this.value.replace(/[^0-9]/g, '');
});
//Función limpiar
function limpiar()
{
	$("#id").val("");
	$("#id_em_cl").val("");
	$("#id_prospecto_cl").val("");
/* 	$("#fec_cp").val(""); */
	$("#id_em_cl").selectpicker("refresh");
	$("#id_prospecto_cl").selectpicker("refresh");
	// prospecto
	$("#nom_pr").val("");
	$("#ape_pr").val("");
	$("#dni_pr").val("");
	$("#ema_pr").val("");
	$("#tel_pr").val("");
	$("#cel_pr").val("");
	$("#dir_pr").val("");
	$("#des_pr").val("");
 
}
//Función mostrar formulario
function mostrarform(flag) {
	limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled", false);

	setInterval(function() {	
				existCustomer();
	}, 500);

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
			url: '../ajax/clientes.php?op=listar',
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
	$.post("../ajax/clientes.php?op=mostrar", {
		id: id
	}, function (data, status) {
		data = JSON.parse(data);
		mostrarform(true);

		$("#id").val(data.idcliente);
		$("#id_em_cl").val(data.idempresa);
		$("#id_em_cl").selectpicker("refresh");
	/* 	$("#id_prospecto_cl").val(data.idprospecto);
		$("#id_prospecto_cl").selectpicker("refresh"); */

		$("#idprospecto").val(data.id_prospecto);
		$("#nom_pr").val(data.nombre_pr);
		$("#ape_pr").val(data.apellido_pr);
		$("#dni_pr").val(data.dni_pr);
		$("#ema_pr").val(data.email_pr);
		$("#tel_pr").val(data.telefono_pr);
		$("#cel_pr").val(data.celular_pr);
		$("#dir_pr").val(data.direccion_pr);
	 
		$("#des_pr").val(data.descripcion_pr);

		/* $("#fec_cp").val(data.fec_cp); */
	})

}

// Te olvidaste poner el parametro
function guardaryeditar(e) {

	e.preventDefault();
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);

	var dni = $("#dni_pr").val();

	$.ajax({
		url: "../ajax/clientes.php?op=guardaryeditar&dni_pr="+dni,
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
function eliminar(id){
	bootbox.confirm("¿Está Seguro que desea eliminar el cliente seleccionado?", function (result) {
		if (result) {
			$.post("../ajax/clientes.php?op=eliminar", {
				id: id
			}, function (e) {
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})	
}
function desactivar(id){
	bootbox.confirm("¿Está Seguro que desea eliminar el cliente seleccionado?", function (result) {
		if (result) {
			$.post("../ajax/clientes.php?op=desactivar", {
				id: id
			}, function (e) {
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})	
}


function existCustomer(){

	// voy a obtener el valor del input luego lo voy a pasar por parametro a la funcion 
	var formData = new FormData($("#formulario")[0]);
	var dni = $("#dni_pr").val();
	// hace un select a la tabla prospectos con el dni = para ver si ya existe si ya existe
   $.ajax({
	   url: "../ajax/clientes.php?op=existCustomerInserted&dni_pr="+dni,
	   type: "POST",
	   data: formData,
	   contentType: false,
	   processData: false,

	   success: function (datos) {
		   var resultado = datos.trim();

		   if(resultado == 'existCustomer'){
			console.log("disabled")
			$("#btnGuardar").prop("disabled", true);
		   }else if (resultado == 'notExistCustomer'){
			 console.log("add")
			 $("#btnGuardar").prop("disabled", false);
		   }else{
			   console.log("error al procesar la información");
		   }
		   
	   
	   }
   });


	/* voy a mandar deshabilitar la opcion,
	alert duplicidad de datos.
   si no existe lo mantengo normal  */
}


init();