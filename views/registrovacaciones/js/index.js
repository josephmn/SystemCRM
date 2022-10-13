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

  // bsCustomFileInput.init();
  //cargar deshabilitado los botones
  $("#documento,#nombre").attr("readonly", true);
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
  document.getElementById("finicio").value = dia + "/" + mes + "/" + ano;
  document.getElementById("ffin").value = dia + "/" + mes + "/" + ano;

  $("#example1,#example2").DataTable({
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

var Toast = Swal.mixin({
  toast: true,
  position: "top-right",
  showConfirmButton: false,
  timer: 5000,
  timerProgressBar: true,
});

// GUARDAR DATO
$("#btnagregar").on("click", function () {
  var dni = $("#documento").val();
  var dateinicio = $("#finicio").val();
  var datefin = $("#ffin").val();
  var tipovac = $("#tipovacacion").val();

  if (dateinicio == "") {
    Toast.fire({
      icon: "error",
      title: "Fecha inicio no puede estar vacío..!!",
    });
    $("#finicio").focus();
    return;
  }

  // formato fecha inicio
  if (
    dateinicio.includes("d") == true ||
    dateinicio.includes("m") == true ||
    dateinicio.includes("a") == true
  ) {
    Toast.fire({
      icon: "error",
      title: "Fecha inicio no tiene el formato correcto..!!",
    });
    $("#finicio").focus();
    return;
  }

  if (datefin == "") {
    Toast.fire({
      icon: "error",
      title: "Fecha fin no puede estar vacío..!!",
    });
    $("#ffin").focus();
    return;
  }

  // formato fecha inicio
  if (
    datefin.includes("d") == true ||
    datefin.includes("m") == true ||
    datefin.includes("a") == true
  ) {
    Toast.fire({
      icon: "error",
      title: "Fecha fin no tiene el formato correcto..!!",
    });
    $("#ffin").focus();
    return;
  }

  Swal.fire({
    title: "Estas seguro de registrar sus vacaciones?",
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
        url: "/recursoshumanos/registrovacaciones/registrarvacacion",
        data: {
          dateinicio: dateinicio,
          datefin: datefin,
          dni: dni,
          tipovac: tipovac,
        },
        success: function (res) {
          if (res.icase == 1) {
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
  let codigo = $(this).attr("id"); // CODIGO ASISTENCIA
  let dni = $("#documento").val();

  Swal.fire({
    title: "Estas seguro de eliminar la programacion de vacaciones?",
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
        url: "/recursoshumanos/registrovacaciones/eliminar_registro",
        data: { codigo: codigo, dni: dni },
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