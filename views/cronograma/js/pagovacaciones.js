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

  //Date range picker
  $("#fcorte").datetimepicker({
    format: "DD/MM/YYYY",
  });

  // //Date and time picker
  // $("#fcorte").datetimepicker({ icons: { time: "far fa-clock" } });

  $("#vanhio,#vmes,#fcorte,#vnommes").attr("readonly", true);

  $row = [5, 10, 15, 20, -1];
  $rowdes = ["5", "10", "15", "20", "Todos"];
  creardatatable("#example1", $row, $rowdes, 2, "asc");

  $row1 = [-1];
  $rowdes1 = ["Todos"];
  creardatatable("#example2", $row1, $rowdes1, 9, "asc");

  $row2 = [-1];
  $rowdes2 = ["Todos"];
  creardatatable("#example3", $row2, $rowdes2, 9, "asc");

  // aprobar vacaciones a tiempo
  $("#btnatiempo").on("click", function () {
    let post = 1; // vacaciones en tiempo
    let mes = $("#vmes").val();
    let anhio = $("#vanhio").val();
    let nommes = $("#vnommes").val();
    let fecha = $("#fcorte").val();
    let ivac = "";

    var table = $("#example1").DataTable();

    if (!table.data().any()) {
      Swal.fire({
        icon: "info",
        title: "TABLA VACÍA",
        text: "No se puede procesar datos, verificar o recargar la página nuevamente..!!",
        timer: 4000,
        timerProgressBar: true,
        showCancelButton: false,
        showConfirmButton: false,
      });
    } else {
      Swal.fire({
        title: "PAGO VACACIONES " + nommes + " " + anhio,
        html:
          "Estas seguro de procesar las vacaciones del mes de <b>" +
          nommes +
          "</b> con la siguiente fecha de corte <b>" +
          fecha +
          "</b> ?",
        text: "Esta acción no se podra deshacer, favor de confirmar!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#61C250",
        cancelButtonColor: "#ea5455",
        confirmButtonText: "&#128077 Si, procesar!", //<i class="fa-solid fa-thumbs-up"></i>
        cancelButtonText: "&#128078 No", //<i class="fa-solid fa-thumbs-down"></i>
        // showClass: {
        //   popup: "animate__animated animate__bounceInDown",
        // },
        // hideClass: {
        //   popup: "animate__animated animate__bounceOutDown",
        // },
      }).then((result) => {
        if (result.value) {
          $.ajax({
            type: "POST",
            url: "/recursoshumanos/cronograma/mantenimiento_pagovacaciones",
            data: {
              post: post,
              mes: mes,
              anhio: anhio,
              fecha: fecha,
              ivac: ivac,
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

  // aprobar vacaciones a personal fuera de fecha de corte
  $("#example2 tbody").on("click", "a.aprobar", function () {
    let post = 2; // vacaciones fuera de fecha de corte
    let mes = $("#vmes").val();
    let anhio = $("#vanhio").val();
    let nommes = $("#vnommes").val();
    let fecha = $("#fcorte").val();
    let ivac = $(this).attr("id");
    let nombre = $(this).attr("nombre");

    Swal.fire({
      title: "PAGO VACACIONES " + nommes + " " + anhio,
      html:
        "Estas seguro de procesar las vacaciones de <b>" +
        nombre +
        "</b>, recordar que no se encuentra dentro de la fecha de corte <b>" +
        fecha +
        "</b> ?",
      text: "Esta acción no se podra deshacer, favor de confirmar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#61C250",
      cancelButtonColor: "#ea5455",
      confirmButtonText: "&#128077 Si, procesar!", //<i class="fa-solid fa-thumbs-up"></i>
      cancelButtonText: "&#128078 No", //<i class="fa-solid fa-thumbs-down"></i>
      // showClass: {
      //   popup: "animate__animated animate__bounceInDown",
      // },
      // hideClass: {
      //   popup: "animate__animated animate__bounceOutDown",
      // },
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "/recursoshumanos/cronograma/mantenimiento_pagovacaciones",
          data: {
            post: post,
            mes: mes,
            anhio: anhio,
            fecha: fecha,
            ivac: ivac,
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

  // aprobar vacaciones a personal fuera de fecha de corte
  $("#example3 tbody").on("click", "a.eliminar", function () {
    let post = 3; // vacaciones fuera de fecha de corte
    let mes = $("#vmes").val();
    let anhio = $("#vanhio").val();
    let nommes = $("#vnommes").val();
    let fecha = $("#fcorte").val();
    let ivac = $(this).attr("id");
    let nombre = $(this).attr("nombre");

    Swal.fire({
      title: "PAGO VACACIONES " + nommes + " " + anhio,
      html:
        "Estas seguro de eliminar a <b>" +
        nombre +
        "</b>, del grupo de pago de vacaciones del mes de <b>" +
        nommes +
        "</b> ?",
      text: "Esta acción no se podra deshacer, favor de confirmar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#61C250",
      cancelButtonColor: "#ea5455",
      confirmButtonText: "&#128077 Si, procesar!", //<i class="fa-solid fa-thumbs-up"></i>
      cancelButtonText: "&#128078 No", //<i class="fa-solid fa-thumbs-down"></i>
      // showClass: {
      //   popup: "animate__animated animate__bounceInDown",
      // },
      // hideClass: {
      //   popup: "animate__animated animate__bounceOutDown",
      // },
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "/recursoshumanos/cronograma/mantenimiento_pagovacaciones",
          data: {
            post: post,
            mes: mes,
            anhio: anhio,
            fecha: fecha,
            ivac: ivac,
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

  // aprobar vacaciones a tiempo
  $("#btnenvio").on("click", function () {
    let post = 4; // vacaciones en tiempo
    let mes = $("#vmes").val();
    let anhio = $("#vanhio").val();
    let nommes = $("#vnommes").val();
    let fecha = $("#fcorte").val();
    let ivac = "";

    var table = $("#example3").DataTable();

    if (!table.data().any()) {
      Swal.fire({
        icon: "info",
        title: "TABLA VACÍA",
        text: "No se puede enviar datos, verificar o recargar la página nuevamente..!!",
        timer: 4000,
        timerProgressBar: true,
        showCancelButton: false,
        showConfirmButton: false,
      });
    } else {
      Swal.fire({
        title: "PAGO VACACIONES " + nommes + " " + anhio,
        html:
          "Estas seguro de procesar el envío de pago de vacaciones de <b>" +
          nommes +
          "</b> ?",
        text: "Esta acción no se podra deshacer, favor de confirmar si esta seguro..!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#61C250",
        cancelButtonColor: "#ea5455",
        confirmButtonText: "&#128077 Si, enviar!", //<i class="fa-solid fa-thumbs-up"></i>
        cancelButtonText: "&#128078 No", //<i class="fa-solid fa-thumbs-down"></i>
        // showClass: {
        //   popup: "animate__animated animate__bounceInDown",
        // },
        // hideClass: {
        //   popup: "animate__animated animate__bounceOutDown",
        // },
      }).then((result) => {
        if (result.value) {
          $.ajax({
            type: "POST",
            url: "/recursoshumanos/cronograma/mantenimiento_pagovacaciones",
            data: {
              post: post,
              mes: mes,
              anhio: anhio,
              fecha: fecha,
              ivac: ivac,
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
});

// crear tabla
function creardatatable(nombretabla, row = [], rowdes = [], orden, nomorden) {
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
        rows: "filas",
      },
    },
    lengthMenu: [row, rowdes],
    order: [[orden, nomorden]],
  });
  return tabla;
}
