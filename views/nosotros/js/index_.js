var msgBox = $("#message-box");
var wsUri = "ws://localhost:82/recursoshumanos/server.php";
websocket = new WebSocket(wsUri);

websocket.onopen = function (ev) {
  // connection is open
  msgBox.append(
    '<div class="system_msg" style="color:#bbbbbb">Welcome to my "Demo WebSocket Chat box"!</div>'
  ); //notify user
};
// Message received from server
websocket.onmessage = function (ev) {
  var response = JSON.parse(ev.data); //PHP sends Json data

  // console.log(response);

  var res_type = response.type;
  var res_class = response.class;
  var res_title = response.title;
  var res_subtitle = response.subtitle;
  var res_body = response.body;
  var res_autohide = response.autohide;
  var res_delay = response.delay;

  switch (res_type) {
    case "usermsg":
      $(document).Toasts("create", {
        class: res_class,
        title: res_title,
        subtitle: res_subtitle,
        body: res_body,
        autohide: res_autohide,
        delay: res_delay,
      });
      break;
    case "system":
      //msgBox.append('<div style="color:#bbbbbb">' + user_message + "</div>");
      break;
  }
};

websocket.onerror = function (ev) {
  msgBox.append(
    '<div class="system_error">Error Occurred - ' + ev.data + "</div>"
  );
};
websocket.onclose = function (ev) {
  msgBox.append('<div class="system_msg">Connection Closed</div>');
};

//Message send button
$("#send-message").click(function () {
  send_message();
});

//User hits enter key
$("#message").on("keydown", function (event) {
  if (event.which == 13) {
    send_message();
  }
});

//Send message
function send_message() {
  var message_input = $("#message"); //user message text
  var name_input = $("#name"); //user name

  //prepare json data
  var msg = {
    class: "bg-warning",
    title: "PAGO DE UTILIDADES 2021 - " + name_input.val(),
    subtitle: "12:00",
    body: message_input.val(),
    autohide: true,
    delay: 10000,
  };

  // console.log(JSON.stringify(msg));

  //convert and send data to server
  websocket.send(JSON.stringify(msg));
  message_input.val(""); //reset message input
}

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

  // window.open(
  //   "http://www.desarrolloweb.com",
  //   "ventana1",
  //   "width=600,height=400,scrollbars=NO,Top=140,Left=20"
  // );

  // window.open(
  //   "http://www.google.com",
  //   "ventana2",
  //   "width=600,height=400,scrollbars=NO,Top=240,Left=120"
  // );

  // // tabla example1
  // creardatatable("#example1", 10, 0, "desc"); //tabla.- index

  /* initialize the calendar
     -----------------------------------------------------------------*/
  //Date for the calendar events (dummy data)

  // var Calendar = FullCalendar.Calendar;
  // var calendarEl = document.getElementById("calendar");

  // var calendar = new Calendar(calendarEl, {
  //   locale: "es",
  //   plugins: ["bootstrap", "interaction", "dayGrid", "timeGrid"],
  //   header: {
  //     left: "prev,next today",
  //     center: "title",
  //     right: "dayGridMonth,timeGridWeek,timeGridDay",
  //   },
  //   themeSystem: "bootstrap",
  //   events: "/recursoshumanos/nosotros/calendario",
  // });
  // calendar.render();

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
  // cargar_notificaciones();
  // cargar_push();

  // temporizadorDeRetraso();
});

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
      if (nuevo != res.total_push) {
        $.ajax({
          type: "POST",
          url: "/recursoshumanos/nosotros/ultimo_push",
          async: false,
          success: function (res) {
            if (res.title == null || res.title == "") {
            } else {
              $(document).Toasts("create", {
                class: res.class,
                title: res.title,
                subtitle: res.subtitle,
                body: res.body,
                autohide: res.autohide,
                delay: res.delay,
              });
            }
          },
        });

        nuevo = res.total_push;
        // console.log(nuevo);
        // console.log(res.total_push);
        // console.log("entra");
      } else {
        // console.log(nuevo);
        // console.log(res.total_push);
        // console.log("no entra");
      }

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

// var contador = 6;
// var total_push = 0;

// function cargar_push() {
//   $.ajax({
//     // async: true,
//     type: "POST",
//     url: "/recursoshumanos/nosotros/notificacion_push",
//     data: { contador: contador, total_push: total_push },
//     success: function (res) {
//       console.log(res);
//       total_push = total_push + 1;

//       if (contador == 0) {
//         contador = 0;
//       } else {
//         contador = contador - 1;
//       }

//       // JSON.stringify(console.log(res.actual));
//       // JSON.stringify(console.log(res.timestamp));
//       // JSON.stringify(console.log(res.notificacion));

//       // if (res.contador > 6 || res.autohide == null) {
//       // } else {
//       //   $(document).Toasts("create", {
//       //     class: res.class,
//       //     title: res.title,
//       //     subtitle: res.subtitle,
//       //     body: res.body,
//       //     // autohide: res.autohide,
//       //     // delay: res.delay,
//       //   });
//       // }

//       setTimeout(cargar_push, 1000);
//       // // setInterval(cargar_push, 1000);

//       // if (length.res == null || length.res == "") {
//       // } else {
//       //   // JSON.stringify(console.log(res));
//       //   res.data.forEach((element) => {
//       //     $(document).Toasts("create", {
//       //       class: element.v_class,
//       //       title: element.v_title,
//       //       subtitle: element.v_subtitle,
//       //       body: element.v_body,
//       //       // autohide: res.autohide,
//       //       // delay: res.delay,
//       //     });
//       //   });
//       // }
//     },
//   });
// }

// let identificadorTiempoDeEspera;

// function temporizadorDeRetraso() {
//   identificadorTiempoDeEspera = setTimeout(funcionConRetraso, 3000);
// }

// function funcionConRetraso() {
//   alert("Han pasado 3 segundos.");
// }

$("#boletin").on("click", function () {
  $("#modal-boletin").modal("show");
});

// padres
function navegacionmenu(string) {
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/dashboard/cambiarsession",
    data: { string: string },
  });
  var dato = ""; //cerrado
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/dashboard/cambiaropen",
    data: { string: dato },
  });
}

// hijos
function clicksub(string) {
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/dashboard/cambiarsessionsub",
    data: { string: string },
  });
  var dato = "open"; //cerrado
  $.ajax({
    type: "POST",
    url: "/recursoshumanos/dashboard/cambiaropen",
    data: { string: dato },
  });
}
