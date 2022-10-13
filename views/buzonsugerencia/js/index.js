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

  // desactivar inputs
  $("#envio_para,#envio_de,#nombre").attr("readonly", true);

  // TABLA
  creardatatable("#example1", 10, 0);

  var Toast = Swal.mixin({
    toast: true,
    position: "top-right",
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
  });

  // ENVIAR CORREO
  $("#btn-enviar").on("click", function () {
    let envio_para = $("#envio_para").val();
    let envio_de = $("#envio_de").val();
    let nombre = $("#nombre").val();
    let asunto = $("#asunto").val();
    let desc_asunto = ShowSelected("asunto");
    let descripcion = $("#descripcion").val();

    if (envio_para == "") {
      Toast.fire({
        icon: "error",
        title: "Correo de destinatario no configurado..!!",
      });
      return;
    }

    if (envio_de == "") {
      Toast.fire({
        icon: "error",
        title:
          "Su correo no ha sido configurado, diríjase a perfil e ingrese su correo en correo personal..!!",
      });
      return;
    }

    if (asunto == null || asunto == 0) {
      Toast.fire({
        icon: "error",
        title: "No ha seleccionado un asunto, favor de seleccionar uno..!!",
      });
      $("#asunto").focus();
      return;
    }

    if (descripcion == null || descripcion == 0) {
      Toast.fire({
        icon: "error",
        title: "No ha ingresado un comentario o detalle, favor de ingresar..!!",
      });
      $("#descripcion").focus();
      return;
    }

    Swal.fire({
      title: "Estas seguro de enviar el correo?",
      text: "Favor de confirmar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#61C250",
      cancelButtonColor: "#ea5455",
      confirmButtonText: "Si, enviar!", //<i class="fa fa-smile-wink"></i>
      cancelButtonText: "No", //<i class="fa fa-frown"></i>
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "/recursoshumanos/buzonsugerencia/enviar_correo",
          data: {
            envio_para: envio_para,
            envio_de: envio_de,
            nombre: nombre,
            asunto: asunto,
            desc_asunto: desc_asunto,
            descripcion: descripcion,
          },
          beforeSend: function () {
            $("#btn-enviar").attr("disabled", "disabled");
            $("#btn-enviar").html(
              "<span class='spinner-border spinner-border-sm'></span> \
                              <span class='ml-25 align-middle'>Enviando...</span>"
            );
            $("#btn-cancelar-agregar").attr("disabled", "disabled");
            $("#envio-agregar").attr("disabled", "disabled");
          },
          success: function (res) {
            if ((res.correo = 1)) {
              Swal.fire({
                icon: "success",
                title: "Correo enviado correctamente",
                text: "Muchas gracias por la información.",
                timer: 3000,
                timerProgressBar: true,
                showCancelButton: false,
                showConfirmButton: false,
              });
              var id = setInterval(function () {
                location.reload();
                clearInterval(id);
              }, 3000);
            } else {
              Swal.fire({
                icon: "error",
                title: "Error al enviar correo",
                text: "Correo no enviado, intentelo mas tarde..",
                timer: 3000,
                timerProgressBar: true,
                showCancelButton: false,
                showConfirmButton: false,
              });
              var id = setInterval(function () {
                location.reload();
                clearInterval(id);
              }, 3000);
            }
          },
        });
      }
    });
  });
});

// // CONTADOR DE CARACTERES PARA TEXTAREA
// function caracteres_descripcion() {
//   var total = 2000;
//   setTimeout(function () {
//     var valor = document.getElementById("descripcion");
//     var cantidad = valor.value.length;
//     document.getElementById("res").innerHTML =
//       "<p><b>" +
//       cantidad +
//       " caractere/s, te quedan " +
//       (total - cantidad) +
//       "</b></p>";
//   }, 10);
// }

function ShowSelected(dato) {
  /* Para obtener el texto */
  var combo = document.getElementById(dato);
  return (selected = combo.options[combo.selectedIndex].text);
}

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
    order: [[orden, "desc"]],
  });
  return tabla;
}
