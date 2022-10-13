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

  //cargar deshabilitado los botones
  $("#dni, #nombre").attr("readonly", true);
  bsCustomFileInput.init();

  // tabla
  creardatatable("#example1", 25, 0);

  var Toast = Swal.mixin({
    toast: true,
    position: "top-right",
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
  });

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
              delay: 6000,
            });
            clearInterval(id);
          }, 2000);
          break;
      }
    },
  });

  $("#combodocumento").on("change", function () {
    let id = $("#combodocumento").val();
    $.ajax({
      url: "/recursoshumanos/documentos/ObtenerTipoArchivo",
      type: "POST",
      data: { id: id },
      success: function (res) {
        $("#typearchivo").html("");
        $("#typearchivo").append("BUSCAR ARCHIVO (" + res + ")");
        $("#archivo").attr("accept", res);
      },
    });
  });

  //*********************************************************************//

  // CARGAR ARCHIVO
  $("#btnsubir").on("click", function () {
    var formData = new FormData();
    var files = $("#archivo")[0].files[0];
    var combodocumento = $("#combodocumento").val();

    if (combodocumento == 0 || combodocumento == null) {
      Toast.fire({
        icon: "error",
        title: "Favor de seleccionar un tipo de documento a cargar..!!",
      });
      $("#combodocumento").focus();
      return;
    }

    formData.append("archivo", files);
    formData.append("combodocumento", combodocumento);

    Swal.fire({
      title: "Estas seguro de subir el archivo?",
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
          url: "/recursoshumanos/documentos/subir_archivo",
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          success: function (res) {
            if (res.icase < 5) {
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
              var $el = $("#archivo");
              $el.wrap("<form>").closest("form").get(0).reset();
              $el.unwrap();
            }
          },
        });
      }
    });
  });

  //*********************************************************************//

  // ELIMINAR DOCUMENTO
  $("#example1 tbody").on("click", "a.eliminar", function () {
    let codigo = $(this).attr("id"); // CODIGO ELIMINAR
    let nombre = $(this).attr("name");

    Swal.fire({
      title:
        "Estas seguro de eliminar el documento " +
        codigo +
        " - " +
        nombre +
        "?",
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
          url: "/recursoshumanos/documentos/eliminar_archivo",
          data: { codigo: codigo },
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
    order: [[orden, "asc"]],
  });
  return tabla;
}
