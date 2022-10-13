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

  $("#icheck").prop("checked", false);

  //Date range picker
  $("#fecha").datetimepicker({
    format: "DD/MM/YYYY",
  });

  $("#icheck").on("change", function () {
    if ($("#icheck").is(":checked")) {
      $("#envio_de").val("");
      $("#nombre").val("");
    } else {
      $.ajax({
        type: "POST",
        url: "/recursoshumanos/canaldenuncia/datos_personal",
        success: function (res) {
          $("#envio_de").val(res.correo);
          $("#nombre").val(res.nombre);
        },
      });
    }
  });

  // desactivar inputs
  $("#envio_de,#nombre").attr("readonly", true);

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
    var formData = new FormData();

    var files = $("#archivo")[0].files[0];
    var envio_de = $("#envio_de").val();
    var nombre = $("#nombre").val();
    var anonimo = $("#icheck").val();
    var fecha = $("#fecha").val();
    var asunto = $("#asunto").val();
    var descripcion = $("#descripcion").val();

    if ($("#icheck").is(":checked")) {
      envio_de = "";
      nombre = "";
      anonimo = 1;
    } else {
      if (envio_de == "") {
        Toast.fire({
          icon: "error",
          title:
            "Su correo no ha sido configurado, diríjase a perfil e ingrese su correo en correo personal..!!",
        });
        return;
      }
      anonimo = 0;
    }

    if (asunto == null || asunto == 0) {
      Toast.fire({
        icon: "error",
        title: "No a ingresado un asunto, favor de ingresarlo..!!",
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

    formData.append("archivo", files);
    formData.append("envio_de", envio_de);
    formData.append("nombre", nombre);
    formData.append("anonimo", anonimo);
    formData.append("fecha", fecha);
    formData.append("asunto", asunto);
    formData.append("descripcion", descripcion);

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
          url: "/recursoshumanos/canaldenuncia/enviar_correo2",
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
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
            switch (res.correo) {
              case 1:
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
                break;
              case 2:
                Swal.fire({
                  icon: "error",
                  title: "Error no se pudo enviar el correo",
                  text: "Ocurrio un error en el envío, favor de volver a intentarlo en un momento..!!",
                  timer: 4000,
                  timerProgressBar: true,
                  showCancelButton: false,
                  showConfirmButton: false,
                });
                var id = setInterval(function () {
                  location.reload();
                  clearInterval(id);
                }, 4000);
                break;
              case 3:
                Swal.fire({
                  icon: "error",
                  title: "Error al adjuntar archivo al correo",
                  text: "Ocurrio un error al tratar de cargar el archivo al correo, favor de volver a intentarlo en un momento..!!",
                  timer: 5000,
                  timerProgressBar: true,
                  showCancelButton: false,
                  showConfirmButton: false,
                });
                var id = setInterval(function () {
                  location.reload();
                  clearInterval(id);
                }, 5000);
                break;
              case 4:
                Swal.fire({
                  icon: "error",
                  title: "Error en tamaño de archivo",
                  text: "Archivo es demasiado grande a lo permitido, debe ser menor a 15 mb. Verificar..!!",
                  timer: 5000,
                  timerProgressBar: true,
                  showCancelButton: false,
                  showConfirmButton: false,
                });
                var id = setInterval(function () {
                  location.reload();
                  clearInterval(id);
                }, 5000);
                break;
            }
          },
        });
      }
    });
  });
});

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
