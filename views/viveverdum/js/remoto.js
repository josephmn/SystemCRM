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

  $.ajax({
    type: "POST",
    url: "/recursoshumanos/registrovacaciones/alert",
    success: function (res) {
      switch (res.icase) {
        case 1:
          Swal.fire({
            icon: res.vicon,
            title: res.vtitle,
            text: res.vtext,
            timer: 8000,
          });
          break;
      }
    },
  });

  var Toast = Swal.mixin({
    toast: true,
    position: "top-right",
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
  });

  // input inhabilitados
  $("#documento,#nombre").attr("readonly", true);

  creardatatable("#example1", 10, 1);

  // seleccion de año
  $("#anhio").change(function () {
    let anhio = $("#anhio").val();

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/viveverdum/construir_tabla_remoto",
      data: { anhio: anhio },
      success: function (res) {
        $("#example1").dataTable().fnDestroy();
        $("#tbdet").html("");
        $("#tbdet").append(res.div);
        creardatatable("#example1", 10, 1);
      },
    });
  });

  // insertar horario semanal
  $("#btnagregar").on("click", function () {
    let post = 1; // insert
    let id = 0; // no se usa
    let semana = $("#semana").val();

    if (semana == 0 || semana == null) {
      Toast.fire({
        icon: "error",
        title: "No ha seleccionado una semana, favor de seleccionar uno..!!",
      });
      $("#semana").focus();
      return;
    }

    Swal.fire({
      title: "Estas seguro de registrar el trabajo remoto?",
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
          url: "/recursoshumanos/viveverdum/mantenimiento_remoto",
          data: { post: post, id: id, semana: semana },
          beforeSend: function () {
            // setting a timeout
            $("#btnagregar").attr("disabled", "disabled");
            $("#btnagregar").html(
              "<span class='spinner-border spinner-border-sm'></span> \
                                <span class='ml-25 align-middle'>GUARDANDO...</span>"
            );
          },
          success: function (res) {
            // console.log(res);
            // JSON.stringify(console.log(res));
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
              $("#btnagregar").attr("disabled", false);
              $("#btnagregar").html("REGISTRAR TRABAJO REMOTO");
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
              $("#btnagregar").attr("disabled", false);
              $("#btnagregar").html("REGISTRAR TRABAJO REMOTO");
            }
          },
        });
      }
    });
  });

  // eliminar registro semanal / si no esta aprobado
  $("#example1 tbody").on("click", "a.delete", function () {
    let post = 3; // delete
    let id = $(this).attr("id"); // no se usa
    let semana = 0;

    Swal.fire({
      title: "Estas seguro de eliminar la semana del trabajo remoto?",
      text: "Favor de confirmar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#61C250",
      cancelButtonColor: "#ea5455",
      confirmButtonText: "Si, eliminar!", //<i class="fa fa-smile-wink"></i>
      cancelButtonText: "No", //<i class="fa fa-frown"></i>
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "/recursoshumanos/viveverdum/mantenimiento_remoto",
          data: { post: post, id: id, semana: semana },
          success: function (res) {
            // console.log(res);
            // JSON.stringify(console.log(res));
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

  // marcación
  $("#btn-asistencia").on("click", function () {
    $.ajax({
      type: "POST",
      url: "/recursoshumanos/viveverdum/get_confimar_marcacion",
      success: function (res) {
        if (res.icase > 0) {
          mensaje_marcacion();
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
    lengthMenu: [[row], [row]],
    order: [[orden, "asc"]],
  });
  return tabla;
}

function mensaje_marcacion() {
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/viveverdum/get_mensaje_marcacion",
    success: function (res) {
      if (res.icase > 4) {
        Swal.fire({
          icon: res.vicon,
          title: res.vtitle,
          timer: res.itimer,
          timerProgressBar: res.vprogressbar,
          showCancelButton: false,
          showConfirmButton: false,
        });
      } else {
        marcar(res.vtitle);
      }
    },
  });
}

function marcar(mensaje) {
  Swal.fire({
    title: mensaje,
    text: "Favor de confirmar!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#61C250",
    cancelButtonColor: "#ea5455",
    confirmButtonText: "Si!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.value) {
      $.ajax({
        type: "POST",
        url: "/recursoshumanos/viveverdum/marcacion_remota",
        success: function (res) {
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
        },
      });
    }
  });
}