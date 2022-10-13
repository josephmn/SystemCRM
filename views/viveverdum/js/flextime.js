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
    timerProgressBar: true
  });

  // input inhabilitados
  $("#documento,#nombre").attr("readonly", true);

  //Initialize Select2 Elements
  $(".select2").select2();

  //Initialize Select2 Elements
  $(".select2bs4").select2({
    theme: "bootstrap4",
  });

  creardatatable("#example1", 10, 1);

  var arr = [];
  // seleccion de semanas
  $(".select2").change(function () {
    arr = $(this).val();
    // console.log(arr);
  });

  // seleccion de meses
  $("#meses").change(function () {
    let mes = $("#meses").val();
    let anhio = $("#anhio").val();

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/viveverdum/construir_tabla",
      data: { anhio: anhio, mes: mes },
      success: function (res) {
        $("#example1").dataTable().fnDestroy();
        $("#tbdet").html("");
        $("#tbdet").append(res.div);
        creardatatable("#example1", 10, 1);
      },
    });
  });

  // seleccion de año
  $("#anhio").change(function () {
    let mes = $("#meses").val();
    let anhio = $("#anhio").val();

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/viveverdum/construir_tabla",
      data: { anhio: anhio, mes: mes },
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
    let semana = arr;
    let flex = $("#horario").val();

    if (flex == 0 || flex == null) {
      Toast.fire({
        icon: "error",
        title:
          "No ha seleccionado un horario, favor de seleccionar uno..!!",
      });
      $("#horario").focus();
      return;
    }

    if (semana.length == "" || semana.length == null) {
      Toast.fire({
        icon: "error",
        title:
          "No ha seleccionado ninguna semana, favor de seleccionar uno..!!",
      });
      $("#semana").focus();
      return;
    }

    Swal.fire({
      title: "Estas seguro de registrar el siguiente horario para la semana(as)?",
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
          url: "/recursoshumanos/viveverdum/mantenimiento_flextime",
          data: { post: post, id: id, semana: semana, flex: flex },
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
              $("#btnagregar").html("REGISTRAR FLEX TIME");
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
              $("#btnagregar").html("REGISTRAR FLEX TIME");
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
    let flex = 0;

    Swal.fire({
      title: "Estas seguro de eliminar el siguiente horario?",
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
          url: "/recursoshumanos/viveverdum/eliminar_flextime",
          data: { post: post, id: id, semana: semana, flex: flex },
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