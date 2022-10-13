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

  var Toast = Swal.mixin({
    toast: true,
    position: "top-right",
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
  });

  // ALERT
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

  // TOAST 01
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/registrovacaciones/toasts",
    data: { mensaje: (mensaje = 2) },
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
              delay: 4000,
            });
            clearInterval(id);
          }, 1000);
          break;
      }
    },
  });

  //cargar deshabilitado los botones
  $("#documento,#nombre").attr("readonly", true);

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
  });

  // GUARDAR DATO
  $("#btnagregar").on("click", function () {
    let post = 1; // insert
    let id = 0;
    let fecha = $("#fecha").val();

    // formato fecha
    if (
      fecha.includes("d") == true ||
      fecha.includes("m") == true ||
      fecha.includes("a") == true
    ) {
      Toast.fire({
        icon: "error",
        title: "Fecha no tiene el formato correcto..!!",
      });
      $("#finicio-imagen-convenio").focus();
      return;
    }
    Swal.fire({
      title: "Estas seguro de registrar su dia de vacacion por cumpleaños?",
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

  // CARGAR MODAL ELIMINAR VACACIONES
  $("#example1 tbody").on("click", "a.delete", function () {
    let post = 3; // delete
    let id = $(this).attr("id");
    let fecha = "";

    Swal.fire({
      title: "Estas seguro de registrar su dia de vacacion por cumpleaños?",
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
});

$.ajax({
  type: "POST",
  url: "/recursoshumanos/viveverdum/get_cumpleanios",
  success: function (res) {
    let anhio = res.substr(6, 4);
    let mes = res.substr(3, 2);
    let dia = res.substr(0, 2);
    let newDate = anhio + "-" + mes + "-" + dia;

    $("#fecha").flatpickr({
      enableTime: false,
      // dateFormat: "Y-m-d",
      dateFormat: "d/m/Y",
      defaultDate: res,
      disable: [
        {
          from: new Date("1900-01-01"),
          to: new Date(newDate).fp_incr(-3),
        },
        {
          from: new Date(newDate).fp_incr(+5),
          to: new Date("2050-01-01"),
        },
      ],
    });
  },
});