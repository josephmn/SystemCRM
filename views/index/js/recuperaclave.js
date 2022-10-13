$(function () {
  $("#enviarclave").on("click", function () {
    var correo = $("#correo").val();

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/index/enviar_correo",
      data: { correo: correo },
      beforeSend: function () {
        $("#correo").attr("readonly", true);
        $("#enviarclave").attr("disabled", "disabled");
        $("#enviarclave").html(
          "<span class='spinner-border spinner-border-sm'></span> \
                            <span class='ml-25 align-middle'>Enviando...</span>"
        );
      },
      success: function (res) {
        switch (res.dato) {
          case 0: // NO INGRESO CORREO
            $("#correo").attr("readonly", false);
            $("#enviarclave").prop("disabled", false);
            $("#enviarclave").html("Enviar correo");
            Swal.fire({
              icon: "info",
              title: "No ha ingresado su correo...",
              text: "Vuelva a intentarlo!",
              timer: 3000,
            });
            break;
          case 1: // CORREO NO ENCONTRADO EN LA BASE DE DATOS
            $("#correo").attr("readonly", false);
            $("#enviarclave").prop("disabled", false);
            $("#enviarclave").html("Enviar correo");
            Swal.fire({
              icon: "error",
              title: "Correo no encontrado en la base de datos...",
              text: "Vuelva a ingresar un correo válido!",
              timer: 5000,
            });
            break;
          case 2: // SE ENVIO CORREO CORRECTAMENTE
            Swal.fire({
              //   position: "top-end",
              icon: "success",
              title: "Correo enviado, favor de revisar su bandeja de entrada o bandeja de spam.",
              showConfirmButton: false,
              timer: 4000,
            });
            $("#correo").val("");
            setInterval(function () {
              location.href = "https://verdum.com/recursoshumanos/index/index";
            }, 4000);
            break;
          case 3:
            $("#correo").attr("readonly", false);
            $("#enviarclave").prop("disabled", false);
            $("#enviarclave").html("Enviar correo");
            Swal.fire({
              icon: "error",
              title: "Erro al enviar correo",
              text: "Favor de volver a intentarlo en unos minutos.!",
              timer: 5000,
            });
            break;
        }
      },
    });
  });
});
