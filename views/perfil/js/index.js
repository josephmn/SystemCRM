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

  //Initialize Select2 Elements
  $(".select2").select2();
  bsCustomFileInput.init();

  //cargar deshabilitado los botones
  $("#dni, #nombre, #edad").attr("readonly", true);

  //Date range picker
  $("#fnacimiento").datetimepicker({
    format: "DD/MM/YYYY",
  });

  //ALERT
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

  //TOAST 01
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/registrovacaciones/toasts",
    data: { mensaje: (mensaje = 1) },
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
              delay: 5000,
            });
            clearInterval(id);
          }, 2000);
          break;
      }
    },
  });

  //TOAST 02
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
              delay: 6000,
            });
            clearInterval(id);
          }, 3000);
          break;
      }
    },
  });

  //TOAST 03
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
              delay: 7000,
            });
            clearInterval(id);
          }, 4000);
          break;
      }
    },
  });

  // var fecha = new Date(); //Fecha actual
  // var mes = fecha.getMonth() + 1; //obteniendo mes
  // var dia = fecha.getDate(); //obteniendo dia
  // var ano = fecha.getFullYear(); //obteniendo año
  // if (dia < 10) dia = "0" + dia; //agrega cero si el menor de 10
  // if (mes < 10) mes = "0" + mes; //agrega cero si el menor de 10
  // document.getElementById("fnacimiento").value = dia + "/" + mes + "/" + ano;

  // $("#celular, #numero_emergencia").on("input cut copy paste", function (evt) {
  //   $(this).val(
  //     $(this)
  //       .val()
  //       .replace(/[^0-9]/g, "")
  //   );
  // });

  $("#btnsubir").on("click", function () {
    var formData = new FormData();
    var files = $("#archivo")[0].files[0];
    formData.append("archivo", files);

    Swal.fire({
      title: "Estas seguro de subir la foto?",
      text: "Favor de confirmar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#61C250",
      cancelButtonColor: "#ea5455",
      confirmButtonText: "Si, subir!", //<i class="fa fa-smile-wink"></i>
      cancelButtonText: "No", //<i class="fa fa-frown"></i>
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: "/recursoshumanos/perfil/subir_archivo",
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          success: function (res) {
            if (res.icase < 3) {
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

// PARA LISTAR LAS PROVINCIAS
$("#departamento").change(function () {
  var departamento = $("#departamento").val();
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/perfil/cargar_provincia",
    data: { departamento: departamento },
    success: function (res) {
      // alert(res.data);
      $("#provincia").html("");
      $("#provincia").append(res.data);
    },
  });
});

// PARA LISTAR LOS DISTRITOS
$("#provincia").change(function () {
  var provincia = $("#provincia").val();

  $.ajax({
    type: "POST",
    url: "/recursoshumanos/perfil/cargar_distritos",
    data: { provincia: provincia },
    success: function (res) {
      // alert(res.data);
      $("#distrito").html("");
      $("#distrito").append(res.data);
    },
  });
});

// function comprobar_email($email) {
//     return (filter_var($email, FILTER_VALIDATE_EMAIL)) ? 1 : 0;
// };

// BOTON GUARDAR
$("#btn_guardar").on("click", function () {
  var dni = $("#dni").val();
  var nombre = $("#nombre").val();
  var fnacimiento = $("#fnacimiento").val();
  var civil = $("#civil").val();
  var celular = $("#celular").val();
  var correo = $("#correo").val();
  var correoempresa = $("#correoempresa").val();
  var numero_emergencia = $("#numero_emergencia").val();
  var nombre_contacto = $("#nombre_contacto").val();
  var departamento = $("#departamento").val();
  var provincia = $("#provincia").val();
  var distrito = $("#distrito").val();
  var domicilio_actual = $("#domicilio_actual").val();
  var referencia_actual = $("#referencia_actual").val();

  // alert(dni);
  // alert(nombre);
  // alert(fnacimiento);
  // alert(civil);
  // alert(celular);
  // alert(correo);
  // alert(correoempresa);
  // alert(numero_emergencia);
  // alert(nombre_contacto);
  // alert(departamento);
  // alert(provincia);
  // alert(distrito);
  // alert(domicilio_actual);
  // alert(referencia_actual);

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
        url: "/recursoshumanos/perfil/registrar_perfil",
        data: {
          dni: dni,
          nombre: nombre,
          fnacimiento: fnacimiento,
          civil: civil,
          celular: celular,
          correo: correo,
          correoempresa: correoempresa,
          numero_emergencia: numero_emergencia,
          nombre_contacto: nombre_contacto,
          departamento: departamento,
          provincia: provincia,
          distrito: distrito,
          domicilio_actual: domicilio_actual,
          referencia_actual: referencia_actual,
        },
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
});