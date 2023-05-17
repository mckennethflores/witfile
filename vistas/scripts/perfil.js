var tabla;

function init() {
	mostrarform(false);

	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});
	$("#imagenmuestra").hide();

	$('#mPerfil').addClass("treeview active");
	$('#lUsuarios').addClass("active");

    $.post("../ajax/perfil.php?op=mostrar", function (r) {
        let perfil = JSON.parse(r);
        console.log(perfil)
        $("#usuarioavatar").text(perfil.usu_us);
		$("#usuarioavatar2").text(perfil.usu_us);
		$("#avatarperfil").attr('src', '../files/usuarios/'+perfil.imagen_us);
		$("#avatarperfil2").attr('src', '../files/usuarios/'+perfil.imagen_us);

        $("#role").text(perfil.rol_id_us);
        $("#nombres").text(perfil.nom_us);
        $("#usuario").text(perfil.usu_us);
       
	});
}

$("#idperfil").change(function () {

	$("select option:selected").each(function () {
		if ($(this).text() == 'Cliente') {
			$('.permisos_div').addClass("ocultar");
		} else {
			$('.permisos_div').removeClass("ocultar");
		}
	});

});


function limpiar() {
	$("#claveactual").val("");
	$("#nuevaclave").val("");
	$("#repetirclave").val("");
	
	$("#idusuario").val("");
	$("#dniusuario").val("");
	$("#nomusuario").val("");
	$("#sexousuario").val("");
	$("#telusuario").val("");
	$("#emailusuario").val("");
	$("#dirusuario").val("");
	$("#claveusuario").val("");
	$("#imagenusuario").val("");
}

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

function cancelarform() {
	limpiar();
	mostrarform(false);

}
// Te olvidaste poner el parametro
function guardaryeditar(e) {

	e.preventDefault();
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);
	console.log(formData);
	$.ajax({
		url: "../ajax/usuario.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datos) {
			console.log(datos);
			bootbox.alert(datos);
			mostrarform(false);
			tabla.ajax.reload();
		}
	});
	limpiar();

}

function actualizarAccesoClave(e){
	
	e.preventDefault();

	if(($("#claveactual").val() == "") || ($("#nuevaclave").val() == "") || ($("#repetirclave").val() == "")){
		$("#mensaje").text("Debe llenar los campos")
	}else if(($("#nuevaclave").val() === $("#repetirclave").val())){
		$("#btnactualizar").prop("disabled", true);
		var formData = new FormData($("#formacceso")[0]);

		console.log(formData);
	
		$.ajax({
			url: "../ajax/perfil.php?op=actualizAracceso",
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			success: function (datos) { 
				let data = JSON.parse(datos);
				console.log(data);
				bootbox.alert(data.mensaje);
				$("#btnactualizar").prop("disabled", false);
				if(data.rsta) $("#modalEditarAcceso").modal('hide')
			}
		});

		limpiar();
	}else{
		$("#mensaje").text("Las contraseñas no coinciden")
	}
}

function mostrar(idusuario) {
	$.post("../ajax/usuario.php?op=mostrar", {
		idusuario: idusuario
	}, function (data, status) {
		data = JSON.parse(data);
		mostrarform(true);
		console.log(data)
		$("#idusuario").val(data.idusuario);
		$("#dniusuario").val(data.dniusuario);
		$("#nomusuario").val(data.nomusuario);
		$("#sexousuario").val(data.sexousuario);
		$("#telusuario").val(data.telusuario);
		$("#emailusuario").val(data.emailusuario);
		$("#dirusuario").val(data.dirusuario);
		$("#claveusuario").val(data.claveusuario);
		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src", "../files/usuarios/" + data.imagenusuario);
		$("#imagenactual").val(data.imagenusuario);

		$("#sexousuario").val(data.sexousuario);
		$('#sexousuario').selectpicker('refresh');

		$("#iddepartamento").val(data.iddepartamento);
		$('#iddepartamento').selectpicker('refresh');

		$("#idprovincia").val(data.idprovincia);
		$('#idprovincia').selectpicker('refresh');

		$("#idmunicipalidad").val(data.idmunicipalidad);
		$('#idmunicipalidad').selectpicker('refresh');
	})

	$.post("../ajax/usuario.php?op=permisos&id=" + idusuario, function (r) {
		$("#permisos").html(r);
	});
}

function desactivar(idusuario) {
	bootbox.confirm("¿Está Seguro de desactivar el usuario?", function (result) {
		if (result) {
			$.post("../ajax/usuario.php?op=desactivar", {
				idusuario: idusuario
			}, function (e) {
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

function activar(idusuario) {
	bootbox.confirm("¿Está Seguro de activar el usuario?", function (result) {
		if (result) {
			$.post("../ajax/usuario.php?op=activar", {
				idusuario: idusuario
			}, function (e) {
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

$("#btncancelar").click(limpiar);
$("#btnactualizar").click(actualizarAccesoClave);

init();