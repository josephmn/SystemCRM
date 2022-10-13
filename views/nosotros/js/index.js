$(function () {
  // cerrar session
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

  // AVISO PARA CAMBIO DE CONTRASEÑA Y ACTUALIZACION DE DATOS
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/nosotros/mensaje",
    success: function (res) {
      switch (res.icase) {
        case 0: //no ingreso datos
          Swal.fire({
            icon: res.vicon,
            title: res.vtitle,
            html:
              "Estimado <b>" +
              res.vnombre +
              "</b>, hemos detectado que no ha registrado sus datos, como <b>correo personal (este para recuperar la clave)</b>, celular, \
            número de emergencia y otros. Favor de dirigirse a perfil y registre los datos. <b>Gracias RRHH</b>.",
            // text: res.vtext,
          });
          break;

        case 1: //no ingreso correo de recuperacion
          Swal.fire({
            icon: res.vicon,
            title: res.vtitle,
            html:
              "Estimado <b>" +
              res.vnombre +
              "</b>, no ha ingresado su <b>correo personal (este se usara para recuperar la clave, si en un futuro se olvida)</b>. \
              Favor de dirigirse a perfil y registre su correo. <b>Gracias RRHH</b>.",
            // text: res.vtext,
          });
          break;

        case 3: //imagen de cumpleaños
          contruir_imagen(1);
          $("#modal-cumple").modal("show");
          break;
      }
    },
  });

  $.ajax({
    type: "POST",
    url: "/recursoshumanos/nosotros/cambiarclave",
    success: function (res) {
      switch (res.icase) {
        case 1: //no ingreso correo de recuperacion
          Swal.fire({
            icon: res.vicon,
            title: res.vtitle,
            html:
              "Estimado <b>" +
              res.vnombre +
              "</b>, hemos detectado que sigues usando la misma clave que se te brindo al inicio para el ingreso al portal; para proteger tu información \
              solicitamos por favor cambiar la clave para mayor seguridad. <b>Gracias RRHH</b>.",
            // text: res.vtext,
          });
          break;
      }
    },
  });

  // notificacion push
  cargar_notificaciones();
});

// CONSTRUCTOR IMAGEN PARA CUMPLEAÑOS
function contruir_imagen(id) {
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/nosotros/obtenerimg_cumple",
    data: { id: id },
    success: function (res) {
      $("#draw-img").html("");
      $("#draw-img").append(res.div);
      let id = setInterval(function () {
        clearInterval(id);
        destroy_imagen(res.imagen);
      }, 2000);
    },
  });
}

function destroy_imagen($nombre) {
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/nosotros/deshacer_imagen",
    data: { nombre: $nombre },
    // success: function (res) {
    //   console.log(res);
    // },
  });
}

// para cargar las primeras notificaciones
var numero = 1;
var tope = 6;
var contador = 0;
var total_push = 0;

var nuevo = 0;
$.ajax({
  type: "POST",
  url: "/recursoshumanos/nosotros/numero_push",
  async: false,
  success: function (res) {
    nuevo = res;
    total_push = res;
  },
});

function cargar_notificaciones() {
  $.ajax({
    async: true,
    type: "POST",
    url: "/recursoshumanos/nosotros/notificacion_push",
    data: { tope: tope },
    success: function (res) {
      tope = tope - 1;
      if (res.title == null || res.title == "") {
        contador++;
        // console.log(contador);
        setTimeout(cargar_notificaciones, 1000);
      } else {
        $(document).Toasts("create", {
          class: res.class,
          title: res.title,
          subtitle: res.subtitle,
          body: res.body,
          autohide: res.autohide,
          delay: res.delay,
        });
        contador++;
        // console.log(contador);
        setTimeout(cargar_notificaciones, 1000);
      }
    },
  });
}
