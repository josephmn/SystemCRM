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

  //CARGAR DESHABILITADO LOS INPUT
  $("#id-local-actualizar").attr("readonly", true);

  //PARA CARGAR LA TABLA
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
    order: [
      [7, "asc"],
      [1, "asc"],
    ],
    // dom: "Bfrtip",
    lengthMenu: [
      [10, 25, 50, -1],
      [10, 25, 50, "All"],
    ],
    // buttons: [
    //   "excel",
    //   // "pdf",
    //   "print",
    //   {
    //     extend: "pdfHtml5",
    //     orientation: "landscape",
    //     pageSize: "LEGAL",
    //   },
    // ],
  });
});

// COMENTADO PARA PODER DAR LONGITUD
function Datos() {
  // function countnombre(obj) {
  //   var maxLength = 30;
  //   var strLength = obj.value.length;
  //   if (strLength > maxLength) {
  //     document.getElementById("charnombre").innerHTML =
  //       '<span style="color: red;">' +
  //       strLength +
  //       " de " +
  //       maxLength +
  //       " caracteres</span>";
  //   } else {
  //     document.getElementById("charnombre").innerHTML =
  //       strLength + " de " + maxLength + " caracteres";
  //   }
  // }
  // function countabrev(obj) {
  //   var maxLength = 3;
  //   var strLength = obj.value.length;
  //   if (strLength > maxLength) {
  //     document.getElementById("charabrev").innerHTML =
  //       '<span style="color: red;">' +
  //       strLength +
  //       " de " +
  //       maxLength +
  //       " caracteres</span>";
  //   } else {
  //     document.getElementById("charabrev").innerHTML =
  //       strLength + " de " + maxLength + " caracteres";
  //   }
  // }
  // function countnombre_actualizar(obj) {
  //   var maxLength = 30;
  //   var strLength = obj.value.length;
  //   if (strLength > maxLength) {
  //     document.getElementById("charnombre").innerHTML =
  //       '<span style="color: red;">' +
  //       strLength +
  //       " de " +
  //       maxLength +
  //       " caracteres</span>";
  //   } else {
  //     document.getElementById("charnombre_actualizar").innerHTML =
  //       strLength + " de " + maxLength + " caracteres";
  //   }
  // }
  // function countabrev_actualizar(obj) {
  //   var maxLength = 3;
  //   var strLength = obj.value.length;
  //   if (strLength > maxLength) {
  //     document.getElementById("charabrev").innerHTML =
  //       '<span style="color: red;">' +
  //       strLength +
  //       " de " +
  //       maxLength +
  //       " caracteres</span>";
  //   } else {
  //     document.getElementById("charabrev_actualizar").innerHTML =
  //       strLength + " de " + maxLength + " caracteres";
  //   }
  // }
}

// SOLO LETRAS
function sololetras(event) {
  var regex = new RegExp("^[a-zA-Z ]+$");
  var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
  if (!regex.test(key)) {
    event.preventDefault();
    return false;
  }
}

//-------------------- MODAL AGREGAR --------------------//
// CARGAR MODAL AGREGAR
$("#btn-agregar").on("click", function () {
  $("#nombre-local").val("");
  $("#id-zona").val("0");
  $("#abrev-local").val("");
  $("#modal-agregar").modal("show");
});

