$(function () {
  $("#btncerrarsession").on("click", function () {
    Swal.fire({
      title: "Estas seguro de cerrar sesión?",
      text: "Favor de confirmar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#61C250",
      cancelButtonColor: "#ea5455",
      confirmButtonText: "Si, cerrar!", //<i class="fa fa-smile-wink"></i>
      cancelButtonText: "No", //<i class="fa fa-frown"></i>
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "/recursoshumanos/index/logout",
          success: function (res) {
            location.reload();
          },
        });
      }
    });
  });

  $("#nombre,#dias").attr("readonly", true);
  $("#anhiob,#meses,#tipoprograma").attr("disabled", true);

  bsCustomFileInput.init();

  $("#example1").DataTable({
    lengthChange: true,
    responsive: true,
    autoWidth: false,
    language: {
      decimal: "",
      emptyTable: "No hay información",
      info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
      infoEmpty: "Mostrando 0 to 0 of 0 Entradas",
      infoFiltered: "(Filtrado de _MAX_ total entradas)",
      infoPostFix: "",
      thousands: ",",
      lengthMenu: "Mostrar _MENU_ Entradas",
      loadingRecords: "Cargando...",
      processing: "Procesando...",
      search: "Buscar:",
      zeroRecords: "Sin resultados encontrados",
      paginate: {
        first: "Primero",
        last: "Ultimo",
        next: "Siguiente",
        previous: "Anterior",
      },
    },
    order: [[3, "desc"]],
    lengthMenu: [[12], ["12 rows"]],
  });

  // BTN GENERAR NUEVO AÑO PARA VACACIONES
  $("#btngen").on("click", function () {
    var anhio = $("#anhio").val();

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/cronograma/gen_anhio",
      data: { anhio: anhio },
      success: function (res) {
        if (res.icase != 1) {
          Swal.fire({
            icon: res.vicon,
            title: res.vtitle,
            text: res.vtext,
            timer: res.itimer,
            timerProgressBar: res.vprogressbar,
            showCancelButton: false,
            showConfirmButton: false,
          });
        } else {
          Swal.fire({
            icon: res.vicon,
            title: res.vtitle,
            text: res.vtext,
            timer: res.itimer,
            timerProgressBar: res.vprogressbar,
            showCancelButton: false,
            showConfirmButton: false,
          });
          var id = setInterval(function () {
            location.reload();
            clearInterval(id);
          }, res.itimer);
        }
      },
    });
  });

  // CARGAR ARCHIVO IMAGEN
  $("#btn_cargar").on("click", function () {
    var formData = new FormData();
    var files = $("#excel")[0].files[0];
    formData.append("excel", files);
    $.ajax({
      url: "/recursoshumanos/cronograma/cargar_datos",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (res) {
        if (res.icase != 1) {
          Swal.fire({
            icon: res.vicon,
            title: res.vtitle,
            text: res.vtext,
            timer: res.itimer,
            timerProgressBar: res.vprogressbar,
            showCancelButton: false,
            showConfirmButton: false,
          });
          var id = setInterval(function () {
            location.reload();
            clearInterval(id);
          }, res.itimer);
        } else {
          Swal.fire({
            icon: res.vicon,
            title: res.vtitle,
            text: res.vtext,
            timer: res.itimer,
            timerProgressBar: res.vprogressbar,
            showCancelButton: false,
            showConfirmButton: false,
          });
        }
      },
    });
  });
});

function validaNumericos(evt) {
  var code = evt.which ? evt.which : evt.keyCode;
  if (code == 8) {
    // backspace.
    return true;
  } else if (code >= 48 && code <= 57) {
    // is a number.
    return true;
  } else {
    // other keys.
    return false;
  }
}

$("#btnvalidar").on("click", function () {
  var doc = $("#documento").val();

  $.ajax({
    type: "POST",
    url: "/recursoshumanos/cronograma/validar_documento",
    data: { doc: doc },
    success: function (res) {
      switch (res.dato) {
        case 0:
          Swal.fire({
            icon: "error",
            title: "DNI no encontrado en la base de datos",
            text: "No puede programar vacaciones a un DNI que no existe...Ingrese un documento válido!",
            timer: 3000,
            timerProgressBar: true,
            showCancelButton: false,
            showConfirmButton: false,
          });
          $("#documento").val("");
          $("#documento").focus();
          break;
        case 1:
          Swal.fire({
            icon: "success",
            title: "DNI correcto",
            text: "Favor de llenar los siguientes datos...!",
            timer: 2000,
            timerProgressBar: true,
            showCancelButton: false,
            showConfirmButton: false,
          });
          $("#nombre").val(res.nombre);
          $("#anhiob,#meses,#tipoprograma").attr("disabled", false);
          $("#dias").attr("readonly", false);
          break;
      }
    },
  });
});

