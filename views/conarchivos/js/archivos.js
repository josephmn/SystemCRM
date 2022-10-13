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

  // inactivar input
  $("#id-archivo-actualizar").attr("readonly", true);

  // tabla
  creardatatable("#example1", 10, 0);

  var Toast = Swal.mixin({
    toast: true,
    position: "top-right",
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
  });

  // cargar modal para insertar nuevo archivo
  $("#btn-agregar").on("click", function () {
    $("#modal-agregar").modal("show");
  });

  $("#modal-agregar").on("shown.bs.modal", function () {
    $("#nombre-archivo").focus();
  });

  // agregar a tabla de documentos globales
  $("#btn-registrar").on("click", function () {
    let post = 1; // insert
    let id = 0; // no se usa para el insert
    let nombre = $("#nombre-archivo").val();
    let mime = $("#mime-archivo").val();
    let type = $("#type-archivo").val();
    let icono = $("#icono-archivo").val();
    let color = $("#color-archivo").val();

    if (nombre == null || nombre == "") {
      Toast.fire({
        icon: "error",
        title: "Favor de ingresar un nombre..!!",
      });
      $("#nombre-archivo").focus();
      return;
    }

    if (mime == null || mime == "") {
      Toast.fire({
        icon: "error",
        title: "Favor de ingresar un mime válido..!!",
      });
      $("#mime-archivo").focus();
      return;
    }

    if (type == null || type == "") {
      Toast.fire({
        icon: "error",
        title: "Favor de ingresar un type válido..!!",
      });
      $("#type-archivo").focus();
      return;
    }

    if (icono == null || icono == "") {
      Toast.fire({
        icon: "error",
        title: "Favor de ingresar un icono válido..!!",
      });
      $("#icono-archivo").focus();
      return;
    }

    if (color == null || color == 0) {
      Toast.fire({
        icon: "error",
        title: "Favor de seleccionar un color válido..!!",
      });
      $("#icono-archivo").focus();
      return;
    }

    Swal.fire({
      title: "Estas seguro de registrar el tipo de archivo?",
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
          url: "/recursoshumanos/conarchivos/mantenimiento_archivos",
          data: {
            post: post,
            id: id,
            nombre: nombre,
            mime: mime,
            type: type,
            icono: icono,
            color: color,
          },
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
              $("#modal-agregar").modal("hide");
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

  // boton cancelar agregar
  $("#btn-cancelar-agregar").on("click", function () {
    $("#modal-agregar").modal("hide");
  });

  // obtener datos para actualizar archivo global
  $("#example1 tbody").on("click", "a.editar-data", function () {
    let cod = $(this).attr("id");

    $.ajax({
      type: "POST",
      url: "/recursoshumanos/conarchivos/obtener_tipoarchivo",
      data: { cod: cod },
      success: function (res) {
        $("#id-archivo-actualizar").val("");
        $("#id-archivo-actualizar").val(cod);
        $("#nombre-archivo-actualizar").val("");
        $("#nombre-archivo-actualizar").val(res.v_archivo);
        $("#mime-archivo-actualizar").val("");
        $("#mime-archivo-actualizar").val(res.v_mime);
        $("#type-archivo-actualizar").val("");
        $("#type-archivo-actualizar").val(res.v_type);
        $("#icono-archivo-actualizar").val("");
        $("#icono-archivo-actualizar").val(res.v_icono);
        $("#color-archivo-actualizar").val("");
        $("#color-archivo-actualizar").val(res.v_color);
      },
    });

    $("#modal-editar").modal("show");
  });

  $("#modal-editar").on("shown.bs.modal", function () {
    $("#nombre-archivo-actualizar").focus();
  });

  // actualizar tabla de documentos globales
  $("#btn-actualizar").on("click", function () {
    let post = 2; // update
    let id = $("#id-archivo-actualizar").val();
    let nombre = $("#nombre-archivo-actualizar").val();
    let mime = $("#mime-archivo-actualizar").val();
    let type = $("#type-archivo-actualizar").val();
    let icono = $("#icono-archivo-actualizar").val();
    let color = $("#color-archivo-actualizar").val();

    if (nombre == null || nombre == "") {
      Toast.fire({
        icon: "error",
        title: "Favor de ingresar un nombre..!!",
      });
      $("#nombre-archivo-actualizar").focus();
      return;
    }

    if (mime == null || mime == "") {
      Toast.fire({
        icon: "error",
        title: "Favor de ingresar un mime válido..!!",
      });
      $("#mime-archivo-actualizar").focus();
      return;
    }

    if (type == null || type == "") {
      Toast.fire({
        icon: "error",
        title: "Favor de ingresar un type válido..!!",
      });
      $("#type-archivo-actualizar").focus();
      return;
    }

    if (icono == null || icono == "") {
      Toast.fire({
        icon: "error",
        title: "Favor de ingresar un icono válido..!!",
      });
      $("#icono-archivo-actualizar").focus();
      return;
    }

    Swal.fire({
      title: "Estas seguro de actualizar el tipo de archivo?",
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
          url: "/recursoshumanos/conarchivos/mantenimiento_archivos",
          data: {
            post: post,
            id: id,
            nombre: nombre,
            mime: mime,
            type: type,
            icono: icono,
            color: color,
          },
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
              $("#modal-editar").modal("hide");
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

  // boton cancelar actualizar
  $("#btn-cancelar-actualizar").on("click", function () {
    $("#modal-editar").modal("hide");
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