// BONTON REGISTRAR
$("#btn-registrar").on("click", function () {
  var id = 1; // insertar
  var local = 0;
  var nombre = $("#nombre-local").val();
  var idzona = $("#id-zona").val();
  var estado = 0;
  var abrev = $("#abrev").val();
  var horaini = $("#hora-inicio").val();
  var horafin = $("#hora-fin").val();
  var tolerancia = $("#tolerancia").val();
  var tipoasistencia = $("#tipo-asistencia").val();

  if (nombre == null || nombre == "") {
    Swal.fire({
      icon: "info",
      title: "Nombre de local no puede estar vacío...",
      text: "Registre un nombre!",
      timer: 3000,
    });
  } else if (idzona == 0 || idzona == null) {
    Swal.fire({
      icon: "info",
      title: "No ha seleccionado ninguna zona...",
      text: "Favor de seleccionar una zona válida!",
      timer: 3000,
    });
  } else if (abrev == null || abrev == "" || abrev.length < 2) {
    Swal.fire({
      icon: "info",
      title: "No ha ingresado una abreviatura al local...",
      text: "Favor de ingresar uno válido!",
      timer: 3000,
    });
  } else if (abrev.length < 3) {
    Swal.fire({
      icon: "info",
      title: "Longitud incorrecta para abreviatura...",
      text: "Favor de ingresar 3 digitos!",
      timer: 3000,
    });
  } else if (horaini == null || horaini == "") {
    Swal.fire({
      icon: "info",
      title: "No ha ingresado una hora de inicio...",
      text: "Favor de ingresar una hora válido!",
      timer: 3000,
    });
  } else if (horafin == null || horafin == "") {
    Swal.fire({
      icon: "info",
      title: "No ha ingresado una hora de fin...",
      text: "Favor de ingresar una hora válido!",
      timer: 3000,
    });
  } else if (tolerancia == null || tolerancia == "") {
    Swal.fire({
      icon: "info",
      title: "No ha ingresado una hora de tolerancia...",
      text: "Favor de ingresar una hora válido!",
      timer: 3000,
    });
  } else {
    Swal.fire({
      title: "Estas seguro de registrar los datos?",
      text: "Favor de confirmar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#61C250",
      cancelButtonColor: "#ea5455",
      confirmButtonText: "Si, actualizar!", //<i class="fa fa-smile-wink"></i>
      cancelButtonText: "No", //<i class="fa fa-frown"></i>
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "/recursoshumanos/local/mantenimiento_local",
          data: {
            id: id,
            local: local,
            nombre: nombre,
            idzona: idzona,
            estado: estado,
            abrev: abrev,
            horaini: horaini,
            horafin: horafin,
            tolerancia: tolerancia,
            tipoasistencia: tipoasistencia,
          },
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
              $("#modal-agregar").modal("hide");
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

// BONTON CANCELAR REGISTRO
$("#btn-cancelar-agregar").on("click", function () {
  $("#modal-agregar").modal("hide");
});

//-------------------- MODAL ACTUALIZAR --------------------//
// CARGAR MODAL ACTUALIZAR
$("#example1 tbody").on("click", "a.actualizar", function () {
  var cod = $(this).attr("id");

  $.ajax({
    type: "POST",
    url: "/recursoshumanos/local/get_local",
    data: { cod: cod },
    success: function (res) {
      $("#id-local-actualizar").val("");
      $("#id-local-actualizar").val(cod);
      $("#nombre-local-actualizar").val("");
      $("#nombre-local-actualizar").val(res.nombre);
      $("#hora-inicio-actualizar").val("");
      $("#hora-inicio-actualizar").val(res.horainicio);
      $("#hora-fin-actualizar").val("");
      $("#hora-fin-actualizar").val(res.horafin);
      $("#tolerancia-actualizar").val("");
      $("#tolerancia-actualizar").val(res.horatolerancia);
      $("#tipo-asistencia-actualizar").val("");
      $("#tipo-asistencia-actualizar").val(res.tipoasistencia);
      $("#id-zona-actualizar").val("");
      $("#id-zona-actualizar").val(res.zona);
      $("#estado-local-actualizar").val("");
      $("#estado-local-actualizar").val(res.estado);
      $("#abrev-local-actualizar").val("");
      $("#abrev-local-actualizar").val(res.abrev);
    },
  });

  $("#modal-editar").modal("show");
});

// BONTON GUARDAR CAMBIOS
$("#btn-actualizar").on("click", function () {
  var id = 2;
  var local = $("#id-local-actualizar").val();
  var nombre = $("#nombre-local-actualizar").val();
  var idzona = $("#id-zona-actualizar").val();
  var estado = $("#estado-local-actualizar").val();
  var abrev = $("#abrev-local-actualizar").val();
  var horaini = $("#hora-inicio-actualizar").val();
  var horafin = $("#hora-fin-actualizar").val();
  var tolerancia = $("#tolerancia-actualizar").val();
  var tipoasistencia = $("#tipo-asistencia-actualizar").val();

  if (nombre == null || nombre == "") {
    Swal.fire({
      icon: "info",
      title: "Nombre de local no puede estar vacío...",
      text: "Registre un nombre!",
      timer: 3000,
    });
  } else if (idzona == 0 || idzona == null) {
    Swal.fire({
      icon: "info",
      title: "No ha seleccionado ninguna zona...",
      text: "Favor de seleccionar una zona válida!",
      timer: 3000,
    });
  } else if (estado == 0 || estado == null) {
    Swal.fire({
      icon: "info",
      title: "No ha seleccionado ningun estado...",
      text: "Favor de seleccionar un estado válido!",
      timer: 3000,
    });
  } else if (abrev == null || abrev == "") {
    Swal.fire({
      icon: "info",
      title: "No ha ingresado una abreviatura al local...",
      text: "Favor de ingresar uno válido!",
      timer: 3000,
    });
  } else if (abrev.length < 3) {
    Swal.fire({
      icon: "info",
      title: "Longitud incorrecta para abreviatura...",
      text: "Favor de ingresar 3 digitos!",
      timer: 3000,
    });
  } else if (horaini == null || horaini == "") {
    Swal.fire({
      icon: "info",
      title: "No ha ingresado una hora de inicio...",
      text: "Favor de ingresar una hora válido!",
      timer: 3000,
    });
  } else if (horafin == null || horafin == "") {
    Swal.fire({
      icon: "info",
      title: "No ha ingresado una hora de fin...",
      text: "Favor de ingresar una hora válido!",
      timer: 3000,
    });
  } else if (tolerancia == null || tolerancia == "") {
    Swal.fire({
      icon: "info",
      title: "No ha ingresado una hora de tolerancia...",
      text: "Favor de ingresar una hora válido!",
      timer: 3000,
    });
  } else {
    Swal.fire({
      title: "Estas seguro de actualizar los datos?",
      text: "Favor de confirmar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#61C250",
      cancelButtonColor: "#ea5455",
      confirmButtonText: "Si, actualizar!", //<i class="fa fa-smile-wink"></i>
      cancelButtonText: "No", //<i class="fa fa-frown"></i>
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "/recursoshumanos/local/mantenimiento_local",
          data: {
            id: id,
            local: local,
            nombre: nombre,
            idzona: idzona,
            estado: estado,
            abrev: abrev,
            horaini: horaini,
            horafin: horafin,
            tolerancia: tolerancia,
            tipoasistencia: tipoasistencia,
          },
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
      }
    });
  }
});

// BONTON CANCELAR REGISTRO
$("#btn-cancelar-actualizar").on("click", function () {
  $("#modal-editar").modal("hide");
});