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

  //cargar deshabilitado los botones
  $("#dni, #nombre").attr("readonly", true);

  //Date range picker
  $("#finicio, #ffin").datetimepicker({
    format: "DD/MM/YYYY",
  });

  var fecha = new Date(); //Fecha actual
  var mes = fecha.getMonth() + 1; //obteniendo mes
  var dia = fecha.getDate(); //obteniendo dia
  var ano = fecha.getFullYear(); //obteniendo año
  if (dia < 10) dia = "0" + dia; //agrega cero si el menor de 10
  if (mes < 10) mes = "0" + mes; //agrega cero si el menor de 10
  document.getElementById("finiciodate").value = dia + "/" + mes + "/" + ano;
  document.getElementById("ffindate").value = dia + "/" + mes + "/" + ano;

  creardatatable("#example1", -1, 1);
  creardatatable("#example2", -1, 1);

  ////////////////  APROBAR VACACIONES ///////////////////

  // CARGAR MODAL APROBAR VACACIONES PROGRAMADOR / EXCEPCIONAL
  $("#example1 tbody").on("click", "a.aprobar", function () {
    var codigo = $(this).attr("id"); // CODIGO ASISTENCIA
    var nombre = $(this).attr("vnombre"); // NOMBRE USUARIO
    var dni = $("#dni").val(); // DNI DEL JEFE QUE APRUEBA
    var indice = 1; // APROBAR

    Swal.fire({
      title:
        "Estas seguro de aprobar la(s) vacacion(es) programada(s) de " +
        nombre +
        "?",
      text: "Favor de confirmar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#61C250",
      cancelButtonColor: "#ea5455",
      confirmButtonText: "Si, aprobar!", //<i class="fa fa-smile-wink"></i>
      cancelButtonText: "No", //<i class="fa fa-frown"></i>
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "/recursoshumanos/controlvacaciones/gestion_vacaciones",
          data: { codigo: codigo, dni: dni, indice: indice },
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
  });

  // CARGAR MODAL APROBAR VACACIONES POR CUMPLEAÑOS
  $("#example2 tbody").on("click", "a.cumple", function () {
    let post = 2; // update
    var id = $(this).attr("id"); // CODIGO CUMPLEAÑOS SOLICITUD
    var nombre = $(this).attr("vnombre"); // NOMBRE USUARIO
    var fecha = "";

    Swal.fire({
      title:
        "Estas seguro de aprobar la vacación programada de " +
        nombre +
        "?",
      text: "Favor de confirmar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#61C250",
      cancelButtonColor: "#ea5455",
      confirmButtonText: "Si, aprobar!",
      cancelButtonText: "No",
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "/recursoshumanos/viveverdum/mantenimiento_vacacion_cumpleanios",
          data: { post: post, id: id, fecha: fecha },
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
  });

  // ////////////////  DESAPROBAR VACACIONES ///////////////////

  // // CARGAR MODAL DESAPROBAR VACACIONES
  // $("#example2 tbody").on("click", "a.desaprobar", function () {
  //   var cod = $(this).attr("id");

  //   $("#codvacaciones_desaprobar").html("");
  //   $("#codvacaciones_desaprobar").html(cod);
  //   $("#modal-desaprobar").modal("show");
  // });

  // // BOTON SI DESAPROBAR
  // $("#btn_si_desaprobar").on("click", function () {
  //   var codigo = $("#codvacaciones_desaprobar").text(); // CODIGO ASISTENCIA
  //   var dni = $("#dni").val(); // DNI DEL JEFE QUE DESAPRUEBA
  //   var indice = 2; // DESAPROBAR

  //   $.ajax({
  //     type: "POST",
  //     url: "/recursoshumanos/controlvacaciones/gestion_vacaciones",
  //     data: { codigo: codigo, dni: dni, indice: indice },
  //     success: function (res) {
  //       // alert(res.data);
  //       switch (res.data) {
  //         case 0:
  //           $("#mensaje-eliminar").html(
  //             "<div class='alert alert-danger'>Error al desaprobado</div>"
  //           );
  //           setInterval(function () {
  //             $("#mensaje-eliminar").html("");
  //             $("#modal-eliminar").modal("hide");
  //           }, 3000);
  //           break;
  //         case 1:
  //           $("#mensaje-eliminar").html(
  //             "<div class='alert alert-success'>Desaprobado correctamente</div>"
  //           );
  //           setInterval(function () {
  //             $("#mensaje-eliminar").html("");
  //             $("#modal-eliminar").modal("hide");
  //           }, 3000);
  //           location.reload();
  //           break;
  //       }
  //     },
  //   });
  // });

  // // BOTON NO DESAPROBAR
  // $("#btn_no_desaprobar").on("click", function () {
  //   $("#modal-desaprobar").modal("hide");
  // });

  // padres
});

// crear tabla
function creardatatable(nombretabla, row, orden) {
  var tabla = $(nombretabla).dataTable({
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
    lengthMenu: [[row], ["All"]],
    order: [[orden, "asc"]],
  });
  return tabla;
}