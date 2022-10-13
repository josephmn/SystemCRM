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

  // CARGAR DESHABILITADO LOS INPUT
  $("#dni,#nombre").attr("readonly", true);

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

function validar_clave(contrasenna) {
  if (contrasenna.length >= 8) {
    var mayuscula = false;
    var minuscula = false;
    var numero = false;
    var caracter_raro = false;

    for (var i = 0; i < contrasenna.length; i++) {
      if (contrasenna.charCodeAt(i) >= 65 && contrasenna.charCodeAt(i) <= 90) {
        mayuscula = true;
      } else if (
        contrasenna.charCodeAt(i) >= 97 &&
        contrasenna.charCodeAt(i) <= 122
      ) {
        minuscula = true;
      } else if (
        contrasenna.charCodeAt(i) >= 48 &&
        contrasenna.charCodeAt(i) <= 57
      ) {
        numero = true;
      } else {
        caracter_raro = true;
      }
    }
    if (
      (mayuscula == true && minuscula == true && numero == true) ||
      caracter_raro == true
    ) {
      return true;
    }
  }
  return false;
}

$("#btn_guardar").on("click", function () {
  var p1 = document.getElementById("passwd").value;
  var p2 = document.getElementById("passwd2").value;

  var espacios = false;
  var cont = 0;

  while (!espacios && cont < p1.length) {
    if (p1.charAt(cont) == " ") espacios = true;
    cont++;
  }

  if (p1.length < 8 || p1.length < 8) {
    // alert("La contraseña no puede contener espacios en blanco");
    $("#mensaje-guardar").html("");
    $("#mensaje-guardar").html(
      "<div class='alert alert-warning'>La contraseña no puede tener menos de 8 digitos</div>"
    );
    var id = setInterval(function () {
      $("#mensaje-guardar").html("");
      clearInterval(id);
    }, 3000);
    return false;
  }

  if (espacios) {
    // alert("La contraseña no puede contener espacios en blanco");
    $("#mensaje-guardar").html("");
    $("#mensaje-guardar").html(
      "<div class='alert alert-warning'>La contraseña no puede contener espacios en blanco</div>"
    );
    var id = setInterval(function () {
      $("#mensaje-guardar").html("");
      clearInterval(id);
    }, 3000);
    return false;
  }

  if (p1.length == 0 || p2.length == 0) {
    // alert("Los campos de la password no pueden quedar vacios");
    $("#mensaje-guardar").html("");
    $("#mensaje-guardar").html(
      "<div class='alert alert-warning'>Los campos del password no pueden quedar vacios</div>"
    );
    var id = setInterval(function () {
      $("#mensaje-guardar").html("");
      clearInterval(id);
    }, 3000);
    return false;
  }

  if (p1 != p2) {
    // alert("Las passwords deben de coincidir");
    $("#mensaje-guardar").html("");
    $("#mensaje-guardar").html(
      "<div class='alert alert-warning'>Los passwords deben de coincidir</div>"
    );
    var id = setInterval(function () {
      $("#mensaje-guardar").html("");
      clearInterval(id);
    }, 3000);
    return false;
  } else {
    if (validar_clave(p1) == true) {
      var newpasswd = $("#passwd").val();

      Swal.fire({
        title: "Estas seguro de actualizar su contraseña?",
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
            url: "/recursoshumanos/password/cambiar_password",
            data: { newpasswd: newpasswd },
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
    } else {
      $("#mensaje-guardar").html("");
      $("#mensaje-guardar").html(
        "<div class='alert alert-warning'>Contraseña no segura, ingrese mayúsculas y números</div>"
      );
      var id = setInterval(function () {
        $("#mensaje-guardar").html("");
        clearInterval(id);
      }, 3000);
    }
  }
});