$("#btngrabar").on("click", function () {
  let dni = $("#documento").val();
  let name = $("#nombre").val();
  let mes = $("#meses").val();
  let tipo = $("#tipoprograma").val();
  let dias = $("#dias").val();
  let anhio = $("#anhiob").val();

  if (dni === "" || dni.length < 8) {
    Swal.fire({
      icon: "error",
      title: "DNI vacío o longitud incorrecta",
      text: "Ingrese un documento válido!",
      timer: 4000,
    });
    $("#documento").focus();
  } else if (mes === 0 || mes === null) {
    Swal.fire({
      icon: "error",
      title: "No ha seleccionado un mes a programar",
      text: "Seleccione un mes válido!",
      timer: 4000,
    });
    $("#meses").focus();
  } else if (tipo === 0 || tipo === null) {
    Swal.fire({
      icon: "error",
      title: "No ha seleccionado un tipo de programacion",
      text: "Seleccione un tipo válido!",
      timer: 4000,
    });
    $("#tipoprograma").focus();
  } else if (dias === 0) {
    Swal.fire({
      icon: "error",
      title: "No ha ingresado los dias a programar",
      text: "Ingrese un número válido!",
      timer: 4000,
    });
    $("#dias").focus();
  } else {
    Swal.fire({
      title:
        "Estas seguro de registrar las vacaciones para el personal " +
        name +
        " ?",
      text: "Favor de confirmar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#61C250",
      cancelButtonColor: "#ea5455",
      confirmButtonText: "Si, registrar!", //<i class="fa fa-smile-wink"></i>
      cancelButtonText: "No", //<i class="fa fa-frown"></i>
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "/recursoshumanos/cronograma/registrar_cronograma",
          data: { dni: dni, mes: mes, tipo: tipo, dias: dias, anhio: anhio },
          success: function (res) {
            if (res.icase < 4) {
              Swal.fire({
                icon: res.vicon,
                title: res.vtitle,
                text: res.vtext,
                timer: res.itimer,
                timerProgressBar: res.vprogressbar,
                showCancelButton: false,
                showConfirmButton: false,
              });
              var id = setInterval(function () {
                location.reload();
                clearInterval(id);
              }, res.itimer);
            } else {
              Swal.fire({
                icon: res.vicon,
                title: res.vtitle,
                text: res.vtext,
                timer: res.itimer,
                timerProgressBar: res.vprogressbar,
                showCancelButton: false,
                showConfirmButton: false,
              });
            }
          },
        });
      }
    });
  }
});

/////////////////////// MODAL EDITAR ///////////////////////
// CARGAR MODAL EDITAR CRONOGRAMA
$("#example1 tbody").on("click", "a.editar", function () {
  var id = $(this).attr("id");

  $("#cod_editar").html("");
  $("#cod_editar").html(id);

  $.ajax({
    type: "POST",
    url: "/recursoshumanos/cronograma/consultarmeses",
    data: { id: id },
    success: function (res) {
      //alert(res.estado)
      $("#estado").val("");
      $("#estado").val(res.estado);
    },
  });

  $("#modal-editar").modal("show");
});

// EDITAR CRONOGRAMA
$("#btn_actualizar").on("click", function () {
  var id = $("#cod_editar").text(); // ID
  var estado = $("#estado").val();
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/cronograma/mantenimiento_meses",
    data: { id: id, estado: estado },
    success: function (res) {
      if (res.icase < 4) {
        Swal.fire({
          icon: res.vicon,
          title: res.vtitle,
          text: res.vtext,
          timer: res.itimer,
          timerProgressBar: res.vprogressbar,
          showCancelButton: false,
          showConfirmButton: false,
        });
        $("#modal-editar").modal("hide");
        var id = setInterval(function () {
          location.reload();
          clearInterval(id);
        }, res.itimer);
      } else {
        Swal.fire({
          icon: res.vicon,
          title: res.vtitle,
          text: res.vtext,
          timer: res.itimer,
          timerProgressBar: res.vprogressbar,
          showCancelButton: false,
          showConfirmButton: false,
        });
      }
    },
  });
});

// CANCELAR ACTUALIZACION DEL CRONOGRAMA
$("#btn_cancelar").on("click", function () {
  $("#modal-editar").modal("hide");
});