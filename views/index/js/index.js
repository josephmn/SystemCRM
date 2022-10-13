$(function () {
  $("#btn_login").on("click", function () {
    var usuario = $("#usuario").val();
    var password = $("#password").val();
    $.ajax({
      type: "POST",
      url: "/recursoshumanos/index/login",
      data: { usuario: usuario, password: password },
      beforeSend: function () {
        $("#btn_login").attr("disabled", "disabled");
        $("#btn_login").html(
          "<span class='spinner-border spinner-border-sm'></span> \
                                    <span class='ml-25 align-middle'>Ingresando...</span>"
        );
      },
      success: function (res) {
        switch (res.estado) {
          case 0:
            window.location = res.url;
            break;
          case 1:
            $("#msj").html("");
            $("#msj").html(
              "<br><div class='alert alert-warning'>Usuario Inactivo</div>"
            );
            setTimeout(function () {
              $("#msj").html("");
            }, 3000);
            break;
          case 2:
            $("#msj").html("");
            $("#msj").html(
              "<br><div class='alert alert-warning'>Usuario o clave incorrecta</div>"
            );
            setTimeout(function () {
              $("#msj").html("");
            }, 3000);
            $("#btn_login").attr("disabled", false);
            $("#btn_login").html("Ingresar");
            break;
        }
      },
    });
  });
});

function pulsar(e) {
  if (e.keyCode === 13 && !e.shiftKey) {
    $("#btn_login").click();
  }
}
