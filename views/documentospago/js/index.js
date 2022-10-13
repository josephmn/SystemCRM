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
    order: [[0, "desc"]],
    lengthMenu: [
      [10, 25, 50, -1],
      [10, 25, 50, "Todos"],
    ],
  });

  $("#example2,#example3").DataTable({
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
      [0, "desc"],
      [1, "desc"],
    ],
    lengthMenu: [
      [10, 25, 50, -1],
      [10, 25, 50, "Todos"],
    ],
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

  $.ajax({
    type: "POST",
    url: "/recursoshumanos/registrovacaciones/toasts",
    data: { mensaje: (mensaje = 3) },
    success: function (res) {
      switch (res.id) {
        case 1:
          var id = setInterval(function () {
            $(document).Toasts("create", {
              class: res.class,
              title: res.title,
              subtitle: res.subtitle,
              body: res.body,
              autohide: true,
              delay: 6000,
            });
            clearInterval(id);
          }, 2000);
          break;
      }
    },
  });

  $.getJSON("https://api.ipify.org?format=json", function (data) {
    $("#ip").val(data.ip);
  });

  // REGISTRO DE LOG PARA BOLETAS
  $("#example1 tbody").on("click", "a.bol", function () {
    var boleta = $(this).attr("id");
    var ip = $("#ip").val();

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/documentospago/guardar_log",
      data: { boleta: boleta, ip: ip },
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
      },
    });
  });

  // REGISTRO DE LOG PARA UTILIDADES
  $("#example2 tbody").on("click", "a.uti", function () {
    var periodo = $(this).attr("id");
    var ip = $("#ip").val();

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/documentospago/guardar_log_uti",
      data: { periodo: periodo, ip: ip },
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
      },
    });
  });

  // REGISTRO DE LOG PARA CTS
  $("#example3 tbody").on("click", "a.cts", function () {
    var periodo = $(this).attr("id");
    var ip = $("#ip").val();

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/documentospago/guardar_log_cts",
      data: { periodo: periodo, ip: ip },
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
      },
    });
  });
});